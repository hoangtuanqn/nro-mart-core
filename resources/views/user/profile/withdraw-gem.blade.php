@extends('layouts.user.app')

@section('title', $title)

@section('content')
    <section class="profile-section">
        <div class="container">
            <div class="profile-container">
                <div class="profile-header">
                    <h1 class="profile-title"><i class="fa-solid fa-gem me-2"></i> RÚT NGỌC</h1>
                </div>

                <div class="profile-content">
                    @include('layouts.user.sidebar')

                    <div class="profile-main">
                        <div class="profile-info-card">
                            <div class="info-header">
                                <div class="balance-info">
                                    <span class="balance-label"><i class="fa-solid fa-gem me-2"></i> SỐ NGỌC HIỆN TẠI:
                                        {{ number_format(auth()->user()->gem) }}</span>
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

                                <form action="{{ route('profile.withdraw-gem') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="amount" class="form-label">
                                            <i class="fa-solid fa-gem me-2"></i> Số lượng ngọc muốn rút
                                        </label>
                                        <input type="number" value="0"
                                            class="form-control @error('amount') is-invalid @enderror" id="amount"
                                            name="amount" value="{{ old('amount') }}" required min="10"
                                            max="10000">
                                        <div class="form-text">Tối thiểu: 10 ngọc - Tối đa: 10,000 ngọc</div>
                                        @error('amount')
                                            <div class="invalid-feedback">
                                                <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="character_name" class="form-label">
                                            <i class="fa-solid fa-user me-2"></i> Tên nhân vật
                                        </label>
                                        <input type="text"
                                            class="form-control @error('character_name') is-invalid @enderror"
                                            id="character_name" name="character_name" value="{{ old('character_name') }}"
                                            required>
                                        @error('character_name')
                                            <div class="invalid-feedback">
                                                <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="server" class="form-label">
                                            <i class="fa-solid fa-server me-2"></i> Máy chủ
                                        </label>
                                        <select class="form-control @error('server') is-invalid @enderror" id="server"
                                            name="server" required>
                                            <option value="">Chọn máy chủ</option>
                                            @for ($i = 1; $i <= 13; $i++)
                                                <option value="{{ $i }}"
                                                    {{ old('server') == $i ? 'selected' : '' }}>
                                                    Máy chủ {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                        @error('server')
                                            <div class="invalid-feedback">
                                                <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="user_note" class="form-label">
                                            <i class="fa-solid fa-note-sticky me-2"></i> Ghi chú
                                        </label>
                                        <textarea class="form-control @error('user_note') is-invalid @enderror" id="user_note" name="user_note" rows="3"
                                            placeholder="Ghi chú thêm về yêu cầu rút ngọc (nếu có)">{{ old('user_note') }}</textarea>
                                        @error('user_note')
                                            <div class="invalid-feedback">
                                                <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group mt-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa-solid fa-check me-2"></i> Gửi yêu cầu
                                        </button>
                                    </div>
                                </form>

                                <div class="withdrawal-history mt-5">
                                    <div class="history-header">LỊCH SỬ RÚT NGỌC</div>
                                    <div class="history-table-container">
                                        <table class="history-table">
                                            <thead>
                                                <tr>
                                                    <th>Trạng thái</th>
                                                    <th>Thời gian</th>
                                                    <th>Số lượng</th>
                                                    <th>Tên nhân vật</th>
                                                    <th>Máy chủ</th>
                                                    <th>Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (isset($withdrawals) && count($withdrawals) > 0)
                                                    @foreach ($withdrawals as $withdrawal)
                                                        <tr>
                                                            <td>
                                                                {!! display_status($withdrawal->status) !!}
                                                            </td>
                                                            <td>{{ $withdrawal->created_at->format('d/m/Y H:i:s') }}</td>
                                                            <td>{{ number_format($withdrawal->amount) }}</td>
                                                            <td>{{ $withdrawal->character_name }}</td>
                                                            <td>{{ $withdrawal->server }}</td>
                                                            <td>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-info view-details"
                                                                    data-id="{{ $withdrawal->id }}" data-type="gem">
                                                                    <i class="fa-solid fa-eye"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="6" class="text-center">Chưa có lịch sử rút ngọc</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    @if (isset($withdrawals) && count($withdrawals) > 0)
                                        <div class="pagination-area mt-3">
                                            {{ $withdrawals->links() }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Withdrawal Details Modal -->
    <div id="withdrawalDetailsModal" class="modal">
        <div class="modal__content">
            <div class="modal__header">
                <h2 class="modal__title"><i class="fa-solid fa-circle-info me-2"></i> Chi tiết rút ngọc #<span
                        id="withdrawal-id"></span></h2>
                <button class="modal__close" onclick="closeWithdrawalModal()">&times;</button>
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
                        <span class="modal__value" id="withdrawal-time"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-gem me-2"></i> Loại tài nguyên:</span>
                        <span class="modal__value" id="withdrawal-type"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-gem me-2"></i> Số lượng:</span>
                        <span class="modal__value" id="withdrawal-amount"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-user me-2"></i> Tên nhân vật:</span>
                        <span class="modal__value" id="character-name"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-server me-2"></i> Máy chủ:</span>
                        <span class="modal__value" id="withdrawal-server"></span>
                    </div>
                    <div class="modal__row">
                        <span class="modal__label"><i class="fa-solid fa-circle-check me-2"></i> Trạng thái:</span>
                        <span class="modal__value" id="withdrawal-status"></span>
                    </div>
                    <div class="modal__row" id="user-note-container">
                        <span class="modal__label"><i class="fa-solid fa-note-sticky me-2"></i> Ghi chú người dùng:</span>
                        <span class="modal__value" id="user-note"></span>
                    </div>
                    <div class="modal__row" id="admin-note-container">
                        <span class="modal__label"><i class="fa-solid fa-note-sticky me-2"></i> Ghi chú admin:</span>
                        <span class="modal__value" id="admin-note"></span>
                    </div>
                </div>

                <div id="modal-error" class="alert alert-danger" style="display: none;">
                    <i class="fa-solid fa-circle-exclamation me-2"></i> <span id="error-message"></span>
                </div>
            </div>

            <div class="modal__footer">
                <button class="modal__btn modal__btn--close" onclick="closeWithdrawalModal()">ĐÓNG</button>
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
                    const withdrawalId = this.getAttribute('data-id');
                    document.getElementById('withdrawal-id').textContent = withdrawalId;

                    // Show loading, hide content and errors
                    document.getElementById('modal-loading').style.display = 'block';
                    document.getElementById('modal-content').style.display = 'none';
                    document.getElementById('modal-error').style.display = 'none';

                    // Show the modal
                    openWithdrawalModal();

                    // Fetch withdrawal details via AJAX
                    fetch(`/profile/withdrawal-history/${withdrawalId}`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('modal-loading').style.display = 'none';

                            if (data.status === 'success') {
                                // Format data and populate the modal
                                document.getElementById('withdrawal-time').textContent =
                                    new Date(
                                        data.created_at).toLocaleString('vi-VN');
                                document.getElementById('withdrawal-type').textContent = data
                                    .type === 'gold' ? 'Vàng' : 'Ngọc';
                                document.getElementById('withdrawal-amount').textContent =
                                    new Intl.NumberFormat('vi-VN').format(data.amount);
                                document.getElementById('character-name').textContent = data
                                    .character_name;
                                document.getElementById('withdrawal-server').textContent =
                                    'Server ' + data.server;
                                document.getElementById('withdrawal-status').innerHTML = data
                                    .status_html;

                                // Display user note if exists
                                if (data.user_note) {
                                    document.getElementById('user-note').textContent = data
                                        .user_note;
                                    document.getElementById('user-note-container').style
                                        .display = 'flex';
                                } else {
                                    document.getElementById('user-note').textContent =
                                        "Không có ghi chú";
                                }

                                // Display admin note if exists
                                if (data.admin_note) {
                                    document.getElementById('admin-note').textContent = data
                                        .admin_note;
                                    document.getElementById('admin-note-container').style
                                        .display = 'flex';
                                } else {
                                    document.getElementById('admin-note').textContent =
                                        "Không có ghi chú";
                                }

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
                            console.error('Error fetching withdrawal details:', error);
                            document.getElementById('modal-loading').style.display = 'none';
                            document.getElementById('error-message').textContent =
                                'Đã xảy ra lỗi kết nối, vui lòng thử lại sau';
                            document.getElementById('modal-error').style.display = 'block';
                        });
                });
            });
        });

        // Function to open withdrawal modal
        function openWithdrawalModal() {
            document.getElementById('withdrawalDetailsModal').style.display = 'block';
            document.body.style.overflow = 'hidden'; // Prevent scrolling when modal is open
        }

        // Function to close withdrawal modal
        function closeWithdrawalModal() {
            document.getElementById('withdrawalDetailsModal').style.display = 'none';
            document.body.style.overflow = ''; // Restore scrolling
        }
    </script>
@endpush
