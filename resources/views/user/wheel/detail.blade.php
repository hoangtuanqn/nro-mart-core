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
                    <h1 class="wheel-title">{{ $wheel->name }}</h1>
                    <p class="wheel-description">{!! $wheel->description !!}</p>
                    <div class="wheel-price">
                        Giá: <span>{{ number_format($wheel->price_per_spin) }} VNĐ</span> / lượt quay
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
                    <img src="{{ $wheel->wheel_image }}" alt="Vòng quay" class="wheel-image">
                    <div class="wheel-pointer">
                        <i class="fas fa-location-arrow"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- History Section -->
        <section class="history-section">
            <h2 class="history-title">Các lượt quay gần đây</h2>
            @if (count($history) > 0)
                <div class="history-table-container">
                    <table class="history-table">
                        <thead>
                            <tr>
                                <th>Người quay</th>
                                <th>Thời gian</th>
                                <th>Số lượt</th>
                                <th>Tổng tiền</th>
                                <th>Phần thưởng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($history as $item)
                                <tr>
                                    <td>{{ Str::limit($item->user->username, 4) }}</td>
                                    <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $item->spin_count }}</td>
                                    <td>{{ number_format($item->total_cost) }} VNĐ</td>
                                    <td class="history-item-reward">
                                        {{ $item->description }}{{ $item->spin_count > 1 ? ' x ' . $item->spin_count : '' }}
                                    </td>
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
                    {!! $wheel->rules !!}
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
            // Spin the wheel
            let isSpinning = false;
            const spinBtn = document.getElementById('spin-btn');
            const wheelElement = document.querySelector('.wheel-image');
            const spinCount = document.getElementById('spin-count');
            const totalItems = 8; // Fixed to 8 items on the wheel
            const arcAngle = 360 / totalItems;

            spinBtn.addEventListener('click', spinWheel);

            function spinWheel() {
                if (isSpinning) return;

                isSpinning = true;
                spinBtn.disabled = true;

                // Get spin count
                const spinCountValue = parseInt(spinCount.value);
                if (spinCountValue > 10) {
                    alert("Mỗi lần quay tối đa 10 lần")
                    isSpinning = false;
                    spinBtn.disabled = false;
                } else {
                    // Send AJAX request to the server
                    fetch('{{ route('lucky.spin', $wheel->slug) }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                spin_count: spinCountValue
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (!data.success) {
                                alert(data.message);
                                isSpinning = false;
                                spinBtn.disabled = false;
                                return;
                            }

                            // Get the reward from server
                            const reward = data.rewards[0]; // Lấy phần thưởng
                            const selectedIndex = reward.index;

                            // Calculate the angle to stop at
                            const stopAngle = -(selectedIndex * arcAngle);
                            const extraRotations = 5; // Add extra rotations for effect
                            const totalRotation = stopAngle - (360 * extraRotations);

                            // Rotate wheel
                            wheelElement.style.transform = `rotate(${totalRotation}deg)`;

                            // Show result after animation ends
                            setTimeout(() => {
                                // Hiển thị kết quả với số lượt quay
                                const resultMessage = spinCountValue > 1 ?
                                    `${reward.content} x ${spinCountValue} lượt quay)` :
                                    reward.content;

                                showResult(resultMessage);
                                isSpinning = false;
                                spinBtn.disabled = false;

                                // Update user balance if provided
                                if (data.new_balance !== undefined) {
                                    // Update balance display if you have one
                                    const balanceElement = document.querySelector('.user-balance');
                                    if (balanceElement) {
                                        balanceElement.textContent = new Intl.NumberFormat('vi-VN')
                                            .format(
                                                data.new_balance);
                                    }
                                }

                                // Reset wheel after a delay
                                setTimeout(() => {
                                    wheelElement.style.transition = 'none';
                                    wheelElement.style.transform = 'rotate(0deg)';
                                    setTimeout(() => {
                                        wheelElement.style.transition =
                                            'transform 5s cubic-bezier(0.2, 0.8, 0.3, 1)';
                                    }, 50);
                                }, 1000);

                                // Reload history section
                                setTimeout(() => {
                                    location.reload();
                                }, 3000);
                            }, 5000);
                        })
                        .catch(error => {
                            // console.error('Error:', error);
                            alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
                            isSpinning = false;
                            spinBtn.disabled = false;
                        });
                }
            }

            // Show result modal
            function showResult(prize) {
                const modal = document.getElementById('result-modal');
                const rewardText = document.getElementById('result-reward');

                rewardText.textContent = prize;
                modal.classList.add('active');
            }

            // Handle spin count
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
        });
    </script>
@endpush
