<header class="navbar-expand-md">

    <div class="navbar">
        <div class="container-xl">
            <div class="row flex-fill align-items-center">
                <div class="col">
                    <!-- BEGIN NAVBAR MENU -->
                    <ul class="navbar-nav">
                        <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
                            <a class="nav-link" href="/dashboard">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                        <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                        <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                        <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                    </svg>
                                </span>
                                <span class="nav-link-title"> Home </span>
                            </a>
                        </li>


                        {{-- <li class="nav-item {{ Request::is('profile') ? 'active' : '' }}">
                            <a class="nav-link" href="./profile">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <!-- Download SVG icon from http://tabler.io/icons/icon/checkbox -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                        <path d="M9 11l3 3l8 -8" />
                                        <path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9" />
                                    </svg>
                                </span>
                                <span class="nav-link-title"> Profile </span>
                            </a>
                        </li> --}}

                        <li class="nav-item dropdown {{ Request::is('pengaturan/*') ? 'active' : '' }}">
                            <a class="nav-link dropdown-toggle" href="#navbar-admin" data-bs-toggle="dropdown"
                                data-bs-auto-close="outside" role="button" aria-expanded="false">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-shield-cog">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M12 21a12 12 0 0 1 -8.5 -15a12 12 0 0 0 8.5 -3a12 12 0 0 0 8.5 3c.568 1.933 .635 3.957 .223 5.89" />
                                        <path d="M19.001 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M19.001 15.5v1.5" />
                                        <path d="M19.001 21v1.5" />
                                        <path d="M22.032 17.25l-1.299 .75" />
                                        <path d="M17.27 20l-1.3 .75" />
                                        <path d="M15.97 17.25l1.3 .75" />
                                        <path d="M20.733 20l1.3 .75" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">Administrator</span>
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item {{ request()->routeIs('pengaturan.sistem') ? 'active' : '' }}"
                                    href="{{ route('pengaturan.sistem') }}">
                                    Pengaturan Sistem
                                </a>
                                <a class="dropdown-item {{ request()->routeIs('pengaturan.akses') ? 'active' : '' }}"
                                    href="{{ route('pengaturan.akses') }}">
                                    Pengaturan Akses
                                </a>
                                <a class="dropdown-item {{ request()->routeIs('pengaturan.pembaruan') ? 'active' : '' }}"
                                    href="{{ route('pengaturan.pembaruan') }}">
                                    Pembaruan Aplikasi
                                </a>
                                <a class="dropdown-item {{ request()->routeIs('pengaturan.pemeliharaan') ? 'active' : '' }}"
                                    href="{{ route('pengaturan.pemeliharaan') }}">
                                    Pemeliharaan
                                </a>
                            </div>

                        </li>



                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#navbar-addons" data-bs-toggle="dropdown"
                                data-bs-auto-close="outside" role="button" aria-expanded="false">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <!-- Download SVG icon from http://tabler.io/icons/icon/plus -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                        <path d="M12 5l0 14" />
                                        <path d="M5 12l14 0" />
                                    </svg>
                                </span>
                                <span class="nav-link-title"> Addons </span>
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="./icons.html"> Icons </a>
                                <a class="dropdown-item" href="./emails.html"> Emails </a>
                                <a class="dropdown-item" href="./flags.html"> Flags </a>
                                <a class="dropdown-item" href="./illustrations.html"> Illustrations </a>
                                <a class="dropdown-item" href="./payment-providers.html"> Payment
                                    providers </a>
                            </div>
                        </li>

                    </ul>
                    <!-- END NAVBAR MENU -->
                </div>

            </div>
        </div>
    </div>

</header>
<!-- END NAVBAR  -->
