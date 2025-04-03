@extends('layouts.user.app')

@section('title', $title)

@section('content')
    <section class="profile-section">
        <div class="container">
            <div class="profile-container">
                <div class="profile-header">
                    <h1 class="profile-title"><i class="fa-solid fa-clock-rotate-left me-2"></i> LỊCH SỬ VẬN MAY</h1>
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
                                                    <th>Vòng quay</th>
                                                    <th>Số lượt quay</th>
                                                    <th>Chi phí</th>
                                                    <th>Phần thưởng</th>
                                                    <th>Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($wheelHistories as $history)
                                                    <tr>
                                                        <td>{{ $history->created_at->format('H:i d/m/Y') }}</td>
                                                        <td>{{ $history->luckyWheel->name }}</td>
                                                        <td>{{ $history->spin_count }}</td>
                                                        <td class="amount text-danger">
                                                            -{{ number_format($history->total_cost) }} VND</td>
                                                        <td>
                                                            @if ($history->reward_type === 'gold')
                                                                <span class="status-badge status-completed">
                                                                    <i class="fa-solid fa-coins me-1"></i>
                                                                    {{ number_format($history->reward_amount) }} vàng
                                                                </span>
                                                            @else
                                                                <span class="status-badge status-completed">
                                                                    <i class="fa-solid fa-gem me-1"></i>
                                                                    {{ number_format($history->reward_amount) }} ngọc
                                                                </span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-info view-details"
                                                                data-id="{{ $history->id }}">
                                                                <i class="fa-solid fa-eye"></i>
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
                                        {{ $wheelHistories->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Lucky Wheel Details Modal -->
    <div id="wheelDetailsModal" class="modal">
        <div class="modal__content">
            <div class="modal__header">
                <h2 class="modal__title"><i class="fa-solid fa-circle-info me-2"></i> Chi tiết vòng quay #<span
                        id="wheel-id"></span></h2>
                <button class="modal__close" onclick="closeWheelModal()">&times;</button>
            </div>

            <div class="modal__body">
                <div id="wheel-modal-loading" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Đang tải...</span>
                    </div>
                    <p class="mt-2">Đang tải thông tin...</p>
                </div>

                <div id="wheel-modal-content" class="modal__info" style="display: none;">
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-calendar me-2"></i> Thời gian:</span>
                        <span class="modal__value" id="wheel-time"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-circle me-2"></i> Vòng quay:</span>
                        <span class="modal__value" id="wheel-name"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-rotate me-2"></i> Số lượt quay:</span>
                        <span class="modal__value" id="wheel-spin-count"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-money-bill me-2"></i> Chi phí:</span>
                        <span class="modal__value modal__value--price" id="wheel-cost"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-gift me-2"></i> Phần thưởng:</span>
                        <span class="modal__value" id="wheel-reward"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-note-sticky me-2"></i> Mô tả:</span>
                        <span class="modal__value" id="wheel-description"></span>
                    </div>
                </div>

                <div id="wheel-modal-error" class="alert alert-danger" style="display: none;">
                    <i class="fa-solid fa-circle-exclamation me-2"></i> <span id="wheel-error-message"></span>
                </div>
            </div>

            <div class="modal__footer">
                <button class="modal__btn modal__btn--close" onclick="closeWheelModal()">ĐÓNG</button>
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
                    const wheelId = this.getAttribute('data-id');
                    document.getElementById('wheel-id').textContent = wheelId;

                    // Show loading, hide content and errors
                    document.getElementById('wheel-modal-loading').style.display = 'block';
                    document.getElementById('wheel-modal-content').style.display = 'none';
                    document.getElementById('wheel-modal-error').style.display = 'none';

                    // Show the modal
                    openWheelModal();

                    // Fetch wheel details via AJAX
                    fetch(`/profile/wheel-history/${wheelId}`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('wheel-modal-loading').style.display =
                                'none';

                            if (data.status === 'success') {
                                // Format data and populate the modal
                                document.getElementById('wheel-time').textContent = new Date(
                                    data.created_at).toLocaleString('vi-VN');
                                document.getElementById('wheel-name').textContent = data
                                    .lucky_wheel.name;
                                document.getElementById('wheel-spin-count').textContent = data
                                    .spin_count;
                                document.getElementById('wheel-cost').textContent = '-' +
                                    new Intl.NumberFormat('vi-VN').format(data.total_cost) +
                                    ' VND';

                                // Format reward based on type
                                let rewardText = '';
                                if (data.reward_type === 'gold') {
                                    rewardText =
                                        `<i class="fa-solid fa-coins me-1"></i> ${new Intl.NumberFormat('vi-VN').format(data.reward_amount)} vàng`;
                                } else {
                                    rewardText =
                                        `<i class="fa-solid fa-gem me-1"></i> ${new Intl.NumberFormat('vi-VN').format(data.reward_amount)} ngọc`;
                                }
                                document.getElementById('wheel-reward').innerHTML = rewardText;

                                document.getElementById('wheel-description').textContent = data
                                    .description || 'Không có mô tả';

                                // Show the content
                                document.getElementById('wheel-modal-content').style.display =
                                    'block';
                            } else {
                                // Show error message
                                document.getElementById('wheel-error-message').textContent =
                                    data
                                    .message || 'Đã xảy ra lỗi khi tải dữ liệu';
                                document.getElementById('wheel-modal-error').style.display =
                                    'block';
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching wheel details:', error);
                            document.getElementById('wheel-modal-loading').style.display =
                                'none';
                            document.getElementById('wheel-error-message').textContent =
                                'Đã xảy ra lỗi kết nối, vui lòng thử lại sau';
                            document.getElementById('wheel-modal-error').style.display =
                                'block';
                        });
                });
            });
        });

        // Function to open wheel modal
        function openWheelModal() {
            document.getElementById('wheelDetailsModal').style.display = 'block';
            document.body.style.overflow = 'hidden'; // Prevent scrolling when modal is open
        }

        // Function to close wheel modal
        function closeWheelModal() {
            document.getElementById('wheelDetailsModal').style.display = 'none';
            document.body.style.overflow = ''; // Restore scrolling
        }
    </script>
@endpush
