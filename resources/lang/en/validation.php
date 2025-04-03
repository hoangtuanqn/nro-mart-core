<?php
// Ghi đè thông báo hệ thống
return [
    'required' => 'Trường :attribute là bắt buộc',
    'string' => 'Trường :attribute phải là chuỗi ký tự',
    'numeric' => 'Trường :attribute phải là số',
    'integer' => 'Trường :attribute phải là số nguyên',
    'current_password' => 'Mật khẩu hiện tại không đúng',
    'min' => [
        'numeric' => 'Trường :attribute không được nhỏ hơn :min',
        'string' => 'Trường :attribute phải có ít nhất :min ký tự',
    ],
    'max' => [
        'numeric' => 'Trường :attribute không được lớn hơn :max',
        'string' => 'Trường :attribute không được vượt quá :max ký tự',
    ],
    'email' => 'Trường :attribute phải là một địa chỉ email hợp lệ',
    'unique' => 'Trường :attribute đã tồn tại trong hệ thống',
    'date' => 'Trường :attribute không phải là định dạng của ngày',
    'array' => 'Trường :attribute phải là dạng mảng',
    'boolean' => 'Trường :attribute phải là true hoặc false',
    'confirmed' => 'Trường :attribute xác nhận không khớp',
    'image' => 'Trường :attribute phải là định dạng hình ảnh',
    'in' => 'Giá trị đã chọn trong trường :attribute không hợp lệ',
    'between' => [
        'numeric' => 'Trường :attribute phải nằm giữa :min và :max',
        'string' => 'Trường :attribute phải có độ dài giữa :min và :max ký tự',
    ],


    // Custom cho từng field
    'password' => [
        'confirmed' => 'Mật khẩu nhập lại không khớp',
    ],
];