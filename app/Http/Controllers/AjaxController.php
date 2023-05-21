<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    //

    public function viewOrderByStatus(Request $request)
    {
        // $status = $request->status == null ?  "": $request->status;

        $orders = Order::select('orders.*', 'users.name as user_name')
            ->leftJoin('users', 'users.id', 'orders.user_id')
            ->orderBy('created_at', 'desc');

        if ($request->status == null) {
            $orders = $orders->get();
        } else {
            $orders = $orders->where('orders.status', $request->status)->get();
        }

        return response()->json($orders, 200);
    }

    public function changeOrderStatus(Request $request){
        Order::where('id',$request->orderId)->update([
            'status'=>$request->status,
        ]);

        return 'Order Status Updated';
    }

    public function changeUserRole(Request $request){
        logger($request->all());
        User::where('id',$request->user_id)->update(['role'=>$request->role]);
        return 'User Role Updated';
    }
}
