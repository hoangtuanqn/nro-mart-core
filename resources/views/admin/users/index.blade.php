@extends('layouts.admin.app')
@section('title', $title)
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>USERS LIST</h4>
                    <h6>Manage your users</h6>
                </div>
                {{-- <div class="page-btn">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-added">
                        <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img">Add New User
                    </a>
                </div> --}}
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
                                    <th>Tài khoản</th>
                                    <th>Email</th>
                                    <th>Cấp bậc</th>
                                    <th>Số dư</th>
                                    <th>Tổng nạp</th>
                                    <th>Trạng thái</th>
                                    <th>IP</th>
                                    <th>Ngày tạo</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td>{{ $user->id }}</td>
                                        <td class="text-bolds">{{ $user->username }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td><span
                                                class="badges {{ $user->role == 'admin' ? 'bg-lightred' : 'bg-lightgreen' }}">{{ $user->role }}</span>
                                        </td>
                                        <td>{{ number_format($user->balance) }}đ</td>
                                        <td>{{ number_format($user->total_deposited) }}đ</td>
                                        <td><span
                                                class="badges {{ $user->banned ? 'bg-lightred' : 'bg-lightgreen' }}">{{ $user->banned ? 'Banned' : 'Active' }}</span>
                                        </td>
                                        <td>{{ $user->ip_address }}</td>
                                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <a class="me-3" href="{{ route('admin.users.show', $user->id) }}">
                                                <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="img">
                                            </a>
                                            <a class="me-3 confirm-delete" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal" data-id="{{ $user->id }}">
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
        message="Bạn có chắc chắn muốn xóa người dùng này không? Tất cả dữ liệu có liên quan đến nó sẽ
            biến mất khỏi hệ thống!" />


@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            let userId;

            // Lưu ID user khi click nút xóa
            $('.confirm-delete').on('click', function() {
                userId = $(this).data('id');
            });

            // Xử lý sự kiện click nút xác nhận xóa
            $('#confirmDelete').on('click', function() {
                $.ajax({
                    url: '/admin/users/delete/' + userId,
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
                                text: 'Đã xóa người dùng thành công',
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
                                    'Có lỗi xảy ra khi xóa người dùng',
                            });
                        }
                    },
                    error: function(xhr) {
                        $('#deleteModal').modal('hide');
                        // Hiển thị thông báo lỗi
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: 'Có lỗi xảy ra khi xóa người dùng',
                        });
                    }
                });
            });
        });
    </script>
@endpush
