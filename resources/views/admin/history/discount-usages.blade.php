@extends('layouts.admin.app')
@section('title', $title)
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Lịch sử sử dụng mã giảm giá</h4>
                    <h6>Xem tất cả lịch sử sử dụng mã giảm giá của người dùng</h6>
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
                                    <th>Người dùng</th>
                                    <th>Mã giảm giá</th>
                                    <th>Loại</th>
                                    <th>Áp dụng cho</th>
                                    <th>Giá gốc</th>
                                    <th>Giảm</th>
                                    <th>Giá cuối</th>
                                    <th>Thời gian</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usages as $key => $usage)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <a href="{{ route('admin.users.show', $usage->user_id) }}">
                                                {{ $usage->user->username ?? 'N/A' }}
                                            </a>
                                        </td>
                                        <td>
                                            @if ($usage->discountCode)
                                                <span class="badges bg-lightgreen">{{ $usage->discountCode->code }}</span>
                                            @else
                                                <span class="text-danger">Đã xóa</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($usage->discountCode)
                                                @if ($usage->discountCode->type === 'percent')
                                                    <span
                                                        class="badges bg-lightyellow">{{ $usage->discountCode->value }}%</span>
                                                @else
                                                    <span
                                                        class="badges bg-lightblue">{{ number_format($usage->discountCode->value) }}đ</span>
                                                @endif
                                            @else
                                                <span class="text-danger">Không có</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($usage->context === 'account')
                                                <span class="badges bg-lightblue">Tài khoản</span>
                                            @elseif ($usage->context === 'random_account')
                                                <span class="badges bg-lightpurple">Random</span>
                                            @elseif ($usage->context === 'service')
                                                <span class="badges bg-lightyellow">Dịch vụ</span>
                                            @else
                                                <span class="badges bg-lightgreen">{{ $usage->context }}</span>
                                            @endif
                                            #{{ $usage->item_id }}
                                        </td>
                                        <td>{{ number_format($usage->original_price) }} đ</td>
                                        <td>{{ number_format($usage->discount_amount) }} đ</td>
                                        <td>{{ number_format($usage->discounted_price) }} đ</td>
                                        <td>{{ $usage->created_at->format('d/m/Y H:i:s') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- <div class="pagination-area mt-3">
                        {{ $usages->links() }}
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
