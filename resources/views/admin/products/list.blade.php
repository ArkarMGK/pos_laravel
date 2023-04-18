@extends('admin.layouts.master')
@section('tile', 'Product-List')
@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Product List</h2>

                            </div>
                        </div>
                        <div class="table-data__tool-right">
                            <a href="{{ route('product#createPage') }}">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    <i class="zmdi zmdi-plus"></i>add product
                                </button>
                            </a>
                        </div>
                    </div>
                    {{--   ALERT MESSAGE --}}
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
                    <div class="row">
                        <div class="col-lg-8">
                            <h4>Total of <span class="text-danger">{{ count($products) }}</span> Records</h4>
                        </div>
                        <div class="col-lg-4">
                            <form action="{{ route('product#list') }}">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="key" value="{{ request('key') }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <button>
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @if (count($products))
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Created At</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr class="tr-shadow">
                                            <td>
                                                <div style="width: 40px;background-size:cover">
                                                    <img src="{{ asset('storage/images/product/' . $product->image) }}"
                                                        alt="">
                                                </div>
                                            </td>
                                            <td class="desc">{{ $product->name }}</td>
                                            <td> {{ $product->category_name }}</td>
                                            <td>{{ $product->created_at->format('j/F/Y') }}</td>
                                            <td>
                                                <div class="table-data-feature">
                                                    <a href="{{ route('product#show', $product->id) }}">
                                                        <button class="item" data-toggle="tooltip" data-placement="top"
                                                            title="View">
                                                            <i class="zmdi zmdi-eye"></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{ route('product#edit', $product->id) }}">
                                                        <button class="item" data-toggle="tooltip" data-placement="top"
                                                            title="Edit">
                                                            <i class="zmdi zmdi-edit"></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{ route('product#delete', $product->id) }}">
                                                        <button class="item" data-toggle="tooltip" data-placement="top"
                                                            title="Delete">
                                                            <i class="zmdi zmdi-delete"></i>
                                                        </button>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <div class="fixed-bottom offset-4">
                                {{ $products->appends(request()->query())->links() }}
                            </div>
                        </div>
                        <!-- END DATA TABLE -->
                    @else
                        <h2 class="text-center text-secondary">There is no product Here ...</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
