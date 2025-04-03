{{-- /**
* Copyright (c) 2025 FPT University
*
* @author Phạm Hoàng Tuấn
* @email phamhoangtuanqn@gmail.com
* @facebook fb.com/phamhoangtuanqn
*/ --}}

@extends('layouts.user.app')
@section('title', 'Trang chủ')
@section('content')
    <!-- Hero Section with Banner and Top Nạp -->
    <div class="container">
        <div class="hero-wrapper">
            <!-- Banner -->
            <div class="hero-banner">
                <a href="{{ route('category.show-all') }}">
                    <img src="https://123nick.vn/upload-usr/images/8jElw7OK4i_1629517832.gif" alt="Banner game Ngọc Rồng"
                        class="hero-banner__img">
                </a>
            </div>

            <!-- Top Nạp -->
            <div class="hero-sidebar">
                <div class="hero-sidebar__header">
                    <i class="fas fa-chart-line"></i> TOP Nạp Tháng {{ date('m') }}
                </div>
                <div class="hero-sidebar__content">
                    <div class="hero-sidebar__list">
                        <div class="hero-sidebar__item">
                            <div class="hero-sidebar__user">
                                <img src="https://i.pravatar.cc/40?img=1" alt="User" class="hero-sidebar__avatar">
                                <span class="hero-sidebar__name">Nguyễn Văn A</span>
                            </div>
                            <div class="hero-sidebar__amount">500.000đ</div>
                        </div>
                        <div class="hero-sidebar__item">
                            <div class="hero-sidebar__user">
                                <img src="https://i.pravatar.cc/40?img=2" alt="User" class="hero-sidebar__avatar">
                                <span class="hero-sidebar__name">Trần Thị B</span>
                            </div>
                            <div class="hero-sidebar__amount">300.000đ</div>
                        </div>
                        <div class="hero-sidebar__item">
                            <div class="hero-sidebar__user">
                                <img src="https://i.pravatar.cc/40?img=3" alt="User" class="hero-sidebar__avatar">
                                <span class="hero-sidebar__name">Lê Văn C</span>
                            </div>
                            <div class="hero-sidebar__amount">200.000đ</div>
                        </div>
                    </div>
                    {{-- <div class="hero-sidebar__empty">
                        Chưa có dữ liệu
                    </div> --}}
                    <a href="{{ route('profile.deposit-card') }}" class="hero-sidebar__btn">
                        <i class="fas fa-wallet"></i> NẠP TIỀN NGAY
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Thông báo và Giao dịch gần đây -->
    <div class="container">
        <!-- Thông báo -->
        <div class="service__alert service__alert--success">
            <i class="fas fa-info-circle"></i>
            <div class="service__alert-content">
                <p>Chào mừng bạn đến với Shop Ngọc Rồng Online. Nạp ATM/Momo khuyến mãi 10%, Nạp thẻ cào nhận 100% giá trị
                    thẻ nạp !!!</p>
            </div>
            <button class="service__alert-close">&times;</button>
        </div>

        <!-- Giao dịch gần đây -->
        <div class="recent-transactions">
            <div class="recent-transactions__header">
                <div class="recent-transactions__title">
                    <i class="fas fa-history"></i> Giao Dịch Gần Đây
                </div>
            </div>
            <div class="recent-transactions__marquee">
                <div class="recent-transactions__list">
                    <div class="recent-transactions__item">
                        <span class="recent-transactions__username">user***</span>
                        <span class="recent-transactions__time">cách đây 5 phút</span>
                        đã mua tài khoản
                        <span class="recent-transactions__amount">#12345</span>
                        với giá
                        <span class="recent-transactions__amount">50.000 ₫</span>
                    </div>
                    <div class="recent-transactions__item">
                        <span class="recent-transactions__username">game***</span>
                        <span class="recent-transactions__time">cách đây 10 phút</span>
                        đã mua tài khoản
                        <span class="recent-transactions__amount">#54321</span>
                        với giá
                        <span class="recent-transactions__amount">120.000 ₫</span>
                    </div>
                    <div class="recent-transactions__item">
                        <span class="recent-transactions__username">nro***</span>
                        <span class="recent-transactions__time">cách đây 15 phút</span>
                        đã nạp thẻ
                        <span class="recent-transactions__amount">200.000 ₫</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Transaction -->
    <section class="menu special-menu">
        <div class="container">
            <header class="menu__header">
                <h2 class="menu__header__title">Giao Dịch Nhanh</h2>
            </header>
            <div class="transaction__list">
                <a href="{{ route('profile.deposit-card') }}" class="transaction__item">
                    <div class="transaction__icon">
                        <img src="https://acc957.com/Img/NapThe.png" alt="Nạp thẻ" class="transaction__img" />
                    </div>
                    <p class="text text__transaction__item">NẠP THẺ</p>
                </a>
                <a href="/profile" class="transaction__item">
                    <div class="transaction__icon">
                        <img src="https://acc957.com/Img/TaiKhoan.png" alt="Tài khoản" class="transaction__img" />
                    </div>
                    <p class="text text__transaction__item">TÀI KHOẢN</p>
                </a>
                <a href="{{ route('service.show-all') }}" class="transaction__item">
                    <div class="transaction__icon">
                        <img src="https://acc957.com/Img/DichVu.png" alt="Dịch vụ" class="transaction__img" />
                    </div>
                    <p class="text text__transaction__item">DỊCH VỤ</p>
                </a>
                <a href="{{ route('lucky.show-all') }}" class="transaction__item">
                    <div class="transaction__icon">
                        <img src="https://acc957.com/Img/NickRandom.png" alt="Vòng quay" class="transaction__img" />
                    </div>
                    <p class="text text__transaction__item">VÒNG QUAY</p>
                </a>
            </div>
        </div>
    </section>

    <!-- Menu mục game -->
    <section class="menu">
        <div class="container">
            <header class="menu__header">
                <h2 class="menu__header__title">Tài Khoản Game</h2>
            </header>
            <div class="category__list">
                @foreach ($categories as $category)
                    <a href="{{ route('category.index', ['slug' => $category->slug]) }}" class="category__item">
                        <img src="{{ $category->thumbnail }}" alt="{{ $category->name }}" class="category__img" />
                        <h2 class="category__title">{{ $category->name }}</h2>
                        <div class="category__stats">
                            <span class="badge">{{ number_format($category->allAccount) }} Tài khoản</span>
                            <span class="badge">Đã bán: {{ number_format($category->soldCount) }}</span>
                        </div>
                        <p class="category__action">XEM CHI TIẾT</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Menu mục dịch vụ game -->
    <section class="menu">
        <div class="container">
            <header class="menu__header">
                <h2 class="menu__header__title">Dịch Vụ Game</h2>
            </header>
            <div class="category__list">
                @foreach ($services as $service)
                    @if ($service->active)
                        <a href="{{ route('service.show', ['slug' => $service->slug]) }}" class="category__item">
                            <img src="{{ $service->thumbnail }}" alt="{{ $service->name }}" class="category__img" />
                            <h2 class="category__title">{{ $service->name }}</h2>
                            <div class="category__stats">
                                <span class="badge">{{ number_format($service->orderCount) }} giao dịch</span>
                            </div>
                            <p class="category__action">ĐẶT NGAY</p>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <!-- Menu DANH MỤC RANDOM -->
    <section class="menu">
        <div class="container">
            <header class="menu__header">
                <h2 class="menu__header__title">Tài Khoản Random</h2>
            </header>
            <div class="category__list">
                @foreach ($randomCategories as $category)
                    @if ($category->active)
                        <a href="{{ route('random.index', ['slug' => $category->slug]) }}" class="category__item">
                            <img src="{{ $category->thumbnail }}" alt="{{ $category->name }}" class="category__img" />
                            <h2 class="category__title">{{ $category->name }}</h2>
                            <div class="category__stats">
                                <span class="badge">{{ number_format($category->allAccount) }} Tài
                                    khoản</span>
                                <span class="badge">Đã bán: {{ number_format($category->soldCount) }}</span>
                            </div>
                            <p class="category__action">THỬ VẬN MAY</p>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <!-- Menu DANH MỤC VÒNG QUAY MAY MẮN -->
    <section class="menu">
        <div class="container">
            <header class="menu__header">
                <h2 class="menu__header__title">Vòng Quay May Mắn</h2>
            </header>
            <div class="category__list">
                @foreach ($randomLuckWheel as $category)
                    @if ($category->active)
                        <a href="{{ route('lucky.index', ['slug' => $category->slug]) }}" class="category__item">
                            <img src="{{ $category->thumbnail }}" alt="{{ $category->name }}" class="category__img" />
                            <h2 class="category__title">{{ $category->name }}</h2>
                            <div class="category__stats">
                                <span class="badge">{{ number_format($category->soldCount) }} lượt
                                    quay</span>
                            </div>
                            <p class="category__action">QUAY NGAY</p>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </section>


