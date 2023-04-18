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
                <form action="{{ route('product#update', $product->id) }}" method="post" novalidate="novalidate"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex justify-content-center">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">
                                    <h3 class="text-center title-2">Edit Product Form</h3>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div style="max-width: 200px; background-size: cover">
                                            <img src="{{ asset('storage/images/product/' . $product->image) }}"
                                                alt="">
                                        </div>
                                        <input type="file" name="image" id="" class="mt-4">
                                    </div>
                                    <div class="col-lg-6">
                                        <hr>
                                        <div class="form-group">
                                            <input type="hidden" name="name" value="{{ $product->id }}">
                                            <label for="name" class="control-label mb-1">Name</label>
                                            <input id="name" name="name" type="text"
                                                class="form-control @error('name')
                                                is-invalid
                                            @enderror"
                                                aria-required="true" aria-invalid="false" placeholder="Seafood..."
                                                value="{{ old('name', $product->name) }}">
                                            @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="category" class="control-label mb-1">category</label>
                                            <select class="form-control" name="category" id="">
                                                <option value="">Select category...</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        @if ($category->id == $product->category_id) selected @endif>
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('category')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" name="price" value="{{ $product->id }}">
                                            <label for="price" class="control-label mb-1">Price</label>
                                            <input id="price" name="price" type="number"
                                                class="form-control @error('price')
                                                is-invalid
                                            @enderror"
                                                aria-required="true" aria-invalid="false" placeholder="Seafood..."
                                                value="{{ old('price', $product->price) }}">
                                            @error('price')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" name="description" value="{{ $product->id }}">
                                            <label for="description" class="control-label mb-1">Description</label>
                                            <textarea name="description" id="" cols="30" rows="4" class="form-control">{{ old('description', $product->description) }}</textarea>
                                            @error('description')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div>
                                            <button id="payment-button" type="submit"
                                                class="btn btn-lg btn-info btn-block">
                                                <span id="payment-button-amount"><i
                                                        class="zmdi zmdi-check"></i>&nbsp;Update</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
