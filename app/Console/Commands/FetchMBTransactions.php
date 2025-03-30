<?php

namespace App\Console\Commands;

use App\Models\BankDeposit;
use App\Models\User;
use App\Models\MoneyTransaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FetchMBTransactions extends Command
{
    protected $signature = 'fetch:mb-transactions';
    protected $description = 'Fetch new transactions from MB Bank via SePay API';

    public function handle()
    {
        $apiUrl = 'https://my.sepay.vn/userapi/transactions/list';
        $apiToken = '7UUMGIYH8PWXAW5EJMZCBNTDAJV99WBIOWAC04X6Q8QSUH3R2KJX1LZSCMVEKQBT'; // Thay bằng API Token của bạn
        $accountNumber = '259876543210'; // Số tài khoản MB Bank
        // $this->info('Đang gọi API SePay...');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Content-Type' => 'application/json',
        ])->get($apiUrl, [
                    'account_number' => $accountNumber,
                    'limit' => 10,
                ]);

        if ($response->successful()) {
            $transactions = $response->json();

            foreach ($transactions['transactions'] ?? [] as $transaction) {
                $id = get_id_bank('naptien', $transaction['transaction_content']);
                // $this->info($id);
                if ($transaction['amount_in'] == 0 || $id == 0 || BankDeposit::find($transaction['reference_number']))
                    continue;
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
                            'bank' => 'MBBank'
                        ]
                    );

                    // Chỉ cập nhật số dư và lưu lịch sử nếu bản ghi mới được tạo
                    if ($bankDeposit->wasRecentlyCreated) {
                        // Tìm user và cập nhật số dư
                        $user = User::findOrFail($id);
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
                            'description' => 'Nạp tiền qua MBBank - Mã giao dịch: ' . $transaction['reference_number']
                        ]);
                    }
                    // $this->info('Đã xử lý xong cho id ' . $id . ' có mã GD là: ' . $transaction['reference_number']);
                    DB::commit();

                } catch (\Exception $e) {
                    DB::rollBack();
                    // $this->info('Đã xảy ra lỗi với id ' . $id . ' có mã GD là: ' . $transaction['reference_number']);
                    continue;
                }
                // $this->info('Fetched and processed ' . count($transactions['transactions'] ?? []) . ' transactions.');
            }

        } else {
            $this->error('Failed to fetch transactions: ' . $response->body());
        }
    }
}
