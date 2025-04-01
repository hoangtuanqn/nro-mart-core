@extends('layouts.admin.app')
@section('title', $title)
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Lịch sử giao dịch</h4>
                    <h6>Xem tất cả lịch sử giao dịch của hệ thống</h6>
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
                                    <th>Loại giao dịch</th>
                                    <th>Số tiền</th>
                                    <th>Mô tả</th>
                                    <th>Trạng thái</th>
                                    <th>Thời gian</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->id }}</td>
                                        <td>
                                            <a href="{{ route('admin.users.show', $transaction->user_id) }}">
                                                {{ $transaction->user->name ?? 'N/A' }}
                                            </a>
                                        </td>
                                        <td>{{ $transaction->type }}</td>
                                        <td>
                                            @if ($transaction->amount > 0)
                                                <span class="text-success">+{{ number_format($transaction->amount) }}
                                                    đ</span>
                                            @else
                                                <span class="text-danger">{{ number_format($transaction->amount) }} đ</span>
                                            @endif
                                        </td>
                                        <td>{{ $transaction->description }}</td>
                                        <td>
                                            <span
                                                class="badges {{ $transaction->status === 'completed' ? 'bg-lightgreen' : 'bg-lightred' }}">
                                                {{ $transaction->status === 'completed' ? 'Hoàn thành' : 'Thất bại' }}
                                            </span>
                                        </td>
                                        <td>{{ $transaction->created_at->format('d/m/Y H:i:s') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Không có dữ liệu</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination-area mt-3">
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
