@extends('Admin.layout.master')
@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">


            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Order /</span> Pending Orders</h4>

            <div class="d-flex mb-3 gap-2">
                <input type="text" class="form-control w-50" placeholder="Search here.....">
                <button class="btn btn-primary">Search</button>
            </div>
            <!-- Basic Bootstrap Table -->
            <div class="card">
                <h5 class="card-header">Orders</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Order Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($orders_pending_billTable as $key =>$bill_pending)
                                <tr>
                                    <td>{{$bill_pending->id }}</td>
                                    <td>{{$bill_pending->bill->user->full_name }}</td>
                                    <td>{{$bill_pending->bill->user->role->role_name }}</td>
                                    <td>{{$bill_pending->created_at }}</td>
                                    @if ($bill_pending->status === '0')
                                        <td>
                                            <span class="badge bg-label-danger me-1">Pending</span>
                                        </td>
                                    @else
                                        <td>
                                            <span class="badge bg-label-success me-1">Approved</span>
                                        </td>
                                    @endif

                                    <td class="d-flex">
                                        <a href="{{ route('orders.details') }}"><i
                                                class="bx bxs-show me-1 bg-warning p-2 rounded-2 text-white"></i></a>
                                        <a href="#"><i
                                                class="bx bx-edit-alt me-1 bg-success p-2 rounded-2 text-white"></i></a>
                                        <a href="#"><i
                                                class="bx bx-trash me-1 bg-danger p-2 rounded-2 text-white"></i></a>
                                    </td>
                                </tr>
                            @endforeach



                        </tbody>
                    </table>
                </div>
            </div>
            <!--/ Basic Bootstrap Table -->

        </div>
        <!-- / Content -->


        <div class="content-backdrop fade"></div>

    </div>
@endSection
