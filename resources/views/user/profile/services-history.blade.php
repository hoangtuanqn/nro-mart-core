@extends('layouts.user.app')

@section('title', $title)

@section('content')
    <section class="profile-section">
        <div class="container">
            <div class="profile-container">
                <div class="profile-header">
                    <h1 class="profile-title"><i class="fa-solid fa-clipboard-list me-2"></i> DỊCH VỤ ĐÃ THUÊ</h1>
                </div>

                <div class="profile-content">
                    @include('layouts.user.sidebar')

                    <div class="profile-main">
                        <div class="profile-info-card">
                            <div class="info-header">
                                <div class="balance-info">
                                    <span class="balance-label"><i class="fa-solid fa-wallet me-2"></i> SỐ DƯ HIỆN TẠI:
                                        {{ number_format($user->balance) }} VND</span>
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
                                                    <th>Thời gian</th>
                                                    <th>Máy chủ</th>
                                                    <th>Dịch vụ</th>
                                                    <th>Giá trị</th>
                                                    <th>Trạng thái</th>
                                                    <th>Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($serviceHistories as $service)
                                                    <tr>
                                                        <td>{{ $service->created_at->format('H:i d/m/Y') }}</td>

                                                        <td>Server {{ $service->server }}</td>
                                                        <td>{{ $service->gameService->name }}</td>
                                                        <td class="amount text-danger">
                                                            -{{ number_format($service->price) }} VND</td>
                                                        <td>
                                                            @if ($service->status === 'pending')
                                                                <span class="status-badge status-pending">
                                                                    <i class="fa-solid fa-clock me-1"></i> Đang xử lý
                                                                </span>
                                                            @elseif($service->status === 'completed')
                                                                <span class="status-badge status-completed">
                                                                    <i class="fa-solid fa-check me-1"></i> Hoàn thành
                                                                </span>
                                                            @else
                                                                <span class="status-badge status-failed">
                                                                    <i class="fa-solid fa-xmark me-1"></i> Thất bại
                                                                </span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-info view-details"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#serviceDetailsModal{{ $service->id }}">
                                                                <i class="fa-solid fa-eye"></i>
                                                            </button>
                                                        </td>
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
                                        {{ $serviceHistories->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Details Modals -->
    @foreach ($serviceHistories as $service)
        <div class="modal fade" id="serviceDetailsModal{{ $service->id }}" tabindex="-1"
            aria-labelledby="serviceDetailsModalLabel{{ $service->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="serviceDetailsModalLabel{{ $service->id }}">
                            <i class="fa-solid fa-circle-info me-2"></i> Chi tiết dịch vụ #{{ $service->id }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="service-details">
                            <div class="detail-item">
                                <span class="detail-label"><i class="fa-solid fa-calendar me-2"></i> Thời gian:</span>
                                <span class="detail-value">{{ $service->created_at->format('H:i d/m/Y') }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label"><i class="fa-solid fa-server me-2"></i> Máy chủ:</span>
                                <span class="detail-value">Server {{ $service->server }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label"><i class="fa-solid fa-cube me-2"></i> Dịch vụ:</span>
                                <span class="detail-value">{{ $service->gameService->name }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label"><i class="fa-solid fa-money-bill me-2"></i> Giá trị:</span>
                                <span class="detail-value text-danger">-{{ number_format($service->price) }}
                                    VND</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label"><i class="fa-solid fa-circle-check me-2"></i> Trạng thái:</span>
                                <span class="detail-value">
                                    @if ($service->status === 'pending')
                                        <span class="status-badge status-pending">
                                            <i class="fa-solid fa-clock me-1"></i> Đang xử lý
                                        </span>
                                    @elseif($service->status === 'completed')
                                        <span class="status-badge status-completed">
                                            <i class="fa-solid fa-check me-1"></i> Hoàn thành
                                        </span>
                                    @else
                                        <span class="status-badge status-failed">
                                            <i class="fa-solid fa-xmark me-1"></i> Thất bại
                                        </span>
                                    @endif
                                </span>
                            </div>
                            @if ($service->admin_note)
                                <div class="detail-item">
                                    <span class="detail-label"><i class="fa-solid fa-note-sticky me-2"></i> Ghi chú:</span>
                                    <span class="detail-value">{{ $service->admin_note }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fa-solid fa-xmark me-2"></i> Đóng
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
