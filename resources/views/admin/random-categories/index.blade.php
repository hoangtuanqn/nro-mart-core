@extends('layouts.admin.app')
@section('title', $title)
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Danh sách danh mục random</h4>
                    <h6>Quản lý danh mục tài khoản random</h6>
                </div>
                <div class="page-btn">
                    <a href="{{ route('admin.random-categories.create') }}" class="btn btn-added">
                        <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="plus">
                        <span>Thêm danh mục</span>
                    </a>
                </div>
            </div>
            @if (session('success'))
                <x-alert-admin type="success" :message="session('success')" />
            @endif

            @if (session('error'))
                <x-alert-admin type="danger" :message="session('error')" />
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="table-top">
                        <div class="search-set">
                            <div class="search-input">
                                <a class="btn btn-searchset">
                                    <img src="{{ asset('assets/img/icons/search-white.svg') }}" alt="img">
                                </a>
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
                                    <th class="text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td>{{ $category->id }}</td>
                                        <td class="text-bolds">{{ $category->name }}</td>
                                        <td>
                                            @if ($category->thumbnail)
                                                <img src="{{ asset($category->thumbnail) }}" alt="{{ $category->name }}"
                                                    class="img-thumbnail" style="max-width: 200px;">
                                            @else
                                                (Không có ảnh)
                                            @endif
                                        </td>
                                        <td><span
                                                class="badges {{ $category->active ? 'bg-lightgreen' : 'bg-lightred' }}">{{ $category->active ? 'Hoạt động' : 'Đã ẩn' }}</span>
                                        </td>
                                        <td>{{ $category->created_at->format('d/m/Y') }}</td>
                                        <td class="text-center">
                                            <a class="action-set" href="javascript:void(0);" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="{{ route('admin.random-categories.edit', $category->id) }}"
                                                        class="dropdown-item">
                                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" class="me-2"
                                                            alt="img">
                                                        Sửa danh mục
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item"
                                                        onclick="showDeleteModal({{ $category->id }})">
                                                        <img src="{{ asset('assets/img/icons/delete.svg') }}"
                                                            class="me-2" alt="img">
                                                        Xóa danh mục
                                                    </a>
                                                </li>
                                            </ul>
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
        message="Bạn có chắc chắn muốn xóa danh mục random này không? Tất cả dữ liệu có liên quan đến nó sẽ
                biến mất khỏi hệ thống!" />
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let categoryId;

            // Store ID when delete button is clicked
            function showDeleteModal(id) {
                categoryId = id;
                $('#deleteModal').modal('show');
            }

            // Make showDeleteModal function globally available
            window.showDeleteModal = showDeleteModal;

            // Handle confirm delete button click
            $('#confirmDelete').on('click', function() {
                $.ajax({
                    url: "{{ route('admin.random-categories.destroy', ':id') }}".replace(':id',
                        categoryId),
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#deleteModal').modal('hide');
                        if (response.success) {
                            // Show success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công!',
                                text: 'Đã xóa danh mục random thành công',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                // Reload page
                                window.location.reload();
                            });
                        } else {
                            // Show error message
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: response.message ||
                                    'Có lỗi xảy ra khi xóa danh mục random',
                            });
                        }
                    },
                    error: function(xhr) {
                        $('#deleteModal').modal('hide');
                        // Show error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: xhr.responseJSON?.message ||
                                'Có lỗi xảy ra khi xóa danh mục random',
                        });
                    }
                });
            });
        });
    </script>
@endpush
