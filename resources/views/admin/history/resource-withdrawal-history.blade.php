@extends('layouts.admin.app')
@section('title', 'Lịch sử rút vàng/ngọc')

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Lịch sử rút vàng/ngọc</h4>
                    <h6>Xem và quản lý yêu cầu rút vàng/ngọc của người dùng</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table datanew">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Người dùng</th>
                                    <th>Loại</th>
                                    <th>Số lượng</th>
                                    <th>Tên nhân vật</th>
                                    <th>Máy chủ</th>
                                    <th>Ghi chú người dùng</th>
                                    <th>Ghi chú admin</th>
                                    <th>Trạng thái</th>
                                    <th>Thời gian</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($withdrawals as $withdrawal)
                                    <tr>
                                        <td>{{ $withdrawal->id }}</td>
                                        <td>
                                            <a href="{{ route('admin.users.show', $withdrawal->user_id) }}">
                                                {{ $withdrawal->user->username ?? 'N/A' }}
                                            </a>
                                        </td>
                                        <td>
                                            @if ($withdrawal->type === 'gold')
                                                <span class="badge bg-warning">Vàng</span>
                                            @else
                                                <span class="badge bg-info">Ngọc</span>
                                            @endif
                                        </td>
                                        <td>{{ number_format($withdrawal->amount) }}</td>
                                        <td>{{ $withdrawal->character_name }}</td>
                                        <td>{{ $withdrawal->server }}</td>
                                        <td>{{ $withdrawal->user_note ?? 'Không có' }}</td>
                                        <td>{{ $withdrawal->admin_note ?? 'Chưa có' }}</td>
                                        <td>
                                            {!! display_status_admin($withdrawal->status) !!}
                                            {{-- @if ($withdrawal->status === 'processing')
                                                <span class="badges bg-warning">Đang xử lý</span>
                                            @elseif ($withdrawal->status === 'completed')
                                                <span class="badges bg-success">Đã hoàn thành</span>
                                            @else
                                                <span class="badges bg-danger">Đã hủy</span>
                                            @endif --}}
                                        </td>
                                        <td>{{ $withdrawal->created_at->format('d/m/Y H:i:s') }}</td>
                                        <td>
                                            @if ($withdrawal->status === 'processing')
                                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#successModal{{ $withdrawal->id }}">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#errorModal{{ $withdrawal->id }}">
                                                    <i class="fa fa-times"></i>
                                                </button>

                                                <!-- Success Modal -->
                                                <div class="modal fade" id="successModal{{ $withdrawal->id }}"
                                                    tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Xác nhận duyệt rút
                                                                    {{ $withdrawal->type === 'gold' ? 'vàng' : 'ngọc' }}
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form
                                                                action="{{ route('admin.withdrawals.resources.approve', $withdrawal->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <p>Bạn có chắc chắn muốn duyệt yêu cầu rút
                                                                        {{ number_format($withdrawal->amount) }}
                                                                        {{ $withdrawal->type === 'gold' ? 'vàng' : 'ngọc' }}
                                                                        này?</p>
                                                                    <div class="form-group">
                                                                        <label for="admin_note">Ghi chú:</label>
                                                                        <textarea class="form-control" id="admin_note" name="admin_note" rows="3" placeholder="Nhập ghi chú (nếu có)"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Hủy</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Duyệt</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Error Modal -->
                                                <div class="modal fade" id="errorModal{{ $withdrawal->id }}" tabindex="-1"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Xác nhận từ chối rút
                                                                    {{ $withdrawal->type === 'gold' ? 'vàng' : 'ngọc' }}
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form
                                                                action="{{ route('admin.withdrawals.resources.reject', $withdrawal->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <p>Bạn có chắc chắn muốn từ chối yêu cầu rút
                                                                        {{ number_format($withdrawal->amount) }}
                                                                        {{ $withdrawal->type === 'gold' ? 'vàng' : 'ngọc' }}
                                                                        này?</p>
                                                                    <p><strong>Lưu ý:</strong>
                                                                        {{ $withdrawal->type === 'gold' ? 'Vàng' : 'Ngọc' }}
                                                                        sẽ được hoàn trả lại cho người dùng.</p>
                                                                    <div class="form-group">
                                                                        <label for="admin_note">Ghi chú:</label>
                                                                        <textarea class="form-control" id="admin_note" name="admin_note" rows="3" placeholder="Nhập lý do từ chối"
                                                                            required></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Hủy</button>
                                                                    <button type="submit" class="btn btn-danger">Từ
                                                                        chối</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- <div class="pagination-area mt-3">
                        {{ $withdrawals->links() }}
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
