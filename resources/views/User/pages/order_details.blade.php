@extends('User.layout.master')
@section('content')
    <div class="col-lg-8 mb-4 order-0 ">

        <!-- Content wrapper -->
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="{{ route('user.dashbord') }}"><i
                        class='bx bx-left-arrow-alt fs-4 mb-1 me-3'></i></a>Order /</span> Order Details</h4>
        <!-- Basic Bootstrap Table -->
        <div class="card p-4">
            <h4 class="">Order Details</h4>
            <h6 class="">BILL ID: {{ $bill[0]->id }}</h6>
            <br>
            <span class="d-block fs-5">Orderer Name: {{ $bill[0]->user->full_name }}</span>
            <span class="d-block fs-5">Designation: {{ $bill[0]->user->role->role_name }}</span>
            <span class="d-block fs-5">Order Date: {{ $bill[0]->created_at }}</span>
            <br>



            <div class="table-responsive text-nowrap">
                <table class="table" id="orderTable">
                    <thead>

                        <tr>
                            <th>Product Name</th>
                            <th>Product Category</th>
                            <th>Quantity</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->product->product_name }}</td>
                                <td>{{ $order->product->category->category_name }}</td>
                                <td>{{ $order->quantity }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if ($order->status == 0)
                                            <span class="badge bg-label-danger">Pending</span>
                                        @elseif($order->status == 1)
                                            <span class="badge bg-label-success">Approved</span>
                                        @elseif($order->status == 2)
                                            <span class="badge bg-label-danger">Rejected</span>
                                        @elseif($order->status == 3)
                                            <span class="badge bg-label-success">Received</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if ($order->status == 0)
                                            <span class="badge bg-label-danger">waiting for <br> <br> admin approved</span>
                                        @elseif($order->status == 1)
                                            {{-- <span class="badge bg-label-success">Approved</span> --}}
                                            <a href="{{ route('user.productreceived', ['orderId' => $order->id]) }}">
                                                <i class="bx bx-check me-1 bg-success p-2 rounded-2 text-white"></i></a>
                                        @elseif($order->status == 2)
                                            <span class="badge bg-label-danger">product rejected by admin</span>
                                        @elseif($order->status == 3)
                                            <span class="badge bg-label-danger">you have no action</span>
                                        @endif
                                    </div>
                                    {{-- <a href="{{ route('user.productreceived', ['orderId' => $order->id]) }}">
                                        <i class="bx bx-check me-1 bg-success p-2 rounded-2 text-white"></i>
                                    </a> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <textarea class="form-control mt-4" name="" id="" cols="30" rows="3" readonly>{{ $orders[0]->comments }}</textarea>
        </div>


    </div>
@endSection
