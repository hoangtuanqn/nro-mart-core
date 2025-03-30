@extends('layouts.user.app')

@section('title', 'Nạp tiền thẻ cào')

@section('content')
    <section class="profile-section">
        <div class="container">
            <div class="profile-container">
                <div class="profile-header">
                    <h1 class="profile-title">NẠP TIỀN THẺ CÀO</h1>
                </div>

                <div class="profile-content">
                    @include('layouts.user.sidebar')

                    <div class="profile-main">
                        <div class="profile-info-card">
                            <div class="info-header">
                                <div class="balance-info">
                                    <span class="balance-label">SỐ DƯ:</span>
                                    <span class="balance-value">{{ number_format(Auth::user()->balance ?? 0) }} VND</span>
                                </div>
                            </div>

                            <div class="info-content">
                                <!-- Thêm phần thông báo lỗi và thành công -->
                                @if ($errors->any())
                                    <div class="service__alert service__alert--error">
                                        <i class="fas fa-exclamation-circle"></i>
                                        <div>
                                            <span>Đã có lỗi xảy ra:</span>
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <button type="button" class="service__alert-close">&times;</button>
                                    </div>
                                @endif
                                @foreach (['error', 'success'] as $msg)
                                    @if (session($msg))
                                        <div
                                            class="service__alert service__alert--{{ $msg === 'error' ? 'error' : 'success' }}">
                                            <i
                                                class="fas fa-{{ $msg === 'error' ? 'exclamation-circle' : 'check-circle' }}"></i>
                                            <div>
                                                <span>{{ session($msg) }}</span>
                                            </div>
                                            <button type="button" class="service__alert-close">&times;</button>
                                        </div>
                                    @endif
                                @endforeach
                                <!-- Kết thúc phần thông báo -->

                                <form method="POST" action="{{ route('profile.deposit-card') }}" class="register-form">
                                    @csrf

                                    <div class="form-group">
                                        <label for="telco" class="form-label">Nhà mạng:</label>
                                        <select id="telco" name="telco"
                                            class="form-input @error('telco') is-invalid @enderror">
                                            <option value="VIETTEL">Viettel</option>
                                            <option value="MOBIFONE">Mobifone</option>
                                            <option value="VINAPHONE">Vinaphone</option>
                                            <option value="VIETNAMOBILE">Vietnamobile</option>
                                        </select>
                                        @error('telco')
                                            <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="amount" class="form-label">Mệnh giá:</label>
                                        <select id="amount" name="amount"
                                            class="form-input @error('amount') is-invalid @enderror">
                                            <option value="10000">10,000 VND</option>
                                            <option value="20000">20,000 VND</option>
                                            <option value="50000">50,000 VND</option>
                                            <option value="100000">100,000 VND</option>
                                            <option value="200000">200,000 VND</option>
                                            <option value="500000">500,000 VND</option>
                                        </select>
                                        @error('amount')
                                            <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Nhận được:</label>
                                        <div class="receive-amount form-input" id="receive-amount">10.000 VND</div>
                                    </div>

                                    <div class="form-group">
                                        <label for="serial" class="form-label">Số seri:</label>
                                        <input type="text" id="serial" name="serial" value="{{ old('serial') }}"
                                            class="form-input @error('serial') is-invalid @enderror"
                                            placeholder="Nhập mã serial nằm sau thẻ" required>
                                        @error('serial')
                                            <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="pin" class="form-label">Mã thẻ:</label>
                                        <input type="text" id="pin" name="pin" value="{{ old('pin') }}"
                                            class="form-input @error('pin') is-invalid @enderror"
                                            placeholder="Nhập mã số sau lớp bạc mỏng" required>
                                        @error('pin')
                                            <span class="form-error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <button type="submit" class="register-btn">NẠP THẺ</button>
                                </form>

                                <div class="deposit-notice">
                                    <div class="notice-header">NẠP THẺ KHÔNG CHIẾT KHẤU</div>
                                    <div class="notice-content">nạp 10k được 10k ...100k được 100k</div>
                                    <div class="notice-warning">SAI MỆNH GIÁ -50% THẺ</div>
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
                                                @if (isset($transactions) && count($transactions) > 0)
                                                    @foreach ($transactions as $transaction)
                                                        <tr>
                                                            <td>{!! display_status_nap_tien($transaction->status) !!}</td>
                                                            <td>{{ $transaction->created_at }}</td>
                                                            <td>{{ $transaction->telco }}</td>
                                                            <td>{{ number_format($transaction->amount) }} VND</td>
                                                            <td>{{ number_format($transaction->received_amount) }} VND</td>
                                                            <td>{{ substr($transaction->pin, 0, 3) . '******' }}</td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="7" class="no-data">Không có dữ liệu</td>
                                                    </tr>
                                                @endif
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
