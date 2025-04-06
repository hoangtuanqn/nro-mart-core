@extends('layouts.user.app')

@section('title', $title)

@section('content')
    <section class="profile-section">
        <div class="container">
            <div class="profile-container">
                <div class="profile-header">
                    <h1 class="profile-title"><i class="fa-solid fa-credit-card me-2"></i> NẠP TIỀN THẺ CÀO</h1>
                </div>

                <div class="profile-content">
                    @include('layouts.user.sidebar')

                    <div class="profile-main">
                        <div class="profile-info-card">
                            <div class="info-header">
                                <div class="balance-info">
                                    <span class="balance-label"><i class="fa-solid fa-wallet me-2"></i> SỐ DƯ HIỆN TẠI:
                                        {{ number_format(Auth::user()->balance) }} VND</span>
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

                                <form action="{{ route('profile.deposit-card') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="telecom" class="form-label">
                                            <i class="fa-solid fa-building me-2"></i> Nhà mạng
                                        </label>
                                        <select class="form-control @error('telecom') is-invalid @enderror" id="telecom"
                                            name="telco" required>
                                            <option value="">Chọn nhà mạng</option>
                                            <option value="VIETTEL" {{ old('telecom') == 'VIETTEL' ? 'selected' : '' }}>
                                                Viettel
                                            </option>
                                            <option value="MOBIFONE" {{ old('telecom') == 'MOBIFONE' ? 'selected' : '' }}>
                                                Mobifone
                                            </option>
                                            <option value="VINAPHONE" {{ old('telecom') == 'VINAPHONE' ? 'selected' : '' }}>
                                                Vinaphone
                                            </option>
                                        </select>
                                        @error('telecom')
                                            <div class="invalid-feedback">
                                                <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="amount" class="form-label">
                                            <i class="fa-solid fa-money-bill me-2"></i> Mệnh giá
                                        </label>
                                        <select class="form-control @error('amount') is-invalid @enderror" id="amount"
                                            name="amount" required>
                                            <option value="">Chọn mệnh giá</option>
                                            <option value="10000" {{ old('amount') == '10000' ? 'selected' : '' }}>
                                                10.000 VND
                                            </option>
                                            <option value="20000" {{ old('amount') == '20000' ? 'selected' : '' }}>
                                                20.000 VND
                                            </option>
                                            <option value="50000" {{ old('amount') == '50000' ? 'selected' : '' }}>
                                                50.000 VND
                                            </option>
                                            <option value="100000" {{ old('amount') == '100000' ? 'selected' : '' }}>
                                                100.000 VND
                                            </option>
                                            <option value="200000" {{ old('amount') == '200000' ? 'selected' : '' }}>
                                                200.000 VND
                                            </option>
                                            <option value="500000" {{ old('amount') == '500000' ? 'selected' : '' }}>
                                                500.000 VND
                                            </option>
                                        </select>
                                        @error('amount')
                                            <div class="invalid-feedback">
                                                <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="serial" class="form-label">
                                            <i class="fa-solid fa-barcode me-2"></i> Mã thẻ
                                        </label>
                                        <input type="text" class="form-control @error('serial') is-invalid @enderror"
                                            id="serial" name="serial" value="{{ old('serial') }}" required>
                                        @error('serial')
                                            <div class="invalid-feedback">
                                                <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="pin" class="form-label">
                                            <i class="fa-solid fa-key me-2"></i> Mã PIN
                                        </label>
                                        <input type="text" class="form-control @error('pin') is-invalid @enderror"
                                            id="pin" name="pin" value="{{ old('pin') }}" required>
                                        @error('pin')
                                            <div class="invalid-feedback">
                                                <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group mt-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa-solid fa-check me-2"></i> Nạp tiền
                                        </button>
                                    </div>
                                </form>

                                <div class="deposit-notice">
                                    <div class="notice-header">
                                        @if (config_get('payment.card.discount_percent') == 0)
                                            NẠP THẺ KHÔNG CHIẾT KHẤU
                                        @else
                                            NẠP THẺ CHIẾT KHẤU {{ config_get('payment.card.discount_percent') }}%
                                        @endif
                                    </div>
                                    <div class="notice-content">Ví dụ nạp 100K nhận
                                        {{ 100 - (100 * config_get('payment.card.discount_percent')) / 100 }}K</div>
                                    <div class="notice-warning">SAI MỆNH GIÁ -50% GIÁ TRỊ GỐC CỦA THẺ</div>
                                </div>

                                <div class="deposit-history">
                                    <div class="history-header">LỊCH SỬ NẠP THẺ</div>
                                    <div class="history-table-container">
                                        <table class="history-table">
                                            <thead>
                                                <tr>
                                                    <th>Trạng thái</th>
                                                    <th>Thời gian</th>
                                                    <th>Nhà mạng</th>
                                                    <th>Mệnh giá</th>
                                                    <th>Thực nhận</th>
                                                    <th>Mã thẻ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($transactions as $transaction)
                                                    <tr>
                                                        <td>{!! display_status($transaction->status) !!}</td>
                                                        <td>{{ $transaction->created_at }}</td>
                                                        <td>{{ $transaction->telco }}</td>
                                                        <td>{{ number_format($transaction->amount) }} VND</td>
                                                        <td>{{ number_format($transaction->received_amount) }} VND</td>
                                                        <td>{{ substr($transaction->pin, 0, 3) . '******' }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="no-data">Không có dữ liệu</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="pagination">
                                        {{ $transactions->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const amountSelect = document.getElementById('amount');
                const receiveAmount = document.getElementById('receive-amount');

                // Update received amount when amount changes
                amountSelect.addEventListener('change', function() {
                    receiveAmount.textContent = new Intl.NumberFormat('vi-VN').format(this.value) + ' VND';
                });

            });
        </script>
    @endpush
@endsection
