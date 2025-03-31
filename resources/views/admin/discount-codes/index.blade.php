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
                        <div class="wordset">
                            <ul>
                                <li>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf">
                                        <img src="{{ asset('assets/img/icons/pdf.svg') }}" alt="img">
                                    </a>
                                </li>
                                <li>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel">
                                        <img src="{{ asset('assets/img/icons/excel.svg') }}" alt="img">
                                    </a>
                                </li>
                                <li>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="print">
                                        <img src="{{ asset('assets/img/icons/printer.svg') }}" alt="img">
                                    </a>
                                </li>
                            </ul>
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
                                @foreach ($discountCodes as $discountCode)
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td>{{ $discountCode->id }}</td>
                                        <td class="text-bolds">{{ $discountCode->code }}</td>
                                        <td>{{ $discountCode->type === 'percentage' ? 'Phần trăm' : 'Số tiền cố định' }}
                                        </td>
                                        <td>
                                            @if ($discountCode->type === 'percentage')
                                                {{ $discountCode->value }}%
                                            @else
                                                {{ number_format($discountCode->value) }}đ
                                            @endif
                                        </td>
                                        <td>{{ $discountCode->usage_limit }}</td>
                                        <td>{{ $discountCode->expires_at ? $discountCode->expires_at->format('d/m/Y') : 'Không hết hạn' }}
                                        </td>
                                        <td>
                                            <span
                                                class="badges {{ $discountCode->is_active ? 'bg-lightgreen' : 'bg-lightred' }}">
                                                {{ $discountCode->is_active ? 'Hoạt động' : 'Không hoạt động' }}
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
                                                    <a href="javascript:void(0);" class="dropdown-item confirm-text"
                                                        onclick="event.preventDefault(); document.getElementById('delete-form-{{ $discountCode->id }}').submit();">
                                                        <img src="{{ asset('assets/img/icons/delete.svg') }}"
                                                            class="me-2" alt="img">
                                                        Xóa mã
                                                    </a>
                                                    <form id="delete-form-{{ $discountCode->id }}"
                                                        action="{{ route('admin.discount-codes.destroy', $discountCode->id) }}"
                                                        method="POST" class="d-none">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
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
@endsection
