@extends('layouts.tabler')

@section('title', 'Pengaturan Google Drive')

@section('content')

    <div class="container-fluid">
        <div class="card">
            <!-- Connection Status Card -->
            <div class="card-header">
                <h3 class="card-title">Integrasi Google Drive</h3>
            </div>

            <div class="card-body">
                @if ($googleUser)
                    <!-- Connected State -->
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="avatar avatar-xl"
                                style="background-image: url('{{ $googleUser['picture'] }}')"></span>
                        </div>
                        <div class="col">
                            <div class="d-flex align-items-center mb-1">
                                <h3 class="mb-0">{{ $googleUser['name'] }}</h3>
                                <span class="badge bg-green text-green-fg ms-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check"
                                        width="16" height="16" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M5 12l5 5l10 -10" />
                                    </svg>
                                    Terhubung
                                </span>
                            </div>
                            <div class="text-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail"
                                    width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                                    <path d="M3 7l9 6l9 -6" />
                                </svg>
                                {{ $googleUser['email'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <form action="{{ route('google.drive.revoke') }}" method="POST"
                                onsubmit="return confirm('Yakin ingin memutuskan koneksi Google Drive?')">
                                @csrf
                                <button type="submit" class="btn btn-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                                        <path d="M9 12h12l-3 -3" />
                                        <path d="M18 15l3 -3" />
                                    </svg>
                                    Putuskan Hubungan
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Disconnected State -->
                    <div class="empty">
                        <div class="empty-img">
                            <img src="{{ asset('static/illustrations/google-drive.svg') }}" height="128" alt="">
                        </div>
                        <p class="empty-title">Belum terhubung dengan Google Drive</p>
                        <p class="empty-subtitle text-muted">
                            Sambungkan akun Google Drive Anda untuk mulai menggunakan layanan penyimpanan cloud.
                        </p>
                        <div class="empty-action">
                            <a href="http://localhost:8001/google/redirect?redirect={{ urlencode(route('google.drive.callback')) }}"
                                class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-brand-google-drive">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 10l-6 10l-3 -5l6 -10z" />
                                    <path d="M9 15h12l-3 5h-12" />
                                    <path d="M15 15l-6 -10h6l6 10z" />
                                </svg>
                                Login dengan Google
                            </a>
                        </div>
                    </div>
                @endif
            </div>


            <!-- Authorization Process Section -->
            <div class="card-body border-top">
                <h3 class="mb-3">Proses Otorisasi</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Langkah-langkah Otorisasi</h4>
                                <ol class="steps steps-vertical">
                                    <li class="step-item">
                                        <div class="step-icon">
                                            <span class="step-number">1</span>
                                        </div>
                                        <div class="step-content">
                                            <h5 class="step-title">Klik "Login dengan Google"</h5>
                                            <p class="step-text text-muted">Anda akan diarahkan ke halaman login Google
                                            </p>
                                        </div>
                                    </li>
                                    <li class="step-item">
                                        <div class="step-icon">
                                            <span class="step-number">2</span>
                                        </div>
                                        <div class="step-content">
                                            <h5 class="step-title">Pilih Akun Google</h5>
                                            <p class="step-text text-muted">Pilih akun Google Drive yang ingin Anda
                                                hubungkan</p>
                                        </div>
                                    </li>
                                    <li class="step-item">
                                        <div class="step-icon">
                                            <span class="step-number">3</span>
                                        </div>
                                        <div class="step-content">
                                            <h5 class="step-title">Setujui Permintaan Akses</h5>
                                            <p class="step-text text-muted">Tinjau permintaan izin dan klik "Izinkan"
                                            </p>
                                        </div>
                                    </li>
                                    <li class="step-item">
                                        <div class="step-icon">
                                            <span class="step-number">4</span>
                                        </div>
                                        <div class="step-content">
                                            <h5 class="step-title">Selesai</h5>
                                            <p class="step-text text-muted">Anda akan kembali ke halaman Pengaturan
                                                Google Drive, dan akun yang berhasil dihubungkan akan ditampilkan dengan
                                                status .
                                                <span class="badge bg-green text-green-fg ms-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-check" width="16"
                                                        height="16" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M5 12l5 5l10 -10" />
                                                    </svg>
                                                    Terhubung
                                                </span>
                                            </p>
                                        </div>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Izin yang Dibutuhkan</h4>
                                <div class="alert alert-info">
                                    <div class="d-flex">
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-info-circle" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                                <path d="M12 8h.01" />
                                                <path d="M11 12h1v4h1" />
                                            </svg>
                                        </div>
                                        <div class="ms-3">
                                            <h4 class="alert-title">Akses Terbatas</h4>
                                            <div class="text-muted">
                                                Aplikasi hanya membutuhkan izin untuk mengakses dan mengelola file yang
                                                dibuat oleh aplikasi ini.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <span class="badge bg-blue-lt">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5" />
                                                        <path d="M12 12l8 -4.5" />
                                                        <path d="M12 12l0 9" />
                                                        <path d="M12 12l-8 -4.5" />
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="col">
                                                <small class="text-muted">Melihat informasi dasar akun Google
                                                    Anda</small>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <span class="badge bg-blue-lt">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                        <path
                                                            d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="col">
                                                <small class="text-muted">Membuat dan mengelola file di folder "Scan
                                                    Nilai Rapor"</small>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Drive Usage Information -->
            <div class="card-body border-top">
                <h3 class="mb-3">Informasi Penggunaan Google Drive</h3>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="bg-blue text-white avatar">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M7 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2" />
                                                <path d="M17 15h-12v-12" />
                                                <path d="M10 4l4 4l-4 4" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-medium">
                                            Akses Terbatas
                                        </div>
                                        <div class="text-muted">
                                            Aplikasi hanya akan mengakses folder <code>Scan Nilai Rapor</code> dan tidak
                                            akan melihat/memodifikasi file lain di Drive Anda
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="bg-green text-white avatar">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M9 12l2 2l4 -4" />
                                                <path
                                                    d="M12 3a12 12 0 0 0 8.5 3a12 12 0 0 1 -8.5 15a12 12 0 0 1 -8.5 -15a12 12 0 0 0 8.5 -3" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-medium">
                                            Keamanan Data
                                        </div>
                                        <div class="text-muted">
                                            Kami menggunakan standar keamanan OAuth 2.0 dan tidak menyimpan password
                                            Anda
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <h4>Tentang Penyimpanan Dokumen:</h4>
                    <div class="row row-cards">
                        <div class="col-md-4">
                            <div class="card card-sm">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <span class="bg-blue text-white avatar">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                    <path
                                                        d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div>
                                            <div class="font-weight-medium">Scan Nilai Rapot</div>
                                            <div class="text-muted">Disimpan otomatis di Google Drive Anda</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-sm">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <span class="bg-purple text-white avatar">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path
                                                        d="M5 4h4l3 3h7a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div>
                                            <div class="font-weight-medium">Struktur Folder</div>
                                            <div class="text-muted"><code>Scan Nilai Rapor/UUID/namafile</code></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-sm">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <span class="bg-yellow text-white avatar">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                                    <path d="M12 12l3 3" />
                                                    <path d="M12 7v5" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div>
                                            <div class="font-weight-medium">Kuota Penyimpanan</div>
                                            <div class="text-muted">Menggunakan kuota Google Drive akun Anda</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (session()->has('google_drive_user'))
                <div class="card-footer bg-transparent">
                    <div class="alert alert-success">
                        <div class="d-flex">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-shield-check"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M9 12l2 2l4 -4" />
                                    <path
                                        d="M12 3a12 12 0 0 0 8.5 3a12 12 0 0 1 -8.5 15a12 12 0 0 1 -8.5 -15a12 12 0 0 0 8.5 -3" />
                                </svg>
                            </div>
                            <div class="ms-3">
                                <h4 class="alert-title">Keamanan Data Terjamin</h4>
                                <div class="text-muted">
                                    Kami hanya menyimpan informasi dasar akun dan tidak memiliki akses ke password Anda.
                                    Anda dapat mencabut akses kapan saja.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection
