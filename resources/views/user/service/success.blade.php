@extends('layouts.user.app')

@section('title', 'Đặt Dịch Vụ Thành Công - Ngọc Rồng')

@section('content')
    <x-hero-header title="ĐẶT DỊCH VỤ THÀNH CÔNG" description="Đơn hàng của bạn đã được ghi nhận" />
    <div class="service">
        <div class="container">
            <div class="service__success">
                <div class="service__success-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h2 class="service__success-title">Đặt dịch vụ thành công!</h2>
                <p class="service__success-desc">Cảm ơn bạn đã sử dụng dịch vụ tại Ngọc Rồng Shop. Đơn hàng của bạn đã được
                    ghi nhận và đang chờ xử lý.</p>

                <div class="service__order-details">
                    <h3 class="service__order-title">Chi tiết đơn hàng #{{ $order->id }}</h3>

                    <div class="service__order-info">
                        <div class="service__order-row">
                            <span class="service__order-label">Dịch vụ:</span>
                            <span class="service__order-value">{{ $order->gameService->name }}</span>
                        </div>

                        <div class="service__order-row">
                            <span class="service__order-label">Gói dịch vụ:</span>
                            <span class="service__order-value">{{ $order->servicePackage->name }}</span>
                        </div>

                        <div class="service__order-row">
                            <span class="service__order-label">Máy chủ:</span>
                            <span class="service__order-value">Server {{ $order->server }}</span>
                        </div>

                        <div class="service__order-row">
                            <span class="service__order-label">Tài khoản:</span>
                            <span class="service__order-value">{{ $order->game_account }}</span>
                        </div>

                        <div class="service__order-row">
                            <span class="service__order-label">Trạng thái:</span>
                            <span class="service__order-value service__order-status--{{ $order->status }}">
                                @switch($order->status)
                                    @case('pending')
                                        Đang chờ xử lý
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
                        </div>

                        <div class="service__order-row">
                            <span class="service__order-label">Thời gian đặt:</span>
                            <span class="service__order-value">{{ $order->created_at->format('H:i d/m/Y') }}</span>
                        </div>

                        <div class="service__order-row service__order-row--total">
                            <span class="service__order-label">Tổng tiền:</span>
                            <span
                                class="service__order-value service__order-price">{{ number_format($order->price, 0, ',', '.') }}
                                VNĐ</span>
                        </div>
                    </div>
                </div>

                <div class="service__success-actions">
                    <a href="{{ route('user.services.history') }}" class="service__btn service__btn--primary">
                        <i class="fas fa-history"></i> Lịch sử đơn hàng
                    </a>
                    <a href="{{ route('home') }}" class="service__btn service__btn--outline">
                        <i class="fas fa-home"></i> Về trang chủ
                    </a>
                </div>

                <div class="service__success-note">
                    <p><strong>Lưu ý:</strong> Thời gian xử lý nhiệm vụ có thể mất từ 24-48h tùy theo độ khó của nhiệm vụ.
                        Admin sẽ liên hệ với bạn nếu cần thêm thông tin.</p>
                    <p>Nếu có thắc mắc, vui lòng liên hệ ZALO: 0396498015 hoặc <a
                            href="https://facebook.com/octiiu957.official/" target="_blank">Facebook</a>.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
