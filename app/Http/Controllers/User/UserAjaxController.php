<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserAjaxController extends Controller
{
    public function productList(Request $request)
    {
        // logger($request->all());
        // dd(Product::get()->toArray());
        if ($request->status == 'desc') {
            $data = Product::orderBy('created_at', 'desc')->get();
        } else {
            $data = Product::orderBy('created_at', 'asc')->get();
        }

        return $data;
    }

    public function addToCart(Request $request)
    {
        // logger($request->all());
        // $data = $this->getOrderData($request);
        Cart::create($request->all());
        return response()->json(
            ['status' => 'success', 'message' => 'add to cart complete'],
            200
        );
    }

    public function addOrder(Request $request)
    {
        $totalAmount = 0;
        foreach ($request->all() as $item) {
            // logger(gettype($item));
            // logger($item);
            $data = OrderList::create($item);
            $totalAmount += $item['total'];
        }

        // Order_Code, User Id, Grand Total
        Order::create([
            'user_id' => Auth::user()->id,
            'order_code' => $data->order_code,
            'total_price' => $totalAmount + 1000,
        ]);

        // ORDER CONFIRMED & DELETE CART
        Cart::where('user_id', Auth::user()->id)->delete();
        return response()->json(
            ['status' => 'success', 'message' => 'add to cart complete'],
            200
        );
    }

    public function clearCart()
    {
        Cart::where('user_id', Auth::user()->id)->delete();
    }

    public function increaseProductViewCount(Request $request)
    {
        $product = Product::where('id', $request->id)->first();
        $viewCount = $product->view_count + 1;

        Product::where('id', $request->id)->update([
            'view_count' => $viewCount,
        ]);
    }
}
