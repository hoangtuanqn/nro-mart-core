@extends('layouts.admin.app')
@section('title', $title)
@push('css')
    <style>
        .ck-editor__editable_inline {
            min-height: 200px;
        }

        .config-table th,
        .config-table td {
            padding: 0.5rem 0.25rem;
        }

        @media (max-width: 767.98px) {

            .config-table input,
            .config-table select {
                font-size: 0.85rem;
                width: 100%;
            }
        }
    </style>
@endpush

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Thêm vòng quay may mắn</h4>
                    <h6>Tạo mới vòng quay may mắn</h6>
                </div>
                <div class="page-btn">
                    <a href="{{ route('admin.lucky-wheels.index') }}" class="btn btn-added">
                        <i class="fa fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Lỗi!</strong> Đã xảy ra lỗi khi tạo mới vòng quay may mắn.
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.lucky-wheels.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-8 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="name">Tên vòng quay <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ old('name') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="price_per_spin">Giá mỗi lượt quay (VNĐ) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="price_per_spin" name="price_per_spin"
                                        value="{{ old('price_per_spin', 10000) }}" required min="0" step="1000">
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Ảnh đại diện <span class="text-danger">*</span></label>
                                    <div class="image-upload">
                                        <input type="file" name="thumbnail"
                                            class="form-control @error('thumbnail') is-invalid @enderror" accept="image/*"
                                            onchange="previewImage(this, 'preview-thumbnail')">
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


                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Ảnh vòng quay <span class="text-danger">*</span></label>
                                    <div class="image-upload">
                                        <input type="file" name="wheel_image"
                                            class="form-control @error('wheel_image') is-invalid @enderror" accept="image/*"
                                            onchange="previewImage(this, 'preview-wheel')">
                                        @error('wheel_image')
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

                            <div class="col-lg-12 text-center mt-3 mb-3">
                                <div class="d-flex flex-wrap justify-content-center gap-3">
                                    <div class="mb-3">
                                        <p class="mb-2">Ảnh đại diện:</p>
                                        <img id="preview-thumbnail" src="https://i.imgur.com/NpL6V6y.png"
                                            alt="Thumbnail Preview" class="preview-thumb">
                                    </div>
                                    <div class="mb-3">
                                        <p class="mb-2">Ảnh vòng quay:</p>
                                        <img id="preview-wheel" src="https://i.imgur.com/NpL6V6y.png" alt="Wheel Preview"
                                            class="preview-thumb">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="description">Mô tả vòng quay</label>
                                    <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-12 mt-3">
                                <div class="form-group">
                                    <label for="rules">Thể lệ vòng quay <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="rules" name="rules" required>{{ old('rules') }}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="active">Trạng thái</label>
                                    <select name="active" id="active" class="select">
                                        <option value="1" {{ old('active', 1) ? 'selected' : '' }}>Hoạt động</option>
                                        <option value="0" {{ old('active', 1) ? '' : 'selected' }}>Không hoạt động
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <!-- Phần cấu hình phần thưởng -->
                            <div class="col-lg-12 mt-3">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Cấu hình phần thưởng (8 ô)</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered config-table"
                                                id="configTable">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th class="text-center" style="width: 5%">STT</th>
                                                        <th class="text-center" style="width: 10%">Loại</th>
                                                        <th class="text-center">Nội dung</th>
                                                        <th class="text-center">Số lượng</th>
                                                        <th class="text-center" style="width: 12%">Xác suất (Tổng 100%)
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $oldConfig = old('config', $defaultConfig);
                                                    @endphp

                                                    @for ($i = 0; $i < 8; $i++)
                                                        <tr>
                                                            <td class="text-center align-middle">{{ $i + 1 }}</td>
                                                            <td>
                                                                <select name="config[{{ $i }}][type]"
                                                                    class="select form-select-sm reward-type"
                                                                    data-index="{{ $i }}">
                                                                    <option value="gold"
                                                                        {{ isset($oldConfig[$i]) && $oldConfig[$i]['type'] == 'gold' ? 'selected' : '' }}>
                                                                        Vàng</option>
                                                                    <option value="gem"
                                                                        {{ isset($oldConfig[$i]) && $oldConfig[$i]['type'] == 'gem' ? 'selected' : '' }}>
                                                                        Ngọc</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    name="config[{{ $i }}][content]"
                                                                    value="{{ isset($oldConfig[$i]) ? $oldConfig[$i]['content'] : '' }}"
                                                                    class="form-control" required
                                                                    placeholder="Nội dung phần thưởng">
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm">
                                                                    <input type="number"
                                                                        name="config[{{ $i }}][amount]"
                                                                        value="{{ isset($oldConfig[$i]) ? $oldConfig[$i]['amount'] : 0 }}"
                                                                        class="form-control" min="0" required>
                                                                    <span
                                                                        class="input-group-text reward-symbol-{{ $i }}">
                                                                        {{ isset($oldConfig[$i]) && $oldConfig[$i]['type'] == 'gem' ? 'Ngọc' : 'Vàng' }}
                                                                    </span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm">
                                                                    <input type="number"
                                                                        name="config[{{ $i }}][probability]"
                                                                        value="{{ isset($oldConfig[$i]) ? $oldConfig[$i]['probability'] : 0 }}"
                                                                        class="form-control" min="0"
                                                                        max="100" step="0.1" required>
                                                                    <span class="input-group-text">%</span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endfor
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group mb-0 text-end">
                                    <a href="{{ route('admin.lucky-wheels.index') }}" class="btn btn-secondary">Hủy</a>
                                    <button type="submit" id="submitButton" class="btn btn-primary">Thêm mới</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Khởi tạo CKEditor cho mô tả
            let descriptionEditor;
            if (document.querySelector('#description')) {
                ClassicEditor
                    .create(document.querySelector('#description'), {
                        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList']
                    })
                    .then(editor => {
                        descriptionEditor = editor;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }

            // Khởi tạo CKEditor cho thể lệ
            let rulesEditor;
            if (document.querySelector('#rules')) {
                ClassicEditor
                    .create(document.querySelector('#rules'), {
                        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList']
                    })
                    .then(editor => {
                        rulesEditor = editor;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }

            // Xử lý loại phần thưởng
            const rewardTypes = document.querySelectorAll('.reward-type');
            rewardTypes.forEach(select => {
                select.addEventListener('change', function() {
                    const index = this.getAttribute('data-index');
                    const value = this.value;
                    const symbolElement = document.querySelector(`.reward-symbol-${index}`);

                    if (value === 'gem') {
                        symbolElement.textContent = 'Ngọc';
                    } else {
                        symbolElement.textContent = 'Vàng';
                    }
                });
            });

            // Xử lý nút submit
            document.getElementById('submitButton').addEventListener('click', function(e) {
                e.preventDefault(); // Ngăn chặn hành vi mặc định của button submit

                // Cập nhật dữ liệu từ CKEditor vào textarea
                if (descriptionEditor) {
                    document.querySelector('#description').value = descriptionEditor.getData();
                }

                if (rulesEditor) {
                    document.querySelector('#rules').value = rulesEditor.getData();
                }

                // Submit form sau khi đã cập nhật dữ liệu
                document.querySelector('form').submit();
            });
        });
    </script>
@endpush
