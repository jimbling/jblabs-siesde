@extends('layouts.tabler') <!-- Gunakan layout utama Tabler -->

@section('title', $title ?? 'Dashboard')


@section('page-title', 'Welcome to the Dashboard')

@section('content')
    <div class="container-xl">
        <div class="card">
            <div class="row g-0">
                <!-- Sidebar Menu -->
                <div class="col-12 col-md-3 border-end">
                    <div class="card-body">
                        <h4 class="subheader">Pengaturan</h4>
                        <div class="list-group list-group-transparent">
                            <a href="#" data-target="my-account"
                                class="list-group-item list-group-item-action active">Akun</a>
                            <a href="#" data-target="hak-akses" class="list-group-item list-group-item-action">Hak
                                Akses</a>
                            <a href="#" data-target="ijin" class="list-group-item list-group-item-action">Ijin</a>
                        </div>
                    </div>
                </div>

                <!-- Konten Dinamis (Semua dalam satu halaman) -->
                <div class="col-12 col-md-9 d-flex flex-column">
                    <div class="card-body">
                        <!-- My Account -->
                        <div id="my-account" class="settings-section">
                            <h2 class="mb-4">Pengaturan Akun</h2>

                            <div class="col-md-12 mx-auto">

                                <!-- Informasi Profil -->
                                <div class="card mb-4">

                                    <div class="card-body">

                                        @include('modules.profile.partials.update-profile-information-form')
                                    </div>
                                </div>

                                <!-- Ubah Password -->
                                <div class="card mb-4">

                                    <div class="card-body">
                                        @include('modules.profile.partials.update-password-form')
                                    </div>
                                </div>

                                <!-- Hapus Akun -->
                                <div class="card mb-4 border-danger">

                                    <div class="card-body">
                                        @include('modules.profile.partials.delete-user-form')
                                    </div>
                                </div>

                            </div>

                        </div>




                        <!-- Hak Akses -->
                        <div id="hak-akses" class="settings-section d-none">
                            <h2 class="mb-4">Hak Akses Saya</h2>

                            @php
                                $permissions = auth()->user()->getPermissionNames();
                            @endphp

                            @if ($permissions->isEmpty())
                                <div class="alert alert-warning">
                                    Anda belum memiliki hak akses khusus.
                                </div>
                            @else
                                <ul class="list-group">
                                    @foreach ($permissions as $permission)
                                        <li class="list-group-item">
                                            {{ $permission }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>


                        <!-- Billing & Invoices -->
                        <div id="ijin" class="settings-section d-none">
                            <h2 class="mb-4">Peran Saya</h2>
                            @php
                                $roles = auth()->user()->getRoleNames();
                            @endphp

                            @if ($roles->isEmpty())
                                <div class="alert alert-info">
                                    Anda belum memiliki peran (role).
                                </div>
                            @else
                                <ul class="list-group mb-4">
                                    @foreach ($roles as $role)
                                        <li class="list-group-item">{{ $role }}</li>
                                    @endforeach
                                </ul>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery untuk Navigasi -->

    <script>
        $(document).ready(function() {
            $('.list-group-item').click(function(e) {
                e.preventDefault();

                // Hapus class 'active' dari semua menu dan tambahkan ke yang diklik
                $('.list-group-item').removeClass('active');
                $(this).addClass('active');

                // Sembunyikan semua section, lalu tampilkan yang sesuai dengan menu yang diklik
                $('.settings-section').addClass('d-none');
                $('#' + $(this).data('target')).removeClass('d-none');
            });
        });
    </script>
@endsection
