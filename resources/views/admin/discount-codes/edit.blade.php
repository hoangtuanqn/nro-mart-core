@extends('layouts.admin.app')
@section('title', $title)
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Chỉnh sửa mã giảm giá</h4>
                    <h6>Cập nhật thông tin mã giảm giá</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.discount-codes.update', $discountCode->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Mã giảm giá <span class="text-danger">*</span></label>
                                    <input type="text" name="code" value="{{ old('code', $discountCode->code) }}"
                                        class="form-control @error('code') is-invalid @enderror">
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Kiểu <span class="text-danger">*</span></label>
                                    <select name="type" class="select @error('type') is-invalid @enderror"
                                        id="discountType">
                                        <option value="percentage"
                                            {{ old('type', $discountCode->discount_type) == 'percentage' ? 'selected' : '' }}>
                                            Phần
                                            trăm (%)</option>
                                        <option value="fixed_amount"
                                            {{ old('type', $discountCode->discount_type) == 'fixed_amount' ? 'selected' : '' }}>
                                            Số tiền cố
                                            định (VNĐ)</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Giá trị <span class="text-danger">*</span></label>
                                    <input type="number" name="value"
                                        value="{{ old('value', $discountCode->discount_value) }}"
                                        class="form-control @error('value') is-invalid @enderror">
                                    @error('value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12" id="maxDiscountGroup">
                                <div class="form-group">
                                    <label>Giảm tối đa (0 = không giới hạn)</label>
                                    <input type="number" name="max_discount"
                                        value="{{ old('max_discount', $discountCode->max_discount_value) }}"
                                        class="form-control @error('max_discount') is-invalid @enderror">
                                    @error('max_discount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Số tiền mua tối thiểu</label>
                                    <input type="number" name="min_purchase_amount"
                                        value="{{ old('min_purchase_amount', $discountCode->min_purchase_amount) }}"
                                        class="form-control @error('min_purchase_amount') is-invalid @enderror">
                                    @error('min_purchase_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Lượt sử dụng tối đa (để trống = không giới hạn)</label>
                                    <input type="number" name="usage_limit"
                                        value="{{ old('usage_limit', $discountCode->usage_limit) }}"
                                        class="form-control @error('usage_limit') is-invalid @enderror">
                                    @error('usage_limit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Giới hạn lượt dùng mỗi người (để trống = không giới hạn)</label>
                                    <input type="number" name="per_user_limit"
                                        value="{{ old('per_user_limit', $discountCode->per_user_limit) }}"
                                        class="form-control @error('per_user_limit') is-invalid @enderror">
                                    @error('per_user_limit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Áp dụng cho</label>
                                    <select name="applicable_to"
                                        class="select @error('applicable_to') is-invalid @enderror">
                                        <option value="">Tất cả</option>
                                        <option value="account"
                                            {{ old('applicable_to', $discountCode->applicable_to) == 'account' ? 'selected' : '' }}>
                                            Tài khoản</option>
                                        <option value="random_account"
                                            {{ old('applicable_to', $discountCode->applicable_to) == 'random_account' ? 'selected' : '' }}>
                                            Random tài khoản</option>
                                        <option value="service"
                                            {{ old('applicable_to', $discountCode->applicable_to) == 'service' ? 'selected' : '' }}>
                                            Dịch vụ</option>
                                    </select>
                                    @error('applicable_to')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Ngày hết hạn (để trống = không hết hạn)</label>
                                    <input type="date" name="expires_at"
                                        value="{{ old('expires_at', $discountCode->expire_date ? date('Y-m-d', strtotime($discountCode->expire_date)) : '') }}"
                                        class="form-control @error('expires_at') is-invalid @enderror">
                                    @error('expires_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Trạng thái <span class="text-danger">*</span></label>
                                    <select name="is_active" class="select @error('is_active') is-invalid @enderror">
                                        <option value="1"
                                            {{ old('is_active', $discountCode->is_active) === '1' ? 'selected' : '' }}>Hoạt
                                            động
                                        </option>
                                        <option value="0"
                                            {{ old('is_active', $discountCode->is_active) === '0' ? 'selected' : '' }}>
                                            Không hoạt
                                            động</option>
                                    </select>
                                    @error('is_active')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Mô tả</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $discountCode->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">Cập nhật</button>
                                <a href="{{ route('admin.discount-codes.index') }}" class="btn btn-cancel">Hủy</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const discountType = document.getElementById('discountType');
            const valueInput = document.querySelector('input[name="value"]');
            const maxDiscountGroup = document.getElementById('maxDiscountGroup');

            // Initial state
            updateValueLabel();
            updateMaxDiscountVisibility();

            // Event listener
            discountType.addEventListener('change', function() {
                updateValueLabel();
                updateMaxDiscountVisibility();
            });

            function updateValueLabel() {
                const label = valueInput.closest('.form-group').querySelector('label');
                if (discountType.value === 'percentage') {
                    label.innerHTML = 'Giá trị (%) <span class="text-danger">*</span>';
                } else {
                    label.innerHTML = 'Giá trị (VNĐ) <span class="text-danger">*</span>';
                }
            }

            function updateMaxDiscountVisibility() {
                if (discountType.value === 'percentage') {
                    maxDiscountGroup.style.display = 'block';
                } else {
                    maxDiscountGroup.style.display = 'none';
                }
            }
        });
    </script>
@endpush
