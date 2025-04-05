@extends('layouts.admin.app')
@section('title', $title)
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Cài đặt Email</h4>
                    <h6>Cấu hình email server và thông báo</h6>
                </div>
            </div>
            <div class="row">
                <!-- Notification -->
                <div class="card-body p-2">
                    <div class="alert alert-notication-custom alert-dismissible fade show" role="alert">
                        <strong>Xem video hướng dẫn cấu hình khi sử dụng gmail.com để gửi mail tại <a
                                href="https://youtu.be/3Daci3bR4pM">ĐÂY</a></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
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

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Cấu hình máy chủ email</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.settings.email.update') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Máy chủ gửi mail (Mailer) <span class="text-danger">*</span></label>
                                            <select name="mail_mailer"
                                                class="select @error('mail_mailer') is-invalid @enderror">
                                                <option value="smtp"
                                                    {{ old('mail_mailer', $configs['mail_mailer']) == 'smtp' ? 'selected' : '' }}>
                                                    SMTP</option>
                                                <option value="sendmail"
                                                    {{ old('mail_mailer', $configs['mail_mailer']) == 'sendmail' ? 'selected' : '' }}>
                                                    Sendmail</option>
                                                <option value="mailgun"
                                                    {{ old('mail_mailer', $configs['mail_mailer']) == 'mailgun' ? 'selected' : '' }}>
                                                    Mailgun</option>
                                                <option value="ses"
                                                    {{ old('mail_mailer', $configs['mail_mailer']) == 'ses' ? 'selected' : '' }}>
                                                    Amazon SES</option>
                                                <option value="postmark"
                                                    {{ old('mail_mailer', $configs['mail_mailer']) == 'postmark' ? 'selected' : '' }}>
                                                    Postmark</option>
                                            </select>
                                            @error('mail_mailer')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Mail Host <span class="text-danger">*</span></label>
                                            <input type="text" name="mail_host"
                                                value="{{ old('mail_host', $configs['mail_host']) }}"
                                                class="form-control @error('mail_host') is-invalid @enderror"
                                                placeholder="smtp.gmail.com">
                                            @error('mail_host')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Mail Port <span class="text-danger">*</span></label>
                                            <input type="text" name="mail_port"
                                                value="{{ old('mail_port', $configs['mail_port']) }}"
                                                class="form-control @error('mail_port') is-invalid @enderror"
                                                placeholder="587">
                                            @error('mail_port')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Mail Encryption <span class="text-danger">*</span></label>
                                            <select name="mail_encryption"
                                                class="select @error('mail_encryption') is-invalid @enderror">
                                                <option value="tls"
                                                    {{ old('mail_encryption', $configs['mail_encryption']) == 'tls' ? 'selected' : '' }}>
                                                    TLS</option>
                                                <option value="ssl"
                                                    {{ old('mail_encryption', $configs['mail_encryption']) == 'ssl' ? 'selected' : '' }}>
                                                    SSL</option>
                                                <option value="null"
                                                    {{ old('mail_encryption', $configs['mail_encryption']) == 'null' ? 'selected' : '' }}>
                                                    None</option>
                                            </select>
                                            @error('mail_encryption')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Mail Username <span class="text-danger">*</span></label>
                                            <input type="text" name="mail_username"
                                                value="{{ old('mail_username', $configs['mail_username']) }}"
                                                class="form-control @error('mail_username') is-invalid @enderror"
                                                placeholder="example@gmail.com">
                                            @error('mail_username')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Mail Password <span class="text-danger">*</span></label>
                                            <div class="pass-group">
                                                <input type="password" name="mail_password"
                                                    value="{{ old('mail_password', $configs['mail_password']) }}"
                                                    class="form-control pass-input @error('mail_password') is-invalid @enderror"
                                                    placeholder="Nhập mật khẩu email">
                                                <span class="fas toggle-password fa-eye-slash"></span>
                                                @error('mail_password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Mail From Address <span class="text-danger">*</span></label>
                                            <input type="text" name="mail_from_address"
                                                value="{{ old('mail_from_address', $configs['mail_from_address']) }}"
                                                class="form-control @error('mail_from_address') is-invalid @enderror"
                                                placeholder="noreply@example.com">
                                            @error('mail_from_address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Mail From Name <span class="text-danger">*</span></label>
                                            <input type="text" name="mail_from_name"
                                                value="{{ old('mail_from_name', $configs['mail_from_name']) }}"
                                                class="form-control @error('mail_from_name') is-invalid @enderror"
                                                placeholder="Shop Game Ngọc Rồng">
                                            @error('mail_from_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
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
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Kiểm tra cấu hình email</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.settings.email.test') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>Địa chỉ email nhận thử nghiệm <span class="text-danger">*</span></label>
                                    <input type="email" name="test_email"
                                        class="form-control @error('test_email') is-invalid @enderror"
                                        placeholder="Nhập email để gửi thử" required>
                                    <small class="form-text text-muted">
                                        Nhập địa chỉ email để nhận thư kiểm tra. Email sẽ được gửi với cấu hình hiện tại.
                                    </small>
                                    @error('test_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane me-1"></i> Gửi email kiểm tra
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="card-title">Mẹo sử dụng Gmail</h5>
                        </div>
                        <div class="card-body">
                            <p>Nếu bạn sử dụng Gmail để gửi email:</p>
                            <ol class="mt-2">
                                <li class="mb-2">Đảm bảo sử dụng các cấu hình sau:
                                    <ul class="mt-1">
                                        <li><strong>Mail Host:</strong> smtp.gmail.com</li>
                                        <li><strong>Mail Port:</strong> 587</li>
                                        <li><strong>Mail Encryption:</strong> tls</li>
                                        <li><strong>Mail Username:</strong> email gmail của bạn</li>
                                        <li><strong>Mail Password:</strong> mật khẩu ứng dụng (không phải mật khẩu Gmail)
                                        </li>
                                    </ul>
                                </li>
                                <li class="mb-2">Bạn cần <a href="https://myaccount.google.com/security"
                                        target="_blank">tạo mật khẩu ứng dụng</a> cho Gmail:
                                    <ul class="mt-1">
                                        <li>Bật xác minh 2 bước trong tài khoản Google</li>
                                        <li>Vào "Bảo mật" > "Đăng nhập vào Google" > "Mật khẩu ứng dụng"</li>
                                        <li>Tạo mật khẩu mới với tên "Laravel Mail"</li>
                                        <li>Sử dụng mật khẩu được tạo làm Mail Password</li>
                                    </ul>
                                </li>

                            </ol>
                            <div class="alert alert-info mt-3">
                                <i class="fas fa-info-circle me-2"></i> Lỗi "Connection could not be established" thường do
                                cấu hình host/port không chính xác hoặc bị chặn bởi tường lửa.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
