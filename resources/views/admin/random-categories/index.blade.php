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
                        <img src="{{ asset('img/icons/plus.svg') }}" alt="plus">
                        <span>Thêm danh mục</span>
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-top">
                        <div class="search-set">
                            <div class="search-input">
                                <a class="btn btn-searchset">
                                    <img src="{{ asset('img/icons/search-white.svg') }}" alt="img">
                                </a>
                            </div>
                        </div>
                        <div class="wordset">
                            <ul>
                                <li>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf">
                                        <img src="{{ asset('img/icons/pdf.svg') }}" alt="img">
                                    </a>
                                </li>
                                <li>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel">
                                        <img src="{{ asset('img/icons/excel.svg') }}" alt="img">
                                    </a>
                                </li>
                                <li>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="print">
                                        <img src="{{ asset('img/icons/printer.svg') }}" alt="img">
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
                                            <img src="{{ asset($category->thumbnail) }}" alt="{{ $category->name }}"
                                                class="img-thumbnail" style="max-width: 200px;">
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
                                                        <img src="{{ asset('img/icons/edit.svg') }}" class="me-2"
                                                            alt="img">
                                                        Sửa danh mục
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item confirm-text"
                                                        onclick="event.preventDefault(); document.getElementById('delete-form-{{ $category->id }}').submit();">
                                                        <img src="{{ asset('img/icons/delete.svg') }}" class="me-2"
                                                            alt="img">
                                                        Xóa danh mục
                                                    </a>
                                                    <form id="delete-form-{{ $category->id }}"
                                                        action="{{ route('admin.random-categories.destroy', $category->id) }}"
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
