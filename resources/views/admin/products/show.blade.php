@extends('admin.layouts.master')
@section('title', 'Show-product')
@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-3 offset-8">
                        <a href="{{ route('product#list') }}"><button class="btn bg-dark text-white my-3">List</button></a>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Product Information</h3>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div style="max-width: 200px; background-size: cover">
                                        <img src="{{ asset('storage/images/product/' . $product->image) }}" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <h4 class="mt-4"><span class="text-secondary">Name: </span> {{ $product->name }}
                                    </h4>
                                    <h4 class="mt-4"><span class="text-secondary">Price: </span>{{ $product->price }}
                                    </h4>
                                    <h4 class="mt-4"><span class="text-secondary">Category: </span>{{ $product->category_name }}
                                    </h4>
                                    <h4 class="mt-4"><span class="text-secondary">Description
                                            :</span>{{ $product->description }}</h4>
                                    <h4 class="mt-4"><span class="text-secondary">View Count:
                                        </span>{{ $product->view_count }}</h4>
                                    <h4 class="mt-4"><span class="text-secondary">Registered on
                                        </span>{{ $product->created_at->format('j.M.Y') }}</h4>
                                    <div class="mt-4">
                                        <a href="{{ route('product#edit', $product->id) }}" class="w-100">
                                            <button id="payment-button" type="submit"
                                                class="btn btn-lg btn-info btn-block">
                                                <span id="payment-button-amount"><i
                                                        class="zmdi zmdi-edit"></i>&nbsp;Edit</span>
                                            </button>
                                        </a>
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
