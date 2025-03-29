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