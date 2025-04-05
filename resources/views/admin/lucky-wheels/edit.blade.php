@extends('layouts.admin.app')
@section('title', $title)
@push('css')
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

        /* Responsive styles for mobile */
        @media (max-width: 767.98px) {

            .config-table th,
            .config-table td {
                padding: 0.5rem 0.25rem;
                font-size: 0.85rem;
            }

            .config-table input,
            .config-table select {
                font-size: 0.85rem;
                padding: 0.25rem 0.5rem;
                width: 100%;
            }

            .config-table .input-group-text {
                padding: 0.25rem 0.5rem;
                font-size: 0.85rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Chỉnh sửa vòng quay may mắn</h4>
                    <h6>Cập nhật thông tin vòng quay may mắn</h6>
                </div>
                <div class="page-btn">
                    <a href="{{ route('admin.lucky-wheels.index') }}" class="btn btn-added">
                        <i class="fa fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Lỗi!</strong> Đã xảy ra lỗi khi cập nhật vòng quay may mắn. Vui lòng kiểm tra lại thông tin.
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
                    <form action="{{ route('admin.lucky-wheels.update', $luckyWheel->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-8 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="name">Tên vòng quay <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $luckyWheel->name) }}" required
                                        placeholder="Nhập tên vòng quay" autocomplete="off">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="price_per_spin">Giá mỗi lượt quay (VNĐ) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('price_per_spin') is-invalid @enderror"
                                        id="price_per_spin" name="price_per_spin"
                                        value="{{ old('price_per_spin', $luckyWheel->price_per_spin) }}" required
                                        placeholder="Nhập giá mỗi lượt quay" min="0" step="1000">
                                    @error('price_per_spin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="thumbnail">Ảnh đại diện</label>
                                    <input type="file" class="form-control @error('thumbnail') is-invalid @enderror"
                                        id="thumbnail" name="thumbnail" accept="image/*">
                                    <small class="form-text text-muted">Để trống nếu không muốn thay đổi ảnh</small>
                                    <input type="hidden" name="current_thumbnail" value="{{ $luckyWheel->thumbnail }}">
                                    @error('thumbnail')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="wheel_image">Ảnh vòng quay</label>
                                    <input type="file" class="form-control @error('wheel_image') is-invalid @enderror"
                                        id="wheel_image" name="wheel_image" accept="image/*">
                                    <small class="form-text text-muted">Để trống nếu không muốn thay đổi ảnh</small>
                                    <input type="hidden" name="current_wheel_image" value="{{ $luckyWheel->wheel_image }}">
                                    @error('wheel_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12 text-center mt-3 mb-3">
                                <div class="d-flex flex-wrap justify-content-center gap-3">
                                    <div class="mb-3">
                                        <p class="mb-2">Ảnh đại diện:</p>
                                        <img id="preview-thumbnail" src="{{ $luckyWheel->thumbnail }}"
                                            alt="Thumbnail Preview" class="img-fluid rounded"
                                            style="max-width: 200px; max-height: 150px;">
                                    </div>
                                    <div class="mb-3">
                                        <p class="mb-2">Ảnh vòng quay:</p>
                                        <img id="preview-wheel" src="{{ $luckyWheel->wheel_image }}" alt="Wheel Preview"
                                            class="img-fluid rounded" style="max-width: 200px; max-height: 150px;">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="description">Mô tả vòng quay</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description', $luckyWheel->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12 mt-3">
                                <div class="form-group">
                                    <label for="rules">Thể lệ vòng quay <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('rules') is-invalid @enderror" id="rules" name="rules" required>{{ old('rules', $luckyWheel->rules) }}</textarea>
                                    @error('rules')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="active">Trạng thái</label>
                                    <select name="active" id="active"
                                        class="form-select @error('active') is-invalid @enderror">
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
                                        <p class="card-text">Tổng xác suất các ô phải bằng đúng 100%</p>
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
                                            <table class="table table-striped table-bordered config-table"
                                                id="configTable">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th class="text-center" style="width: 5%">STT</th>
                                                        <th class="text-center" style="width: 10%">Loại</th>
                                                        <th class="text-center">Nội dung</th>
                                                        <th class="text-center">Số lượng</th>
                                                        <th class="text-center" style="width: 12%">Xác suất</th>
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
                                                                        class="form-select form-select-sm reward-type"
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
                                                                        class="form-control form-control-sm content-input"
                                                                        data-index="{{ $i }}" required
                                                                        placeholder="Nội dung phần thưởng">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="input-group input-group-sm">
                                                                    <input type="number"
                                                                        name="config[{{ $i }}][amount]"
                                                                        value="{{ isset($oldConfig[$i]) ? $oldConfig[$i]['amount'] : 0 }}"
                                                                        class="form-control form-control-sm amount-input"
                                                                        data-index="{{ $i }}" min="0"
                                                                        required>
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
                                                                        class="form-control form-control-sm probability-input"
                                                                        min="0" max="100" step="0.1"
                                                                        required>
                                                                    <span class="input-group-text">%</span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endfor
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="3" class="text-end fw-bold">Tổng xác suất:</td>
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
                            <div class="col-lg-12">
                                <div class="form-group mb-0 text-end">
                                    <a href="{{ route('admin.lucky-wheels.index') }}" class="btn btn-secondary">Hủy</a>
                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
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
                        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                            'outdent', 'indent', '|', 'blockQuote', 'insertTable', 'undo', 'redo'
                        ]
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
                        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                            'outdent', 'indent', '|', 'blockQuote', 'insertTable', 'undo', 'redo'
                        ]
                    })
                    .then(editor => {
                        rulesEditor = editor;
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }

            // Xử lý xem trước hình ảnh
            function previewImage(input, previewId) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById(previewId).src = e.target.result;
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            // Bắt sự kiện thay đổi ảnh đại diện
            document.getElementById('thumbnail').addEventListener('change', function() {
                previewImage(this, 'preview-thumbnail');
            });

            // Bắt sự kiện thay đổi ảnh vòng quay
            document.getElementById('wheel_image').addEventListener('change', function() {
                previewImage(this, 'preview-wheel');
            });

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

            // Xử lý tính tổng xác suất
            const probabilityInputs = document.querySelectorAll('.probability-input');
            const totalProbabilityElement = document.getElementById('totalProbability');
            const probabilityProgressBar = document.getElementById('probabilityProgressBar');
            const probabilityStatus = document.getElementById('probabilityStatus');

            function calculateTotalProbability() {
                let total = 0;
                probabilityInputs.forEach(input => {
                    total += parseFloat(input.value) || 0;
                });

                totalProbabilityElement.textContent = total.toFixed(1);
                probabilityProgressBar.style.width = `${total}%`;
                probabilityProgressBar.setAttribute('aria-valuenow', total);
                probabilityProgressBar.textContent = `${total.toFixed(1)}%`;

                if (total < 100) {
                    probabilityProgressBar.classList.remove('bg-success', 'bg-danger');
                    probabilityProgressBar.classList.add('bg-warning');
                    probabilityStatus.textContent = 'Chưa đủ 100%';
                    probabilityStatus.className = 'ms-2 text-warning';
                } else if (total > 100) {
                    probabilityProgressBar.classList.remove('bg-success', 'bg-warning');
                    probabilityProgressBar.classList.add('bg-danger');
                    probabilityStatus.textContent = 'Vượt quá 100%';
                    probabilityStatus.className = 'ms-2 text-danger';
                } else {
                    probabilityProgressBar.classList.remove('bg-warning', 'bg-danger');
                    probabilityProgressBar.classList.add('bg-success');
                    probabilityStatus.textContent = 'Đúng 100%';
                    probabilityStatus.className = 'ms-2 text-success';
                }
            }

            probabilityInputs.forEach(input => {
                input.addEventListener('input', calculateTotalProbability);
            });

            // Tính tổng xác suất khi trang tải xong
            calculateTotalProbability();

            // Xử lý form submit - cần đảm bảo dữ liệu từ CKEditor được cập nhật trước khi submit
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                // Cập nhật dữ liệu từ CKEditor vào textarea trước khi submit
                if (descriptionEditor) {
                    const descriptionInput = document.querySelector('#description');
                    descriptionInput.value = descriptionEditor.getData();
                }

                if (rulesEditor) {
                    const rulesInput = document.querySelector('#rules');
                    rulesInput.value = rulesEditor.getData();
                }

                // Không cần ngăn chặn form submit - để form tự submit bình thường
            });
        });
    </script>
@endpush
