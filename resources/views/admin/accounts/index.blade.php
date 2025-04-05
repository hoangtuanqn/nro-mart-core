@extends('layouts.admin.app')
@section('title', 'Quản lý tài khoản game')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>DANH SÁCH TÀI KHOẢN GAME</h4>
                    <h6>Quản lý tài khoản game của bạn</h6>
                </div>
                <div class="page-btn">
                    <a href="{{ route('admin.accounts.create') }}" class="btn btn-added">
                        <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img">Thêm tài khoản mới
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-top">
                        <div class="search-set">
                            <div class="search-input">
                                <a class="btn btn-searchset"><img src="{{ asset('assets/img/icons/search-white.svg') }}"
                                        alt="img"></a>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table datanew">
                            <thead>
                                <tr>
                                    <th>
                                        <label class="checkboxs">
                                            <input type="checkbox" id="select-all">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </th>
                                    <th>ID</th>
                                    <th>Danh mục</th>
                                    <th>Tên tài khoản</th>
                                    <th>Giá tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Máy chủ</th>
                                    <th>Loại đăng ký</th>
                                    <th>Hành tinh</th>
                                    <th>Ảnh đại diện</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($accounts as $key => $account)
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <a
                                                href="{{ route('admin.categories.edit', ['category' => $account->category->id]) }}">{{ $account->category->name }}</a>
                                        </td>
                                        <td class="text-bolds">{{ $account->account_name }}</td>
                                        <td>{{ number_format($account->price) }} VNĐ</td>
                                        <td>
                                            <span
                                                class="badges {{ $account->status === 'available' ? 'bg-lightgreen' : 'bg-lightred' }}">
                                                {{ $account->status === 'available' ? 'Chưa bán' : 'Đã bán' }}
                                            </span>
                                        </td>
                                        <td>Server {{ $account->server }}</td>
                                        <td>{{ $account->registration_type === 'real' ? 'Thật' : 'Ảo' }}</td>
                                        <td>
                                            @php
                                                $planetNames = [
                                                    'earth' => 'Trái Đất',
                                                    'namek' => 'Namek',
                                                    'xayda' => 'Xayda',
                                                ];
                                            @endphp
                                            {{ $planetNames[$account->planet] }}
                                        </td>
                                        <td>
                                            <img src="{{ asset($account->thumb) }}" alt="{{ $account->account_name }}"
                                                class="img-thumbnail" style="max-width: 100px;">
                                        </td>
                                        <td>
                                            <a class="me-3" href="{{ route('admin.accounts.edit', $account->id) }}">
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

    <!-- Modal xác nhận xóa -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xóa tài khoản game này không?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Xóa</button>
                </div>
            </div>
        </div>
    </div>
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
                    url: '/admin/accounts/delete/' + accountId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#deleteModal').modal('hide');
                        if (response.success) {
                            // Hiển thị thông báo thành công
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công!',
                                text: 'Đã xóa tài khoản game thành công',
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
                                    'Có lỗi xảy ra khi xóa tài khoản game',
                            });
                        }
                    },
                    error: function(xhr) {
                        $('#deleteModal').modal('hide');
                        // Hiển thị thông báo lỗi
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: 'Có lỗi xảy ra khi xóa tài khoản game',
                        });
                    }
                });
            });
        });
    </script>
@endpush
