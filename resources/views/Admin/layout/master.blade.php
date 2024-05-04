<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="/Admin/assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Inventory Dashboard</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/Admin/assets/logos/logo.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="/Admin/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="/Admin/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="/Admin/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="/Admin/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="/Admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="/Admin/assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="/Admin/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="/Admin/assets/js/config.js"></script>


</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include('sweetalert::alert')
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

                <div class="p-2 px-3 pb-0">
                    <a href="{{ route('admin.dashbord') }}" class="">
                        {{-- <div class="p-2" style="background-color:#EEEEEE; border-radius:8px;">
                            <img src="/Admin/assets/logos/l1.png" width="150" alt="">
                        </div> --}}

                        <div class="p-2" style="background-color:#EEEEEE; border-radius:8px;">
                            <img src="/Admin/assets/logos/logo.png" width="70" alt="">
                        </div>

                    </a>

                    <a href="javascript:void(0);"
                        class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!-- Dashboard -->
                    <li class="menu-item active">
                        <a href="{{ route('admin.dashbord') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Analytics">Dashboard</div>
                        </a>
                    </li>


                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class='menu-icon bx bx-cart-alt'></i>
                            <div data-i18n="Account Settings">Order</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('admin.orders') }}" class="menu-link">
                                    <div data-i18n="Account">Order List</div>
                                </a>
                            </li>
                            {{-- <li class="menu-item">
                                <a href="{{ route('pending.orders') }}" class="menu-link">
                                    <div data-i18n="Notifications">Pending Orders</div>
                                </a>
                            </li> --}}
                        </ul>
                    </li>




                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class='menu-icon bx bxs-shopping-bags'></i>
                            <div data-i18n="Authentications">Product</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('addproduct.product') }}" class="menu-link">
                                    <div data-i18n="Basic">Add Product</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('product.index') }}" class="menu-link">
                                    <div data-i18n="Basic">Product List</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('addprocurement.product') }}" class="menu-link">
                                    <div data-i18n="Basic">Add Procurement</div>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class='menu-icon bx bxs-user-account'></i>
                            <div data-i18n="Misc">Users</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('admin.create_user') }}" class="menu-link">
                                    <div data-i18n="Error">Create User</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('admin.user_list') }}" class="menu-link">
                                    <div>User List</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('roles.index') }}" class="menu-link">
                                    <div>Roles</div>
                                </a>
                            </li>

                        </ul>
                    </li>


                    <li class="menu-item">
                        <a href="javascript:void(0)" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-cog"></i>
                            <div data-i18n="User interface">Developer Options</div>
                        </a>
                        <ul class="menu-sub">

                            <li class="menu-item">
                                <a href="{{ route('category.index') }}" class="menu-link">
                                    <div>Categories</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('organization.index') }}" class="menu-link">
                                    <div>Organization</div>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-detail"></i>
                            <div data-i18n="Form Layouts">Report</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('order.report') }}" class="menu-link">
                                    <div data-i18n="Vertical Form">Order Report</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('admin.procurement_report') }}" class="menu-link">
                                    <div data-i18n="Horizontal Form">Procurement Report</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

                        <h5 class="mt-3">Northern Inventory Management System</h5>


                        <ul class="navbar-nav flex-row align-items-center ms-auto">


                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        {{-- <img src="/Admin/assets/img/avatars/1.png" alt
                                            class="w-px-40 h-auto rounded-circle" /> --}}
                                        <img src="{{ asset('/images/uploads/' . $user->profile_img) }}" alt
                                            class="w-px-30 h-auto rounded-circle" />
                                        {{-- <img src="{{ asset('images/uploads') }}/{{ $data->profile_img }}"
                                            alt="{{ $data->profile_img }}" class="w-px-32 h-auto rounded-circle" /> --}}
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        {{-- <img src="/Admin/assets/img/avatars/1.png" alt
                                                            class="w-px-40 h-auto rounded-circle" /> --}}
                                                        <img src="{{ asset('/images/uploads/' . $user->profile_img) }}"
                                                            alt class="w-px-30 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    {{-- <span class="fw-semibold d-block">Saad Al Zabir</span>
                                                    <small class="text-muted">Admin</small> --}}
                                                    <span class="fw-semibold d-block">{{ $user->full_name }}</span>
                                                    <small class="text-muted">{{ $user->role->role_name }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.viewprofile') }}">
                                            <i class="bx bx-user me-2"></i>
                                            <span class="align-middle">My Profile</span>
                                        </a>
                                    </li>


                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.logout') }}">
                                            <i class="bx bx-power-off me-2"></i>
                                            <span class="align-middle">Log Out</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>

                <!-- / Navbar -->



                @hasSection('content')
                    @yield('content')
                @else
                    <h3>No Content Found</h3>
                @endif


                <!-- Footer -->
                {{-- <footer class="content-footer footer bg-footer-theme">
                    <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                        <div class="mb-2 mb-md-0">
                            ©copyright
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                            . All rights reserved.
                        </div>

                    </div>
                </footer> --}}
                <!-- / Footer -->

                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->



    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="/Admin/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="/Admin/assets/vendor/libs/popper/popper.js"></script>
    <script src="/Admin/assets/vendor/js/bootstrap.js"></script>
    <script src="/Admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="/Admin/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="/Admin/assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="/Admin/assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="/Admin/assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>
