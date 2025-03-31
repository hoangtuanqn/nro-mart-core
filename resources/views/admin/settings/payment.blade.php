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

                        <!-- CÀI ĐẶT THẺ CÀO -->
                        <div class="section-header">
                            <h5 class="mb-3">Cài đặt nạp thẻ <span class="text-muted">(Thanh toán qua thẻ cào)</span></h5>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <div class="status-toggle">
                                        <input type="checkbox" id="card_active" class="check" name="card_active"
                                            value="1"
                                            {{ old('card_active', $configs['card_active']) ? 'checked' : '' }}>
                                        <label for="card_active" class="checktoggle"></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Partner ID <span class="text-danger">*</span></label>
                                    <input type="text" name="partner_id_card"
                                        value="{{ old('partner_id_card', $configs['partner_id_card']) }}"
                                        class="form-control @error('partner_id_card') is-invalid @enderror"
                                        placeholder="Nhập Partner ID">
                                    @error('partner_id_card')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Partner Key <span class="text-danger">*</span></label>
                                    <input type="text" name="partner_key_card"
                                        value="{{ old('partner_key_card', $configs['partner_key_card']) }}"
                                        class="form-control @error('partner_key_card') is-invalid @enderror"
                                        placeholder="Nhập Partner Key">
                                    @error('partner_key_card')
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
