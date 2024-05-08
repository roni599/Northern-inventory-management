@extends('Admin.layout.master')
@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">

            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Order /</span> Order List</h4>

            <div class="d-flex mb-3 gap-2">
                <form id="searchForm" class="d-flex align-items-center">
                    @csrf
                    <input type="text" name="designation" id="searchInput" class="form-control w-75"
                        placeholder="Search by Order id....">
                    <button type="submit" class="btn btn-primary ms-1">Search</button>
                </form>
                <a href="{{ route('admin.order_place') }}" class="btn btn-primary">New Order</a>

                {{-- <label for="organization" class="form-label">Filter By Date</label> --}}
                <select class="form-select w-25" id="credentials" name="procurement_report"
                    aria-label="Default select example">
                    <option selected value="0">Select Option</option>
                    <option value="1">Pending</option>
                    <option value="2">Approved</option>
                    <option value="3">Rejected</option>
                </select>
            </div>
            <!-- Basic Bootstrap Table -->
            <div class="card" id="orderlistTable">
                <h5 class="card-header">Orders</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table" id="">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Assigned By</th>
                                <th>Order Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody class="table-border-bottom-0">
                            @foreach ($bills as $key => $bill)
                                @if ($bill->assign_for >= '0')
                                    <tr>
                                        <td>{{ $bill->id }}</td>
                                        @if ($bill->user_id !== null)
                                            <td>{{ $bill->user->full_name }}</td>
                                        @else
                                            <td>User Deleted</td>
                                        @endif
                                        <td>{{ $bill->user->role->role_name }}</td>
                                        @if ($bill->assign_for == 1)
                                            <td>Admin</td>
                                        @else
                                            <td>User Myself</td>
                                        @endif
                                        <td>
                                            Date:
                                            {{ \Carbon\Carbon::parse($bill->created_at)->timezone('Asia/Dhaka')->format('Y-m-d') }}<br>
                                            Time:
                                            {{ \Carbon\Carbon::parse($bill->created_at)->timezone('Asia/Dhaka')->format('h:i:s A') }}
                                        </td>
                                        @if ($bill->status == 1)
                                            <td class="text-danger">Pendding</td>
                                        @elseif ($bill->status == 2)
                                            <td class="text-success">Approved</td>
                                        @elseif($bill->status == 3)
                                            <td class="text-warning">Rejected</td>
                                        @endif
                                        @if ($bill->user_id !== null)
                                            <td class="d-flex">
                                                <a href="{{ route('orders.details', ['orderId' => $bill->id]) }}"><i
                                                class="bx bxs-show me-1 bg-warning p-2 rounded-2 text-white"></i></a>
                                            </td>
                                        @else
                                            <td>You have no action</td>
                                        @endif
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!--/ Basic Bootstrap Table -->

        </div>
        <!-- / Content -->


        <div class="content-backdrop fade"></div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="{{ asset('Admin/js/order_approve.js') }}"></script>
    </div>
@endSection
