@extends('layouts.admin.app')
@section('title', $title)
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Lịch sử mua tài khoản</h4>
                    <h6>Xem tất cả lịch sử mua tài khoản game của người dùng</h6>
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
                                    <th>Hành tinh</th>
                                    <th>Kiểu đăng ký</th>
                                    <th>Giá</th>
                                    <th>Thời gian mua</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($accounts as $key => $account)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <a href="{{ route('admin.users.show', $account->buyer_id) }}">
                                                {{ $account->buyer->username ?? 'N/A' }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.accounts.edit', $account->id) }}">
                                                {{ $account->account_name }}
                                            </a>
                                        </td>
                                        <td>
                                            @if ($account->category)
                                                {{ $account->category->name }}
                                            @else
                                                <span class="text-danger">Không có</span>
                                            @endif
                                        </td>
                                        <td>{{ $account->server }}</td>
                                        <td>
                                            @if ($account->planet === 'earth')
                                                <span class="badges bg-lightgreen">Trái Đất</span>
                                            @elseif ($account->planet === 'namek')
                                                <span class="badges bg-lightblue">Namek</span>
                                            @elseif ($account->planet === 'xayda')
                                                <span class="badges bg-lightred">Xayda</span>
                                            @else
                                                <span class="badges">{{ $account->planet }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($account->registration_type === 'real')
                                                <span class="badges bg-lightgreen">Thật</span>
                                            @else
                                                <span class="badges bg-lightyellow">Ảo</span>
                                            @endif
                                        </td>
                                        <td>{{ number_format($account->price) }} đ</td>
                                        <td>{{ $account->updated_at->format('d/m/Y H:i:s') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- <div class="pagination-area mt-3">
                        {{ $accounts->links() }}
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
