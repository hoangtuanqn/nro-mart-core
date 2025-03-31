@extends('layouts.admin.app')
@section('title', $title)
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Thêm Mã Giảm Giá</h4>
                    <h6>Tạo mã giảm giá mới</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.discount-codes.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Mã giảm giá <span class="text-danger">*</span></label>
                                    <input type="text" name="code" value="{{ old('code') }}"
                                        class="form-control @error('code') is-invalid @enderror"
                                        placeholder="Để trống để tạo mã tự động">
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Kiểu <span class="text-danger">*</span></label>
                                    <select name="type" class="form-select @error('type') is-invalid @enderror"
                                        id="discountType">
                                        <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Phần
                                            trăm (%)</option>
                                        <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Số tiền cố
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
                                    <input type="number" name="value" value="{{ old('value') }}"
                                        class="form-control @error('value') is-invalid @enderror">
                                    @error('value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Giảm tối đa (0 = không giới hạn)</label>
                                    <input type="number" name="max_discount" value="{{ old('max_discount', 0) }}"
                                        class="form-control @error('max_discount') is-invalid @enderror">
                                    @error('max_discount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Lượt sử dụng <span class="text-danger">*</span></label>
                                    <input type="number" name="usage_limit" value="{{ old('usage_limit', 1) }}"
                                        class="form-control @error('usage_limit') is-invalid @enderror">
                                    @error('usage_limit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Ngày hết hạn (để trống = không hết hạn)</label>
                                    <input type="date" name="expires_at" value="{{ old('expires_at') }}"
                                        class="form-control @error('expires_at') is-invalid @enderror">
                                    @error('expires_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Trạng thái <span class="text-danger">*</span></label>
                                    <select name="is_active" class="form-select @error('is_active') is-invalid @enderror">
                                        <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Hoạt
                                            động</option>
                                        <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Không hoạt
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
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">Tạo mã giảm giá</button>
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
            const maxDiscountGroup = document.querySelector('input[name="max_discount"]').closest('.form-group');

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
