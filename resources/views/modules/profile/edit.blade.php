@extends('layouts.tabler') <!-- Gunakan layout utama Tabler -->

@section('title', 'Profile')

@section('page-title', 'Welcome to the Dashboard')

@section('content')
    <div class="container-xl">
        <div class="row">
            <div class="col-md-12 mx-auto">

                <!-- Informasi Profil -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Update Profile Information</h3>
                    </div>
                    <div class="card-body">
                        @include('modules.profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Ubah Password -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Update Password</h3>
                    </div>
                    <div class="card-body">
                        @include('modules.profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Hapus Akun -->
                <div class="card mb-4 border-danger">
                    <div class="card-header bg-danger-lt">
                        <h3 class="card-title text-danger">Delete Account</h3>
                    </div>
                    <div class="card-body">
                        @include('modules.profile.partials.delete-user-form')
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
