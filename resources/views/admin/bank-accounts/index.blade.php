@extends('layouts.admin.app')
@section('title', $title)
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Quản lý tài khoản ngân hàng</h4>
                    <h6>Xem và quản lý các tài khoản ngân hàng</h6>
                </div>
                <div class="page-btn">
                    <a href="{{ route('admin.bank-accounts.create') }}" class="btn btn-added">
                        <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img">
                        Thêm tài khoản mới
                    </a>
                </div>
            </div>


            @if (session('success'))
                <x-alert-admin type="success" :message="session('success')" />
            @endif

            @if (session('error'))
                <x-alert-admin type="danger" :message="session('error')" />
            @endif

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

            <div class="card">
                <div class="card-body">
                    <div class="table-top">
                        <div class="search-set">
                            <div class="search-input">
                                <a class="btn btn-searchset">
                                    <img src="{{ asset('assets/img/icons/search-white.svg') }}" alt="img">
                                </a>
                                <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                    <label>
                                        <input type="search" class="form-control form-control-sm"
                                            placeholder="Tìm kiếm...">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table datanew">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Ngân hàng</th>
                                    <th>Số tài khoản</th>
                                    <th>Chi nhánh</th>
                                    <th>Cú pháp nạp tiền</th>
                                    <th>Access Token</th>
                                    <th>Trạng thái</th>
                                    <th>Tự động xác nhận</th>
                                    <th class="text-end">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bankAccounts as $key => $account)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $account->bank_name }}</td>
                                        <td>{{ $account->account_number }}</td>
                                        <td>{{ $account->branch ?? 'Không có' }}</td>
                                        <td>{{ $account->prefix }}</td>
                                        <td title="{{ $account->access_token }}">
                                            {{ Str::limit($account->access_token, 15, '...') }}
                                        </td>
                                        <td>
                                            @if ($account->is_active)
                                                <span class="badges bg-lightgreen">Hoạt động</span>
                                            @else
                                                <span class="badges bg-lightred">Không hoạt động</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($account->auto_confirm)
                                                <span class="badges bg-lightgreen">Có</span>
                                            @else
                                                <span class="badges bg-lightred">Không</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <a class="me-3" href="{{ route('admin.bank-accounts.edit', $account->id) }}">
                                                <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="img">
                                            </a>
                                            <a class="me-3 confirm-delete" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal" data-id="{{ $account->id }}">
                                                <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="img">
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-modal-confirm-delete
        message=" Bạn có chắc chắn muốn xóa tài khoản ngân hàng này không? Tất cả dữ liệu có liên quan đến nó sẽ
                    biến mất khỏi hệ thống!" />
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            let accountId;

            // Lưu ID tài khoản khi click nút xóa
            $('.confirm-delete').on('click', function() {
                accountId = $(this).data('id');
            });

            // Xử lý sự kiện click nút xác nhận xóa
            $('#confirmDelete').on('click', function() {
                $.ajax({
                    url: '/admin/bank-accounts/delete/' + accountId,
                    type: 'DELETE',
                    dataType: 'json',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#deleteModal').modal('hide');
                        if (response.status) {
                            // Hiển thị thông báo thành công
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công!',
                                text: response.message ||
                                    'Đã xóa tài khoản ngân hàng thành công',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                // Reload trang
                                window.location.reload();
                            });
                        } else {
                            // Hiển thị thông báo lỗi
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: response.message ||
                                    'Có lỗi xảy ra khi xóa tài khoản ngân hàng',
                            });
                        }
                    },
                    error: function(xhr) {
                        $('#deleteModal').modal('hide');
                        // Hiển thị thông báo lỗi
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: 'Có lỗi xảy ra khi xóa tài khoản ngân hàng',
                        });
                    }
                });
            });
        });
    </script>
@endpush
