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
    <section class="profile-section">
        <div class="container">
            <div class="profile-container">
                <div class="profile-header">
                    <h1 class="profile-title"><i class="fa-solid fa-user-circle me-2"></i> THÔNG TIN TÀI KHOẢN</h1>
                </div>

                <div class="profile-content">
                    @include('layouts.user.sidebar')

                    <div class="profile-main">
                        <div class="profile-info-card">
                            <div class="info-header">
                                <div class="balance-info">
                                    <span class="balance-label"><i class="fa-solid fa-wallet me-2"></i> THÔNG TIN TÀI
                                        KHOẢN</span>
                                </div>
                            </div>

                            <div class="info-content">
                                <div class="info-row">
                                    <div class="info-label">
                                        <i class="fa-solid fa-id-card me-2"></i> ID tài khoản
                                    </div>
                                    <div class="info-value">{{ $user->id }}</div>
                                </div>

                                <div class="info-row">
                                    <div class="info-label">
                                        <i class="fa-solid fa-user me-2"></i> Tên đăng nhập
                                    </div>
                                    <div class="info-value">{{ $user->username }}</div>
                                </div>

                                <div class="info-row">
                                    <div class="info-label">
                                        <i class="fa-solid fa-envelope me-2"></i> Email
                                    </div>
                                    <div class="info-value">{{ $user->email }}</div>
                                </div>

                                <div class="info-row">
                                    <div class="info-label">
                                        <i class="fa-solid fa-key me-2"></i> Mật khẩu
                                    </div>
                                    <div class="info-value">
                                        ********
                                        <a href="{{ route('profile.change-password') }}" class="change-password-link">
                                            <i class="fa-solid fa-pen-to-square me-1"></i> Đổi mật khẩu
                                        </a>
                                    </div>
                                </div>


                                <div class="info-row">
                                    <div class="info-label">
                                        <i class="fa-solid fa-wallet me-2"></i> Số dư
                                    </div>
                                    <div class="info-value info-value--highlight">
                                        {{ number_format($user->balance) }} VND
                                    </div>
                                </div>

                                <div class="info-row">
                                    <div class="info-label">
                                        <i class="fa-solid fa-money-bill-trend-up me-2"></i> Tổng nạp
                                    </div>
                                    <div class="info-value info-value--highlight">
                                        {{ number_format($user->total_deposit) }} VND
                                    </div>
                                </div>

                                <div class="info-row">
                                    <div class="info-label">
                                        <i class="fa-solid fa-coins me-2"></i> Vàng
                                    </div>
                                    <div class="info-value">
                                        {{ number_format($user->gold) }}
                                        <a href="{{ route('profile.withdraw-gold') }}" class="change-password-link">
                                            <i class="fa-solid fa-coins me-1"></i> Rút vàng
                                        </a>
                                    </div>
                                </div>

                                <div class="info-row">
                                    <div class="info-label">
                                        <i class="fa-solid fa-gem me-2"></i> Ngọc
                                    </div>
                                    <div class="info-value">
                                        {{ number_format($user->gem) }}
                                        <a href="{{ route('profile.withdraw-gem') }}" class="change-password-link">
                                            <i class="fa-solid fa-gem me-1"></i> Rút ngọc
                                        </a>
                                    </div>
                                </div>

                                <div class="info-row">
                                    <div class="info-label">
                                        <i class="fa-solid fa-calendar-check me-2"></i> Ngày tạo
                                    </div>
                                    <div class="info-value">
                                        {{ $user->created_at->format('H:i d/m/Y') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
