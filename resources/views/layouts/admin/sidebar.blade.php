<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="{{ request()->routeIs('admin.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.index') }}"><img src="{{ asset('assets/img/icons/dashboard.svg') }}"
                            alt="img"><span>Dashboard</span></a>
                </li>

                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/product.svg') }}"
                            alt="img"><span>Danh mục</span><span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('admin.categories.index') }}"
                                class="{{ request()->routeIs('admin.categories.index') ? 'active' : '' }}">Danh sách
                                danh mục</a></li>
                        <li><a href="{{ route('admin.categories.create') }}"
                                class="{{ request()->routeIs('admin.categories.create') ? 'active' : '' }}">Thêm danh
                                mục mới</a></li>
                    </ul>
                </li>

                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/product.svg') }}"
                            alt="img"><span>Tài khoản</span><span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('admin.accounts.index') }}"
                                class="{{ request()->routeIs('admin.accounts.index') ? 'active' : '' }}">Danh sách tài
                                khoản</a></li>
                        <li><a href="{{ route('admin.accounts.create') }}"
                                class="{{ request()->routeIs('admin.accounts.create') ? 'active' : '' }}">Thêm tài
                                khoản mới</a></li>
                    </ul>
                </li>

                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/product.svg') }}"
                            alt="img"><span>Dịch vụ</span><span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('admin.services.index') }}"
                                class="{{ request()->routeIs('admin.services.index') ? 'active' : '' }}">Danh sách dịch
                                vụ</a></li>
                        <li><a href="{{ route('admin.services.create') }}"
                                class="{{ request()->routeIs('admin.services.create') ? 'active' : '' }}">Thêm dịch vụ
                                mới</a></li>
                    </ul>
                </li>

                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/product.svg') }}"
                            alt="img"><span>Gói dịch vụ</span><span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('admin.packages.index') }}"
                                class="{{ request()->routeIs('admin.packages.index') ? 'active' : '' }}">Danh sách gói
                                dịch vụ</a></li>
                        <li><a href="{{ route('admin.packages.create') }}"
                                class="{{ request()->routeIs('admin.packages.create') ? 'active' : '' }}">Thêm gói dịch
                                vụ mới</a></li>
                    </ul>
                </li>

                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/users1.svg') }}"
                            alt="img"><span>Người dùng</span><span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('admin.users.index') }}"
                                class="{{ request()->routeIs('admin.users.index') ? 'active' : '' }}">Danh sách người
                                dùng</a></li>
                    </ul>
                </li>

                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/dollar-square.svg') }}"
                            alt="img"><span>Ngân hàng</span><span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('admin.bank-accounts.index') }}"
                                class="{{ request()->routeIs('admin.bank-accounts.index') ? 'active' : '' }}">Danh sách
                                tài khoản</a></li>
                        <li><a href="{{ route('admin.bank-accounts.create') }}"
                                class="{{ request()->routeIs('admin.bank-accounts.create') ? 'active' : '' }}">Thêm tài
                                khoản mới</a></li>
                    </ul>
                </li>


                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/product.svg') }}"
                            alt="img"><span>Danh mục Random</span><span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('admin.random-categories.index') }}"
                                class="{{ request()->routeIs('admin.random-categories.index') ? 'active' : '' }}">Danh
                                sách danh mục random</a></li>
                        <li><a href="{{ route('admin.random-categories.create') }}"
                                class="{{ request()->routeIs('admin.random-categories.create') ? 'active' : '' }}">Thêm
                                danh mục random</a></li>
                    </ul>
                </li>

                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/product.svg') }}"
                            alt="img"><span>Tài khoản Random</span><span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('admin.random-accounts.index') }}"
                                class="{{ request()->routeIs('admin.random-accounts.index') ? 'active' : '' }}">Danh
                                sách tài khoản random</a></li>
                        <li><a href="{{ route('admin.random-accounts.create') }}"
                                class="{{ request()->routeIs('admin.random-accounts.create') ? 'active' : '' }}">Thêm
                                tài khoản random</a></li>
                    </ul>
                </li>

                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/product.svg') }}"
                            alt="img"><span>Vòng quay may mắn</span><span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('admin.lucky-wheels.index') }}"
                                class="{{ request()->routeIs('admin.lucky-wheels.index') ? 'active' : '' }}">Danh
                                sách VQMM</a></li>
                        <li><a href="{{ route('admin.lucky-wheels.create') }}"
                                class="{{ request()->routeIs('admin.lucky-wheels.create') ? 'active' : '' }}">Thêm
                                VQMM</a>
                        </li>
                        <li><a href="{{ route('admin.lucky-wheels.history') }}"
                                class="{{ request()->routeIs('admin.lucky-wheels.history') ? 'active' : '' }}">Lịch sử
                                quay</a></li>
                    </ul>
                </li>

                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/sales1.svg') }}"
                            alt="img"><span>Mã giảm giá</span><span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('admin.discount-codes.index') }}"
                                class="{{ request()->routeIs('admin.discount-codes.index') ? 'active' : '' }}">Danh
                                sách mã giảm giá</a></li>
                        <li><a href="{{ route('admin.discount-codes.create') }}"
                                class="{{ request()->routeIs('admin.discount-codes.create') ? 'active' : '' }}">Thêm mã
                                giảm giá</a></li>
                    </ul>
                </li>

                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/time.svg') }}"
                            alt="img"><span>Lịch sử</span><span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('admin.history.transactions') }}"
                                class="{{ request()->routeIs('admin.history.transactions') ? 'active' : '' }}">Lịch sử
                                giao dịch</a></li>
                        <li><a href="{{ route('admin.history.accounts') }}"
                                class="{{ request()->routeIs('admin.history.accounts') ? 'active' : '' }}">Lịch sử mua
                                tài khoản</a></li>
                        <li><a href="{{ route('admin.history.random-accounts') }}"
                                class="{{ request()->routeIs('admin.history.random-accounts') ? 'active' : '' }}">Lịch
                                sử mua random</a></li>
                        <li><a href="{{ route('admin.history.services') }}"
                                class="{{ request()->routeIs('admin.history.services') ? 'active' : '' }}">Lịch sử đặt
                                dịch vụ</a></li>
                        <li><a href="{{ route('admin.history.deposits.bank') }}"
                                class="{{ request()->routeIs('admin.history.deposits.bank') ? 'active' : '' }}">Lịch
                                sử nạp tiền ngân hàng</a></li>
                        <li><a href="{{ route('admin.withdrawals.index') }}"
                                class="{{ request()->routeIs('admin.withdrawals.index') ? 'active' : '' }}">Lịch
                                sử rút tiền</a></li>
                        <li><a href="{{ route('admin.withdrawals.resources.index') }}"
                                class="{{ request()->routeIs('admin.withdrawals.resources.index') ? 'active' : '' }}">Lịch
                                sử rút vàng/ngọc</a></li>
                        <li><a href="{{ route('admin.history.deposits.card') }}"
                                class="{{ request()->routeIs('admin.history.deposits.card') ? 'active' : '' }}">Lịch
                                sử nạp thẻ cào</a></li>
                        <li><a href="{{ route('admin.history.discount-usages') }}"
                                class="{{ request()->routeIs('admin.history.discount-usages') ? 'active' : '' }}">Lịch
                                sử dùng mã giảm giá</a></li>
                    </ul>
                </li>

                <li class="submenu">
                    <a href="javascript:void(0);"><i data-feather="settings"></i><span>Cài đặt hệ thống</span><span
                            class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ route('admin.settings.general') }}"
                                class="{{ request()->routeIs('admin.settings.general') ? 'active' : '' }}">Cài đặt
                                chung</a></li>
                        <li><a href="{{ route('admin.settings.social') }}"
                                class="{{ request()->routeIs('admin.settings.social') ? 'active' : '' }}">Mạng xã hội
                                & Thông báo</a></li>
                        <li><a href="{{ route('admin.settings.email') }}"
                                class="{{ request()->routeIs('admin.settings.email') ? 'active' : '' }}">Cài đặt
                                email</a></li>
                        <li><a href="{{ route('admin.settings.payment') }}"
                                class="{{ request()->routeIs('admin.settings.payment') ? 'active' : '' }}">Cài đặt
                                nạp thẻ</a></li>
                        <li><a href="{{ route('admin.settings.login') }}"
                                class="{{ request()->routeIs('admin.settings.login') ? 'active' : '' }}">Cài đặt
                                đăng nhập</a></li>
                        <li><a href="{{ route('admin.settings.notifications') }}"
                                class="{{ request()->routeIs('admin.settings.notifications') ? 'active' : '' }}">Quản
                                lý thông báo</a></li>
                    </ul>
                </li>

                <hr>
                <li>

                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><img src="{{ asset('assets/img/icons/support.svg') }}"
                            alt="img"><span>Hỗ trợ sự cố</span><span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="{{ ENV('FACEBOOK_URL_AUTHOR') }}" target="_blank" class="">Facebook</a>
                        </li>
                        <li><a href="{{ ENV('FANPAGE_URL_AUTHOR') }}" target="_blank" class="">Fanpage</a>
                        </li>
                        <li><a href="{{ ENV('ZALO_URL_AUTHOR') }}" target="_blank" class="">Zalo</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</div>
