{{-- /**
* Copyright (c) 2025 FPT University
*
* @author Phạm Hoàng Tuấn
* @email phamhoangtuanqn@gmail.com
* @facebook fb.com/phamhoangtuanqn
*/ --}}

@extends('layouts.user.app')

@section('title', 'Chi tiết tài khoản random #' . $account->id)

@section('content')
    <x-hero-header title="THÔNG TIN TÀI KHOẢN RANDOM #{{ $account->id }}"
        description="Tài khoản random từ danh mục {{ $account->category->name }}" />

    <section class="detail">
        <div class="container">
            <div class="detail__content">
                <!-- Action Buttons -->
                <div class="detail__actions">
                    @if ($account->status === 'available')
                        <button class="detail__btn detail__btn--primary" onclick="buyAccount({{ $account->id }})">MUA
                            NGAY</button>
                        <a class="detail__btn detail__btn--card" href="{{ route('profile.deposit-card') }}">NẠP THẺ</a>
                        <button class="detail__btn detail__btn--wallet" onclick="showRechargeModal('wallet')">NẠP
                            ATM</button>
                    @else
                        <div class="detail__purchased">
                            <h2 class="detail__purchased-title">Tài khoản này đã được mua</h2>
                        </div>
                    @endif
                </div>
                <!-- Account Info -->
                <div class="detail__info">
                    <h2 class="detail__info-title">Thông tin tài khoản random</h2>

                    <div class="detail__info-row">
                        <div class="detail__info-label">ID:</div>
                        <div class="detail__info-value">#{{ $account->id }}</div>
                    </div>

                    <div class="detail__info-row">
                        <div class="detail__info-label">Danh mục:</div>
                        <div class="detail__info-value">{{ $account->category->name }}</div>
                    </div>

                    <div class="detail__info-row">
                        <div class="detail__info-label">Máy chủ:</div>
                        <div class="detail__info-value">{{ $account->server }}</div>
                    </div>

                    <div class="detail__info-row">
                        <div class="detail__info-label">Giá:</div>
                        <div class="detail__info-value">{{ number_format($account->price) }}đ</div>
                    </div>

                    @if (!empty($account->note))
                        <div class="detail__info-row">
                            <div class="detail__info-label">Ghi chú:</div>
                            <div class="detail__info-value">{{ $account->note }}</div>
                        </div>
                    @endif
                </div>

                <!-- Account Preview -->
                @if ($account->thumbnail)
                    <div class="detail__images">
                        <h2 class="detail__images-title">Hình ảnh tài khoản random <span
                                class="text-danger">#{{ $account->id }}</span>
                        </h2>
                        <div class="detail__images-list">
                            <img src="{{ $account->thumbnail }}" alt="Account Preview" class="detail__images-item">
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Purchase Modal -->
    <div id="purchaseModal" class="modal">
        <div class="modal__content">
            <div class="modal__header">
                <h2 class="modal__title">XÁC NHẬN MUA TÀI KHOẢN RANDOM #{{ $account->id }}</h2>
                <button class="modal__close" onclick="closePurchaseModal()">&times;</button>
            </div>

            <div class="modal__body">
                <div class="modal__info">
                    <div class="modal__row">
                        <span class="modal__label">Danh mục:</span>
                        <span class="modal__value">{{ $account->category->name }}</span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label">Máy chủ:</span>
                        <span class="modal__value">{{ $account->server }}</span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label">Giá tiền:</span>
                        <span class="modal__value modal__value--price"
                            id="account-price">{{ number_format($account->price) }} đ</span>
                    </div>
                </div>

                <div class="modal__discount">
                    <div class="modal__row">
                        <input type="text" id="discount-code" class="modal__input" placeholder="Nhập mã giảm giá nếu có">
                        <button class="modal__btn modal__btn--check" onclick="checkDiscountCode()">Kiểm tra</button>
                    </div>
                    <div id="discount-message" class="modal__discount-message"></div>
                </div>

                @auth
                    @if (Auth::user()->balance < $account->price)
                        <div class="modal__notice">
                            Bạn cần thêm {{ number_format($account->price - Auth::user()->balance) }} đ để mua tài khoản này.
                            Bạn hãy click vào nút nạp thẻ để nạp thêm và mua tài khoản.
                        </div>
                    @endif
                @else
                    <div class="modal__notice">
                        Vui lòng đăng nhập để thực hiện giao dịch.
                    </div>
                @endauth
            </div>

            <div class="modal__footer">
                @auth
                    @if (Auth::user()->balance < $account->price)
                        <a class="modal__btn modal__btn--card" href="{{ route('profile.deposit-card') }}">NẠP THẺ CÀO</a>
                        <button class="modal__btn modal__btn--wallet" onclick="showRechargeModal('wallet')">NẠP ATM</button>
                    @else
                        <button class="modal__btn modal__btn--card" onclick="purchaseAccount({{ $account->id }})">XÁC NHẬN
                            MUA</button>
                    @endif
                @else
                    <a class="modal__btn modal__btn--wallet" href="{{ route('login') }}">ĐĂNG NHẬP</a>
                @endauth
                <button class="modal__btn modal__btn--close" onclick="closePurchaseModal()">ĐÓNG</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let discountCode = '';
        let originalPrice = {{ $account->price }};
        let discountedPrice = originalPrice;

        function buyAccount(accountId) {
            const modal = document.getElementById('purchaseModal');
            if (modal) {
                modal.style.display = 'block';
                document.body.style.overflow = 'hidden';
            }
        }

        function closePurchaseModal() {
            const modal = document.getElementById('purchaseModal');
            if (modal) {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        }

        function checkDiscountCode() {
            discountCode = document.getElementById('discount-code').value.trim();
            const messageElement = document.getElementById('discount-message');

            if (!discountCode) {
                messageElement.innerHTML = 'Vui lòng nhập mã giảm giá!';
                messageElement.className = 'modal__discount-message modal__discount-message--error';
                return;
            }

            // Giả lập kiểm tra mã giảm giá
            // Trong thực tế, gửi request đến server để kiểm tra
            messageElement.innerHTML = 'Đang kiểm tra mã...';
            messageElement.className = 'modal__discount-message';

            // Reset price to original
            discountedPrice = originalPrice;
            document.getElementById('account-price').textContent = new Intl.NumberFormat('vi-VN').format(discountedPrice) +
                ' đ';
        }

        function purchaseAccount(accountId) {
            if (!confirm('Bạn có chắc chắn muốn mua tài khoản này?')) {
                return;
            }

            const data = {
                discount_code: discountCode
            };

            fetch(`/random/account/${accountId}/purchase`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Mua tài khoản thành công!');

                        // Update balance display if exists
                        const balanceElement = document.querySelector('.balance-value');
                        if (balanceElement) {
                            balanceElement.textContent = new Intl.NumberFormat('vi-VN').format(data.data.new_balance) +
                                ' VND';
                        }

                        // Redirect to purchased accounts page
                        window.location.href = '{{ route('profile.purchased-accounts') }}';
                    } else {
                        alert(data.message || 'Có lỗi xảy ra khi mua tài khoản');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra khi xử lý yêu cầu');
                });
        }
    </script>
@endpush
