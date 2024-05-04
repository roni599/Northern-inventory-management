@extends('User.layout.master')
@section('content')
    <!-- Content wrapper -->
    <div class="col-lg-8 mb-4 order-0">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">


            <h4 class="fw-bold py-3 mb-4"><a href="{{ route('user.dashbord') }}"><i
                        class='bx bx-left-arrow-alt fs-4 mb-1 me-3'></i></a> Place Order</h4>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <h5>Bill Id : {{ $uuid }}</h5>
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
            <form method="POST" action="{{ route('user.add_order') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="mb-3 col-md-3">

                        <label for="organization" class="form-label">Product Name</label>
                        <select class="form-select" required id="organization" name="productname"
                            aria-label="Default select example">
                            <option disabled selected value="">Select Product</option>
                            @foreach ($products as $key => $product)
                                <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                            @endforeach
                        </select>
                        @error('productname')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input class="form-control" type="text" id="quantity" name="quantity" placeholder="eg. 50" />
                    </div>
                    <div class="mt-2 col-md-3">
                        <button type="submit" class="btn btn-primary mt-4">Add</button>
                    </div>
                </div>
            </form>

            <div class="card p-4">
                <h5 class="my-4">Products</h5>
                @foreach ($orders as $key => $order)
                    <form method="POST" action="{{ route('user.delete_order') }}"
                        onsubmit="return confirm('Are you sure you want to delete this item?')">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <h5>Item {{ $key + 1 }}</h5>
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label for="organization" class="form-label">Product Name</label>
                                <h5>{{ $order->product->product_name }}</h5>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <h5>{{ $order->quantity }}</h5>
                            </div>
                            <div class="mt-2 col-md-2">
                                <button type="submit" class="btn btn-danger mt-2"><i class='bx bxs-trash'></i></button>
                            </div>
                        </div>
                    </form>
                @endforeach


            </div>

            <form action="{{ route('user.complete_order') }}" method="POST" class="mt-4" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Comments</label>
                    <input class="form-control" id="textarea" name="textarea" rows="3"/>
                  </div>
                @csrf
                <button type="submit" class="btn btn-success mt-3">Complete Order</button>
            </form>
            <!-- / Content -->


            <div class="content-backdrop fade"></div>
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
