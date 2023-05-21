<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function list(){
        $users = User::where('role','user')->get();
        return view('admin.customer.list',compact('users'));
    }
}
