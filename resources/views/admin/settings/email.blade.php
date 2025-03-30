@extends('layouts.admin.app')
@section('title', $title)
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Email Setting</h4>
                    <h6>Manage Email Setting</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Mail Host <span class="manitory">*</span></label>
                                <input type="text">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Mail Port<span class="manitory">*</span></label>
                                <input type="text">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Mail Address <span class="manitory">*</span></label>
                                <input type="text">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Password <span class="manitory">*</span></label>
                                <div class="pass-group">
                                    <input type="password" class=" pass-input">
                                    <span class="fas toggle-password fa-eye-slash"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Mail From Name<span class="manitory">*</span></label>
                                <input type="text">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Encryption <span class="manitory">*</span></label>
                                <select class="select">
                                    <option>Choose </option>
                                    <option>Encryption</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <a href="javascript:void(0);" class="btn btn-submit me-2">Submit</a>
                                <a href="javascript:void(0);" class="btn btn-cancel">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
