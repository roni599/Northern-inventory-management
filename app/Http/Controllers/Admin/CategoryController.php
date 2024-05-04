<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;


class CategoryController extends Controller
{
    public function index()
    {
        $data = array();
        if (Session::has('loginIdAdmin')) {
            $data = User::where('id', '=', Session::get('loginIdAdmin'))->first();
        }
        $user_id = Session::get('loginIdAdmin');
        $user = User::where('id', $user_id)->first();
        $categories = Category::latest()->paginate(5);
        return view('Admin.pages.category',compact('categories','data','user'));
    }

    public function store(Request $request)
    {
        Category::create([
            'category_name' => $request->input('nameWithTitle'),
        ]);
        return response()->json(['status' => 'success']);
    }
    public function categoryEdit(Request $request)
    {
        $categoryId = $request->input('category_id');
        $category = Category::findOrFail($categoryId);
        $category->update([
            'category_name' => $request->input('nameWithTitle')
        ]);
        return response()->json(['status' => 'success']);
    }

    public function categoryDestroy(Request $request)
    {
        $category = Category::find($request->category_id);
        if (!$category) {
            return response()->json(['error' => 'Role not found'], 404);
        }
        $category->delete();
        return response()->json(['status' => 'success']);
    }
}
