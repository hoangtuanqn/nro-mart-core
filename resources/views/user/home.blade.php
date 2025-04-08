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
                    <img src="{{ config_get('site_banner') }}" alt="{{ config_get('site_description') }}"
                        class="hero-banner__img">
                </a>
            </div>

            <!-- Top Nạp -->
            <div class="hero-sidebar">
                <div class="hero-sidebar__header">
                    <i class="fas fa-chart-line"></i> TOP 3 Nạp Tháng {{ date('m') }}
                </div>
                <div class="hero-sidebar__content">
                    <div class="hero-sidebar__list">
                        @forelse($topDepositors as $depositor)
                            <div class="hero-sidebar__item">
                                <div class="hero-sidebar__user">
                                    <div
                                        class="hero-sidebar__rank hero-sidebar__rank--{{ $loop->iteration <= 3 ? ($loop->iteration == 1 ? 'gold' : ($loop->iteration == 2 ? 'silver' : 'bronze')) : '' }}">
                                        {{ $loop->iteration }}</div>
                                    <span class="hero-sidebar__name">{{ $depositor->user->username }}</span>
                                </div>
                                <div class="hero-sidebar__amount">{{ number_format($depositor->total_amount) }}đ</div>
                            </div>
                        @empty
                            <div class="hero-sidebar__empty">
                                Chưa có dữ liệu
                            </div>
                        @endforelse
                    </div>
                    <a href="{{ route('profile.deposit-atm') }}" class="hero-sidebar__btn">
                        <i class="fas fa-wallet"></i> NẠP TIỀN NGAY
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Thông báo và Giao dịch gần đây -->
    <div class="container">
        @if (!empty(config_get('home_notification')))
            <!-- Thông báo -->
            <div class="service__alert service__alert--success">
                <i class="fas fa-info-circle"></i>
                <div class="service__alert-content">
                    <p>{{ config_get('home_notification') }}</p>
                </div>
                <button class="service__alert-close">&times;</button>
            </div>
        @endif

        <!-- Giao dịch gần đây -->
        <div class="recent-transactions">
            <div class="recent-transactions__header">
                <div class="recent-transactions__title">
                    <i class="fas fa-history"></i> Giao Dịch Gần Đây
                </div>
            </div>
            <div class="recent-transactions__marquee">
                <div class="recent-transactions__list">
                    @forelse($recentTransactions as $transaction)
                        <div class="recent-transactions__item">
                            <span
                                class="recent-transactions__username">{{ substr($transaction->user->username, 0, 3) }}***</span>
                            <span class="recent-transactions__time">{{ $transaction->created_at->diffForHumans() }}</span>
                            @if ($transaction->type == 'deposit')
                                đã nạp
                            @elseif($transaction->type == 'withdraw')
                                đã rút
                            @elseif($transaction->type == 'purchase')
                                đã mua
                            @elseif($transaction->type == 'refund')
                                được hoàn
                            @endif
                            <span class="recent-transactions__amount">{{ number_format($transaction->amount) }} ₫</span>
                        </div>
                    @empty
                        <div class="recent-transactions__item">
                            <span class="recent-transactions__username">Chưa có giao dịch nào</span>
                        </div>
                    @endforelse
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
                        <img src="https://i.imgur.com/cZ8R4uz.png" alt="Nạp thẻ" class="transaction__img" />
                    </div>
                    <p class="text text__transaction__item">NẠP THẺ</p>
                </a>
                <a href="/profile" class="transaction__item">
                    <div class="transaction__icon">
                        <img src="https://i.imgur.com/R40n5E3.png" alt="Tài khoản" class="transaction__img" />
                    </div>
                    <p class="text text__transaction__item">TÀI KHOẢN</p>
                </a>
                <a href="{{ route('service.show-all') }}" class="transaction__item">
                    <div class="transaction__icon">
                        <img src="https://i.imgur.com/R9AiElQ.png" alt="Dịch vụ" class="transaction__img" />
                    </div>
                    <p class="text text__transaction__item">DỊCH VỤ</p>
                </a>
                <a href="{{ route('lucky.show-all') }}" class="transaction__item">
                    <div class="transaction__icon">
                        <img src="https://i.imgur.com/kNeAzbA.png" alt="Vòng quay" class="transaction__img" />
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
                @foreach ($LuckWheel as $category)
                    @if ($category->active)
                        <a href="{{ route('lucky.index', ['slug' => $category->slug]) }}" class="category__item">
                            <img src="{{ $category->thumbnail }}" alt="{{ $category->name }}" class="category__img" />
                            <h2 class="category__title">{{ $category->name }}</h2>
                            <div class="category__stats">
                                <span class="badge">{{ number_format($category->soldCount) }} lượt quay</span>
                            </div>
                            <p class="category__action">QUAY NGAY</p>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <!-- Welcome Modal HTML -->
    @if (config_get('welcome_modal', false))
        <div id="welcomeModal" class="welcome-modal-overlay" style="display: none;">
            <div class="welcome-modal">
                <div class="welcome-modal__header">
                    <h3 class="welcome-modal__title">Thông báo</h3>
                    <button class="welcome-modal__close">&times;</button>
                </div>
                <div class="welcome-modal__body">
                    <img src="{{ config_get('site_logo') }}" alt="{{ config_get('site_description') }}"
                        class="welcome-modal__icon">

                    <p>Chào mừng bạn đến với <b>{{ config_get('site_name') }}</b>!</p>
                    <p>{{ config_get('site_description') }}</p>
                    <div class="welcome-modal__feature-list">
                        @foreach ($notifications as $notification)
                            <div class="welcome-modal__feature-item">
                                <div class="welcome-modal__feature-icon">
                                    <i class="fas {{ $notification->class_favicon }}"></i>
                                </div>
                                <div class="welcome-modal__feature-text">
                                    {{ $notification->content }}
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
                <div class="welcome-modal__footer">
                    <button class="welcome-modal__btn" id="welcomeModalBtn">
                        <i class="fas fa-rocket"></i> Bắt đầu ngay
                    </button>
                </div>
            </div>
        </div>
    @endif

