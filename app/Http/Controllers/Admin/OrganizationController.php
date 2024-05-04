<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;


class OrganizationController extends Controller
{
    public function index()
    {
        $data = array();
        if (Session::has('loginIdAdmin')) {
            $data = User::where('id', '=', Session::get('loginIdAdmin'))->first();
        }
        $user_id = Session::get('loginIdAdmin');
        $user = User::where('id', $user_id)->first();
        $organizations = Organization::latest()->paginate(5);
        return view('Admin.pages.organization', compact('organizations','data','user'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nameWithTitle' => 'required|string|max:255'
        ]);
        
        Organization::create([
            'organization_name' => $request->input('nameWithTitle')
        ]);
        return response()->json(['status' => 'success']);
    }

    public function organizationEdit(Request $request)
    {
        $roleId = $request->input('organization_id');
        $role = Organization::findOrFail($roleId);
        $role->update([
            'organization_name' => $request->input('nameWithTitle')
        ]);
        return response()->json(['status' => 'success']);
    }

    public function organizationDestroy(Request $request)
    {
        $role = Organization::find($request->organization_id);
        if (!$role) {
            return response()->json(['error' => 'Role not found'], 404);
        }
        $role->delete();
        return response()->json(['status' => 'success']);
    }
}
