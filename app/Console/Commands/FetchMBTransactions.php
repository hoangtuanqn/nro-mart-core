<?php

namespace App\Console\Commands;

use App\Models\BankDeposit;
use App\Models\BankAccount;
use App\Models\User;
use App\Models\MoneyTransaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FetchMBTransactions extends Command
{
    protected $signature = 'fetch:mb-transactions';
    protected $description = 'Fetch new transactions from bank accounts via SePay API';

    public function handle()
    {
        $this->info('===== Bắt đầu quét giao dịch ngân hàng =====');
        // Lấy tất cả tài khoản ngân hàng có tự động cộng tiền
        $bankAccounts = BankAccount::where('auto_confirm', true)
            ->where('is_active', true)
            ->whereNotNull('access_token')
            ->get();

        if ($bankAccounts->isEmpty()) {
            $this->warn('Không có tài khoản ngân hàng nào được cấu hình tự động cộng tiền.');
            return;
        }

        $this->info('Tìm thấy ' . $bankAccounts->count() . ' tài khoản ngân hàng cần quét.');
        $apiUrl = 'https://my.sepay.vn/userapi/transactions/list';
        $totalProcessed = 0;

        foreach ($bankAccounts as $bankAccount) {
            $this->info('------------------------------');
            $this->info('Đang xử lý tài khoản: ' . $bankAccount->bank_name . ' - ' . $bankAccount->account_number);

            // Sử dụng access_token riêng của mỗi tài khoản
            if (empty($bankAccount->access_token)) {
                $this->error('Tài khoản ' . $bankAccount->bank_name . ' chưa được cấu hình Access Token.');
                continue;
            }

            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $bankAccount->access_token,
                    'Content-Type' => 'application/json',
                ])->get($apiUrl, [
                            'account_number' => $bankAccount->account_number,
                            'limit' => 10,
                        ]);

                if ($response->successful()) {
                    $transactions = $response->json();
                    $processedCount = 0;
                    $skippedCount = 0;

                    $this->info('Tìm thấy ' . count($transactions['transactions'] ?? []) . ' giao dịch.');
                    // print_r($transactions['transactions']); debug
                    foreach ($transactions['transactions'] ?? [] as $transaction) {
                        // Sử dụng prefix từ cấu hình tài khoản ngân hàng
                        $prefix = $bankAccount->prefix ?? 'naptien';
                        $id = get_id_bank($prefix, $transaction['transaction_content']);

                        if ($transaction['amount_in'] == 0) {
                            $skippedCount++;
                            continue;
                        }

                        if ($id == 0) {
                            $this->line('Bỏ qua giao dịch không tìm thấy mã người dùng: ' . $transaction['transaction_content']);
                            $skippedCount++;
                            continue;
                        }

                        if (BankDeposit::where('transaction_id', $transaction['reference_number'])->exists() || !User::find($id)) {
                            $this->line('Bỏ qua giao dịch đã xử lý: ' . $transaction['reference_number']);
                            $skippedCount++;
                            continue;
                        }

                        try {
                            DB::beginTransaction();

                            // Kiểm tra và lưu thông tin giao dịch ngân hàng
                            $bankDeposit = BankDeposit::updateOrCreate(
                                ['transaction_id' => $transaction['reference_number']], // Kiểm tra nếu đã có giao dịch này chưa
                                [
                                    'user_id' => $id,
                                    'account_number' => $transaction['account_number'],
                                    'amount' => $transaction['amount_in'],
                                    'content' => $transaction['transaction_content'],
                                    'bank' => $bankAccount->bank_name
                                ]
                            );

                            // Chỉ cập nhật số dư và lưu lịch sử nếu bản ghi mới được tạo
                            if ($bankDeposit->wasRecentlyCreated) {
                                // Tìm user và cập nhật số dư
                                $user = User::find($id);

                                if (!$user) {
                                    $this->error("Không tìm thấy người dùng với ID: $id");
                                    DB::rollBack();
                                    continue;
                                }

                                $balanceBefore = $user->balance;
                                $amount = $transaction['amount_in'];

                                // Cập nhật số dư và tổng tiền đã nạp
                                $user->balance += $amount;
                                $user->total_deposited += $amount;
                                $user->save();

                                // Lưu lịch sử giao dịch
                                MoneyTransaction::create([
                                    'user_id' => $id,
                                    'type' => 'deposit',
                                    'amount' => $amount,
                                    'balance_before' => $balanceBefore,
                                    'balance_after' => $user->balance,
                                    'description' => "Nạp tiền qua {$bankAccount->bank_name} - Mã giao dịch: {$transaction['reference_number']}",
                                    'reference_id' => $transaction['reference_number']
                                ]);

                                $this->info("► Cộng thành công " . number_format($amount) . "đ cho người dùng #$id");
                                $processedCount++;
                                $totalProcessed++;
                            }

                            DB::commit();

                        } catch (\Exception $e) {
                            DB::rollBack();
                            $this->error('Lỗi xử lý giao dịch: ' . $e->getMessage());
                            continue;
                        }
                    }

                    $this->info("Kết quả: Đã xử lý {$processedCount} giao dịch, bỏ qua {$skippedCount} giao dịch.");
                } else {
                    $this->error('Không thể lấy dữ liệu giao dịch: ' . $response->status() . ' - ' . $response->body());
                }
            } catch (\Exception $e) {
                $this->error('Lỗi kết nối API: ' . $e->getMessage());
            }
        }

        $this->info('===== Kết thúc quét giao dịch ngân hàng =====');
        $this->info("Tổng số giao dịch đã xử lý: $totalProcessed");
    }
}
