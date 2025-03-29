<?php

function display_status_nap_tien($status)
{
    switch ($status) {
        case 'success':
            return '<span class="status-badge success">Thành công</span>';
        case 'error':
            return '<span class="status-badge error">Lỗi</span>';
        case 'processing':
            return '<span class="status-badge processing">Đang xử lý</span>';
        default:
            return '<span class="status-badge unknown">Không xác định</span>';
    }
}
function display_status_service($status)
{
    switch ($status) {
        case 'pending':
            return '<span class="status-badge warning">Chờ xử lý</span>';
        case 'processing':
            return '<span class="status-badge info">Đang xử lý</span>';
        case 'completed':
            return '<span class="status-badge success">Hoàn thành</span>';
        case 'cancelled':
            return '<span class="status-badge error">Đã hủy</span>';
        default:
            return '<span class="status-badge secondary">Không xác định</span>';
    }
}
function display_hanh_tinh($planet)
{
    switch ($planet) {
        case 'xayda':
            return 'Xayda';
        case 'earth':
            return 'Trái đất';
        case 'namek':
            return 'Namek';
        default:
            return 'Không xác định';
    }
}

function display_dang_ky($planet)
{
    switch ($planet) {
        case 'real':
            return 'Thật';
        case 'virtual':
            return 'Ảo';
        default:
            return 'Không xác định';
    }
}