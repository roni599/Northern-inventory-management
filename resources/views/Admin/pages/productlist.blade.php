@extends('Admin.layout.master')
@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">


            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Product</span> / Product List</h4>

            <div class="d-flex mb-3 gap-2">
                <form id="searchForm" class="d-flex align-items-center">
                    @csrf
                    <input type="text" name="designation" id="searchInput" class="form-control w-75"
                        placeholder="Search by Order id....">
                    <button type="submit" class="btn btn-primary ms-1">Search</button>
                </form>
            </div>
            <div class="card mt-3" id="productTableDiv">
                <h5 class="card-header">Products</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table" id="productTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Assigned For</th>
                                <th>Expiry Time</th>
                                <th>Quantity</th>
                                <th>Organization</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($products as $key => $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>
                                        {{ $product->category != null ? $product->category->category_name : 'No Role Assigned' }}
                                    </td>
                                    <td>
                                        {{ $product->role != null ? $product->role->role_name : 'No Role Assigned' }}
                                    </td>
                                    @if ($product->expiry_time === null)
                                        <td>0</td>
                                    @else
                                        <td>{{ $product->expiry_time }}</td>
                                    @endif
                                    <td>{{ $product->quantity }}</td>
                                    <td>
                                        @foreach ($product->organizations as $organization)
                                            {{ $organization->organization_name }}
                                            <br>
                                        @endforeach
                                    </td>
                                    <td class="d-flex">
                                        <button type="button" class="btn btn-link p-0 updateProductButton"
                                            data-bs-toggle="modal" data-bs-target="#updateProductmodal"
                                            data-product_id="{{ $product->id }}"
                                            data-product_name="{{ $product->product_name }}"
                                            {{-- data-role_id="{{ $product->role ? $product->role->role_name : 'null' }}" --}}
                                            data-expiry_time="{{ $product->expiry_time }}"
                                            data-categoryto="{{ $product->category ? $product->category->category_name : 'null' }}"
                                            data-quantity="{{ $product->quantity }}"
                                            data-organization="{{ $product->organizations->pluck('id')->toJson() }}">
                                            <i class="bx bx-edit-alt me-1 bg-success p-2 rounded-2 text-white"></i>
                                        </button>
                                        {{-- <a href="#"><i
                                                class="bx bx-edit-alt me-1 bg-success p-2 rounded-2 text-white"></i></a> --}}
                                        {{-- <a href="#"><i
                                                class="bx bx-trash me-1 bg-danger p-2 rounded-2 text-white"></i></a> --}}
                                        <form id="productDelete" action="{{ route('product.destroy') }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <button type="submit" onclick="return confirm('Are you sure?')"
                                                class="btn btn-link p-0">
                                                <i class="bx bx-trash me-1 bg-danger p-2 rounded-2 text-white"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <span class="p-4 d-flex gap-3">
                        {!! $products->withQueryString()->links('pagination::bootstrap-5') !!}
                    </span>
                </div>
            </div>

            <div class="modal fade" id="updateProductmodal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateProductTitle">Add Category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="errMsgContainer"></div>
                            <form id="updateProduct" data-route="{{ route('product.edit') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="text" hidden name="pid" id="productupdateid">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="product_name" class="form-label">Product Name</label>
                                        <input class="form-control" type="text" id="firstName" name="product_name"
                                            autofocus />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="categoryfor" class="form-label">Product Category</label>
                                        <select class="form-select categoryforto" name="category" id="categoryfor" aria-label="Default select example" data-categoryto="YourCategoryValue">
                                            <option selected>Select Category</option>
                                            @foreach ($categories as $key => $category)
                                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- <div class="mb-3 col-md-6">
                                        <label for="assingfor" class="form-label">Assigned For</label>
                                        <select class="form-select assingfor" name="assigned_for" id="assingfor"
                                            aria-label="Default select example">
                                            <option selected>Select Role</option>
                                            @foreach ($roles as $key => $role)
                                                <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                    <div class="mb-3 col-md-6">
                                        <label for="ex_time" class="form-label">Expiry Time</label>
                                        <input class="form-control" type="text" id="ex_time" name="expiry_time"
                                            placeholder="eg. 20" />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="quantity" class="form-label">Quantity</label>
                                        <input class="form-control" type="text" id="quantity" name="quantity"
                                            placeholder="eg. 50" />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="organization" class="form-label">Organization</label>
                                        <select class="form-select" id="organization" name="organization"
                                            aria-label="Default select example">
                                            <option selected>Select Organization</option>
                                            @foreach ($organizations as $key => $organization)
                                                <option value="{{ $organization->id }}">
                                                    {{ $organization->organization_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label for="formFile" class="form-label">Upload Product Image</label>
                                        <input class="form-control" name="image" type="file" id="formFile">
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <button type="submit" class="btn btn-primary me-2">Add Product</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-backdrop fade"></div>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="{{ asset('Admin/js/product.js') }}"></script>
        </div>
    @endSection
