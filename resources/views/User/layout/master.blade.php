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
    <link rel="stylesheet" href="/User/assets/css/style.css" />

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
            @include('sweetalert::alert')
            <!-- Menu -->
            <div class="content-wrapper">
                <!-- Content -->

                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="row">
                        <div class="col-lg-4 mb-4 order-0 main-left">

                            <div class="card main-card">
                                <div class="d-flex align-items-end row">
                                    <div class="col-sm-12">
                                        <div class="card-body text-center">


                                            <div class="top-segment">
                                                <a href="{{ route('user.dashbord') }}" class="">
                                                    <div class="p-2">
                                                        {{-- <img src="/Admin/assets/logos/l1.png" width="170"
                                                            alt=""> --}}
                                                            <img src="/Admin/assets/logos/logo.png" width="80"
                                                            alt="">
                                                    </div>
                                                </a>
                                            </div>
                                            
                                            <div class="pro-card">
                                                <div class="pro-img">
                                                    <img src="{{ asset('/images/uploads/' . $user->profile_img) }}" alt="">
                                                </div>
                                            </div>

                                            <span class="d-block text-dark mt-4 fs-4 fw-bold">{{ $user->full_name }}</span>
                                            <span class="d-block text-muted">{{ $user->role->role_name }}</span>


                                            <a href="{{ route('user.edit_profile') }}" class="btn btn-sm btn-primary mt-3"><i
                                                    class='bx bx-edit-alt me-2'></i>Edit profile</a>

                                            <div class="card-body">
                                                <div class="divider mt-5">
                                                    <div class="divider-text">Setting & Privacy</div>
                                                </div>

                                                <a href="{{ route('user.dashbord') }}"
                                                    class="btn btn-light d-block">Dashboard</a>
                                                <a href="{{ route('user.logout') }}"
                                                    class="btn btn-outline-dark d-block mt-3">Logout</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @hasSection('content')
                            @yield('content')
                        @else
                            <h3>No Content Found</h3>
                        @endif
                    </div>

                </div>
                <!-- / Content -->
                <div class="content-backdrop fade"></div>
            </div>
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
