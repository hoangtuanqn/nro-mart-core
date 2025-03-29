{{-- /**
* Copyright (c) 2025 FPT University
*
* @author Phạm Hoàng Tuấn
* @email phamhoangtuanqn@gmail.com
* @facebook fb.com/phamhoangtuanqn
*/ --}}

@extends('layouts.user.app')

@section('title', 'Thông tin tài khoản')

@section('content')
    <section class="profile-section">
        <div class="container">
            <div class="profile-container">
                <div class="profile-header">
                    <h1 class="profile-title">THÔNG TIN TÀI KHOẢN</h1>
                </div>

                <div class="profile-content">
                    @include('layouts.user.sidebar')

                    <div class="profile-main">
                        <div class="profile-info-card">
                            <div class="info-header">
                                <h2 class="info-title">THÔNG TIN TÀI KHOẢN</h2>
                            </div>
                            <div class="info-content">
                                <div class="info-row">
                                    <div class="info-label">ID của bạn:</div>
                                    <div class="info-value">{{ Auth::user()->id }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Tên tài khoản:</div>
                                    <div class="info-value">{{ Auth::user()->username }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Email:</div>
                                    <div class="info-value">{{ Auth::user()->email }}</div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Mật khẩu:</div>
                                    <div class="info-value">
                                        ********
                                        <a href="{{ route('profile.change-password') }}" class="change-password-link">Nhấn
                                            đổi mật khẩu</a>
                                    </div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Số dư:</div>
                                    <div class="info-value info-value--highlight">
                                        {{ number_format(Auth::user()->balance ?? 0) }} VND
                                    </div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Tổng tiền đã nạp:</div>
                                    <div class="info-value info-value--highlight">
                                        {{ number_format(Auth::user()->total_deposited ?? 0) }} VND
                                    </div>
                                </div>


                                <div class="info-row">
                                    <div class="info-label">Ngày tham gia:</div>
                                    <div class="info-value">{{ Auth::user()->created_at->format('d/m/Y H:i:s A') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection