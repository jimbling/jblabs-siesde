<!DOCTYPE html>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <style>
        @import url("https://rsms.me/inter/inter.css");
    </style>
    <script>
        document.documentElement.setAttribute('data-bs-theme', localStorage.getItem('theme') || 'light');
    </script>

    @vite('resources/css/app.css')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</head>



<body class="d-flex flex-column">
    <div class="wrapper">
        <!-- Navbar -->
        @include('components.top-nav') <!-- Include Navbar -->
        @include('components.menu-nav') <!-- Include Navbar -->

        <div class="page-wrapper">

            <!-- BEGIN PAGE HEADER -->
            {{-- <div class="page-header d-print-none">
                <div class="container-xl">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <!-- Page pre-title -->
                            <div class="page-pretitle">Overview</div>
                            <h2 class="page-title">Dashboard</h2>
                        </div>
                        <!-- Page title actions -->
                        <div class="col-auto ms-auto d-print-none">
                            <div class="btn-list">
                                <span class="d-none d-sm-inline">
                                    <a href="#" class="btn btn-1"> New view </a>
                                </span>
                                <a href="#" class="btn btn-primary btn-5 d-none d-sm-inline-block"
                                    data-bs-toggle="modal" data-bs-target="#modal-report">
                                    <!-- Download SVG icon from http://tabler.io/icons/icon/plus -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="icon icon-2">
                                        <path d="M12 5l0 14" />
                                        <path d="M5 12l14 0" />
                                    </svg>
                                    Create new report
                                </a>
                                <a href="#" class="btn btn-primary btn-6 d-sm-none btn-icon"
                                    data-bs-toggle="modal" data-bs-target="#modal-report"
                                    aria-label="Create new report">
                                    <!-- Download SVG icon from http://tabler.io/icons/icon/plus -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="icon icon-2">
                                        <path d="M12 5l0 14" />
                                        <path d="M5 12l14 0" />
                                    </svg>
                                </a>
                            </div>
                            <!-- BEGIN MODAL -->
                            <!-- END MODAL -->
                        </div>
                    </div>
                </div>
            </div> --}}
            @include('components.breadcrumb', ['breadcrumbs' => $breadcrumbs ?? []])

            <!-- END PAGE HEADER -->

            <!-- Main content -->
            <div class="page-content">
                {{-- <div class="page-header">
                    <h1>@yield('page-title', 'Dashboard')</h1>
                </div> --}}
                <div class="page-body">
                    @yield('content') <!-- Konten halaman spesifik -->
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="page-footer">
        @include('components.footer') <!-- Include Footer -->
    </div>

    <!-- Skrip JS, jika menggunakan Vite -->
    @vite('resources/js/app.js') <!-- Jika menggunakan Vite -->
    @if (session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'swal2-popup-custom'
                    }
                });
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: '{{ session('error') }}',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'swal2-popup-custom'
                    }
                });
            });
        </script>
    @endif



</body>

</html>
