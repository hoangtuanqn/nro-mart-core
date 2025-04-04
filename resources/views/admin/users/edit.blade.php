@extends('layouts.admin.app')
@section('title', $title)
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Chỉnh sửa người dùng</h4>
                    <h6>Cập nhật thông tin người dùng</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Tên tài khoản</label>
                                    <input type="text" name="username" value="{{ $user->username }}" class="form-control"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" value="{{ $user->email }}"
                                        class="form-control @error('email') is-invalid @enderror">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Vai trò</label>
                                    <select name="role" class="select @error('role') is-invalid @enderror">
                                        <option value="member" {{ $user->role == 'member' ? 'selected' : '' }}>Người dùng
                                        </option>
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Quản trị viên
                                        </option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Số dư</label>
                                    <input type="number" name="balance" value="{{ $user->balance }}"
                                        class="form-control @error('balance') is-invalid @enderror">
                                    @error('balance')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Tổng nạp</label>
                                    <input type="number" name="total_deposited" value="{{ $user->total_deposited }}"
                                        class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Trạng thái</label>
                                    <select name="banned" class="select @error('banned') is-invalid @enderror">
                                        <option value="0" {{ $user->banned == 0 ? 'selected' : '' }}>Hoạt động
                                        </option>
                                        <option value="1" {{ $user->banned == 1 ? 'selected' : '' }}>Bị khóa</option>
                                    </select>
                                    @error('banned')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">Cập nhật</button>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-cancel">Hủy bỏ</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

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
                                    <th>ID</th>
                                    <th>Loại giao dịch</th>
                                    <th>Số tiền</th>
                                    <th>Số dư trước</th>
                                    <th>Số dư sau</th>
                                    <th>Mô tả</th>
                                    <th>Thời gian</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $key => $transaction)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            {!! display_status_transactions_admin($transaction->type) !!}

                                        </td>
                                        <td
                                            class="{{ $transaction->type == 'deposit' || $transaction->type == 'refund' ? 'text-success' : 'text-danger' }}">
                                            {{ ($transaction->type == 'deposit' || $transaction->type == 'refund' ? '+' : '') . number_format($transaction->amount) }}đ
                                        </td>
                                        <td>{{ number_format($transaction->balance_before) }}đ</td>
                                        <td>{{ number_format($transaction->balance_after) }}đ</td>
                                        <td>{{ $transaction->description }}</td>
                                        <td>{{ $transaction->created_at->format('d/m/Y H:i:s') }}</td>
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
