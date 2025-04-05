@extends('layouts.user.app')

@section('title', $title)

@section('content')

    <section class="profile-section">
        <div class="container">
            <div class="profile-container">
                <div class="profile-header">
                    <h1 class="profile-title">NẠP TIỀN QUA NGÂN HÀNG</h1>
                </div>

                <div class="profile-content">
                    @include('layouts.user.sidebar')

                    <div class="profile-main">
                        <div class="profile-info-card">
                            <div class="info-header">
                                <div class="balance-info">
                                    <span class="balance-label">SỐ DƯ:</span>
                                    <span class="balance-value">{{ number_format(Auth::user()->balance ?? 0) }} VND</span>
                                </div>
                            </div>

                            <div class="info-content">
                                <!-- Thông báo -->
                                @if ($errors->any())
                                    <div class="service__alert service__alert--error">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <div>
                                            <span>Đã có lỗi xảy ra:</span>
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <button type="button" class="service__alert-close">&times;</button>
                                    </div>
                                @endif
                                @foreach (['error', 'success'] as $msg)
                                    @if (session($msg))
                                        <div
                                            class="service__alert service__alert--{{ $msg === 'error' ? 'error' : 'success' }}">
                                            <i
                                                class="fas fa-{{ $msg === 'error' ? 'exclamation-circle' : 'check-circle' }}"></i>
                                            <div>
                                                <span>{{ session($msg) }}</span>
                                            </div>
                                            <button type="button" class="service__alert-close">&times;</button>
                                        </div>
                                    @endif
                                @endforeach
                                <!-- Kết thúc thông báo -->

                                <div class="deposit-notice">
                                    <div class="notice-header">HƯỚNG DẪN NẠP TIỀN QUA NGÂN HÀNG</div>
                                    <div class="notice-content">
                                        <p>1. Chuyển tiền vào một trong các tài khoản ngân hàng bên dưới</p>
                                        <p>2. Yêu cầu chuyển đúng nội dung chuyển khoản bên dưới</p>
                                        <p>3. Số tiền sẽ được cộng tự động vào tài khoản sau khi giao dịch hoàn tất</p>
                                    </div>
                                    <div class="notice-warning">CHÚ Ý: PHẢI ĐÚNG CÚ PHÁP NỘI DUNG CHUYỂN KHOẢN</div>
                                </div>

                                <div class="bank-accounts-container">
                                    <div class="bank-accounts-title">THÔNG TIN TÀI KHOẢN NGÂN HÀNG</div>

                                    <div class="bank-accounts-list">
                                        @if (count($bankAccounts) > 0)
                                            @foreach ($bankAccounts as $account)
                                                <div class="bank-account-item">
                                                    <div class="bank-account-info">
                                                        <div class="bank-details">
                                                            <h3 class="bank-name">{{ $account->bank_name }}</h3>
                                                            <div class="branch">
                                                                <span class="label">Tên tài khoản:</span>
                                                                <span class="value">{{ $account->account_name }}</span>
                                                            </div>
                                                            <div class="account-number">
                                                                <span class="label">Số tài khoản:</span>
                                                                <span class="value">{{ $account->account_number }}</span>
                                                                <button class="copy-btn"
                                                                    data-clipboard-text="{{ $account->account_number }}">
                                                                    <i class="far fa-copy"></i>
                                                                </button>
                                                            </div>
                                                            <div class="branch">
                                                                <span class="label">Chi nhánh:</span>
                                                                <span class="value">{{ $account->branch }}</span>
                                                            </div>
                                                            @if ($account->note)
                                                                <div class="note">
                                                                    <span class="label">Ghi chú:</span>
                                                                    <span class="value">{{ $account->note }}</span>
                                                                </div>
                                                            @endif
                                                            @if ($account->note)
                                                                <div class="note">
                                                                    <span class="label">Nội dung:</span>
                                                                    <span
                                                                        class="value text-danger">{{ $account->prefix . Auth::user()->id }}</span>
                                                                </div>
                                                            @endif
                                                            <div class="auto-confirm">
                                                                <span class="label">Trạng thái:</span>
                                                                <span
                                                                    class="value {{ $account->auto_confirm ? 'auto' : 'manual' }}">
                                                                    {{ $account->auto_confirm ? 'Tự động cộng tiền' : 'Cộng tiền thủ công' }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="bank-qr-code">
                                                        <img src="https://qr.sepay.vn/img?bank={{ $account->bank_name }}&acc={{ $account->account_number }}&template=&amount=&des={{ $account->prefix . Auth::user()->id }}"
                                                            alt="QR Code">

                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="no-bank-accounts">
                                                <p class="text-danger text-bold">Hiện tại không có tài khoản ngân hàng nào
                                                    được cấu
                                                    hình</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="deposit-history">
                                    <div class="history-header">LỊCH SỬ NẠP TIỀN</div>
                                    <div class="history-table-container">
                                        <table class="history-table">
                                            <thead>
                                                <tr>
                                                    <th>Thời gian</th>
                                                    <th>Số tiền</th>
                                                    <th>Ngân hàng</th>
                                                    <th>Nội dung</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (isset($transactions) && count($transactions) > 0)
                                                    @foreach ($transactions as $transaction)
                                                        <tr>
                                                            <td>{{ $transaction->created_at }}</td>
                                                            <td class="text-success">
                                                                {{ number_format($transaction->amount) }} VND</td>
                                                            <td>{{ $transaction->bank }}</td>
                                                            <td>{{ $transaction->content }}</td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="4" class="no-data">Không có dữ liệu</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    @if (isset($transactions) && $transactions->hasPages())
                                        <div class="pagination">
                                            {{ $transactions->links() }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.8/dist/clipboard.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Clipboard.js init
                var clipboard = new ClipboardJS('.copy-btn');

                clipboard.on('success', function(e) {
                    const originalText = e.trigger.innerHTML;
                    e.trigger.innerHTML = '<i class="fas fa-check"></i>';

                    setTimeout(function() {
                        e.trigger.innerHTML = originalText;
                    }, 2000);

                    e.clearSelection();
                });

                // Close alert buttons
                const alertCloseButtons = document.querySelectorAll('.service__alert-close');
                alertCloseButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        this.closest('.service__alert').remove();
                    });
                });
            });
        </script>
    @endpush

@endsection
