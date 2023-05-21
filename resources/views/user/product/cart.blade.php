@extends('user.layouts.master')
@section('title', 'Cart')
@section('content')
    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0" id="dataTable">
                    <thead class="thead-dark">
                        <tr>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($carts as $item)
                            <tr>
                                <input type="hidden" class="userId" value="{{ Auth::user()->id }}">
                                <input type="hidden" class="productId" value="{{ $item->id }}">
                                <td class="align-middle">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-6"> <img
                                                src="{{ asset('storage/images/product/' . $item->image) }}"alt=""
                                                style="width: 50px;">
                                        </div>
                                        <div class="col-6">{{ $item->product_name }}</div>
                                    </div>

                                </td>
                                <td class="align-middle" id="price" value="{{ $item->price }}">{{ $item->price }} MMK
                                </td>
                                <td class="align-middle">
                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-minus">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text"
                                            class="form-control form-control-sm bg-secondary border-0 text-center"
                                            value="{{ $item->qty }}" id="qty">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-plus">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle total">{{ $item->qty * $item->price }} MMK</td>
                                <td class="align-middle"><button class="btn btn-sm btn-danger btnRemove"><i
                                            class="fa fa-times"></i></button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart
                        Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6 id="subTotal">{{ $totalAmount }} MMK</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Delivary</h6>
                            <h6 class="font-weight-medium" id="delivary">1000 MMK</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5 id="grandTotal">{{ $totalAmount + 1000 }} MMK</h5>
                        </div>
                        <button class="btn btn-block btn-primary font-weight-bold my-3 py-3" id="btnCheckOut">Proceed To
                            Checkout</button>

                        <button class="btn btn-block btn-danger font-weight-bold my-3 py-3" id="btnClearAll">Clear All
                            </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection
@section('script')
    {{-- PURE JS --}}
    <script src="{{ asset('js/cart.js') }}"></script>
    <script>
        $('document').ready(function() {
            $('#btnCheckOut').click(function() {
                // UserId with Timestamp
                $orderCode = $('.userId').val() + "POS" + Date.now().toString();
                $orderList = [];
                $('#dataTable tbody tr').each(function(index, row) {
                    $orderList.push({
                        'user_id': $(row).find('.userId').val(),
                        'product_id': $(row).find('.productId').val(),
                        'qty': $(row).find('#qty').val(),
                        'total': $(row).find('.total').text().replace('MMK', '') * 1,
                        'order_code': $orderCode,
                    });
                });
                $.ajax({
                    type: 'get',
                    url: '/user/ajax/order',
                    // JSON OBJECT FORMAT
                    data: Object.assign({}, $orderList),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 'success') {
                            window.location.href = "/user/home"
                        }
                    }
                })
            })

            $('#btnClearAll').click(function() {
                $.ajax({
                    type : 'get',
                    url : '/user/ajax/clear/cart',
                    dataType : 'json',
                })

                $('#dataTable tbody tr').remove();
                $('#subTotal').html("0 MMK");
                $('#delivary').html("0 MMK");
                $('#grandTotal').html("0 MMK");

            })
        })
    </script>
@endsection
