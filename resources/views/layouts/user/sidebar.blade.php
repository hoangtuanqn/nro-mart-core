{{-- /**
* Copyright (c) 2025 FPT University
*
* @author Phạm Hoàng Tuấn
* @email phamhoangtuanqn@gmail.com
* @facebook fb.com/phamhoangtuanqn
*/ --}}

<div class="profile-sidebar">
    <div class="sidebar-header">
        <h2 class="sidebar-title">MENU TÀI KHOẢN</h2>
    </div>
    <ul class="sidebar-menu">
        <li class="sidebar-item {{ request()->routeIs('profile.index') ? 'active' : '' }}">
            <a href="{{ route('profile.index') }}" class="sidebar-link">
                <i class="fa-solid fa-user"></i> Thông tin tài khoản
            </a>
        </li>
        @if (config_get('payment.card.active', true))
            <li class="sidebar-item {{ request()->routeIs('profile.deposit-card') ? 'active' : '' }}">
                <a href="{{ route('profile.deposit-card') }}" class="sidebar-link">
                    <i class="fa-solid fa-credit-card"></i> Nạp tiền thẻ cào
                </a>
            </li>
        @endif
        <li class="sidebar-item {{ request()->routeIs('profile.deposit-atm') ? 'active' : '' }}">
            <a href="{{ route('profile.deposit-atm') }}" class="sidebar-link">
                <i class="fa-solid fa-money-bill-transfer"></i> Nạp tiền ATM
            </a>
        </li>
        <li class="sidebar-item {{ request()->routeIs('profile.transaction-history') ? 'active' : '' }}">
            <a href="{{ route('profile.transaction-history') }}" class="sidebar-link">
                <i class="fa-solid fa-chart-line"></i> Biến động số dư
            </a>
        </li>
        <li class="sidebar-item {{ request()->routeIs('profile.withdraw.*') ? 'active' : '' }}">
            <a href="{{ route('profile.withdraw.create') }}" class="sidebar-link">
                <i class="fa-solid fa-money-bill-wave"></i> Rút tiền
            </a>
        </li>
        <li class="sidebar-item {{ request()->routeIs('profile.withdraw-gold') ? 'active' : '' }}">
            <a href="{{ route('profile.withdraw-gold') }}" class="sidebar-link">
                <i class="fa-solid fa-coins"></i> Rút vàng
            </a>
        </li>
        <li class="sidebar-item {{ request()->routeIs('profile.withdraw-gem') ? 'active' : '' }}">
            <a href="{{ route('profile.withdraw-gem') }}" class="sidebar-link">
                <i class="fa-solid fa-gem"></i> Rút ngọc
            </a>
        </li>
    </ul>

    <div class="sidebar-header mt-4">
        <h2 class="sidebar-title">MENU GIAO DỊCH</h2>
    </div>
    <ul class="sidebar-menu">
        <li class="sidebar-item {{ request()->routeIs('profile.wheels-history') ? 'active' : '' }}">
            <a href="{{ route('profile.wheels-history') }}" class="sidebar-link">
                <i class="fa-solid fa-clock-rotate-left"></i> Lịch sử vòng quay
            </a>
        </li>
        <li class="sidebar-item {{ request()->routeIs('profile.purchased-accounts') ? 'active' : '' }}">
            <a href="{{ route('profile.purchased-accounts') }}" class="sidebar-link">
                <i class="fa-solid fa-box"></i> Tài khoản đã mua
            </a>
        </li>
        <li class="sidebar-item {{ request()->routeIs('profile.purchased-random-accounts') ? 'active' : '' }}">
            <a href="{{ route('profile.purchased-random-accounts') }}" class="sidebar-link">
                <i class="fa-solid fa-dice"></i> Random đã mua
            </a>
        </li>
        {{--
            Chưa phát triển
        <li class="sidebar-item">
            <a href="#" class="sidebar-link">
                <i class="fa-solid fa-money-bill"></i> Tài khoản trả góp
            </a>
        </li> --}}
        <li class="sidebar-item {{ request()->routeIs('profile.services-history') ? 'active' : '' }}">
            <a href="{{ route('profile.services-history') }}" class="sidebar-link">
                <i class="fa-solid fa-clipboard-list"></i> Dịch vụ đã thuê
            </a>
        </li>
    </ul>
</div>
