@extends('layouts.admin.app')
@section('title', $title)
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Danh sách mã giảm giá</h4>
                    <h6>Quản lý mã giảm giá cho tài khoản và dịch vụ</h6>
                </div>
                <div class="page-btn">
                    <a href="{{ route('admin.discount-codes.create') }}" class="btn btn-added">
                        <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="plus">
                        <span>Thêm mã giảm giá</span>
                    </a>
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
                                    <th>Mã giảm giá</th>
                                    <th>Kiểu</th>
                                    <th>Giá trị</th>
                                    <th>Lượt sử dụng còn lại</th>
                                    <th>Hết hạn</th>
                                    <th>Trạng thái</th>
                                    <th class="text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($discountCodes as $key => $discountCode)
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td>{{ $key + 1 }}</td>
                                        <td class="text-bolds">{{ $discountCode->code }}</td>
                                        <td>{{ $discountCode->discount_type === 'percentage' ? 'Phần trăm' : 'Số tiền cố định' }}
                                        </td>
                                        <td>
                                            @if ($discountCode->discount_type === 'percentage')
                                                {{ $discountCode->discount_value }}%
                                            @else
                                                {{ number_format($discountCode->discount_value) }}đ
                                            @endif
                                        </td>
                                        <td>{{ $discountCode->usage_limit }}</td>
                                        <td>{{ $discountCode->expire_date ? date('d/m/Y', strtotime($discountCode->expire_date)) : 'Không hết hạn' }}
                                        </td>
                                        <td>
                                            <span
                                                class="badges {{ $discountCode->status === 'active' ? 'bg-lightgreen' : 'bg-lightred' }}">
                                                {{ $discountCode->status === 'active' ? 'Hoạt động' : 'Không hoạt động' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a class="action-set" href="javascript:void(0);" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="{{ route('admin.discount-codes.edit', $discountCode->id) }}"
                                                        class="dropdown-item">
                                                        <img src="{{ asset('assets/img/icons/edit.svg') }}" class="me-2"
                                                            alt="img">
                                                        Sửa mã
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item"
                                                        onclick="showDeleteModal({{ $discountCode->id }})">
                                                        <img src="{{ asset('assets/img/icons/delete.svg') }}"
                                                            class="me-2" alt="img">
                                                        Xóa mã
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

    <!-- Modal xác nhận xóa -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xóa mã giảm giá này không? Tất cả dữ liệu có liên quan đến mã giảm giá này sẽ
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
            let discountCodeId;

            // Store ID when delete button is clicked
            function showDeleteModal(id) {
                discountCodeId = id;
                $('#deleteModal').modal('show');
            }

            // Make showDeleteModal function globally available
            window.showDeleteModal = showDeleteModal;

            // Handle confirm delete button click
            $('#confirmDelete').on('click', function() {
                $.ajax({
                    url: "{{ route('admin.discount-codes.destroy', ':id') }}".replace(':id',
                        discountCodeId),
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
                                text: 'Đã xóa mã giảm giá thành công',
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
                                    'Có lỗi xảy ra khi xóa mã giảm giá',
                            });
                        }
                    },
                    error: function(xhr) {
                        $('#deleteModal').modal('hide');
                        // Show error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: 'Có lỗi xảy ra khi xóa mã giảm giá',
                        });
                    }
                });
            });
        });
    </script>
@endpush
