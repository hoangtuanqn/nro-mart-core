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
                                                                data-id="{{ $service->id }}">
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

    <!-- Service Details Modal -->
    <div id="serviceDetailsModal" class="modal">
        <div class="modal__content">
            <div class="modal__header">
                <h2 class="modal__title"><i class="fa-solid fa-circle-info me-2"></i> Chi tiết dịch vụ #<span
                        id="service-id"></span></h2>
                <button class="modal__close" onclick="closeServiceModal()">&times;</button>
            </div>

            <div class="modal__body">
                <div id="modal-loading" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Đang tải...</span>
                    </div>
                    <p class="mt-2">Đang tải thông tin...</p>
                </div>

                <div id="modal-content" class="modal__info" style="display: none;">
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-calendar me-2"></i> Thời gian:</span>
                        <span class="modal__value" id="service-time"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-server me-2"></i> Máy chủ:</span>
                        <span class="modal__value" id="service-server"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-cube me-2"></i> Dịch vụ:</span>
                        <span class="modal__value" id="service-name"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-money-bill me-2"></i> Giá trị:</span>
                        <span class="modal__value modal__value--price" id="service-price"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-circle-check me-2"></i> Trạng thái:</span>
                        <span class="modal__value" id="service-status"></span>
                    </div>
                    <div class="modal__row" id="admin-note-container">
                        <span class="modal__label"><i class="fa-solid fa-note-sticky me-2"></i> Ghi chú:</span>
                        <span class="modal__value" id="admin-note"></span>
                    </div>
                </div>

                <div id="modal-error" class="alert alert-danger" style="display: none;">
                    <i class="fa-solid fa-circle-exclamation me-2"></i> <span id="error-message"></span>
                </div>
            </div>

            <div class="modal__footer">
                <button class="modal__btn modal__btn--close" onclick="closeServiceModal()">ĐÓNG</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get all view details buttons
            const viewButtons = document.querySelectorAll('.view-details');

            // Add click event to each button
            viewButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const serviceId = this.getAttribute('data-id');
                    document.getElementById('service-id').textContent = serviceId;

                    // Show loading, hide content and errors
                    document.getElementById('modal-loading').style.display = 'block';
                    document.getElementById('modal-content').style.display = 'none';
                    document.getElementById('modal-error').style.display = 'none';

                    // Show the modal
                    openServiceModal();

                    // Fetch service details via AJAX
                    fetch(`/profile/service-history/${serviceId}`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('modal-loading').style.display = 'none';

                            if (data.status === 'success') {
                                // Format data and populate the modal
                                document.getElementById('service-time').textContent = new Date(
                                    data.created_at).toLocaleString('vi-VN');
                                document.getElementById('service-server').textContent =
                                    'Server ' + data.server;
                                document.getElementById('service-name').textContent = data
                                    .game_service.name;
                                document.getElementById('service-price').textContent = '-' +
                                    new Intl.NumberFormat('vi-VN').format(data.price) + ' VND';
                                document.getElementById('service-status').innerHTML = data
                                    .status_html;
                                document.getElementById('admin-note').textContent = data
                                    .admin_note ? data.admin_note : "Không có ghi chú";



                                // Show the content
                                document.getElementById('modal-content').style.display =
                                    'block';
                            } else {
                                // Show error message
                                document.getElementById('error-message').textContent = data
                                    .message || 'Đã xảy ra lỗi khi tải dữ liệu';
                                document.getElementById('modal-error').style.display = 'block';
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching service details:', error);
                            document.getElementById('modal-loading').style.display = 'none';
                            document.getElementById('error-message').textContent =
                                'Đã xảy ra lỗi kết nối, vui lòng thử lại sau';
                            document.getElementById('modal-error').style.display = 'block';
                        });
                });
            });
        });

        // Function to open service modal
        function openServiceModal() {
            document.getElementById('serviceDetailsModal').style.display = 'block';
            document.body.style.overflow = 'hidden'; // Prevent scrolling when modal is open
        }

        // Function to close service modal
        function closeServiceModal() {
            document.getElementById('serviceDetailsModal').style.display = 'none';
            document.body.style.overflow = ''; // Restore scrolling
        }
    </script>
@endpush
