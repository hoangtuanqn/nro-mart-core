@extends('layouts.admin.app')
@section('title', $title)
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Thêm gói dịch vụ mới</h4>
                    <h6>Tạo gói dịch vụ mới</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.packages.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Dịch vụ <span class="text-danger">*</span></label>
                                    <select name="game_service_id"
                                        class="select @error('game_service_id') is-invalid @enderror">
                                        <option value="">Chọn dịch vụ</option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}"
                                                {{ old('game_service_id') == $service->id || (isset($selectedService) && $selectedService->id == $service->id) ? 'selected' : '' }}>
                                                {{ $service->name }}
                                                ({{ $service->type == 'gold' ? 'Bán vàng' : ($service->type == 'gem' ? 'Bán ngọc' : 'Cày thuê') }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('game_service_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Tên gói dịch vụ <span class="text-danger">*</span></label>
                                    <input type="text" name="name" value="{{ old('name') }}"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Ví dụ: Gói 1000 vàng, Gói 100 ngọc...">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Số lượng <span class="text-danger">*</span></label>
                                    <input type="number" name="amount" value="{{ old('amount') }}"
                                        class="form-control @error('amount') is-invalid @enderror"
                                        placeholder="Ví dụ: 1000">
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Giá (VND) <span class="text-danger">*</span></label>
                                    <input type="number" name="price" value="{{ old('price') }}"
                                        class="form-control @error('price') is-invalid @enderror"
                                        placeholder="Ví dụ: 100000">
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Thời gian ước tính (phút)</label>
                                    <input type="number" name="estimated_time" value="{{ old('estimated_time') }}"
                                        class="form-control @error('estimated_time') is-invalid @enderror"
                                        placeholder="Ví dụ: 60">
                                    @error('estimated_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Trạng thái <span class="text-danger">*</span></label>
                                    <select name="active" class="select @error('active') is-invalid @enderror">
                                        <option value="1" {{ old('active', '1') == '1' ? 'selected' : '' }}>Hiển thị
                                        </option>
                                        <option value="0" {{ old('active') == '0' ? 'selected' : '' }}>Ẩn</option>
                                    </select>
                                    @error('active')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Mô tả gói dịch vụ</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4"
                                        placeholder="Mô tả chi tiết về gói dịch vụ">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">Tạo mới</button>
                                <a href="{{ isset($selectedService) ? route('admin.packages.service', $selectedService->id) : route('admin.packages.index') }}"
                                    class="btn btn-cancel">Hủy bỏ</a>
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
        $(document).ready(function() {
            // Nếu là dịch vụ cày thuê, hiển thị trường thời gian ước tính
            $('select[name="game_service_id"]').on('change', function() {
                const serviceType = $(this).find('option:selected').text();
                if (serviceType.includes('Cày thuê')) {
                    $('input[name="estimated_time"]').parent('.form-group').show();
                } else {
                    $('input[name="estimated_time"]').parent('.form-group').hide();
                    $('input[name="estimated_time"]').val('');
                }
            }).trigger('change');
        });
    </script>
@endpush