@endsection

@push('styles')
    <style>
        .category__stats {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin: 10px 20px;
        }

        .recent-transactions__marquee {
            overflow: hidden;
            position: relative;
            height: 150px;
        }

        .recent-transactions__list {
            animation: marquee 30s linear infinite;
        }

        @keyframes marquee {
            0% {
                transform: translateY(0);
            }

            100% {
                transform: translateY(-50%);
            }
        }

        .recent-transactions__list:hover {
            animation-play-state: paused;
        }

        .recent-transactions__item {
            padding: 8px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .recent-transactions__username {
            font-weight: bold;
            color: #ffd700;
        }

        .recent-transactions__time {
            color: #aaa;
            font-size: 0.9em;
            margin-left: 5px;
        }

        .recent-transactions__amount {
            color: #4caf50;
            font-weight: bold;
            margin-left: 5px;
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

            // Welcome Modal functionality
            const welcomeModal = document.getElementById('welcomeModal');

            if (welcomeModal) {
                const welcomeModalClose = document.querySelector('.welcome-modal__close');
                const welcomeModalBtn = document.getElementById('welcomeModalBtn');

                // Luôn hiển thị modal khi trang được tải
                setTimeout(() => {
                    welcomeModal.style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                }, 500);

                // Close modal event handlers
                if (welcomeModalClose) {
                    welcomeModalClose.addEventListener('click', closeWelcomeModal);
                }

                if (welcomeModalBtn) {
                    welcomeModalBtn.addEventListener('click', closeWelcomeModal);
                }

                // Close when clicking outside modal
                welcomeModal.addEventListener('click', function(e) {
                    if (e.target === welcomeModal) {
                        closeWelcomeModal();
                    }
                });

                // Close with ESC key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && welcomeModal.style.display === 'flex') {
                        closeWelcomeModal();
                    }
                });

                function closeWelcomeModal() {
                    welcomeModal.style.opacity = '0';
                    setTimeout(() => {
                        welcomeModal.style.display = 'none';
                        welcomeModal.style.opacity = '1';
                        document.body.style.overflow = '';
                    }, 300);
                }
            }
        });
    </script>
@endpush
