<!-- Mobile Menu -->
<div class="mobile-menu">
    <div class="mobile-menu__close">
        <i class="fa-solid fa-xmark"></i>
    </div>
    <div class="mobile-menu__list">
        <a href="/" class="mobile-menu__item {{ request()->is('/') ? 'active' : '' }}">Trang chủ</a>
        <a href="{{ route('profile.deposit-card') }}" class="mobile-menu__item {{ request()->routeIs('profile.deposit-card') ? 'active' : '' }}">Nạp tiền</a>
        <a href="#" class="mobile-menu__item {{ request()->is('services*') ? 'active' : '' }}">Dịch vụ</a>
        <a href="#" class="mobile-menu__item {{ request()->is('nick-game*') ? 'active' : '' }}">Nick game</a>
        <a href="#" class="mobile-menu__item {{ request()->is('hack-game*') ? 'active' : '' }}">Tải hack game</a>
    </div>
    <div class="mobile-menu__actions">
        @guest
            <a href="{{ route('login') }}" class="text action__link">
                <i class="fa-solid fa-user"></i> Đăng nhập
            </a>
            <a href="{{ route('register') }}" class="text action__link action__link--primary">
                <i class="fa-solid fa-key"></i> Đăng ký
            </a>
        @else
            <a href="/profile" class="text action__link">
                <i class="fa-solid fa-user"></i> {{ Auth::user()->username }} - {{ number_format(Auth::user()->balance) }}đ
            </a>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="text action__link action__link--primary">
                    <i class="fa-solid fa-sign-out-alt"></i> Đăng xuất
                </button>
            </form>
        @endguest
    </div>
</div>
<div class="overlay"></div>