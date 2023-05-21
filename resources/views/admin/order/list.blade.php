@extends('admin.layouts.master')
@section('title', 'Order-List')
@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="table-data__tool">
                    <div class="table-data__tool-left">
                        <div class="overview-wrap">
                            <h2 class="title-1">Order List</h2>

                        </div>
                    </div>
                </div>

                <!--   ALERT MESSAGE -->
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
                        {{-- <h4>Total of <span class="text-danger">{{ count($orders) }}</span> Records</h4> --}}
                        <div class="col-lg-6">
                            <form action="{{ route('order#status') }}" method="GET">
                                <label for="orderStatus">Order Status By</label>
                                <div class="div d-flex">
                                    <select name="orderStatus" id="orderStatus" class="form-control">
                                        <option value="" @if (request('orderStatus') == null) selected @endif>All
                                        </option>
                                        <option value="0" @if (request('orderStatus') == '0') selected @endif>Pending
                                        </option>
                                        <option value="1" @if (request('orderStatus') == '1') selected @endif>Accept
                                        </option>
                                        <option value="2" @if (request('orderStatus') == '2') selected @endif>Rejected
                                        </option>
                                    </select>
                                    <button class="btn btn-primary ">Search</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                @if (count($orders) > 0)
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2">
                            <thead>
                                <tr>
                                    <th>Customer Id</th>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Code</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody class="dataList">
                                @foreach ($orders as $order)
                                    <tr class="tr-shadow dataRow">
                                        <input type="hidden" value="{{ $order->id }}" class="orderId">
                                        <td>{{ $order->user_id }}</td>
                                        <td>{{ $order->user_name }}</td>
                                        <td>{{ $order->created_at->format('j/F/Y') }}</td>
                                        <td>
                                            <a href="{{ route('order#orderCode', $order->order_code) }}">
                                                {{ $order->order_code }}
                                            </a>
                                        </td>
                                        <td>{{ $order->total_price }}</td>
                                        <td>
                                            <select name="status" class="form-control orderStatusCurrent">
                                                <option value="0" @if ($order->status == 0) selected @endif>
                                                    Pending
                                                </option>
                                                <option value="1" @if ($order->status == 1) selected @endif>
                                                    Accept
                                                </option>
                                                <option value="2" @if ($order->status == 2) selected @endif>
                                                    Rejected
                                                </option>
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        {{-- <div class="fixed-bottom offset-4">
                        {{ $orders->appends(request()->query())->links() }}
                    </div> --}}
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
@section('script')
    <script>
        $(document).ready(function() {
            // $('#orderStatus').change(function() {
            //     $status = $('#orderStatus').val();
            //     $months = ['January', 'February', 'March', 'April', 'May', 'Jone', 'July', 'August',
            //         'September', 'October', 'November', 'December'
            //     ];


            //     $.ajax({
            //         type: 'get',
            //         url: '/admin/ajax/order/status',
            //         data: {
            //             'status': $status,
            //         },
            //         dataType: 'json',
            //         success: function(response) {
            //             $list = '';

            //             for ($i = 0; $i < response.length; $i++) {
            //                 // Order Status
            //                 if (response[$i].status == 0) {
            //                     $statusMessage = `
        //                         <select name="status" class="form-control orderStatusCurrent">
        //                             <option value="0" selected>Pending</option>
        //                             <option value="1">Accept</option>
        //                             <option value="2">Reject</option>
        //                         </select>
        //                         `;
            //                 } else if (response[$i].status == 1) {
            //                     $statusMessage = `
        //                         <select name="status" class="form-control orderStatusCurrent">
        //                             <option value="0">Pending</option>
        //                             <option value="1" selected>Accept</option>
        //                             <option value="2">Reject</option>
        //                         </select>
        //                         `;
            //                 } else {
            //                     $statusMessage = `
        //                         <select name="status" class="form-control orderStatusCurrent">
        //                             <option value="0">Pending</option>
        //                             <option value="1">Accept</option>
        //                             <option value="2" selected>Reject</option>
        //                         </select>
        //                         `;
            //                 }


            //                 $dbDate = new Date(response[$i].created_at);
            //                 $createdDate = $dbDate.getDate() + "/" + $months[$dbDate
            //                     .getMonth()] + "/" + $dbDate.getFullYear();
            //                 $list += `
        //                 <tr class="tr-shadow">
        //                     <input type="hidden" value="${response[$i].id}" class="orderId">
        //                         <td>${response[$i].user_id }</td>
        //                         <td>${response[$i].user_name }</td>
        //                         <td>${$createdDate}</td>
        //                         <td>${response[$i].order_code }</td>
        //                         <td>${response[$i].total_price }</td>
        //                         <td>${$statusMessage}</td>
        //                     </tr>
        //                 `;
            //             }
            //             $('.dataList').html($list);
            //         }
            //     });
            // })

            $('.orderStatusCurrent').change(function() {
                $parentNode = $(this).parents('.dataRow');
                $status = $parentNode.find('.orderStatusCurrent').val();
                $orderId = $parentNode.find('.orderId').val();
                $.ajax({
                    type: 'get',
                    url: '/admin/ajax/order/status/change',
                    data: {
                        'status': $status,
                        'orderId': $orderId,
                    },
                    // dataType : 'json',

                    success: function(response) {
                        console.log(response);
                    }
                })
                location.reload();
            })
        })
    </script>
@endsection
