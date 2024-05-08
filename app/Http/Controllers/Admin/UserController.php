<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;



class UserController extends Controller
{

    public function userList()
    {
        $data = array();
        if (Session::has('loginIdAdmin')) {
            $data = User::where('id', '=', Session::get('loginIdAdmin'))->first();
        }
        $user_id = Session::get('loginIdAdmin');
        $user = User::where('id', $user_id)->first();
        
        $users = User::latest()->paginate(50);
        $roles = Role::all();
        $organizations = Organization::all();
        return view('Admin.pages.userlist', compact('users', 'roles', 'organizations','data','user'));
    }
    public function create()
    {
        $data = array();
        if (Session::has('loginIdAdmin')) {
            $data = User::where('id', '=', Session::get('loginIdAdmin'))->first();
        }
        $user_id = Session::get('loginIdAdmin');
        $user = User::where('id', $user_id)->first();

        $roles = Role::all();
        $organizations = Organization::all();
        return view('Admin.pages.create_user', compact('roles', 'organizations','data','user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fullName' => 'required|string|max:255',
            'role' => 'required|in:1,2,3,4,5,6,7,8,9,10',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'organization' => 'required|in:1,2,3,4,5,6,7,8,9,10',
            'phoneNumber' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:5120',
        ]);
        $user = new User();
        $user->full_name = $request->fullName;
        $user->role_id = $request->role;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->organization_id = $request->organization;
        $user->phone = $request->phoneNumber;
        $user->address = $request->address;

        $imageName = '';
        if ($image = $request->file('image')) {
            $imageName = rand(1, 1000) . '_' . $request->full_name . '.' . $image->getClientOriginalExtension();
            $image->move('images/uploads/', $imageName);
            $user->profile_img = $imageName;
        }
        $user->save();
        return redirect()->back()->with('success', 'User created successfully');
    }

    public function userEdit(Request $request)
    {
        if ($request->ajax()) {
            $userId = $request->input('user_id');
            $user = User::findOrFail($userId);

            $imageName = '';
            $deleteOldImage = 'images/uploads/' . $user->profile_img;
            if ($image = $request->file('newimage')) {

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
            return response()->json(['status' => 'success']);
        }
    }
    public function userDestroy(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        if (!$user) {
            return response()->json(['error' => 'Role not found'], 404);
        }
        $deleteOldImage = 'images/uploads/' . $user->profile_img;
        if (file_exists($deleteOldImage)) {
            File::delete($deleteOldImage);
        }
        $user->delete();
        return response()->json(['status' => 'success']);
    }

    public function user_searchlist(Request $request){
        return "ik";
    }
}
