@extends('Admin.layout.master')
@section('content')
    <!-- Content wrapper -->

    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">


        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Order /</span> Place Order</h4>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <h5>Bill ID: {{ $uuid }}</h5>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <form method="POST" action="{{ route('admin.order_add') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="mb-3 col-md-3">
                    <label for="organization" class="form-label">Product Name</label>
                    {{-- <select class="form-select" id="organization" name="productname"
                        aria-label="Default select example">
                        <option selected>Select Product</option>
                        @foreach ($products as $key => $product)
                            <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                        @endforeach
                    </select> --}}
                    <select class="form-select" required id="organization" name="productname"
                        aria-label="Default select example">
                        <option disabled selected value="">Select Product</option>
                        @foreach ($products as $key => $product)
                            <option value="{{ $product->id }}">{{ $product->product_name }}--
                                @if ($product->role_id == 1)
                                    staff
                                @else
                                    employee/management/faculty
                                    {{-- @endif{{ $product->role->role_name }} --}}
                                @endif
                            </option>
                        @endforeach
                    </select>

                    @error('productname')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3 col-md-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    {{-- <input class="form-control" type="text" id="quantity" min="0" max="5" name="quantity" placeholder="eg. 50" /> --}}
                    <input class="form-control" id="quantity" min="0" max="5" name="quantity"
                        placeholder="e.g. 50" />
                </div>
                <div class="mt-2 col-md-3">
                    <button type="submit" class="btn btn-primary mt-4">Add</button>
                </div>
            </div>
        </form>

        {{-- for delete --}}
        <div class="card p-4">
            <h5 class="my-4">Products</h5>
            @foreach ($orders as $key => $order)
                <form class="" action="{{ route('admin.admin_delete_order') }}"
                    method="POST"onsubmit="return confirm('Are you sure you want to delete this item?')">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <h5 class="mb-3">Item {{ $key + 1 }}</h5>
                    <div class="row">
                        <div class="mb-0 col-md-3">
                            <label for="organization" class="form-label">Product Name</label>
                            <h5>{{ $order->product->product_name }}</h5>
                        </div>
                        <div class="mb-0 col-md-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <h5>{{ $order->quantity }}</h5>
                        </div>
                        <div class="mt-1 col-md-2">
                            <button type="submit" class="btn btn-danger mt-2"><i class='bx bxs-trash'></i></button>
                        </div>
                        <span class="mb-4">This Product For :
                            {{-- {{ $order->product->role->role_name }} --}}
                            @if ($order->product->role_id ==1)
                                staff
                            @else
                                employee/management/faculty
                                {{-- @endif{{ $product->role->role_name }} --}}
                            @endif
                        </span>
                    </div>
                </form>
            @endforeach

        </div>

        <form action="{{ route('admin.order_complete') }}" method="POST" class="mt-4" enctype="multipart/form-data">
            @csrf
            <div class="mb-3 col-md-3">
                <label for="organization" class="form-label">Order For</label>
                {{-- <select class="form-select" required id="organization" name="assinfor" aria-label="Default select example">
                    <option selected>Select User</option>
                    @foreach ($users as $key => $userr)
                        <option value="{{ $userr->id }}">{{ $userr->full_name }}</option>
                    @endforeach
                </select> --}}
                <select class="form-select" required id="organization" name="assinfor" aria-label="Default select example">
                    @if ($users->isEmpty())
                        <option disabled selected>No users available</option>
                    @else
                        <option selected>Select User</option>
                        @foreach ($users as $key => $userr)
                            @if ($userr->id != 1)
                                <option value="{{ $userr->id }}">
                                    {{ $userr->full_name }}--{{ $userr->role->role_name }}</option>
                            @endif
                        @endforeach
                    @endif
                    @if ($orders->isEmpty())
                        <input type="text" hidden name="pos_value" value="0" id="">
                    @else
                        @foreach ($orders as $key => $order)
                            <input type="text" name="pos_value[]" hidden value="{{ $order->product->role_id }}"
                                id="">
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Example textarea</label>
                <input class="form-control" name="textarea" id="textarea" rows="3" />
            </div>
            <button type="submit" class="btn btn-success mt-3">Complete Order</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#quantity').on('input', function() {
                var quantityValue = $(this).val();
                if (quantityValue > 5) {
                    // Show a toast message with auto hide after 2 seconds
                    toastr.error('Quantity cannot be greater than 5', '', {
                        timeOut: 500 // Hide after 2 seconds
                    });
                    // You can also clear the input field if needed
                    $(this).val('');
                }
            });
        });
    </script>
    </div>
@endSection
