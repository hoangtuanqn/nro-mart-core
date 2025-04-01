{{-- /**
* Copyright (c) 2025 FPT University
*
* @author Phạm Hoàng Tuấn
* @email phamhoangtuanqn@gmail.com
* @facebook fb.com/phamhoangtuanqn
*/ --}}

@extends('layouts.user.app')

@section('title', 'Chi tiết tài khoản random #' . $account->id)
@push('css')
<style>
    .detail__images-list {
        grid-template-columns: 1fr;
    }
</style>
@endpush
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
                        <div class="detail__info-value account-price-value">{{ number_format($account->price) }}đ</div>
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
                            <!-- Using data-src instead of src for SimpleLightbox -->
                            <a href="{{ $account->thumbnail }}" title="Xem ảnh lớn" class="detail__images-link">
                                <img src="{{ $account->thumbnail }}" alt="Tài khoản Random #{{ $account->id }}"
                                    class="detail__images-item">
                            </a>
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
                            id="account-price">{{ number_format($account->price) }}đ</span>
                    </div>
                </div>

                <div class="modal__discount">
                    <div class="modal__row">
                        <input type="text" id="discount-code" class="modal__input" placeholder="Nhập mã giảm giá nếu có">
                        <button class="modal__btn modal__btn--check" onclick="checkDiscountCode('random_account')">Kiểm
                            tra</button>
                    </div>
                    <div id="discount-message" class="modal__discount-message"></div>
                </div>

                @auth
                    @if (Auth::user()->balance < $account->price)
                        <div class="modal__notice">
                            Bạn cần thêm {{ number_format($account->price - Auth::user()->balance) }}đ để mua tài khoản này.
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
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize the lightbox for detail images
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
                initDiscountHandler('random_account', accountId, {{ $account->price }});
            }
        }

        function closePurchaseModal() {
            const modal = document.getElementById('purchaseModal');
            if (modal) {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        }

        function submitPurchase() {
            const accountId = {{ $account->id }};
            const discountInfo = getDiscountInfo();

            fetch(`/random/account/${accountId}/purchase`, {
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
                        window.location.href = data.redirect_url ||
                            '{{ route('profile.purchased-random-accounts') }}';
                    } else {
                        alert('Lỗi! ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Lỗi! Đã xảy ra lỗi khi xử lý giao dịch');
                });
        }
    </script>
@endpush
