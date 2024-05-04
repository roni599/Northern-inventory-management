<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Procurement;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use App\Exports\OrderExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class OrderreportController extends Controller
{
    public function report()
    {
        $data = array();
        if (Session::has('loginIdAdmin')) {
            $data = User::where('id', '=', Session::get('loginIdAdmin'))->first();
        }
        $user_id = Session::get('loginIdAdmin');
        $user = User::where('id', $user_id)->first();
        $users = User::all();
        $products = Product::all();
        $categories = Category::all();
        $roles = Role::all();
        $orders = Order::all();
        return view('Admin.pages.ordered_productlist', compact('orders', 'users', 'products', 'categories', 'roles', 'data', 'user'));
    }
    public function searchStatus(Request $request)
    {
        $userId = $request->input('userId');

        $data = Order::where('status', $userId)->get();

        $tableHtml = '<table class="table" id="reportTable">';
        $tableHtml .= '<thead>';
        $tableHtml .= '<tr>';
        $tableHtml .= '<th>Order ID</th>';
        $tableHtml .= '<th>Product Name</th>';
        $tableHtml .= '<th>Orderer Name</th>';
        $tableHtml .= '<th>Designation</th>';
        $tableHtml .= '<th>Order Date</th>';
        $tableHtml .= '<th>Quantity</th>';
        $tableHtml .= '<th>Status</th>';
        $tableHtml .= '</tr>';
        $tableHtml .= '</thead>';
        $tableHtml .= '<tbody class="table-border-bottom-0">';
        if (count($data) == 0) {
            $tableHtml .= '<tr><td colspan="7" class="text-center">No data found</td></tr>';
        } else {
            foreach ($data as $order) {
                $statusText = $order->status === '1' ? 'Approved' : ($order->status === '0' ? 'Pending' : 'Reject');
                $tableHtml .= '<tr>';
                $tableHtml .= '<td>' . $order->bill_id . '</td>';
                $tableHtml .= '<td>' . $order->product->product_name . '</td>';
                $tableHtml .= '<td>' . $order->product->role->user->full_name . '</td>';
                $tableHtml .= '<td>' . $order->product->role->role_name . '</td>';
                $tableHtml .= '<td>' . $order->created_at . '</td>';
                $tableHtml .= '<td>' . $order->quantity . '</td>';
                $tableHtml .= '<td><span class="badge bg-label-success me-1">' . $statusText . '</span></td>';
                $tableHtml .= '</tr>';
            }
        }

        $tableHtml .= '</tbody>';
        $tableHtml .= '</table>';
        return $tableHtml;
    }
    public function searchUsers(Request $request)
    {
        $userId = $request->input('userId');
        $user = Order::join('bills', 'orders.bill_id', '=', 'bills.id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->join('users', 'bills.user_id', '=', 'users.id')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('organizations', 'users.organization_id', '=', 'organizations.id')
            ->where('users.id', $userId)
            ->select(
                'orders.*',
                'orders.quantity as order_quantity',
                'orders.created_at as order_created_at',
                'orders.status as orders_status',
                'bills.status as bill_status',
                'products.*',
                'users.*',
                'roles.*',
                'categories.*',
                'organizations.*'
            )
            ->get();

        $tableHtml = '<table class="table" id="reportTable">';
        $tableHtml .= '<thead>';
        $tableHtml .= '<tr>';
        $tableHtml .= '<th>Order ID</th>';
        $tableHtml .= '<th>Product Name</th>';
        $tableHtml .= '<th>Orderer Name</th>';
        $tableHtml .= '<th>Designation</th>';
        $tableHtml .= '<th>Order Date</th>';
        $tableHtml .= '<th>Quantity</th>';
        $tableHtml .= '<th>Status</th>';
        $tableHtml .= '</tr>';
        $tableHtml .= '</thead>';
        $tableHtml .= '<tbody class="table-border-bottom-0">';
        if (count($user) == 0) {
            $tableHtml .= '<tr><td colspan="7" class="text-center">No data found</td></tr>';
        } else {
            foreach ($user as $order) {
                $statusText = $order->orders_status === '1' ? 'Approved' : ($order->orders_status == 0 ? 'Pending' : 'Reject');
                $tableHtml .= '<tr>';
                $tableHtml .= '<td>' . $order->bill_id . '</td>';
                $tableHtml .= '<td>' . $order->product_name . '</td>';
                $tableHtml .= '<td>' . $order->full_name . '</td>';
                $tableHtml .= '<td>' . $order->role_name . '</td>';
                $tableHtml .= '<td>' . $order->order_created_at . '</td>';
                $tableHtml .= '<td>' . $order->order_quantity  . '</td>';
                $tableHtml .= '<td><span class="badge bg-label-success me-1">' . $statusText . '</span></td>';
                $tableHtml .= '</tr>';
            }
        }
        $tableHtml .= '</tbody>';
        $tableHtml .= '</table>';
        return $tableHtml;
    }

    public function searchCategory(Request $request)
    {
        $userId = $request->input('userId');

        $user = Order::join('bills', 'orders.bill_id', '=', 'bills.id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->join('users', 'bills.user_id', '=', 'users.id')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('categories.id', $userId)
            ->select('orders.*', 'bills.status as bill_status', 'products.*', 'users.*', 'roles.*', 'orders.created_at', 'categories.*', 'orders.created_at')
            ->get();


        $tableHtml = '<table class="table" id="reportTable">';
        $tableHtml .= '<thead>';
        $tableHtml .= '<tr>';
        $tableHtml .= '<th>Order ID</th>';
        $tableHtml .= '<th>Product Name</th>';
        $tableHtml .= '<th>Orderer Name</th>';
        $tableHtml .= '<th>Designation</th>';
        $tableHtml .= '<th>Order Date</th>';
        $tableHtml .= '<th>Quantity</th>';
        $tableHtml .= '<th>Status</th>';
        $tableHtml .= '</tr>';
        $tableHtml .= '</thead>';
        $tableHtml .= '<tbody class="table-border-bottom-0">';

        if (count($user) == 0) {
            $tableHtml .= '<tr><td colspan="7" class="text-center">No data found</td></tr>';
        } else {
            foreach ($user as $order) {
                $statusText = $order->orders_status === '1' ? 'Approved' : ($order->orders_status === '0' ? 'Pending' : 'Reject');
                $tableHtml .= '<tr>';
                $tableHtml .= '<td>' . $order->bill_id . '</td>';
                $tableHtml .= '<td>' . $order->product->product_name . '</td>';
                $tableHtml .= '<td>' . $order->product->role->user->full_name .  '</td>';
                $tableHtml .= '<td>' . $order->product->role->role_name . '</td>';
                $tableHtml .= '<td>' . $order->created_at . '</td>';
                $tableHtml .= '<td>' . $order['quantity'] . '</td>';
                $tableHtml .= '<td><span class="badge bg-label-success me-1">' . $statusText . '</span></td>';
                $tableHtml .= '</tr>';
            }
        }

        $tableHtml .= '</tbody>';
        $tableHtml .= '</table>';

        return $tableHtml;
    }

    public function searchDesignation(Request $request)
    {
        $userId = $request->input('userId');
        $user = Order::join('bills', 'orders.bill_id', '=', 'bills.id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->join('users', 'bills.user_id', '=', 'users.id')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('organizations', 'users.organization_id', '=', 'organizations.id')

            ->where('roles.id', $userId)
            ->select(
                'orders.*',
                'orders.quantity as order_quantity',
                'orders.created_at as order_created_at',
                'bills.status as bill_status',
                'orders.status as order_status',
                'products.*',
                'users.*',
                'roles.*',
                'categories.*',
                'organizations.*'
            )
            ->get();
        $tableHtml = '<table class="table" id="reportTable">';
        $tableHtml .= '<thead>';
        $tableHtml .= '<tr>';
        $tableHtml .= '<th>Order ID</th>';
        $tableHtml .= '<th>Product Name</th>';
        $tableHtml .= '<th>Orderer Name</th>';
        $tableHtml .= '<th>Designation</th>';
        $tableHtml .= '<th>Order Date</th>';
        $tableHtml .= '<th>Quantity</th>';
        $tableHtml .= '<th>Status</th>';
        $tableHtml .= '</tr>';
        $tableHtml .= '</thead>';
        $tableHtml .= '<tbody class="table-border-bottom-0">';
        if (count($user) == 0) {
            $tableHtml .= '<tr><td colspan="7" class="text-center">No data found</td></tr>';
        } else {
            foreach ($user as $order) {
                $statusText = $order->orders_status === '1' ? 'Approved' : ($order->orders_status === '0' ? 'Pending' : 'Reject');
                $tableHtml .= '<tr>';
                $tableHtml .= '<td>' . $order->bill_id . '</td>';
                $tableHtml .= '<td>' . $order->product_name . '</td>';
                $tableHtml .= '<td>' . $order->full_name . '</td>';
                $tableHtml .= '<td>' . $order->role_name . '</td>';
                $tableHtml .= '<td>' . $order->order_created_at . '</td>';
                $tableHtml .= '<td>' . $order->order_quantity . '</td>';
                $tableHtml .= '<td><span class="badge bg-label-success me-1">' . $statusText . '</span></td>';
                $tableHtml .= '</tr>';
            }
        }

        $tableHtml .= '</tbody>';
        $tableHtml .= '</table>';


        return $tableHtml;
    }
    public function procurement_report()
    {
        $data = array();
        if (Session::has('loginIdAdmin')) {
            $data = User::where('id', '=', Session::get('loginIdAdmin'))->first();
        }
        $user_id = Session::get('loginIdAdmin');
        $user = User::where('id', $user_id)->first();
        $products = Procurement::all();
        $productt = Product::all();
        return view('Admin.pages.procurement_report', compact('productt', 'products', 'data', 'user'));
    }
    public function search_procurement_report(Request $request)
    {
        $selectedValue = $request->input('selectedValue');
        $products = Procurement::join('products', 'procurements.product_id', '=', 'products.id')
            ->where('products.product_name', 'like', '%' . $selectedValue . '%')
            ->get(['procurements.*']);

        $tableHtml = '<div class="table-responsive text-nowrap">';
        $tableHtml .= '<table class="table" id="procurementTable">';
        $tableHtml .= '<thead>';
        $tableHtml .= '<tr>';
        $tableHtml .= '<th>Procurement ID</th>';
        $tableHtml .= '<th>Product Name</th>';
        $tableHtml .= '<th>Quantity</th>';
        $tableHtml .= '<th>UNIT PRICE</th>';
        $tableHtml .= '<th>Price</th>';
        $tableHtml .= '<th>Status</th>';
        $tableHtml .= '</tr>';
        $tableHtml .= '</thead>';
        $tableHtml .= '<tbody class="table-border-bottom-0">';
        foreach ($products as $product) {
            $tableHtml .= '<tr>';
            $tableHtml .= '<td>' . $product->id . '</td>';
            $tableHtml .= '<td>' . $product->product->product_name . '</td>';
            $tableHtml .= '<td>' . $product->quantity . '</td>';
            $tableHtml .= '<td>' . $product->unit_price . '</td>';
            $tableHtml .= '<td>' . $product->price . '</td>';

            $tableHtml .= '<td>';
            if ($product->status === '0' || $product->status === null) {
                $tableHtml .= '<span class="badge bg-label-success me-1">Available</span>';
            } else {
                $tableHtml .= '<span class="badge bg-label-danger me-1">Not Available</span>';
            }
            $tableHtml .= '</td>';
            $tableHtml .= '<td class="d-flex">';
            $tableHtml .= '</td>';
            $tableHtml .= '</tr>';
        }
        $tableHtml .= '</tbody>';
        $tableHtml .= '</table>';
        $tableHtml .= '</div>';
        return $tableHtml;
    }

    public function daysprocurement_report(Request $request)
    {
        $selectedValue = $request->input('selected_value');
        $today = Carbon::now();
        $lastWeek = $today->copy()->subDays(7);
        $last30Days = $today->copy()->subDays(30);
        if ($selectedValue == 0) {
            $products = Procurement::all();
        } elseif ($selectedValue == 1) {
            $products = Procurement::whereDate('created_at', $today)->get();
        } elseif ($selectedValue == 2) {
            $products = Procurement::whereBetween('created_at', [$lastWeek->startOfDay(), $today->endOfDay()])->get();
        } elseif ($selectedValue == 3) {
            $products = Procurement::whereDate('created_at', '>=', $last30Days)->get();
        }
        $tableHtml = '<div class="table-responsive text-nowrap">';
        $tableHtml .= '<table class="table" id="procurementTable">';
        $tableHtml .= '<thead>';
        $tableHtml .= '<tr>';
        $tableHtml .= '<th>Procurement ID</th>';
        $tableHtml .= '<th>Product Name</th>';
        $tableHtml .= '<th>Quantity</th>';
        $tableHtml .= '<th>Price</th>';
        $tableHtml .= '<th>Status</th>';
        $tableHtml .= '</tr>';
        $tableHtml .= '</thead>';
        $tableHtml .= '<tbody class="table-border-bottom-0">';
        foreach ($products as $product) {
            $tableHtml .= '<tr>';
            $tableHtml .= '<td>' . $product->id . '</td>';
            $tableHtml .= '<td>' . $product->product->product_name . '</td>';
            $tableHtml .= '<td>' . $product->quantity . '</td>';
            $tableHtml .= '<td>' . $product->price  . '</td>';
            $tableHtml .= '<td>';
            if ($product->status === '0' || $product->status === null) {
                $tableHtml .= '<span class="badge bg-label-success me-1">Available</span>';
            } else {
                $tableHtml .= '<span class="badge bg-label-danger me-1">Not Available</span>';
            }
            $tableHtml .= '</td>';
            $tableHtml .= '<td class="d-flex">';
            $tableHtml .= '</td>';
            $tableHtml .= '</tr>';
        }
        $tableHtml .= '</tbody>';
        $tableHtml .= '</table>';
        $tableHtml .= '</div>';
        return $tableHtml;
    }
    public function Orderexport()
    {
        return Excel::download(new OrderExport(), 'OrderReport.xlsx');
    }

    public function searchProduct(Request $request)
    {
        $userId = $request->input('userId');
        $user = Order::join('bills', 'orders.bill_id', '=', 'bills.id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->join('users', 'bills.user_id', '=', 'users.id')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('organizations', 'users.organization_id', '=', 'organizations.id')
            ->where('products.id', $userId)
            ->select(
                'orders.*',
                'orders.quantity as order_quantity',
                'orders.created_at as order_created_at',
                'bills.status as bill_status',
                'orders.status as order_status',
                'products.*',
                'users.*',
                'roles.*',
                'categories.*',
                'organizations.*'
            )
            ->get();

        $tableHtml = '<table class="table" id="reportTable">';
        $tableHtml .= '<thead>';
        $tableHtml .= '<tr>';
        $tableHtml .= '<th>Order ID</th>';
        $tableHtml .= '<th>Product Name</th>';
        $tableHtml .= '<th>Orderer Name</th>';
        $tableHtml .= '<th>Designation</th>';
        $tableHtml .= '<th>Order Date</th>';
        $tableHtml .= '<th>Quantity</th>';
        $tableHtml .= '<th>Status</th>';
        $tableHtml .= '</tr>';
        $tableHtml .= '</thead>';
        $tableHtml .= '<tbody class="table-border-bottom-0">';
        if (count($user) == 0) {
            $tableHtml .= '<tr><td colspan="7" class="text-center">No data found</td></tr>';
        } else {
            foreach ($user as $order) {
                $statusText = $order->order_status === '0' ? 'Pending' : ($order->order_status === '1' ? 'Approved' : 'Rejected');

                $tableHtml .= '<tr>';
                $tableHtml .= '<td>' . $order->bill_id . '</td>';
                $tableHtml .= '<td>' . $order->product_name . '</td>';
                $tableHtml .= '<td>' . $order->full_name . '</td>';
                $tableHtml .= '<td>' . $order->role_name . '</td>';
                $tableHtml .= '<td>' . $order->order_created_at . '</td>';
                $tableHtml .= '<td>' . $order->order_quantity . '</td>';
                $tableHtml .= '<td><span class="badge bg-label-success me-1">' . $statusText . '</span></td>';
                $tableHtml .= '</tr>';
            }
        }

        $tableHtml .= '</tbody>';
        $tableHtml .= '</table>';

        return $tableHtml;
    }
}
