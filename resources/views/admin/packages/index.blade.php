@extends('layouts.admin.app')
@section('title', $title)
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>DANH SÁCH GÓI DỊCH VỤ</h4>
                    <h6>Quản lý gói dịch vụ của bạn</h6>
                </div>
                <div class="page-btn">
                    @if (isset($serviceId))
                        <a href="{{ route('admin.packages.createForService', $serviceId) }}" class="btn btn-added">
                            <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img">Thêm gói dịch vụ mới
                        </a>
                    @else
                        <a href="{{ route('admin.packages.create') }}" class="btn btn-added">
                            <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img">Thêm gói dịch vụ mới
                        </a>
                    @endif
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
                                    <th>Tên gói</th>
                                    <th>Dịch vụ</th>
                                    <th>Giá</th>
                                    <th>Thời gian ước tính</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($packages as $package)
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td>{{ $package->id }}</td>
                                        <td class="text-bolds">{{ $package->name }}</td>
                                        <td>
                                            <a href="{{ route('admin.services.edit', $package->service->id) }}">
                                                {{ $package->service->name }}
                                            </a>
                                        </td>
                                        <td>{{ number_format($package->price) }} đ</td>
                                        <td>
                                            @if ($package->estimated_time)
                                                {{ $package->estimated_time }} phút
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badges {{ $package->active ? 'bg-lightgreen' : 'bg-lightred' }}">
                                                {{ $package->active ? 'Hoạt động' : 'Đã ẩn' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a class="me-3" href="{{ route('admin.packages.edit', $package->id) }}">
                                                <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="img">
                                            </a>
                                            <a class="me-3 confirm-delete" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal" data-id="{{ $package->id }}">
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
    message="Bạn có chắc chắn muốn xóa gói dịch vụ này không? Tất cả dữ liệu có liên quan đến nó sẽ
                biến mất khỏi hệ thống!" />
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let packageId;
            let currentServiceId = @json($serviceId ?? null);

            // Lưu ID gói dịch vụ khi click nút xóa
            $('.confirm-delete').on('click', function() {
                packageId = $(this).data('id');
            });

            // Xử lý sự kiện click nút xác nhận xóa
            $('#confirmDelete').on('click', function() {
                $.ajax({
                    url: '/admin/packages/delete/' + packageId,
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
                                text: 'Đã xóa gói dịch vụ thành công',
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
                                    'Có lỗi xảy ra khi xóa gói dịch vụ',
                            });
                        }
                    },
                    error: function(xhr) {
                        $('#deleteModal').modal('hide');
                        // Hiển thị thông báo lỗi
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: xhr.responseJSON?.message ||
                                'Có lỗi xảy ra khi xóa gói dịch vụ',
                        });
                    }
                });
            });
        });
    </script>
@endpush
