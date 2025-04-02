{{-- /**
* Copyright (c) 2025 FPT University
*
* @author Phạm Hoàng Tuấn
* @email phamhoangtuanqn@gmail.com
* @facebook fb.com/phamhoangtuanqn
*/ --}}

@extends('layouts.user.app')
@section('title', 'Vòng Quay May Mắn')
@section('content')
    <div class="container">
        <div class="lucky-wheel-container">
            <div class="wheel-page">
                <div class="wheel-info">
                    <h1 class="wheel-title">Vòng Quay Ngọc Rồng</h1>
                    <p class="wheel-description">Hãy thử vận may của bạn với vòng quay Ngọc Rồng siêu đẳng cấp. Cơ hội nhận
                        tài khoản VIP và nhiều phần thưởng hấp dẫn khác.</p>
                    <div class="wheel-price">
                        Giá: <span>30,000 VNĐ</span> / lượt quay
                    </div>
                    <div class="wheel-controls">
                        <div class="spin-count">
                            <button class="spin-count-btn" id="decrease-btn">-</button>
                            <input type="number" class="spin-count-input" value="1" min="1" max="10"
                                id="spin-count">
                            <button class="spin-count-btn" id="increase-btn">+</button>
                        </div>
                        <button class="wheel-spin-btn" id="spin-btn">
                            <i class="fas fa-sync-alt"></i> Quay Ngay
                        </button>
                    </div>
                </div>
                <div class="wheel-canvas-container">
                    <canvas id="wheel-canvas" class="wheel-canvas"></canvas>
                    <div class="wheel-pointer">
                        <i class="fas fa-location-arrow"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- History Section -->
        <section class="history-section">
            <h2 class="history-title">Lịch Sử Quay</h2>
            @if (count($history) > 0)
                <div class="history-table-container">
                    <table class="history-table">
                        <thead>
                            <tr>
                                <th>Thời gian</th>
                                <th>Số lượt</th>
                                <th>Tổng tiền</th>
                                <th>Phần thưởng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($history as $item)
                                <tr>
                                    <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $item->spin_count }}</td>
                                    <td>{{ number_format($item->total_cost) }} VNĐ</td>
                                    <td class="history-item-reward">{{ $item->description }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="no-history">
                    <p>Bạn chưa có lịch sử quay nào. Hãy thử vận may của mình!</p>
                </div>
            @endif
        </section>

        <!-- Rules Section -->
        <section class="rules-section">
            <h2 class="rules-title">Thể lệ & Quy định</h2>
            <div class="rules-content">
                <ul class="rules-list">
                    <li>Mỗi lượt quay có giá 30,000 VNĐ.</li>
                    <li>Bạn có thể quay tối đa 10 lượt một lần.</li>
                    <li>Phần thưởng sẽ được cộng vào tài khoản của bạn ngay sau khi quay.</li>
                    <li>Trường hợp phần thưởng là tài khoản VIP, thông tin sẽ được gửi qua mục tài khoản đã mua.</li>
                    <li>Tỷ lệ trúng các phần thưởng được công bố rõ ràng trên vòng quay.</li>
                    <li>Admin có quyền thay đổi cơ cấu phần thưởng mà không cần báo trước.</li>
                    <li>Trong trường hợp gặp sự cố, vui lòng liên hệ Fanpage hoặc số điện thoại hỗ trợ.</li>
                </ul>
            </div>
        </section>
    </div>

    <!-- Result Modal -->
    <div class="result-modal" id="result-modal">
        <div class="modal-content">
            <button class="modal-close" id="modal-close"><i class="fas fa-times"></i></button>
            <div class="result-icon">
                <i class="fas fa-gift"></i>
            </div>
            <h3 class="result-title">Chúc mừng!</h3>
            <p class="result-desc">Bạn đã quay trúng phần thưởng:</p>
            <div class="result-reward" id="result-reward">Tài khoản VIP</div>
            <button class="btn btn--primary" id="continue-btn">Tiếp tục</button>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Canvas setup
            const canvas = document.getElementById('wheel-canvas');
            const ctx = canvas.getContext('2d');
            const wheelItems = [{
                    color: '#7F5AF0',
                    label: 'Tài khoản VIP',
                    probability: 5
                },
                {
                    color: '#FF5277',
                    label: '50,000 VNĐ',
                    probability: 10
                },
                {
                    color: '#16CFBC',
                    label: '20,000 VNĐ',
                    probability: 15
                },
                {
                    color: '#FFD166',
                    label: '10,000 VNĐ',
                    probability: 20
                },
                {
                    color: '#4F9BF4',
                    label: '5,000 VNĐ',
                    probability: 25
                },
                {
                    color: '#B84F9E',
                    label: 'Chúc may mắn',
                    probability: 25
                }
            ];

            // Set canvas dimensions
            function setCanvasDimensions() {
                const container = document.querySelector('.wheel-canvas-container');
                const size = container.offsetWidth;
                canvas.width = size;
                canvas.height = size;
                drawWheel();
            }

            // Draw the wheel
            function drawWheel() {
                const centerX = canvas.width / 2;
                const centerY = canvas.height / 2;
                const radius = Math.min(centerX, centerY) * 0.9;

                ctx.clearRect(0, 0, canvas.width, canvas.height);

                const totalItems = wheelItems.length;
                const arcAngle = (2 * Math.PI) / totalItems;

                for (let i = 0; i < totalItems; i++) {
                    const startAngle = i * arcAngle;
                    const endAngle = (i + 1) * arcAngle;

                    // Draw segment
                    ctx.beginPath();
                    ctx.moveTo(centerX, centerY);
                    ctx.arc(centerX, centerY, radius, startAngle, endAngle);
                    ctx.closePath();
                    ctx.fillStyle = wheelItems[i].color;
                    ctx.fill();

                    // Draw label
                    ctx.save();
                    ctx.translate(centerX, centerY);
                    ctx.rotate(startAngle + arcAngle / 2);
                    ctx.textAlign = 'right';
                    ctx.fillStyle = '#fff';
                    ctx.font = 'bold 14px Poppins';
                    ctx.fillText(wheelItems[i].label, radius * 0.85, 5);
                    ctx.restore();
                }

                // Draw center circle
                ctx.beginPath();
                ctx.arc(centerX, centerY, radius * 0.1, 0, 2 * Math.PI);
                ctx.fillStyle = '#fff';
                ctx.fill();
            }

            // Spin the wheel
            let isSpinning = false;

            const spinBtn = document.getElementById('spin-btn');
            spinBtn.addEventListener('click', spinWheel);

            function spinWheel() {
                if (isSpinning) return;

                isSpinning = true;
                spinBtn.disabled = true;

                // Calculate random rotation
                const totalItems = wheelItems.length;
                const arcAngle = 360 / totalItems;

                // Weight-based selection
                const weights = wheelItems.map(item => item.probability);
                const totalWeight = weights.reduce((a, b) => a + b, 0);
                let random = Math.random() * totalWeight;

                let selectedIndex = 0;
                for (let i = 0; i < weights.length; i++) {
                    random -= weights[i];
                    if (random <= 0) {
                        selectedIndex = i;
                        break;
                    }
                }

                // Calculate the angle to stop at
                const stopAngle = 360 - (selectedIndex * arcAngle + arcAngle / 2);
                const extraRotations = 5; // Add extra rotations for effect
                const totalRotation = stopAngle + 360 * extraRotations;

                // Rotate wheel
                canvas.style.transform = `rotate(${totalRotation}deg)`;

                // Show result after animation ends
                setTimeout(() => {
                    showResult(wheelItems[selectedIndex].label);
                    isSpinning = false;
                    spinBtn.disabled = false;

                    // Reset wheel after a delay
                    setTimeout(() => {
                        canvas.style.transition = 'none';
                        canvas.style.transform = 'rotate(0deg)';
                        setTimeout(() => {
                            canvas.style.transition =
                                'transform 5s cubic-bezier(0.2, 0.8, 0.3, 1)';
                        }, 50);
                    }, 1000);
                }, 5000);
            }

            // Show result modal
            function showResult(prize) {
                const modal = document.getElementById('result-modal');
                const rewardText = document.getElementById('result-reward');

                rewardText.textContent = prize;
                modal.classList.add('active');
            }

            // Handle spin count
            const spinCount = document.getElementById('spin-count');
            const decreaseBtn = document.getElementById('decrease-btn');
            const increaseBtn = document.getElementById('increase-btn');

            decreaseBtn.addEventListener('click', () => {
                let count = parseInt(spinCount.value);
                if (count > 1) {
                    spinCount.value = count - 1;
                }
            });

            increaseBtn.addEventListener('click', () => {
                let count = parseInt(spinCount.value);
                if (count < 10) {
                    spinCount.value = count + 1;
                }
            });

            // Handle modal close
            const modalClose = document.getElementById('modal-close');
            const continueBtn = document.getElementById('continue-btn');

            modalClose.addEventListener('click', closeModal);
            continueBtn.addEventListener('click', closeModal);

            function closeModal() {
                const modal = document.getElementById('result-modal');
                modal.classList.remove('active');
            }

            // Initial setup
            setCanvasDimensions();
            window.addEventListener('resize', setCanvasDimensions);
        });
    </script>
@endpush
