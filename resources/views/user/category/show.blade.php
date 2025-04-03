{{-- /**
* Copyright (c) 2025 FPT University
*
* @author Phạm Hoàng Tuấn
* @email phamhoangtuanqn@gmail.com
* @facebook fb.com/phamhoangtuanqn
*/ --}}

@extends('layouts.user.app')

@section('title', $category->name)

@section('content')
    <!-- Hero Section -->
    <x-hero-header title="{{ $category->name }}" description="{{ $category->description }}" />

    <!-- Account List Section -->
    <section class="account-section">
        <div class="container">
            <!-- Filter Bar -->
            <form action="" method="GET" class="account-filter">
                <div class="account-filter__row">
                    <div class="account-filter__group">
                        <label for="code" class="account-filter__label">Mã Số:</label>
                        <input type="text" id="code" name="code" class="account-filter__input"
                            placeholder="Nhập Mã Số" value="{{ request('code') }}">
                    </div>

                    <div class="account-filter__group">
                        <label for="price_range" class="account-filter__label">Giá:</label>
                        <select id="price_range" name="price_range"
                            class="account-filter__input account-filter__input--select">
                            <option value="">Tất cả</option>
                            <option value="0-50000" {{ request('price_range') == '0-50000' ? 'selected' : '' }}>Dưới 50K
                            </option>
                            <option value="50000-200000" {{ request('price_range') == '50000-200000' ? 'selected' : '' }}>
                                50K
                                - 200K</option>
                            <option value="200000-500000" {{ request('price_range') == '200000-500000' ? 'selected' : '' }}>
                                200K - 500K</option>
                            <option value="500000-1000000"
                                {{ request('price_range') == '500000-1000000' ? 'selected' : '' }}>
                                500K - 1M</option>
                            <option value="1000000" {{ request('price_range') == '1000000' ? 'selected' : '' }}>Trên 1M
                            </option>
                        </select>
                    </div>

                    <div class="account-filter__group">
                        <label for="status" class="account-filter__label">Trạng thái:</label>
                        <select id="status" name="status" class="account-filter__input account-filter__input--select">
                            <option value="">Trạng Thái</option>
                            <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Chưa bán
                            </option>
                            <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Đã bán</option>
                        </select>
                    </div>
                </div>

                <div class="account-filter__row">
                    <div class="account-filter__group">
                        <label for="planet" class="account-filter__label">Hành tinh:</label>
                        <select id="planet" name="planet" class="account-filter__input account-filter__input--select">
                            <option value="">Hành tinh</option>
                            <option value="earth" {{ request('planet') == 'earth' ? 'selected' : '' }}>Trái Đất</option>
                            <option value="namek" {{ request('planet') == 'namek' ? 'selected' : '' }}>Namek</option>
                            <option value="xayda" {{ request('planet') == 'xayda' ? 'selected' : '' }}>Xayda</option>
                        </select>
                    </div>

                    <div class="account-filter__group">
                        <label for="registration" class="account-filter__label">Đăng ký:</label>
                        <select id="registration" name="registration"
                            class="account-filter__input account-filter__input--select">
                            <option value="">Đăng ký</option>
                            <option value="virtual" {{ request('registration') == 'virtual' ? 'selected' : '' }}>Ảo
                            </option>
                            <option value="real" {{ request('registration') == 'real' ? 'selected' : '' }}>Thật</option>
                        </select>
                    </div>

                    <div class="account-filter__group">
                        <label for="server" class="account-filter__label">Máy chủ:</label>
                        <select id="server" name="server" class="account-filter__input account-filter__input--select">
                            <option value="">Máy chủ</option>
                            @for ($i = 1; $i <= 13; $i++)
                                <option value="{{ $i }}" {{ request('server') == $i ? 'selected' : '' }}>Server
                                    {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="account-filter__actions">
                    <button type="submit" class="account-filter__button account-filter__button--primary">
                        <i class="fa-solid fa-filter"></i> TÌM KIẾM
                    </button>
                    <a href="{{ request()->url() }}" class="account-filter__button account-filter__button--outline">
                        <i class="fa-solid fa-rotate"></i> ĐẶT LẠI
                    </a>
                </div>
            </form>

            <!-- Account Grid -->
            <div class="account-grid">
                @forelse($accounts as $account)
                    <div class="account-card">
                        <div class="account-media">
                            <a href="{{ route('account.show', ['id' => $account->id]) }}">
                                <img src="{{ $account->thumb }}" alt="Account Preview" class="account-img">
                            </a>
                            <div class="account-code">Mã số: {{ $account->id }}</div>
                            <div class="account-price-top">ATM/VÍ ĐIỆN TỬ: {{ number_format($account->price) }} VND</div>
                        </div>

                        <div class="account-info">
                            <div class="account-row">
                                <div class="info-item">
                                    <span class="info-item__title">Máy chủ:</span>
                                    <span class="info-value">Server {{ $account->server }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-item__title">Hành tinh:</span>
                                    <span class="info-value">{{ display_hanh_tinh($account->planet) }}</span>
                                </div>
                            </div>
                            <div class="account-row">
                                <div class="info-item">
                                    <span class="info-item__title">Đăng ký:</span>
                                    <span class="info-value">{{ display_dang_ky($account->registration_type) }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-item__title">Bông tai:</span>
                                    <span class="info-value">{{ $account->earring ? 'Có' : 'Không' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="account-actions">
                            <div class="card-price">CARD:
                                {{ number_format($account->price / ((100 - config_get('payment.card.discount_percent')) / 100)) }}
                                Đ</div>
                            <a href="{{ route('account.show', ['id' => $account->id]) }}"
                                class="action-btn action-btn--detail">XEM CHI TIẾT</a>
                        </div>
                    </div>
                @empty
                    <div class="no-data">
                        <p class="no-data-text">Không có tài khoản nào</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            {{-- {{ $accounts->links() }} --}}
        </div>
    </section>
@endsection
