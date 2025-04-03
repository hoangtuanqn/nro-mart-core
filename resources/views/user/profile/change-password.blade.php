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
                    <h1 class="profile-title"><i class="fa-solid fa-key me-2"></i> ĐỔI MẬT KHẨU</h1>
                </div>

                <div class="profile-content">
                    @include('layouts.user.sidebar')

                    <div class="profile-main">
                        <div class="profile-info-card">
                            <div class="info-header">
                                <div class="balance-info">
                                    <span class="balance-label"><i class="fa-solid fa-lock me-2"></i> THAY ĐỔI MẬT
                                        KHẨU</span>
                                </div>
                            </div>

                            <div class="info-content">
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
                                    </div>
                                @endif

                                <form action="{{ route('profile.change-password') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="current_password" class="form-label">
                                            <i class="fa-solid fa-lock me-2"></i> Mật khẩu hiện tại
                                        </label>
                                        <input type="password"
                                            class="form-control @error('current_password') is-invalid @enderror"
                                            id="current_password" name="current_password" required>
                                        @error('current_password')
                                            <div class="invalid-feedback">
                                                <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="new_password" class="form-label">
                                            <i class="fa-solid fa-key me-2"></i> Mật khẩu mới
                                        </label>
                                        <input type="password"
                                            class="form-control @error('new_password') is-invalid @enderror"
                                            id="new_password" name="new_password" required>
                                        @error('new_password')
                                            <div class="invalid-feedback">
                                                <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="new_password_confirmation" class="form-label">
                                            <i class="fa-solid fa-key me-2"></i> Xác nhận mật khẩu mới
                                        </label>
                                        <input type="password" class="form-control" id="new_password_confirmation"
                                            name="new_password_confirmation" required>
                                    </div>

                                    <div class="form-group mt-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa-solid fa-check me-2"></i> Cập nhật mật khẩu
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
