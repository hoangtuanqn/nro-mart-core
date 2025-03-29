@extends('layouts.user.app')

@section('title', $category->name)

@section('content')
    <!-- Hero Section -->
    <section class="hero hero--small">
        <div class="container">
            <div class="hero__content">
                <h1 class="hero__title">{{ $category->name }}</h1>
                <p class="hero__desc">{!! $category->description !!}</p>
            </div>
        </div>
    </section>

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
                            <img src="{{ $account->thumbnail }}" alt="Account Preview" class="account-img">
                            <div class="account-code">Mã số: {{ $account->id }}</div>
                            <div class="account-price-top">ATM/VÍ ĐIỆN TỬ: {{ number_format($account->price) }} VND</div>
                        </div>

                        <div class="account-info">
                            <div class="account-row">
                                <div class="info-item">
                                    <span class="info-label">Máy chủ:</span>
                                    <span class="info-value">Server {{ $account->server }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Hành tinh:</span>
                                    <span class="info-value">{{ $account->planet }}</span>
                                </div>
                            </div>
                            <div class="account-row">
                                <div class="info-item">
                                    <span class="info-label">Đăng ký:</span>
                                    <span class="info-value">{{ $account->registration_type }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Thành viên:</span>
                                    <span class="info-value">{{ $account->member_type }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="account-actions">
                            <div class="card-price">TIỀN CARD: {{ number_format($account->card_price) }} VND</div>
                            {{-- {{ route('account.detail', $account->id) }} --}}
                            <a href="" class="action-btn action-btn--detail">Chi tiết</a>
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
