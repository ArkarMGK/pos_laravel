@extends('admin.layouts.master')
@section('title', 'Change-Password')
@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                {{-- <div class="row">
                    <div class="col-3 offset-8">
                        <a href="{{ route('category#list') }}"><button class="btn bg-dark text-white my-3">List</button></a>
                    </div>
                </div> --}}
                @if (session('message'))
                    <div class="col-12">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                @endif
                <div class="col-lg-6 offset-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Admin Change Password</h3>
                            </div>
                            <hr>
                            <form action="{{ route('admin#updatePassword') }}" method="post" novalidate="novalidate">
                                @csrf
                                <div class="form-group">
                                    <label for="oldPassword" class="control-label mb-1">Old Password</label>
                                    <input id="oldPassword" name="oldPassword" type="password"
                                        class="form-control  @if (session('notMatch')) is-invalid @endif   @error('oldPassword')
                                        is-invalid
                                    @enderror"
                                        aria-required="true" aria-invalid="false" placeholder="Enter old Password...">

                                    @error('oldPassword')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror

                                    @if(session('notMatch'))
                                        <small class="invalid-feedback">
                                            {{ session('notMatch') }}
                                        </small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="newPassword" class="control-label mb-1">New Password</label>
                                    <input id="newPassword" name="newPassword" type="password"
                                        class="form-control @error('newPassword')
                                        is-invalid
                                    @enderror"
                                        aria-required="true" aria-invalid="false" placeholder="Enter new Password...">
                                    @error('newPassword')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="confirmPassword" class="control-label mb-1">Confirm Password</label>
                                    <input id="confirmPassword" name="confirmPassword" type="password"
                                        class="form-control @error('confirmPassword')
                                        is-invalid
                                    @enderror"
                                        aria-required="true" aria-invalid="false" placeholder="Enter confirm Password..." }}">
                                    @error('confirmPassword')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div>
                                    <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                        <span id="payment-button-amount">Update</span>
                                        <span id="payment-button-sending" style="display:none;">Sending…</span>
                                        <i class="fa-solid fa-circle-right"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
