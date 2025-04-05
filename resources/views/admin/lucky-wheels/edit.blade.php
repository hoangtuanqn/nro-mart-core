@extends('layouts.admin.app')
@section('title', $title)
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Chỉnh sửa vòng quay may mắn</h4>
                    <h6>Cập nhật thông tin vòng quay may mắn</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.lucky-wheels.update', $luckyWheel->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Tên vòng quay <span class="text-danger">*</span></label>
                                    <input type="text" name="name" value="{{ old('name', $luckyWheel->name) }}"
                                        class="form-control @error('name') is-invalid @enderror" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Giá mỗi lượt quay (VNĐ) <span class="text-danger">*</span></label>
                                    <input type="number" name="price_per_spin"
                                        value="{{ old('price_per_spin', $luckyWheel->price_per_spin) }}"
                                        class="form-control @error('price_per_spin') is-invalid @enderror" min="1000"
                                        required>
                                    @error('price_per_spin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
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
                                                style="max-width: 100px; max-height: 100px;">
                                            <h4>Kéo thả hoặc chọn ảnh đại diện mới</h4>
                                        </div>
                                        <div class="mt-2">
                                            <p>Ảnh đại diện hiện tại:</p>
                                            <img src="{{ $luckyWheel->thumbnail }}" alt="{{ $luckyWheel->name }}"
                                                id="current-thumbnail" class="img-fluid rounded"
                                                style="max-width: 200px; max-height: 150px;">
                                            <img id="preview-thumbnail" src="#" alt="preview"
                                                class="img-fluid mt-2 rounded"
                                                style="max-width: 200px; max-height: 150px; display: none;">
                                        </div>
                                    </div>
                                    <input type="hidden" name="current_thumbnail" value="{{ $luckyWheel->thumbnail }}">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
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
                                                style="max-width: 100px; max-height: 100px;">
                                            <h4>Kéo thả hoặc chọn ảnh vòng quay mới</h4>
                                        </div>
                                        <div class="mt-2">
                                            <p>Ảnh vòng quay hiện tại:</p>
                                            <img src="{{ $luckyWheel->wheel_image }}" alt="Hình ảnh vòng quay"
                                                id="current-wheel" class="img-fluid rounded"
                                                style="max-width: 200px; max-height: 150px;">
                                            <img id="preview-wheel" src="#" alt="preview"
                                                class="img-fluid mt-2 rounded"
                                                style="max-width: 200px; max-height: 150px; display: none;">
                                        </div>
                                    </div>
                                    <input type="hidden" name="current_wheel_image"
                                        value="{{ $luckyWheel->wheel_image }}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Mô tả</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $luckyWheel->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Thể lệ vòng quay <span class="text-danger">*</span></label>
                                    <div class="editor-container">
                                        <textarea name="rules" id="editor" class="form-control @error('rules') is-invalid @enderror">{{ old('rules', $luckyWheel->rules) }}</textarea>
                                    </div>
                                    @error('rules')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Trạng thái <span class="text-danger">*</span></label>
                                    <select name="active" class="form-select @error('active') is-invalid @enderror"
                                        required>
                                        <option value="1" {{ old('active', $luckyWheel->active) ? 'selected' : '' }}>
                                            Hoạt động</option>
                                        <option value="0" {{ old('active', $luckyWheel->active) ? '' : 'selected' }}>
                                            Không hoạt động</option>
                                    </select>
                                    @error('active')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Phần cấu hình phần thưởng -->
                            <div class="col-lg-12 mt-3">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Cấu hình phần thưởng (8 ô)</h5>
                                        <p class="card-text">Tổng xác suất các ô phải bằng đúng 100%. Vui lòng kiểm tra kỹ
                                            trước khi lưu.</p>
                                    </div>
                                    <div class="card-body">
                                        @error('config')
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                {{ $message }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        @enderror

                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered" id="configTable">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th class="text-center" width="5%">STT</th>
                                                        <th class="text-center" width="10%">Loại</th>
                                                        <th class="text-center" width="35%">Nội dung</th>
                                                        <th class="text-center" width="25%">Số lượng</th>
                                                        <th class="text-center" width="15%">Xác suất (%)</th>
                                                        <th class="text-center" width="10%">Xem trước</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $oldConfig = old('config', $config);
                                                    @endphp

                                                    @for ($i = 0; $i < 8; $i++)
                                                        <tr>
                                                            <td class="text-center align-middle">{{ $i + 1 }}</td>
                                                            <td>
                                                                <div class="form-group mb-0">
                                                                    <select name="config[{{ $i }}][type]"
                                                                        class="select form-select reward-type"
                                                                        data-index="{{ $i }}">
                                                                        <option value="gold"
                                                                            {{ isset($oldConfig[$i]) && $oldConfig[$i]['type'] == 'gold' ? 'selected' : '' }}>
                                                                            Vàng</option>
                                                                        <option value="gem"
                                                                            {{ isset($oldConfig[$i]) && $oldConfig[$i]['type'] == 'gem' ? 'selected' : '' }}>
                                                                            Ngọc</option>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-group mb-0">
                                                                    <input type="text"
                                                                        name="config[{{ $i }}][content]"
                                                                        value="{{ isset($oldConfig[$i]) ? $oldConfig[$i]['content'] : '' }}"
                                                                        class="form-control content-input"
                                                                        data-index="{{ $i }}" required
                                                                        placeholder="VD: Trúng 100 triệu vàng">
                                                                    <div class="invalid-feedback">
                                                                        Vui lòng nhập nội dung phần thưởng
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <input type="number"
                                                                        name="config[{{ $i }}][amount]"
                                                                        value="{{ isset($oldConfig[$i]) ? $oldConfig[$i]['amount'] : 0 }}"
                                                                        class="form-control amount-input"
                                                                        data-index="{{ $i }}" min="0"
                                                                        required placeholder="VD: 100000000">
                                                                    <span
                                                                        class="input-group-text reward-symbol-{{ $i }}">
                                                                        {{ isset($oldConfig[$i]) && $oldConfig[$i]['type'] == 'gem' ? 'Ngọc' : 'Vàng' }}
                                                                    </span>
                                                                    <div class="invalid-feedback">
                                                                        Vui lòng nhập số lượng phần thưởng
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <input type="number"
                                                                        name="config[{{ $i }}][probability]"
                                                                        value="{{ isset($oldConfig[$i]) ? $oldConfig[$i]['probability'] : 0 }}"
                                                                        class="form-control probability-input"
                                                                        min="0" max="100" required
                                                                        step="0.1" placeholder="VD: 12.5">
                                                                    <span class="input-group-text">%</span>
                                                                    <div class="invalid-feedback">
                                                                        Xác suất phải từ 0-100%
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                <span
                                                                    class="preview-badge-{{ $i }} badges {{ isset($oldConfig[$i]) && $oldConfig[$i]['type'] == 'gem' ? 'bg-info' : 'bg-warning' }}">
                                                                    {{ isset($oldConfig[$i]) && $oldConfig[$i]['type'] == 'gem' ? 'Ngọc' : 'Vàng' }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endfor
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="4" class="text-end fw-bold">Tổng xác suất:</td>
                                                        <td colspan="2">
                                                            <div class="progress">
                                                                <div id="probabilityProgressBar" class="progress-bar"
                                                                    role="progressbar" style="width: 0%;"
                                                                    aria-valuenow="0" aria-valuemin="0"
                                                                    aria-valuemax="100">0%</div>
                                                            </div>
                                                            <span id="totalProbability"
                                                                class="fw-bold mt-2 d-inline-block">0</span>%
                                                            <span id="probabilityStatus" class="ms-2"></span>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <div class="alert alert-info mt-3">
                                            <i class="fa fa-info-circle me-2"></i> Lưu ý: Xác suất có thể sử dụng số thập
                                            phân (VD: 12.5%) và tổng xác suất phải đúng bằng 100%.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 mt-3">
                                <button type="submit" class="btn btn-submit me-2">Cập nhật</button>
                                <a href="{{ route('admin.lucky-wheels.index') }}" class="btn btn-cancel">Hủy</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.0/classic/ckeditor.js"></script>
    <script>
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var preview = document.getElementById(previewId);
                    preview.src = e.target.result;
                    preview.style.display = 'block';

                    // Ẩn ảnh hiện tại khi có ảnh xem trước mới
                    var currentImageId = 'current-' + previewId.replace('preview-', '');
                    var currentImage = document.getElementById(currentImageId);
                    if (currentImage) {
                        currentImage.style.display = 'none';
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Khởi tạo CKEditor 5
            ClassicEditor
                .create(document.querySelector('#editor'), {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                        'outdent', 'indent', '|', 'blockQuote', 'insertTable', 'undo', 'redo'
                    ],
                    heading: {
                        options: [{
                                model: 'paragraph',
                                title: 'Paragraph',
                                class: 'ck-heading_paragraph'
                            },
                            {
                                model: 'heading1',
                                view: 'h1',
                                title: 'Heading 1',
                                class: 'ck-heading_heading1'
                            },
                            {
                                model: 'heading2',
                                view: 'h2',
                                title: 'Heading 2',
                                class: 'ck-heading_heading2'
                            },
                            {
                                model: 'heading3',
                                view: 'h3',
                                title: 'Heading 3',
                                class: 'ck-heading_heading3'
                            }
                        ]
                    }
                })
                .then(editor => {
                    console.log('CKEditor đã được khởi tạo', editor);
                })
                .catch(error => {
                    console.error('Lỗi khởi tạo CKEditor:', error);
                });

            // Tính tổng xác suất và cập nhật thanh tiến trình
            function calculateTotalProbability() {
                const inputs = document.querySelectorAll('.probability-input');
                let total = 0;

                inputs.forEach(input => {
                    total += parseFloat(input.value) || 0;
                });

                // Hiển thị tổng xác suất
                const totalElement = document.getElementById('totalProbability');
                totalElement.textContent = total.toFixed(1);

                // Cập nhật progress bar
                const progressBar = document.getElementById('probabilityProgressBar');
                progressBar.style.width = `${total}%`;
                progressBar.setAttribute('aria-valuenow', total);
                progressBar.textContent = `${total.toFixed(1)}%`;

                // Set màu cho progress bar
                if (total < 100) {
                    progressBar.classList.remove('bg-success', 'bg-danger');
                    progressBar.classList.add('bg-warning');
                    document.getElementById('probabilityStatus').innerHTML =
                        '<i class="fa fa-exclamation-triangle text-warning"></i> <small class="text-warning">Chưa đủ 100%</small>';
                } else if (total > 100) {
                    progressBar.classList.remove('bg-success', 'bg-warning');
                    progressBar.classList.add('bg-danger');
                    document.getElementById('probabilityStatus').innerHTML =
                        '<i class="fa fa-times-circle text-danger"></i> <small class="text-danger">Vượt quá 100%</small>';
                } else {
                    progressBar.classList.remove('bg-warning', 'bg-danger');
                    progressBar.classList.add('bg-success');
                    document.getElementById('probabilityStatus').innerHTML =
                        '<i class="fa fa-check-circle text-success"></i> <small class="text-success">Hợp lệ</small>';
                }
            }

            // Cập nhật biểu tượng loại phần thưởng
            function updateRewardType() {
                const selects = document.querySelectorAll('.reward-type');

                selects.forEach(select => {
                    const index = select.getAttribute('data-index');
                    const type = select.value;
                    const symbolElement = document.querySelector(`.reward-symbol-${index}`);
                    const previewBadge = document.querySelector(`.preview-badge-${index}`);

                    if (symbolElement) {
                        symbolElement.textContent = type === 'gem' ? 'Ngọc' : 'Vàng';
                    }

                    if (previewBadge) {
                        if (type === 'gem') {
                            previewBadge.classList.remove('bg-warning');
                            previewBadge.classList.add('bg-info');
                            previewBadge.textContent = 'Ngọc';
                        } else {
                            previewBadge.classList.remove('bg-info');
                            previewBadge.classList.add('bg-warning');
                            previewBadge.textContent = 'Vàng';
                        }
                    }
                });
            }

            // Gắn sự kiện cho các input xác suất
            const probabilityInputs = document.querySelectorAll('.probability-input');
            probabilityInputs.forEach(input => {
                input.addEventListener('input', calculateTotalProbability);
            });

            // Gắn sự kiện cho các select loại phần thưởng
            const typeSelects = document.querySelectorAll('.reward-type');
            typeSelects.forEach(select => {
                select.addEventListener('change', function() {
                    updateRewardType();
                });
            });

            // Khởi tạo ban đầu
            calculateTotalProbability();
            updateRewardType();
        });
    </script>
    <style>
        .ck-editor__editable_inline {
            min-height: 200px;
        }

        .editor-container {
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
        }

        .ck.ck-editor .ck-editor__top .ck-sticky-panel .ck-toolbar {
            border-top-right-radius: 4px;
            border-top-left-radius: 4px;
        }

        .ck.ck-editor .ck-editor__main {
            border-bottom-right-radius: 4px;
            border-bottom-left-radius: 4px;
        }
    </style>
@endpush
