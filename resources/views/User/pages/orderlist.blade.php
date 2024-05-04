@extends('User.layout.master')
@section('content')
    <!-- Content wrapper -->
    <div class="col-lg-8 mb-4 order-0">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">


            <h4 class="fw-bold py-3 mb-4"><a href="{{ route('user.dashbord') }}"><i
                        class='bx bx-left-arrow-alt fs-4 mb-1 me-3'></i></a>
                Order List</h4>
            {{-- <div class="d-flex mb-3 gap-2">
                <input type="text" class="form-control w-50" placeholder="Search here.....">
                <button class="btn btn-primary">Search</button>
                <a href="/user/place_order" class="btn btn-primary">Place An Order</a>
            </div> --}}
            <div class="d-flex mb-3 gap-4">
                <form id="searchForm" class="d-flex align-items-center">
                    @csrf
                    <input type="text" name="query" id="searchInput" class="form-control w-75"
                        placeholder="Search by Order ID, Name, Designation, Date, or Status...">
                    <button type="submit" class="btn btn-primary ms-1">Search</button>
                </form>
                <a href="{{ route('user.place_order') }}" class="btn btn-primary">New Order</a>
            </div>
            <!-- Basic Bootstrap Table -->
            <div class="card">
                <h5 class="card-header">Orders</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table" id="orderTable">
                        <thead>

                            <tr>
                                <th>Order ID</th>
                                <th>Order Date</th>
                                <th>Status</th>
                                <th>Recit</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($bills as $key => $bill)
                                @if ($bill->user_id && $bill->status != 0)
                                    <tr>
                                        <td>{{ $bill->id }}</td>
                                        <td>
                                            Date : {{ $bill->created_at->format('Y-m-d') }}<br>
                                            Time : {{ $bill->created_at->format('H:i:s') }}
                                        </td>
                                        {{-- <td>{{ $bill->created_at }}</td> --}}
                                        {{-- <td>{{ $bill->status }}</td> --}}
                                        @if ($bill->status == 2)
                                            <td class="text-success">Approved</td>
                                        @elseif($bill->status == 1)
                                            <td class="text-danger">Pending</td>
                                        @endif
                                        <td class="d-flex">
                                            <a href="{{ route('user.order_details', ['orderId' => $bill->id]) }}"><i
                                                    class="bx bxs-show me-1 bg-warning p-2 rounded-2 text-white"></i></a>
                                            {{-- <a href="#"><i
                                                    class="bx bx-edit-alt me-1 bg-success p-2 rounded-2 text-white"></i></a>
                                            <a href="#"><i
                                                    class="bx bx-trash me-1 bg-danger p-2 rounded-2 text-white"></i></a> --}}
                                        </td>
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



    </div>
    <!-- / Content -->


    <div class="content-backdrop fade"></div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('Admin/js/usersearch.js') }}"></script>
    </div>
@endSection
