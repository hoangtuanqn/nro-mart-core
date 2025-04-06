{{-- /**
* Copyright (c) 2025 FPT University
*
* @author Phạm Hoàng Tuấn
* @email phamhoangtuanqn@gmail.com
* @facebook fb.com/phamhoangtuanqn
*/ --}}

@extends('layouts.user.app')

@section('title', 'Đặt lại mật khẩu')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
@endpush
@section('content')
    <section class="register-section">
        <div class="container">
            <div class="register-container">
                <div class="register-header">
                    <h1 class="register-title">Đặt lại mật khẩu</h1>
                    <p class="register-subtitle">Vui lòng nhập mật khẩu mới cho tài khoản của bạn</p>
                </div>

                @if (session('status'))
                    <div class="service__alert service__alert--success">
                        <i class="fas fa-check-circle"></i>
                        <div>
                            <span>{{ session('status') }}</span>
                        </div>
                        <button type="button" class="service__alert-close">&times;</button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="service__alert service__alert--error">
                        <i class="fas fa-exclamation-circle"></i>
                        <div>
                            <span>{{ session('error') }}</span>
                        </div>
                        <button type="button" class="service__alert-close">&times;</button>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.store') }}" class="register-form">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="form-group">
                        <label for="email" class="form-label">Địa chỉ Email</label>
                        <input id="email" type="email" class="form-input @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email', $request->email) }}" required autofocus readonly>
                        @error('email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Mật khẩu mới</label>
                        <input id="password" type="password" class="form-input @error('password') is-invalid @enderror"
                            name="password" required>
                        @error('password')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                        <input id="password_confirmation" type="password" class="form-input" name="password_confirmation"
                            required>
                    </div>

                    <button type="submit" class="register-btn">
                        Đặt lại mật khẩu
                    </button>

                    <div class="login-link mt-3">
                        <a href="{{ route('login') }}">
                            <i class="fas fa-arrow-left"></i> Quay lại đăng nhập
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
