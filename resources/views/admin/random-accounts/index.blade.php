@extends('layouts.admin.app')
@section('title', $title)
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Danh sách tài khoản random</h4>
                    <h6>Quản lý tài khoản random</h6>
                </div>
                <div class="page-btn">
                    <a href="{{ route('admin.random-accounts.create') }}" class="btn btn-added">
                        <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="plus">
                        <span>Thêm tài khoản</span>
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
                                    <th>Danh mục</th>
                                    <th>Máy chủ</th>
                                    <th>Giá</th>
                                    <th>Trạng thái</th>
                                    <th>Người mua</th>
                                    <th>Ngày tạo</th>
                                    <th class="text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($accounts as $account)
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td>{{ $account->id }}</td>
                                        <td>
                                            <a href="{{ route('admin.random-categories.edit', ['category' => $account->category->id]) }}"
                                                target="_blank">
                                                {{ $account->category->name }}
                                            </a>
                                        </td>

                                        </td>
                                        <td>{{ $account->server }}</td>
                                        <td>{{ number_format($account->price) }}</td>
                                        <td><span
                                                class="badges {{ $account->status === 'available' ? 'bg-lightgreen' : 'bg-lightred' }}">{{ $account->status === 'available' ? 'Chưa bán' : 'Đã bán' }}</span>
                                        </td>
                                        <td>{{ $account->buyer ? $account->buyer->name : 'Chưa có' }}</td>
                                        <td>{{ $account->created_at->format('d/m/Y') }}</td>
                                        <td class="text-center">
                                            <a class="me-3"
                                                href="{{ route('admin.random-accounts.edit', $account->id) }}">
                                                <img src="{{ asset('assets/img/icons/edit.svg') }}" alt="img">
                                            </a>
                                            <a class="me-3 confirm-delete" href="javascript:void(0);"
                                                onclick="showDeleteModal({{ $account->id }})">
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
        message="Bạn có chắc chắn muốn xóa tài khoản random này không? Tất cả dữ liệu có liên quan đến nó sẽ
                biến mất khỏi hệ thống!" />
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let accountId;

            // Store ID when delete button is clicked
            function showDeleteModal(id) {
                accountId = id;
                $('#deleteModal').modal('show');
            }

            // Make showDeleteModal function globally available
            window.showDeleteModal = showDeleteModal;

            // Handle confirm delete button click
            $('#confirmDelete').on('click', function() {
                $.ajax({
                    url: "{{ route('admin.random-accounts.destroy', ':id') }}".replace(':id',
                        accountId),
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
                                text: 'Đã xóa tài khoản random thành công',
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
                                    'Có lỗi xảy ra khi xóa tài khoản random',
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
                                'Có lỗi xảy ra khi xóa tài khoản random',
                        });
                    }
                });
            });
        });
    </script>
@endpush
