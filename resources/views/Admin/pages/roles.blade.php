@extends('Admin.layout.master')
@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">User /</span> Roles</h4>
            <div class="mt-3">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCenter">
                    Add Role
                </button>
                <!-- Modal -->
                <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalCenterTitle">Add Role</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="errMsgContainer"></div>
                                <form id="createRoleForm" data-route="{{ route('roles.store') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col mb-3">
                                            <label for="nameWithTitle" class="form-label">Role Name</label>
                                            <input type="text" name="nameWithTitle" id="nameWithTitle"
                                                class="form-control" placeholder="Enter Name" />
                                        </div>
                                    </div>
                                    <div class="row g-2">
                                        <div class="mb-3 col-md-6">
                                            <label for="exampleFormControlSelect1" class="form-label">Permissions</label>
                                            <select class="form-select" name="permissions" id="exampleFormControlSelect1"
                                                aria-label="Default select example">
                                                <option selected>Select Privilege</option>
                                                <option value="1">Read</option>
                                                <option value="2">Read Write</option>
                                                <option value="3">Read Write Update</option>
                                                <option value="4">Read Write Update Delete</option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Basic Bootstrap Table -->
            <div class="card mt-3" id="rolesTable">
                <h5 class="card-header">Roles</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table" id="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Role Name</th>
                                <th>Permissions</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($roles as $key => $role)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $role->role_name }}</td>
                                    <td>{{ $role->permissions }}</td>
                                    <td>{{ $role->status }}</td>
                                    <td class="d-flex">
                                        <button type="button" class="btn btn-link p-0 updateRole" data-bs-toggle="modal"
                                            data-bs-target="#modalUpdate" data-role-id="{{ $role->id }}"
                                            data-role_name="{{ $role->role_name }}"
                                            data-permissions="{{ $role->permissions }}">
                                            <i class="bx bx-edit-alt me-1 bg-success p-2 rounded-2 text-white"></i>
                                        </button>
                                        <form id="roleDelete" action="{{ route('roles.destroy') }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="role_id" value="{{ $role->id }}">
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
                        {!! $roles->withQueryString()->links('pagination::bootstrap-5') !!}
                    </span>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalUpdate" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalUpdateTitle">Edit Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="updateRoleForm" data-route="{{ route('roles.edit') }}">
                            @csrf
                            <input type="text" name="role_id" id="role_id" hidden>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameWithTitle" class="form-label">Role Name</label>
                                    <input type="text" name="nameWithTitle" id="roleNameUpdate" class="form-control"
                                        placeholder="Enter Name" />
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="mb-3 col-md-6">
                                    <label for="exampleFormControlSelect1" class="form-label">Permissions</label>
                                    <select class="form-select" name="permissions" id="rlup"
                                        aria-label="Default select example">
                                        <option selected>Select Privilege</option>
                                        <option value="1">Read</option>
                                        <option value="2">Read Write</option>
                                        <option value="3">Read Write Update</option>
                                        <option value="4">Read Write Update Delete</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Content -->
        <div class="content-backdrop fade"></div>
    </div>
    <!-- Your HTML template -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('Admin/js/role.js') }}"></script>
@endSection
