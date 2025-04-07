@extends('layouts.admin.app')
@section('title', $title)
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Thêm Tài Khoản Random</h4>
                    <h6>Tạo tài khoản random mới</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.random-accounts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Danh mục <span class="text-danger">*</span></label>
                                    <select name="random_category_id"
                                        class="form-select @error('random_category_id') is-invalid @enderror">
                                        <option value="">-- Chọn danh mục --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('random_category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('random_category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Máy chủ <span class="text-danger">*</span></label>
                                    <select name="server" class="form-select @error('server') is-invalid @enderror">
                                        <option value="">-- Chọn máy chủ --</option>
                                        @for ($i = 1; $i <= 13; $i++)
                                            <option value="{{ $i }}" {{ old('server') == $i ? 'selected' : '' }}>
                                                Máy chủ {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                    <i>Nếu không trúng thưởng thì chọn bừa</i>
                                    @error('server')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Giá <span class="text-danger">*</span></label>
                                    <input type="number" name="price" value="{{ old('price') }}"
                                        class="form-control @error('price') is-invalid @enderror">
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>Danh sách tài khoản</label>
                                    <textarea name="accounts" rows="5" class="form-control @error('accounts') is-invalid @enderror"
                                        placeholder="account1|pass123&#10;account2|pass456">{{ old('accounts') }}</textarea>
                                    <i>Mỗi tài khoản một dòng, định dạng: username|password. Nếu không trúng thưởng thì có
                                        thể điền: Chúc bạn may mắn lần sau</i>
                                    @error('accounts')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Ghi chú</label>
                                    <textarea name="note" class="form-control @error('note') is-invalid @enderror">{{ old('note') }}</textarea>
                                    <i>Ai cũng có thể thấy</i>
                                    @error('note')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Ghi chú cho người mua</label>
                                    <textarea name="note_buyer" class="form-control @error('note_buyer') is-invalid @enderror">{{ old('note_buyer') }}</textarea>
                                    @error('note_buyer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Ảnh đại diện</label>
                                    <div class="image-upload">
                                        <input type="file" name="thumbnail"
                                            class="form-control @error('thumbnail') is-invalid @enderror" accept="image/*"
                                            onchange="previewImage(this, 'preview-thumb')">
                                        @error('thumbnail')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="image-uploads">
                                            <img src="{{ asset('assets/img/icons/upload.svg') }}" alt="Upload Image"
                                                style="max-width: 200px; max-height: 200px;">
                                            <h4>Kéo thả hoặc chọn ảnh để tải lên</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <x-preview-image />
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">Tạo tài khoản</button>
                                <a href="{{ route('admin.random-accounts.index') }}" class="btn btn-cancel">Hủy</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
