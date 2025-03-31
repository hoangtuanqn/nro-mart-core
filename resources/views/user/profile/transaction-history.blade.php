@extends('layouts.user.app')

@section('title', $title)

@section('content')
    <section class="profile-section">
        <div class="container">
            <div class="profile-container">
                <div class="profile-header">
                    <h1 class="profile-title">LỊCH SỬ GIAO DỊCH</h1>
                </div>

                <div class="profile-content">
                    @include('layouts.user.sidebar')

                    <div class="profile-main">
                        <div class="profile-info-card">
                            <div class="info-header">
                                <div class="balance-info">
                                    <span class="balance-label">LỊCH SỬ GIAO DỊCH</span>
                                </div>
                            </div>

                            <div class="info-content">
                                <div class="transaction-history">
                                    <div class="history-table-container">
                                        <table class="history-table">
                                            <thead>
                                                <tr>
                                                    <th>Thời gian</th>
                                                    <th>Giao dịch</th>
                                                    <th>Trước giao dịch</th>
                                                    <th>Số tiền</th>
                                                    <th>Sau giao dịch</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($transactions as $transaction)
                                                    <tr>
                                                        <td>{{ $transaction->created_at->format('H:i d/m/Y') }}</td>
                                                        <td>{{ $transaction->description }}</td>
                                                        <td>{{ number_format($transaction->balance_before) }} VND</td>

                                                        <td
                                                            class="amount {{ $transaction->amount >= 0 ? 'text-success' : 'text-danger' }}">
                                                            {{ number_format($transaction->amount) }} VND
                                                        </td>
                                                        <td>{{ number_format($transaction->balance_after) }} VND</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="no-data">Không có dữ liệu</td>
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