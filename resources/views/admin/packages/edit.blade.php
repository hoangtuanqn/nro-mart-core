@extends('layouts.admin.app')
@section('title', $title)
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Chỉnh sửa gói dịch vụ</h4>
                    <h6>Cập nhật thông tin gói dịch vụ</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.packages.update', $package->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Dịch vụ <span class="text-danger">*</span></label>
                                    <select name="game_service_id"
                                        class="select @error('game_service_id') is-invalid @enderror">
                                        <option value="">Chọn dịch vụ</option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}"
                                                {{ old('game_service_id', $package->game_service_id) == $service->id ? 'selected' : '' }}>
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
                                    <input type="text" name="name" value="{{ old('name', $package->name) }}"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Ví dụ: Gói 1000 vàng, Gói 100 ngọc...">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Giá (VND) <span class="text-danger">*</span></label>
                                    <input type="number" name="price" value="{{ old('price', $package->price) }}"
                                        class="form-control @error('price') is-invalid @enderror"
                                        placeholder="Ví dụ: 100000">
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12" id="estimated-time-group">
                                <div class="form-group">
                                    <label>Thời gian ước tính (phút)</label>
                                    <input type="number" name="estimated_time"
                                        value="{{ old('estimated_time', $package->estimated_time) }}"
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
                                        <option value="1"
                                            {{ old('active', $package->active) == '1' ? 'selected' : '' }}>Hiển thị
                                        </option>
                                        <option value="0"
                                            {{ old('active', $package->active) == '0' ? 'selected' : '' }}>Ẩn</option>
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
                                        placeholder="Mô tả chi tiết về gói dịch vụ">{{ old('description', $package->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">Cập nhật</button>
                                <a href="{{ route('admin.packages.service', $package->game_service_id) }}"
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
            function updateEstimatedTimeVisibility() {
                const serviceType = $('select[name="game_service_id"] option:selected').text();
                if (serviceType.includes('Cày thuê')) {
                    $('#estimated-time-group').show();
                } else {
                    $('#estimated-time-group').hide();
                    if (!$('input[name="estimated_time"]').data('has-value')) {
                        $('input[name="estimated_time"]').val('');
                    }
                }
            }

            // Nếu đã có giá trị, lưu lại để không bị xóa khi ẩn
            if ($('input[name="estimated_time"]').val()) {
                $('input[name="estimated_time"]').data('has-value', true);
            }

            $('select[name="game_service_id"]').on('change', updateEstimatedTimeVisibility);

            // Kích hoạt khi trang tải xong
            updateEstimatedTimeVisibility();
        });
    </script>
@endpush
