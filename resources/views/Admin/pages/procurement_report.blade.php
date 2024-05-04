@extends('Admin.layout.master')
@section('content')

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">


                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Report /</span> Procurement Report</h4>

                <div class="d-flex mb-3 gap-2">

 
                    <div class="mb-3 col-md-2">
                        <label for="organization" class="form-label">Filter By Product Name</label>
                        <select class="form-select" id="procurementproduct" name="procurement" aria-label="Default select example">
                            <option selected>Select Product</option>
                            @foreach ($products as $key=>$product )
                            <option value="{{ $product->product->product_name}}">{{ $product->product->product_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 col-md-2">
                        <label for="organization" class="form-label">Filter By Date</label>
                        <select class="form-select" id="procurementdays" name="procurement_report" aria-label="Default select example">
                            <option value="0" selected>Select Date</option>
                            <option value="1">Today</option>
                            <option value="2">Last 7 Days</option>
                            <option value="3">Last 30 Days</option>
                        </select>
                    </div>
                    <div class="mt-4 col-md-2">
                      <a href="{{ route('orders.procurementExport') }}" class="btn btn-primary">Download Excel</a>
                    </div>
                </div>
                <div class="card mt-3">
                <h5 class="card-header">Procurements</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table" id="daysTable">
                    <thead>
                      <tr>
                        <th>Procurement ID</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Price</th>
                        <th>status</th>
                        {{-- <th>Action</th> --}}
                        {{-- <th>Actions</th> --}}
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      @foreach ($products as $key=>$product)
                      <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->product->product_name }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->unit_price }}</td>
                        <td>{{ $product->price }}</td>
                        @if($product->status==='0' || $product->status===null)
                        <td><span class="badge bg-label-success me-1">Available</span></td>
                        @else
                        <td><span class="badge bg-label-success me-1">Not Available</span></td>
                        @endif
                        {{-- <td class="d-flex">
                            <a href="#"><i class="bx bx-edit-alt me-1 bg-success p-2 rounded-2 text-white"></i></a>
                            <a href="#"><i class="bx bx-trash me-1 bg-danger p-2 rounded-2 text-white"></i></a>
                        </td>
                      </tr> --}}
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>

            </div>
            <!-- / Content -->

         
            <div class="content-backdrop fade"></div>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="{{ asset('Admin/js/procurement_report.js') }}"></script>
          </div>
            



@endSection