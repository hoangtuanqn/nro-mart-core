@extends('layouts.admin.app')
@section('title', $title)
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Lịch sử nạp tiền qua ngân hàng</h4>
                    <h6>Xem tất cả lịch sử nạp tiền qua ngân hàng của người dùng</h6>
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
                                    <th>Mã giao dịch</th>
                                    <th>Người nạp</th>
                                    <th>Ngân hàng</th>
                                    <th>Số tài khoản</th>
                                    <th>Số tiền</th>
                                    <th>Nội dung CK</th>
                                    <th>Trạng thái</th>
                                    <th>Thời gian</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($deposits as $key => $deposit)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $deposit->transaction_id }}</td>
                                        <td>
                                            <a href="{{ route('admin.users.show', $deposit->user_id) }}">
                                                {{ $deposit->user->username ?? 'N/A' }}
                                            </a>
                                        </td>
                                        <td>
                                            @if ($deposit->bankAccount)
                                                {{ $deposit->bankAccount->bank_name }}
                                            @else
                                                <span class="text-danger">Không có</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($deposit->bankAccount)
                                                {{ $deposit->bankAccount->account_number }}
                                            @else
                                                <span class="text-danger">Không có</span>
                                            @endif
                                        </td>
                                        <td>{{ number_format($deposit->amount) }} đ</td>
                                        <td>{{ $deposit->transaction_content }}</td>
                                        <td>
                                            @if ($deposit->status === 'completed')
                                                <span class="badges bg-lightgreen">Thành công</span>
                                            @elseif ($deposit->status === 'pending')
                                                <span class="badges bg-lightyellow">Chờ xác nhận</span>
                                            @elseif ($deposit->status === 'cancelled')
                                                <span class="badges bg-lightred">Đã hủy</span>
                                            @else
                                                <span class="badges bg-lightred">Thất bại</span>
                                            @endif
                                        </td>
                                        <td>{{ $deposit->created_at->format('d/m/Y H:i:s') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- <div class="pagination-area mt-3">
                        {{ $deposits->links() }}
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
