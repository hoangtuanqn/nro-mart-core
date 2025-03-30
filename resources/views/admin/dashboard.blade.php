@extends('layouts.admin.app')
@section('title', 'Dashboard')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Admin Dashboard</h4>
                    <h6>Thống kê tổng quan hệ thống</h6>
                </div>
            </div>

            @if (isset($error))
                <div class="alert alert-danger">
                    <strong>Lỗi!</strong> Đã xảy ra lỗi khi tải dữ liệu dashboard. Vui lòng thông báo cho quản trị viên.
                    @if (config('app.debug'))
                        <p>{{ $error }}</p>
                    @endif
                </div>
            @else
                <!-- Statistics Cards Row -->
                <div class="row">
                    <!-- Game Accounts Stats -->
                    <div class="col-lg-3 col-sm-6 col-12 d-flex">
                        <div class="dash-count">
                            <div class="dash-counts">
                                <h4>{{ $statistics['accounts']['total'] }}</h4>
                                <h5>Tài khoản game</h5>
                            </div>
                            <div class="dash-imgs">
                                <i data-feather="user"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6 col-12 d-flex">
                        <div class="dash-count das1">
                            <div class="dash-counts">
                                <h4>{{ $statistics['accounts']['available'] }}</h4>
                                <h5>Chưa bán</h5>
                            </div>
                            <div class="dash-imgs">
                                <i data-feather="shopping-cart"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6 col-12 d-flex">
                        <div class="dash-count das2">
                            <div class="dash-counts">
                                <h4>{{ $statistics['accounts']['sold'] }}</h4>
                                <h5>Đã bán</h5>
                            </div>
                            <div class="dash-imgs">
                                <i data-feather="check-circle"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6 col-12 d-flex">
                        <div class="dash-count das3">
                            <div class="dash-counts">
                                <h4>{{ $statistics['users']['total'] }}</h4>
                                <h5>Người dùng</h5>
                            </div>
                            <div class="dash-imgs">
                                <i data-feather="users"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Second Row of Statistics -->
                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12 d-flex">
                        <div class="dash-count">
                            <div class="dash-counts">
                                <h4>{{ $statistics['services']['total'] }}</h4>
                                <h5>Dịch vụ</h5>
                            </div>
                            <div class="dash-imgs">
                                <i data-feather="briefcase"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6 col-12 d-flex">
                        <div class="dash-count das1">
                            <div class="dash-counts">
                                <h4>{{ $statistics['services']['active'] }}</h4>
                                <h5>Dịch vụ hoạt động</h5>
                            </div>
                            <div class="dash-imgs">
                                <i data-feather="check"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6 col-12 d-flex">
                        <div class="dash-count das2">
                            <div class="dash-counts">
                                <h4>{{ $statistics['packages']['total'] }}</h4>
                                <h5>Gói dịch vụ</h5>
                            </div>
                            <div class="dash-imgs">
                                <i data-feather="package"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6 col-12 d-flex">
                        <div class="dash-count das3">
                            <div class="dash-counts">
                                <h4>{{ $statistics['categories']['total'] }}</h4>
                                <h5>Danh mục</h5>
                            </div>
                            <div class="dash-imgs">
                                <i data-feather="grid"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transaction Summary Row -->
                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="dash-widget">
                            <div class="dash-widgetimg">
                                <span><i class="fa fa-arrow-down text-success"></i></span>
                            </div>
                            <div class="dash-widgetcontent">
                                <h5><span class="counters">{{ number_format($transactionSummary['total_deposit']) }}</span>
                                    VNĐ</h5>
                                <h6>Tổng nạp tiền</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="dash-widget dash1">
                            <div class="dash-widgetimg">
                                <span><i class="fa fa-arrow-up text-danger"></i></span>
                            </div>
                            <div class="dash-widgetcontent">
                                <h5><span
                                        class="counters">{{ number_format($transactionSummary['total_withdraw']) }}</span>
                                    VNĐ</h5>
                                <h6>Tổng rút tiền</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="dash-widget dash2">
                            <div class="dash-widgetimg">
                                <span><i class="fa fa-shopping-cart text-info"></i></span>
                            </div>
                            <div class="dash-widgetcontent">
                                <h5><span
                                        class="counters">{{ number_format($transactionSummary['total_purchase']) }}</span>
                                    VNĐ</h5>
                                <h6>Tổng mua hàng</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="dash-widget dash3">
                            <div class="dash-widgetimg">
                                <span><i class="fa fa-undo text-warning"></i></span>
                            </div>
                            <div class="dash-widgetcontent">
                                <h5><span class="counters">{{ number_format($transactionSummary['total_refund']) }}</span>
                                    VNĐ</h5>
                                <h6>Tổng hoàn tiền</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service Type Distribution & Categories -->
                <div class="row">
                    <div class="col-lg-6 col-sm-12 col-12 d-flex">
                        <div class="card flex-fill">
                            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Loại dịch vụ</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table datanew">
                                        <thead>
                                            <tr>
                                                <th>Loại</th>
                                                <th>Số lượng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($servicesByType as $serviceType)
                                                <tr>
                                                    <td>
                                                        @if ($serviceType->type == 'gold')
                                                            <span class="badge bg-warning">Bán vàng</span>
                                                        @elseif($serviceType->type == 'gem')
                                                            <span class="badge bg-info">Bán ngọc</span>
                                                        @elseif($serviceType->type == 'leveling')
                                                            <span class="badge bg-success">Cày thuê</span>
                                                        @else
                                                            <span class="badge bg-secondary">{{ $serviceType->type }}</span>
                                                        @endif
                                                    </td>
                                                    <td><span class="badge bg-primary">{{ $serviceType->total }}</span></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-12 col-12 d-flex">
                        <div class="card flex-fill">
                            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Thống kê người dùng</h5>
                            </div>
                            <div class="card-body">
                                <div class="stats-list">
                                    <div class="stats-info">
                                        <p>Admin <span class="badge rounded-pill bg-primary">{{ $statistics['users']['admin'] }}</span></p>
                                        <div class="progress">
                                            <div class="progress-bar bg-primary" role="progressbar"
                                                style="width: {{ ($statistics['users']['admin'] / $statistics['users']['total']) * 100 }}%"
                                                aria-valuenow="{{ $statistics['users']['admin'] }}"
                                                aria-valuemin="0"
                                                aria-valuemax="{{ $statistics['users']['total'] }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="stats-info">
                                        <p>Khách hàng <span class="badge rounded-pill bg-success">{{ $statistics['users']['user'] }}</span></p>
                                        <div class="progress">
                                            <div class="progress-bar bg-success" role="progressbar"
                                                style="width: {{ ($statistics['users']['user'] / $statistics['users']['total']) * 100 }}%"
                                                aria-valuenow="{{ $statistics['users']['user'] }}"
                                                aria-valuemin="0"
                                                aria-valuemax="{{ $statistics['users']['total'] }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="stats-info">
                                        <p>Danh mục hiển thị <span class="badge rounded-pill bg-info">{{ $statistics['categories']['active'] }}</span></p>
                                        <div class="progress">
                                            <div class="progress-bar bg-info" role="progressbar"
                                                style="width: {{ ($statistics['categories']['active'] / $statistics['categories']['total']) * 100 }}%"
                                                aria-valuenow="{{ $statistics['categories']['active'] }}"
                                                aria-valuemin="0"
                                                aria-valuemax="{{ $statistics['categories']['total'] }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Transactions -->
                <div class="card mb-0">
                    <div class="card-header">
                        <h4 class="card-title">Lịch sử giao dịch gần đây</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive dataview">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Người dùng</th>
                                        <th>Loại giao dịch</th>
                                        <th>Số tiền</th>
                                        <th>Số dư trước</th>
                                        <th>Số dư sau</th>
                                        <th>Mô tả</th>
                                        <th>Thời gian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentTransactions as $transaction)
                                        <tr>
                                            <td>{{ $transaction->id }}</td>
                                            <td class="productimgname">
                                                <a class="product-img">
                                                    <img src="{{ asset('assets/img/customer/profile.jpg') }}" alt="profile">
                                                </a>
                                                <a href="javascript:void(0);">{{ $transaction->user->name ?? 'N/A' }}</a>
                                            </td>
                                            <td>
                                                @if ($transaction->type == 'deposit')
                                                    <span class="badge bg-success">Nạp tiền</span>
                                                @elseif($transaction->type == 'withdraw')
                                                    <span class="badge bg-danger">Rút tiền</span>
                                                @elseif($transaction->type == 'purchase')
                                                    <span class="badge bg-info">Mua hàng</span>
                                                @elseif($transaction->type == 'refund')
                                                    <span class="badge bg-warning">Hoàn tiền</span>
                                                @else
                                                    <span class="badge bg-secondary">Khác</span>
                                                @endif
                                            </td>
                                            <td>{{ number_format($transaction->amount) }} VNĐ</td>
                                            <td>{{ number_format($transaction->balance_before) }} VNĐ</td>
                                            <td>{{ number_format($transaction->balance_after) }} VNĐ</td>
                                            <td>{{ $transaction->description ?? 'N/A' }}</td>
                                            <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
