@extends('layouts.admin.app')
@section('title', $title)

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Thêm tài khoản ngân hàng</h4>
                    <h6>Tạo tài khoản ngân hàng mới</h6>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-notication-custom alert-dismissible fade show" role="alert">

                    <strong>Hệ thống hiện tại đang API qua SePay.</strong> Một doanh nghiệp đang hợp tác với các ngân hàng
                    lớn.
                    <br>Hiện nay họ đang cho <b class="fw-bold text-primary">miễn phí 50 giao dịch mỗi tháng</b> và được
                    quyền <b class="fw-bold text-success">sử dụng tất cả tính năng</b> của họ. Đặc
                    biệt, nếu bạn muốn nhiều giao dịch hơn, vui lòng xem bảng giá chi tiết tại <a
                        href="https://sepay.vn/?utm_source=INV&utm_medium=RFTRA&utm_campaign=1B420439" target="_blank"
                        class="a_link">sepay.vn</a>.

                    <br><b class="fw-bold text-danger">Yêu cầu quý khách đăng ký tài khoản SePay nếu chưa có tại <a
                            href="https://sepay.vn/?utm_source=INV&utm_medium=RFTRA&utm_campaign=1B420439"
                            target="_blank">SePay.VN</a></b>
                    <hr>
                    Nếu bạn muốn tích hợp qua website khác mà không phải
                    SePay, hãy liên hệ với nhà cung cấp qua Zalo <a href="https://zalo.me/0812665001" class="a_link"
                        target="_blank">0812665001</a> hoặc Fanpage <a href="https://www.facebook.com/tuanori.vn"
                        class="a_link" target="_blank">TUAN ORI - Web Designer MMO</a> để nhận được sự hỗ trợ.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <div class="alert alert-notication-custom alert-dismissible fade show" role="alert">
                    <strong>Hướng dẫn lấy Access Token:</strong> Vui lòng xem video hướng dẫn chi tiết tại <a
                        href="https://youtu.be/QgURAxXgE40" target="_blank" class="a_link">đây</a>.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                    <form action="{{ route('admin.bank-accounts.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label>Tên ngân hàng <span class="text-danger">*</span></label>
                                    <select name="bank_name" class="form-control @error('bank_name') is-invalid @enderror">
                                        <option value="">-- Chọn ngân hàng --</option>
                                        <option value="Vietcombank"
                                            {{ old('bank_name') == 'Vietcombank' ? 'selected' : '' }}>Vietcombank</option>
                                        <option value="VietinBank" {{ old('bank_name') == 'VietinBank' ? 'selected' : '' }}>
                                            VietinBank</option>
                                        <option value="BIDV" {{ old('bank_name') == 'BIDV' ? 'selected' : '' }}>BIDV
                                        </option>
                                        <option value="Techcombank"
                                            {{ old('bank_name') == 'Techcombank' ? 'selected' : '' }}>Techcombank</option>
                                        <option value="Sacombank" {{ old('bank_name') == 'Sacombank' ? 'selected' : '' }}>
                                            Sacombank</option>
                                        <option value="MBBank" {{ old('bank_name') == 'MBBank' ? 'selected' : '' }}>MBBank
                                        </option>
                                        <option value="ACB" {{ old('bank_name') == 'ACB' ? 'selected' : '' }}>ACB
                                        </option>
                                        <option value="VPBank" {{ old('bank_name') == 'VPBank' ? 'selected' : '' }}>VPBank
                                        </option>
                                        <option value="Agribank" {{ old('bank_name') == 'Agribank' ? 'selected' : '' }}>
                                            Agribank</option>
                                        <option value="TPBank" {{ old('bank_name') == 'TPBank' ? 'selected' : '' }}>TPBank
                                        </option>
                                        <option value="HDBank" {{ old('bank_name') == 'HDBank' ? 'selected' : '' }}>HDBank
                                        </option>
                                        <option value="VIB" {{ old('bank_name') == 'VIB' ? 'selected' : '' }}>VIB
                                        </option>
                                        <option value="MSB" {{ old('bank_name') == 'MSB' ? 'selected' : '' }}>MSB
                                        </option>
                                        <option value="OCB" {{ old('bank_name') == 'OCB' ? 'selected' : '' }}>OCB
                                        </option>
                                        <option value="Eximbank" {{ old('bank_name') == 'Eximbank' ? 'selected' : '' }}>
                                            Eximbank</option>
                                        <option value="SHB" {{ old('bank_name') == 'SHB' ? 'selected' : '' }}>SHB
                                        </option>
                                        <option value="SeABank" {{ old('bank_name') == 'SeABank' ? 'selected' : '' }}>
                                            SeABank</option>
                                        <option value="NamABank" {{ old('bank_name') == 'NamABank' ? 'selected' : '' }}>
                                            NamABank</option>
                                        <option value="KienLongBank"
                                            {{ old('bank_name') == 'KienLongBank' ? 'selected' : '' }}>KienLongBank
                                        </option>
                                        <option value="PGBank" {{ old('bank_name') == 'PGBank' ? 'selected' : '' }}>PGBank
                                        </option>
                                        <option value="ABBank" {{ old('bank_name') == 'ABBank' ? 'selected' : '' }}>ABBank
                                        </option>
                                        <option value="LPBank" {{ old('bank_name') == 'LPBank' ? 'selected' : '' }}>LPBank
                                        </option>
                                        <option value="VietABank" {{ old('bank_name') == 'VietABank' ? 'selected' : '' }}>
                                            VietABank</option>
                                        <option value="VIETBANK" {{ old('bank_name') == 'VIETBANK' ? 'selected' : '' }}>
                                            VIETBANK</option>
                                        <option value="BACABANK" {{ old('bank_name') == 'BACABANK' ? 'selected' : '' }}>
                                            BACABANK</option>
                                        <option value="BVBank" {{ old('bank_name') == 'BVBank' ? 'selected' : '' }}>BVBank
                                        </option>
                                        <option value="NHQUOCDAN" {{ old('bank_name') == 'NHQUOCDAN' ? 'selected' : '' }}>
                                            Ngân hàng Quốc Dân</option>
                                        <option value="PBVN" {{ old('bank_name') == 'PBVN' ? 'selected' : '' }}>Public
                                            Bank Vietnam</option>
                                        <option value="ShinhanBank"
                                            {{ old('bank_name') == 'ShinhanBank' ? 'selected' : '' }}>Shinhan Bank</option>
                                        <option value="WOORIVN" {{ old('bank_name') == 'WOORIVN' ? 'selected' : '' }}>Woori
                                            Bank Vietnam</option>
                                    </select>

                                    @error('bank_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label>Số tài khoản <span class="text-danger">*</span></label>
                                    <input type="text" name="account_number" value="{{ old('account_number') }}"
                                        class="form-control @error('account_number') is-invalid @enderror"
                                        placeholder="Nhập số tài khoản">
                                    @error('account_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label>Tên tài khoản <span class="text-danger">*</span></label>
                                    <input type="text" name="account_name" value="{{ old('account_name') }}"
                                        class="form-control @error('account_name') is-invalid @enderror"
                                        placeholder="Nhập tên tài khoản">
                                    @error('account_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Chi nhánh</label>
                                    <input type="text" name="branch" value="{{ old('branch') }}"
                                        class="form-control" placeholder="Nhập chi nhánh ngân hàng">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Cú pháp nạp tiền <span class="text-danger">*</span></label>
                                    <input type="text" name="prefix" value="{{ old('prefix', 'naptien') }}"
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
                                    <textarea class="form-control" name="note" placeholder="Nhập ghi chú (nếu có)">{{ old('note') }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>SePay Access Token (<a
                                            href="https://sepay.vn/?utm_source=INV&utm_medium=RFTRA&utm_campaign=1B420439s">Đăng
                                            ký tài khoản</a>)</label>
                                    <input type="text" class="form-control @error('access_token') is-invalid @enderror"
                                        name="access_token" placeholder="Nhập Access Token từ SePay.vn"
                                        value="{{ old('access_token') }}">
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
                                            checked>
                                        <label class="form-check-label" for="is_active">Kích hoạt tài khoản</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="auto_confirm"
                                            id="auto_confirm" checked>
                                        <label class="form-check-label" for="auto_confirm">Tự động xác nhận và cộng
                                            tiền</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">Tạo tài khoản</button>
                                <a href="{{ route('admin.bank-accounts.index') }}" class="btn btn-cancel">Hủy bỏ</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
