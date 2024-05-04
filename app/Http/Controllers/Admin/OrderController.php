<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Ramsey\Uuid\Uuid;
use RealRashid\SweetAlert\Facades\Alert;


$uuid = Uuid::uuid4()->toString();


class OrderController extends Controller
{
    public function Orders()
    {
        $data = array();
        if (Session::has('loginIdAdmin')) {
            $data = User::where('id', '=', Session::get('loginIdAdmin'))->first();
        }
        $user_id = Session::get('loginIdAdmin');
        $user = User::where('id', $user_id)->first();

        // $bills = Bill::get();
        $bills = Bill::orderBy('created_at', 'desc')->get();
        $orders = Order::all();

        // $bills = Order::whereIn('id', function ($query) {
        //     $query->select('id')
        //         ->from('orders')
        //         ->groupBy('bill_id');
        // })->get();
        // $bills = Order::orderBy('created_at', 'desc')->get();
        return view('Admin.pages.orderlist', compact('bills', 'data', 'user', 'orders'));
    }
    public function Order_place()
    {

        // $uuid=Session::get('loginIdAdmin');

        // if (!$uuid) {
        //     $uuid = substr(Uuid::uuid4()->toString(), 0, 6);
        //     Session::put('uuid', $uuid);
        // }

        // Session::pull('uuid');

        // $uuid = Session::get('uuid');
        // // If the UUID doesn't exist in the session, generate and store a new one
        // if (!$uuid) {
        //     $uuid1 = Uuid::uuid4()->toString();
        //     $uuid = implode('', array_slice(str_split($uuid1), 0, 8));
        //     Session::put('uuid', $uuid);
        // }

        $user_id = Session::get('loginIdAdmin');
        $user = User::where('id', $user_id)->first();

        $check = Bill::where('user_id', $user_id)->where('status', 0)->get();

        $data = array();
        if (Session::has('loginIdAdmin')) {
            $data = User::where('id', '=', Session::get('loginIdAdmin'))->first();
        }

        if ($check->isEmpty()) {

            $uuid1 = Uuid::uuid4()->toString();
            $uuid = implode('', array_slice(str_split($uuid1), 0, 8));
            Session::put('uuid', $uuid);
            $bill = new Bill();
            $bill->id = $uuid;
            $bill->user_id = $user_id;
            $bill->save();
            $orders = Order::where('bill_id', $uuid)->get();
            $users = User::all();
            $products = Product::all();
            return view('Admin.pages.place_order', compact('orders', 'user', 'data', 'users', 'products'))->with('uuid', $uuid);
        } else {
            $uuid = $check[0]->id;
            Session::put('uuid', $uuid);

            $users = User::all();
            $products = Product::all();
            $orders = Order::where('bill_id', $uuid)->get();
            return view('Admin.pages.place_order', compact('users', 'data', 'user', 'products', 'orders'))->with('uuid', $uuid);
            // $uuid = Session::get('uuid');
            // if (!$uuid) {
            //     $uuid1 = Uuid::uuid4()->toString();
            //     $uuid = implode('', array_slice(str_split($uuid1), 0, 8));
            //     Session::put('uuid', $uuid);
            //     $bill = new Bill();
            //     $bill->id = $uuid;
            //     $bill->save();
            // }


        }
    }

