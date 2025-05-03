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

    <!-- Sidebar -->
    <div class="sidebar">
        @include('components.menu-nav') <!-- Include Sidebar -->
    </div>

    <!-- Konten Utama -->
    <div class="page-wrapper">
        <!-- Navbar -->
        @include('components.top-nav') <!-- Include Navbar -->

        @include('components.breadcrumb', ['breadcrumbs' => $breadcrumbs ?? []])

        <div class="page-content">
            <div class="page-body">
                @yield('content') <!-- Konten halaman spesifik -->
            </div>
        </div>

        <!-- Footer -->
        <div class="page-footer">
            @include('components.footer') <!-- Include Footer -->
        </div>

    </div>

    @vite('resources/js/app.js')
    @stack('scripts')

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
                    timer: 7000,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'swal2-popup-custom'
                    }
                });
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Ada kesalahan dalam input!',
                    html: `
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                `,
                    showConfirmButton: false,
                    timer: 7000,
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