@endsection

@push('styles')
    <style>
        .category__stats {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin: 10px 20px;
        }

        .special-notice {
            background: linear-gradient(135deg, #0E3EDA, #0A2E9F);
            border-radius: var(--border-radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-md);
        }

        .special-notice__content {
            padding: 35px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 30px;
            position: relative;
        }

        .special-notice__text {
            flex: 1;
        }

        .special-notice__title {
            color: white;
            font-size: 2.4rem;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .special-notice__desc {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.6rem;
            margin-bottom: 25px;
            line-height: 1.5;
        }

        .special-notice__btn {
            background: var(--primary-color);
            color: white;
            padding: 12px 30px;
            border-radius: var(--border-radius-pill);
            font-weight: 700;
            font-size: 1.6rem;
            display: inline-block;
            transition: var(--transition);
            box-shadow: 0 4px 10px rgba(14, 62, 218, 0.4);
        }

        .special-notice__btn:hover {
            background: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(14, 62, 218, 0.5);
            color: white;
        }

        .special-notice__image {
            width: 220px;
            height: 220px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .special-notice__image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.3));
        }

        @media screen and (max-width: 992px) {
            .special-notice__content {
                flex-direction: column;
                padding: 30px 20px;
            }

            .special-notice__text {
                text-align: center;
                margin-bottom: 20px;
            }

            .special-notice__image {
                width: 180px;
                height: 180px;
            }
        }

        @media screen and (max-width: 576px) {
            .special-notice__title {
                font-size: 2rem;
            }

            .special-notice__desc {
                font-size: 1.4rem;
            }

            .special-notice__image {
                width: 150px;
                height: 150px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Xử lý đóng thông báo
            const alertCloseBtn = document.querySelector('.service__alert-close');
            if (alertCloseBtn) {
                alertCloseBtn.addEventListener('click', function() {
                    const alert = this.closest('.service__alert');
                    if (alert) {
                        alert.style.display = 'none';
                    }
                });
            }

            // Code xử lý khác nếu cần
        });
    </script>
@endpush
