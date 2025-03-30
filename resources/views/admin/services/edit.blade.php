@extends('layouts.admin.app')
@section('title', $title)
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Chỉnh sửa dịch vụ game</h4>
                    <h6>Cập nhật thông tin dịch vụ game</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.services.update', $service->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Tên dịch vụ <span class="text-danger">*</span></label>
                                    <input type="text" name="name" value="{{ old('name', $service->name) }}"
                                        class="form-control @error('name') is-invalid @enderror">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Loại dịch vụ <span class="text-danger">*</span></label>
                                    <select name="type" class="select @error('type') is-invalid @enderror">
                                        <option value="gold"
                                            {{ old('type', $service->type) == 'gold' ? 'selected' : '' }}>
                                            Bán vàng</option>
                                        <option value="gem" {{ old('type', $service->type) == 'gem' ? 'selected' : '' }}>
                                            Bán ngọc</option>
                                        <option value="leveling"
                                            {{ old('type', $service->type) == 'leveling' ? 'selected' : '' }}>Cày thuê
                                        </option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Trạng thái <span class="text-danger">*</span></label>
                                    <select name="active" class="select @error('active') is-invalid @enderror">
                                        <option value="1"
                                            {{ old('active', $service->active) == '1' ? 'selected' : '' }}>
                                            Hiển thị</option>
                                        <option value="0"
                                            {{ old('active', $service->active) == '0' ? 'selected' : '' }}>
                                            Ẩn</option>
                                    </select>
                                    @error('active')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Mô tả dịch vụ <span class="text-danger">*</span></label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $service->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Ảnh đại diện</label>
                                    <div class="image-upload">
                                        <input type="file" name="thumbnail"
                                            class="form-control @error('thumbnail') is-invalid @enderror" accept="image/*"
                                            onchange="previewImage(this, 'preview-thumb')">
                                        @error('thumbnail')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="image-uploads">
                                            <img src="{{ asset('assets/img/icons/upload.svg') }}" alt="Upload Image"
                                                style="max-width: 200px; max-height: 200px;">
                                            <h4>Kéo thả hoặc chọn ảnh để tải lên</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 text-center">
                                <div class="form-group">
                                    <h5>Ảnh đại diện hiện tại</h5>
                                    <img id="preview-thumb" src="{{ $service->thumbnail }}" alt="preview"
                                        class="img-fluid mt-2 mb-2 preview-thumb">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">Cập nhật</button>
                                <a href="{{ route('admin.services.index') }}" class="btn btn-cancel">Hủy bỏ</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-top">
                        <div class="search-set">

                            <div class="search-input">
                                <a class="btn btn-searchset"><img src="{{ asset('assets/img/icons/search-white.svg') }}"
                                        alt="img"></a>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-12">
                        <div class="form-group">
                            <h5>Thông tin gói dịch vụ hiện có</h5>
                            <div class="table-responsive">
                                <table class="table datanew">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên gói</th>
                                            <th>Mô tả</th>
                                            <th>Giá tiền</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($service->packages as $package)
                                            <tr>
                                                <td>{{ $package->id }}</td>
                                                <td>{{ $package->name }}</td>
                                                <td>{{ $package->description }}</td>
                                                <td>{{ number_format($package->price) }} đ</td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-primary">Sửa</a>
                                                    <a href="#" class="btn btn-sm btn-danger">Xóa</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">Chưa có gói dịch vụ nào</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                <a href="#" class="btn btn-primary">Thêm gói dịch vụ mới</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var preview = document.getElementById(previewId);
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
