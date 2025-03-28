@extends('layouts.user.app')

@section('title', 'Đăng ký tài khoản')

@section('content')
    <section class="register-section">
        <div class="container">
            <div class="register-container">
                <div class="register-header">
                    <h1 class="register-title">Đăng ký tài khoản</h1>
                    <p class="register-subtitle">Tạo tài khoản để mua game dễ dàng hơn</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="register-form">
                    @csrf

                    <div class="form-group">
                        <label for="username" class="form-label">Tên tài khoản</label>
                        <input id="username" type="text" class="form-input @error('username') is-invalid @enderror"
                            name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                        @error('username')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" type="email" class="form-input @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input id="password" type="password" class="form-input @error('password') is-invalid @enderror"
                            name="password" required autocomplete="new-password">
                        @error('password')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password-confirm" class="form-label">Xác nhận mật khẩu</label>
                        <input id="password-confirm" type="password" class="form-input" name="password_confirmation"
                            required autocomplete="new-password">
                    </div>

                    <button type="submit" class="register-btn">
                        Đăng ký
                    </button>

                    <div class="login-link">
                        Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập ngay</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection