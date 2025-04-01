@extends('layouts.admin.app')
@section('title', $title)

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Chỉnh sửa tài khoản ngân hàng</h4>
                    <h6>Cập nhật thông tin tài khoản ngân hàng</h6>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.bank-accounts.update', $bankAccount->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Tên ngân hàng <span class="text-danger">*</span></label>
                                    <select name="bank_name" class="form-control @error('bank_name') is-invalid @enderror">
                                        <option value="">-- Chọn ngân hàng --</option>
                                        <option value="Vietcombank"
                                            {{ old('bank_name', $bankAccount->bank_name) == 'Vietcombank' ? 'selected' : '' }}>
                                            Vietcombank</option>
                                        <option value="VietinBank"
                                            {{ old('bank_name', $bankAccount->bank_name) == 'VietinBank' ? 'selected' : '' }}>
                                            VietinBank</option>
                                        <option value="BIDV"
                                            {{ old('bank_name', $bankAccount->bank_name) == 'BIDV' ? 'selected' : '' }}>BIDV
                                        </option>
                                        <option value="Techcombank"
                                            {{ old('bank_name', $bankAccount->bank_name) == 'Techcombank' ? 'selected' : '' }}>
                                            Techcombank</option>
                                        <option value="Sacombank"
                                            {{ old('bank_name', $bankAccount->bank_name) == 'Sacombank' ? 'selected' : '' }}>
                                            Sacombank</option>
                                        <option value="MBBank"
                                            {{ old('bank_name', $bankAccount->bank_name) == 'MBBank' ? 'selected' : '' }}>
                                            MBBank</option>
                                        <option value="ACB"
                                            {{ old('bank_name', $bankAccount->bank_name) == 'ACB' ? 'selected' : '' }}>ACB
                                        </option>
                                        <option value="VPBank"
                                            {{ old('bank_name', $bankAccount->bank_name) == 'VPBank' ? 'selected' : '' }}>
                                            VPBank</option>
                                        <option value="Agribank"
                                            {{ old('bank_name', $bankAccount->bank_name) == 'Agribank' ? 'selected' : '' }}>
                                            Agribank</option>
                                        <option value="TPBank"
                                            {{ old('bank_name', $bankAccount->bank_name) == 'TPBank' ? 'selected' : '' }}>
                                            TPBank</option>
                                        <option value="HDBank"
                                            {{ old('bank_name', $bankAccount->bank_name) == 'HDBank' ? 'selected' : '' }}>
                                            HDBank</option>
                                        <option value="VIB"
                                            {{ old('bank_name', $bankAccount->bank_name) == 'VIB' ? 'selected' : '' }}>VIB
                                        </option>
                                        <option value="MSB"
                                            {{ old('bank_name', $bankAccount->bank_name) == 'MSB' ? 'selected' : '' }}>MSB
                                        </option>
                                        <option value="OCB"
                                            {{ old('bank_name', $bankAccount->bank_name) == 'OCB' ? 'selected' : '' }}>OCB
                                        </option>
                                        <option value="Eximbank"
                                            {{ old('bank_name', $bankAccount->bank_name) == 'Eximbank' ? 'selected' : '' }}>
                                            Eximbank</option>
                                        <option value="SHB"
                                            {{ old('bank_name', $bankAccount->bank_name) == 'SHB' ? 'selected' : '' }}>SHB
                                        </option>
                                        <option value="SeABank"
                                            {{ old('bank_name', $bankAccount->bank_name) == 'SeABank' ? 'selected' : '' }}>
                                            SeABank</option>
                                        <option value="NamABank"
                                            {{ old('bank_name', $bankAccount->bank_name) == 'NamABank' ? 'selected' : '' }}>
                                            NamABank</option>
                                        <option value="KienLongBank"
                                            {{ old('bank_name', $bankAccount->bank_name) == 'KienLongBank' ? 'selected' : '' }}>
                                            KienLongBank</option>
                                        <option value="PGBank"
                                            {{ old('bank_name', $bankAccount->bank_name) == 'PGBank' ? 'selected' : '' }}>
                                            PGBank</option>
                                        <option value="ABBank"
                                            {{ old('bank_name', $bankAccount->bank_name) == 'ABBank' ? 'selected' : '' }}>
                                            ABBank</option>
                                        <option value="LPBank"
                                            {{ old('bank_name', $bankAccount->bank_name) == 'LPBank' ? 'selected' : '' }}>
                                            LPBank</option>
                                        <option value="VietABank"
                                            {{ old('bank_name', $bankAccount->bank_name) == 'VietABank' ? 'selected' : '' }}>
                                            VietABank</option>
                                        <option value="VIETBANK"
                                            {{ old('bank_name', $bankAccount->bank_name) == 'VIETBANK' ? 'selected' : '' }}>
                                            VIETBANK</option>
                                        <option value="BACABANK"
                                            {{ old('bank_name', $bankAccount->bank_name) == 'BACABANK' ? 'selected' : '' }}>
                                            BACABANK</option>
                                        <option value="BVBank"
                                            {{ old('bank_name', $bankAccount->bank_name) == 'BVBank' ? 'selected' : '' }}>
                                            BVBank</option>
                                        <option value="NHQUOCDAN"
                                            {{ old('bank_name', $bankAccount->bank_name) == 'NHQUOCDAN' ? 'selected' : '' }}>
                                            Ngân hàng Quốc Dân</option>
                                        <option value="PBVN"
                                            {{ old('bank_name', $bankAccount->bank_name) == 'PBVN' ? 'selected' : '' }}>
                                            Public Bank Vietnam</option>
                                        <option value="ShinhanBank"
                                            {{ old('bank_name', $bankAccount->bank_name) == 'ShinhanBank' ? 'selected' : '' }}>
                                            Shinhan Bank</option>
                                        <option value="WOORIVN"
                                            {{ old('bank_name', $bankAccount->bank_name) == 'WOORIVN' ? 'selected' : '' }}>
                                            Woori Bank Vietnam</option>
                                    </select>
                                    @error('bank_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Số tài khoản <span class="text-danger">*</span></label>
                                    <input type="text" name="account_number"
                                        value="{{ old('account_number', $bankAccount->account_number) }}"
                                        class="form-control @error('account_number') is-invalid @enderror"
                                        placeholder="Nhập số tài khoản">
                                    @error('account_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Chi nhánh</label>
                                    <input type="text" name="branch" value="{{ old('branch', $bankAccount->branch) }}"
                                        class="form-control" placeholder="Nhập chi nhánh ngân hàng">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Cú pháp nạp tiền <span class="text-danger">*</span></label>
                                    <input type="text" name="prefix" value="{{ old('prefix', $bankAccount->prefix) }}"
                                        class="form-control @error('prefix') is-invalid @enderror"
                                        placeholder="Nhập cú pháp nạp tiền (ví dụ: naptien)">
                                    @error('prefix')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Cú pháp nạp tiền sẽ được dùng để tự động xác định
                                        người dùng trong nội dung chuyển khoản. Ví dụ: naptien123 với 123 là ID người
                                        dùng.</small>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Ghi chú</label>
                                    <textarea class="form-control" name="note" placeholder="Nhập ghi chú (nếu có)">{{ old('note', $bankAccount->note) }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>SePay Access Token</label>
                                    <input type="text" class="form-control @error('access_token') is-invalid @enderror"
                                        name="access_token" placeholder="Nhập Access Token từ SePay.vn"
                                        value="{{ old('access_token', $bankAccount->access_token) }}">
                                    @error('access_token')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Token này được cung cấp bởi SePay.vn để kết nối API
                                        tự động cộng tiền. Cần nhập nếu muốn sử dụng tính năng tự động cộng tiền.</small>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                            {{ old('is_active', $bankAccount->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">Kích hoạt tài khoản</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="auto_confirm"
                                            id="auto_confirm"
                                            {{ old('auto_confirm', $bankAccount->auto_confirm) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="auto_confirm">Tự động xác nhận và cộng
                                            tiền</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">Cập nhật</button>
                                <a href="{{ route('admin.bank-accounts.index') }}" class="btn btn-cancel">Hủy bỏ</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
