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
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
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
                                @forelse ($bankAccounts as $key => $account)
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
                                            <a class="me-3 confirm-text" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal" data-id="{{ $account->id }}">
                                                <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="img">
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">Không có dữ liệu</td>
                                    </tr>
                                @endforelse
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
                    Bạn có chắc chắn muốn xóa tài khoản ngân hàng này không?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Lưu ID và cập nhật form xóa khi click nút xóa
            $('.confirm-text').on('click', function() {
                const id = $(this).data('id');
                $('#deleteForm').attr('action', "{{ route('admin.bank-accounts.destroy', '') }}/" + id);
            });
        });
    </script>
@endpush
