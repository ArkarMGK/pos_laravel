<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderList;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function orderList()
    {
        $orders = Order::select('orders.*', 'users.name as user_name')
            ->leftJoin('users', 'users.id', 'orders.user_id')
            ->get();
        return view('admin.order.list', compact('orders'));
    }

    public function viewByOrderStatus(Request $request)
    {
        $orders = Order::select('orders.*', 'users.name as user_name')
            ->leftJoin('users', 'users.id', 'orders.user_id')
            ->orderBy('created_at', 'desc');

        if ($request->orderStatus == null) {
            $orders = $orders->get();
        } else {
            $orders = $orders
                ->where('orders.status', $request->orderStatus)
                ->get();
        }

        return view('admin.order.list', compact('orders'));
    }

    public function showOrderDetails($orderCode)
    {
        $orders = OrderList::select(
            'order_lists.*',
            'users.name as user_name',
            'products.name as product_name',
            'products.image as image'
        )
            ->leftJoin('users', 'users.id', 'order_lists.user_id')
            ->leftJoin('products', 'products.id', 'order_lists.product_id')
            ->where('order_code', $orderCode)
            ->get();
        // dd($orders->toArray());
        return view('admin.order.showOrderDetails', compact('orders'));
    }
}
