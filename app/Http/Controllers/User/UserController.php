<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // UserSite Landing Page
    public function homePage()
    {
        $categories = Category::get();
        $products = Product::latest()->get();
        $carts = Cart::where('user_id', Auth::user()->id)->get();
        $orders = Order::where('user_id', Auth::user()->id)->get();
        return view(
            'user.home',
            compact('products', 'categories', 'carts', 'orders')
        );
    }

    public function filter($categoryId)
    {
        $categories = Category::get();

        if ($categoryId != 'all') {
            $products = Product::where('category_id', $categoryId)->latest();
        } else {
            $products = Product::latest();
        }
        $products = $products->get();
        $carts = Cart::where('user_id', Auth::user()->id)->get();
        $orders = Order::where('user_id', Auth::user()->id)->get();
        return view(
            'user.home',
            compact('products', 'categories', 'carts', 'orders')
        );
    }

    // User-Site Order History Page
    public function history()
    {
        $orders = Order::where('user_id', Auth::user()->id)
            ->latest()
            ->paginate(3);
        return view('user.product.history', compact('orders'));
    }

    // User-Site Contact Us Page
    public function contactUs()
    {
        return view('user.contact');
    }

    public function saveContactMessage(Request $request)
    {
        $this->messageValidationCheck($request);
        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);
        return redirect()->route('user#home')->with([
            'message' => 'Your Message Has Been Sent !',
        ]);
    }

    private function messageValidationCheck($request)
    {
        Validator::make($request->all(), [
            'name' => 'required|min:3|max:12',
            'email' => 'required|email',
            'message' => 'required|min:10',
        ])->validate();
    }
    // User-Site Password Reset
    public function changePasswordPage()
    {
        return view('user.account.changePassword');
    }

    public function updatePassword(Request $request)
    {
        $this->passwordValidationCheck($request);
        $user = User::select('password')
            ->where('id', Auth::user()->id)
            ->first();
        $dbHashedPassword = $user->password;
        // dd($request->oldPassword, $dbHashedPassword);
        if (Hash::check($request->oldPassword, $dbHashedPassword)) {
            User::where('id', Auth::user()->id)->update([
                'password' => Hash::make($request->newPassword),
            ]);

            // Auth::logout();
            return back()->with(['message' => 'Password Updated Successfully']);
        }

        return back()->with([
            'notMatch' => 'The Old Password Do Not Match. Try Again !',
        ]);
    }

    // Password validation Check
    private function passwordValidationCheck(Request $request)
    {
        Validator::make($request->all(), [
            'oldPassword' => 'required|min:6|max:12',
            'newPassword' => 'required|min:6|max:12',
            'confirmPassword' => 'required|min:6|max:12|same:newPassword',
        ])->validate();
    }

    // User-Site Account Edit
    public function accountEditPage()
    {
        return view('user.account.edit');
    }

    public function updateAccount(Request $request, $id)
    {
        // dd($request->all(), $id);
        $this->accountValidationCheck($request);
        $data = $this->getUserData($request);
        // for image
        if ($request->hasFile('image')) {
            // $dbImage = User::where('id', $id)->first();
            // $dbImage = $dbImage->image;

            $dbImage = Auth::user()->image;
            if ($dbImage != null) {
                Storage::delete('public/' . $dbImage);
            }
            $fileName =
                uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public', $fileName);
            $data['image'] = $fileName;
        }

        User::where('id', $id)->update($data);
        return back()->with(['message' => 'Account Updated..!']);
    }

    private function accountValidationCheck($request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            // 'gender' => 'required',
            // 'phone' => 'required',
            // 'address' => 'required',
            'image' => 'mimes:png,jpg,jpeg|file',
        ])->validate();
    }

    private function getUserData($request)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'address' => $request->address,
            'updated_at' => Carbon::now(),
        ];
    }
}
