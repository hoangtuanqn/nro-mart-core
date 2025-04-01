@extends('layouts.admin.app')
@section('title', 'Quản lý danh mục game')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>DANH SÁCH DANH MỤC GAME</h4>
                    <h6>Quản lý danh mục game của bạn</h6>
                </div>
                <div class="page-btn">
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-added">
                        <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img">Thêm danh mục mới
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
                                    <th>Tên danh mục</th>
                                    <th>Ảnh đại diện</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $key => $category)
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td>{{ $key + 1 }}</td>
                                        <td class="text-bolds">{{ $category->name }}</td>
                                        <td>
                                            <img src="{{ asset($category->thumbnail) }}" alt="{{ $category->name }}"
                                                class="img-thumbnail" style="max-width: 200px;">
                                        </td>
                                        <td><span
                                                class="badges {{ $category->active ? 'bg-lightgreen' : 'bg-lightred' }}">{{ $category->active ? 'Hoạt động' : 'Đã ẩn' }}</span>
                                        </td>
                                        <td>{{ $category->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <a class="me-3" href="{{ route('admin.categories.edit', $category->id) }}">
                                                <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="img">
                                            </a>
                                            <a class="me-3 confirm-text" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal" data-id="{{ $category->id }}">
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
                    Bạn có chắc chắn muốn xóa danh mục game này không? Tất cả dữ liệu có liên quan đến danh mục này sẽ
                    biến mất khỏi hệ thống!
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
            let userId;

            // Lưu ID user khi click nút xóa
            $('.confirm-text').on('click', function() {
                userId = $(this).data('id');
            });

            // Xử lý sự kiện click nút xác nhận xóa
            $('#confirmDelete').on('click', function() {
                $.ajax({
                    url: '/admin/categories/delete/' + userId,
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
                                text: 'Đã xóa danh mục game thành công',
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
                                    'Có lỗi xảy ra khi xóa danh mục game',
                            });
                        }
                    },
                    error: function(xhr) {
                        $('#deleteModal').modal('hide');
                        // Hiển thị thông báo lỗi
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: 'Có lỗi xảy ra khi xóa danh mục game',
                        });
                    }
                });
            });
        });
    </script>
@endpush
