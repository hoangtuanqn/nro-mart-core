{{-- /**
* Copyright (c) 2025 FPT University
*
* @author Phạm Hoàng Tuấn
* @email phamhoangtuanqn@gmail.com
* @facebook fb.com/phamhoangtuanqn
*/ --}}

@extends('layouts.user.app')

@section('title', 'Đăng nhập')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
@endpush
@section('content')
    <section class="register-section">
        <div class="container">
            <div class="register-container">
                <div class="register-header">
                    <h1 class="register-title">Đăng nhập</h1>
                    <p class="register-subtitle">Đăng nhập để tiếp tục sử dụng dịch vụ</p>
                </div>
                @if (session('error'))
                    <div class="service__alert service__alert--error">
                        <i class="fas fa-exclamation-circle"></i>
                        <div>
                            <span>{{ session('error') }}</span>
                        </div>
                        <button type="button" class="service__alert-close">&times;</button>
                    </div>
                @endif
                <form method="POST" action="{{ route('login') }}" class="register-form">
                    @csrf

                    <div class="form-group">
                        <label for="username" class="form-label">Tên tài khoản hoặc Email</label>
                        <input id="username" type="text" class="form-input @error('username') is-invalid @enderror"
                            name="username" value="{{ old('username') }}" required autofocus>
                        @error('username')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input id="password" type="password" class="form-input @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password">
                        @error('password')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Ghi nhớ đăng nhập
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="register-btn">
                        Đăng nhập
                    </button>

                    @if (config_get('login_social.google.active', false) || config_get('login_social.facebook.active', false))
                        <div class="social-login">
                            <p class="social-login-text">Hoặc đăng nhập bằng</p>
                            <div class="social-login-buttons">
                                @if (config_get('login_social.google.active', false))
                                    <a href="{{ route('auth.google') }}" class="google-login-btn">
                                        <i class="fab fa-google"></i>
                                        <span>Google</span>
                                    </a>
                                @endif
                                @if (config_get('login_social.facebook.active', false))
                                    <a href="{{ route('auth.facebook') }}" class="facebook-login-btn">
                                        <i class="fab fa-facebook-f"></i>
                                        <span>Facebook</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="login-link">
                        Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a>
                    </div>

                    @if (Route::has('password.request'))
                        <div class="login-link mt-2">
                            <a href="{{ route('password.request') }}">
                                Quên mật khẩu?
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </section>
@endsection
