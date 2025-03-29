@extends('layouts.user.app')

@section('title', 'Chi tiết tài khoản #171973')

@section('content')
    <section class="hero hero--small">
        <div class="container">
            <div class="hero__content">
                <h1 class="hero__title">THÔNG TIN TÀI KHOẢN #171973</h1>
                <p class="hero__desc">Để xem thêm chi tiết về tài khoản và bộ sưu tập bên dưới</p>
            </div>
        </div>
    </section>
    <section class="detail">
        <div class="container">
            <div class="detail__header">
                <h1 class="detail__title">CHI TIẾT TÀI KHOẢN</h1>
            </div>

            <div class="detail__content">
                <!-- Price Info -->
                <div class="detail__price">
                    <div class="detail__price-item">
                        <span class="detail__price-label">ATM/VÍ:</span>
                        <span class="detail__price-value">7,000 VND</span>
                    </div>
                    <div class="detail__price-item">
                        <span class="detail__price-label">TIỀN CARD:</span>
                        <span class="detail__price-value">10,000 VND</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="detail__actions">
                    <button class="detail__btn detail__btn--primary">MUA NGAY</button>
                    <button class="detail__btn detail__btn--card">NẠP THẺ</button>
                    <button class="detail__btn detail__btn--wallet">ATM/VÍ</button>
                </div>

                <!-- Account Info -->
                <div class="detail__info">
                    <div class="detail__info-row">
                        <div class="detail__info-item">
                            <span class="detail__info-label">MÁY CHỦ:</span>
                            <span class="detail__info-value">SERVER 7</span>
                        </div>
                        <div class="detail__info-item">
                            <span class="detail__info-label">HÀNH TINH:</span>
                            <span class="detail__info-value">XAY DA</span>
                        </div>
                    </div>

                    <div class="detail__info-row">
                        <div class="detail__info-item">
                            <span class="detail__info-label">LOẠI ACC:</span>
                            <span class="detail__info-value">SƠ SINH</span>
                        </div>
                        <div class="detail__info-item">
                            <span class="detail__info-label">NỔI BẬT:</span>
                            <span class="detail__info-value">SƠ SINH CÓ ĐỆ TỬ + 47 NGỌC</span>
                        </div>
                    </div>

                    <div class="detail__info-row">
                        <div class="detail__info-item">
                            <span class="detail__info-label">ĐĂNG KÝ:</span>
                            <span class="detail__info-value">ẢO</span>
                        </div>
                        <div class="detail__info-item">
                            <span class="detail__info-label">BÔNG TAI:</span>
                            <span class="detail__info-value">KHÔNG</span>
                        </div>
                    </div>
                </div>

                <!-- Account Images -->
                <div class="detail__images">
                    <h2 class="detail__images-title">Hình ảnh chi tiết của tài khoản Ngọc rồng Online #171973</h2>
                    <div class="detail__images-list">
                        <img src="https://img.acc957.com//20250326135302img_8768.jpg" alt="Account Preview"
                            class="detail__images-item">
                        <img src="https://img.acc957.com//20250326135302img_8768.jpg" alt="Account Preview"
                            class="detail__images-item">
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection