<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Welcome')</title>
    <!-- Tabler Core CSS -->
    @vite('resources/css/app.css')
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #206bc4 0%, #8256d0 100%);
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }

        .dark .hero-gradient {
            background: linear-gradient(135deg, #1c3f6e 0%, #4d2a7a 100%);
        }
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
</head>

<body class="d-flex flex-column">
    <!-- Header -->
    <header class="navbar navbar-expand-md navbar-light d-print-none">
        <div class="container-xl">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                <a href="/">
                    <span class="text-primary">Siesde</span>
                </a>
            </h1>
            <div class="navbar-nav flex-row order-md-last">
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown">
                        <span class="avatar avatar-sm" style="background-image: url(/static/avatars/000m.jpg)"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <a href="#" class="dropdown-item">Settings</a>
                        <a href="#" class="dropdown-item">Profile</a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">Logout</a>
                    </div>
                </div>
            </div>
            <div class="collapse navbar-collapse" id="navbar-menu">
                <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#features">
                                <span class="nav-link-title">Features</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#pricing">
                                <span class="nav-link-title">Pricing</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#contact">
                                <span class="nav-link-title">Contact</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="ms-md-3 pe-3 pe-md-0">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary ms-2">
                                Register
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-gradient text-white py-6 py-lg-8">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Build amazing things with <span class="text-yellow">Siesde</span>
                    </h1>
                    <p class="lead mb-4">The most powerful platform to streamline your workflow and boost productivity.
                        Designed for modern teams and individuals.</p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('register') }}" class="btn btn-lg btn-yellow">Get Started</a>
                        <a href="#features" class="btn btn-lg btn-outline-white">Learn More</a>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <img src="https://tabler.io/static/illustrations/undraw_rocket.svg" alt="Hero illustration"
                        class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-6 py-lg-8 bg-body">
        <div class="container">
            <div class="text-center mb-6">
                <h2 class="h1">Powerful Features</h2>
                <p class="text-muted">Everything you need to succeed in one place</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card card-borderless">
                        <div class="card-body text-center">
                            <div class="feature-icon bg-blue text-white mb-3 mx-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-bolt"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M13 3l0 7l6 0l-8 11l0 -7l-6 0l8 -11"></path>
                                </svg>
                            </div>
                            <h3 class="mb-2">Lightning Fast</h3>
                            <p class="text-muted">Optimized for speed with instant response times and smooth
                                performance.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-borderless">
                        <div class="card-body text-center">
                            <div class="feature-icon bg-green text-white mb-3 mx-auto">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-shield-lock" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M12 3a12 12 0 0 0 8.5 3a12 12 0 0 1 -8.5 15a12 12 0 0 1 -8.5 -15a12 12 0 0 0 8.5 -3">
                                    </path>
                                    <path d="M12 11m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"></path>
                                    <path d="M12 12l0 2.5"></path>
                                </svg>
                            </div>
                            <h3 class="mb-2">Secure & Private</h3>
                            <p class="text-muted">Enterprise-grade security with end-to-end encryption and privacy
                                controls.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-borderless">
                        <div class="card-body text-center">
                            <div class="feature-icon bg-purple text-white mb-3 mx-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-devices"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M13 9a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-6a1 1 0 0 1 -1 -1v-10z">
                                    </path>
                                    <path d="M18 8v-3a1 1 0 0 0 -1 -1h-13a1 1 0 0 0 -1 1v12a1 1 0 0 0 1 1h9"></path>
                                    <path d="M16 9h2"></path>
                                </svg>
                            </div>
                            <h3 class="mb-2">Cross Platform</h3>
                            <p class="text-muted">Works seamlessly across all your devices with real-time sync.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-6 py-lg-8 bg-blue-lt">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="h1 mb-3">Ready to get started?</h2>
                    <p class="lead text-muted mb-4 mb-lg-0">Join thousands of satisfied users today.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5">Sign Up Free</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer footer-transparent py-6">
        <div class="container">
            <div class="row text-center align-items-center flex-row-reverse">
                <div class="col-lg-auto ms-lg-auto">
                    <ul class="list-inline list-inline-dots mb-0">
                        <li class="list-inline-item"><a href="#" class="link-secondary">Documentation</a></li>
                        <li class="list-inline-item"><a href="#" class="link-secondary">License</a></li>
                        <li class="list-inline-item"><a href="#" class="link-secondary">Changelog</a></li>
                    </ul>
                </div>
                <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                    <p class="text-muted mb-0">Copyright © 2023 YourApp. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Tabler Core JS -->
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>
</body>

</html>
