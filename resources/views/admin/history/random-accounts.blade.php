@extends('layouts.admin.app')
@section('title', $title)
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Lịch sử mua tài khoản Random</h4>
                    <h6>Xem tất cả lịch sử mua tài khoản random của người dùng</h6>
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
                                    <th>Người mua</th>
                                    <th>Tài khoản</th>
                                    <th>Danh mục</th>
                                    <th>Máy chủ</th>
                                    <th>Giá gốc</th>
                                    <th>Giá đã giảm</th>
                                    <th>Mã giảm giá</th>
                                    <th>Thời gian</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchases as $key => $purchase)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <a href="{{ route('admin.users.show', $purchase->user_id) }}">
                                                {{ $purchase->user->username ?? 'N/A' }}
                                            </a>
                                        </td>
                                        <td>
                                            @if ($purchase->account)
                                                <a href="{{ route('admin.random-accounts.edit', $purchase->account_id) }}">
                                                    {{ $purchase->account->account_name ?? 'ACC#' . $purchase->account_id }}
                                                </a>
                                            @else
                                                <span class="text-danger">Đã xóa</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($purchase->account && $purchase->account->category)
                                                {{ $purchase->account->category->name }}
                                            @else
                                                <span class="text-danger">Không có</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($purchase->account)
                                                {{ $purchase->account->server ?? 'N/A' }}
                                            @else
                                                <span class="text-danger">Không có</span>
                                            @endif
                                        </td>
                                        <td>{{ number_format($purchase->original_price) }} đ</td>
                                        <td>{{ number_format($purchase->final_price) }} đ</td>
                                        <td>
                                            @if ($purchase->discount_code)
                                                <span class="badges bg-lightgreen">{{ $purchase->discount_code }}</span>
                                            @else
                                                <span class="text-muted">Không có</span>
                                            @endif
                                        </td>
                                        <td>{{ $purchase->created_at->format('d/m/Y H:i:s') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- <div class="pagination-area mt-3">
                        {{ $purchases->links() }}
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
