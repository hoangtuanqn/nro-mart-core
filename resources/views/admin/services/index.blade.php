@extends('layouts.admin.app')
@section('title', $title)
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>DANH SÁCH DỊCH VỤ GAME</h4>
                    <h6>Quản lý dịch vụ game của bạn</h6>
                </div>
                <div class="page-btn">
                    <a href="{{ route('admin.services.create') }}" class="btn btn-added">
                        <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img">Thêm dịch vụ mới
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
                                    <th>Tên dịch vụ</th>
                                    <th>Ảnh đại diện</th>
                                    <th>Loại</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($services as $service)
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td>{{ $service->id }}</td>
                                        <td class="text-bolds">{{ $service->name }}</td>
                                        <td>
                                            <img src="{{ $service->thumbnail }}" alt="{{ $service->name }}"
                                                class="img-thumbnail" style="max-width: 200px;">
                                        </td>
                                        <td>
                                            @php
                                                $typeLabels = [
                                                    'gold' => 'Bán vàng',
                                                    'gem' => 'Bán ngọc',
                                                    'leveling' => 'Cày thuê',
                                                ];
                                                $typeClasses = [
                                                    'gold' => 'bg-lightyellow',
                                                    'gem' => 'bg-lightblue',
                                                    'leveling' => 'bg-lightgreen',
                                                ];
                                            @endphp
                                            <span class="badges {{ $typeClasses[$service->type] ?? '' }}">
                                                {{ $typeLabels[$service->type] ?? $service->type }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badges {{ $service->active ? 'bg-lightgreen' : 'bg-lightred' }}">
                                                {{ $service->active ? 'Hoạt động' : 'Đã ẩn' }}
                                            </span>
                                        </td>
                                        <td>{{ $service->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <a class="me-3" href="{{ route('admin.services.edit', $service->id) }}">
                                                <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="img">
                                            </a>
                                            <a class="me-3 confirm-delete" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal" data-id="{{ $service->id }}">
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
        message="Bạn có chắc chắn muốn xóa dịch vụ game này không? Tất cả dữ liệu có liên quan đến nó sẽ
                biến mất khỏi hệ thống!" />
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let serviceId;

            // Lưu ID service khi click nút xóa
            $('.confirm-delete').on('click', function() {
                serviceId = $(this).data('id');
            });

            // Xử lý sự kiện click nút xác nhận xóa
            $('#confirmDelete').on('click', function() {
                $.ajax({
                    url: '/admin/services/delete/' + serviceId,
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
                                    'Đã xóa dịch vụ game thành công',
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
                                    'Có lỗi xảy ra khi xóa dịch vụ game',
                            });
                        }
                    },
                    error: function(xhr) {
                        $('#deleteModal').modal('hide');
                        // Hiển thị thông báo lỗi
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: 'Có lỗi xảy ra khi xóa dịch vụ game',
                        });
                    }
                });
            });
        });
    </script>
@endpush
