@extends('layouts.user.app')

@section('title', 'Chi tiết đơn hàng - Ngọc Rồng')

@section('content')
    <x-hero-header title="CHI TIẾT ĐƠN HÀNG #{{ $order->id }}" description="Thông tin chi tiết về đơn hàng của bạn" />
    <div class="service">
        <div class="container">
            <div class="service__detail">
                <div class="service__detail-header">
                    <div class="service__detail-status service__detail-status--{{ $order->status }}">
                        @switch($order->status)
                            @case('pending')
                                <i class="fas fa-clock"></i> Đang chờ xử lý
                            @break

                            @case('processing')
                                <i class="fas fa-spinner fa-spin"></i> Đang thực hiện
                            @break

                            @case('completed')
                                <i class="fas fa-check-circle"></i> Hoàn thành
                            @break

                            @case('cancelled')
                                <i class="fas fa-times-circle"></i> Đã hủy
                            @break

                            @default
                                {{ $order->status }}
                        @endswitch
                    </div>
                    <a href="{{ route('user.services.history') }}" class="service__detail-back">
                        <i class="fas fa-arrow-left"></i> Quay lại danh sách
                    </a>
                </div>

                <div class="service__detail-content">
                    <div class="service__detail-section">
                        <h3 class="service__detail-section-title">Thông tin dịch vụ</h3>
                        <div class="service__detail-info">
                            <div class="service__detail-row">
                                <span class="service__detail-label">ID đơn hàng:</span>
                                <span class="service__detail-value">#{{ $order->id }}</span>
                            </div>

                            <div class="service__detail-row">
                                <span class="service__detail-label">Dịch vụ:</span>
                                <span class="service__detail-value">{{ $order->gameService->name }}</span>
                            </div>

                            <div class="service__detail-row">
                                <span class="service__detail-label">Gói dịch vụ:</span>
                                <span class="service__detail-value">{{ $order->servicePackage->name }}</span>
                            </div>

                            <div class="service__detail-row">
                                <span class="service__detail-label">Trạng thái:</span>
                                <span class="service__detail-value service__detail-status--{{ $order->status }}">
                                    @switch($order->status)
                                        @case('pending')
                                            <i class="fas fa-clock"></i> Đang chờ xử lý
                                        @break

                                        @case('processing')
                                            <i class="fas fa-spinner fa-spin"></i> Đang thực hiện
                                        @break

                                        @case('completed')
                                            <i class="fas fa-check-circle"></i> Hoàn thành
                                        @break

                                        @case('cancelled')
                                            <i class="fas fa-times-circle"></i> Đã hủy
                                        @break

                                        @default
                                            {{ $order->status }}
                                    @endswitch
                                </span>
                            </div>

                            <div class="service__detail-row">
                                <span class="service__detail-label">Ngày đặt:</span>
                                <span class="service__detail-value">{{ $order->created_at->format('H:i d/m/Y') }}</span>
                            </div>

                            @if ($order->completed_at)
                                <div class="service__detail-row">
                                    <span class="service__detail-label">Ngày hoàn thành:</span>
                                    <span
                                        class="service__detail-value">{{ $order->completed_at->format('H:i d/m/Y') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="service__detail-section">
                        <h3 class="service__detail-section-title">Thông tin tài khoản</h3>
                        <div class="service__detail-info">
                            <div class="service__detail-row">
                                <span class="service__detail-label">Tài khoản:</span>
                                <span class="service__detail-value">{{ $order->game_account }}</span>
                            </div>

                            <div class="service__detail-row">
                                <span class="service__detail-label">Mật khẩu:</span>
                                <span class="service__detail-value">••••••••••</span>
                            </div>

                            <div class="service__detail-row">
                                <span class="service__detail-label">Máy chủ:</span>
                                <span class="service__detail-value">Server {{ $order->server }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="service__detail-section">
                        <h3 class="service__detail-section-title">Thông tin thanh toán</h3>
                        <div class="service__detail-info">
                            <div class="service__detail-row">
                                <span class="service__detail-label">Giá gói:</span>
                                <span class="service__detail-value">{{ number_format($order->price, 0, ',', '.') }}
                                    VNĐ</span>
                            </div>

                            @if ($order->discount_amount > 0)
                                <div class="service__detail-row">
                                    <span class="service__detail-label">Giảm giá:</span>
                                    <span class="service__detail-value service__detail-discount">
                                        - {{ number_format($order->discount_amount, 0, ',', '.') }} VNĐ
                                    </span>
                                </div>
                            @endif

                            <div class="service__detail-row service__detail-row--total">
                                <span class="service__detail-label">Tổng thanh toán:</span>
                                <span
                                    class="service__detail-value service__detail-price">{{ number_format($order->price - $order->discount_amount, 0, ',', '.') }}
                                    VNĐ</span>
                            </div>
                        </div>
                    </div>

                    @if ($order->admin_note)
                        <div class="service__detail-section">
                            <h3 class="service__detail-section-title">Ghi chú từ admin</h3>
                            <div class="service__detail-note">
                                {{ $order->admin_note }}
                            </div>
                        </div>
                    @endif

                    <div class="service__detail-actions">
                        <a href="{{ route('user.services.history') }}" class="service__btn service__btn--outline">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>

                        @if ($order->status == 'pending')
                            <button type="button" class="service__btn service__btn--danger"
                                onclick="if(confirm('Bạn có chắc chắn muốn hủy đơn này không?')) { document.getElementById('cancel-form').submit(); }">
                                <i class="fas fa-times"></i> Hủy đơn hàng
                            </button>
                            <form id="cancel-form" action="{{ route('user.services.order.cancel', $order->id) }}"
                                method="POST" style="display: none;">
                                @csrf
                                @method('POST')
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .service__detail {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 40px;
            overflow: hidden;
        }

        .service__detail-header {
            padding: 20px;
            background-color: #f9fafc;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .service__detail-status {
            font-size: 1.6rem;
            font-weight: 600;
        }

        .service__detail-status--pending {
            color: #ffa000;
        }

        .service__detail-status--processing {
            color: #1976d2;
        }

        .service__detail-status--completed {
            color: #43a047;
        }

        .service__detail-status--cancelled {
            color: #e53935;
        }

        .service__detail-back {
            color: #555;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .service__detail-back:hover {
            color: #22a7f0;
        }

        .service__detail-content {
            padding: 30px;
        }

        .service__detail-section {
            margin-bottom: 30px;
        }

        .service__detail-section-title {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .service__detail-info {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .service__detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .service__detail-label {
            font-weight: 500;
            color: #555;
            flex: 0 0 150px;
        }

        .service__detail-value {
            color: #333;
        }

        .service__detail-discount {
            color: #43a047;
        }

        .service__detail-row--total {
            margin-top: 10px;
            padding-top: 15px;
            border-top: 1px dashed #eee;
        }

        .service__detail-price {
            font-size: 1.8rem;
            font-weight: 700;
            color: #e53935;
        }

        .service__detail-note {
            padding: 15px;
            background-color: #f9f9fa;
            border-radius: 8px;
            color: #555;
            font-style: italic;
        }

        .service__detail-actions {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 40px;
        }

        @media (max-width: 768px) {
            .service__detail-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .service__detail-back {
                align-self: flex-end;
            }

            .service__detail-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }

            .service__detail-label {
                flex: none;
            }
        }
    </style>
@endpush
