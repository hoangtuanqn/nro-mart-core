@extends('layouts.user.app')

@section('title', 'Dịch Vụ Đã Thuê - Ngọc Rồng')

@section('content')
    <x-hero-header title="DỊCH VỤ ĐÃ THUÊ" description="Danh sách các dịch vụ bạn đã sử dụng" />
    <div class="service">
        <div class="container">
            <!-- Thông báo -->
            @if (session('success'))
                <div class="service__alert service__alert--success">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                    <button type="button" class="service__alert-close">&times;</button>
                </div>
            @endif

            @if (session('error'))
                <div class="service__alert service__alert--error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session('error') }}</span>
                    <button type="button" class="service__alert-close">&times;</button>
                </div>
            @endif

            <div class="service__history">
                <div class="service__history-header">
                    <h2 class="service__history-title">Dịch vụ đã thuê</h2>
                </div>

                <div class="service__history-filter">
                    <form action="{{ route('user.services.history') }}" method="GET" class="service__filter-form">
                        <div class="service__filter-row">
                            <div class="service__filter-group">
                                <label for="status" class="service__filter-label">Trạng thái</label>
                                <select name="status" id="status" class="service__form-control">
                                    <option value="">Tất cả</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xử lý
                                    </option>
                                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>
                                        Đang thực hiện</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Hoàn
                                        thành</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã
                                        hủy</option>
                                </select>
                            </div>

                            <div class="service__filter-actions">
                                <button type="submit" class="service__btn service__btn--primary service__btn--sm">
                                    <i class="fas fa-filter"></i> Lọc
                                </button>
                                <a href="{{ route('user.services.history') }}"
                                    class="service__btn service__btn--outline service__btn--sm">
                                    <i class="fas fa-sync-alt"></i> Đặt lại
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                @if ($orders->isEmpty())
                    <div class="service__history-empty">
                        <div class="service__history-empty-icon">
                            <i class="fas fa-history"></i>
                        </div>
                        <p class="service__history-empty-text">Bạn chưa thuê dịch vụ nào</p>
                        <a href="{{ route('home') }}" class="service__btn service__btn--primary">
                            <i class="fas fa-shopping-cart"></i> Thuê dịch vụ ngay
                        </a>
                    </div>
                @else
                    <div class="service__table-container">
                        <table class="service__table">
                            <thead>
                                <tr>
                                    <th>Thời gian</th>
                                    <th>Mã giao dịch</th>
                                    <th>Server</th>
                                    <th>Loại dịch vụ</th>
                                    <th>Trạng thái</th>
                                    <th>Trị giá</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->created_at->format('H:i d/m/Y') }}</td>
                                        <td><span class="service__id">#{{ $order->id }}</span></td>
                                        <td>Server {{ $order->server }}</td>
                                        <td>{{ $order->servicePackage->name }}</td>
                                        <td>
                                            <span class="service__status service__status--{{ $order->status }}">
                                                @switch($order->status)
                                                    @case('pending')
                                                        Chờ xử lý
                                                    @break

                                                    @case('processing')
                                                        Đang thực hiện
                                                    @break

                                                    @case('completed')
                                                        Hoàn thành
                                                    @break

                                                    @case('cancelled')
                                                        Đã hủy
                                                    @break

                                                    @default
                                                        {{ $order->status }}
                                                @endswitch
                                            </span>
                                        </td>
                                        <td><span class="service__price">{{ number_format($order->price, 0, ',', '.') }}
                                                VNĐ</span></td>
                                        <td>
                                            <div class="service__actions">
                                                <a href="{{ route('user.services.order.detail', $order->id) }}"
                                                    class="service__btn service__btn--sm service__btn--outline">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                @if ($order->status == 'pending')
                                                    <button type="button"
                                                        class="service__btn service__btn--sm service__btn--danger"
                                                        onclick="if(confirm('Bạn có chắc chắn muốn hủy đơn này không?')) { document.getElementById('cancel-form-{{ $order->id }}').submit(); }">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                    <form id="cancel-form-{{ $order->id }}"
                                                        action="{{ route('user.services.order.cancel', $order->id) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('POST')
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="service__pagination">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Bảng dịch vụ */
        .service__table-container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
            margin-bottom: 20px;
        }

        .service__table {
            width: 100%;
            border-collapse: collapse;
        }

        .service__table th,
        .service__table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .service__table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #333;
        }

        .service__table tr:hover {
            background-color: #f5f9ff;
        }

        .service__status {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }

        .service__status--pending {
            background-color: #fff8e1;
            color: #ffa000;
            border: 1px solid #ffecb3;
        }

        .service__status--processing {
            background-color: #e3f2fd;
            color: #1976d2;
            border: 1px solid #bbdefb;
        }

        .service__status--completed {
            background-color: #e8f5e9;
            color: #43a047;
            border: 1px solid #c8e6c9;
        }

        .service__status--cancelled {
            background-color: #ffebee;
            color: #e53935;
            border: 1px solid #ffcdd2;
        }

        .service__price {
            font-weight: 600;
            color: #e53935;
        }

        .service__id {
            font-family: monospace;
            font-weight: 600;
        }

        .service__actions {
            display: flex;
            gap: 5px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .service__table-container {
                margin: 0 -15px;
                border-radius: 0;
            }

            .service__table th,
            .service__table td {
                padding: 10px;
            }

            .service__btn--sm {
                padding: 5px 10px;
                font-size: 1.2rem;
            }
        }

        @media (max-width: 576px) {
            .service__table {
                font-size: 1.3rem;
            }

            .service__filter-row {
                flex-direction: column;
            }

            .service__filter-actions {
                margin-top: 10px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Xử lý đóng thông báo
            const alertCloseButtons = document.querySelectorAll('.service__alert-close');
            alertCloseButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const alert = this.closest('.service__alert');
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    setTimeout(() => {
                        alert.remove();
                    }, 300);
                });
            });
        });
    </script>
@endpush
