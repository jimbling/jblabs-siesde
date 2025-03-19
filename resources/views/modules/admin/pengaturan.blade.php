@extends('layouts.tabler') <!-- Gunakan layout utama Tabler -->

@section('title', 'Dashboard')

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
                            <a href="#" data-target="notifications"
                                class="list-group-item list-group-item-action">Pembaruan</a>
                            <a href="#" data-target="connected-apps"
                                class="list-group-item list-group-item-action">Pemeliharaan</a>
                            <a href="#" data-target="plans" class="list-group-item list-group-item-action">Hak
                                Akses</a>
                            <a href="#" data-target="billing" class="list-group-item list-group-item-action">Ijin</a>
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




                        <!-- Notifications -->
                        <div id="notifications" class="settings-section d-none">
                            <h2 class="mb-4">Pembaruan</h2>
                            <p>Pengaturan pembaruan aplikasi</p>
                        </div>

                        <!-- Connected Apps -->
                        <div id="connected-apps" class="settings-section d-none">
                            <h2 class="mb-4">Pemeliharaan</h2>
                            <p>Kelola dan Backup Database Sistem</p>
                        </div>

                        <!-- Plans -->
                        <div id="plans" class="settings-section d-none">
                            <h2 class="mb-4">Plans</h2>
                            <p>Kelola paket langganan Anda.</p>
                        </div>

                        <!-- Billing & Invoices -->
                        <div id="billing" class="settings-section d-none">
                            <h2 class="mb-4">Billing & Invoices</h2>
                            <p>Kelola tagihan dan faktur Anda.</p>
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
