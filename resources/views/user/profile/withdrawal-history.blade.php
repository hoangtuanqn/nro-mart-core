@extends('layouts.user.app')

@section('title', $title)

@section('content')
    <section class="profile-section">
        <div class="container">
            <div class="profile-container">
                <div class="profile-header">
                    <h1 class="profile-title"><i class="fa-solid fa-history me-2"></i> LỊCH SỬ RÚT TIỀN</h1>
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

                                <div class="transaction-history">
                                    <div class="history-table-container">
                                        <table class="history-table">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Số tiền</th>
                                                    <th>Ghi chú</th>
                                                    <th>Phản hồi admin</th>
                                                    <th>Trạng thái</th>
                                                    <th>Thời gian</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($withdrawals) > 0)
                                                    @foreach ($withdrawals as $withdrawal)
                                                        <tr>
                                                            <td>{{ $withdrawal->id }}</td>
                                                            <td class="text-danger">{{ number_format($withdrawal->amount) }}
                                                                VND</td>
                                                            <td>{{ $withdrawal->user_note ?? 'Không có' }}</td>
                                                            <td>{{ $withdrawal->admin_note ?? 'Chưa có phản hồi' }}</td>
                                                            <td>
                                                                @if ($withdrawal->status === 'processing')
                                                                    <span class="badge bg-warning">Đang xử lý</span>
                                                                @elseif ($withdrawal->status === 'success')
                                                                    <span class="badge bg-success">Thành công</span>
                                                                @else
                                                                    <span class="badge bg-danger">Thất bại</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $withdrawal->created_at->format('d/m/Y H:i:s') }}</td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="6" class="no-data">Không có dữ liệu</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="pagination">
                                        {{ $withdrawals->links() }}
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
