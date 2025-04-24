{{-- /**
* Copyright (c) 2025 FPT University
*
* @author Phạm Hoàng Tuấn
* @email phamhoangtuanqn@gmail.com
* @facebook fb.com/phamhoangtuanqn
*/ --}}

<!DOCTYPE html>
<html lang="en">
<!-- Head -->
@include('layouts.user.head')

<body>
    <!-- CSRF Token Meta for JS usage -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('layouts.user.header')
    <!-- Main -->
    <main>
        @yield('content')
    </main>

    @include('layouts.user.footer')
    @include('layouts.user.menu-mobile')

    <!-- Deposit Options Modal -->
    <div id="depositOptionsModal"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999;">
        <div
            style="position: relative; width: 90%; max-width: 500px; margin: 20vh auto; background: #fff; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.3);">
            <div
                style="padding: 15px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="margin: 0; font-size: 18px;">CHỌN PHƯƠNG THỨC NẠP TIỀN</h3>
                <button onclick="closeDepositOptionsModal()"
                    style="background: none; border: none; font-size: 24px; cursor: pointer;">&times;</button>
            </div>

            <div style="padding: 30px; display: flex; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
                <div onclick="redirectToCardDeposit()"
                    style="flex: 1; min-width: 180px; padding: 20px; background: #f8f9fa; border-radius: 8px; text-align: center; cursor: pointer; transition: all 0.2s; border: 1px solid #ddd;">
                    <i class="fa-solid fa-credit-card"
                        style="font-size: 32px; color: #28a745; margin-bottom: 10px;"></i>
                    <h4 style="margin: 10px 0; font-size: 16px;">Nạp qua thẻ cào</h4>
                    <p style="margin: 0; font-size: 14px; color: #6c757d;">Nạp tiền bằng thẻ cào điện thoại</p>
                </div>

                <div onclick="openDepositModal()"
                    style="flex: 1; min-width: 180px; padding: 20px; background: #f8f9fa; border-radius: 8px; text-align: center; cursor: pointer; transition: all 0.2s; border: 1px solid #ddd;">
                    <i class="fa-solid fa-building-columns"
                        style="font-size: 32px; color: #007bff; margin-bottom: 10px;"></i>
                    <h4 style="margin: 10px 0; font-size: 16px;">Nạp qua ATM/Banking</h4>
                    <p style="margin: 0; font-size: 14px; color: #6c757d;">Chuyển khoản qua ngân hàng</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Deposit Modal -->
    <div id="depositModal"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999;">
        <div
            style="position: relative; width: 90%; max-width: 800px; margin: 20px auto; background: #fff; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.3);">
            <div
                style="padding: 15px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="margin: 0; font-size: 18px;">NẠP TIỀN QUA NGÂN HÀNG</h3>
                <button onclick="closeDepositModal()"
                    style="background: none; border: none; font-size: 24px; cursor: pointer;">&times;</button>
            </div>

            <div style="padding: 20px; max-height: 70vh; overflow-y: auto;">
                <!-- Balance -->
              
              

                <!-- Instructions -->
                <div style="margin-bottom: 20px;">
                    <div style="padding: 10px; background: #ffd; border-radius: 5px; margin-bottom: 10px;">
                        <p>1. Yêu cầu chuyển đúng nội dung chuyển khoản bên dưới</p>
                        <p>2. Số tiền sẽ được cộng tự động vào tài khoản sau khi giao dịch hoàn tất</p>
                        <div style="color: red; font-weight: bold; margin-top: 5px;">CHÚ Ý: PHẢI ĐÚNG CÚ PHÁP NỘI DUNG
                            CHUYỂN KHOẢN</div>
                    </div>
                </div>

                <!-- Bank Accounts -->
                <div id="bankAccountsList" style="margin-bottom: 20px;">
                    <div style="font-weight: bold; margin-bottom: 10px; font-size: 16px;">THÔNG TIN TÀI KHOẢN NGÂN HÀNG
                    </div>
                    <div id="bankAccountsLoading" style="text-align: center; padding: 20px;">
                        <div
                            style="display: inline-block; width: 30px; height: 30px; border: 3px solid #f3f3f3; border-radius: 50%; border-top: 3px solid #3498db; animation: spin 1s linear infinite;">
                        </div>
                        <p>Đang tải thông tin ngân hàng...</p>
                    </div>
                </div>
            </div>

            <div style="padding: 15px; border-top: 1px solid #eee; text-align: center;">
                <button onclick="closeDepositModal()"
                    style="padding: 8px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">Đã
                    hiểu</button>
            </div>
        </div>
    </div>

    <style>
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>

    <!-- Lightbox script -->
    <script src="{{ asset('assets/libs/simplelightbox.min.js') }}"></script>
    <script src="{{ asset('assets/js/image-lightbox.js') }}"></script>

    <!-- Mobile Menu script -->
    <script src="{{ asset('assets/js/mobile-menu.js') }}"></script>

    <!-- Core scripts -->
    <script src="{{ asset('assets/js/discount-code.js') }}"></script>

    <!-- Deposit Modal Script -->
    <script>
        // Open deposit options modal
        function openDepositOptionsModal() {
            document.getElementById('depositOptionsModal').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        // Close deposit options modal
        function closeDepositOptionsModal() {
            document.getElementById('depositOptionsModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Open deposit modal
        function openDepositModal() {
            document.getElementById('depositOptionsModal').style.display = 'none';
            document.getElementById('depositModal').style.display = 'block';
            loadBankAccounts();
        }

        // Close deposit modal
        function closeDepositModal() {
            document.getElementById('depositModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        function redirectToCardDeposit() {
            window.location.href = "{{ route('profile.deposit-card') }}";
        }

        // Load bank accounts
        function loadBankAccounts() {
            $.ajax({
                url: '/api/deposit-modal/bank-accounts',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        let html =
                            '<div class="bank-accounts-list" style="display: flex; flex-direction: column; gap: 15px;">';

                        response.bankAccounts.forEach(function(account) {
                            html += `
                                <div style="border: 1px solid #ddd; border-radius: 8px; overflow: hidden;">
                                    <div style="display: flex; flex-wrap: wrap; justify-content: center">
                                        <div style="flex: 1; min-width: 300px; padding: 15px;">
                                            <h3 style="font-size: 18px; margin-top: 0; margin-bottom: 10px; color: #007bff;">${account.bank_name}</h3>
                                          <div style="margin-bottom: 8px;">
                                              <span style="display: inline-block; width: 120px; font-weight: bold;">Tên tài khoản:</span>
                                               <span>${account.account_name}</span>
                                          </div>
                                            <div style="margin-bottom: 8px; display: flex; align-items: center;">
                                                <span style="display: inline-block; width: 120px; font-weight: bold;">Số tài khoản:</span>
                                                <span>${account.account_number}</span>
                                                <button onclick="copyToClipboard('${account.account_number}')" style="margin-left: 10px; padding: 2px 8px; background: #f8f9fa; border: 1px solid #ddd; border-radius: 3px; cursor: pointer;">
                                                    <i class="far fa-copy"></i>
                                                </button>
                                            </div>
                                            <div style="margin-bottom: 8px;">
                                                <span style="display: inline-block; width: 120px; font-weight: bold;">Chi nhánh:</span>
                                                <span>${account.branch || 'Tất cả chi nhánh'}</span>
                                            </div>
                                            ${account.note ? 
                                                `<div style="margin-bottom: 8px;">
                                                                                                                    <span style="display: inline-block; width: 120px; font-weight: bold;">Ghi chú:</span>
                                                                                                                    <span>${account.note}</span>
                                                                                                                </div>` : ''
                                            }
                                            <div style="margin-bottom: 8px;">
                                                <span style="display: inline-block; width: 120px; font-weight: bold;">Nội dung:</span>
                                                <span style="color: red; font-weight: bold;">${account.content}</span>
                                                <button onclick="copyToClipboard('${account.content}')" style="margin-left: 10px; padding: 2px 8px; background: #f8f9fa; border: 1px solid #ddd; border-radius: 3px; cursor: pointer;">
                                                    <i class="far fa-copy"></i>
                                                </button>
                                            </div>
                                            <div style="margin-bottom: 8px;">
                                                <span style="display: inline-block; width: 120px; font-weight: bold;">Trạng thái:</span>
                                                <span style="color: ${account.auto_confirm ? 'green' : 'orange'}; font-weight: bold;">
                                                    ${account.auto_confirm ? 'Tự động cộng tiền' : 'Cộng tiền thủ công'}
                                                </span>
                                            </div>
                                        </div>
                                        <div style="width: 200px; padding: 15px; display: flex; justify-content: center; align-items: center; background: #f9f9f9;">
                                            <img src="https://qr.sepay.vn/img?bank=${encodeURIComponent(account.bank_name)}&acc=${account.account_number}&template=&amount=&des=${account.content}" 
                                                alt="QR Code" style="max-width: 100%; max-height: 200px; border: 1px solid #eee;">
                                        </div>
                                    </div>
                                </div>
                            `;
                        });

                        html += '</div>';
                        $('#bankAccountsList').html(html);
                    } else {
                        $('#bankAccountsList').html(`
                            <div style="padding: 20px; text-align: center; background: #fff5f5; border-radius: 5px; border: 1px solid #ffcdd2;">
                                <p style="color: #d32f2f; font-weight: bold;">${response.message || 'Không thể tải thông tin ngân hàng'}</p>
                            </div>
                        `);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error loading bank accounts:', error);
                    $('#bankAccountsList').html(`
                        <div style="padding: 20px; text-align: center; background: #fff5f5; border-radius: 5px; border: 1px solid #ffcdd2;">
                            <p style="color: #d32f2f; font-weight: bold;">Không thể tải thông tin ngân hàng: ${error}</p>
                        </div>
                    `);
                }
            });
        }

        // Copy to clipboard
        function copyToClipboard(text) {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);

            // Show success notification
            const notification = document.createElement('div');
            notification.textContent = 'Đã sao chép số thông tin!';
            notification.style.position = 'fixed';
            notification.style.bottom = '20px';
            notification.style.right = '20px';
            notification.style.padding = '10px 15px';
            notification.style.background = '#4caf50';
            notification.style.color = 'white';
            notification.style.borderRadius = '4px';
            notification.style.zIndex = '10000';
            notification.style.boxShadow = '0 2px 5px rgba(0,0,0,0.3)';
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transition = 'opacity 0.5s';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 500);
            }, 2000);
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const depositOptionsModal = document.getElementById('depositOptionsModal');
            const depositModal = document.getElementById('depositModal');

            if (event.target == depositOptionsModal) {
                closeDepositOptionsModal();
            }

            if (event.target == depositModal) {
                closeDepositModal();
            }
        }

        // Handle escape key to close modals
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeDepositOptionsModal();
                closeDepositModal();
            }
        });
    </script>

    @stack('scripts')
    <script src="{{ asset('assets/js/menu.js') }}"></script>
    <script src="{{ asset('assets/js/alert-notice.js') }}"></script>
</body>

</html>
