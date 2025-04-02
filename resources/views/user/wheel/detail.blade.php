{{-- filepath: c:\Users\MSI\Downloads\shop-game-ngoc-rong\resources\views\user\wheel\detail.blade.php --}}
@extends('layouts.user.app')

@section('content')
    <style>
        /* Modern styles for the wheel page */
        :root {
            --primary: #3a3f45;
            --primary-light: #5a5f65;
            --secondary: #ff0000;
            --secondary-light: #ff5757;
            --accent: #e63946;
            --dark: #1e2023;
            --light: #f8f9fa;
            --purple: #6c63ff;
            --purple-light: #8f7fff;
            --purple-dark: #4641b7;
            --pink: #ff66c4;
            --teal: #2ec4b6;
            --gold: #ffd166;
            --gold-dark: #efb810;
        }

        body {
            background-color: #f8f9fa;
            background-image:
                radial-gradient(#e6e6e6 1px, transparent 1px),
                radial-gradient(#e6e6e6 1px, transparent 1px);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
        }

        .lucky-wheel-page {
            padding: 2.5rem 0;
            font-family: 'Roboto Condensed', sans-serif;
            color: #333;
            position: relative;
        }

        .page-header {
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            background: linear-gradient(45deg, var(--purple) 0%, var(--accent) 50%, var(--gold) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
            position: relative;
        }

        .page-title::after {
            content: '';
            display: block;
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, var(--purple), var(--accent));
            margin: 10px auto 0;
            border-radius: 2px;
        }

        .page-subtitle {
            font-size: 1.2rem;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
        }

        .page-container {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .wheel-side {
            flex: 1;
            min-width: 300px;
        }

        .info-side {
            flex: 1;
            min-width: 300px;
        }

        .card {
            border-radius: 20px;
            background: white;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
        }

        .card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--purple), var(--accent));
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }

        /* Wheel container */
        .wheel-section {
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            aspect-ratio: 1/1;
            position: relative;
            overflow: hidden;
        }

        .wheel-container {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1.5rem;
        }

        .wheel-backdrop {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            overflow: hidden;
            z-index: 1;
        }

        .wheel-backdrop::before {
            content: '';
            position: absolute;
            width: 150%;
            height: 150%;
            top: -25%;
            left: -25%;
            background: radial-gradient(circle at center, rgba(108, 99, 255, 0.2) 0%, rgba(230, 57, 70, 0.1) 50%, rgba(255, 209, 102, 0.05) 100%);
            z-index: -1;
            animation: rotate 60s linear infinite;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .wheel-outer-glow {
            position: absolute;
            top: 5%;
            left: 5%;
            width: 90%;
            height: 90%;
            border-radius: 50%;
            filter: blur(20px);
            background: radial-gradient(circle at center, rgba(108, 99, 255, 0.2), transparent 70%);
            z-index: 1;
            animation: pulse 6s ease-in-out infinite alternate;
        }

        @keyframes pulse {
            0% {
                opacity: 0.4;
                transform: scale(0.98);
            }

            100% {
                opacity: 0.7;
                transform: scale(1.02);
            }
        }

        .wheel-image {
            width: 90%;
            height: 90%;
            border-radius: 50%;
            object-fit: cover;
            transition: transform 3s cubic-bezier(0.17, 0.67, 0.12, 0.99);
            z-index: 2;
            border: 5px solid white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2),
                0 0 0 2px rgba(108, 99, 255, 0.2),
                0 0 0 8px rgba(255, 255, 255, 0.8);
        }

        .wheel-center {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 20%;
            height: 20%;
            border-radius: 50%;
            background: white;
            z-index: 4;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2), inset 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .wheel-center::before {
            content: '';
            position: absolute;
            width: 80%;
            height: 80%;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--purple-light), var(--purple));
        }

        .spin-button {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90px;
            height: 90px;
            background: linear-gradient(135deg, var(--purple) 0%, var(--purple-dark) 100%);
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 50%;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
            font-size: 1.3rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            z-index: 5;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .spin-button::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(transparent, rgba(255, 255, 255, 0.3), transparent);
            transform: rotate(45deg);
            animation: shine 6s infinite;
        }

        @keyframes shine {
            0% {
                left: -50%;
            }

            20%,
            100% {
                left: 100%;
            }
        }

        .spin-button:hover {
            transform: translate(-50%, -50%) scale(1.05);
            box-shadow: 0 8px 20px rgba(108, 99, 255, 0.5);
        }

        .spin-button:active {
            transform: translate(-50%, -50%) scale(0.95);
        }

        .wheel-stats {
            display: flex;
            justify-content: space-around;
            margin-top: 1.5rem;
            padding: 1rem;
            background: linear-gradient(180deg, #f8f9fa, white);
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .wheel-stat {
            text-align: center;
            padding: 10px;
        }

        .wheel-stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--purple);
            margin-bottom: 5px;
        }

        .wheel-stat-label {
            font-size: 0.9rem;
            color: #777;
            text-transform: uppercase;
        }

        /* Info Panel */
        .info-panel {
            height: 100%;
            display: flex;
            flex-direction: column;
            padding: 0;
        }

        .price-display {
            background: linear-gradient(135deg, var(--purple) 0%, var(--accent) 100%);
            color: white;
            padding: 1.5rem;
            font-size: 1.25rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .price-display::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'%3E%3Cpath d='M0 40L40 0H20L0 20M40 40V20L20 40'/%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.2;
        }

        .price-icon {
            margin-right: 10px;
            background-color: white;
            color: var(--accent);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }

        .action-buttons {
            display: flex;
            padding: 1.5rem;
            gap: 1rem;
        }

        .action-btn {
            flex: 1;
            padding: 0.8rem;
            border: none;
            border-radius: 12px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .btn-try {
            background: linear-gradient(135deg, var(--accent), #ff6b6b);
            color: white;
            box-shadow: 0 5px 15px rgba(230, 57, 70, 0.3);
        }

        .btn-reward {
            background: linear-gradient(135deg, var(--teal), #4ecdc4);
            color: white;
            box-shadow: 0 5px 15px rgba(46, 196, 182, 0.3);
        }

        .action-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(255, 255, 255, 0.2), transparent);
        }

        .action-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .action-btn:active {
            transform: translateY(-1px);
        }

        .action-btn i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        /* Recent players list */
        .recent-players {
            padding: 1.5rem;
        }

        .recent-players-header {
            display: flex;
            align-items: center;
            margin-bottom: 1.3rem;
        }

        .recent-players-icon {
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin-right: 15px;
            box-shadow: 0 5px 10px rgba(255, 209, 102, 0.3);
        }

        .recent-players-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--primary);
            flex: 1;
        }

        .player-list {
            height: 100%;
            max-height: 280px;
            overflow-y: auto;
            padding-right: 10px;
        }

        .player-list::-webkit-scrollbar {
            width: 6px;
        }

        .player-list::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .player-list::-webkit-scrollbar-thumb {
            background: rgba(108, 99, 255, 0.5);
            border-radius: 10px;
        }

        .player-item {
            padding: 1rem;
            background-color: #f9f9f9;
            border-radius: 12px;
            margin-bottom: 0.8rem;
            color: #444;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .player-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(var(--purple), var(--accent));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .player-item:hover {
            background-color: #f1f3f9;
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .player-item:hover::before {
            opacity: 1;
        }

        .player-name {
            color: var(--purple);
            font-weight: bold;
        }

        .player-time {
            font-size: 0.85rem;
            color: #888;
            margin-top: 5px;
        }

        /* Confetti animation for winning */
        .confetti-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1000;
            display: none;
        }

        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            background-color: var(--pink);
            border-radius: 0;
            animation: fall 5s ease-in infinite;
        }

        @keyframes fall {
            0% {
                transform: translateY(-100px) rotate(0deg);
                opacity: 1;
            }

            100% {
                transform: translateY(100vh) rotate(720deg);
                opacity: 0;
            }
        }

        /* Responsive styles */
        @media (max-width: 992px) {
            .page-container {
                flex-direction: column;
                padding: 0 1rem;
            }

            .wheel-side {
                max-width: 500px;
                margin: 0 auto;
            }

            .info-side {
                max-width: 500px;
                margin: 0 auto;
            }
        }

        @media (max-width: 768px) {
            .spin-button {
                width: 80px;
                height: 80px;
                font-size: 1rem;
            }

            .page-title {
                font-size: 2rem;
            }
        }

        @media (max-width: 480px) {
            .spin-button {
                width: 70px;
                height: 70px;
                font-size: 0.9rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .wheel-stats {
                flex-wrap: wrap;
            }

            .wheel-stat {
                width: 50%;
                margin-bottom: 10px;
            }
        }
    </style>

    <div class="lucky-wheel-page">
        <div class="container mx-auto">
            <div class="page-header">
                <h1 class="page-title">Vòng Quay May Mắn</h1>
                <p class="page-subtitle">Quay thưởng ngay để nhận những phần quà hấp dẫn và giá trị</p>
            </div>

            <div class="page-container">
                <!-- Wheel Section (Left) -->
                <div class="wheel-side">
                    <div class="card">
                        <div class="wheel-section">
                            <div class="wheel-container">
                                <div class="wheel-backdrop"></div>
                                <div class="wheel-outer-glow"></div>
                                <img src="https://123nick.vn/upload-usr/images/LVNwJbtFqU_1599464163.jpg" alt="Vòng quay"
                                    class="wheel-image">
                                <div class="wheel-center"></div>
                                <button class="spin-button">Quay</button>
                            </div>
                        </div>
                        <div class="wheel-stats">
                            <div class="wheel-stat">
                                <div class="wheel-stat-value">20K</div>
                                <div class="wheel-stat-label">Giá/Lượt</div>
                            </div>
                            <div class="wheel-stat">
                                <div class="wheel-stat-value">100%</div>
                                <div class="wheel-stat-label">Tỉ lệ trúng</div>
                            </div>
                            <div class="wheel-stat">
                                <div class="wheel-stat-value">50+</div>
                                <div class="wheel-stat-label">Phần quà</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Panel (Right) -->
                <div class="info-side">
                    <div class="card info-panel">
                        <!-- Price display -->
                        <div class="price-display">
                            <div class="price-icon">
                                <i class="fas fa-ticket-alt"></i>
                            </div>
                            <span>Giá 15.000 đ / Lượt</span>
                        </div>

                        <!-- Action buttons -->
                        <div class="action-buttons">
                            <button class="action-btn btn-try">
                                <i class="fas fa-play-circle"></i> Chơi Thử
                            </button>
                            <button class="action-btn btn-reward">
                                <i class="fas fa-gift"></i> Rút Thưởng
                            </button>
                        </div>

                        <!-- Recent players -->
                        <div class="recent-players">
                            <div class="recent-players-header">
                                <div class="recent-players-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <h3 class="recent-players-title">Người chơi gần đây</h3>
                            </div>

                            <div class="player-list">
                                @foreach ($history as $item)
                                    <div class="player-item">
                                        <div><span class="player-name">{{ $item->username }}</span> đã chơi vòng quay</div>
                                        <div class="player-time">{{ $item->created_at }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confetti Container for Winning Animation -->
    <div class="confetti-container" id="confetti"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const wheelImage = document.querySelector('.wheel-image');
            const spinButton = document.querySelector('.spin-button');
            const confettiContainer = document.getElementById('confetti');
            const tryButton = document.querySelector('.btn-try');

            // Disable button during spin
            let spinning = false;

            function spinWheel() {
                if (spinning) return;

                spinning = true;
                spinButton.disabled = true;
                spinButton.innerText = "...";

                // Generate random rotation between 3600 and 7200 degrees (10-20 full rotations)
                const rotation = 3600 + Math.floor(Math.random() * 3600);

                // Apply rotation
                wheelImage.style.transform = `rotate(${rotation}deg)`;

                // Re-enable button after spin animation finishes
                setTimeout(() => {
                    spinning = false;
                    spinButton.disabled = false;
                    spinButton.innerText = "Quay";

                    // Show winning animation
                    showWinAnimation();
                }, 3000);
            }

            spinButton.addEventListener('click', spinWheel);
            tryButton.addEventListener('click', spinWheel);

            // Create confetti animation
            function showWinAnimation() {
                confettiContainer.style.display = 'block';
                confettiContainer.innerHTML = '';

                // Create confetti pieces
                const colors = ['#6c63ff', '#e63946', '#2ec4b6', '#ffd166', '#ff66c4', '#4ecdc4'];

                for (let i = 0; i < 150; i++) {
                    const confetti = document.createElement('div');
                    confetti.className = 'confetti';

                    // Random position
                    confetti.style.left = Math.random() * 100 + 'vw';
                    confetti.style.top = -10 + 'px';

                    // Random color
                    confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];

                    // Random size
                    const size = Math.random() * 10 + 5;
                    confetti.style.width = size + 'px';
                    confetti.style.height = size + 'px';

                    // Random shape
                    const shapes = ['circle', 'triangle', 'square'];
                    const shape = shapes[Math.floor(Math.random() * shapes.length)];

                    if (shape === 'circle') {
                        confetti.style.borderRadius = '50%';
                    } else if (shape === 'triangle') {
                        confetti.style.width = '0';
                        confetti.style.height = '0';
                        confetti.style.backgroundColor = 'transparent';
                        confetti.style.borderLeft = (size / 2) + 'px solid transparent';
                        confetti.style.borderRight = (size / 2) + 'px solid transparent';
                        confetti.style.borderBottom = size + 'px solid ' + colors[Math.floor(Math.random() * colors
                            .length)];
                    }

                    // Random animation duration
                    confetti.style.animationDuration = Math.random() * 3 + 2 + 's';

                    // Add to container
                    confettiContainer.appendChild(confetti);
                }

                // Remove confetti after animation
                setTimeout(() => {
                    confettiContainer.style.display = 'none';
                }, 5000);
            }
        });
    </script>
@endsection
