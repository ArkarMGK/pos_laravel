<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserProductController extends Controller
{
    //

    public function productDetails($id)
    {
        $product = Product::where('id', $id)->first();
        $products = Product::get();
        return view('user.product.details', compact('product', 'products'));
    }

    public function cartList()
    {
        $carts = Cart::select('carts.*', 'products.name as product_name','products.price as price', 'products.image as image')
            ->leftJoin('products', 'products.id', 'carts.product_id')
            ->where('user_id', Auth::user()->id)
            ->get();

        $totalAmount = 0;
        foreach ($carts as $item ) {
            $totalAmount += $item->price * $item->qty;
        }
        return view('user.product.cart', compact('carts','totalAmount'));
    }
}
