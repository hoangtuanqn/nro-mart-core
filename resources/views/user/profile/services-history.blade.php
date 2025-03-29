@extends('layouts.user.app')

@section('title', 'Dịch vụ đã thuê')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <section class="profile-section">
        <div class="container">
            <div class="profile-container">
                <div class="profile-header">
                    <h1 class="profile-title">DỊCH VỤ ĐÃ THUÊ</h1>
                </div>

                <div class="profile-content">
                    @include('layouts.user.sidebar')

                    <div class="profile-main">
                        <div class="profile-info-card">
                            <div class="info-header">
                                <div class="balance-info">
                                    <span class="balance-label">DỊCH VỤ ĐÃ THUÊ</span>
                                </div>
                            </div>

                            <div class="info-content">
                                <div class="transaction-history">
                                    <div class="history-table-container">
                                        <table class="history-table">
                                            <thead>
                                                <tr>
                                                    <th>Thời gian</th>
                                                    <th>Mã giao dịch</th>
                                                    <th>Server</th>
                                                    <th>Loại dịch vụ</th>
                                                    <th>Trị giá</th>
                                                    <th>Trạng thái</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($serviceHistories as $history)
                                                    <tr>
                                                        <td>{{ $history->created_at->format('H:i d/m/Y') }}</td>
                                                        <td>
                                                            <span class="text-danger">#{{ $history->id }}</span>
                                                        </td>
                                                        <td>Server {{ $history->server }}</td>
                                                        <td class="text-bold">{{ $history->gameService->name }}</td>
                                                        <td class="amount text-danger">
                                                            -{{ number_format($history->price) }} VND
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-primary btn-sm"
                                                                onclick="showServiceDetail({{ $history->id }})">
                                                                Chi tiết
                                                            </button>
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

    <!-- Service Detail Modal -->
    <div id="serviceDetailModal" class="modal">
        <div class="modal__content">
            <div class="modal__header">
                <h2 class="modal__title">CHI TIẾT DỊCH VỤ #<span id="serviceId"></span></h2>
                <button class="modal__close" onclick="closeServiceModal()">&times;</button>
            </div>

            <div class="modal__body">
                <div class="modal__info">
                    <div class="modal__row">
                        <span class="modal__label">Loại dịch vụ:</span>
                        <span class="modal__value" id="serviceName"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label">Tài khoản game:</span>
                        <span class="modal__value text-danger" id="gameAccount"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label">Server:</span>
                        <span class="modal__value" id="serverNumber"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label">Gói dịch vụ:</span>
                        <span class="modal__value" id="packageName"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label">Giá tiền:</span>
                        <span class="modal__value modal__value--price" id="servicePrice"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label">Trạng thái:</span>
                        <span class="modal__value" id="serviceStatus"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label">Ghi chú từ Admin:</span>
                        <span class="modal__value" id="adminNote"></span>
                    </div>
                </div>
            </div>

            <div class="modal__footer">
                <button class="modal__btn modal__btn--close" onclick="closeServiceModal()">ĐÓNG</button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function showServiceDetail(serviceId) {
                fetch(`/profile/service-history/${serviceId}`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.status === 'error') {
                            throw new Error(data.message);
                        }

                        document.getElementById('serviceId').textContent = data.id;
                        document.getElementById('serviceName').textContent = data.game_service.name;
                        document.getElementById('gameAccount').textContent = data.game_account;
                        document.getElementById('serverNumber').textContent = 'Server ' + data.server;
                        document.getElementById('packageName').textContent = data.service_package.name;
                        document.getElementById('servicePrice').textContent = new Intl.NumberFormat('vi-VN').format(data
                            .price) + ' VND';
                        document.getElementById('serviceStatus').innerHTML = data.status_html;
                        document.getElementById('adminNote').textContent = data.admin_note;

                        const modal = document.getElementById('serviceDetailModal');
                        modal.style.display = 'block';
                        document.body.style.overflow = 'hidden';
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Có lỗi xảy ra khi tải thông tin dịch vụ');
                    });
            }

            function closeServiceModal() {
                const modal = document.getElementById('serviceDetailModal');
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }

            // Close modal when clicking outside
            document.addEventListener('DOMContentLoaded', function () {
                const modal = document.getElementById('serviceDetailModal');
                window.addEventListener('click', function (event) {
                    if (event.target === modal) {
                        closeServiceModal();
                    }
                });
            });
        </script>
    @endpush
@endsection