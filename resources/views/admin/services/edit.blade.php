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
                        <div class="page-header">
                            <div class="page-title">
                                <h4>Các gói dịch vụ hiện có</h4>
                                <h6>Quản lý các gói dịch vụ thuộc {{ $service->name }}</h6>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-12">
                        <div class="form-group">
                            <div class="table-responsive">
                                <table class="table datanew">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên gói</th>
                                            <th>Giá</th>
                                            <th>Thời gian ước tính</th>
                                            <th>Trạng thái</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($service->packages as $package)
                                            <tr>
                                                <td>{{ $package->id }}</td>
                                                <td>{{ $package->name }}</td>
                                                <td>{{ number_format($package->price) }} đ</td>
                                                <td>
                                                    @if ($package->estimated_time)
                                                        {{ $package->estimated_time }} phút
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    <span
                                                        class="badges {{ $package->active ? 'bg-lightgreen' : 'bg-lightred' }}">
                                                        {{ $package->active ? 'Hoạt động' : 'Đã ẩn' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.packages.edit', $package->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="Sửa">
                                                    </a>
                                                    <a href="javascript:void(0);"
                                                        class="btn btn-sm btn-danger delete-package"
                                                        data-id="{{ $package->id }}" data-name="{{ $package->name }}">
                                                        <img src="{{ asset('assets/img/icons/delete.svg') }}"
                                                            alt="Xóa">
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">Chưa có gói dịch vụ nào</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('admin.packages.createForService', $service->id) }}"
                                    class="btn btn-primary">
                                    <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">
                                    Thêm gói dịch vụ mới
                                </a>
                                <a href="{{ route('admin.packages.service', $service->id) }}" class="btn btn-secondary">
                                    <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="img" class="me-1">
                                    Xem tất cả gói dịch vụ
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal xác nhận xóa gói -->
    <div class="modal fade" id="deletePackageModal" tabindex="-1" aria-labelledby="deletePackageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePackageModalLabel">Xác nhận xóa gói dịch vụ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa gói dịch vụ "<span id="package-name"></span>" không?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-danger" id="confirmDeletePackage">Xóa</button>
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

        // Xử lý xóa gói dịch vụ
        $(document).ready(function() {
            let packageId;

            $('.delete-package').on('click', function() {
                packageId = $(this).data('id');
                const packageName = $(this).data('name');
                $('#package-name').text(packageName);
                $('#deletePackageModal').modal('show');
            });

            $('#confirmDeletePackage').on('click', function() {
                $.ajax({
                    url: '/admin/packages/delete/' + packageId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#deletePackageModal').modal('hide');
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công!',
                                text: 'Đã xóa gói dịch vụ thành công',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: response.message ||
                                    'Có lỗi xảy ra khi xóa gói dịch vụ',
                            });
                        }
                    },
                    error: function(xhr) {
                        $('#deletePackageModal').modal('hide');
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: xhr.responseJSON?.message ||
                                'Có lỗi xảy ra khi xóa gói dịch vụ',
                        });
                    }
                });
            });
        });
    </script>
@endpush
