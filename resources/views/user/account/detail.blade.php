{{-- /**
* Copyright (c) 2025 FPT University
*
* @author Phạm Hoàng Tuấn
* @email phamhoangtuanqn@gmail.com
* @facebook fb.com/phamhoangtuanqn
*/ --}}

@extends('layouts.user.app')

@section('title', 'Chi tiết tài khoản #' . $account->id)

@section('content')
    <x-hero-header title="THÔNG TIN TÀI KHOẢN #{{ $account->id }}"
        description="Để xem thêm chi tiết về tài khoản và bộ sưu tập bên dưới" />

    <section class="detail">
        <div class="container">
            <div class="detail__content">
                <!-- Action Buttons -->
                <div class="detail__actions">
                    @if ($account->status === 'available')
                        <button class="detail__btn detail__btn--primary" onclick="buyAccount({{ $account->id }})"><i
                                class="fas fa-shopping-cart"></i>MUA NGAY</button>
                        <a class="detail__btn detail__btn--card" href="{{ route('profile.deposit-card') }}"><i
                                class="fas fa-credit-card"></i>NẠP THẺ</a>
                        <button class="detail__btn detail__btn--wallet" onclick="showRechargeModal('wallet')"><i
                                class="fas fa-university"></i>NẠP ATM</button>
                    @else
                        <div class="detail__purchased">
                            <h2 class="detail__purchased-title">Tài khoản này đã được mua</h2>
                        </div>
                    @endif
                </div>
                <!-- Account Info -->
                <div class="detail__info">
                    <div class="detail__info-row">
                        <div class="detail__info-item">
                            <span class="detail__info-label">MÁY CHỦ:</span>
                            <span class="detail__info-value">Server {{ $account->server }}</span>
                        </div>
                        <div class="detail__info-item">
                            <span class="detail__info-label">HÀNH TINH:</span>
                            <span class="detail__info-value">{{ display_hanh_tinh($account->planet) }}</span>
                        </div>
                    </div>

                    <div class="detail__info-row">
                        <div class="detail__info-item">
                            <span class="detail__info-label">ĐĂNG KÝ:</span>
                            <span class="detail__info-value">{{ display_dang_ky($account->registration_type) }}</span>
                        </div>
                        <div class="detail__info-item">
                            <span class="detail__info-label">BÔNG TAI:</span>
                            <span class="detail__info-value">{{ $account->earring ? 'Có' : 'Không' }}</span>
                        </div>
                    </div>

                    @if ($account->note)
                        <div class="detail__info-row">
                            <div class="detail__info-item">
                                <span class="detail__info-label">NỔI BẬT:</span>
                                <span class="detail__info-value">{{ $account->note }}</span>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Account Images -->
                <div class="detail__images">
                    <h2 class="detail__images-title">Hình ảnh chi tiết của tài khoản Ngọc rồng Online <span
                            class="text-danger">#{{ $account->id }}</span>
                    </h2>
                    <div class="detail__images-list">
                        @foreach ($images as $image)
                            <a href="{{ $image }}" title="Xem ảnh lớn" class="detail__images-link">
                                <img src="{{ $image }}"
                                    alt="Tài khoản #{{ $account->id }} - Ảnh {{ $loop->iteration }}"
                                    class="detail__images-item">
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Purchase Modal -->
    <div id="purchaseModal" class="modal">
        <div class="modal__content">
            <div class="modal__header">
                <h2 class="modal__title">XÁC NHẬN MUA TÀI KHOẢN #{{ $account->id }}</h2>
                <button class="modal__close" onclick="closePurchaseModal()">&times;</button>
            </div>

            <div class="modal__body">
                <div class="modal__info">
                    <div class="modal__row">
                        <span class="modal__label">Nhà phát hành:</span>
                        <span class="modal__value">TeaMobi</span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label">Tên game:</span>
                        <span class="modal__value">Ngọc Rồng Online</span>
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
                        <button class="modal__btn modal__btn--check" onclick="checkDiscountCode('account')">Kiểm
                            tra</button>
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
                        <button class="modal__btn modal__btn--card" onclick="submitPurchase()">XÁC NHẬN
                            MUA</button>
                    @endif
                @else
                    <a class="modal__btn modal__btn--wallet" href="{{ route('login') }}">ĐĂNG NHẬP</a>
                @endauth
                <button class="modal__btn modal__btn--close" onclick="closePurchaseModal()">ĐÓNG</button>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize the lightbox for account images
                const lightbox = new SimpleLightbox('.detail__images-link', {
                    captionPosition: 'bottom',
                    captionsData: 'alt',
                    closeText: '×',
                    navText: ['←', '→'],
                    animationSpeed: 250,
                    enableKeyboard: true,
                    scaleImageToRatio: true,
                    disableRightClick: true
                });
            });

            function buyAccount(accountId) {
                const modal = document.getElementById('purchaseModal');
                if (modal) {
                    modal.style.display = 'block';
                    document.body.style.overflow = 'hidden';

                    // Initialize discount handler
                    initDiscountHandler('account', accountId, {{ $account->price }});
                }
            }

            function submitPurchase() {
                const accountId = {{ $account->id }};
                const discountInfo = getDiscountInfo();

                fetch(`/account/${accountId}/purchase`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            discount_code: discountInfo.discountCode
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Thành công! ' + data.message);
                            window.location.href = data.redirect_url;
                        } else {
                            alert('Lỗi! ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Lỗi! Đã xảy ra lỗi khi xử lý giao dịch');
                    });
            }

            function showRechargeModal(type) {
                // Implement recharge modal logic here
                console.log('Show recharge modal:', type);
            }

            function closePurchaseModal() {
                const modal = document.getElementById('purchaseModal');
                if (modal) {
                    modal.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }
            }

            // Close modal when clicking outside
            document.addEventListener('DOMContentLoaded', function() {
                const modal = document.getElementById('purchaseModal');
                if (modal) {
                    window.addEventListener('click', function(event) {
                        if (event.target === modal) {
                            closePurchaseModal();
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection
