@extends('user.layouts.master')
@section('title', 'Change-Password')
@section('content')
    <!-- MAIN CONTENT-->

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
    <div class="col-lg-6 offset-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h3 class="text-center title-2">Admin Change Password</h3>
                </div>
                <hr>
                <form action="{{ route('user#updatePassword') }}" method="post" novalidate="novalidate">
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

                        @if (session('notMatch'))
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
                            aria-required="true" aria-invalid="false" placeholder="Enter confirm Password...">
                        @error('confirmPassword')
                            <small class="invalid-feedback">{{ $message }}</small>
                        @enderror
                    </div>
                    <div>
                        <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                            <span id="payment-button-amount">
                                <i class="fa fa-check"></i>
                                Update</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
