@extends('Admin.layout.master')
@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Developer /</span> Category</h4>
            <div class="mt-3">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCenter">
                    Add Category
                </button>
                <!-- Modal -->
                <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalCenterTitle">Add Category</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="errMsgContainer"></div>
                                <form id="createCategory" data-route="{{ route('category.store') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col mb-3">
                                            <label for="nameWithTitle" class="form-label">Category Name</label>
                                            <input type="text" id="nameWithTitle" name="nameWithTitle"
                                                class="form-control" placeholder="Enter Name" />
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="=submit" id="addCategory" class="btn btn-primary">Add</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Basic Bootstrap Table -->
            <div class="card mt-3" id="categoryTableDiv">
                <h5 class="card-header">Categories</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table" id="categoryTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category Name</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($categories as $key => $category)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $category->category_name }}</td>
                                    <td><span class="badge bg-label-success me-1">{{ $category->status }}</span></td>
                                    <td class="d-flex">
                                        <button type="button" class="btn btn-link p-0 updateCategoryButton"
                                            data-bs-toggle="modal" data-bs-target="#updateCategorymodal"
                                            data-category_id="{{ $category->id }}"
                                            data-category_name="{{ $category->category_name }}">
                                            <i class="bx bx-edit-alt me-1 bg-success p-2 rounded-2 text-white"></i>
                                        </button>
                                        <form id="categoryDelete" action="{{ route('category.destroy') }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="category_id" value="{{ $category->id }}">
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
                        {!! $categories->withQueryString()->links('pagination::bootstrap-5') !!}
                    </span>
                </div>
            </div>
        </div>

        <div class="modal fade" id="updateCategorymodal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateCategoryTitle">Add Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="errMsgContainer"></div>
                        <form id="updateCategory" data-route="{{ route('category.edit') }}">
                            @csrf
                            <input type="text" id="category_id" name="category_id" hidden>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Category Name</label>
                                    <input type="text" id="category_name" name="nameWithTitle" class="form-control"
                                        placeholder="Enter Name" />
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="=submit" id="addCategory" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- / Content -->
        <div class="content-backdrop fade"></div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="{{ asset('Admin/js/categories.js') }}"></script>
    </div>
@endSection
