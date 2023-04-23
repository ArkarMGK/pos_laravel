<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    // change password page
    public function changePasswordPage()
    {
        return view('admin.account.changePassword');
    }

    // update password
    public function updatePassword(Request $request)
    {
        /*
            1. all fields must be filled
            2. password lenght between 6 and 12
            3. new password & confirm password must same
            4. old password filed must be the same as the Database Password
        */

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

        // dd('here');
        return back()->with([
            'notMatch' => 'The Old Password Do Not Match. Try Again !',
        ]);
    }

    private function passwordValidationCheck(Request $request)
    {
        Validator::make($request->all(), [
            'oldPassword' => 'required|min:6|max:12',
            'newPassword' => 'required|min:6|max:12',
            'confirmPassword' => 'required|min:6|max:12|same:newPassword',
        ])->validate();
    }

    // direct admin Profile Details Page
    public function accountDetails()
    {
        return view('admin.account.details');
    }
    // direct admin Profile Edit Page
    public function accountEdit()
    {
        return view('admin.account.edit');
    }

    public function delete($id)
    {
        User::where('id', $id)->delete();
        return back()->with(['message' => 'Admin Account Deleted !']);
    }
    // admin List
    public function list()
    {
        $users =
            // = User::where('id', '!=', Auth::user()->id)
            User::when(request('key'), function ($query) {
                $query->where('name','like', '%'.request('key').'%')
                ->orWhere('email','like', '%'.request('key').'%')
                ->orWhere('address','like', '%'.request('key').'%')
                ->orWhere('gender','like', '%'.request('key').'%')
                ->orWhere('phone','like', '%'.request('key').'%');
            })
                ->where('role', 'admin')
                ->paginate(2);
        // dd($users->toArray());
        return view('admin.account.list', compact('users'));
    }

    // update Admin Account Info
    public function accountUpdate($id, Request $request)
    {
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
        return redirect()
            ->route('admin#accountDetails')
            ->with(['message' => 'Admin Account Updated..!']);
    }

    private function accountValidationCheck($request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'gender' => 'required',
            'phone' => 'required',
            'address' => 'required',
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
