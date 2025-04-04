@extends('layouts.admin.app')
@section('title', $title)
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Lịch sử nạp thẻ cào</h4>
                    <h6>Xem tất cả lịch sử nạp thẻ cào của người dùng</h6>
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
                                    <th>Người nạp</th>
                                    <th>Nhà mạng</th>
                                    <th>Mệnh giá</th>
                                    <th>Thực nhận</th>
                                    <th>Mã thẻ</th>
                                    <th>Serial</th>
                                    <th>Trạng thái</th>
                                    <th>Thời gian</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($deposits as $key => $deposit)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <a href="{{ route('admin.users.show', $deposit->user_id) }}">
                                                {{ $deposit->user->username ?? 'N/A' }}
                                            </a>
                                        </td>
                                        <td>
                                            <span class="text-uppercase">{{ $deposit->telco }}</span>
                                        </td>
                                        <td>{{ number_format($deposit->amount) }} đ</td>
                                        <td>{{ number_format($deposit->received_amount) }} đ</td>
                                        <td>
                                            <span
                                                class="text-monospace">{{ substr($deposit->pin, 0, 4) }}****{{ substr($deposit->pin, -4) }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="text-monospace">{{ substr($deposit->serial, 0, 4) }}****{{ substr($deposit->serial, -4) }}</span>
                                        </td>
                                        <td>
                                            @if ($deposit->status === 'success')
                                                <span class="badges bg-lightgreen">Thành công</span>
                                            @elseif ($deposit->status === 'processing')
                                                <span class="badges bg-lightyellow">Đang xử lý</span>
                                            @elseif ($deposit->status === 'error')
                                                <span class="badges bg-lightred">Lỗi thẻ</span>
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
