@extends('layouts.user.app')

@section('title', $title)

@section('content')
    <section class="profile-section">
        <div class="container">
            <div class="profile-container">
                <div class="profile-header">
                    <h1 class="profile-title"><i class="fa-solid fa-money-bill-wave me-2"></i> RÚT TIỀN</h1>
                </div>

                <div class="profile-content">
                    @include('layouts.user.sidebar')

                    <div class="profile-main">
                        <div class="profile-info-card">
                            <div class="info-header">
                                <div class="balance-info">
                                    <span class="balance-label"><i class="fa-solid fa-wallet me-2"></i> SỐ DƯ HIỆN TẠI:
                                        {{ number_format(auth()->user()->balance) }} VND</span>
                                </div>
                            </div>

                            <div class="info-content">
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
                                    </div>
                                @endif

                                @if (session('success'))
                                    <div class="alert alert-success">
                                        <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                                    </div>
                                @endif

                                <form action="{{ route('profile.withdraw.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="amount" class="form-label">
                                            <i class="fa-solid fa-money-bill me-2"></i> Số tiền muốn rút
                                        </label>
                                        <input type="number" class="form-control @error('amount') is-invalid @enderror"
                                            id="amount" name="amount" value="{{ old('amount') }}" required
                                            min="100000" max="10000000">
                                        <div class="form-text">Tối thiểu: 100,000đ - Tối đa: 10,000,000đ</div>
                                        @error('amount')
                                            <div class="invalid-feedback">
                                                <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="user_note" class="form-label">
                                            <i class="fa-solid fa-note-sticky me-2"></i> Thông tin tài khoản
                                        </label>
                                        <textarea class="form-control @error('user_note') is-invalid @enderror" id="user_note" name="user_note" rows="3"
                                            placeholder="Ví dụ: Vietcombank - 1234567890 - Nguyễn Văn A">{{ old('user_note') }}</textarea>
                                        @error('user_note')
                                            <div class="invalid-feedback">
                                                <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group mt-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa-solid fa-check me-2"></i> Gửi yêu cầu
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
