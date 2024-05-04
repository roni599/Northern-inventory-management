<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class RoleController extends Controller
{
    public function index()
    {
        $data = array();
        if (Session::has('loginIdAdmin')) {
            $data = User::where('id', '=', Session::get('loginIdAdmin'))->first();
        }
        $user_id = Session::get('loginIdAdmin');
        $user = User::where('id', $user_id)->first();
        $roles = Role::latest()->paginate(5);
        return view('Admin.pages.roles', compact('roles','data','user'));
    }
    public function store(Request $request)
    {
        Role::create([
            'role_name' => $request->input('nameWithTitle'),
            'permissions' => $request->input('permissions'),
        ]);
        return response()->json(['status' => 'success']);
    }
    public function roleDestroy(Request $request)
    {
        $role = Role::find($request->role_id);
        if (!$role) {
            return response()->json(['error' => 'Role not found'], 404);
        }
        $role->delete();
        return response()->json(['status' => 'success']);
    }

    public function roleEdit(Request $request)
    {
        $roleId = $request->input('role_id');
        $role = Role::findOrFail($roleId);
        $role->update([
            'role_name' => $request->input('nameWithTitle'),
            'permissions' => $request->input('permissions')
        ]);
        return response()->json(['status' => 'success']);
    }
}
