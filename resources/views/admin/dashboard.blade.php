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
                <!-- Alert thông báo -->
                <div class="row">
                    <!-- Notification -->
                    <div class="card-body p-2">
                        <div class="alert alert-notication-custom alert-dismissible fade show" role="alert">
                            <strong>Mã nguồn được phát triển bởi TUANORI.VN!</strong> Chúng tôi chuyên cung cấp các giải
                            pháp website chuyên nghiệp.
                            <br>
                            Liên hệ mua source code tại Fanpage: <a href="https://www.facebook.com/tuanori.vn"
                                target="_blank">TUAN ORI - Web Designer MMO </a>
                            <br><br>
                            <em>Lưu ý: Source code có thể còn tồn tại lỗi chưa được phát hiện. Chúng tôi rất cảm ơn nếu bạn
                                báo cáo lỗi cho chúng tôi.
                                Để cảm ơn sự đóng góp của bạn, chúng tôi sẽ xem xét miễn phí source code trong dự án tiếp
                                theo cho bạn!</em>
                            <br>
                            Phiên làm việc hiện tại: {{ now()->format('d/m/Y H:i') }}
                            @if (count($pendingServices) > 0 || count($pendingWithdrawals) > 0 || count($pendingResourceWithdrawals) > 0)
                                <br>
                                <span class="text-danger">Bạn có
                                    {{ count($pendingServices) + count($pendingWithdrawals) + count($pendingResourceWithdrawals) }}
                                    yêu cầu đang chờ xử lý.</span>
                            @endif
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>

                <!-- Thống kê tài khoản -->
                <div class="row">
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

                <!-- Thống kê dịch vụ và danh mục -->
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
                                <h4>{{ $statistics['random_accounts']['total'] }}</h4>
                                <h5>Acc Random</h5>
                            </div>
                            <div class="dash-imgs">
                                <i data-feather="package"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6 col-12 d-flex">
                        <div class="dash-count das2">
                            <div class="dash-counts">
                                <h4>{{ $statistics['lucky_wheels']['total'] }}</h4>
                                <h5>Vòng quay</h5>
                            </div>
                            <div class="dash-imgs">
                                <i data-feather="refresh-cw"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-6 col-12 d-flex">
                        <div class="dash-count das3">
                            <div class="dash-counts">
                                <h4>{{ $statistics['users']['new_today'] }}</h4>
                                <h5>Người dùng mới hôm nay</h5>
                            </div>
                            <div class="dash-imgs">
                                <i data-feather="user-plus"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tổng hợp giao dịch -->
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

                <!-- Phân bố loại dịch vụ và Các tài khoản mua gần đây -->
                <div class="row">
                    <div class="col-lg-4 col-sm-12 col-12 d-flex">
                        <div class="card flex-fill">
                            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Loại dịch vụ</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
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
                                                            <span
                                                                class="badge bg-secondary">{{ $serviceType->type }}</span>
                                                        @endif
                                                    </td>
                                                    <td><span class="badge bg-primary">{{ $serviceType->total }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-12 col-12 d-flex">
                        <div class="card flex-fill">
                            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Mã giảm giá đang hoạt động</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Mã</th>
                                                <th>Giá trị</th>
                                                <th>Hạn dùng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($activeDiscountCodes as $code)
                                                <tr>
                                                    <td>
                                                        <strong>{{ $code->code }}</strong>
                                                    </td>
                                                    <td>
                                                        @if ($code->discount_type == 'percentage')
                                                            {{ $code->discount_value }}%
                                                        @else
                                                            {{ number_format($code->discount_value) }}đ
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $code->expire_date ? $code->expire_date->format('d/m/Y') : 'Không hạn' }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-center">Không có mã giảm giá nào đang
                                                        hoạt động</td>
                                                </tr>
                                            @endforelse
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-12 col-12 d-flex">
                        <div class="card flex-fill">
                            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Thống kê người dùng</h5>
                            </div>
                            <div class="card-body">
                                <div class="stats-list">
                                    <div class="stats-info mb-3">
                                        <p>Admin <span
                                                class="badge rounded-pill bg-primary">{{ $statistics['users']['admin'] }}</span>
                                        </p>
                                        <div class="progress">
                                            <div class="progress-bar bg-primary" role="progressbar"
                                                style="width: {{ ($statistics['users']['admin'] / $statistics['users']['total']) * 100 }}%"
                                                aria-valuenow="{{ $statistics['users']['admin'] }}" aria-valuemin="0"
                                                aria-valuemax="{{ $statistics['users']['total'] }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="stats-info mb-3">
                                        <p>Khách hàng <span
                                                class="badge rounded-pill bg-success">{{ $statistics['users']['user'] }}</span>
                                        </p>
                                        <div class="progress">
                                            <div class="progress-bar bg-success" role="progressbar"
                                                style="width: {{ ($statistics['users']['user'] / $statistics['users']['total']) * 100 }}%"
                                                aria-valuenow="{{ $statistics['users']['user'] }}" aria-valuemin="0"
                                                aria-valuemax="{{ $statistics['users']['total'] }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="stats-info mb-3">
                                        <p>Thống kê người dùng mới</p>
                                        <div class="row">
                                            <div class="col-4">
                                                <small>Hôm nay:</small> <span
                                                    class="badge bg-info">{{ $statistics['users']['new_today'] }}</span>
                                            </div>
                                            <div class="col-4">
                                                <small>Tuần này:</small> <span
                                                    class="badge bg-info">{{ $statistics['users']['new_this_week'] }}</span>
                                            </div>
                                            <div class="col-4">
                                                <small>Tháng này:</small> <span
                                                    class="badge bg-info">{{ $statistics['users']['new_this_month'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Giao dịch gần đây -->
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
                                    @foreach ($recentTransactions as $key => $transaction)
                                        <tr>
                                            <td>{{ $transaction->id }}</td>
                                            <td class="productimgname">
                                                <a
                                                    href="{{ route('admin.users.show', ['id' => $transaction->user->id]) }}">{{ $transaction->user->username ?? 'N/A' }}</a>
                                            </td>
                                            <td>
                                                @if ($transaction->type == 'deposit')
                                                    <span class="badge bg-success">Nạp tiền</span>
                                                @elseif($transaction->type == 'withdraw')
                                                    <span class="badge bg-danger">Rút tiền</span>
                                                @elseif($transaction->type == 'purchase')
                                                    <span class="badge bg-primary">Mua hàng</span>
                                                @elseif($transaction->type == 'refund')
                                                    <span class="badge bg-warning">Hoàn tiền</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ $transaction->type }}</span>
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

                <!-- Biểu đồ tổng quan & Dịch vụ cần xử lý-->
                <div class="row mt-4">
                    <div class="col-lg-7 col-sm-12 col-12 d-flex">
                        <div class="card flex-fill">
                            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Thống kê nạp tiền & mua hàng (7 ngày gần đây)</h5>
                            </div>
                            <div class="card-body">
                                <div id="sales_charts"></div>
                                <div class="table-responsive mt-3">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Ngày</th>
                                                @foreach ($last7Days as $day)
                                                    <th>{{ $day['date'] }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>Nạp tiền</strong></td>
                                                @foreach ($last7Days as $day)
                                                    <td>{{ number_format($day['deposits']) }}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <td><strong>Mua hàng</strong></td>
                                                @foreach ($last7Days as $day)
                                                    <td>{{ number_format($day['purchases']) }}</td>
                                                @endforeach
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-sm-12 col-12 d-flex">
                        <div class="card flex-fill">
                            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0">Dịch vụ đang chờ xử lý</h4>
                                <div class="dropdown">
                                    <a href="{{ route('admin.history.services') }}" class="btn btn-sm btn-primary">
                                        Xem tất cả
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive dataview">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Dịch vụ</th>
                                                <th>Người dùng</th>
                                                <th>Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($pendingServices as $key => $service)
                                                <tr>
                                                    <td>{{ $service->id }}</td>
                                                    <td>
                                                        <span
                                                            class="badge bg-primary">{{ $service->gameService->name ?? 'N/A' }}</span>
                                                        <small>{{ $service->servicePackage->name ?? 'N/A' }}</small>
                                                    </td>
                                                    <td>{{ $service->user->username ?? 'N/A' }}</td>
                                                    <td><span class="badge bg-warning">Chờ xử lý</span></td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center">Không có dịch vụ nào đang chờ
                                                        xử lý</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rút tiền đang chờ & Rút tài nguyên đang chờ -->
                <div class="row">
                    <div class="col-lg-6 col-sm-12 col-12 d-flex">
                        <div class="card flex-fill">
                            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0">Yêu cầu rút tiền đang chờ</h4>
                                <a href="{{ route('admin.withdrawals.index') }}" class="btn btn-sm btn-primary">
                                    Xem tất cả
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive dataview">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Người dùng</th>
                                                <th>Số tiền</th>
                                                <th>Ngân hàng</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($pendingWithdrawals as $withdrawal)
                                                <tr>
                                                    <td>{{ $withdrawal->id }}</td>
                                                    <td>{{ $withdrawal->user->username ?? 'N/A' }}</td>
                                                    <td>{{ number_format($withdrawal->amount) }} VNĐ</td>
                                                    <td>{{ $withdrawal->bank_name }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.withdrawals.index') }}"
                                                            class="btn btn-sm btn-primary">Xử lý</a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">Không có yêu cầu rút tiền nào
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-12 d-flex">
                        <div class="card flex-fill">
                            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0">Yêu cầu rút tài nguyên đang chờ</h4>
                                <a href="{{ route('admin.withdrawals.resources.index') }}"
                                    class="btn btn-sm btn-primary">
                                    Xem tất cả
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive dataview">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Người dùng</th>
                                                <th>Loại</th>
                                                <th>Số lượng</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($pendingResourceWithdrawals as $withdrawal)
                                                <tr>
                                                    <td>{{ $withdrawal->id }}</td>
                                                    <td>{{ $withdrawal->user->username ?? 'N/A' }}</td>
                                                    <td>
                                                        @if ($withdrawal->type == 'gold')
                                                            <span class="badge bg-warning">Vàng</span>
                                                        @else
                                                            <span class="badge bg-info">Ngọc</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ number_format($withdrawal->amount) }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.withdrawals.resources.index') }}"
                                                            class="btn btn-sm btn-primary">Xử lý</a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">Không có yêu cầu rút tài nguyên
                                                        nào</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        $(document).ready(function() {
            var salesData = {!! json_encode($last7Days) !!};

            var categories = salesData.map(function(item) {
                return item.date;
            });

            var depositData = salesData.map(function(item) {
                return item.deposits;
            });

            var purchaseData = salesData.map(function(item) {
                return item.purchases;
            });

            var options = {
                series: [{
                    name: 'Nạp tiền',
                    data: depositData
                }, {
                    name: 'Mua hàng',
                    data: purchaseData
                }],
                chart: {
                    height: 300,
                    type: 'area',
                    toolbar: {
                        show: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                xaxis: {
                    type: 'category',
                    categories: categories
                },
                tooltip: {
                    x: {
                        format: 'dd/MM'
                    },
                    y: {
                        formatter: function(val) {
                            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + ' VNĐ';
                        }
                    }
                },
                colors: ['#5757f7', '#28a745']
            };

            var chart = new ApexCharts(document.querySelector("#sales_charts"), options);
            chart.render();
        });
    </script>
@endpush
