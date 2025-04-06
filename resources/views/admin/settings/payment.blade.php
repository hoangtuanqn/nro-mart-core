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
            <!-- Notication -->
            <div class="card-body">
                <div class="alert alert-notication-custom alert-dismissible fade show" role="alert">
                    <strong>Chúng tôi hiện đang hỗ trợ 3 đối tác thanh toán:</strong>
                    <a href="https://thesieure.com" target="_blank">THESIEURE.COM</a>,
                    <a href="https://doithe1s.vn" target="_blank">DOITHE1S.VN</a>,
                    <a href="https://cardvip.vn" target="_blank">CARDVIP.VN</a>.
                    Nếu bạn có nhu cầu chọn đối tác khác, xin vui lòng liên hệ với chúng tôi (phí dịch vụ là
                    100K).
                    <br>
                    Địa chỉ nhận Callback theo phương thức GET hoặc POST đều được:
                    <b><strong>{{ url(route('callback.card', [], '')) }}</strong></b>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                                    <label>Website đối tác <span class="text-danger">*</span></label>
                                    <select name="partner_website_card"
                                        class="select @error('partner_website_card') is-invalid @enderror">
                                        <option value="">Chọn đối tác</option>
                                        <option value="thesieure.com"
                                            {{ $configs['partner_website_card'] === 'thesieure.com' ? 'selected' : '' }}>
                                            THESIEURE.COM</option>
                                        <option value="cardvip.vn"
                                            {{ $configs['partner_website_card'] === 'cardvip.vn' ? 'selected' : '' }}>
                                            CARDVIP.VN</option>
                                        <option value="doithe1s.vn"
                                            {{ $configs['partner_website_card'] === 'doithe1s.vn' ? 'selected' : '' }}>
                                            DOITHE1S.VN</option>
                                    </select>
                                    @error('partner_website_card')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Chiết khấu nạp thẻ <span class="text-danger">*</span></label>
                                    <input type="text" name="discount_percent_card"
                                        value="{{ old('discount_percent_card', $configs['discount_percent_card']) }}"
                                        class="form-control @error('discount_percent_card') is-invalid @enderror"
                                        placeholder="Nhập chiết khấu nạp thẻ">
                                    @error('discount_percent_card')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
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
