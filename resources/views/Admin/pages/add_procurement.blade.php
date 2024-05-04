@extends('Admin.layout.master')
@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">


            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Product /</span> Procurement</h4>

            <div class="mt-3">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCenter">
                    Add Procurement
                </button>

                <!-- Modal -->
                <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalCenterTitle">Add Procurement</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="errMsgContainer"></div>
                                <form id="addProcurement" data-route="{{ route('storeprocurement.product') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col mb-3">
                                            <label for="exampleFormControlSelect1" class="form-label">Product Name</label>
                                            <select class="form-select" name="productName" id="productName"
                                                aria-label="Default select example">
                                                <option selected>Select Product</option>
                                                @foreach ($products as $key => $product)
                                                    <option value="{{ $product->id }}">{{ $product->product_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col mb-3">
                                            <label for="quantity" class="form-label">Quantity</label>
                                            <input type="text" id="quantity" name="quantity" class="form-control"
                                                placeholder="Enter Quantity" />
                                        </div>
                                        <div class="col mb-3">
                                            <label for="price" class="form-label">Price</label>
                                            <input type="text" id="price" name="price" class="form-control"
                                                placeholder="Enter Price" />
                                        </div>
                                        <div class="col mb-3">
                                            <label for="unit_price" class="form-label">Unit Price</label>
                                            <input type="text" id="unitprice" name="unitprice" class="form-control"
                                                placeholder="Enter Unit Price" />
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <!-- Use a button to trigger the form submission via JavaScript -->
                                        <button type="submit" class="btn btn-primary" id="addDataBtn">Add</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Basic Bootstrap Table -->
            <div class="card mt-3" id="procurementDiv">
                <h5 class="card-header">Procurements</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table" id="procurementTable">
                        <thead>
                            <tr>
                                <th>Procurement ID</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($procurements as $key => $procurement)
                                <tr>

                                    <td>{{ $procurement->id }}</td>
                                    <td>{{ $procurement->product->product_name }}</td>
                                    <td>{{ $procurement->quantity }}</td>
                                    <td>{{ $procurement->unit_price }}</td>
                                    <td>{{ $procurement->price }}</td>
                                    {{-- <td><span class="badge bg-label-success me-1">{{ $procurement->status }}</span></td> --}}
                                    <td class="d-flex">
                                        {{-- <a href="#"><i
                                        class="bx bx-edit-alt me-1 bg-success p-2 rounded-2 text-white"></i></a> --}}
                                        <button type="button" class="btn btn-link p-0 updateProcurement"
                                            data-bs-toggle="modal" data-bs-target="#Procurementmodal"
                                            data-id="{{ $procurement->id }}"
                                            data-product-id="{{ $procurement->product_id }}"
                                            data-quantity="{{ $procurement->quantity }}"
                                            data-price="{{ $procurement->price }}"
                                            data-unitprice="{{ $procurement->unit_price }}"
                                            >
                                            <i class="bx bx-edit-alt me-1 bg-success p-2 rounded-2 text-white"></i>
                                        </button>
                                        <form id="procurementDelete" action="{{ route('procurement.destroy') }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="procure_id" value="{{ $procurement->id }}">
                                            <button type="submit" onclick="return confirm('Are you sure?')"
                                                class="btn btn-link p-0">
                                                <i class="bx bx-trash me-1 bg-danger p-2 rounded-2 text-white"></i>
                                            </button>
                                        </form>
                                        {{-- <a href="#"><i
                                                class="bx bx-trash me-1 bg-danger p-2 rounded-2 text-white"></i></a> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <span class="p-4 d-flex gap-3">
                      {!! $procurements->withQueryString()->links('pagination::bootstrap-5') !!}
                  </span>
                </div>
            </div>


            <div class="modal fade" id="Procurementmodal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="procurementTitle">Add Procurement</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="errMsgContainer"></div>
                            <form id="updateProcurement" data-route="{{ route('procurement.edit') }}">
                                @csrf
                                <input type="hidden" name="procure_id" id="procureId">
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="exampleFormControlSelect1" class="form-label">Product Name</label>
                                        <select class="form-select" name="productName" id="productName_pro"
                                            aria-label="Default select example">
                                            <option selected>Select Product</option>
                                            @foreach ($products as $key => $product)
                                                <option value="{{ $product->id }}">{{ $product->product_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col mb-3">
                                        <label for="quantity" class="form-label">Quantity</label>
                                        <input type="text" id="quantity_pro" name="quantity" class="form-control"
                                            placeholder="Enter Quantity" />
                                    </div>
                                    <div class="col mb-3">
                                        <label for="price" class="form-label">Price</label>
                                        <input type="text" id="price_pro" name="price" class="form-control"
                                            placeholder="Enter Price" />
                                    </div>
                                    <div class="col mb-3">
                                        <label for="unit_price" class="form-label">Unit Price</label>
                                        <input type="text" id="priceunit" name="unitprice" class="form-control"
                                            placeholder="Enter Unit Price" />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <!-- Use a button to trigger the form submission via JavaScript -->
                                    <button type="submit" class="btn btn-primary" id="addDataBtn">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Content -->

        <div class="content-backdrop fade"></div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="{{ asset('Admin/js/procurement.js') }}"></script>
    </div>
@endSection
