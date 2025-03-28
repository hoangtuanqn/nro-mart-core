<!-- Announcement -->
<header class="announcement">
    <div class="container row">
        <div class="announcement__media">
            <a class="media__facebook" href="#"><i class="fa-brands fa-facebook"></i></a>
            <a class="media__youtube" href="#"><i class="fa-brands fa-youtube"></i></a>
        </div>
        <div class="announcement__hotline">Hotline: <a href="tel:0396498015">0396498015</a> (8h - 22h)</div>
    </div>
</header>

<!-- Nav -->
<nav class="nav">
    <div class="container row">
        <a href="/">
            <img src="https://acc957.com/upload-usr/images/logo.png" alt="Logo Game" class="nav__logo" />
        </a>
        <div class="nav__menu">
            <a href="#" class="text menu__item">Trang chủ</a>
            <a href="#" class="text menu__item">Nạp tiền</a>
            <a href="#" class="text menu__item">Dịch vụ</a>
            <a href="#" class="text menu__item">Nick game</a>
            <a href="#" class="text menu__item">Tải hack game</a>
        </div>
        <div class="mobile-menu-toggle">
            <i class="fa-solid fa-bars"></i>
        </div>
        <div class="nav__action">
            @guest
                <a href="{{ route('login') }}" class="text action__link"><i class="fa-solid fa-user"></i> Đăng nhập</a>
                <a href="{{ route('register') }}" class="text action__link action__link--primary"><i
                        class="fa-solid fa-key"></i> Đăng ký</a>
            @else
                <a href="#" class="text action__link"><i class="fa-solid fa-user"></i> {{ Auth::user()->username }} -
                    {{ number_format(Auth::user()->balance) }}đ</a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="text action__link action__link--primary">
                        <i class="fa-solid fa-sign-out-alt"></i> Đăng xuất
                    </button>
                </form>
            @endguest
        </div>
    </div>
</nav>