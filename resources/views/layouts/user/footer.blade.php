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
                    <img src="https://acc957.com/upload-usr/images/logo.png" alt="Logo" height="50">
                </a>
                <p class="footer__desc">
                    Shop Ngọc Rồng Online cung cấp tài khoản game chính hãng, giá tốt nhất thị trường.
                    Giao dịch an toàn, nhanh chóng và bảo mật.
                </p>
                <div class="footer__social">
                    <a href="#" class="social__link"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social__link"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="social__link"><i class="fab fa-telegram"></i></a>
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
                        <span>Hotline: 0123.456.789</span>
                    </li>
                    <li class="contact__item">
                        <i class="fas fa-envelope"></i>
                        <span>Email: support@tuanori.vn</span>
                    </li>
                    <li class="contact__item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Địa chỉ: TPHCM, Việt Nam</span>
                    </li>
                    <li class="contact__item">
                        <i class="fas fa-clock"></i>
                        <span>Giờ làm việc: 8:00 - 22:00</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="footer__bottom">
            <div class="footer__payment">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/1024px-Visa_Inc._logo.svg.png"
                    alt="Visa" class="payment__img">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/1280px-Mastercard-logo.svg.png"
                    alt="MasterCard" class="payment__img">
                <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="PayPal"
                    class="payment__img">
                <img src="https://cdn.haitrieu.com/wp-content/uploads/2022/02/Logo-MoMo-Square.png" alt="MoMo"
                    class="payment__img">
            </div>
            <div class="footer__copyright">
                &copy; {{ date('Y') }} - Bản quyền thuộc về <a href="https://tuanori.vn"
                    target="_blank">TUANORI.VN</a> - Thiết kế bởi <a href="https://tuanori.vn"
                    target="_blank">TUANORI.VN</a>
            </div>
        </div>
    </div>
</footer>
