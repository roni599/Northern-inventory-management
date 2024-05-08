<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Ramsey\Uuid\Uuid;
use RealRashid\SweetAlert\Facades\Alert;

$uuid = Uuid::uuid4()->toString();

class UserAuthController extends Controller
{
    public function login()
    {
        return view('User.pages.login');
    }
    public function profile(Request $request)
    {
        $user = User::where('email', '=', $request->email_username)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                if ($user->role) {
                    if ($user->role->permissions === '1' || $user->role->permissions === '2' || $user->role->permissions === '3') {
                        $request->session()->put('loginId', $user->id);
                        return redirect()->route('user.dashbord');
                    } else {
                        return back()->with('fail', 'Not allowed for the crendial');
                    }
                } else {
                    return back()->with('fail', 'crendial not assigned.');
                }
            }
            //  if($request->password==$user->password){
            //     $request->session()->put('loginId', $user->id);
            //     return redirect()->route('admin.dashbord');
            // }
            else {
                return back()->with('fail', 'Password not matches.');
            }
        } else {
            return back()->with('fail', 'This email is not registered.');
        }
    }
    public function dashbord()
    {
        $data = array();
        if (Session::has('loginId')) {
            $data = User::where('id', '=', Session::get('loginId'))->first();
        }
        $user_id = Session::get('loginId');
        $user = User::where('id', $user_id)->first();
        return view('User.pages.dashboard', compact('data', 'user'));
    }
    public function logout()
    {
        if (Session::has('loginId') || Session::has('uuid')) {
            Session::pull('loginId');
            Session::pull('uuid');
            return redirect()->route('user.login');
        }
    }

    public function place_order()
    {
        $user_id = Session::get('loginId');
        $user = User::where('id', $user_id)->first();

        $check = Bill::where('user_id', $user_id)->where('status', 0)->get();

        $data = array();
        if (Session::has('loginId')) {
            $data = User::where('id', '=', Session::get('loginId'))->first();
        }

        if ($check->isEmpty()) {

            $uuid1 = Uuid::uuid4()->toString();
            $uuid = implode('', array_slice(str_split($uuid1), 0, 8));
            Session::put('uuid', $uuid);
            $bill = new Bill();
            $bill->id = $uuid;
            $bill->user_id = $user_id;

            $bill->save();

            $products = Product::where('role_id', '=', $user->role_id)->get();
            $orders = Order::where('bill_id', $uuid)->get();


            if ($user->role->permissions === '2' || $user->role->permissions === '3') {
                $category = Product::where('category_id', '=', 2)->get();
                return view('User.pages.place_order', compact('data', 'category', 'user', 'products', 'orders'))->with('uuid', $uuid);
            } else {

                $category = Product::where('category_id', '=', 1)->get();
                return view('User.pages.place_order', compact('data', 'category', 'user', 'products', 'orders'))->with('uuid', $uuid);
            }
        } else {
            $uuid = $check[0]->id;
            Session::put('uuid', $uuid);

            $products = Product::where('role_id', '=', $user->role_id)->get();
            $orders = Order::where('bill_id', $uuid)->get();


            if ($user->role->permissions === '2' || $user->role->permissions === '3') {
                $category = Product::where('category_id', '=', 2)->get();
                return view('User.pages.place_order', compact('data', 'category', 'user', 'products', 'orders'))->with('uuid', $uuid);
            } else {

                $category = Product::where('category_id', '=', 1)->get();
                return view('User.pages.place_order', compact('data', 'category', 'user', 'products', 'orders'))->with('uuid', $uuid);
            }
        }
        // $uuid = Session::get('uuid');

        // if (!$uuid) {
        //     $uuid1 = Uuid::uuid4()->toString();
        //     $uuid = implode('', array_slice(str_split($uuid1), 0, 8));
        //     Session::put('uuid', $uuid);
        //     $bill = new Bill();
        //     $bill->id = $uuid;
        //     $bill->user_id = $user_id;

        //     $bill->save();
        // }
    }

    public function add_order(Request $request)
    {
        $request->validate([
            'productname' => 'required',
            'quantity' => 'required|numeric',
        ]);
        $data = array();
        if (Session::has('loginId')) {
            $data = User::where('id', '=', Session::get('loginId'))->first();
        }
        $user_id = Session::get('loginId');
        $user = User::where('id', $user_id)->first();
        $bill_name = Session::get('uuid');

        $product = Product::where('id', $request->productname)->first();

        // if ($product->product_name) {
        //     if ($product->quantity >= $request->quantity) {
        //         dd('ol');
        //     } else {
        //         dd('Product quantity is less than required quantity');
        //     }
        // } else {
        //     dd('Product not found');
        // }


        $order = new Order();
        $order->product_id = $request->productname;
        $order->quantity = $request->quantity;
        $order->bill_id = $bill_name;

        if ($user->role->permissions === '1' || $user->role->permissions === '2') {
            $productEx = Product::where('id', '=', $request->productname)->get();
            $expiryTime = $productEx->pluck('expiry_time')->toArray();
            $orders = Bill::where('user_id', $user_id)
                ->whereHas('orders', function ($query) use ($request) {
                    $query->where('product_id', $request->productname);
                })
                ->with(['orders' => function ($query) use ($request) {
                    $query->where('product_id', $request->productname);
                }])
                ->select('id', 'user_id', 'updated_at') // Include updated_at in the select statement
                ->get();
            $expiredStatus = 0;
            foreach ($orders as $order) {
                $updatedAtDate = $order->updated_at;

                // Do something with $updatedAt

                // $date = Carbon::parse($updatedAtDate);
                // echo $date . '<br>';
                // $newDate = $date->addDays(intval($expiryTime));
                // echo $newDate . '<br>';

                // $date = Carbon::createFromFormat('Y-m-d', $updatedAtDate); 
                // Create a Carbon instance with a specific date
                $date = Carbon::createFromFormat('Y-m-d H:i:s', $updatedAtDate);
                $newDate = $date->addDays(7);

                $newDate = $newDate->format('Y-m-d');
                $today = Carbon::today();
                $newDate = Carbon::parse($newDate);
                // $today = $today->format('Y-m-d');
                // echo $newDate."<br>";
                // echo $today."<br>";
                if ($newDate->gte($today)) {
                    $expiredStatus = 1;
                    return redirect()->back()->with('error', 'We Apologize. It seems like you have ordered this item recently. Please contact admin.');
                    break;
                }
            }
            if ($expiredStatus == 0) {
                $order->save();
                return redirect()->back()->with(['success' => 'Order added successfully!', 'user' => $data, 'data' => $data]);
            }
        } else {
            $order->save();
            // Alert::success('Product Added Successfully', 'we have added your product successfully');
            // return redirect()->back();
            return redirect()->back()->with(['success' => 'Order added successfully!', 'user' => $data, 'data' => $data]);
        }
    }
    public function complete_order(Request $request)
    {
        // $request->validate([
        //     'textarea' => 'required|string',
        // ]);

        // if ($request->has('textarea') && empty($request->textarea)) {
        //     Alert::error('Please add then press complete order.');
        //     return redirect()->back();
        // }
        $data = array();
        if (Session::has('loginId')) {
            $data = User::where('id', '=', Session::get('loginId'))->first();
        }
        $user_id = Session::get('loginId');
        $user = User::where('id', $user_id)->first();

        $bilId = Session::get('uuid');
        $order = Order::where('bill_id', '=', $bilId)->first();
        if (!$order || !$order->bill_id) {
            Alert::error('Please add then press complete order.');
            return redirect()->back();
        }

        $bill = Bill::find($bilId);
        $bill->user_id = $user_id;
        $bill->assign_for = $user_id;
        $bill->status = 1;
        $order->comments = $request->textarea;
        $order->save();
        $bill->save();
        Session::pull('uuid');

        Alert::success('Thank You', 'Your products are ordered successfully');
        return redirect()->route('user.dashbord');
        // return view('User.pages.complete_order', compact('data', 'user'));
    }

    public function order_list(Request $request)
    {
        $data = array();
        if (Session::has('loginId')) {
            $data = User::where('id', '=', Session::get('loginId'))->first();
        }

        $user_id = Session::get('loginId');
        $user = User::where('id', $user_id)->first();
        $bills = Bill::where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->get();
        $orderId = $request->input('orderId');

        // $orders = Order::where('bill_id', '=', $orderId)->get();
        // $bill=Bill::where('id','=',$orderId)->get();
        return view('User.pages.orderlist', compact('data', 'user', 'bills'));
    }

    public function order_details(Request $request)
    {

        $data = array();
        if (Session::has('loginId')) {
            $data = User::where('id', '=', Session::get('loginId'))->first();
        }

        $user_id = Session::get('loginId');

        $user = User::where('id', $user_id)->first();

        $orderId = $request->input('orderId');
        $orders = Order::where('bill_id', '=', $orderId)->get();
        $bill = Bill::where('id', '=', $orderId)->get();

        return view('User.pages.order_details', compact('bill', 'orders', 'data', 'user'));
    }

    public function deleteOrder(Request $request)
    {
        $orderId = $request->input('order_id');

        // Find the order by ID
        $order = Order::find($orderId);

        if (!$order) {
            return redirect()->back()->with('error', 'Order not found.');
        }

        // Delete the order
        $order->delete();

        return redirect()->back()->with('success', 'Order deleted successfully.');
    }

    public function searchOrdersByDesignation(Request $request)
    {
        $searchTerm = $request->input('designation');
        $bills = Bill::where('id', $searchTerm)->get();
        $tableHtml = '<div class="table-responsive text-nowrap">';
        $tableHtml .= '<table class="table" id="tableData">';
        $tableHtml .= '<thead>';
        $tableHtml .= '<tr>';
        $tableHtml .= '<th>Order ID</th>';
        $tableHtml .= '<th>Name</th>';
        $tableHtml .= '<th>Designation</th>';
        $tableHtml .= '<th>Order Date</th>';
        $tableHtml .= '<th>Actions</th>';
        $tableHtml .= '</tr>';
        $tableHtml .= '</thead>';
        $tableHtml .= '<tbody>';

        // Check if there are no bills found
        $tableHtml = '';
        if ($bills->isEmpty()) {
            $tableHtml .= '<p class="text-center">No data found</p>';
        } else {
            $tableHtml .= '<div class="table-responsive">';
            $tableHtml .= '<table class="table">';
            $tableHtml .= '<thead>';
            $tableHtml .= '<tr>';
            $tableHtml .= '<th>ID</th>';
            $tableHtml .= '<th>User Name</th>';
            $tableHtml .= '<th>User Role</th>';
            $tableHtml .= '<th>Created At</th>';
            $tableHtml .= '<th>Actions</th>';
            $tableHtml .= '</tr>';
            $tableHtml .= '</thead>';
            $tableHtml .= '<tbody>';
            foreach ($bills as $order) {
                $tableHtml .= '<tr>';
                $tableHtml .= '<td>' . $order->id . '</td>';
                $tableHtml .= '<td>' . $order->user->full_name . '</td>';
                $tableHtml .= '<td>' . $order->user->role->role_name . '</td>';
                $tableHtml .= '<td>' . $order->created_at . '</td>';
                // Add actions column as needed
                $tableHtml .= '<td>';
                $tableHtml .= '<a href="' . route('orders.details', ['orderId' => $order->id]) . '"><i class="bx bxs-show me-1 bg-warning p-2 rounded-2 text-white"></i></a>';
                // Add other action icons as needed
                $tableHtml .= '</td>';
                $tableHtml .= '</tr>';
            }
            $tableHtml .= '</tbody>';
            $tableHtml .= '</table>';
            $tableHtml .= '</div>';
        }

        // Return the HTML
        return $tableHtml;
    }
}
