@extends('Admin.layout.master')
@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">


            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Admin /</span> Admin Profile</h4>
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-pills flex-column flex-md-row mb-3">
                        <li class="nav-item">
                            <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> Account</a>
                        </li>
                    </ul>
                    <div class="card mb-4">
                        <h5 class="card-header">Profile Details</h5>
                        <!-- Account -->

                        <hr class="my-0" />
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <form id="formAccountSettings" action="{{ route('admin.store_profile') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                                        <img {{-- src="/Admin/assets/img/avatars/1.png" --}} src="{{ asset('images/uploads/' . $user->profile_img) }}"
                                            alt="user-avatar" class="d-block rounded" height="100" width="100"
                                            id="uploadedAvatar" />
                                        <div class="button-wrapper">
                                            <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                                <span class="d-none d-sm-block">Upload new photo</span>
                                                <i class="bx bx-upload d-block d-sm-none"></i>
                                                <input type="file" id="upload" class="account-file-input"
                                                    name="image" hidden accept="image/png, image/jpeg" />
                                            </label>
                                            <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                                        </div>
                                    </div>
                                </div>
                                <input type="text" name="user_id" hidden value="{{ $user->id }}" id="">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="firstName" class="form-label">Full Name</label>
                                        <input class="form-control" type="text" id="firstName" name="firstName"
                                            value="{{ $user->full_name }}" autofocus />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="lastName" class="form-label">Role</label>
                                        <input class="form-control" type="text" name="role" id="role"
                                            value="Admin" readonly />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="email" class="form-label">E-mail</label>
                                        <input class="form-control" type="text" id="email" name="email"
                                            value="{{ $user->email }}" placeholder="nub@example.com" />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="organization" class="form-label">Organization</label>
                                        <input type="text" class="form-control" id="organization" name="organization"
                                            value="{{ $user->organization->organization_name }}" placeholder="Northen" />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label" for="phoneNumber">Phone Number</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text">BD (+880)</span>
                                            <input type="text" id="phoneNumber" name="phoneNumber" class="form-control"
                                                placeholder="172 345 6789" value="{{ $user->phone }}" />
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address"
                                            value="{{ $user->address }}" name="address" placeholder="Address" />
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                </div>
                            </form>
                        </div>
                        <!-- /Account -->
                    </div>
                    <div class="card">
                        <h5 class="card-header">Change Password</h5>
                        <div class="card-body">
                            <div class="mb-3 col-12 mb-0">
                                <div class="alert alert-warning">
                                    <h6 class="alert-heading fw-bold mb-1">Are you sure you want to change password?</h6>
                                    <p class="mb-0">Once you change your account, there is no going back. Please be
                                        certain.</p>
                                </div>
                            </div>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (session('password'))
                                <div class="alert alert-success">
                                    {{ session('password') }}
                                </div>
                            @endif
                            <form id="formAccountDeactivation" action="{{ route('admin.changepassword') }}"
                                method="post" onsubmit="alert('Are you want to change your password?')">
                                @csrf
                                <input type="text" name="user_id" hidden value="{{ $user->id }}" id="">
                                <div class="mb-3 col-md-6">
                                    <label for="state" class="form-label">Old Password</label>
                                    <input class="form-control" type="text" id="old_pass" name="old_pass"
                                        placeholder="Old Password" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="zipCode" class="form-label">New Password</label>
                                    <input type="text" class="form-control" id="new_pass" name="new_pass"
                                        placeholder="New Password" maxlength="20" />
                                </div>
                                <button type="submit" class="btn btn-warning">Change Password</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="content-backdrop fade"></div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            document.getElementById('upload').addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('uploadedAvatar').src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        </script>
    </div>
@endSection
