<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>

    @php $favicon = system_setting('favicon'); @endphp

    @if ($favicon)
        <link rel="icon" href="{{ asset('storage/' . $favicon) }}" type="image/x-icon">
        <link rel="shortcut icon" href="{{ asset('storage/' . $favicon) }}" type="image/x-icon">
    @else
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    @endif

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        @import url("https://rsms.me/inter/inter.css");
    </style>

    <script>
        document.documentElement.setAttribute('data-bs-theme', localStorage.getItem('theme') || 'light');
    </script>

    @vite('resources/css/app.css')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
</head>

<body class="d-flex flex-column">

    <!-- Sidebar -->
    <div class="sidebar">
        @include('components.menu-nav') <!-- Include Sidebar -->
    </div>

    <!-- Konten Utama -->
    <div class="page-wrapper d-flex flex-column flex-grow-1">
        <!-- Navbar -->
        @include('components.top-nav') <!-- Include Navbar -->

        @if (!empty($breadcrumbs))
            @include('components.breadcrumb', ['breadcrumbs' => $breadcrumbs])
        @endif

        <div class="page-content flex-grow-1">
            <div class="page-body">
                @yield('content') <!-- Konten halaman spesifik -->
            </div>
        </div>

        <!-- Footer -->
        <div class="page-footer">
            @include('components.footer') <!-- Include Footer -->
        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    @vite('resources/js/app.js')
    @stack('scripts')


    @if (session('import_error_file'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Proses impor sebagian gagal!',
                    html: `
                <p>Ada beberapa data yang tidak valid.</p>
                <p>Silakan cek kesalahan pada baris terakhir data siswa Anda untuk mengetahui letak masalahnya.</p>
                <a href="{{ session('import_error_file') }}" target="_blank" onclick="Swal.close()" class="swal2-confirm swal2-styled" style="display: inline-block; margin-top: 10px;">
                    Unduh File Kesalahan
                </a>
            `,
                    showConfirmButton: true,
                    confirmButtonText: 'Tutup',
                    customClass: {
                        popup: 'swal2-popup-custom'
                    }
                });
            });
        </script>
    @endif


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

    @if (session('error') && !session('import_error_file'))
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
