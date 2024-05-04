@extends('Admin.layout.master')
@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">


            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Report /</span> Order Report</h4>

            <div class="d-flex mb-3 gap-2">

                <div class="mb-3 col-md-2">
                    <label for="organization" class="form-label">Filter By Username</label>
                    <select class="form-select" id="organization" name="organization" aria-label="Default select example">
                        <option selected>Select Username</option>
                        @foreach ($users as $userr)
                            <option value="{{ $userr->id }}">{{ $userr->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 col-md-2">
                    <label for="organization" class="form-label">Filter By Product Name</label>
                    <select class="form-select" id="product" name="organization" aria-label="Default select example">
                        <option selected>Select Product</option>
                        @foreach ($products as $key => $product)
                            <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 col-md-2">
                    <label for="organization" class="form-label">Filter By Product Category</label>
                    <select class="form-select" id="category" name="organization" aria-label="Default select example">
                        <option selected>Select Category</option>
                        @foreach ($categories as $key => $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 col-md-2">
                    <label for="organization" class="form-label">Filter By Designation</label>
                    <select class="form-select" id="designation" name="organization" aria-label="Default select example">
                        <option selected value="0">Select Designation</option>
                        @foreach ($roles as $key => $role)
                            <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 col-md-2">
                    <label for="organization" class="form-label">Filter By Order Status</label>
                    <select class="form-select" id="orderStatus" name="orderStatus" aria-label="Default select example">
                        <option selected>Select Order Status</option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select>
                </div>
                <div class="mb-3 col-md-2">
                    <a href="{{ route('admin.Orderexport') }}" class="btn btn-primary">Download Excel</a>
                </div>
            </div>



            <!-- Basic Bootstrap Table -->
            <div class="card">
                <h5 class="card-header">Ordered Products</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table" id="reportTable">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Product Name</th>
                                <th>Orderer Name</th>
                                <th>Designation</th>
                                {{-- <th>Order Date</th> --}}
                                <th>Quantity</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->bill_id }}</td>
                                    <td>{{ $order->product->product_name }}</td>
                                    <td>{{ $order->bill->user->full_name  }}</td>
                                    <td>{{ $order->bill->user->role->role_name  }}</td>
                                    {{-- <td>{{ $order->order_created_at  }}</td>  --}}
                                    <td>{{ $order->quantity }}</td>
                                    @if ($order->status === '0' || $order->status === null)
                                        <td><span class="badge bg-label-warning me-1">Pending</span></td>
                                    @elseif($order->status === '1')
                                        <td><span class="badge bg-label-success me-1">Appreved</span></td>
                                    @else
                                        <td><span class="badge bg-label-danger me-1">Rejected</span></td>
                                    @endif
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="{{ asset('Admin/js/oreder_report.js') }}"></script>
    </div>
@endSection
