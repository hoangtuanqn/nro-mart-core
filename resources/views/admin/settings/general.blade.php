@extends('layouts.admin.app')
@section('title', $title)
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Cài đặt chung</h4>
                    <h6>Quản lý thông tin chung của website</h6>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.settings.general.update') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Tên trang web <span class="text-danger">*</span></label>
                                    <input type="text" name="site_name"
                                        class="form-control @error('site_name') is-invalid @enderror"
                                        value="{{ old('site_name', $configs['site_name']) }}"
                                        placeholder="Nhập tên trang web">
                                    @error('site_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Từ khóa website</label>
                                    <input type="text" name="site_keywords"
                                        class="form-control @error('site_keywords') is-invalid @enderror"
                                        value="{{ old('site_keywords', $configs['site_keywords']) }}"
                                        placeholder="Nhập từ khóa website: shopacc, lienquan, accgame, ...">
                                    @error('site_keywords')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Mô tả trang web</label>
                                    <textarea name="site_description" class="form-control @error('site_description') is-invalid @enderror" rows="3"
                                        placeholder="Nhập mô tả trang web">{{ old('site_description', $configs['site_description']) }}</textarea>
                                    @error('site_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Email liên hệ <span class="text-danger">*</span></label>
                                    <input type="text" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $configs['email']) }}" placeholder="Nhập email liên hệ">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Số điện thoại <span class="text-danger">*</span></label>
                                    <input type="text" name="phone"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        value="{{ old('phone', $configs['phone']) }}" placeholder="Nhập số điện thoại">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Địa chỉ</label>
                                    <input type="text" name="address"
                                        class="form-control @error('address') is-invalid @enderror"
                                        value="{{ old('address', $configs['address']) }}" placeholder="Nhập địa chỉ">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Logo chính trang web</label>
                                    <div class="image-upload">
                                        <input type="file" name="site_logo"
                                            class="form-control @error('site_logo') is-invalid @enderror" accept="image/*"
                                            onchange="previewImage(this, 'preview-logo')">
                                        @error('site_logo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="image-uploads">
                                            <img src="{{ asset('assets/img/icons/upload.svg') }}" alt="img">
                                            <h4>Kéo thả hoặc click để tải logo lên</h4>
                                        </div>
                                    </div>
                                </div>

                                @if (!empty($configs['site_logo']))
                                    <div class="form-group mt-3">
                                        <label>Logo hiện tại:</label>
                                        <div>
                                            <img id="preview-logo" src="{{ $configs['site_logo'] }}" alt="Logo"
                                                class="img-fluid mt-2" style="max-height: 100px;">
                                        </div>
                                    </div>
                                @else
                                    <div class="form-group mt-3">
                                        <img id="preview-logo" src="" alt="Logo Preview" class="img-fluid mt-2"
                                            style="max-height: 100px; display: none;">
                                    </div>
                                @endif
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Logo chân trang</label>
                                    <div class="image-upload">
                                        <input type="file" name="site_logo_footer"
                                            class="form-control @error('site_logo_footer') is-invalid @enderror"
                                            accept="image/jpeg,image/png,image/jpg,image/gif"
                                            onchange="previewImage(this, 'preview-logo-footer')">
                                        @error('site_logo_footer')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="image-uploads">
                                            <img src="{{ asset('assets/img/icons/upload.svg') }}" alt="img">
                                            <h4>Kéo thả hoặc click để tải logo lên</h4>
                                        </div>
                                    </div>
                                </div>

                                @if (!empty($configs['site_logo_footer']))
                                    <div class="form-group mt-3">
                                        <label>Logo chân trang hiện tại:</label>
                                        <div>
                                            <img id="preview-logo-footer" src="{{ $configs['site_logo_footer'] }}"
                                                alt="Logo Footer" class="img-fluid mt-2" style="max-height: 50px;">
                                        </div>
                                    </div>
                                @else
                                    <div class="form-group mt-3">
                                        <img id="preview-logo-footer" src="" alt="Logo Footer Preview"
                                            class="img-fluid mt-2" style="max-height: 50px; display: none;">
                                    </div>
                                @endif
                            </div>


                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Favicon trang web</label>
                                    <div class="image-upload">
                                        <input type="file" name="site_favicon"
                                            class="form-control @error('site_favicon') is-invalid @enderror"
                                            accept="image/jpeg,image/png,image/jpg,image/gif"
                                            onchange="previewImage(this, 'preview-favicon')">
                                        @error('site_favicon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="image-uploads">
                                            <img src="{{ asset('assets/img/icons/upload.svg') }}" alt="img">
                                            <h4>Kéo thả hoặc click để tải favicon lên</h4>
                                        </div>
                                    </div>
                                </div>

                                @if (!empty($configs['site_favicon']))
                                    <div class="form-group mt-3">
                                        <label>Favicon hiện tại:</label>
                                        <div>
                                            <img id="preview-favicon" src="{{ $configs['site_favicon'] }}"
                                                alt="Favicon" class="img-fluid mt-2" style="max-height: 50px;">
                                        </div>
                                    </div>
                                @else
                                    <div class="form-group mt-3">
                                        <img id="preview-favicon" src="" alt="Favicon Preview"
                                            class="img-fluid mt-2" style="max-height: 50px; display: none;">
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Banner trang web</label>
                                    <div class="image-upload">
                                        <input type="file" name="site_banner"
                                            class="form-control @error('site_banner') is-invalid @enderror"
                                            accept="image/jpeg,image/png,image/jpg,image/gif"
                                            onchange="previewImage(this, 'preview-banner')">
                                        @error('site_banner')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="image-uploads">
                                            <img src="{{ asset('assets/img/icons/upload.svg') }}" alt="img">
                                            <h4>Kéo thả hoặc click để tải ảnh banner lên</h4>
                                        </div>
                                    </div>
                                </div>

                                @if (!empty($configs['site_banner']))
                                    <div class="form-group mt-3">
                                        <label>Ảnh banner hiện tại:</label>
                                        <div>
                                            <img id="preview-banner" src="{{ $configs['site_banner'] }}" alt="Banner"
                                                class="img-fluid mt-2" style="max-height: 200px;">
                                        </div>
                                    </div>
                                @else
                                    <div class="form-group mt-3">
                                        <img id="preview-banner" src="" alt="Banner Preview"
                                            class="img-fluid mt-2" style="max-height: 200px; display: none;">
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Ảnh bìa trang web</label>
                                    <div class="image-upload">
                                        <input type="file" name="site_share_image"
                                            class="form-control @error('site_share_image') is-invalid @enderror"
                                            accept="image/jpeg,image/png,image/jpg,image/gif"
                                            onchange="previewImage(this, 'preview-share-image')">
                                        @error('site_share_image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="image-uploads">
                                            <img src="{{ asset('assets/img/icons/upload.svg') }}" alt="img">
                                            <h4>Kéo thả hoặc click để tải ảnh bìa lên</h4>
                                        </div>
                                    </div>
                                </div>

                                @if (!empty($configs['site_share_image']))
                                    <div class="form-group mt-3">
                                        <label>Ảnh bìa hiện tại:</label>
                                        <div>
                                            <img id="preview-share-image" src="{{ $configs['site_share_image'] }}"
                                                alt="Image Share" class="img-fluid mt-2" style="max-height: 200px;">
                                        </div>
                                    </div>
                                @else
                                    <div class="form-group mt-3">
                                        <img id="preview-share-image" src="" alt="Image Share Preview"
                                            class="img-fluid mt-2" style="max-height: 200px; display: none;">
                                    </div>
                                @endif
                            </div>

                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">Lưu thay đổi</button>
                                <a href="{{ route('admin.index') }}" class="btn btn-cancel">Hủy bỏ</a>
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
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#' + previewId).attr('src', e.target.result);
                    $('#' + previewId).css('display', 'block');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
