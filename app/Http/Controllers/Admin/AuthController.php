<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        return view('Admin.pages.login');
    }

    public function profile(Request $request)
    {
        //$user = User::where('email',$request->email_username)->first();
        $user = User::where('email', $request->email_username)->get()->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                if ($user->role) {
                    if ($user->role->permissions === '4') {
                        $request->session()->put('loginIdAdmin', $user->id);
                        return redirect()->route('admin.dashbord');
                    } else {
                        return back()->with('fail', 'Not allowed for this crendial');
                    }
                } else {
                    // Role not found for the user
                    return back()->with('fail', 'Crendial not assigned.');
                }
            } else {
                return back()->with('fail', 'Password does not match.');
            }
        } else {
            return back()->with('fail', 'This email is not registered.');
        }
    }


    public function dashbord()
    {
        $data = array();
        if (Session::has('loginIdAdmin')) {
            $data = User::where('id', '=', Session::get('loginIdAdmin'))->first();
        }
        $user_id = Session::get('loginIdAdmin');
        $user = User::where('id', $user_id)->first();

        $ordersCount = Order::count();
        $orders=Order::all();
        $productsCount = Product::count();
        $usersCount = User::count();
        $categoryCount = Category::count();
        $bills=Bill::all();
        $billsCount=Bill::all()->count();
        return view('Admin.pages.dashboard', compact('data','orders','billsCount','bills', 'user', 'ordersCount', 'productsCount', 'usersCount', 'categoryCount'));
    }
    public function logout()
    {
        if (Session::has('loginIdAdmin') || Session::has('uuid')) {
            Session::pull('loginIdAdmin');
            Session::pull('uuid');
            return redirect()->route('admin.login');
        }
    }
    public function viewProfile()
    {
        $data = array();
        if (Session::has('loginIdAdmin')) {
            $data = User::where('id', '=', Session::get('loginIdAdmin'))->first();
        }
        $user_id = Session::get('loginIdAdmin');
        $user = User::where('id', $user_id)->first();
        return view('Admin.pages.profile', compact('data', 'user'));
    }
    public function Admin_store_profile(Request $request)
    {
        // dd($request->all());
        $userId = $request->input('user_id');
        $user = User::findOrFail($userId);
        $imageName = '';
        $deleteOldImage = 'images/uploads/' . $user->profile_img;
        if ($image = $request->file('image')) {

            if (file_exists($deleteOldImage)) {
                File::delete($deleteOldImage);
            }
            $imageName = rand(1, 1000) . '_' . $request->image_name . '.' . $image->getClientOriginalExtension();
            $image->move('images/uploads/', $imageName);
        } else {
            $imageName = $user->profile_img;
        }
        $user->update([
            'full_name' => $request->firstName,
            'role_id' => $request->role,
            'email' => $request->email,
            'organization_id' => $request->organization,
            'phone' => $request->phoneNumber,
            'address' => $request->address,
            'profile_img' => $imageName
        ]);
        return redirect()->back()->with('success', 'User Updated successfully');
    }
    public function admin_changepassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_pass' => 'required',
            'new_pass' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $userId = $request->input('user_id');
        $user = User::findOrFail($userId);
        if (Hash::check($request->old_pass, $user->password)) {
            $user->update([
                'password' => Hash::make($request->new_pass),
            ]);

            return redirect()->back()->with('password', 'Admin Password Updated successfully');
        } else {
            return redirect()->back()->with('password', 'Old password is incorrect.');
        }
    }
    public function admin_user_changepassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'chng_pass' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $userId = $request->input('user_id');

        $user = User::findOrFail($userId);
        $user->update([
            'password' => Hash::make($request->chng_pass),
        ]);

        return response()->json(['status' => 'success']);
    }
}
