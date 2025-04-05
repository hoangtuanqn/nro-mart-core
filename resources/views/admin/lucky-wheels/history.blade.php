@extends('layouts.admin.app')
@section('title', $title)
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Lịch sử vòng quay may mắn</h4>
                    <h6>Xem lịch sử quay vòng quay của người dùng</h6>
                </div>
                <div class="page-btn">
                    <a href="{{ route('admin.lucky-wheels.index') }}" class="btn btn-added">
                        <i class="fa fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-top">
                        <div class="search-set">
                            <div class="search-input">
                                <a class="btn btn-searchset"><i class="fa fa-search"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table datanew">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Người dùng</th>
                                    <th>Vòng quay</th>
                                    <th>Số lượt</th>
                                    <th>Tổng chi phí</th>
                                    <th>Loại giải thưởng</th>
                                    <th>Số lượng trúng</th>
                                    <th>Mô tả</th>
                                    <th>Thời gian</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($history as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>
                                            <a href="{{ route('admin.users.show', $item->user_id) }}">
                                                {{ $item->user->username ?? 'N/A' }}
                                            </a>
                                        </td>
                                        <td>{{ $item->luckyWheel->name ?? 'N/A' }}</td>
                                        <td>{{ $item->spin_count }}</td>
                                        <td>{{ number_format($item->total_cost) }} VNĐ</td>
                                        <td>
                                            @if ($item->reward_type == 'gold')
                                                <span class="badges bg-warning">Vàng</span>
                                            @else
                                                <span class="badges bg-info">Ngọc</span>
                                            @endif
                                        </td>
                                        <td>{{ number_format($item->reward_amount) }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination-section">
                        {{ $history->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
