@extends('layouts.admin.app')
@section('title', $title)
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Chỉnh sửa tài khoản game</h4>
                    <h6>Cập nhật thông tin tài khoản game</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.accounts.update', $account->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @if ($account->status == 'sold' && $account->buyer_id)
                            <h4 class="text-danger">Tài khoản này đã được bán cho <a
                                    href="{{ route('admin.users.edit', $account->buyer_id) }}" target="_blank"
                                    class="text-bold">{{ $account->buyer->username }}</a></h4>
                        @endif
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Danh mục game <span class="text-danger">*</span></label>
                                    <select name="game_category_id"
                                        class="select @error('game_category_id') is-invalid @enderror">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('game_category_id', $account->game_category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('game_category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Tên tài khoản <span class="text-danger">*</span></label>
                                    <input type="text" name="account_name"
                                        value="{{ old('account_name', $account->account_name) }}"
                                        class="form-control @error('account_name') is-invalid @enderror">
                                    @error('account_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Mật khẩu <span class="text-danger">*</span></label>
                                    <input type="text" name="password" value="{{ old('password', $account->password) }}"
                                        class="form-control @error('password') is-invalid @enderror">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Giá tiền <span class="text-danger">*</span></label>
                                    <input type="number" name="price" value="{{ old('price', $account->price) }}"
                                        class="form-control @error('price') is-invalid @enderror">
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Trạng thái</label>
                                    <select name="status" class="select @error('status') is-invalid @enderror">
                                        <option value="available"
                                            {{ old('status', $account->status) == 'available' ? 'selected' : '' }}>Còn hàng
                                        </option>
                                        <option value="sold"
                                            {{ old('status', $account->status) == 'sold' ? 'selected' : '' }}>Đã bán
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Máy chủ <span class="text-danger">*</span></label>
                                    <input type="number" name="server" value="{{ old('server', $account->server) }}"
                                        class="form-control @error('server') is-invalid @enderror">
                                    @error('server')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Loại đăng ký</label>
                                    <select name="registration_type"
                                        class="select @error('registration_type') is-invalid @enderror">
                                        <option value="virtual"
                                            {{ old('registration_type', $account->registration_type) == 'virtual' ? 'selected' : '' }}>
                                            Ảo</option>
                                        <option value="real"
                                            {{ old('registration_type', $account->registration_type) == 'real' ? 'selected' : '' }}>
                                            Thật</option>
                                    </select>
                                    @error('registration_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Hành tinh</label>
                                    <select name="planet" class="select @error('planet') is-invalid @enderror">
                                        <option value="earth"
                                            {{ old('planet', $account->planet) == 'earth' ? 'selected' : '' }}>Trái đất
                                        </option>
                                        <option value="namek"
                                            {{ old('planet', $account->planet) == 'namek' ? 'selected' : '' }}>Namek
                                        </option>
                                        <option value="xayda"
                                            {{ old('planet', $account->planet) == 'xayda' ? 'selected' : '' }}>Xayda
                                        </option>
                                    </select>
                                    @error('planet')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Bông tai</label>
                                    <select name="earring" class="select @error('earring') is-invalid @enderror">
                                        <option value="1"
                                            {{ old('earring', $account->earring) == 1 ? 'selected' : '' }}>Có</option>
                                        <option value="0"
                                            {{ old('earring', $account->earring) == 0 ? 'selected' : '' }}>Không</option>
                                    </select>
                                    @error('earring')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Ảnh đại diện</label>
                                    <div class="image-upload">
                                        <input type="file" name="thumb"
                                            class="form-control @error('thumb') is-invalid @enderror" accept="image/*"
                                            onchange="previewImage(this, 'preview-thumb')">
                                        @error('thumb')
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
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Ảnh chi tiết</label>
                                    <div class="image-upload">
                                        <input type="file" name="images[]" multiple
                                            class="form-control @error('images') is-invalid @enderror" accept="image/*"
                                            onchange="previewMultipleImages(this, 'preview-images')">
                                        @error('images')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="image-uploads">
                                            <img src="{{ asset('assets/img/icons/upload.svg') }}" alt="Upload Images"
                                                style="max-width: 200px; max-height: 200px;">
                                            <h4>Kéo thả hoặc chọn nhiều ảnh để tải lên</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 text-center">
                                <img id="preview-thumb" src="{{ $account->thumb }}" alt="preview"
                                    class="mx-auto d-block mb-3 preview-thumb">
                                <div id="preview-images" class="d-flex flex-wrap justify-content-center gap-3 mb-3">
                                    @if ($account->images)
                                        @foreach (json_decode($account->images) as $image)
                                            <img src="{{ $image }}" alt="preview"
                                                style="max-width: 200px; max-height: 200px;">
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Ghi chú</label>
                                    <textarea name="note" class="form-control @error('note') is-invalid @enderror" rows="4">{{ old('note', $account->note) }}</textarea>
                                    @error('note')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">Cập nhật</button>
                                <a href="{{ route('admin.accounts.index') }}" class="btn btn-cancel">Hủy bỏ</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(previewId).src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewMultipleImages(input, previewId) {
            var preview = document.getElementById(previewId);
            preview.innerHTML = '';
            if (input.files) {
                Array.from(input.files).forEach(file => {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.maxWidth = '200px';
                        img.style.maxHeight = '200px';
                        preview.appendChild(img);
                    }
                    reader.readAsDataURL(file);
                });
            }
        }
    </script>
@endpush
