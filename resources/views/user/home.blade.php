{{-- /**
* Copyright (c) 2025 FPT University
*
* @author Phạm Hoàng Tuấn
* @email phamhoangtuanqn@gmail.com
* @facebook fb.com/phamhoangtuanqn
*/ --}}

@extends('layouts.user.app')
@section('title', 'Trang chủ')
@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero__content">
                <h1 class="hero__title">Mua Bán Nick Game Uy Tín</h1>
                <p class="hero__desc">Cung cấp tài khoản game chính hãng, giá rẻ, thanh toán nhanh chóng</p>
                <div class="hero__actions">
                    <a href="#" class="btn btn--primary">Mua Ngay</a>
                    <a href="#" class="btn btn--outline">Tìm Hiểu Thêm</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Menu Transaction -->
    <section class="menu">
        <div class="container">
            <header class="menu__header">
                <h2 class="menu__header__title">MENU GIAO DỊCH</h2>
            </header>
            <div class="transaction__list">
                <a href="{{ route('profile.deposit-card') }}" class="transaction__item">
                    <div class="transaction__icon">
                        <img src="https://acc957.com/Img/NapThe.png" alt="Item" class="transaction__img" />
                    </div>
                    <p class="text text__transaction__item">NẠP THẺ</p>
                </a>
                <a href="/profile" class="transaction__item">
                    <div class="transaction__icon">
                        <img src="https://acc957.com/Img/TaiKhoan.png" alt="Item" class="transaction__img" />
                    </div>
                    <p class="text text__transaction__item">TÀI KHOẢN</p>
                </a>
                <a href="{{ route('service.show-all') }}" class="transaction__item">
                    <div class="transaction__icon">
                        <img src="https://acc957.com/Img/DichVu.png" alt="Item" class="transaction__img" />
                    </div>
                    <p class="text text__transaction__item">DỊCH VỤ</p>
                </a>
                <a href="#" class="transaction__item">
                    <div class="transaction__icon">
                        <img src="https://acc957.com/Img/NickRandom.png" alt="Item" class="transaction__img" />
                    </div>
                    <p class="text text__transaction__item">VÒNG QUAY</p>
                </a>
            </div>
        </div>
    </section>

    <!-- Menu mục game -->
    <section class="menu">
        <div class="container">
            <header class="menu__header">
                <h2 class="menu__header__title">DANH MỤC GAME</h2>
            </header>
            <div class="category__list">
                @foreach ($categories as $category)
                    <a href="{{ route('category.index', ['slug' => $category->slug]) }}" class="category__item">
                        <img src="{{ $category->thumbnail }}" alt="{{ $category->name }}" class="category__img" />
                        <h2 class="category__title">{{ $category->name }}</h2>
                        <p class="category__desc">Tổng tài khoản: {{ number_format($category->allAccount) }}</p>
                        <p class="category__desc">Acc đã bán: {{ number_format($category->soldCount) }}</p>
                        <p class="text category__action">Mua ngay</p>
                    </a>
                @endforeach

            </div>
        </div>
    </section>

    <!-- Menu mục dịch vụ game -->
    <section class="menu">
        <div class="container">
            <header class="menu__header">
                <h2 class="menu__header__title">DANH MỤC DỊCH VỤ</h2>
            </header>
            <div class="category__list">
                @foreach ($services as $service)
                    @if ($service->active)
                        <a href="{{ route('service.show', ['slug' => $service->slug]) }}" class="category__item">
                            <img src="{{ $service->thumbnail }}" alt="{{ $service->name }}" class="category__img" />
                            <h2 class="category__title">{{ strtoupper($service->name) }}</h2>
                            <p class="category__desc">Tổng giao dịch: {{ number_format($service->orderCount) }}</p>
                            <p class="text category__action">Thuê ngay</p>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </section>


    <!-- Menu DANH MỤC RANDOM -->
    <section class="menu">
        <div class="container">
            <header class="menu__header">
                <h2 class="menu__header__title">DANH MỤC RANDOM</h2>
            </header>
            <div class="category__list">
                @foreach ($randomCategories as $category)
                    @if ($category->active)
                        <a href="{{ route('random.index', ['slug' => $category->slug]) }}" class="category__item">
                            <img src="{{ $category->thumbnail }}" alt="{{ $category->name }}" class="category__img" />
                            <h2 class="category__title">{{ strtoupper($category->name) }}</h2>
                            <p class="category__desc">Tổng tài khoản: {{ number_format($category->allAccount) }}</p>
                            <p class="category__desc">Acc đã bán: {{ number_format($category->soldCount) }}</p>
                            <p class="text category__action">Mua ngay</p>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <!-- Menu DANH MỤC VÒNG QUAY MAY MẮN -->
    <section class="menu">
        <div class="container">
            <header class="menu__header">
                <h2 class="menu__header__title">VÒNG QUAY MAY MẮN</h2>
            </header>
            <div class="category__list">
                @foreach ($randomLuckWheel as $category)
                    @if ($category->active)
                        <a href="{{ route('random.index', ['slug' => $category->slug]) }}" class="category__item">
                            <img src="{{ $category->thumbnail }}" alt="{{ $category->name }}" class="category__img" />
                            <h2 class="category__title">{{ strtoupper($category->name) }}</h2>
                            <p class="category__desc">Số lượt quay: {{ number_format($category->soldCount) }}</p>
                            <p class="text category__action">Mua ngay</p>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
@endsection
