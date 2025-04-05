@extends('layouts.admin.app')
@section('title', $title)
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>{{ isset($notification) ? 'Chỉnh sửa thông báo' : 'Thêm thông báo mới' }}</h4>
                    <h6>{{ isset($notification) ? 'Cập nhật thông tin thông báo' : 'Tạo thông báo mới hiển thị trên trang chủ' }}
                    </h6>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <form
                        action="{{ isset($notification) ? route('admin.settings.notifications.update', $notification->id) : route('admin.settings.notifications.store') }}"
                        method="POST">
                        @csrf
                        @if (isset($notification))
                            @method('PUT')
                        @endif
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Biểu tượng <span class="text-danger">*</span></label>
                                    <input type="text" name="class_favicon"
                                        class="form-control @error('class_favicon') is-invalid @enderror" id="icon-selector"
                                        value="{{ old('class_favicon', $notification->class_favicon ?? '') }}"
                                        placeholder="Nhập class biểu tượng, ví dụ: fa-user-circle">
                                    @error('class_favicon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Nhập class của biểu tượng FontAwesome.
                                        <a href="https://fontawesome.com/v5/search?m=free" target="_blank">
                                            Xem danh sách biểu tượng tại đây
                                        </a>.
                                        <strong>Lưu ý:</strong> Chỉ nhập phần class (ví dụ: fa-shield-alt), không cần nhập
                                        "fas" hoặc "fa".
                                    </small>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Xem trước biểu tượng</label>
                                    <div class="icon-preview"
                                        style="padding: 20px; border: 1px solid #eee; border-radius: 5px; text-align: center; background-color: #f9f9f9;">
                                        <i id="icon-preview"
                                            class="fas {{ old('class_favicon', $notification->class_favicon ?? '') }}"
                                            style="font-size: 3rem; color: #5757f7;"></i>
                                        <div style="margin-top: 10px;">
                                            <code
                                                id="icon-class-display">{{ old('class_favicon', $notification->class_favicon ?? '') }}</code>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Nội dung thông báo <span class="text-danger">*</span></label>
                                    <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="3"
                                        placeholder="Nhập nội dung thông báo">{{ old('content', $notification->content ?? '') }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Nội dung thông báo hiển thị trên modal chào mừng
                                        trang chủ</small>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">
                                    {{ isset($notification) ? 'Cập nhật' : 'Thêm thông báo' }}
                                </button>
                                <a href="{{ route('admin.settings.notifications') }}" class="btn btn-cancel">Hủy bỏ</a>
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
            // Cập nhật xem trước biểu tượng khi nhập
            $('#icon-selector').on('input', function() {
                let iconClass = $(this).val();
                // Đảm bảo iconClass bắt đầu với "fa-"
                if (iconClass && !iconClass.startsWith('fa-')) {
                    iconClass = 'fa-' + iconClass;
                }
                $('#icon-preview').attr('class', 'fas ' + iconClass);
                $('#icon-class-display').text(iconClass);
            });

            // Hiển thị trước khi load trang
            let initialIcon = $('#icon-selector').val();
            if (initialIcon) {
                $('#icon-preview').attr('class', 'fas ' + initialIcon);
                $('#icon-class-display').text(initialIcon);
            }
        });
    </script>
@endpush
