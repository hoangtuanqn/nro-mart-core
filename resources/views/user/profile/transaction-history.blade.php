@extends('layouts.user.app')

@section('title', 'Lịch sử giao dịch')

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
                                        {{-- {{ $transactions->links() }} --}}
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

<style>
    .transaction-history {
        width: 100%;
    }

    .history-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .history-table th,
    .history-table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }

    .history-table th {
        background-color: #f8f9fa;
        font-weight: 600;
        color: #333;
    }

    .history-table tr:hover {
        background-color: #f8f9fa;
    }

    .text-success {
        color: #28a745;
    }

    .text-danger {
        color: #dc3545;
    }

    .no-data {
        text-align: center;
        padding: 20px;
        color: #666;
    }

    .amount {
        font-weight: 600;
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 5px;
        margin-top: 20px;
    }

    .pagination .page-link {
        padding: 8px 12px;
        border: 1px solid #ddd;
        color: #333;
        text-decoration: none;
        border-radius: 4px;
    }

    .pagination .page-item.active .page-link {
        background-color: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .pagination .page-link:hover {
        background-color: #f8f9fa;
    }
</style>