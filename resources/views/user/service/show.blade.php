@extends('layouts.user.app')

@section('title', 'Làm Nhiệm Vụ - Ngọc Rồng')

@section('content')
    <x-hero-header title="{{ $service->name }}" description="{{ $service->description }}" />
    <div class="service">
        <div class="container">

            <div class="service__cards">
                <div class="service__card service__card--rules">
                    <div class="service__card-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="service__card-content">
                        <h3 class="service__card-title">Quy định nhiệm vụ</h3>
                        <p>Giá nhiệm vụ cực rẻ...ae cứ thuê shop cần hết luôn...AE thuê xong cứ zo acc mà chơi ...nào mạt
                            kết
                            nối nhiều và liên tục thì đừng vào nữa ...thời gian làm tùy nhiệm vụ < từ 24 tiếng 48tiếng>
                        </p>
                    </div>
                </div>

                <div class="service__card service__card--server">
                    <div class="service__card-icon">
                        <i class="fas fa-server"></i>
                    </div>
                    <div class="service__card-content">
                        <h3 class="service__card-title">Chọn Server</h3>
                        <p>Chọn sever để xem chi tiết bảng giá nhiệm vụ. Chúng tôi cung cấp dịch vụ trên tất cả các máy chủ
                            của game Ngọc Rồng Online. Mỗi máy chủ sẽ có bảng giá riêng tùy theo độ khó của nhiệm vụ và số
                            lượng người chơi. Vui lòng chọn máy chủ phù hợp để xem bảng giá chi tiết và đặt dịch vụ.</p>


                    </div>
                </div>

                <div class="service__card service__card--contact">
                    <div class="service__card-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div class="service__card-content">
                        <h3 class="service__card-title">Liên hệ thuê nhiệm vụ</h3>
                        <div class="service__contact-info">
                            <div class="service__contact-item">
                                <i class="fab fa-facebook"></i>
                                <a href="https://facebook.com/octiiu957.official/"
                                    target="_blank">facebook.com/octiiu957.official/</a>
                            </div>
                            <div class="service__contact-item">
                                <i class="fab fa-whatsapp"></i>
                                <a href="tel:0396498015">ZALO: 0396498015</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="service__form">
                <h3 class="service__form-title">Thông tin</h3>

                <div class="service__form-row">
                    <div class="service__form-group">
                        <label for="server"><i class="fas fa-server"></i> Máy chủ</label>
                        <select id="server" class="service__form-control">
                            <option value="">Chọn Máy chủ</option>
                            <option value="1">Server 1</option>
                            <option value="2">Server 2</option>
                            <option value="3">Server 3</option>
                        </select>
                    </div>

                    <div class="service__form-group">
                        <label for="service"><i class="fas fa-cogs"></i> Dịch vụ</label>
                        <select id="service" class="service__form-control">
                            <option value="">Vui lòng chọn</option>
                        </select>
                    </div>
                </div>

                <div class="service__form-row">
                    <div class="service__form-group">
                        <label for="username"><i class="fas fa-user"></i> Tài khoản</label>
                        <input type="text" id="username" class="service__form-control" value=""
                            placeholder="Tài khoản game">
                    </div>

                    <div class="service__form-group">
                        <label for="password"><i class="fas fa-lock"></i> Mật khẩu</label>
                        <input type="password" id="password" class="service__form-control" value=""
                            placeholder="Mật khẩu game">
                    </div>
                </div>

                <div class="service__form-row">
                    <div class="service__form-group">
                        <label for="amount"><i class="fas fa-coins"></i> Tổng tiền</label>
                        <input type="text" id="amount" class="service__form-control" value="0" readonly>
                    </div>

                    <div class="service__form-group">
                        <label for="giftcode"><i class="fas fa-gift"></i> Mã giftcode</label>
                        <input type="text" id="giftcode" class="service__form-control" placeholder="Nhập mã nếu có">
                    </div>
                </div>

                <div class="service__form-actions">
                    @if (Auth::check())
                        <button type="submit" class="service__btn service__btn--primary service__btn--block">
                            Thanh toán
                        </button>
                    @else
                        <button type="submit" class="service__btn service__btn--primary service__btn--block">
                            <i class="fas fa-sign-in-alt"></i> Đăng nhập để thanh toán
                        </button>
                    @endif
                </div>
            </div>

            <div class="service__price-section">
                <h2 class="service__price-title">BẢNG GIÁ DỊCH VỤ</h2>
                <div class="service__price-container">
                    <table class="service__price-table">
                        <thead>
                            <tr>
                                <th class="service__price-col--id">#</th>
                                <th class="service__price-col--package">Gói thanh toán</th>
                                <th class="service__price-col--price">Giá tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($service->packages as $index => $package)
                                <tr class="service__price-row" data-id="{{ $package->id }}" data-price="{{ $package->price }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $package->name }} ({{ $package->description }})</td>
                                    <td>{{ number_format($package->price, 0, ',', ',') }} VNĐ</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>



        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Server selection
            const serverBtns = document.querySelectorAll('.service__server-btn');
            serverBtns.forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    serverBtns.forEach(b => b.classList.remove('service__server-btn--active'));
                    this.classList.add('service__server-btn--active');
                    // Could update server dropdown here
                });
            });

            // Price table rows
            const priceRows = document.querySelectorAll('.service__price-row');
            const serviceSelect = document.getElementById('service');
            const amountInput = document.getElementById('amount');

            // Initialize service dropdown
            function initServiceOptions() {
                // Clear existing options except default
                while (serviceSelect.options.length > 1) {
                    serviceSelect.remove(1);
                }

                // Add options from price table
                priceRows.forEach(row => {
                    const serviceId = row.dataset.id;
                    const servicePrice = row.dataset.price;
                    const serviceText = row.cells[1].textContent;

                    const option = document.createElement('option');
                    option.value = serviceId;
                    option.dataset.price = servicePrice;
                    option.textContent = serviceText;

                    serviceSelect.appendChild(option);
                });
            }

            // Highlight selected service in price table
            serviceSelect.addEventListener('change', function () {
                // Remove highlight from all rows
                priceRows.forEach(row => row.classList.remove('service__price-row--selected'));

                if (this.value) {
                    // Find and highlight selected row
                    const selectedRow = document.querySelector(
                        `.service__price-row[data-id="${this.value}"]`);
                    if (selectedRow) {
                        selectedRow.classList.add('service__price-row--selected');
                        selectedRow.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });

                        // Update amount
                        const price = selectedRow.dataset.price;
                        amountInput.value = parseInt(price).toLocaleString('vi-VN') + ' VNĐ';
                    }
                } else {
                    amountInput.value = '0';
                }
            });

            // Make price rows clickable
            priceRows.forEach(row => {
                row.addEventListener('click', function () {
                    const serviceId = this.dataset.id;
                    serviceSelect.value = serviceId;
                    serviceSelect.dispatchEvent(new Event('change'));
                });
            });

            // Initialize
            initServiceOptions();
        });
    </script>
@endpush