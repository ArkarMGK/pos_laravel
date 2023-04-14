@extends('admin.layouts.master')
@section('title', 'Account-Details')
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
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">
                                    <h3 class="text-center title-2">Admin Details</h3>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-6">
                                        @if (Auth::user()->image != null)
                                            <div style="background-size: contain ; background-repeat: no-repeat">
                                                <img src="{{ asset('storage/' . Auth::user()->image) }}"
                                                    style="width: 400px">
                                            </div>
                                        @else
                                            <img src="@if (Auth::user()->gender == 'male') {{ asset('images/default/default-user-male.png') }}
                                        @else
                                        {{ asset('images/default/default-user-female.jpg') }} @endif "
                                                alt="">
                                        @endif

                                        <div class="mt-4">
                                            <a href="{{ route('admin#accountEdit') }}" class="w-100 mt-4">
                                                <button class="btn btn-primary w-100">
                                                    <i class="fas fa-pen-square"></i> Edit Profile
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <h4 class="text-secondary mt-2">
                                            <i class="fa fa-user"></i> {{ Auth::user()->name }}
                                        </h4>
                                        <h4 class="text-secondary mt-4">
                                            <i class="zmdi zmdi-email"></i> {{ Auth::user()->email }}
                                        </h4>
                                        <h4 class="text-secondary mt-4">
                                            <i class="fa fa-phone"></i> {{ Auth::user()->phone }}
                                        </h4>
                                        <h4 class="text-secondary mt-4">
                                            <i class="fa fa-address-card"></i> {{ Auth::user()->address }}
                                        </h4>
                                        <h4 class="text-secondary mt-4">
                                            <i class="fa fa-venus-mars"></i> {{ Auth::user()->gender }}
                                        </h4>
                                        <h4 class="text-secondary mt-4">
                                            <i class="fa fa-calendar"></i> {{ Auth::user()->created_at->format('j-F-Y') }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
