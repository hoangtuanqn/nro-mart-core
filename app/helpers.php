<?php

function display_status($status)
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