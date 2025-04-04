@extends('layouts.user.app')

@section('title', $title)

@section('content')
    <x-hero-header title="{{ $service->name }}" description="{{ $service->description }}" />

    <style>
        .service__discount-feedback {
            font-size: 14px;
            padding: 8px 12px;
            border-radius: var(--border-radius-sm);
            margin-top: 5px;
        }

        .service__discount-feedback--loading {
            background-color: rgba(0, 0, 0, 0.05);
            color: #666;
        }

        .service__discount-feedback--success {
            background-color: rgba(40, 167, 69, 0.1);
            color: #28a745;
            border-left: 3px solid #28a745;
        }

        .service__discount-feedback--error {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border-left: 3px solid #dc3545;
        }
    </style>

    <div class="service">
        <div class="container">
            <!-- Thông báo lỗi và thành công -->
            @if (session('error'))
                <div class="service__alert service__alert--error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session('error') }}</span>
                    <button type="button" class="service__alert-close">&times;</button>
                </div>
            @endif

            @if (session('success'))
                <div class="service__alert service__alert--success">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                    <button type="button" class="service__alert-close">&times;</button>
                </div>
            @endif

            @if ($errors->any())
                <div class="service__alert service__alert--error">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        <span>Đã có lỗi xảy ra:</span>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="service__alert-close">&times;</button>
                </div>
            @endif

            <!-- Thông tin dịch vụ -->
            <div class="service__info">
                <div class="service__cards">
                    <div class="service__card service__card--rules">
                        <div class="service__card-icon">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="service__card-content">
                            <h3 class="service__card-title">Quy định nhiệm vụ</h3>
                            <p>Giá nhiệm vụ cực rẻ...ae cứ thuê shop cần hết luôn...AE thuê xong cứ zo acc mà chơi ...nào
                                mạt
                                kết nối nhiều và liên tục thì đừng vào nữa ...thời gian làm tùy nhiệm vụ < từ 24 tiếng
                                    48tiếng>
                            </p>
                        </div>
                    </div>

                    <div class="service__card service__card--server">
                        <div class="service__card-icon">
                            <i class="fas fa-server"></i>
                        </div>
                        <div class="service__card-content">
                            <h3 class="service__card-title">Chọn Server</h3>
                            <p>Chọn sever để xem chi tiết bảng giá nhiệm vụ. Chúng tôi cung cấp dịch vụ trên tất cả các máy
                                chủ
                                của game Ngọc Rồng Online. Mỗi máy chủ sẽ có bảng giá riêng tùy theo độ khó của nhiệm vụ và
                                số
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
            </div>

            <!-- Bảng giá dịch vụ -->
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
                            @foreach ($service->packages as $index => $package)
                                <tr class="service__price-row" data-id="{{ $package->id }}"
                                    data-price="{{ $package->price }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $package->name }} ({{ $package->description }})</td>
                                    <td>{{ number_format($package->price, 0, ',', ',') }} VNĐ</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Form đặt dịch vụ -->
            <div class="service__form">
                <h3 class="service__form-title">Thông tin đặt dịch vụ</h3>

                <form action="{{ route('service.order', $service->slug) }}" method="POST">
                    @csrf
                    <input type="hidden" name="service_id" value="{{ $service->id }}">

                    <div class="service__form-row">
                        <div class="service__form-group">
                            <label for="server"><i class="fas fa-server"></i> Máy chủ</label>
                            <select id="server" name="server" class="service__form-control" required>
                                <option value="">Chọn Máy chủ</option>
                                @for ($i = 1; $i <= 13; $i++)
                                    <option value="{{ $i }}" {{ old('server') == $i ? 'selected' : '' }}>Server
                                        {{ $i }}</option>
                                @endfor
                            </select>
                            @error('server')
                                <div class="service__form-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="service__form-group">
                            <label for="package_id"><i class="fas fa-cogs"></i> Dịch vụ</label>
                            <select id="package_id" name="package_id" class="service__form-control" required>
                                <option value="">Vui lòng chọn</option>
                                @foreach ($service->packages as $package)
                                    <option value="{{ $package->id }}"
                                        {{ old('package_id') == $package->id ? 'selected' : '' }}
                                        data-price="{{ $package->price }}">
                                        {{ $package->name }} ({{ $package->description }})
                                    </option>
                                @endforeach
                            </select>
                            @error('package_id')
                                <div class="service__form-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="service__form-row">
                        <div class="service__form-group">
                            <label for="game_account"><i class="fas fa-user"></i> Tài khoản</label>
                            <input type="text" id="game_account" name="game_account" class="service__form-control"
                                value="{{ old('game_account') }}" placeholder="Tài khoản game" required>
                            @error('game_account')
                                <div class="service__form-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="service__form-group">
                            <label for="game_password"><i class="fas fa-lock"></i> Mật khẩu</label>
                            <input type="text" id="game_password" name="game_password" class="service__form-control"
                                value="{{ old('game_password') }}" placeholder="Mật khẩu game" required>
                            @error('game_password')
                                <div class="service__form-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="service__form-row">
                        <div class="service__form-group">
                            <label for="amount"><i class="fas fa-coins"></i> Tổng tiền</label>
                            <input type="text" id="amount" class="service__form-control" value="0" readonly>
                        </div>

                        <div class="service__form-group">
                            <label for="giftcode"><i class="fas fa-gift"></i> Mã giftcode</label>
                            <input type="text" id="giftcode" name="giftcode" class="service__form-control"
                                placeholder="Nhập mã nếu có" value="{{ old('giftcode') }}">
                            @error('giftcode')
                                <div class="service__form-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="service__form-actions">
                        @if (Auth::check())
                            <button type="submit" class="service__btn service__btn--primary service__btn--block">
                                <i class="fas fa-check-circle"></i> Thanh toán
                            </button>
                        @else
                            <a href="{{ route('login') }}"
                                class="service__btn service__btn--primary service__btn--block">
                                <i class="fas fa-sign-in-alt"></i> Đăng nhập để thanh toán
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Server selection
            const serverBtns = document.querySelectorAll('.service__server-btn');
            const serverSelect = document.getElementById('server');
            const packageSelect = document.getElementById('package_id');
            const amountInput = document.getElementById('amount');
            const giftcodeInput = document.getElementById('giftcode');

            // Add UI elements for discount feedback
            const amountContainer = amountInput.closest('.service__form-group');
            const discountFeedback = document.createElement('div');
            discountFeedback.className = 'service__discount-feedback';
            discountFeedback.style.display = 'none';
            amountContainer.appendChild(discountFeedback);

            // Track original price
            let originalPrice = 0;
            let discountedPrice = 0;

            // Server Buttons
            serverBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Update UI
                    serverBtns.forEach(b => b.classList.remove('service__server-btn--active'));
                    this.classList.add('service__server-btn--active');

                    // Update form select
                    const serverId = this.textContent.replace('Server', '').trim();
                    serverSelect.value = serverId;
                });
            });

            // Price table rows
            const priceRows = document.querySelectorAll('.service__price-row');

            // Highlight the row and update amount when package is selected
            function updateSelectedPackage() {
                // Remove highlight from all rows
                priceRows.forEach(row => row.classList.remove('service__price-row--selected'));

                if (packageSelect.value) {
                    // Find and highlight selected row
                    const selectedRow = document.querySelector(
                        `.service__price-row[data-id="${packageSelect.value}"]`);
                    if (selectedRow) {
                        selectedRow.classList.add('service__price-row--selected');
                        selectedRow.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });

                        // Update amount
                        originalPrice = parseInt(selectedRow.dataset.price);
                        discountedPrice = originalPrice;
                        amountInput.value = originalPrice.toLocaleString('vi-VN') + ' VNĐ';

                        // If giftcode has a value, validate it again
                        if (giftcodeInput.value) {
                            validateGiftcode();
                        } else {
                            // Hide discount feedback
                            discountFeedback.style.display = 'none';
                        }
                    }
                } else {
                    originalPrice = 0;
                    discountedPrice = 0;
                    amountInput.value = '0';
                    discountFeedback.style.display = 'none';
                }
            }

            // Function to validate giftcode and update price
            function validateGiftcode() {
                const giftcode = giftcodeInput.value.trim();

                if (!giftcode || !originalPrice || !packageSelect.value) {
                    discountFeedback.style.display = 'none';
                    return;
                }

                // Show loading state
                discountFeedback.textContent = 'Đang kiểm tra mã giảm giá...';
                discountFeedback.className = 'service__discount-feedback service__discount-feedback--loading';
                discountFeedback.style.display = 'block';

                // Call the validateCode endpoint
                fetch('/api/discount-codes/validate', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            code: giftcode,
                            context: 'service',
                            item_id: packageSelect.value
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update UI with discount info
                            discountFeedback.className =
                                'service__discount-feedback service__discount-feedback--success';
                            discountFeedback.innerHTML =
                                `Mã giảm giá hợp lệ! Tiết kiệm: ${data.data.savings.toLocaleString('vi-VN')} VNĐ`;

                            // Update amount
                            discountedPrice = data.data.discounted_price;
                            amountInput.value = discountedPrice.toLocaleString('vi-VN') + ' VNĐ';
                        } else {
                            // Show error
                            discountFeedback.className =
                                'service__discount-feedback service__discount-feedback--error';
                            discountFeedback.textContent = data.message || 'Mã giảm giá không hợp lệ';

                            // Reset to original price
                            discountedPrice = originalPrice;
                            amountInput.value = originalPrice.toLocaleString('vi-VN') + ' VNĐ';
                        }
                    })
                    .catch(error => {
                        console.error('Error validating discount code:', error);
                        discountFeedback.className =
                            'service__discount-feedback service__discount-feedback--error';
                        discountFeedback.textContent = 'Đã xảy ra lỗi khi kiểm tra mã giảm giá';

                        // Reset to original price
                        discountedPrice = originalPrice;
                        amountInput.value = originalPrice.toLocaleString('vi-VN') + ' VNĐ';
                    });
            }

            // Handle giftcode input
            giftcodeInput.addEventListener('blur', validateGiftcode);

            // Highlight selected service in price table
            packageSelect.addEventListener('change', updateSelectedPackage);

            // Make price rows clickable
            priceRows.forEach(row => {
                row.addEventListener('click', function() {
                    const serviceId = this.dataset.id;
                    packageSelect.value = serviceId;
                    updateSelectedPackage();
                });
            });

            // Initialize with selected values
            if (packageSelect.value) {
                updateSelectedPackage();
            }
        });
    </script>
@endpush
