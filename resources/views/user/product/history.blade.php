@extends('user.layouts.master')
@section('title', 'Cart-History')
@section('content')
    <!-- History Start -->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row px-xl-5">
                    <div class="col-lg-10 table-responsive mb-5 mx-auto">
                        <table class="table table-light table-borderless table-hover text-center mb-0" id="dataTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody class="align-middle">
                                @foreach ($orders as $order)
                                    <tr>
                                        <td class="align-middle">{{ $order->order_code }}</td>
                                        <td class="align-middle">{{ $order->updated_at->format('d M Y') }}</td>
                                        <td class="align-middle">{{ $order->total_price }}</td>
                                        <td class="align-middle">
                                            @if ($order->status == 0)
                                                <h5 class="text-warning"><i class="fas fa-clock"></i> Pending</h5>
                                            @elseif ($order->status == 1)
                                                <h5 class="text-success"><i class="fas fa-check"></i> Success</h5>
                                            @elseif ($order->status == 2)
                                                <h5 class="text-danger"><i class="fas fa-exclamation-triangle"></i> Rejected
                                                </h5>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-4">
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- History End-->
@endsection
