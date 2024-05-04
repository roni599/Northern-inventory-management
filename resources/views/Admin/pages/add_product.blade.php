@extends('Admin.layout.master')
@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Product</span> / Add Product</h4>
            <!-- Basic Bootstrap Table -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <h5 class="card-header">Product Details</h5>
                        <!-- Account -->
                        <hr class="my-0" />
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <form id="formAccountSettings" method="POST" action="{{ route('addproduct.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="product_name" class="form-label">Product Name</label>
                                        <input class="form-control" type="text" id="firstName" name="product_name"
                                            autofocus />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="exampleFormControlSelect1" class="form-label">Product Category</label>
                                        <select class="form-select" name="category" id="exampleFormControlSelect1"
                                            aria-label="Default select example">
                                            <option selected>Select Category</option>
                                            @foreach ($categories as $key => $category)
                                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- <div class="mb-3 col-md-6">
                                        <label for="exampleFormControlSelect1" class="form-label">Assigned For</label>
                                        <select class="form-select" name="assigned_for" id="exampleFormControlSelect1"
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
                                        <input class="form-control" type="text"  id="quantity" name="quantity"
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
                        <!-- /Account -->
                    </div>
                </div>
            </div>
            <div class="content-backdrop fade"></div>
        </div>
    @endSection
