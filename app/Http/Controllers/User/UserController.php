<?php

namespace App\Http\Controllers\User;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //
    public function home(){
        $categories = Category::get();
        $products = Product::get();
        return view('user.home',compact('products','categories'));
    }
}
