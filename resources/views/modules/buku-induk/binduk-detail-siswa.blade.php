@extends('layouts.tabler')
@section('title', $title ?? 'Dashboard')

@section('page-title', 'Welcome to the Dashboard')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/print.css') }}" media="print">
    <div class="container-fluid">



        <!-- Header Halaman (Hanya Tampil di Layar) -->
        <div class="col-sm-12 col-lg-12 mb-4">
            <div class="card shadow-md">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-primary text-white avatar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-address-book">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M20 6v12a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2z" />
                                    <path d="M10 16h6" />
                                    <path d="M13 11m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                    <path d="M4 8h3" />
                                    <path d="M4 12h3" />
                                    <path d="M4 16h3" />
                                </svg>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-large">BUKU INDUK</div>
                            <div class="text-secondary d-none d-md-block">
                                Rekaman data lengkap siswa dalam buku induk sekolah
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="btn-list">

                                <a href="{{ route('induk.index') }}" class="btn btn-outline-warning">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler-arrow-left"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M5 12l14 0" />
                                        <path d="M5 12l6 6" />
                                        <path d="M5 12l6 -6" />
                                    </svg>
                                    Kembali
                                </a>
                                {{-- Tombol Cetak --}}
                                <form action="{{ route('induk.buku-induk.cetak') }}" method="POST" target="_blank"
                                    class="d-inline">
                                    @csrf
                                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                                    <button type="submit" class="btn btn-primary btn-icon" data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="{{ $student->can_generate_pdf ? 'Cetak Buku Induk' : 'Nomor dokumen belum tersedia' }}"
                                        {{ $student->can_generate_pdf ? '' : 'disabled' }}>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler-printer">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                                            <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                                            <path
                                                d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                                        </svg>
                                    </button>
                                </form>

                                {{-- Tombol Unduh PDF --}}
                                <a href="{{ $student->can_generate_pdf ? route('induk.generatePDF', ['uuid' => $student->uuid]) : '#' }}"
                                    class="btn btn-danger btn-icon {{ $student->can_generate_pdf ? '' : 'disabled' }}"
                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="{{ $student->can_generate_pdf ? 'Unduh PDF' : 'Nomor dokumen belum tersedia' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-file-type-pdf">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                        <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                        <path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" />
                                        <path d="M17 18h2" />
                                        <path d="M20 15h-3v6" />
                                        <path d="M11 15v6h1a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-1z" />
                                    </svg>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Identitas Siswa -->
        <div class="card card-border-primary mb-4 printable-page">
            <div class="card-header bg-warning-lt d-flex align-items-center">
                <span class="bg-warning text-white avatar me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-id">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z" />
                        <path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                        <path d="M15 8l2 0" />
                        <path d="M15 12l2 0" />
                        <path d="M7 16l10 0" />
                    </svg>
                </span>
                <div>
                    <h3 class="card-title text-warning mb-0">KETERANGAN PESERTA DIDIK</h3>
                    <div class="text-muted small">Informasi identitas peserta didik</div>
                </div>
            </div>
            <div class="card-body">
                <div class="row align-items-start">
                    <div class="col-md-3 text-center mb-3 d-flex flex-wrap gap-3 flex-md-column flex-print-row">
                        @if (count($fotoSiswa) > 0)
                            @foreach ($fotoSiswa as $foto)
                                <div class="foto-wrapper text-center">
                                    <img src="{{ asset('storage/' . $foto->path_foto) }}" alt="Foto Siswa"
                                        class="img-thumbnail student-photo"
                                        style="width: 2.7cm; height: 3.6cm; object-fit: cover; border-radius: 4px;">
                                    <div class="mt-2 small text-muted foto-caption">
                                        Foto Tahun - {{ $foto->tahunPelajaran->tahun_ajaran ?? 'Tidak Diketahui' }}
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="empty-state">
                                <div class="empty-state-icon bg-primary-lt">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler-camera"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M5 7h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" />
                                        <path d="M9 13a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                    </svg>
                                </div>
                                <h4 class="empty-state-title">Belum Ada Foto Siswa</h4>
                                <p class="empty-state-subtitle text-muted">
                                    Data foto siswa belum tersedia untuk ditampilkan
                                </p>

                            </div>
                        @endif
                    </div>
                    <div class="col-md-9">
                        <div class="card">

                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped table-borderless">
                                        <tbody>

                                            <tr>
                                                <th width="35%" class="ps-4 text-muted">NIPD</th>
                                                <td class="fw-semibold">{{ $student->nipd }}</td>
                                            </tr>
                                            <tr>
                                                <th class="ps-4 text-muted">NISN</th>
                                                <td class="fw-semibold">{{ $student->nisn }}</td>
                                            </tr>
                                            <tr>
                                                <th class="ps-4 text-muted">Nama Lengkap</th>
                                                <td class="fw-semibold">{{ $student->nama }}</td>
                                            </tr>
                                            <tr>
                                                <th class="ps-4 text-muted">Nama Panggilan</th>
                                                <td>{{ $student->nama_panggilan }}</td>
                                            </tr>


                                            <tr>
                                                <th class="ps-4 text-muted">Jenis Kelamin</th>
                                                <td>
                                                    @if ($student->jk == 'L')
                                                        <span class="badge bg-blue-lt">Laki-laki</span>
                                                    @else
                                                        <span class="badge bg-pink-lt">Perempuan</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="ps-4 text-muted">Tempat/Tanggal Lahir</th>
                                                <td>
                                                    {{ $student->tempat_lahir }},
                                                    <span
                                                        class="text-nowrap">{{ \Carbon\Carbon::parse($student->tanggal_lahir)->isoFormat('D MMMM Y') }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="ps-4 text-muted">Agama</th>
                                                <td>
                                                    <span
                                                        class="badge bg-cyan-lt">{{ $student->agama->nama ?? '-' }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="ps-4 text-muted">Kewarganegaraan</th>
                                                <td>{{ $student->kewarganegaraan }}</td>
                                            </tr>


                                            <tr>
                                                <th class="ps-4 text-muted">Anak ke</th>
                                                <td>{{ $student->anak_ke }}</td>
                                            </tr>
                                            <tr>
                                                <th class="ps-4 text-muted">Jumlah Saudara</th>
                                                <td>
                                                    <div class="d-flex gap-3">
                                                        <span class="text-nowrap">Kandung:
                                                            {{ $student->jumlah_saudara_kandung }}</span>
                                                        <span class="text-nowrap">Tiri:
                                                            {{ $student->saudara_tiri }}</span>
                                                        <span class="text-nowrap">Angkat:
                                                            {{ $student->saudara_angkat }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="ps-4 text-muted">Status Anak</th>
                                                <td>{{ $student->status_anak }}</td>
                                            </tr>


                                            <tr>
                                                <th class="ps-4 text-muted">Bahasa sehari-hari</th>
                                                <td>{{ $student->bahasa_keseharian }}</td>
                                            </tr>
                                            <tr>
                                                <th class="ps-4 text-muted">Alamat</th>
                                                <td>{{ $student->alamat }}</td>
                                            </tr>
                                            <tr>
                                                <th class="ps-4 text-muted">Kontak</th>
                                                <td>
                                                    @if ($student->telepon)
                                                        <a href="tel:{{ $student->telepon }}"
                                                            class="text-reset">{{ $student->telepon }}</a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="ps-4 text-muted">Nomor Dokumen</th>
                                                <td>
                                                    @if ($student->nomor_dokumen)
                                                        <span
                                                            class="badge bg-green-lt">{{ $student->nomor_dokumen }}</span>
                                                    @else
                                                        <span class="badge bg-yellow-lt">Belum Dibuat</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- end row -->
            </div>
        </div>

        <div class="card rounded-3 shadow-sm mb-4 printable-page">
            <div class="card-header bg-info-lt d-flex align-items-center">
                <span class="bg-info text-white avatar me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-map-2">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v7.5" />
                        <path d="M9 4v13" />
                        <path d="M15 7v5.5" />
                        <path
                            d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879z" />
                        <path d="M19 18v.01" />
                    </svg>
                </span>
                <div>
                    <h3 class="card-title text-info mb-0">KETERANGAN TEMPAT TINGGAL</h3>
                    <div class="text-muted small">Alamat lengkap dan informasi tempat tinggal siswa</div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table table-borderless table-sm">
                                <tbody>
                                    <tr>
                                        <td width="35%" class="text-muted fw-semibold ps-0">Alamat Jalan</td>
                                        <td class="fw-semibold">{{ $student->alamat }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted fw-semibold ps-0">RT/RW</td>
                                        <td>
                                            <span class="badge bg-blue-lt">
                                                {{ $student->rt }}/{{ $student->rw }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted fw-semibold ps-0">Kelurahan</td>
                                        <td>{{ $student->kelurahan }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted fw-semibold ps-0">Kecamatan</td>
                                        <td>{{ $student->kecamatan }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted fw-semibold ps-0">Jenis Tinggal</td>
                                        <td>
                                            <span class="badge bg-info-lt text-info">
                                                {{ $student->jenisTinggal->nama ?? '-' }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table table-borderless table-sm">
                                <tbody>
                                    <tr>
                                        <td width="35%" class="text-muted fw-semibold ps-0">Kabupaten/Kota</td>
                                        <td>{{ $student->kabupaten }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted fw-semibold ps-0">Provinsi</td>
                                        <td>{{ $student->provinsi }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted fw-semibold ps-0">Kode POS</td>
                                        <td>
                                            <span class="badge bg-purple-lt">
                                                {{ $student->kode_pos }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted fw-semibold ps-0">Kontak</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                @if ($student->telepon)
                                                    <a href="tel:{{ $student->telepon }}" class="text-reset">
                                                        <span class="badge bg-green-lt">
                                                            <i class="ti ti-phone me-1"></i> {{ $student->telepon }}
                                                        </span>
                                                    </a>
                                                @endif
                                                @if ($student->hp)
                                                    <a href="https://wa.me/{{ $student->hp }}" class="text-reset">
                                                        <span class="badge bg-green-lt">
                                                            <i class="ti ti-brand-whatsapp me-1"></i> {{ $student->hp }}
                                                        </span>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted fw-semibold ps-0">Jarak ke Sekolah</td>
                                        <td>
                                            <span class="badge bg-orange-lt">
                                                {{ $student->jarak_rumah_km }} km
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="card rounded-3 shadow-sm mb-4 printable-page">
            <div class="card-header bg-success-lt d-flex align-items-center">
                <span class="bg-success text-white avatar me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                    </svg>
                </span>
                <div>
                    <h3 class="card-title text-success mb-0">DATA ORANG TUA/WALI</h3>
                    <div class="text-muted small">Informasi lengkap orang tua/wali siswa</div>
                </div>
            </div>

            <div class="card-body">
                <div class="row row-cards">
                    @forelse ($student->orangTuas as $orangTua)
                        <div class="col-md-6">
                            <div class="card card-sm border-success">
                                <div class="card-header bg-success-lt py-2">
                                    <h4 class="card-title text-success">
                                        @if ($orangTua->tipe == 'Ayah')
                                            <i class="ti ti-man me-1"></i>
                                        @elseif($orangTua->tipe == 'Ibu')
                                            <i class="ti ti-woman me-1"></i>
                                        @else
                                            <i class="ti ti-user me-1"></i>
                                        @endif
                                        {{ $orangTua->tipe }} - {{ $orangTua->nama }}
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-sm">
                                            <tbody>
                                                <tr>
                                                    <td width="35%" class="text-muted fw-semibold ps-0">Hubungan</td>
                                                    <td>
                                                        <span class="badge bg-success-lt text-success">
                                                            {{ $orangTua->tipe }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted fw-semibold ps-0">Pendidikan</td>
                                                    <td>{{ $orangTua->pendidikan->jenjang ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted fw-semibold ps-0">Pekerjaan</td>
                                                    <td>{{ $orangTua->pekerjaan->nama ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted fw-semibold ps-0">Penghasilan</td>
                                                    <td>
                                                        @if ($orangTua->penghasilan)
                                                            <span class="badge bg-blue-lt">
                                                                {{ $orangTua->penghasilan->rentang }}
                                                            </span>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted fw-semibold ps-0">Kewarganegaraan</td>
                                                    <td>{{ $orangTua->kewarganegaraan }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info py-3">
                                <div class="d-flex align-items-center">
                                    <i class="ti ti-info-circle fs-3 me-3"></i>
                                    <div>
                                        <h4 class="alert-title">Data Orang Tua Belum Tersedia</h4>
                                        <div class="text-muted">Informasi orang tua/wali siswa belum diinput</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>



        <div class="card rounded-3 shadow-sm mb-4 printable-page">
            <div class="card-header bg-purple-lt d-flex align-items-center">
                <span class="bg-purple text-white avatar me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-backpack">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 18v-6a6 6 0 0 1 6 -6h2a6 6 0 0 1 6 6v6a3 3 0 0 1 -3 3h-8a3 3 0 0 1 -3 -3z" />
                        <path d="M10 6v-1a2 2 0 1 1 4 0v1" />
                        <path d="M9 21v-4a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v4" />
                        <path d="M11 10h2" />
                    </svg>
                </span>
                <div>
                    <h3 class="card-title text-purple mb-0">KETERANGAN PENDIDIKAN</h3>
                    <div class="text-muted small">Informasi tentang pendidikan peserta didik</div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Left Column - Riwayat Sekolah -->
                    <div class="col-md-6 border-end pe-3">
                        <div class="d-flex align-items-center mb-3">
                            <span class="bg-info text-white avatar me-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="currentColor"
                                    class="icon icon-tabler icons-tabler-filled icon-tabler-home">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M12.707 2.293l9 9c.63 .63 .184 1.707 -.707 1.707h-1v6a3 3 0 0 1 -3 3h-1v-7a3 3 0 0 0 -2.824 -2.995l-.176 -.005h-2a3 3 0 0 0 -3 3v7h-1a3 3 0 0 1 -3 -3v-6h-1c-.89 0 -1.337 -1.077 -.707 -1.707l9 -9a1 1 0 0 1 1.414 0m.293 11.707a1 1 0 0 1 1 1v7h-4v-7a1 1 0 0 1 .883 -.993l.117 -.007z" />
                                </svg>
                            </span>
                            <h4 class="m-0">Riwayat Sekolah</h4>
                        </div>

                        @if ($riwayatSekolah)
                            <div class="table-responsive">
                                <table class="table table-sm table-borderless">
                                    <tbody>
                                        <tr>
                                            <th width="40%" class="text-muted ps-0">Sekolah Asal</th>
                                            <td class="fw-semibold">{{ $riwayatSekolah->sekolah_asal }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted ps-0">Jenis Pendaftaran</th>
                                            <td>{{ $riwayatSekolah->jenis_pendaftar }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted ps-0">Tanggal Masuk</th>
                                            <td>{{ \Carbon\Carbon::parse($riwayatSekolah->tanggal_masuk)->isoFormat('D MMMM Y') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted ps-0">Tahun Lulus</th>
                                            <td>
                                                @if ($riwayatSekolah->tahun_lulus)
                                                    {{ $riwayatSekolah->tahun_lulus }}
                                                @else
                                                    <span class="badge bg-green-lt">Masih Bersekolah</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info mt-3 py-2">
                                <i class="ti ti-info-circle me-1"></i> Data riwayat sekolah belum tersedia
                            </div>
                        @endif
                    </div>

                    <!-- Right Column - Riwayat Kelas -->
                    <div class="col-md-6 ps-3">
                        <div class="d-flex align-items-center mb-3">
                            <span class="bg-warning text-white avatar me-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-school">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M22 9l-10 -4l-10 4l10 4l10 -4v6" />
                                    <path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4" />
                                </svg>
                            </span>
                            <h4 class="m-0">Riwayat Kelas</h4>
                        </div>

                        @if (count($riwayatRombel) > 0)
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead class="bg-warning-lt">
                                        <tr>
                                            <th>Tahun</th>
                                            <th>Semester</th>
                                            <th>Rombel</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($riwayatRombel as $riwayat)
                                            <tr>
                                                <td>{{ $riwayat->tahunPelajaran->tahun_ajaran }}</td>
                                                <td>{{ $riwayat->semester->semester }}</td>
                                                <td>
                                                    <span class="badge bg-primary-lt text-primary">
                                                        {{ $riwayat->rombel->nama }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-warning mt-3 py-2">
                                <i class="ti ti-alert-triangle me-1"></i> Data riwayat kelas belum tersedia
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>



        <div class="card card-border-secondary printable-page">
            <div class="card-header bg-lime-lt d-flex align-items-center">
                <span class="bg-lime text-white avatar me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-info-square-rounded">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M12 2l.642 .005l.616 .017l.299 .013l.579 .034l.553 .046c4.687 .455 6.65 2.333 7.166 6.906l.03 .29l.046 .553l.041 .727l.006 .15l.017 .617l.005 .642l-.005 .642l-.017 .616l-.013 .299l-.034 .579l-.046 .553c-.455 4.687 -2.333 6.65 -6.906 7.166l-.29 .03l-.553 .046l-.727 .041l-.15 .006l-.617 .017l-.642 .005l-.642 -.005l-.616 -.017l-.299 -.013l-.579 -.034l-.553 -.046c-4.687 -.455 -6.65 -2.333 -7.166 -6.906l-.03 -.29l-.046 -.553l-.041 -.727l-.006 -.15l-.017 -.617l-.004 -.318v-.648l.004 -.318l.017 -.616l.013 -.299l.034 -.579l.046 -.553c.455 -4.687 2.333 -6.65 6.906 -7.166l.29 -.03l.553 -.046l.727 -.041l.15 -.006l.617 -.017c.21 -.003 .424 -.005 .642 -.005zm0 9h-1l-.117 .007a1 1 0 0 0 0 1.986l.117 .007v3l.007 .117a1 1 0 0 0 .876 .876l.117 .007h1l.117 -.007a1 1 0 0 0 .876 -.876l.007 -.117l-.007 -.117a1 1 0 0 0 -.764 -.857l-.112 -.02l-.117 -.006v-3l-.007 -.117a1 1 0 0 0 -.876 -.876l-.117 -.007zm.01 -3l-.127 .007a1 1 0 0 0 0 1.986l.117 .007l.127 -.007a1 1 0 0 0 0 -1.986l-.117 -.007z" />
                    </svg>
                </span>
                <div>
                    <h3 class="card-title text-lime mb-0">INFORMASI TAMBAHAN</h3>
                    <div class="text-muted small">Informasi lain-lain</div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h5 class="fw-semibold">Keterangan Khusus</h5>
                        <p class="text-muted">-</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h5 class="fw-semibold">Catatan Penting</h5>
                        <p class="text-muted">-</p>
                    </div>
                </div>
            </div>
        </div>




    @endsection
