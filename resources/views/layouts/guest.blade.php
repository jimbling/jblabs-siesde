<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <style>
        @import url("https://rsms.me/inter/inter.css");
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let theme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', theme);
        });
    </script>
    @php $favicon = system_setting('favicon'); @endphp

    @if ($favicon)
        <link rel="icon" href="{{ asset('storage/' . $favicon) }}" type="image/x-icon">
        <link rel="shortcut icon" href="{{ asset('storage/' . $favicon) }}" type="image/x-icon">
    @else
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    @endif
    <!-- Link ke CSS, jika menggunakan Vite atau Laravel Mix -->
    @vite('resources/css/app.css') <!-- Jika menggunakan Vite -->

</head>



<body class="antialiased">
    <div class="d-flex flex-column justify-content-center align-items-center min-vh-100 pt-6">
        <div class="text-center mb-4">
            <!-- BEGIN NAVBAR LOGO -->
            <a href=".">
                <img src="{{ asset('storage/' . system_setting('logo')) }}" alt="Logo"
                    style="height: 100px; width: auto;">

            </a>
        </div>


        <div class="w-100 shadow-md overflow-hidden rounded">
            {{ $slot }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi fungsi dismiss alert
            document.querySelectorAll('.alert-dismissible .btn-close').forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('.alert').remove();
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.querySelector('form');
            const loginButton = document.getElementById('loginButton');
            const buttonText = loginButton.querySelector('.button-text');
            const spinner = loginButton.querySelector('.spinner-border');

            loginForm.addEventListener('submit', function() {
                loginButton.disabled = true;
                buttonText.classList.add('d-none');
                spinner.classList.remove('d-none');
            });
        });
    </script>
    <script>
        document.querySelector('.toggle-password').addEventListener('click', function() {
            const passwordField = document.getElementById('passwordField');
            const visibleIcon = this.querySelector('.password-visible-icon');
            const hiddenIcon = this.querySelector('.password-hidden-icon');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                visibleIcon.classList.add('d-none');
                hiddenIcon.classList.remove('d-none');
            } else {
                passwordField.type = 'password';
                visibleIcon.classList.remove('d-none');
                hiddenIcon.classList.add('d-none');
            }
        });
    </script>

</body>


</html>
