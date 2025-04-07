@extends('layouts.admin.app')
@section('title', $title)
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Quản lý vòng quay may mắn</h4>
                    <h6>Xem và quản lý tất cả vòng quay may mắn</h6>
                </div>
                <div class="page-btn">
                    <a href="{{ route('admin.lucky-wheels.create') }}" class="btn btn-added">
                        <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img">
                        Thêm mới
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
                                <div id="DataTables_Table_0_filter" class="dataTables_filter">
                                    <label>
                                        <input type="search" class="form-control form-control-sm"
                                            placeholder="Tìm kiếm...">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="wordset">
                            <ul>
                                <li>
                                    <a href="{{ route('admin.lucky-wheels.history') }}" class="btn btn-info text-light">
                                        <i class="fa fa-history"></i> Xem lịch sử quay
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table datanew">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên vòng quay</th>
                                    <th>Hình ảnh</th>
                                    <th>Giá/Lượt quay</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th class="text-end">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($luckyWheels as $wheel)
                                    <tr>
                                        <td>{{ $wheel->id }}</td>
                                        <td>{{ $wheel->name }}</td>
                                        <td>
                                            <img src="{{ $wheel->thumbnail }}" alt="{{ $wheel->name }}" width="300"
                                                height="300" class="rounded">
                                        </td>
                                        <td>{{ number_format($wheel->price_per_spin) }} VNĐ</td>
                                        <td>
                                            @if ($wheel->active)
                                                <span class="badges bg-lightgreen">Hoạt động</span>
                                            @else
                                                <span class="badges bg-lightred">Không hoạt động</span>
                                            @endif
                                        </td>
                                        <td>{{ $wheel->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="text-end">
                                            <a class="me-3" href="{{ route('admin.lucky-wheels.edit', $wheel->id) }}"
                                                title="Chỉnh sửa">
                                                <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="img">
                                            </a>
                                            <a class="me-3 delete-item" href="javascript:void(0);"
                                                data-id="{{ $wheel->id }}" title="Xóa">
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
        message="Bạn có chắc chắn muốn xóa vòng quay may mắn này không? Tất cả dữ liệu có liên quan đến nó sẽ
                biến mất khỏi hệ thống!" />
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-item');
            let luckyWheelId;

            // Store ID when delete button is clicked
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    luckyWheelId = this.getAttribute('data-id');
                    $('#deleteModal').modal('show');
                });
            });

            // Handle confirm delete button click
            $('#confirmDelete').on('click', function() {
                $.ajax({
                    url: "{{ route('admin.lucky-wheels.destroy', '') }}/" + luckyWheelId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#deleteModal').modal('hide');
                        if (response.status === true) {
                            // Show success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công!',
                                text: response.message,
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
                                text: response.message
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
                                'Có lỗi xảy ra khi xóa vòng quay may mắn'
                        });
                    }
                });
            });
        });
    </script>
@endpush
