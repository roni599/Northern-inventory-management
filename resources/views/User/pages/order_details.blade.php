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
                        </tr>
                    </thead>


                    <tbody class="table-border-bottom-0">
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->product->product_name }}</td>
                                <td>
                                    {{ $order->product->category->category_name }}
                                </td>
                                <td>{{ $order->quantity }}</td>

                                @if ($order->status == 0)
                                    <td class="badge bg-label-danger mt-2">Pending</td>
                                @elseif($order->status == 1)
                                    <td class="badge bg-label-success mt-2">Approved</td>
                                @elseif($order->status == 2)
                                <td class="badge bg-label-danger mt-2">Rejected</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <textarea class="form-control mt-4" name="" id="" cols="30" rows="3" readonly>{{ $orders[0]->comments }}</textarea>
        </div>


    </div>
@endSection
