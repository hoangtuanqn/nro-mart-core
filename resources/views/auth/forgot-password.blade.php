{{-- /**
* Copyright (c) 2025 FPT University
*
* @author Phạm Hoàng Tuấn
* @email phamhoangtuanqn@gmail.com
* @facebook fb.com/phamhoangtuanqn
*/ --}}

@extends('layouts.user.app')

@section('title', 'Quên mật khẩu')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
@endpush
@section('content')
    <section class="register-section">
        <div class="container">
            <div class="register-container">
                <div class="register-header">
                    <h1 class="register-title">Quên mật khẩu</h1>
                    <p class="register-subtitle">Vui lòng nhập địa chỉ email của bạn để đặt lại mật khẩu</p>
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

                <form method="POST" action="{{ route('password.email') }}" class="register-form">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="form-label">Địa chỉ Email</label>
                        <input id="email" type="email" class="form-input @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="register-btn">
                        Gửi liên kết đặt lại mật khẩu
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
