@extends('Admin.layout.master')
@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">


            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">User</span> / Create User</h4>




            <!-- Basic Bootstrap Table -->
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-pills flex-column flex-md-row mb-3">
                        <li class="nav-item">
                            <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> Account</a>
                        </li>
                    </ul>
                    <div class="card mb-4">
                        <h5 class="card-header">User Details</h5>
                        <!-- Account -->

                        <hr class="my-0" />
                        {{-- <div class="card-body">
                            <form id="formAccountSettings" method="POST">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="firstName" class="form-label">Full Name</label>
                                        <input class="form-control" type="text" id="firstName" name="firstName"
                                            autofocus />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="exampleFormControlSelect1" class="form-label">Role</label>
                                        <select class="form-select" id="exampleFormControlSelect1"
                                            aria-label="Default select example">
                                            <option selected>Select Role</option>
                                            <option value="1">Admin</option>
                                            <option value="2">Faculty</option>
                                            <option value="3">Staff</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="email" class="form-label">E-mail</label>
                                        <input class="form-control" type="text" id="email" name="email"
                                            placeholder="nub@example.com" />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="pass" class="form-label">Password</label>
                                        <input class="form-control" type="password" id="pass" name="pass"
                                            placeholder="New Password" />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="organization" class="form-label">Organization</label>
                                        <select class="form-select" id="organization" name="organization"
                                            aria-label="Default select example">
                                            <option selected>Select Organization</option>
                                            <option value="1">Praasad</option>
                                            <option value="2">Northern</option>
                                            <option value="3">Others</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label" for="phoneNumber">Phone Number</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text">BD (+880)</span>
                                            <input type="text" id="phoneNumber" name="phoneNumber" class="form-control"
                                                placeholder="172 345 6789" />
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address" name="address"
                                            placeholder="Address" />
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label for="formFile" class="form-label">Upload Image</label>
                                        <input class="form-control" type="file" id="formFile">
                                    </div>






                                </div>
                                <div class="mt-2">
                                    <button type="submit" class="btn btn-primary me-2">Create User</button>
                                </div>
                            </form>
                        </div> --}}

                        {{-- <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <form id="formAccountSettings" method="POST" action="{{ route('admin.store') }}" enctype="multipart/form-data">
                                @csrf
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
                                        <select class="form-select" id="role" name="role"
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
                                    <!-- Password -->
                                    <div class="mb-3 col-md-6">
                                        <label for="password" class="form-label">Password</label>
                                        <input class="form-control" type="password" id="password" name="password"
                                            placeholder="Password" />
                                    </div>
                                    <!-- Organization -->
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
                                    <!-- Phone Number -->
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label" for="phoneNumber">Phone Number</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text">BD (+880)</span>
                                            <input type="text" id="phoneNumber" name="phoneNumber" class="form-control"
                                                placeholder="172 345 6789" />
                                        </div>
                                    </div>
                                    <!-- Address -->
                                    <div class="mb-3 col-md-6">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address" name="address"
                                            placeholder="Address" />
                                    </div>
                                    <!-- Upload Image -->
                                    <div class="mb-3 col-md-6">
                                        <label for="image" class="form-label">Upload Image</label>
                                        <input class="form-control" type="file" id="image" name="image" />
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <button type="submit" class="btn btn-primary me-2">Create User</button>
                                </div>
                            </form>
                        </div> --}}
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <form id="formAccountSettings" method="POST" action="{{ route('admin.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <!-- Full Name -->
                                    <div class="mb-3 col-md-6">
                                        <label for="fullName" class="form-label">Full Name</label>
                                        <input class="form-control" type="text" id="fullName" name="fullName"
                                            value="{{ old('fullName') }}" autofocus />
                                    </div>
                                    
                                    <!-- Role -->
                                    <div class="mb-3 col-md-6">
                                        <label for="role" class="form-label">Role</label>
                                        <select class="form-select" id="role" name="role"
                                            aria-label="Default select example">
                                            <option selected>Select Role</option>
                                            @foreach ($roles as $key => $role)
                                                <option value="{{ $role->id }}"
                                                   
                                                    {{ old('role') == $role->id ? 'selected' : '' }}>
                                                    {{ $role->role_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- Email -->
                                    <div class="mb-3 col-md-6">
                                        <label for="email" class="form-label">E-mail</label>
                                        <input class="form-control" type="text" id="email" name="email"
                                            value="{{ old('email') }}" placeholder="example@example.com" />
                                    </div>
                                    <!-- Password -->
                                    <div class="mb-3 col-md-6">
                                        <label for="password" class="form-label">Password</label>
                                        <input class="form-control" type="password" id="password" name="password"
                                            value="{{ old('password') }}" placeholder="Password" />
                                    </div>
                                    <!-- Organization -->
                                    <div class="mb-3 col-md-6">
                                        <label for="organization" class="form-label">Organization</label>
                                        <select class="form-select" id="organization" name="organization"
                                            aria-label="Default select example">
                                            <option selected>Select Organization</option>
                                            @foreach ($organizations as $key => $organization)
                                                <option value="{{ $organization->id }}"
                                                    {{ old('organization') == $organization->id ? 'selected' : '' }}>
                                                    {{ $organization->organization_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- Phone Number -->
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label" for="phoneNumber">Phone Number</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text">BD (+880)</span>
                                            <input type="text" id="phoneNumber" name="phoneNumber" class="form-control"
                                                value="{{ old('phoneNumber') }}" placeholder="172 345 6789" />
                                        </div>
                                    </div>
                                    <!-- Address -->
                                    <div class="mb-3 col-md-6">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address" name="address"
                                            value="{{ old('address') }}" placeholder="Address" />
                                    </div>
                                    <!-- Upload Image -->
                                    <div class="mb-3 col-md-6">
                                        <label for="image" class="form-label">Upload Image</label>
                                        <input class="form-control" type="file" id="image" name="image" />
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <button type="submit" class="btn btn-primary me-2">Create User</button>
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
