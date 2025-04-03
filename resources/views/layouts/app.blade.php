<li class="nav-item">
    <a href="{{ route('profile.withdraw.create') }}"
        class="nav-link {{ request()->routeIs('profile.withdraw.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-money-bill-wave"></i>
        <p>Rút tiền</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('profile.withdrawal.history') }}"
        class="nav-link {{ request()->routeIs('profile.withdrawal.history') ? 'active' : '' }}">
        <i class="nav-icon fas fa-history"></i>
        <p>Lịch sử rút tiền</p>
    </a>
</li>
