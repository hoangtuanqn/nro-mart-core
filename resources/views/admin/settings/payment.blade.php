@extends('layouts.admin.app')
@section('title', $title)
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Cài đặt thanh toán</h4>
                    <h6>Cấu hình các phương thức thanh toán</h6>
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
                    <form action="{{ route('admin.settings.payment.update') }}" method="POST">
                        @csrf

                        <!-- VNPAY -->
                        <div class="section-header">
                            <h5 class="mb-3">VNPay <span class="text-muted">(Thanh toán qua cổng VNPAY)</span></h5>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <div class="status-toggle">
                                        <input type="checkbox" id="vnpay_active" class="check" name="vnpay_active"
                                            value="1"
                                            {{ old('vnpay_active', $configs['vnpay_active']) ? 'checked' : '' }}>
                                        <label for="vnpay_active" class="checktoggle">checkbox</label>
                                    </div>
                                    <label class="mt-2">Kích hoạt VNPAY</label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Terminal ID <span class="text-danger">*</span></label>
                                    <input type="text" name="vnpay_terminal_id"
                                        value="{{ old('vnpay_terminal_id', $configs['vnpay_terminal_id']) }}"
                                        class="form-control @error('vnpay_terminal_id') is-invalid @enderror"
                                        placeholder="Nhập Terminal ID">
                                    @error('vnpay_terminal_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-5 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Secret Key <span class="text-danger">*</span></label>
                                    <input type="text" name="vnpay_secret_key"
                                        value="{{ old('vnpay_secret_key', $configs['vnpay_secret_key']) }}"
                                        class="form-control @error('vnpay_secret_key') is-invalid @enderror"
                                        placeholder="Nhập Secret Key">
                                    @error('vnpay_secret_key')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-3">

                        <!-- MOMO -->
                        <div class="section-header">
                            <h5 class="mb-3">MoMo <span class="text-muted">(Thanh toán qua ví điện tử MoMo)</span></h5>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <div class="status-toggle">
                                        <input type="checkbox" id="momo_active" class="check" name="momo_active"
                                            value="1"
                                            {{ old('momo_active', $configs['momo_active']) ? 'checked' : '' }}>
                                        <label for="momo_active" class="checktoggle">checkbox</label>
                                    </div>
                                    <label class="mt-2">Kích hoạt MoMo</label>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Partner Code <span class="text-danger">*</span></label>
                                    <input type="text" name="momo_partner_code"
                                        value="{{ old('momo_partner_code', $configs['momo_partner_code']) }}"
                                        class="form-control @error('momo_partner_code') is-invalid @enderror"
                                        placeholder="Nhập Partner Code">
                                    @error('momo_partner_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Access Key <span class="text-danger">*</span></label>
                                    <input type="text" name="momo_access_key"
                                        value="{{ old('momo_access_key', $configs['momo_access_key']) }}"
                                        class="form-control @error('momo_access_key') is-invalid @enderror"
                                        placeholder="Nhập Access Key">
                                    @error('momo_access_key')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Secret Key <span class="text-danger">*</span></label>
                                    <input type="text" name="momo_secret_key"
                                        value="{{ old('momo_secret_key', $configs['momo_secret_key']) }}"
                                        class="form-control @error('momo_secret_key') is-invalid @enderror"
                                        placeholder="Nhập Secret Key">
                                    @error('momo_secret_key')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-3">

                        <!-- BANK TRANSFER -->
                        <div class="section-header">
                            <h5 class="mb-3">Chuyển khoản ngân hàng <span class="text-muted">(Thanh toán qua chuyển khoản
                                    ngân hàng)</span></h5>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <div class="status-toggle">
                                        <input type="checkbox" id="bank_transfer_active" class="check"
                                            name="bank_transfer_active" value="1"
                                            {{ old('bank_transfer_active', $configs['bank_transfer_active']) ? 'checked' : '' }}>
                                        <label for="bank_transfer_active" class="checktoggle">checkbox</label>
                                    </div>
                                    <label class="mt-2">Kích hoạt chuyển khoản</label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Tên ngân hàng <span class="text-danger">*</span></label>
                                    <input type="text" name="bank_name"
                                        value="{{ old('bank_name', $configs['bank_name']) }}"
                                        class="form-control @error('bank_name') is-invalid @enderror"
                                        placeholder="Ví dụ: Vietcombank, BIDV...">
                                    @error('bank_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-5 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Số tài khoản <span class="text-danger">*</span></label>
                                    <input type="text" name="bank_account_number"
                                        value="{{ old('bank_account_number', $configs['bank_account_number']) }}"
                                        class="form-control @error('bank_account_number') is-invalid @enderror"
                                        placeholder="Nhập số tài khoản">
                                    @error('bank_account_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Tên chủ tài khoản <span class="text-danger">*</span></label>
                                    <input type="text" name="bank_account_name"
                                        value="{{ old('bank_account_name', $configs['bank_account_name']) }}"
                                        class="form-control @error('bank_account_name') is-invalid @enderror"
                                        placeholder="Nhập tên chủ tài khoản">
                                    @error('bank_account_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Chi nhánh</label>
                                    <input type="text" name="bank_branch"
                                        value="{{ old('bank_branch', $configs['bank_branch']) }}"
                                        class="form-control @error('bank_branch') is-invalid @enderror"
                                        placeholder="Nhập chi nhánh ngân hàng">
                                    @error('bank_branch')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
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
        $(document).ready(function() {
            // Toggle input fields based on payment method status
            function toggleInputFields(checkboxId, containerClass) {
                const isChecked = $('#' + checkboxId).is(':checked');
                $('.' + containerClass + ' input, .' + containerClass + ' select').prop('disabled', !isChecked);
            }

            // Initial state and event handlers
            $('.payment-method-container').each(function() {
                const checkboxId = $(this).data('checkbox');
                const containerClass = $(this).data('container');
                toggleInputFields(checkboxId, containerClass);

                $('#' + checkboxId).on('change', function() {
                    toggleInputFields(checkboxId, containerClass);
                });
            });
        });
    </script>
@endpush
