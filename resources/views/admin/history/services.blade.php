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
                                    <th>Người đặt</th>
                                    <th>Dịch vụ</th>
                                    <th>Gói dịch vụ</th>
                                    <th>Thông tin tài khoản</th>
                                    <th>Giá gốc</th>
                                    <th>Giá đã giảm</th>
                                    <th>Trạng thái</th>
                                    <th>Thời gian</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>
                                            <a href="{{ route('admin.users.show', $order->user_id) }}">
                                                {{ $order->user->name ?? 'N/A' }}
                                            </a>
                                        </td>
                                        <td>
                                            @if ($order->package && $order->package->service)
                                                {{ $order->package->service->name }}
                                            @else
                                                <span class="text-danger">Đã xóa</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($order->package)
                                                {{ $order->package->name }}
                                            @else
                                                <span class="text-danger">Đã xóa</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-info" type="button" data-bs-toggle="modal"
                                                data-bs-target="#orderInfo{{ $order->id }}">
                                                Xem thông tin
                                            </button>
                                        </td>
                                        <td>{{ number_format($order->original_price) }} đ</td>
                                        <td>{{ number_format($order->final_price) }} đ</td>
                                        <td>
                                            @if ($order->status === 'completed')
                                                <span class="badges bg-lightgreen">Hoàn thành</span>
                                            @elseif ($order->status === 'processing')
                                                <span class="badges bg-lightyellow">Đang xử lý</span>
                                            @elseif ($order->status === 'pending')
                                                <span class="badges bg-lightblue">Chờ xử lý</span>
                                            @else
                                                <span class="badges bg-lightred">Đã hủy</span>
                                            @endif
                                        </td>
                                        <td>{{ $order->created_at->format('d/m/Y H:i:s') }}</td>
                                    </tr>

                                    <!-- Modal thông tin đơn hàng -->
                                    <div class="modal fade" id="orderInfo{{ $order->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Chi tiết đơn hàng #{{ $order->id }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-12 mb-2">
                                                            <p><strong>Thông tin tài khoản:</strong></p>
                                                            <pre class="bg-light p-2 rounded">{{ $order->account_info }}</pre>
                                                        </div>
                                                        <div class="col-12 mb-2">
                                                            <p><strong>Ghi chú:</strong></p>
                                                            <p>{{ $order->note ?? 'Không có ghi chú' }}</p>
                                                        </div>
                                                        @if ($order->result)
                                                            <div class="col-12">
                                                                <p><strong>Kết quả:</strong></p>
                                                                <pre class="bg-light p-2 rounded">{{ $order->result }}</pre>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Đóng</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">Không có dữ liệu</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination-area mt-3">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
