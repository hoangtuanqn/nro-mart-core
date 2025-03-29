{{-- /**
* Copyright (c) 2025 FPT University
*
* @author Phạm Hoàng Tuấn
* @email phamhoangtuanqn@gmail.com
* @facebook fb.com/phamhoangtuanqn
*/ --}}

@extends('layouts.user.app')

@section('title', 'Đổi mật khẩu')

@section('content')
    <section class="profile-section">
        <div class="container">
            <div class="profile-container">
                <div class="profile-header">
                    <h1 class="profile-title">ĐỔI MẬT KHẨU</h1>
                </div>

                <div class="profile-content">
                    @include('layouts.user.sidebar')

                    <div class="profile-main">
                        <div class="profile-info-card">
                            <div class="info-header">
                                <div class="balance-info">
                                    <span class="balance-label">ĐỔI MẬT KHẨU</span>
                                </div>
                            </div>

                            <div class="info-content">
                                @if(session('status') === 'password-updated')
                                    <div class="alert alert-success">
                                        Mật khẩu đã được cập nhật thành công!
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('password.update') }}" class="register-form">
                                    @csrf
                                    @method('put')

                                    <div class="form-group">
                                        <label for="current_password" class="form-label">Mật khẩu hiện tại:</label>
                                        <input type="password" id="current_password" name="current_password"
                                            class="form-input @error('current_password', 'updatePassword') is-invalid @enderror"
                                            required>
                                        @error('current_password', 'updatePassword')
                                            <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="password" class="form-label">Mật khẩu mới:</label>
                                        <input type="password" id="password" name="password"
                                            class="form-input @error('password', 'updatePassword') is-invalid @enderror"
                                            required>
                                        @error('password', 'updatePassword')
                                            <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="password_confirmation" class="form-label">Xác nhận mật khẩu mới:</label>
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                            class="form-input" required>
                                    </div>

                                    <button type="submit" class="register-btn">
                                        CẬP NHẬT MẬT KHẨU
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection