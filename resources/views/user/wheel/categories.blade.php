{{-- /**
* Copyright (c) 2025 FPT University
*
* @author Phạm Hoàng Tuấn
* @email phamhoangtuanqn@gmail.com
* @facebook fb.com/phamhoangtuanqn
*/ --}}

@extends('layouts.user.app')
@section('title', $title)
@section('content')
    <div class="container">
        <div class="wheel-categories-header">
            <h1 class="wheel-categories-title">Vòng Quay May Mắn</h1>
            <p class="wheel-categories-desc">Thử vận may của bạn và nhận những phần thưởng hấp dẫn với các vòng quay độc đáo
                của chúng tôi</p>
        </div>

        <div class="wheel-categories-list">
            @foreach ($categories as $category)
                <div class="wheel-category-card">
                    <div class="wheel-category-image">
                        <img src="{{ $category->thumbnail }}" alt="{{ $category->name }}">
                        <div class="wheel-category-badge">
                            <i class="fas fa-sync-alt"></i> {{ number_format($category->soldCount) }} lượt quay
                        </div>
                    </div>
                    <div class="wheel-category-content">
                        <h3 class="wheel-category-title">{{ $category->name }}</h3>
                        <p class="wheel-category-price">
                            <i class="fas fa-coins"></i> {{ number_format($category->price_per_spin) }}₫/lượt
                        </p>
                        <a href="{{ route('lucky.index', ['id' => $category->id]) }}" class="wheel-category-btn">
                            <span>Quay Ngay</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="wheel-info-section">
            <div class="wheel-info-content">
                <h2 class="wheel-info-title">Tại sao chọn vòng quay của chúng tôi?</h2>
                <div class="wheel-info-features">
                    <div class="wheel-info-feature">
                        <div class="wheel-info-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3>An Toàn & Bảo Mật</h3>
                        <p>Hệ thống quay thưởng được mã hóa và bảo mật cao, đảm bảo tính công bằng.</p>
                    </div>
                    <div class="wheel-info-feature">
                        <div class="wheel-info-icon">
                            <i class="fas fa-gift"></i>
                        </div>
                        <h3>Phần Thưởng Hấp Dẫn</h3>
                        <p>Đa dạng phần thưởng giá trị, từ tài khoản VIP đến tiền mặt và nhiều ưu đãi khác.</p>
                    </div>
                    <div class="wheel-info-feature">
                        <div class="wheel-info-icon">
                            <i class="fas fa-history"></i>
                        </div>
                        <h3>Nhận Thưởng Ngay</h3>
                        <p>Phần thưởng được cộng trực tiếp vào tài khoản ngay sau khi quay thưởng thành công.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .wheel-categories-header {
            text-align: center;
            padding: 50px 0;
            background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
            border-radius: var(--border-radius-lg);
            color: white;
            margin-bottom: 50px;
            position: relative;
            overflow: hidden;
        }

        .wheel-categories-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('/assets/images/hero-pattern.svg');
            background-repeat: repeat;
            background-size: 100px;
            opacity: 0.05;
        }

        .wheel-categories-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 15px;
            background: linear-gradient(to right, #fff, #e0e0ff);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            position: relative;
        }

        .wheel-categories-desc {
            font-size: 1.8rem;
            max-width: 700px;
            margin: 0 auto;
            opacity: 0.9;
        }

        .wheel-categories-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 30px;
            margin-bottom: 60px;
        }

        .wheel-category-card {
            background-color: white;
            border-radius: var(--border-radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: var(--transition);
        }

        .wheel-category-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
        }

        .wheel-category-image {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .wheel-category-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .wheel-category-card:hover .wheel-category-image img {
            transform: scale(1.05);
        }

        .wheel-category-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: var(--accent-color);
            color: white;
            padding: 8px 15px;
            border-radius: var(--border-radius-pill);
            font-size: 1.4rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .wheel-category-content {
            padding: 25px;
        }

        .wheel-category-title {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--dark);
        }

        .wheel-category-price {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .wheel-category-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            padding: 12px 25px;
            border-radius: var(--border-radius-pill);
            font-weight: 600;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(127, 90, 240, 0.3);
        }

        .wheel-category-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(127, 90, 240, 0.4);
            color: white;
        }

        .wheel-info-section {
            background-color: white;
            border-radius: var(--border-radius-lg);
            padding: 60px 40px;
            margin-bottom: 60px;
            box-shadow: var(--shadow-md);
        }

        .wheel-info-title {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 40px;
            text-align: center;
            color: var(--dark);
        }

        .wheel-info-features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .wheel-info-feature {
            text-align: center;
            padding: 20px;
        }

        .wheel-info-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-light), var(--primary-color));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            margin: 0 auto 20px;
            box-shadow: 0 10px 20px rgba(127, 90, 240, 0.2);
        }

        .wheel-info-feature h3 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--dark);
        }

        .wheel-info-feature p {
            color: var(--text-light);
            line-height: 1.6;
        }

        @media screen and (max-width: 768px) {
            .wheel-categories-title {
                font-size: 3rem;
            }

            .wheel-categories-desc {
                font-size: 1.6rem;
            }

            .wheel-info-title {
                font-size: 2.4rem;
            }
        }

        @media screen and (max-width: 576px) {
            .wheel-categories-title {
                font-size: 2.5rem;
            }

            .wheel-categories-header {
                padding: 40px 20px;
            }

            .wheel-info-section {
                padding: 40px 20px;
            }
        }
    </style>
@endpush
