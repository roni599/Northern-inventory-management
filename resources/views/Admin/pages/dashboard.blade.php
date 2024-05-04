@extends('Admin.layout.master')
@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-lg-12 mb-4 order-0">
                    <div class="card">
                        <div class="d-flex align-items-end row">
                            <div class="col-sm-7">
                                <div class="card-body">
                                    {{-- <h5 class="card-title text-primary">Congratulations Saad Al Zabir! 🎉</h5> --}}
                                    <h5 class="card-title text-primary">Congratulations {{ $user->full_name }}! 🎉</h5>
                                    <p class="mb-4">
                                        Welcome to
                                        your profile.
                                    </p>

                                    <a href="{{ route('admin.viewprofile') }}" class="btn btn-sm btn-outline-primary">View
                                        profile</a>
                                </div>
                            </div>
                            <div class="col-sm-5 text-center text-sm-left">
                                <div class="card-body pb-0 px-0 px-md-4">
                                    <img src="/Admin/assets/img/illustrations/man-with-laptop-light.png" height="140"
                                        alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                        data-app-light-img="illustrations/man-with-laptop-light.png" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-4 col-md-4 order-1">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                            <i class='bx bx-cart-alt text-warning fs-3'></i>
                                        </div>
                                        <div class="dropdown">
                                            {{-- <button
                                class="btn p-0"
                                type="button"
                                id="cardOpt3"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                              >
                                <i class="bx bx-dots-vertical-rounded"></i>
                              </button> --}}
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                                {{-- <a class="dropdown-item" href="javascript:void(0);">View More</a> --}}

                                            </div>
                                        </div>
                                    </div>
                                    <span class="fw-semibold d-block mb-1">Total Order</span>


                                    {{-- @foreach ($bills as $key => $bill) --}}
                                        @if ($ordersCount>0)
                                            <h3 class="card-title mb-2">{{ $ordersCount }}</h3>
                                        @else
                                            <h3 class="card-title mb-2">0</h3>
                                        @endif
                                    {{-- @endforeach --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                            <i class='bx bx-package text-success fs-3'></i>
                                        </div>
                                        <div class="dropdown">
                                            {{-- <button
                                class="btn p-0"
                                type="button"
                                id="cardOpt6"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                              >
                                <i class="bx bx-dots-vertical-rounded"></i>
                              </button> --}}
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                                {{-- <a class="dropdown-item" href="javascript:void(0);">View More</a> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <span class="fw-semibold d-block mb-1 pb-1">Total Products</span>
                                    <h3 class="card-title text-nowrap mb-1">{{ $productsCount }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--/ Total Revenue -->
                <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
                    <div class="row">
                        <div class="col-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                            <i class='bx bx-user-pin text-danger fs-3'></i>
                                        </div>
                                        <div class="dropdown">
                                            {{-- <button
                                class="btn p-0"
                                type="button"
                                id="cardOpt4"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                              >
                                <i class="bx bx-dots-vertical-rounded"></i>
                              </button> --}}
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                                {{-- <a class="dropdown-item" href="javascript:void(0);">View More</a> --}}

                                            </div>
                                        </div>
                                    </div>
                                    <span class="fw-semibold d-block mb-1">Total User</span>
                                    <h3 class="card-title text-nowrap mb-2">{{ $usersCount }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                            <!-- <img src="/Admin/assets/img/icons/unicons/cc-primary.png" alt="Credit Card" class="rounded" /> -->
                                            <i class='bx bx-category text-primary fs-3'></i>
                                        </div>
                                        <div class="dropdown">
                                            {{-- <button
                                class="btn p-0"
                                type="button"
                                id="cardOpt1"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                              >
                                <i class="bx bx-dots-vertical-rounded"></i>
                              </button> --}}
                                            <div class="dropdown-menu" aria-labelledby="cardOpt1">
                                                {{-- <a class="dropdown-item" href="javascript:void(0);">View More</a> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <span class="fw-semibold d-block mb-1">Total Category</span>
                                    <h3 class="card-title mb-2">{{ $categoryCount }}</h3>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        <!-- / Content -->


        <div class="content-backdrop fade"></div>
    </div>
@endSection
