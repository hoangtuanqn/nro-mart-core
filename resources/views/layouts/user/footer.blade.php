{{-- /**
* Copyright (c) 2025 FPT University
*
* @author Phạm Hoàng Tuấn
* @email phamhoangtuanqn@gmail.com
* @facebook fb.com/phamhoangtuanqn
*/ --}}

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer__content">
            <div class="footer__column">
                <a href="/" class="footer__logo">
                    <img src="{{ config_get('site_logo_footer') }}" alt="{{ config_get('site_name') }}" height="40"
                        width="200">
                </a>
                <p class="footer__desc">
                    {{ config_get('site_description') }}
                </p>
                <div class="footer__social">
                    <a href="{{ config_get('facebook', '#') }}" class="social__link" target="_blank"><i
                            class="fab fa-facebook-f"></i></a>
                    <a href="{{ config_get('youtube', '#') }}" class="social__link" target="_blank"><i
                            class="fab fa-youtube"></i></a>
                    @if (config_get('telegram'))
                        <a href="{{ config_get('telegram', '#') }}" class="social__link" target="_blank"><i
                                class="fab fa-telegram"></i></a>
                    @endif
                    @if (config_get('discord'))
                        <a href="{{ config_get('discord') }}" class="social__link" target="_blank"><i
                                class="fab fa-discord"></i></a>
                    @endif
                    @if (config_get('tiktok'))
                        <a href="{{ config_get('tiktok') }}" class="social__link" target="_blank"><i
                                class="fab fa-tiktok"></i></a>
                    @endif
                </div>
            </div>
            <div class="footer__column">
                <h3 class="footer__title">Liên Kết Nhanh</h3>
                <ul class="footer__links">
                    <li><a href="{{ route('home') }}" class="footer__link">Trang Chủ</a></li>
                    <li><a href="{{ route('category.show-all') }}" class="footer__link">Mua Tài Khoản</a></li>
                    <li><a href="{{ route('service.show-all') }}" class="footer__link">Dịch Vụ Game</a></li>
                    <li><a href="{{ route('lucky.show-all') }}" class="footer__link">Vòng Quay May Mắn</a></li>
                </ul>
            </div>
            <div class="footer__column">
                <h3 class="footer__title">Hỗ Trợ Khách Hàng</h3>
                <ul class="footer__links">
                    <li><a href="#" class="footer__link">Hướng Dẫn Mua Hàng</a></li>
                    <li><a href="#" class="footer__link">Chính Sách Bảo Mật</a></li>
                    <li><a href="#" class="footer__link">Điều Khoản Sử Dụng</a></li>
                    <li><a href="#" class="footer__link">Liên Hệ</a></li>
                </ul>
            </div>
            <div class="footer__column">
                <h3 class="footer__title">Thông Tin Liên Hệ</h3>
                <ul class="footer__contact">
                    <li class="contact__item">
                        <i class="fas fa-phone-alt"></i>
                        <span>Hotline:
                            {{ preg_replace('/(\d{4})(\d{3})(\d{3})/', '$1.$2.$3', config_get('phone')) }}</span>
                    </li>
                    <li class="contact__item">
                        <i class="fas fa-envelope"></i>
                        <span>Email: {{ config_get('email') }}</span>
                    </li>
                    @if (config_get('zalo'))
                        <li class="contact__item">
                            <i class="fas fa-comment-dots"></i>
                            <span>Zalo: <a href="https://zalo.me/{{ config_get('zalo') }}"
                                    target="_blank">{{ preg_replace('/(\d{4})(\d{3})(\d{3})/', '$1.$2.$3', config_get('zalo')) }}</a></span>
                        </li>
                    @endif
                    <li class="contact__item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Địa chỉ: {{ config_get('address') }}</span>
                    </li>
                    <li class="contact__item">
                        <i class="fas fa-clock"></i>
                        <span>Giờ làm việc: {{ config_get('working_hours') }}</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="footer__bottom">
            <div class="footer__payment">
                <img src="{{ asset('assets/images/payment/amex.svg') }}" alt="American Express" class="payment__img">
                <img src="{{ asset('assets/images/payment/mastercard.svg') }}" alt="MasterCard" class="payment__img">
                <img src="{{ asset('assets/images/payment/paypal.svg') }}" alt="PayPal" class="payment__img">
                <img src="{{ asset('assets/images/payment/visa.svg') }}" alt="Visa" class="payment__img">
            </div>
            <div class="footer__copyright">
                &copy; {{ date('Y') }} - Bản quyền thuộc về <a href="/"
                    target="_blank">{{ strtoupper(request()->getHost()) }}</a> - Thiết kế bởi <a
                    href="https://tuanori.vn" target="_blank">TUANORI.VN</a>
            </div>
        </div>
    </div>
</footer>
