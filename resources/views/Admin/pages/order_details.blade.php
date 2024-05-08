@extends('Admin.layout.master')
@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">


            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Order /</span> Order Details</h4>

            <!-- Basic Bootstrap Table -->

            <div class="card p-4" id="orderdetailsDiv">
                @if ($bill->isnotEmpty())
                    <h4 class="">Order Details</h4>
                    <h6 class="">BILL ID: {{ $bill[0]->id }}</h6>
                    <br>
                    <span class="d-block fs-5">Orderer Name: {{ $bill[0]->user->full_name }}</span>
                    <span class="d-block fs-5">Designation: {{ $bill[0]->user->role->role_name }}</span>
                    <span class="d-block fs-5">Order Date: {{ $bill[0]->created_at->addDay()->setTimezone('Asia/Dhaka')->format('Y-m-d') }}<br>
                      <span class="d-block fs-5">Order Time: {{ $bill[0]->created_at->setTimezone('Asia/Dhaka')->format('h:i:s A') }}</span>                      
                @endif
                <br>
                @foreach ($orders as $key => $order)
                    <div class="card-body ">
                        <form id="approveForm" class="mb-4 approve approveForm" action="{{ route('orders.approve') }}"
                            method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="text" hidden name="approve_id" value="{{ $order->id }}">
                            <h5>Item {{ $key + 1 }}</h5>
                            <div class="row">
                                <div class="mb-3 col-md-2">
                                    <label for="firstName" class="form-label">Product Name</label>
                                    <input class="form-control" type="text" id="p_name" name="p_name"
                                        value="{{ $order->product->product_name }}" readonly />
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label for="p_category" class="form-label">Product Category</label>
                                    <input class="form-control" type="text" id="p_category" name="p_category"
                                        value="{{ $order->product->category ? $order->product->category->category_name : 'None' }}"
                                        readonly />
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label for="designation" class="form-label">Assigned For</label>
                                    <input class="form-control" type="text" id="designation" name="designation"
                                        value="{{ $order->product->role ? $order->product->role->role_name : 'None' }}"
                                        readonly />
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label for="quantity" class="form-label">Quantity</label>
                                    <input class="form-control" type="text" id="quantity" name="quantity"
                                        placeholder="eg. 50" value="{{ $order->quantity }}" />
                                </div>
                                {{-- <div class="mb-3 col-md-2">
                                    <label for="last_order_date" class="form-label">Last Order Date</label>
                                    <input class="form-control" type="text" id="last_order_date" name="last_order_date"
                                        value="{{ $order->created_at->format('F d, Y') }}" readonly />
                                </div> --}}
                                @if ($order->status === '0' || $order->status === null)
                                    <div class="mb-3 col-md-1">
                                        <label for="last_order_date" class="form-label">Status</label>
                                        <a href="#" class="badge bg-label-danger">Pending</a>
                                    </div>
                                @elseif($order->status === '1')
                                    <div class="mb-3 col-md-1">
                                        <label for="last_order_date" class="form-label">Status</label>
                                        <a href="#" class="badge bg-label-success">Approved</a>
                                    </div>
                                @elseif($order->status === '2')
                                    <div class="mb-3 col-md-1">
                                        <label for="last_order_date" class="form-label">Status</label>
                                        <a href="#" class="badge bg-label-danger">Rejected</a>
                                    </div>
                                @endif
                            </div>
                            @if ($order->status === '0' || $order->status === null)
                                <div class="mt-2">
                                    {{-- <button type="submit" id="approve2" class="btn btn-primary me-2">Approve</button>
                          <button type="submit" class="btn btn-danger me-2">Reject</button> --}}
                                    <button type="button" id="approveBtn"
                                        class="btn btn-primary approveBtn me-2">Approve</button>
                                    <button type="button" id="rejectBtn"
                                        class="btn btn-danger rejectBtn me-2">Reject</button>
                                </div>
                            @endif
                        </form>
                    </div>
                @endforeach
                @if ($bill->isnotEmpty())
                    <div class="form-group">
                        <label for="textarea">Comments</label>
                        <textarea class="form-control mt-0" name="" id="" cols="30" rows="3" readonly>{{ $orders[0]->comments }}</textarea>
                    </div>
                    @else
                @endif
            </div>

            {{-- <div class="card p-4">
                <h4 class="">Order Details</h4>
                <h6 class="">BILL ID: T243HJ</h6>
                <br>
                <span class="d-block fs-5">Orderer Name: Adnan</span>
                <span class="d-block fs-5">Designation: Faculty</span>
                <span class="d-block fs-5">Order Date: 22/03/2024</span>
                <br>


                <div class="card-body">



                      <form id="formAccountSettings" class="mb-4" method="POST" onsubmit="return false">
                        <h5>Item 1</h5>
                        <div class="row">
                          <div class="mb-3 col-md-2">
                            <label for="firstName" class="form-label">Product Name</label>
                            <input
                              class="form-control"
                              type="text"
                              id="p_name"
                              name="p_name"
                              value="Graph Paper"
                              readonly
                            />
                          </div>
                          <div class="mb-3 col-md-2">
                            <label for="p_category" class="form-label">Product Category</label>
                            <input
                              class="form-control"
                              type="text"
                              id="p_category"
                              name="p_category"
                              value="Equipment"
                              readonly
                            />
                          </div>
                          <div class="mb-3 col-md-2">
                            <label for="designation" class="form-label">Assigned For</label>
                            <input
                              class="form-control"
                              type="text"
                              id="designation"
                              name="designation"
                              value="Faculty"
                              readonly
                            />
                          </div>
                          <div class="mb-3 col-md-2">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input
                              class="form-control"
                              type="text"
                              id="quantity"
                              name="quantity"
                              placeholder="eg. 50"
                            />
                          </div>
                          <div class="mb-3 col-md-2">
                            <label for="last_order_date" class="form-label">Last Order Date</label>
                            <input
                              class="form-control"
                              type="text"
                              id="last_order_date"
                              name="last_order_date"
                              value="20/03/2024"
                              readonly
                            />
                          </div>
                          <div class="mb-3 col-md-1">
                          <label for="last_order_date" class="form-label">Status</label>
                            <a href="#" class="badge bg-label-danger">Pending</a>
                          </div>


                        </div>
                        <div class="mt-2">
                          <button type="submit" class="btn btn-primary me-2">Approve</button>
                          <button type="submit" class="btn btn-danger me-2">Reject</button>
                        </div>
                      </form>

                      <form id="formAccountSettings" class="mb-4" method="POST" onsubmit="return false">
                        <h5>Item 2</h5>
                        <div class="row">
                          <div class="mb-3 col-md-2">
                            <label for="firstName" class="form-label">Product Name</label>
                            <input
                              class="form-control"
                              type="text"
                              id="p_name"
                              name="p_name"
                              value="Graph Paper"
                              readonly
                            />
                          </div>
                          <div class="mb-3 col-md-2">
                            <label for="p_category" class="form-label">Product Category</label>
                            <input
                              class="form-control"
                              type="text"
                              id="p_category"
                              name="p_category"
                              value="Equipment"
                              readonly
                            />
                          </div>
                          <div class="mb-3 col-md-2">
                            <label for="designation" class="form-label">Assigned For</label>
                            <input
                              class="form-control"
                              type="text"
                              id="designation"
                              name="designation"
                              value="Faculty"
                              readonly
                            />
                          </div>
                          <div class="mb-3 col-md-2">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input
                              class="form-control"
                              type="text"
                              id="quantity"
                              name="quantity"
                              placeholder="eg. 50"
                            />
                          </div>
                          <div class="mb-3 col-md-2">
                            <label for="last_order_date" class="form-label">Last Order Date</label>
                            <input
                              class="form-control"
                              type="text"
                              id="last_order_date"
                              name="last_order_date"
                              value="20/03/2024"
                              readonly
                            />
                          </div>
                          <div class="mb-3 col-md-1">
                          <label for="last_order_date" class="form-label">Status</label>
                            <a href="#" class="badge bg-label-danger">Pending</a>
                          </div>


                        </div>
                        <div class="mt-2">
                          <button type="submit" class="btn btn-primary me-2">Approve</button>
                          <button type="submit" class="btn btn-danger me-2">Reject</button>
                        </div>
                      </form>


                      <form id="formAccountSettings" class="mb-4" method="POST" onsubmit="return false">
                        <h5>Item 3</h5>
                        <div class="row">
                          <div class="mb-3 col-md-2">
                            <label for="firstName" class="form-label">Product Name</label>
                            <input
                              class="form-control"
                              type="text"
                              id="p_name"
                              name="p_name"
                              value="Graph Paper"
                              readonly
                            />
                          </div>
                          <div class="mb-3 col-md-2">
                            <label for="p_category" class="form-label">Product Category</label>
                            <input
                              class="form-control"
                              type="text"
                              id="p_category"
                              name="p_category"
                              value="Equipment"
                              readonly
                            />
                          </div>
                          <div class="mb-3 col-md-2">
                            <label for="designation" class="form-label">Assigned For</label>
                            <input
                              class="form-control"
                              type="text"
                              id="designation"
                              name="designation"
                              value="Faculty"
                              readonly
                            />
                          </div>
                          <div class="mb-3 col-md-2">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input
                              class="form-control"
                              type="text"
                              id="quantity"
                              name="quantity"
                              placeholder="eg. 50"
                            />
                          </div>
                          <div class="mb-3 col-md-2">
                            <label for="last_order_date" class="form-label">Last Order Date</label>
                            <input
                              class="form-control"
                              type="text"
                              id="last_order_date"
                              name="last_order_date"
                              value="20/03/2024"
                              readonly
                            />
                          </div>

                          <div class="mb-3 col-md-1">
                          <label for="last_order_date" class="form-label">Status</label>
                            <a href="#" class="badge bg-label-danger">Pending</a>
                          </div>


                        </div>
                        <div class="mt-2">
                          <button type="submit" class="btn btn-primary me-2">Approve</button>
                          <button type="submit" class="btn btn-danger me-2">Reject</button>
                        </div>
                      </form>




                    </div>

              </div> --}}
            <div class="content-backdrop fade"></div>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="{{ asset('Admin/js/order_approve.js') }}"></script>
        </div>
    @endSection
