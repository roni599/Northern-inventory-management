<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ProcurementExport;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Organization;
use App\Models\Procurement;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function index()
    {
        $data = array();
        if (Session::has('loginIdAdmin')) {
            $data = User::where('id', '=', Session::get('loginIdAdmin'))->first();
        }
        $user_id = Session::get('loginIdAdmin');
        $user = User::where('id', $user_id)->first();

        $roles = Role::all();
        $categories = Category::all();
        $organizations = Organization::all();
        $products = Product::with(['category', 'organizations'])->paginate(10);
        return view('Admin.pages.productlist', compact('products', 'roles', 'categories', 'organizations', 'user', 'data'));
    }

    public function addproduct()
    {
        $data = array();
        if (Session::has('loginIdAdmin')) {
            $data = User::where('id', '=', Session::get('loginIdAdmin'))->first();
        }
        $user_id = Session::get('loginIdAdmin');
        $user = User::where('id', $user_id)->first();

        $roles = Role::all();
        $categories = Category::all();
        $organizations = Organization::all();
        return view('Admin.pages.add_product', compact('roles', 'categories', 'organizations', 'data', 'user'));
    }

    // public function store(Request $request)
    // {

    //     $roles = Role::all();

    //     $product = new Product();
    //     $product->product_name = $request->product_name;
    //     $product->expiry_time = $request->expiry_time;
    //     $product->quantity = $request->quantity;
    //     $product->category_id = $request->category;
    //     foreach ($roles as $role) {
    //         if ($role->permissions == 1) {
    //             $product->role_id = 1;
    //         }
    //     }
    //     if ($request->hasFile('image')) {
    //         $file = $request->file('image');
    //         $filename = rand(1, 1000) . '_' . $product->product_name . '-' . $request->file('image')->getClientOriginalName();
    //         $file->move('products', $filename);
    //         $product->product_img = $filename;
    //     }

    //     $product->save();

    //     $product->organizations()->attach($request->organization);

    //     return Redirect::back()->with('success', 'Product added successfully');
    // }

    public function store(Request $request)
    {
        
        $roles = Role::where('permissions',$request->category)->first();
        
        $product = new Product();
        $product->product_name = $request->product_name;
        $product->expiry_time = $request->expiry_time;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category;

        if($roles->id==1){
            $product->role_id=$request->category;
        }
        elseif($roles->id==2 || $roles->id==3){
            $product->role_id=$request->category;
        }
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = rand(1, 1000) . '_' . $product->product_name . '-' . $request->file('image')->getClientOriginalName();
            $file->move('products', $filename);
            $product->product_img = $filename;
        }

        $product->save();

        $product->organizations()->attach($request->organization);

        return Redirect::back()->with('success', 'Product added successfully');
    }


    public function productEdit(Request $request)
    {
        
        $productId = $request->input('pid');
        $product = Product::findOrFail($productId);
        $roles = Role::where('permissions',$request->category)->first();

        $product->product_name = $request->product_name;
        $product->expiry_time = $request->expiry_time;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category;
        if($roles->id==1){
            $product->role_id=$request->category;
        }
        elseif($roles->id==2 || $roles->id==3){
            $product->role_id=$request->category;
        }

        if ($request->hasFile('image')) {
            if ($product->product_image) {
                $oldImagePath = public_path('products/' . $product->product_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $file = $request->file('image');
            $filename = rand(1, 1000) . '_' . $product->product_name . '-' . $file->getClientOriginalName();
            $file->move('products/', $filename);
            $product->product_image = $filename;
        }

        $product->save();

        $product->organizations()->sync($request->organization);

        return response()->json(['status' => 'success']);
    }


    public function productDestroy(Request $request)
    {
        $product = Product::find($request->product_id);
        if (!$product) {
            return response()->json(['error' => 'Role not found'], 404);
        }
        $product->delete();
        return response()->json(['status' => 'success']);
    }

    public function addprocurement()
    {
        $data = array();
        if (Session::has('loginIdAdmin')) {
            $data = User::where('id', '=', Session::get('loginIdAdmin'))->first();
        }

        $user_id = Session::get('loginIdAdmin');
        $user = User::where('id', $user_id)->first();
        $products = Product::all();
        $procurements = Procurement::latest()->paginate(5);
        return view('Admin.pages.add_procurement', compact('products', 'procurements', 'data', 'user'));
    }

    public function storeprocurement(Request $request)
    {
        $productName = $request->input('productName');
        $quantity = $request->input('quantity');
        // $unitPrice = $request->input('unitprice');

        $product = Product::find($productName);

        if ($product) {
            // Update the quantity of the product
            $newQuantity = $product->quantity + $quantity;
            $product->quantity = $newQuantity;
            $product->save();
        } else {
            return 'wrong attempt';
        }
        Procurement::create([
            'product_id' => $request->productName,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'unit_price' => $request->unitprice,
        ]);
        return response()->json(['status' => 'success']);
    }

    public function procurementEdit(Request $request)
    {
        $procureId = $request->input('procure_id');
        $productId = $request->input('productName');
        $quantity = $request->input('quantity');

        $procurements = Procurement::findOrFail($procureId);

        $originalQuantity = $procurements->getOriginal('quantity');

        $product = Product::find($productId);

        if ($product) {
            // Calculate the difference in quantity
            $quantityDifference = $quantity - $originalQuantity;

            // Perform summation or subtraction based on the difference
            if ($quantityDifference > 0) {
                // Add the difference to the product's quantity for procurement
                $product->quantity += $quantityDifference;
            } elseif ($quantityDifference < 0) {
                // Subtract the absolute value of the difference from the product's quantity for consumption
                $product->quantity -= abs($quantityDifference);
            }

            // Save the updated product
            $product->save();
        }
        $procurements->update([
            'product_id' => $request->productName,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'unit_price' => $request->unitprice,
        ]);
        return response()->json(['status' => 'success']);
    }

    public function procurementDestroy(Request $request)
    {
        $tt = $request->procure_id;
        $procureId = Procurement::find($request->procure_id);
        if (!$procureId) {
            return response()->json(['error' => 'Role not found'], 404);
        }
        $procureId->delete();
        return response()->json(['status' => 'success']);
    }

    public function product_searchlist(Request $request)
    {
        $userId = $request->input('query');
        $products = Product::where('product_name', 'like', '%' . $userId . '%')
            ->orWhere('quantity', 'like', '%' . $userId . '%')
            ->get();
        // $products = Product::paginate(10);

        $tableHtml = '';

        $tableHtml .= '<table class="table" id="productTable">';
        $tableHtml .= '<thead>';
        $tableHtml .= '<tr>';
        $tableHtml .= '<th>#</th>';
        $tableHtml .= '<th>Product Name</th>';
        $tableHtml .= '<th>Category</th>';
        $tableHtml .= '<th>Assigned For</th>';
        $tableHtml .= '<th>Expiry Time</th>';
        $tableHtml .= '<th>Quantity</th>';
        $tableHtml .= '<th>Organization</th>';
        $tableHtml .= '<th>Actions</th>';
        $tableHtml .= '</tr>';
        $tableHtml .= '</thead>';
        $tableHtml .= '<tbody class="table-border-bottom-0">';

        // Loop through each product and add a table row for each
        foreach ($products as $product) {
            $tableHtml .= '<tr>';
            $tableHtml .= '<td>' . $product->id . '</td>';
            $tableHtml .= '<td>' . $product->product_name . '</td>';
            $tableHtml .= '<td>' . ($product->category ? $product->category->category_name : 'No Category Assigned') . '</td>';
            $tableHtml .= '<td>' . ($product->role ? $product->role->role_name : 'No Role Assigned') . '</td>';
            $tableHtml .= '<td>' . ($product->expiry_time ?: '0') . '</td>';
            $tableHtml .= '<td>' . $product->quantity . '</td>';
            $tableHtml .= '<td>';
            foreach ($product->organizations as $organization) {
                $tableHtml .= $organization->organization_name . '<br>';
            }
            $tableHtml .= '</td>';
            $tableHtml .= '<td class="d-flex">';
            $tableHtml .= '<button type="button" class="btn btn-link p-0 updateProductButton"';
            $tableHtml .= ' data-bs-toggle="modal" data-bs-target="#updateProductmodal"';
            $tableHtml .= ' data-product_id="' . $product->id . '"';
            $tableHtml .= ' data-product_name="' . $product->product_name . '"';
            $tableHtml .= ' data-role_id="' . ($product->role ? $product->role->role_name : 'null') . '"';
            $tableHtml .= ' data-expiry_time="' . ($product->expiry_time ?: 'null') . '"';
            $tableHtml .= ' data-category="' . ($product->category ? $product->category->category_name : 'null') . '"';
            $tableHtml .= ' data-quantity="' . $product->quantity . '"';
            $tableHtml .= ' data-organization="' . $product->organizations->pluck('id')->toJson() . '">';
            $tableHtml .= '<i class="bx bx-edit-alt me-1 bg-success p-2 rounded-2 text-white"></i>';
            $tableHtml .= '</button>';
            $tableHtml .= '<form id="productDelete" action="' . route('product.destroy', $product->id) . '" method="post">';
            $tableHtml .= '<input type="hidden" name="_token" value="' . csrf_token() . '">';
            $tableHtml .= '<input type="hidden" name="_method" value="DELETE">';
            $tableHtml .= '<button type="submit" onclick="return confirm(\'Are you sure?\')" class="btn btn-link p-0">';
            $tableHtml .= '<i class="bx bx-trash me-1 bg-danger p-2 rounded-2 text-white"></i>';
            $tableHtml .= '</button>';
            $tableHtml .= '</form>';
            $tableHtml .= '</td>';
            $tableHtml .= '</tr>';

            return $tableHtml;
        }

        // Finish building the HTML markup
        $tableHtml .= '</tbody>';
        $tableHtml .= '</table>';
        $tableHtml .= '<span class="p-4 d-flex gap-3">';
        // Add pagination links
        $tableHtml .= $products->links('pagination::bootstrap-4');
        $tableHtml .= '</span>';
        $tableHtml .= '</div>';
        $tableHtml .= '</div>';

        // Return the generated HTML markup
        return $tableHtml;
    }
    public function user_searchlist(Request $request)
    {

        $searchTerm = $request->input('query');

        $users = User::Where('full_name', 'like', '%' . $searchTerm . '%')

            ->get();
        $tableHtml = '<div class="card mt-3" id="userTableDiv">';
        $tableHtml .= '<h5 class="card-header">Users</h5>';
        $tableHtml .= '<div class="table-responsive text-nowrap">';
        $tableHtml .= '<table class="table" id="userTable">';
        $tableHtml .= '<thead>';
        $tableHtml .= '<tr>';
        $tableHtml .= '<th>User ID</th>';
        $tableHtml .= '<th>Full Name</th>';
        $tableHtml .= '<th>Role</th>';
        $tableHtml .= '<th>Email</th>';
        $tableHtml .= '<th>Phone</th>';
        $tableHtml .= '<th>Organization Name</th>';
        $tableHtml .= '<th>profile</th>';
        $tableHtml .= '<th>Status</th>';
        $tableHtml .= '<th>Actions</th>';
        $tableHtml .= '</tr>';
        $tableHtml .= '</thead>';
        $tableHtml .= '<tbody class="table-border-bottom-0">';

        foreach ($users as $key => $user) {
            $tableHtml .= '<tr>';
            $tableHtml .= '<td>' . ($key + 1) . '</td>';
            $tableHtml .= '<td>' . $user->full_name . '</td>';
            $tableHtml .= '<td>' . ($user->role_id === null ? 'No Role Assigned' : $user->role->role_name) . '</td>';
            $tableHtml .= '<td>' . $user->email . '</td>';
            $tableHtml .= '<td>' . $user->phone . '</td>';
            $tableHtml .= '<td>' . ($user->organization === null ? 'No organization Assigned' : $user->organization->organization_name) . '</td>';
            $tableHtml .= '<td><img src="' . asset('images/uploads/' . $user->profile_img) . '" height="50px" width="50px" style="border-radius:50%; border: 4px solid greenyellow;" alt=""></td>';
            $tableHtml .= '<td><span class="badge bg-label-success me-1">' . $user->status . '</span></td>';
            $tableHtml .= '<td class="d-flex">';
            $tableHtml .= '<button type="button" class="btn btn-link p-0 updateUserButton" data-bs-toggle="modal" data-bs-target="#updateUsermodal" data-user_id="' . $user->id . '" data-full_name="' . $user->full_name . '" data-email="' . $user->email . '" data-phone_number="' . $user->phone . '" data-address="' . $user->address . '" data-image="' . $user->profile_img . '" data-role_id="' . ($user->role_id != null ? $user->role->role_name : 'No Role Assigned') . '" data-organization_id="' . ($user->organization_id != null ? $user->organization->organization_name : 'No organization Assigned') . '">';
            $tableHtml .= '<i class="bx bx-edit-alt me-1 bg-success p-2 rounded-2 text-white"></i>';
            $tableHtml .= '</button>';
            $tableHtml .= '<form id="userDelete" action="' . route('user.destroy') . '" method="post">';
            $tableHtml .= '<input type="hidden" name="user_id" value="' . $user->id . '">';
            $tableHtml .= '<button type="submit" onclick="return confirm(\'Are you sure?\')" class="btn btn-link p-0">';
            $tableHtml .= '<i class="bx bx-trash me-1 bg-danger p-2 rounded-2 text-white"></i>';
            $tableHtml .= '</button>';
            $tableHtml .= '</form>';
            $tableHtml .= '</td>';
            $tableHtml .= '</tr>';
        }

        $tableHtml .= '</tbody>';
        $tableHtml .= '</table>';
        $tableHtml .= '<span class="p-4 d-flex gap-3">';
        // $tableHtml .= $users->withQueryString()->links('pagination::bootstrap-5');
        $tableHtml .= '</span>';
        $tableHtml .= '</div>';
        $tableHtml .= '</div>';

        return $tableHtml;
    }
    public function procurementExport()
    {
        return Excel::download(new ProcurementExport(), 'procurements.xlsx');
    }
}
