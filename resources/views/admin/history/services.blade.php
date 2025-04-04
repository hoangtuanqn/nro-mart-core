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
                                    <th>Người dùng</th>
                                    <th>Dịch vụ</th>
                                    <th>Gói dịch vụ</th>
                                    <th>Máy chủ</th>
                                    <th>Tài khoản game</th>
                                    <th>Giá</th>
                                    <th>Trạng thái</th>
                                    <th>Thời gian</th>
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
                                        <td>{{ number_format($service->price) }} đ</td>
                                        <td>
                                            @if ($service->status === 'completed')
                                                <span class="badges bg-lightgreen">Hoàn thành</span>
                                            @elseif ($service->status === 'processing')
                                                <span class="badges bg-lightyellow">Đang xử lý</span>
                                            @elseif ($service->status === 'pending')
                                                <span class="badges bg-lightblue">Chờ xử lý</span>
                                            @else
                                                <span class="badges bg-lightred">Đã hủy</span>
                                            @endif
                                        </td>
                                        <td>{{ $service->created_at->format('d/m/Y H:i:s') }}</td>
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
