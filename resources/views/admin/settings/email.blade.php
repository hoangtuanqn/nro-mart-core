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

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.settings.email.update') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Máy chủ gửi mail (Mailer) <span class="text-danger">*</span></label>
                                    <select name="mail_mailer" class="select @error('mail_mailer') is-invalid @enderror">
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
                                        class="form-control @error('mail_port') is-invalid @enderror" placeholder="587">
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
    </div>
@endsection
