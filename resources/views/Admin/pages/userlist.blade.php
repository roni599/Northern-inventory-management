@extends('Admin.layout.master')
@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">


            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">User /</span> User List</h4>

            <div class="d-flex mb-3 gap-2">
                <form id="searchForm" class="d-flex align-items-center">
                    @csrf
                    <input type="text" name="designation" id="searchInput" class="form-control w-75"
                        placeholder="Search by User name....">
                    <button type="submit" class="btn btn-primary ms-1">Search</button>
                </form>
            </div>


            <!-- Basic Bootstrap Table -->

            <div class="card mt-3" id="userTableDiv">
                <h5 class="card-header">Users</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table" id="userTable">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Full Name</th>
                                <th>Role</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Organization Name</th>
                                <th>profile</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($users as $key => $userr)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $userr->full_name }}</td>
                                    <td>
                                        @if ($userr->role_id === null)
                                            No Role Assigned
                                        @else
                                            {{ $userr->role->role_name }}
                                        @endif
                                    </td>
                                    <td>{{ $userr->email }}</td>
                                    <td>{{ $userr->phone }}</td>
                                    <td>
                                        @if ($userr->organization === null)
                                            No organization is alwoed
                                            @else{{ $userr->organization->organization_name }}
                                        @endif
                                    </td>
                                    <td>
                                        <img src="{{ asset('images/uploads') }}/{{ $userr->profile_img }}" height="50px"
                                            width="50px" style="border-radius:50%; border: 4px solid greenyellow;"
                                            alt="">
                                    </td>
                                    @if ($userr->status === '0')
                                        <td><span class="badge bg-label-success me-1">Approved</span></td>
                                    @else
                                        <td><span class="badge bg-label-success me-1">Rejected</span></td>
                                    @endif
                                    <td class="d-flex">

                                        <button type="button" class="btn btn-link p-0 updateUserButton"
                                            data-bs-toggle="modal" data-bs-target="#updateUsermodal"
                                            data-user_id="{{ $userr->id }}" data-full_name="{{ $userr->full_name }}"
                                            data-email="{{ $userr->email }}" data-phone_number="{{ $userr->phone }}"
                                            data-address="{{ $userr->address }}" data-image="{{ $userr->profile_img }}"
                                            data-role_id="{{ $userr->role_id != null ? $userr->role->role_name : 'No Role Assigned' }}"
                                            data-organization_id="{{ $userr->organization_id != null ? $userr->organization->organization_name : 'No organization Assigned' }}">
                                            <i class="bx bx-edit-alt me-1 bg-success p-2 rounded-2 text-white"></i>
                                        </button>
                                        <form id="userDelete" action="{{ route('user.destroy') }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="user_id" value="{{ $userr->id }}">
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
                        {!! $users->withQueryString()->links('pagination::bootstrap-5') !!}
                    </span>
                </div>
            </div>

            <div class="modal fade" id="updateUsermodal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateUserTitle">Add Category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="errMsgContainer"></div>
                            <form id="userUpdate" data-route="{{ route('user.edit') }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="text" hidden name="user_id" id="userid">
                                <div class="row">
                                    <!-- Full Name -->
                                    <div class="mb-3 col-md-6">
                                        <label for="fullName" class="form-label">Full Name</label>
                                        <input class="form-control" type="text" id="fullName" name="fullName"
                                            autofocus />
                                    </div>
                                    <!-- Role -->
                                    <div class="mb-3 col-md-6">
                                        <label for="role" class="form-label">Role</label>
                                        <select class="form-select roles" id="roles" name="role"
                                            aria-label="Default select example">
                                            <option selected>Select Role</option>
                                            @foreach ($roles as $key => $role)
                                                <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- Email -->
                                    <div class="mb-3 col-md-6">
                                        <label for="email" class="form-label">E-mail</label>
                                        <input class="form-control" type="text" id="email" name="email"
                                            placeholder="example@example.com" />
                                    </div>

                                    <!-- Organization -->
                                    <div class="mb-3 col-md-6">
                                        <label for="organization" class="form-label">Organization</label>
                                        <select class="form-select organizations" id="organizations" name="organization"
                                            aria-label="Default select example">
                                            <option selected>Select Organization</option>
                                            @foreach ($organizations as $key => $organization)
                                                <option value="{{ $organization->id }}">
                                                    {{ $organization->organization_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- Phone Number -->
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label" for="phoneNumber">Phone Number</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text">BD (+880)</span>
                                            <input type="text" id="phoneNumber" name="phoneNumber"
                                                class="form-control" placeholder="172 345 6789" />
                                        </div>
                                    </div>
                                    <!-- Address -->
                                    <div class="mb-3 col-md-6">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address" name="address"
                                            placeholder="Address" />
                                    </div>
                                    <!-- Upload Image -->
                                    <div id="imagePathDisplay"></div>
                                    <div class="mb-3 col-md-6">
                                        <input class="form-control" type="file" id="image" name="newimage" />
                                    </div>
                                </div>
                                <div class="mt-3 mb-2">
                                    <button type="submit" class="btn btn-primary me-2">Update User</button>
                                </div>
                            </form>
                            <form id="userPassChange" method="post"
                                data-route="{{ route('admin.user_changepassword') }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="text" hidden name="user_id" id="userid_change_pass">
                                <div class="mb-3 col-md-6">
                                    <label for="address" class="form-label">Change Password</label>
                                    <input type="text" class="form-control" id="change_pass" name="chng_pass"
                                        placeholder="Enter user new password" />
                                </div>
                                <div class="mt-2 mb-2">
                                    <button type="submit" class="btn btn-warning me-2">Change Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-backdrop fade"></div>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="{{ asset('Admin/js/users.js') }}"></script>
        </div>
    @endSection
