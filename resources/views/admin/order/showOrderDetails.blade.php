@extends('admin.layouts.master')
@section('title', 'order-Details')
@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('order#list') }}"> <i class="fas fa-arrow-left"></i> Back to OrderList</a>

                </div>

                @if (count($orders) > 0)
                    <div class="table-responsive table-responsive-data2">
                        <div class="row my-4">
                            <div class="col-lg-3 col-md-4">
                                <div class="row">
                                    <div class="col-4"><i class="fas fa-user"></i></div>
                                    <div class="col-8">
                                        <h4>{{ strtoupper   ($orders[0]->user_name) }}</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <i class="fas fa-barcode"></i>
                                    </div>
                                    <div class="col-8">
                                        <h4>{{ $orders[0]->order_code }}</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div class="col-8">
                                        <h4>{{ $orders[0]->created_at->format('j.F.Y') }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-data2">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Name</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody class="dataList">
                                @foreach ($orders as $order)
                                    <tr class="tr-shadow dataRow">
                                        <td>
                                            <div style="width:40px;background-size:cover">
                                                <img src="{{ asset('storage/images/product/' . $order->image) }}"
                                                    alt="">
                                            </div>
                                        </td>
                                        <td>{{ $order->product_name }}</td>
                                        <td>{{ $order->qty }}</td>
                                        <td>{{ $order->total }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <!-- END DATA TABLE -->
                @else
                    <div class="d-block mt-4">
                        <h2 class="text-center text-secondary">No data ...</h2>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
