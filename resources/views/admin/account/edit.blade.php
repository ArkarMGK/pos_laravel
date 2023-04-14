@extends('admin.layouts.master')
@section('title', 'Account-Edit')
@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
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
                <div class="d-flex justify-content-center">
                    <div class="col-lg-10">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">
                                    <h3 class="text-center title-2">Admin Details</h3>
                                </div>
                                <hr>
                                <form action="{{ route('admin#accountUpdate', Auth::user()->id) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6">
                                            @if (Auth::user()->image != null)
                                                <img src="{{ asset('storage/' . Auth::user()->image) }}">
                                            @else
                                                <img src="@if (Auth::user()->gender == 'male') {{ asset('images/default/default-user-male.png') }}
                                                @else
                                                {{ asset('images/default/default-user-female.jpg') }} @endif "
                                                    alt="">
                                            @endif

                                            <div class="mt-4">
                                                <input type="file" name="image" id="">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="name" class="control-label mb-1">Name</label>
                                                <input id="name" name="name" type="text"
                                                    class="form-control @error('name')
                                                        is-invalid
                                                    @enderror"
                                                    aria-required="true" aria-invalid="false" placeholder="Enter Name"
                                                    value="{{ old('name', Auth::user()->name) }}">
                                                @error('name')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>



                                            <div class="form-group">
                                                <label for="email" class="control-label mb-1">Email</label>
                                                <input id="email" name="email" type="text"
                                                    class="form-control  @error('email', Auth::user()->email)
                                                        is-invalid
                                                    @enderror"
                                                    aria-required="true" aria-invalid="false" placeholder="Enter Email..."
                                                    value="{{ old('email', Auth::user()->email) }}">

                                                @error('email')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="phone" class="control-label mb-1">Phone</label>
                                                <input id="phone" name="phone" type="text"
                                                    class="form-control  @error('phone')
                                                        is-invalid
                                                    @enderror"
                                                    aria-required="true" aria-invalid="false" placeholder="Enter Phone..."
                                                    value="{{ old('phone', Auth::user()->phone) }}">

                                                @error('phone')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>


                                            <div class="form-group">
                                                <label for="gender" class="control-label mb-1">Gender</label>
                                                <select class="form-control" name="gender" id="">
                                                    <option value="">Select Gender...</option>
                                                    <option value="male"
                                                        @if (Auth::user()->gender == 'male') selected @endif>Male</option>
                                                    <option value="female"
                                                        @if (Auth::user()->gender = 'female') selected @endif>Female</option>
                                                </select>
                                                @error('gender')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>


                                            <div class="form-group">
                                                <label for="address" class="control-label mb-1">Address</label>
                                                {{-- <input id="address" name="address" type="text"
                                                        class="form-control  @error('address')
                                                        is-invalid
                                                    @enderror"
                                                        aria-required="true" aria-invalid="false"
                                                        placeholder="Enter Address..."
                                                        value="{{ old('address', Auth::user()->address) }}"> --}}
                                                <textarea class="form-control" name="address" id="" cols="30" rows="4">{{ old('address', Auth::user()->address) }}</textarea>
                                                @error('address')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <button class="btn btn-primary w-100"><i class="zmdi zmdi-check"></i>
                                                Update</button>
                                        </div>
                                    </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
