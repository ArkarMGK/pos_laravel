@extends('user.layouts.master')
@section('title', 'User-Home-Page')
@section('content')
    <!-- Shop Start -->
    <div class="row px-xl-5">
        <!-- Shop Sidebar Start -->
        <div class="col-lg-3 col-md-4">
            <!-- Price Start -->
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter
                    by price</span>
            </h5>
            <div class="bg-light p-4 mb-30">
                <form>
                    <div class="d-flex align-items-center justify-content-between mb-3 bg-dark text-white px-4">

                        <label class="" for="price-all">
                            <a href="{{ route('user#home') }}">
                                Category
                            </a>
                        </label>
                        <span class="badge border font-weight-normal">{{ count($categories) }}</span>
                    </div>

                    @foreach ($categories as $category)
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="{{ route('user#filter', $category->id) }}" class="text-decoration-none"
                                style="color:darkblue">
                                <label class="" for="price-all">{{ $category->name }}</label>
                            </a>
                        </div>
                    @endforeach
                </form>
            </div>
            <!-- Price End -->

            <div class="">
                <button class="btn btn btn-warning w-100">Order</button>
            </div>
            <!-- Size End -->
        </div>
        <!-- Shop Sidebar End -->


        <!-- Shop Product Start -->
        <div class="col-lg-9 col-md-8">
            <div class="row pb-3">
                <div class="col-12 pb-1">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div>
                            <button class="btn btn-sm btn-light"><i class="fa fa-th-large"></i></button>
                            <button class="btn btn-sm btn-light ml-2"><i class="fa fa-bars"></i></button>
                        </div>
                        <div class="ml-2">
                            <div class="btn-group">
                                {{-- <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                                    data-toggle="dropdown">Sorting</button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">Latest</a>
                                    <a class="dropdown-item" href="">Oldest</a>
                                    <a class="dropdown-item" href="#">Popularity</a>
                                    <a class="dropdown-item" href="#">Best Rating</a>
                                </div> --}}
                                <div class="d-flex">
                                    {{-- <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Sorting</label> --}}
                                    <select class="custom-select my-1 mr-sm-2" id="sortingOption">
                                        {{-- <option selected value="desc">Sort by</option> --}}
                                        <option value="desc">Latest</option>
                                        <option value="asc">Oldest</option>
                                    </select>
                                </div>

                            </div>
                            <div class="btn-group ml-2">
                                <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                                    data-toggle="dropdown">Showing</button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">10</a>
                                    <a class="dropdown-item" href="#">20</a>
                                    <a class="dropdown-item" href="#">30</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if (count($products) > 0)
                    <div id="productList" class="row">
                        @foreach ($products as $product)
                            <a href="">
                                <div class="col-lg-4 pb-1">
                                    <div class="product-item bg-light mb-4">
                                        <div class="product-img position-relative overflow-hidden">
                                            <div style="height:400px;background-size: contain">
                                                <img class="img-fluid w-100"
                                                    src="{{ asset('storage/images/product/' . $product->image) }}"
                                                    alt="">
                                            </div>

                                            <div class="product-action">
                                                <a class="btn btn-outline-dark btn-square" href=""><i
                                                        class="fa fa-shopping-cart"></i></a>
                                                <a class="btn btn-outline-dark btn-square"
                                                    href="{{ route('user#productDetails', $product->id) }}"><i
                                                        class="fa fa-info-circle"></i></a>
                                            </div>
                                        </div>
                                        <div class="text-center py-4">
                                            <a class="h6 text-decoration-none text-truncate"
                                                href="">{{ $product->name }}</a>
                                            <div class="d-flex align-items-center justify-content-center mt-2">
                                                <h5>{{ $product->price }} MMK</h5>
                                                {{-- <h6 class="text-muted ml-2"><del>25000</del></h6> --}}
                                            </div>
                                            <div class="d-flex align-items-center justify-content-center mb-1">
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="col-12 mt-4 d-flex justify-content-center">
                        <h2 class="text-danger"> No Products Avaliable !</h2>
                    </div>
                @endif

            </div>
        </div>
        <!-- Shop Product End -->
    </div>
    <!-- Shop End -->
@endsection

@section('script')
    <script>
    $(document).ready(function() {
            // $.ajax({
            //     type: 'get',
            //     url: 'http://localhost:8000/user/ajax/productList',
            //     dataType: 'json',
            //     success: function(response) {
            //         console.log(response);
            //     }
            // })

            $('#sortingOption').change(function() {
                $eventOption = $('#sortingOption').val();
                $.ajax({
                    type: 'get',
                    url: 'http://localhost:8000/user/ajax/product/list',
                    data: {
                        'status': $eventOption
                    },
                    dataType: 'json',
                    success: function(response) {
                        $list = '';
                        for ($i = 0; $i < response.length; $i++) {
                            $list += `
                            <a href="">
                                <div class="col-lg-4 pb-1">
                                    <div class="product-item bg-light mb-4">
                                        <div class="product-img position-relative overflow-hidden">
                                            <div style="height:400px;background-size: contain">
                                            <img class="img-fluid w-100"
                                                src="{{ asset('storage/images/product/${response[$i].image}') }}" alt="">
                                            </div>
                                            <div class="product-action">
                                                <a class="btn btn-outline-dark btn-square" href=""><i
                                                        class="fa fa-shopping-cart"></i></a>
                                                <a class="btn btn-outline-dark btn-square" href=""><i
                                                        class="fa fa-info-circle"></i></a>
                                            </div>
                                        </div>
                                        <div class="text-center py-4">
                                            <a class="h6 text-decoration-none text-truncate" href="">${response[$i].name}</a>
                                            <div class="d-flex align-items-center justify-content-center mt-2">
                                                <h5>${response[$i].price} MMK</h5>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-center mb-1">
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            `;
                        }

                        $('#productList').html($list);
                        // console.log(response);

                    }
                })

            });

        });
    </script>
@endsection
