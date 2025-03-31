@extends('layouts.user.app')

@section('title', $title)

@section('content')
    <section class="profile-section">
        <div class="container">
            <div class="profile-container">
                <div class="profile-header">
                    <h1 class="profile-title">TÀI KHOẢN ĐÃ MUA</h1>
                </div>

                <div class="profile-content">
                    @include('layouts.user.sidebar')

                    <div class="profile-main">
                        <div class="profile-info-card">
                            <div class="info-header">
                                <div class="balance-info">
                                    <span class="balance-label">TÀI KHOẢN ĐÃ MUA</span>
                                </div>
                            </div>

                            <div class="info-content">
                                <div class="transaction-history">
                                    <div class="history-table-container">
                                        <table class="history-table">
                                            <thead>
                                                <tr>
                                                    <th>Thời gian</th>
                                                    <th>Mã</th>
                                                    <th>Máy chủ</th>
                                                    <th>Tài khoản</th>
                                                    <th>Mật khẩu</th>
                                                    <th>Số tiền</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($transactions as $transaction)
                                                    <tr>
                                                        <td>{{ $transaction->created_at->format('H:i d/m/Y') }}</td>
                                                        <td><a target="_blank" class="text-danger"
                                                                href="{{ route("account.show", ['id' => $transaction->id]) }}">#{{ $transaction->id }}</a>
                                                        </td>
                                                        <td>Server {{ $transaction->server }}</td>
                                                        <td class="text-bold">{{ $transaction->account_name }}</td>
                                                        <td class="text-bold">{{ $transaction->password }}</td>
                                                        <td class="amount text-danger">
                                                            -{{ number_format($transaction->price) }} VND
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="no-data">Không có dữ liệu</td>
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
@endsection
