@extends('layouts.tabler')

@section('title', $title ?? 'Dashboard')

@section('page-title', 'Detail Siswa')

@section('content')
    <div class="container-fluid">

        <div class="card">



            <div class="card-header p-4 detail-siswa-card-header">
                <!-- Konten Utama -->
                <div class="detail-siswa-main-content">
                    <!-- Avatar -->
                    <div class="detail-siswa-avatar avatar avatar-xxl shadow"
                        style="background-image: url('{{ $student->fotoTerbaru ? asset('storage/' . $student->fotoTerbaru->path_foto) : asset('default-avatar.png') }}')">
                    </div>

                    <!-- Info Siswa -->
                    <div>
                        <div class="detail-siswa-info">
                            <h1 class="mb-1">{{ $student->nama }}</h1>
                            <div class="text-muted mb-2">
                                <span class="badge bg-blue-lt detail-siswa-badge">{{ $student->nipd }}</span>
                                <span class="badge bg-green-lt detail-siswa-badge">{{ $student->nisn }}</span>
                            </div>
                            <div class="detail-siswa-badges">
                                <span class="badge bg-{{ $student->jk == 'L' ? 'blue' : 'pink' }}-lt detail-siswa-badge">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-{{ $student->jk == 'L' ? 'gender-male' : 'gender-female' }}"
                                        width="16" height="16" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 14m-5 0a5 5 0 1 0 10 0a5 5 0 1 0 -10 0" />
                                        <path d="M19 5l-5.4 5.4" />
                                        <path d="M19 5h-5" />
                                        <path d="M19 5v5" />
                                    </svg>
                                    {{ $student->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </span>

                                <span class="badge bg-purple-lt detail-siswa-badge">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-cake"
                                        width="16" height="16" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M3 20h18v-8a3 3 0 0 0 -3 -3h-12a3 3 0 0 0 -3 3v8z" />
                                        <path
                                            d="M3 14.803c.312 .135 .654 .204 1 .197a2.4 2.4 0 0 0 2 -1a2.4 2.4 0 0 1 2 -1a2.4 2.4 0 0 1 2 1a2.4 2.4 0 0 0 2 1a2.4 2.4 0 0 0 2 -1a2.4 2.4 0 0 1 2 -1a2.4 2.4 0 0 1 2 1a2.4 2.4 0 0 0 2 1c.35 .007 .692 -.062 1 -.197" />
                                        <path d="M12 4l1.465 1.638a2 2 0 1 1 -3.015 .099l1.55 -1.737z" />
                                    </svg>
                                    {{ $student->tanggal_lahir_indo }}
                                    ({{ \Carbon\Carbon::parse($student->tanggal_lahir)->age }} tahun)
                                </span>

                                @if ($student->agama)
                                    <span class="badge bg-orange-lt detail-siswa-badge">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pray"
                                            width="16" height="16" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                            <path d="M7 20h8l-4 -4v-7l4 -3l-4 -3v-2" />
                                        </svg>
                                        {{ $student->agama->nama }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="detail-siswa-actions">

                    <a href="{{ route('induk.siswa') }}" class="btn btn-outline-warning">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler-arrow-left" width="24"
                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M5 12l14 0" />
                            <path d="M5 12l6 6" />
                            <path d="M5 12l6 -6" />
                        </svg>
                        Kembali
                    </a>

                    <a href="#" class="btn btn-info ms-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-calculator">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M18 2a3 3 0 0 1 3 3v14a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3v-14a3 3 0 0 1 3 -3zm-10 15a1 1 0 0 0 -1 1l.007 .127a1 1 0 0 0 1.993 -.117l-.007 -.127a1 1 0 0 0 -.993 -.883zm4 0a1 1 0 0 0 -1 1l.007 .127a1 1 0 0 0 1.993 -.117l-.007 -.127a1 1 0 0 0 -.993 -.883zm4 0a1 1 0 0 0 -1 1l.007 .127a1 1 0 0 0 1.993 -.117l-.007 -.127a1 1 0 0 0 -.993 -.883zm-8 -4a1 1 0 0 0 -1 1l.007 .127a1 1 0 0 0 1.993 -.117l-.007 -.127a1 1 0 0 0 -.993 -.883zm4 0a1 1 0 0 0 -1 1l.007 .127a1 1 0 0 0 1.993 -.117l-.007 -.127a1 1 0 0 0 -.993 -.883zm4 0a1 1 0 0 0 -1 1l.007 .127a1 1 0 0 0 1.993 -.117l-.007 -.127a1 1 0 0 0 -.993 -.883zm-1 -7h-6a2 2 0 0 0 -2 2v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2 -2v-1a2 2 0 0 0 -2 -2z" />
                        </svg>
                        Nilai PD
                    </a>
                </div>
            </div>

            <!-- Main content with tabs -->
            <div class="card-body p-0">
                <!-- Enhanced Tabs Navigation -->
                <div class="px-4 pt-3 border-bottom">
                    <ul class="nav nav-tabs nav-tabs-alt" data-bs-toggle="tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-biodata" class="nav-link active" data-bs-toggle="tab" role="tab">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-circle"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                    <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                    <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                                </svg>
                                Biodata
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-ortu" class="nav-link" data-bs-toggle="tab" role="tab">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                    <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                </svg>
                                Orang Tua
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-lokasi" class="nav-link" data-bs-toggle="tab" role="tab">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-pin"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                    <path
                                        d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z" />
                                </svg>
                                Lokasi & Bank
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-sosial" class="nav-link" data-bs-toggle="tab" role="tab">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-heart-handshake" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" />
                                    <path
                                        d="M12 6l-3.293 3.293a1 1 0 0 0 0 1.414l.543 .543c.69 .69 1.81 .69 2.5 0l1 -1a3.182 3.182 0 0 1 4.5 0l2.25 2.25" />
                                    <path d="M12.5 15.5l2 2" />
                                    <path d="M15 13l2 2" />
                                </svg>
                                Data Sosial
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-registrasi" class="nav-link" data-bs-toggle="tab" role="tab">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-school"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M22 9l-10 -4l-10 4l10 4l10 -4v6" />
                                    <path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4" />
                                </svg>
                                Registrasi
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-rombel" class="nav-link" data-bs-toggle="tab" role="tab">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users-group"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                    <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1" />
                                    <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                    <path d="M17 10h2a2 2 0 0 1 2 2v1" />
                                    <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                    <path d="M3 13v-1a2 2 0 0 1 2 -2h2" />
                                </svg>
                                Rombel
                            </a>
                        </li>

                        <li class="nav-item" role="presentation">
                            <a href="#tabs-dokumen" class="nav-link" data-bs-toggle="tab" role="tab">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-file-search">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                    <path d="M12 21h-5a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v4.5" />
                                    <path d="M16.5 17.5m-2.5 0a2.5 2.5 0 1 0 5 0a2.5 2.5 0 1 0 -5 0" />
                                    <path d="M18.5 19.5l2.5 2.5" />
                                </svg>
                                Dokumen PD
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Tabs Content -->
                <div class="tab-content p-4">
                    <!-- Tab Biodata -->
                    <div class="tab-pane active show fade" id="tabs-biodata" role="tabpanel">
                        @if (request('edit') === 'biodata')
                            @include('modules.students.partials.biodata_form')
                        @else
                            @include('modules.students.partials.biodata_view')
                        @endif
                    </div>


                    <!-- Tab Data Sosial -->
                    <div class="tab-pane  fade" id="tabs-sosial" role="tabpanel">

                        <div id="sosialView">
                            @include('modules.students.partials.sosial_view', [
                                'student' => $student,
                            ])
                        </div>

                        <div id="sosialForm" style="display:none;">
                            <form action="{{ route('induk.siswa.update-sosial', $student) }}" method="POST">
                                @csrf
                                @method('PUT')
                                @include('modules.students.partials.sosial_form', [
                                    'student' => $student,
                                ])

                                <div class="mt-3">
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                    <button type="button" class="btn btn-secondary"
                                        id="btn-cancel-sosial">Batal</button>
                                </div>
                            </form>
                        </div>


                    </div>


                    <!-- Tab Lokasi & Bank -->
                    <div class="tab-pane fade" id="tabs-lokasi" role="tabpanel">
                        <div id="lokasi-view">
                            @include('modules.students.partials.lokasi-bank_view')

                        </div>

                        <div id="lokasi-form" style="display:none;">
                            <form method="POST" action="{{ route('induk.siswa.update-lokasi', $student) }}">
                                @csrf
                                @method('PUT')
                                @include('modules.students.partials.lokasi-bank_form', [
                                    'student' => $student,
                                ])
                                <button type="submit" class="btn btn-success">Simpan</button>
                                <button type="button" class="btn btn-secondary" id="btn-cancel-lokasi">Batal</button>
                            </form>
                        </div>
                    </div>



                    <!-- Tab Orang Tua -->
                    <div class="tab-pane fade" id="tabs-ortu" role="tabpanel">

                        <div id="ortuView">
                            @include('modules.students.partials.ortu_view', [
                                'student' => $student,
                            ])
                        </div>

                        <div id="ortuForm" class="d-none">
                            <form action="{{ route('induk.siswa.update.ortu', $student) }}" method="POST">
                                @csrf
                                @method('PUT')
                                @include('modules.students.partials.ortu_form', [
                                    'student' => $student,
                                ])

                                <div class="mt-3">
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                    <button type="button" class="btn btn-secondary"
                                        onclick="toggleOrtuEdit(false)">Batal</button>
                                </div>
                            </form>
                        </div>


                    </div>

                    <!-- Tab Registrasi -->
                    <div class="tab-pane fade" id="tabs-registrasi" role="tabpanel">
                        @if ($student->riwayatSekolah)
                            <div class="card mb-4">
                                <div class="card-header bg-green-lt">
                                    <h3 class="card-title">Riwayat Sekolah</h3>
                                </div>
                                <div class="card-body">
                                    <div class="datagrid">
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">Jenis Pendaftar</div>
                                            <div class="datagrid-content">
                                                <span
                                                    class="badge bg-{{ $student->riwayatSekolah->jenis_pendaftar == 'Siswa Baru' ? 'green' : ($student->riwayatSekolah->jenis_pendaftar == 'Pindahan' ? 'orange' : 'blue') }}-lt">
                                                    {{ $student->riwayatSekolah->jenis_pendaftar }}
                                                </span>
                                            </div>

                                        </div>
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">Tanggal Masuk</div>
                                            <div class="datagrid-content">
                                                {{ $riwayatSekolah->tanggal_masuk_indo ?? '-' }}</div>
                                        </div>
                                        @if ($student->riwayatSekolah->kelas_diterima)
                                            <div class="datagrid-item">
                                                <div class="datagrid-title">Kelas Diterima</div>
                                                <div class="datagrid-content">
                                                    {{ $student->riwayatSekolah->kelas_diterima ?? '-' }}</div>
                                            </div>
                                        @endif
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">SKHUN</div>
                                            <div class="datagrid-content">
                                                {{ $student->riwayatSekolah->skhun ?? '-' }}</div>
                                        </div>

                                        @if ($student->riwayatSekolah->jenis_pendaftar === 'Siswa Baru')
                                            <div class="datagrid-item">
                                                <div class="datagrid-title">Sekolah Asal</div>
                                                <div class="datagrid-content">
                                                    {{ $student->riwayatSekolah->sekolah_asal ?? '-' }}</div>
                                            </div>
                                            <div class="datagrid-item">
                                                <div class="datagrid-title">Tanggal Ijazah</div>
                                                <div class="datagrid-content">
                                                    {{ $student->riwayatSekolah->tanggal_ijazah_indo ?? '-' }}
                                                </div>
                                            </div>
                                            <div class="datagrid-item">
                                                <div class="datagrid-title">Nomor Ijazah</div>
                                                <div class="datagrid-content">
                                                    {{ $student->riwayatSekolah->nomor_ijazah ?? '-' }}</div>
                                            </div>
                                            <div class="datagrid-item">
                                                <div class="datagrid-title">Lama Belajar</div>
                                                <div class="datagrid-content">
                                                    {{ $student->riwayatSekolah->lama_belajar ? $student->riwayatSekolah->lama_belajar . ' tahun' : '-' }}
                                                </div>
                                            </div>
                                        @elseif ($student->riwayatSekolah->jenis_pendaftar === 'Pindahan')
                                            <div class="datagrid-item">
                                                <div class="datagrid-title">Dari Sekolah</div>
                                                <div class="datagrid-content">
                                                    {{ $student->riwayatSekolah->dari_sekolah ?? '-' }}</div>
                                            </div>
                                            <div class="datagrid-item">
                                                <div class="datagrid-title">Alasan Pindah</div>
                                                <div class="datagrid-content">
                                                    {{ $student->riwayatSekolah->alasan_pindah ?? '-' }}</div>
                                            </div>
                                        @elseif ($student->riwayatSekolah->jenis_pendaftar === 'Kembali Bersekolah')
                                            <div class="datagrid-item">
                                                <div class="datagrid-title">Catatan Kembali</div>
                                                <div class="datagrid-content">
                                                    {{ $student->riwayatSekolah->catatan_kembali ?? '-' }}</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-info">
                                <div class="d-flex">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-info-circle" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                            <path d="M12 8l.01 0" />
                                            <path d="M11 12l1 0l0 4l1 0" />
                                        </svg>
                                    </div>
                                    <div class="ms-3">
                                        <h4>Data Riwayat Sekolah Belum Tersedia</h4>
                                        <div class="text-muted">Silahkan tambahkan data riwayat sekolah siswa.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Tab Rombel -->
                    <div class="tab-pane fade" id="tabs-rombel" role="tabpanel">
                        <div class="card">
                            <div class="card-header bg-indigo-lt">
                                <div>
                                    <h3 class="card-title mb-1">Rombongan Belajar</h3>
                                    <div class="text-muted small">Riwayat kelas dan wali kelas siswa (read-only)</div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if ($riwayatRombel->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover table-nowrap card-table">
                                            <thead>
                                                <tr>
                                                    <th>Tahun Ajaran</th>
                                                    <th>Semester</th>
                                                    <th>Kelas</th>


                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($riwayatRombel as $rombel)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="me-2 text-indigo">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon"
                                                                        width="24" height="24" viewBox="0 0 24 24"
                                                                        stroke-width="2" stroke="currentColor"
                                                                        fill="none" stroke-linecap="round"
                                                                        stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                            fill="none" />
                                                                        <path d="M22 9l-10 -4l-10 4l10 4l10 -4v6" />
                                                                        <path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4" />
                                                                    </svg>
                                                                </div>
                                                                <div>
                                                                    {{ $rombel->tahunPelajaran ? $rombel->tahunPelajaran->tahun_ajaran : '-' }}
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="badge
                                            {{ $rombel->semester && $rombel->semester->semester == 1 ? 'bg-blue-lt' : 'bg-orange-lt' }}">
                                                                {{ $rombel->semester ? 'Semester ' . $rombel->semester->semester : '-' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <span class="avatar avatar-sm bg-azure-lt me-2">
                                                                    {{ $rombel->rombel ? substr($rombel->rombel->tingkat, 0, 1) : '-' }}
                                                                </span>

                                                            </div>
                                                        </td>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="mt-4 alert alert-info">
                                        <div class="d-flex align-items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-info-circle" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                <path d="M12 8l.01 0" />
                                                <path d="M11 12l1 0l0 4l1 0" />
                                            </svg>
                                            <div class="ms-3">
                                                Untuk mengubah data rombongan belajar, silakan kunjungi menu <strong>Buku
                                                    Induk > Akademik > Rombel</strong>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="empty">
                                        <div class="empty-img">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-school-off" width="48"
                                                height="48" viewBox="0 0 24 24" stroke-width="1.5" stroke="#adb5bd"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M22 9l-10 -4l-2.136 .854m-2.864 1.146l-5 2l10 4l.697 -.279m2.878 -1.151l6.425 -2.57v6" />
                                                <path d="M6 10.6v5.4a6 3 0 0 0 10.4 2.4m1.6 -2.4v-3.4" />
                                                <path d="M3 3l18 18" />
                                            </svg>
                                        </div>
                                        <p class="empty-title">Belum ada data rombongan belajar</p>
                                        <p class="empty-subtitle text-muted">
                                            Siswa belum terdaftar dalam rombongan belajar. Silakan daftarkan melalui menu
                                            pengelolaan rombel.
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Tab Dokumen -->
                    <div class="tab-pane fade" id="tabs-dokumen" role="tabpanel">
                        <div class="card">
                            <div class="card-header bg-indigo-lt">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3 class="card-title mb-1">Dokumen Pribadi</h3>
                                        <div class="text-muted small">Kelola dokumen penting siswa</div>
                                    </div>
                                    <button class="btn btn-primary btn-pill" data-bs-toggle="modal"
                                        data-bs-target="#uploadDocumentModal">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-upload" width="20" height="20"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                            <path d="M7 9l5 -5l5 5" />
                                            <path d="M12 4l0 12" />
                                        </svg>
                                        Unggah Dokumen
                                    </button>
                                </div>
                            </div>
                            <div class="card-body" id="document-content">
                                @include('modules.students.partials.student-documents', [
                                    'student' => $student,
                                ])
                            </div>
                        </div>
                    </div>

                    <!-- Modal Upload Dokumen -->
                    <div class="modal fade" id="uploadDocumentModal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Unggah Dokumen Siswa</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form id="documentUploadForm"
                                    action="{{ route('student.documents.store', $student->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Jenis Dokumen</label>
                                            <select class="form-select" name="tipe_dokumen" required>
                                                <option value="">Pilih Jenis Dokumen</option>
                                                <option value="kk">Kartu Keluarga</option>
                                                <option value="akta_kelahiran">Akta Kelahiran</option>
                                                <option value="surat_pindah">Surat Pindah</option>
                                                <option value="ijazah_tk">Ijazah TK</option>
                                                <option value="ijazah_sd">Ijazah SD</option>
                                                <option value="lainnya">Lainnya</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Keterangan (Opsional)</label>
                                            <input type="text" class="form-control" name="keterangan"
                                                placeholder="Contoh: KK atas nama ibu">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">File Dokumen</label>
                                            <input type="file" class="form-control" name="file" required
                                                accept=".pdf,.jpg,.jpeg,.png">
                                            <small class="text-muted">Format: PDF, JPG, PNG (Maks. 5MB)</small>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-link link-secondary"
                                            data-bs-dismiss="modal">
                                            Batal
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-upload me-2"></i> Unggah
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Preview -->
                    <div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Preview Dokumen</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <iframe id="previewFrame" src=""
                                        style="width:100%; height:70vh; border:none;"></iframe>
                                    <div id="imagePreview" class="text-center"></div>
                                </div>
                                <div class="modal-footer">
                                    <a id="downloadBtn" href="#" class="btn btn-primary">
                                        <i class="fas fa-download me-2"></i> Download
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Modal Konfirmasi Hapus --}}
    <x-modal.konfirmasi id="modalKonfirmasiHapus" title="Hapus Data Terpilih?"
        body="Data yang dipilih akan dihapus permanen. Tindakan ini tidak dapat dibatalkan." btnLabel="Ya, Hapus"
        btnColor="danger" :formAction="''" {{-- formAction dikosongkan, nanti diisi JS --}} method="DELETE" />

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize tooltips
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl)
                });

                // Smooth tab transitions
                document.querySelectorAll('[data-bs-toggle="tab"]').forEach(tab => {
                    tab.addEventListener('show.bs.tab', function(e) {
                        let activePane = document.querySelector('.tab-pane.active');
                        if (activePane) {
                            activePane.classList.add('fade-out');
                            setTimeout(() => {
                                activePane.classList.remove('fade-out');
                            }, 300);
                        }
                    });
                });
            });
        </script>

        <style>
            .fade-out {
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .avatar-xxl {
                width: 120px;
                height: 120px;
            }

            .card-header h1 {
                font-size: 1.75rem;
                font-weight: 600;
            }

            .datagrid-item {
                border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            }

            .datagrid-title {
                font-weight: 500;
                color: #495057;
            }

            .nav-tabs-alt .nav-link {
                padding: 0.75rem 1.25rem;
                border-radius: 4px 4px 0 0;
                transition: all 0.2s;
            }

            .nav-tabs-alt .nav-link:hover {
                background-color: rgba(0, 0, 0, 0.03);
            }

            .nav-tabs-alt .nav-link.active {
                border-bottom: 3px solid var(--tblr-primary);
                font-weight: 500;
            }

            .card-header h3.card-title {
                font-size: 1.1rem;
                font-weight: 600;
            }
        </style>

        <script>
            const STUDENT_ID = "{{ $student->id }}";

            function bindDocumentEvents() {
                // Hapus semua event listener sebelumnya untuk menghindari duplikasi
                $(document).off('click', '.btn-preview');
                $(document).off('click', '.btn-delete-doc');

                // PREVIEW dengan event delegation
                $(document).on('click', '.btn-preview', function() {
                    const url = $(this).data('url');
                    const isImage = url.match(/\.(jpg|jpeg|png|webp)$/i);

                    if (isImage) {
                        $('#previewFrame').hide();
                        $('#imagePreview').html(`<img src="${url}" class="img-fluid" alt="Preview">`).show();
                    } else {
                        $('#imagePreview').hide();
                        $('#previewFrame').attr('src', url).show();
                    }

                    $('#downloadBtn').attr('href', url);
                    $('#previewModal').modal('show');
                });

                // DELETE MODAL dengan event delegation
                $(document).on('click', '.btn-delete-doc', function() {
                    const actionUrl = $(this).data('action');
                    const targetModal = $($(this).data('target-modal'));
                    targetModal.find('form').attr('action', actionUrl);
                    targetModal.modal('show');
                });
            }

            function reloadDocumentSection(studentId) {
                $.get(`/student-documents/${studentId}/documents/partial`, function(html) {
                    $('#document-content').html(html);
                    bindDocumentEvents(); // Rebind events setelah konten diganti
                }).fail(function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message || 'Gagal memuat dokumen'
                    });
                });
            }

            $(document).ready(function() {
                bindDocumentEvents(); // Bind awal

                // === UPLOAD ===
                $('#documentUploadForm').on('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);

                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        beforeSend: function() {
                            $('#documentUploadForm button[type="submit"]').prop('disabled', true)
                                .html('<i class="fas fa-spinner fa-spin me-2"></i> Mengupload...');
                        },
                        success: function(response) {
                            $('#uploadDocumentModal').modal('hide');
                            $('#documentUploadForm')[0].reset(); // Reset form

                            // ✅ Reset tombol submit ke keadaan awal
                            $('#documentUploadForm button[type="submit"]').prop('disabled', false)
                                .html('<i class="fas fa-upload me-2"></i> Unggah');

                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: response.message || 'Dokumen berhasil diupload',
                                showConfirmButton: false,
                                timer: 3000
                            });

                            reloadDocumentSection(STUDENT_ID);
                        },
                        // Di dalam $('#documentUploadForm').on('submit', ...)
                        error: function(xhr) {
                            let errorMessage = 'Terjadi kesalahan saat upload';
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                // Jika ada error validasi
                                errorMessage = Object.values(xhr.responseJSON.errors).join('<br>');
                            } else if (xhr.responseJSON?.message) {
                                errorMessage = xhr.responseJSON.message;
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                html: errorMessage,
                                timer: 7000,
                                timerProgressBar: true,
                            });

                            $('#documentUploadForm button[type="submit"]').prop('disabled', false)
                                .html('<i class="fas fa-upload me-2"></i> Unggah');
                        }
                    });
                });

                // === HAPUS ===
                $('#modalKonfirmasiHapus form').on('submit', function(e) {
                    e.preventDefault();
                    const form = $(this);
                    const actionUrl = form.attr('action');

                    $.ajax({
                        url: actionUrl,
                        type: 'POST',
                        data: form.serialize(),
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'success',
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    customClass: {
                                        popup: 'swal2-popup-custom'
                                    }

                                });

                                $('#modalKonfirmasiHapus').modal('hide');
                                reloadDocumentSection(STUDENT_ID);
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: xhr.responseJSON?.message ||
                                    'Terjadi kesalahan saat menghapus dokumen'
                            });
                        }
                    });
                });
            });
        </script>

        {{-- SCRIPT TABS DAN EDIT --}}
        <script>
            function toggleEdit(section) {
                const view = document.getElementById(section + '-view');
                const form = document.getElementById(section + '-form');

                if (view && form) {
                    const isEditing = form.style.display === 'block';
                    view.style.display = isEditing ? 'block' : 'none';
                    form.style.display = isEditing ? 'none' : 'block';
                }
            }
        </script>

        <script>
            function toggleOrtuEdit(edit = true) {
                document.getElementById('ortuView').classList.toggle('d-none', edit);
                document.getElementById('ortuForm').classList.toggle('d-none', !edit);
                document.getElementById('editOrtuBtn').classList.toggle('d-none', edit);
            }
        </script>

        <script>
            document.getElementById('btn-edit-lokasi').addEventListener('click', function() {
                document.getElementById('lokasi-view').style.display = 'none';
                document.getElementById('lokasi-form').style.display = 'block';
            });

            document.getElementById('btn-cancel-lokasi').addEventListener('click', function() {
                document.getElementById('lokasi-form').style.display = 'none';
                document.getElementById('lokasi-view').style.display = 'block';
            });
        </script>

        <script>
            document.getElementById('btn-edit-sosial').addEventListener('click', function() {
                document.getElementById('sosialView').style.display = 'none';
                document.getElementById('sosialForm').style.display = 'block';
            });

            document.getElementById('btn-cancel-sosial').addEventListener('click', function() {
                document.getElementById('sosialForm').style.display = 'none';
                document.getElementById('sosialView').style.display = 'block';
            });
        </script>





        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Inisialisasi flatpickr untuk edit form tanggal lahir
                window.initializeFlatpickr("#tanggal_lahir_display", {
                    altInput: true,
                    altFormat: "d F Y",
                    dateFormat: "Y-m-d",
                    maxDate: "today",
                    allowInput: true,
                    locale: "id",
                    defaultDate: document.getElementById('tanggal_lahir').value || null,
                    onChange: function(selectedDates, dateStr) {
                        document.getElementById('tanggal_lahir').value = dateStr;
                    }
                });

                // Validasi sebelum submit (optional)
                const form = document.getElementById('formEditSiswa'); // Ganti dengan ID form edit kamu
                form.addEventListener('submit', function(e) {
                    const displayInput = document.getElementById('tanggal_lahir_display');
                    const hiddenInput = document.getElementById('tanggal_lahir');

                    if (!hiddenInput.value) {
                        displayInput.classList.add('is-invalid');
                        e.preventDefault(); // Cegah submit
                    } else {
                        displayInput.classList.remove('is-invalid');
                    }
                });
            });
        </script>
    @endpush
@endsection
