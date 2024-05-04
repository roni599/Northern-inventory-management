<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;


class UserAccountSettingsController extends Controller
{
    // public function profileView(){
    //     dd('i');
    //     return view('User.pages.profile');
    // }
    public function view_profile()
    {
        $data = array();
        if (Session::has('loginId')) {
            $data = User::where('id', '=', Session::get('loginId'))->first();
        }
        $user_id = Session::get('loginId');
        $user = User::where('id', $user_id)->first();
        return view('User.pages.profile', compact('data', 'user'));
    }

    public function edit_profile()
    {
        $data = array();
        if (Session::has('loginId')) {
            $data = User::where('id', '=', Session::get('loginId'))->first();
        }
        $user_id = Session::get('loginId');
        $user = User::where('id', $user_id)->first();
        return view('User.pages.profile', compact('data', 'user'));
    }
    public function store_profile(Request $request)
    {

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
            'full_name' => $request->fullName,
            'role_id' => $request->role,
            'email' => $request->email,
            'organization_id' => $request->organization,
            'phone' => $request->phoneNumber,
            'address' => $request->address,
            'profile_img' => $imageName
        ]);
        return redirect()->back()->with('success', 'User Updated successfully');
    }
    public function userPasschange(Request $request)
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

            return redirect()->back()->with('password', 'User Password Updated successfully');
        } else {
            return redirect()->back()->with('password', 'Old password is incorrect.');
        }
    }
}
