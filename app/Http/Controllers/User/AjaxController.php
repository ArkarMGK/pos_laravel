<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AjaxController extends Controller
{
    public function productList(Request $request)
    {
        logger($request->all());
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
        $data = $this->getOrderData($request);
        Cart::create($data);
        return response()->json(
            ['status' => 'success',
             'message' => 'add to cart complete'],
            200,
        );
    }

    private function getOrderData($request)
    {
        return [
            'qty' => $request->count,
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
        ];
    }
}