    public function Order_add(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'productname' => 'required',
            'quantity' => 'required|string',
        ]);
        $bill_name = Session::get('uuid');
        $order = new Order();
        $order->product_id = $request->productname;
        $order->quantity = $request->quantity;
        $order->bill_id = $bill_name;
        $order->save();
        // Alert::success('Product Added Successfully', 'we have added your product successfully');
        // return redirect()->back()->with('success', 'Order added successfully!');
        return redirect()->back()->with('success', 'Order added successfully!');
    }

    public function admindeleteOrder(Request $request)
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

    // public function complete_Order(Request $request)
    // {

    //     $request->validate([
    //         'textarea' => 'required|string',
    //         'assinfor' => 'required|numeric|max:255'
    //     ],
    //     [
    //         'assinfor.required' => 'Please select a user.',
    //         'assinfor.exists' => 'The selected user does not exist.',
    //     ]);
    //     $assinfor=$request->assinfor;
    //     if (Session::has('loginIdAdmin')) {
    //         $data = User::where('id', '=', Session::get('loginIdAdmin'))->first();
    //     }
    //     $user_id = Session::get('loginIdAdmin');
    //     $user = User::where('id', $user_id)->first();

    //     $bilId = Session::get('uuid');
    //     $order = Order::where('bill_id', '=', $bilId)->first();

    //     $bill = Bill::find($bilId);
    //     // $bill->status = $request->input('assinfor');
    //     // $bill->status = 1;
    //     // $bill->user_id = $user_id;
    //     $bill->assign_for =$user_id;
    //     $bill->status = 1;




    //     $bill->user_id = $request->input('assinfor');
    //     // $bill->comments = $request->textarea;
    //     $order->comments=$request->textarea;
    //     $order->save();
    //     $bill->save();
    //     Session::pull('uuid');

    //     // $bilId = Session::get('uuid');
    //     // $bill = Bill::find($bilId);
    //     // // $bill->user_id = $request->assinfor;
    //     // $bill->status =1;
    //     // $bill->save();
    //     // Session::pull('uuid');
    //     // // Alert::success('Product Added Successfully', 'we have added your product successfully');
    //     Alert::success('Product Added Successfully', 'we have added your product successfully');
    //     return redirect()->route('admin.dashbord');
    //     // return redirect('/orders');
    // }

    public function complete_Order(Request $request)
    {
        $request->validate([
            'textarea' => 'required|string',
            'assinfor' => 'required'
        ], [
            'assinfor.required' => 'Please select a user.',
            'assinfor.exists' => 'The selected user does not exist.',
        ]);

        $user_id = Session::get('loginIdAdmin');
        $ass = $request->assinfor;
        $pos_id = $request->pos_value;
        // foreach ($pos_id as $value) {
        //     if ($value == 1) {
        //         $hasOnes = true;
        //     } else {
        //         $hastwo = true;
        //     }
        // }
        // $hasOnes = false;
        // $hasTwos = false;
        // $hasThrees = false;
        // $hasFours = false;
        // $hasFive = false;
        // $otherThanOnes = false;

        // foreach ($pos_id as $value) {
        //     if ($value == 1) {
        //         $hasOnes = true;
        //     }
        //     if ($value == 2) {
        //         $hasTwos = true;
        //     }
        //     if ($value == 3) {
        //         $hasThrees = true;
        //     }
        //     if ($value == 4) {
        //         $hasFours = true;
        //     }
        //     if ($value == 5) {
        //         $hasFive = true;
        //     }
        //     if ($value != 1) {
        //         $otherThanOnes = true;
        //     }
        // }

        // if ($hasOnes && !$hasTwos && !$hasThrees && !$hasFours &&  $ass == 2) {
        //     //dd('staff because all value is one and staff value is two');
        //     $billId = Session::get('uuid');
        //     $order = Order::where('bill_id', '=', $billId)->first();
        //     $bill = Bill::find($billId);

        //     $bill->assign_for = $user_id;
        //     $bill->status = 1;

        //     $bill->user_id = $ass;
        //     $order->comments = $request->textarea;

        //     $order->save();
        //     $bill->save();
        //     Session::pull('uuid');

        //     Alert::success('Product Added Successfully', 'The product has been successfully assigned.');
        //     return redirect()->route('admin.dashbord');
        // } elseif ($hasOnes && $otherThanOnes && $ass != 2) {
        //     //dd('Not allowed');
        //     Alert::error('Product Assignment Error', 'You are not allowed to assign this product to the selected user.');
        //     return redirect()->back();
        // } elseif ($hasTwos && $ass == 3) {
        //     //dd('faculty because no staff or empoly or management product is not assign');
        //     $billId = Session::get('uuid');
        //     $order = Order::where('bill_id', '=', $billId)->first();
        //     $bill = Bill::find($billId);

        //     $bill->assign_for = $user_id;
        //     $bill->status = 1;

        //     $bill->user_id = $ass;
        //     $order->comments = $request->textarea;

        //     $order->save();
        //     $bill->save();
        //     Session::pull('uuid');
        //     Alert::success('Product Added Successfully', 'The product has been successfully assigned.');
        //     return redirect()->route('admin.dashbord');
        // } elseif ($hasThrees && $ass == 4) {
        //     //dd('empoly because no staff or faculty or management product is not assign');
        //     $billId = Session::get('uuid');
        //     $order = Order::where('bill_id', '=', $billId)->first();
        //     $bill = Bill::find($billId);

        //     $bill->assign_for = $user_id;
        //     $bill->status = 1;

        //     $bill->user_id = $ass;
        //     $order->comments = $request->textarea;

        //     $order->save();
        //     $bill->save();
        //     Session::pull('uuid');
        //     Alert::success('Product Added Successfully', 'The product has been successfully assigned.');
        //     return redirect()->route('admin.dashbord');
        // } elseif ($hasFours &&  $ass == 5) {
        //     //dd('management because no staff or empoly or faculty product is not assign');
        //     $billId = Session::get('uuid');
        //     $order = Order::where('bill_id', '=', $billId)->first();
        //     $bill = Bill::find($billId);

        //     $bill->assign_for = $user_id;
        //     $bill->status = 1;

        //     $bill->user_id = $ass;
        //     $order->comments = $request->textarea;

        //     $order->save();
        //     $bill->save();
        //     Session::pull('uuid');
        //     Alert::success('Product Added Successfully', 'The product has been successfully assigned.');
        //     return redirect()->route('admin.dashbord');
        // } else {
        //     //dd('your add order data contain staff product or you want to store product for staff that product doesn\'t alowed for staff');
        //     Alert::error('Product Assignment Error', 'You are not allowed to assign this product to the selected user.');
        //     return redirect()->back();
        // }





        $hasOnes = false;
        $hasTwos = false;
        $otherThanOnes = false;

        foreach ($pos_id as $value) {
            if ($value == 1) {
                $hasOnes = true;
            }
            if ($value == 2) {
                $hasTwos = true;
            }
            if ($value != 1) {
                $otherThanOnes = true;
            }
        }

        if ($hasOnes && !$hasTwos && $ass == 2) {
            //dd('staff because all value is one and staff value is two');
            $billId = Session::get('uuid');
            $order = Order::where('bill_id', '=', $billId)->first();
            $bill = Bill::find($billId);

            $bill->assign_for = $user_id;
            $bill->status = 1;

            $bill->user_id = $ass;
            $order->comments = $request->textarea;

            $order->save();
            $bill->save();
            Session::pull('uuid');

            Alert::success('Product Added Successfully', 'The product has been successfully assigned.');
            return redirect()->route('admin.dashbord');
        } elseif ($hasOnes && $otherThanOnes && $ass != 2) {
            // dd('at lest one value is 1 and staff value is not 2');
            Alert::error('Product Assignment Error', 'You are not allowed to assign this product to the selected user.');
            return redirect()->back();
        } elseif (!$hasOnes && ($ass == 3 || $ass == 4 || $ass == 5)) {
            //dd('1 value is none and ass value 3 or 4');
            $billId = Session::get('uuid');
            $order = Order::where('bill_id', '=', $billId)->first();
            $bill = Bill::find($billId);

            $bill->assign_for = $user_id;
            $bill->status = 1;

            $bill->user_id = $ass;
            $order->comments = $request->textarea;

            $order->save();
            $bill->save();
            Session::pull('uuid');

            Alert::success('Product Added Successfully', 'The product has been successfully assigned.');
            return redirect()->route('admin.dashbord');
        } else {
            //dd('your add order data contain staff product or you want to store product for staff that product doesn\'t alowed for staff');
            Alert::error('Product Assignment Error', 'You are not allowed to assign this product to the selected user.');
            return redirect()->back();
        }









        // if ($hasOnes   && $ass == 2) {
        //     dd('okeyone');
        //     $billId = Session::get('uuid');
        //     $order = Order::where('bill_id', '=', $billId)->first();
        //     $bill = Bill::find($billId);

        //     $bill->assign_for = $user_id;
        //     $bill->status = 1;

        //     $bill->user_id = $ass;
        //     $order->comments = $request->textarea;

        //     $order->save();
        //     $bill->save();
        //     Session::pull('uuid');

        //     Alert::success('Product Added Successfully', 'The product has been successfully assigned.');
        //     return redirect()->route('admin.dashbord');
        // } elseif ($hastwo && ($ass == 3 || $ass == 4)) {
        //     dd("okeytwo");
        //     $billId = Session::get('uuid');
        //     $order = Order::where('bill_id', '=', $billId)->first();
        //     $bill = Bill::find($billId);

        //     $bill->assign_for = $user_id;
        //     $bill->status = 1;

        //     $bill->user_id = $ass;
        //     $order->comments = $request->textarea;

        //     $order->save();
        //     $bill->save();
        //     Session::pull('uuid');

        //     Alert::success('Product Added Successfully', 'The product has been successfully assigned.');
        //     return redirect()->route('admin.dashbord');
        // } else {
        //     dd('not alowed');
        //     Alert::error('Product Assignment Error', 'You are not allowed to assign this product to the selected user.');
        //     return redirect()->back();
        // }
        // dd('not allowed');
        // $roleId = Product::where('role_id', $ass)->value('role_id');

        // if ($pos_id == 1 && $ass == 2) {

        //     $billId = Session::get('uuid');
        //     $order = Order::where('bill_id', '=', $billId)->first();
        //     $bill = Bill::find($billId);

        //     $bill->assign_for = $user_id;
        //     $bill->status = 1;

        //     $bill->user_id = $ass;
        //     $order->comments = $request->textarea;

        //     $order->save();
        //     $bill->save();
        //     Session::pull('uuid');

        //     Alert::success('Product Added Successfully', 'The product has been successfully assigned.');
        //     return redirect()->route('admin.dashbord');
        // }
        // if ($pos_id != 1  && $ass >= 3) {
        //     $billId = Session::get('uuid');
        //     $order = Order::where('bill_id', '=', $billId)->first();
        //     $bill = Bill::find($billId);

        //     $bill->assign_for = $user_id;
        //     $bill->status = 1;

        //     $bill->user_id = $ass;
        //     $order->comments = $request->textarea;

        //     $order->save();
        //     $bill->save();
        //     Session::pull('uuid');

        //     Alert::success('Product Added Successfully', 'The product has been successfully assigned.');
        //     return redirect()->route('admin.dashbord');
        // } else {
        //     Alert::error('Product Assignment Error', 'You are not allowed to assign this product to the selected user.');
        //     return redirect()->back();
        // }


        // $billId = Session::get('uuid');
        // $order = Order::where('bill_id', '=', $billId)->first();
        // $bill = Bill::find($billId);

        // $bill->assign_for = $user_id;
        // $bill->status = 1;

        // $bill->user_id = $ass;
        // $order->comments = $request->textarea;

        // $order->save();
        // $bill->save();
        // Session::pull('uuid');

        // Alert::success('Product Added Successfully', 'The product has been successfully assigned.');
        // return redirect()->route('admin.dashbord');
    }


    public function Order_pending()
    {
        $data = array();
        if (Session::has('loginIdAdmin')) {
            $data = User::where('id', '=', Session::get('loginIdAdmin'))->first();
        }
        $user_id = Session::get('loginIdAdmin');
        $user = User::where('id', $user_id)->first();
        $orders_pending_billTable = Order::where('status', '=', 0)->get();
        return view('Admin.pages.pending_order', compact('orders_pending_billTable', 'data', 'user'));
    }

    public function order_details(Request $request)
    {
        $data = array();
        if (Session::has('loginIdAdmin')) {
            $data = User::where('id', '=', Session::get('loginIdAdmin'))->first();
        }
        $user_id = Session::get('loginIdAdmin');
        $user = User::where('id', $user_id)->first();

        $orderId = $request->input('orderId');
        $orders = Order::where('bill_id', '=', $orderId)->get();
        $bill = Bill::where('id', '=', $orderId)->get();
        return view('Admin.pages.order_details', compact('orders', 'bill', 'data', 'user'));
    }
    public function order_approve(Request $request)
    {

        $order = Order::find($request->approve_id);

        $bil_id = $order->bill_id;

        $product_id = $order->product->id;
        $productId = Product::find($product_id);
        $sum = $productId->quantity;
        $billUpdate = Bill::find($bil_id);


        $order2 = Order::where('bill_id', $bil_id)->get();

        $pendingCount = $order2->where('status', 0)->count();

        if ($request->quantity >= $sum) {
            return response()->json(['message' => 'Stock out']);
        } else {
            $newQuantity = $sum - $request->quantity;

            $order->status = 1;
            $order->quantity = $request->quantity;
            $order->save();

            if ($pendingCount <= 1) {
                $billUpdate->status = 2;
                $billUpdate->save();
            } else {
                $billUpdate->status = 1;
                $billUpdate->save();
            }
            $productId->quantity = $newQuantity;
            $productId->save();

            // $billUpdate->status = 2;
            $billUpdate->touch();
            // $billUpdate->save();

            return response()->json(['message' => 'Success']);
            // return redirect()->back();
            return redirect()->to(URL::previous());
        }

        return redirect()->back();
    }

    public function order_reject(Request $request)
    {
        $order = Order::find($request->approve_id);
        $bil_id = $order->bill_id;
        $billUpdate = Bill::find($bil_id);

        $order2 = Order::where('bill_id', $bil_id)->get();

        $pendingCount = $order2->where('status', 0)->count();
        $order->status = 2;

        // $order->quantity=$request->quantity;
        $order->touch();
        $order->save();


        if ($pendingCount <= 1) {
            $billUpdate->status = 3;
            $billUpdate->save();
        } else {
            $billUpdate->status = 1;
            $billUpdate->save();
        }

        // $billUpdate->status = 3;
        $billUpdate->touch();
        // $billUpdate->save();
        return response()->json(['message' => 'Success']);
        // return redirect()->back();
        return redirect()->to(URL::previous());
    }

    public function initial_orderlist(Request $request)
    {
        $query = $request->input('query');

        $bills = Bill::where('id', 'like', '%' . $query . '%')
            ->orWhereHas('user', function ($q) use ($query) {
                $q->where('full_name', 'like', '%' . $query . '%');
            })
            ->orWhereHas('user.role', function ($q) use ($query) {
                $q->where('role_name', 'like', '%' . $query . '%');
            })
            ->orWhereDate('created_at', 'like', '%' . $query . '%')
            ->orWhere('status', 'like', '%' . $query . '%')
            ->get();
        $tableHtml = '<div class="card">';
        $tableHtml .= '<h5 class="card-header">Orders</h5>';
        $tableHtml .= '<div class="table-responsive text-nowrap">';
        $tableHtml .= '<table class="table">';
        $tableHtml .= '<thead>';
        $tableHtml .= '<tr>';
        $tableHtml .= '<th>Order ID</th>';
        $tableHtml .= '<th>Name</th>';
        $tableHtml .= '<th>Designation</th>';
        $tableHtml .= '<th>Order Date</th>';
        $tableHtml .= '<th>Status</th>';
        $tableHtml .= '<th>Actions</th>';
        $tableHtml .= '</tr>';
        $tableHtml .= '</thead>';
        $tableHtml .= '<tbody class="table-border-bottom-0">';

        foreach ($bills as $bill) {
            if ($bill->user_id) {
                $tableHtml .= '<tr>';
                $tableHtml .= '<td>' . $bill->id . '</td>';
                $tableHtml .= '<td>' . $bill->user->full_name . '</td>';
                $tableHtml .= '<td>' . $bill->user->role->role_name . '</td>';
                $tableHtml .= '<td>Date: ' . $bill->created_at->format('Y-m-d') . '<br>';
                $tableHtml .= 'Time: ' . date('h:i:s A', strtotime($bill->created_at)) . '</td>';
                if ($bill->status === '1') {
                    $tableHtml .= '<td class="text-danger">Pendding</td>';
                } elseif ($bill->status === '2') {
                    $tableHtml .= '<td class="text-success">Approved</td>';
                } else {
                    $tableHtml .= '<td class="text-warning">Rejected</td>';
                }
                $tableHtml .= '<td class="d-flex">';
                $tableHtml .= '<a href="' . route('orders.details', ['orderId' => $bill->id]) . '"><i class="bx bxs-show me-1 bg-warning p-2 rounded-2 text-white"></i></a>';
                // $tableHtml .= '<a href="#"><i class="bx bx-edit-alt me-1 bg-success p-2 rounded-2 text-white"></i></a>';
                $tableHtml .= '<a href="#"><i class="bx bx-trash me-1 bg-danger p-2 rounded-2 text-white"></i></a>';
                $tableHtml .= '</td>';
                $tableHtml .= '</tr>';
            }
        }

        $tableHtml .= '</tbody>';
        $tableHtml .= '</table>';
        $tableHtml .= '</div>';
        $tableHtml .= '</div>';
        return $tableHtml;
        // return view('your_view_name', ['bills' => $results]);
    }

    public function crendial_search(Request $request)
    {
        $status = $request->input('status');
        if ($status === '0') {
            // If status is 0, fetch all bills without considering status
            $bills = Bill::orderBy('created_at', 'desc')->get();
        } else {
            // If status is not 0, fetch bills with matching status
            $bills = Bill::orderBy('created_at', 'desc')->where('status', $status)->get();
        }

        $tableHtml = '<div class="card">';
        $tableHtml .= '<h5 class="card-header">Orders</h5>';
        $tableHtml .= '<div class="table-responsive text-nowrap">';
        $tableHtml .= '<table class="table">';
        $tableHtml .= '<thead>';
        $tableHtml .= '<tr>';
        $tableHtml .= '<th>Order ID</th>';
        $tableHtml .= '<th>Name</th>';
        $tableHtml .= '<th>Designation</th>';
        $tableHtml .= '<th>Order Date</th>';
        $tableHtml .= '<th>Status</th>';
        $tableHtml .= '<th>Actions</th>';
        $tableHtml .= '</tr>';
        $tableHtml .= '</thead>';
        $tableHtml .= '<tbody class="table-border-bottom-0">';

        foreach ($bills as $bill) {
            if ($bill->user_id) {
                $tableHtml .= '<tr>';
                $tableHtml .= '<td>' . $bill->id . '</td>';
                $tableHtml .= '<td>' . $bill->user->full_name . '</td>';
                $tableHtml .= '<td>' . $bill->user->role->role_name . '</td>';
                $tableHtml .= '<td>Date: ' . $bill->created_at->format('Y-m-d') . '<br>';
                $tableHtml .= 'Time: ' . date('h:i:s A', strtotime($bill->created_at)) . '</td>';
                if ($bill->status === '1') {
                    $tableHtml .= '<td class="text-danger">Pending</td>';
                } elseif ($bill->status === '2') {
                    $tableHtml .= '<td class="text-success">Approved</td>';
                } else {
                    $tableHtml .= '<td class="text-warning">Rejected</td>';
                }
                $tableHtml .= '<td class="d-flex">';
                $tableHtml .= '<a href="' . route('orders.details', ['orderId' => $bill->id]) . '"><i class="bx bxs-show me-1 bg-warning p-2 rounded-2 text-white"></i></a>';
                // $tableHtml .= '<a href="#"><i class="bx bx-edit-alt me-1 bg-success p-2 rounded-2 text-white"></i></a>';
                $tableHtml .= '<a href="#"><i class="bx bx-trash me-1 bg-danger p-2 rounded-2 text-white"></i></a>';
                $tableHtml .= '</td>';
                $tableHtml .= '</tr>';
            }
        }

        $tableHtml .= '</tbody>';
        $tableHtml .= '</table>';
        $tableHtml .= '</div>';
        $tableHtml .= '</div>';
        return $tableHtml;
    }
}
