@extends('layouts.admin.app')
@section('title', $title)
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Lịch sử đặt dịch vụ</h4>
                    <h6>Xem tất cả lịch sử đặt dịch vụ của người dùng</h6>
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

                    <div class="table-top">
                        <div class="search-set">
                            <div class="search-input">
                                <a class="btn btn-searchset">
                                    <img src="{{ asset('assets/img/icons/search-white.svg') }}" alt="img">
                                </a>
                                <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                    <label>
                                        <input type="search" class="form-control form-control-sm"
                                            placeholder="Tìm kiếm...">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table datanew">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Người dùng</th>
                                    <th>Dịch vụ</th>
                                    <th>Gói dịch vụ</th>
                                    <th>Máy chủ</th>
                                    <th>Tài khoản</th>
                                    <th>Mật khẩu</th>
                                    <th>Giá</th>
                                    <th>Trạng thái</th>
                                    <th>Thời gian</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($services as $key => $service)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <a href="{{ route('admin.users.show', $service->user_id) }}">
                                                {{ $service->user->username ?? 'N/A' }}
                                            </a>
                                        </td>
                                        <td>
                                            @if ($service->gameService)
                                                {{ $service->gameService->name }}
                                            @else
                                                <span class="text-danger">Không có</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($service->servicePackage)
                                                {{ $service->servicePackage->name }}
                                            @else
                                                <span class="text-danger">Không có</span>
                                            @endif
                                        </td>
                                        <td>{{ $service->server }}</td>
                                        <td>{{ $service->game_account }}</td>
                                        <td>{{ $service->game_password }}</td>
                                        <td>{{ number_format($service->price) }} đ</td>
                                        <td>
                                            @if ($service->status === 'completed')
                                                <span class="badges bg-lightgreen">Hoàn thành</span>
                                            @elseif ($service->status === 'processing')
                                                <span class="badges bg-lightyellow">Đang xử lý</span>
                                            @elseif ($service->status === 'pending')
                                                <span class="badges bg-lightyellow">Chờ xử lý</span>
                                            @else
                                                <span class="badges bg-lightred">Đã hủy</span>
                                            @endif
                                        </td>
                                        <td>{{ $service->created_at->format('d/m/Y H:i:s') }}</td>
                                        <td>
                                            @if ($service->status === 'pending' || $service->status === 'processing')
                                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#successModal{{ $service->id }}">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#errorModal{{ $service->id }}">
                                                    <i class="fa fa-times"></i>
                                                </button>

                                                <!-- Success Modal -->
                                                <div class="modal fade" id="successModal{{ $service->id }}"
                                                    tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Xác nhận hoàn thành dịch vụ</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form
                                                                action="{{ route('admin.service-history.approve', $service->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <p>Bạn có chắc chắn muốn hoàn thành dịch vụ này?</p>
                                                                    <div class="form-group">
                                                                        <label for="admin_note">Ghi chú:</label>
                                                                        <textarea class="form-control" id="admin_note" name="admin_note" rows="3" placeholder="Nhập ghi chú (nếu có)"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Hủy</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Hoàn thành</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Error Modal -->
                                                <div class="modal fade" id="errorModal{{ $service->id }}" tabindex="-1"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Xác nhận hủy dịch vụ</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form
                                                                action="{{ route('admin.service-history.reject', $service->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <p>Bạn có chắc chắn muốn hủy dịch vụ này?</p>
                                                                    <p><strong>Lưu ý:</strong> Số tiền sẽ được hoàn trả lại cho người dùng.</p>
                                                                    <div class="form-group">
                                                                        <label for="admin_note">Ghi chú:</label>
                                                                        <textarea class="form-control" id="admin_note" name="admin_note" rows="3" placeholder="Nhập lý do hủy"
                                                                            required></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Không</button>
                                                                    <button type="submit" class="btn btn-danger">Hủy dịch vụ</button>
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
                        {{ $services->links() }}
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
