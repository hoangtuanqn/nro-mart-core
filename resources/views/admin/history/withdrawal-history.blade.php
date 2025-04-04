@extends('layouts.admin.app')
@section('title', 'Lịch sử rút tiền')

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Lịch sử rút tiền</h4>
                    <h6>Xem và quản lý yêu cầu rút tiền của người dùng</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table datanew">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Người dùng</th>
                                    <th>Số tiền</th>
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
                                        <td>{{ $withdrawal->user->username }}</td>
                                        <td>{{ number_format($withdrawal->amount) }} đ</td>
                                        <td>{{ $withdrawal->user_note ?? 'Không có' }}</td>
                                        <td>{{ $withdrawal->admin_note ?? 'Không có' }}</td>
                                        <td>
                                            @if ($withdrawal->status === 'processing')
                                                <span class="badges bg-lightyellow">Đang xử lý</span>
                                            @elseif ($withdrawal->status === 'success')
                                                <span class="badges bg-lightgreen">Thành công</span>
                                            @else
                                                <span class="badges bg-lightred">Lỗi</span>
                                            @endif
                                        </td>
                                        <td>{{ $withdrawal->created_at->format('d/m/Y H:i:s') }}</td>
                                        <td>
                                            @if ($withdrawal->status === 'processing')
                                                <div class="d-flex">
                                                    <button type="button" class="btn btn-sm btn-success me-2"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#successModal{{ $withdrawal->id }}">
                                                        Duyệt
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#errorModal{{ $withdrawal->id }}">
                                                        Từ chối
                                                    </button>
                                                </div>

                                                <!-- Success Modal -->
                                                <div class="modal fade" id="successModal{{ $withdrawal->id }}"
                                                    tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Xác nhận duyệt rút tiền</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form {{-- action="{{ route('admin.withdrawals.success', $withdrawal) }}" --}} method="POST">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Ghi chú</label>
                                                                        <textarea class="form-control" name="admin_note" rows="3"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Hủy</button>
                                                                    <button type="submit" class="btn btn-success">Xác nhận
                                                                        duyệt</button>
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
                                                                <h5 class="modal-title">Xác nhận từ chối rút tiền</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form {{-- action="{{ route('admin.withdrawals.error', $withdrawal) }}" --}} method="POST">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Ghi chú</label>
                                                                        <textarea class="form-control" name="admin_note" rows="3"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Hủy</button>
                                                                    <button type="submit" class="btn btn-danger">Xác nhận
                                                                        từ chối</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted">Đã xử lý</span>
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
