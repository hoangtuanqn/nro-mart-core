@extends('layouts.admin.app')

@section('title', 'Cấu hình đăng nhập')

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Cấu hình đăng nhập</h4>
                    <h6>Quản lý các cấu hình phương thức đăng nhập</h6>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-notication-custom alert-dismissible fade show" role="alert">
                    <p class="text-noticate">Tính năng tự động đăng nhập nhanh qua Facebook và Google. Quý khách hàng vui
                        lòng cài đặt đúng thông
                        tin để có thể sử dụng. Xin cảm ơn quý khách.</p>
                    <p class="text-noticate">Nếu có lỗi xảy ra hoặc quý khách hàng không biết cài đặt. Xin vui lòng liên hệ
                        đến nhà phát triển để
                        được hỗ trợ cài đặt (phí cài đặt 80k)</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
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


                    <form method="POST" action="{{ route('admin.settings.login.update') }}">
                        @csrf

                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title">Google Login</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="google_client_id">Client ID</label>
                                            <input id="google_client_id" name="google_client_id" type="text"
                                                class="form-control @error('google_client_id') is-invalid @enderror"
                                                value="{{ old('google_client_id', $configs['google_client_id']) }}">
                                            @error('google_client_id')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="google_client_secret">Client Secret</label>
                                            <input id="google_client_secret" name="google_client_secret" type="text"
                                                class="form-control @error('google_client_secret') is-invalid @enderror"
                                                value="{{ old('google_client_secret', $configs['google_client_secret']) }}">
                                            @error('google_client_secret')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="google_redirect">Redirect URL</label>
                                            <input id="google_redirect" name="google_redirect" type="text"
                                                class="form-control @error('google_redirect') is-invalid @enderror"
                                                value="{{ old('google_redirect', $configs['google_redirect']) }}">
                                            @error('google_redirect')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <p class="mb-2">Kích hoạt</p>
                                            <div class="status-toggle">
                                                <input type="checkbox" id="google_active" class="check"
                                                    name="google_active"
                                                    {{ old('google_active', $configs['google_active']) ? 'checked' : '' }}>
                                                <label for="google_active" class="checktoggle"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-top pt-3 mt-3">
                                    <div class="form-group">
                                        <label class="text-secondary">Hướng dẫn cấu hình</label>
                                        <ol class="text-secondary">
                                            <li>Truy cập <a href="https://console.cloud.google.com/apis/credentials"
                                                    target="_blank">Google Cloud Console</a></li>
                                            <li>Tạo dự án mới hoặc chọn dự án hiện có</li>
                                            <li>Tạo OAuth consent screen</li>
                                            <li>Tạo OAuth Client ID cho Web application</li>
                                            <li>Thêm Redirect URL: <code>{{ url(route('callback.google')) }}</code></li>
                                            <li>Sao chép Client ID và Client Secret vào form này</li>
                                        </ol>
                                        <hr>
                                        <label class="text-secondary">Hoặc xem hướng dẫn: <a href="//"
                                                target="_blank">Cách
                                                cấu hình đăng nhập Google</a></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title">Facebook Login</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="facebook_client_id">App ID</label>  
                                            <input id="facebook_client_id" name="facebook_client_id" type="text"
                                                class="form-control @error('facebook_client_id') is-invalid @enderror"
                                                value="{{ old('facebook_client_id', $configs['facebook_client_id']) }}">
                                            @error('facebook_client_id')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="facebook_client_secret">App Secret</label>
                                            <input id="facebook_client_secret" name="facebook_client_secret" type="text"
                                                class="form-control @error('facebook_client_secret') is-invalid @enderror"
                                                value="{{ old('facebook_client_secret', $configs['facebook_client_secret']) }}">
                                            @error('facebook_client_secret')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="facebook_redirect">Redirect URL</label>
                                            <input id="facebook_redirect" name="facebook_redirect" type="text"
                                                class="form-control @error('facebook_redirect') is-invalid @enderror"
                                                value="{{ old('facebook_redirect', $configs['facebook_redirect']) }}">
                                            @error('facebook_redirect')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <p class="mb-2">Kích hoạt</p>
                                            <div class="status-toggle">
                                                <input type="checkbox" id="facebook_active" class="check"
                                                    name="facebook_active"
                                                    {{ old('facebook_active', $configs['facebook_active']) ? 'checked' : '' }}>
                                                <label for="facebook_active" class="checktoggle"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-top pt-3 mt-3">
                                    <div class="form-group">
                                        <label class="text-secondary">Hướng dẫn cấu hình</label>
                                        <ol class="text-secondary">
                                            <li>Truy cập <a href="https://developers.facebook.com/apps"
                                                    target="_blank">Facebook Developers</a></li>
                                            <li>Tạo ứng dụng mới hoặc chọn ứng dụng hiện có</li>
                                            <li>Thêm sản phẩm Facebook Login</li>
                                            <li>Cấu hình OAuth redirect URI:
                                                <code>{{ url(route('callback.facebook')) }}</code>
                                            </li>
                                            <li>Sao chép App ID và App Secret vào form này</li>
                                        </ol>
                                        <hr>
                                        <label class="text-secondary">Hoặc xem hướng dẫn: <a href="//"
                                                target="_blank">Cách
                                                cấu hình đăng nhập Facebook</a></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-submit me-2">Cập nhật cấu hình</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
