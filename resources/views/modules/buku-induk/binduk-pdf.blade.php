<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Induk_{{ $student->nama }}</title>
    <style>
        /* Gaya umum untuk mPDF, tetap menggunakan estetika Tabler */
        body {
            font-family: Arial, Helvetica, sans-serif;
            /* mPDF lebih konsisten dengan font standar */
            font-size: 10pt;
            /* Ukuran font untuk keterbacaan di PDF */
            line-height: 1.2;
            /* Line height disesuaikan untuk PDF */
            color: #000000;
            /* Warna teks hitam untuk kontras */
            background: #ffffff;
            /* Latar belakang putih */
            margin: 15mm 10mm;
            /* Margin untuk kertas A4 */
        }

        .card {
            border: 1px solid #000000;
            /* Border hitam untuk kejelasan */
            border-radius: 0.25rem;
            /* Border radius Tabler */
            margin-bottom: 1rem;
            page-break-inside: avoid;
            /* Hindari card terpotong di antara halaman */
        }

        .card-header {
            padding: 4px 8px;
            /* Lebih kecil dari default */
            background-color: #f0f0f0;
            border-bottom: 1px solid #000000;
            line-height: 1.1;
            /* Kurangi spasi vertikal */
        }

        .card-title {
            font-size: 11pt;
            /* Ukuran font yang pas */
            margin: 0;
            line-height: 1.2;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 4px;
            /* Jarak antar ikon dan teks */
        }

        .card-body {
            padding: 1rem;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #000000;
            /* Border hitam untuk tabel */
            padding: 0.3rem;
            font-size: 9pt;
        }

        .table th {
            text-align: left;
            /* Align header text to the left */
        }

        .bg-light-theme {
            background-color: #f5f5f5;
            /* Latar belakang ringan untuk header tabel */
        }

        .bg-primary-lt {
            background-color: #e7f1ff;
            /* Warna primary light Tabler */
        }

        .bg-success-lt {
            background-color: #e6f4ea;
            /* Warna success light Tabler */
        }

        .bg-info-lt {
            background-color: #e5f3ff;
            /* Warna info light Tabler */
        }

        .bg-warning-lt {
            background-color: #fef6e7;
            /* Warna warning light Tabler */
        }

        .bg-secondary-lt {
            background-color: #f2f3f5;
            /* Warna secondary light Tabler */
        }

        .student-photo {
            width: 2.7cm;
            height: 3.6cm;
            object-fit: cover;
            border: 1px solid #000;
            /* Seperti pas foto */
            border-radius: 2px;
            display: block;
            margin: 0 auto;
            box-shadow: 0 0 2px rgba(0, 0, 0, 0.3);
            /* opsional untuk efek lebih halus */
        }

        .foto-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0.2rem;
            margin-bottom: 0.2rem;
        }

        .foto-table tr {
            page-break-inside: avoid;
        }

        .foto-cell {
            text-align: center;
            vertical-align: top;
            padding: 0.2rem;
            border: none;
        }

        .foto-caption {
            font-size: 9pt;
            color: #000;
            margin-top: 0.3rem;
            text-align: center;
        }

        /* Atur header untuk PDF */
        .print-header {
            text-align: center;
            margin-bottom: 1rem;
            page-break-after: avoid;
            /* Hindari header terpisah dari konten */
        }

        .print-header h1 {
            font-size: 14pt;
            font-weight: bold;
            margin: 0;
        }

        .header-info {
            text-align: center;
            font-size: 10pt;
            margin-top: 0.5rem;
        }



        /* Hindari elemen terpotong */
        .printable-page {
            page-break-inside: avoid;
            margin-bottom: 1rem;
        }

        /* Atur teks untuk kontras tinggi */
        .text-primary,
        .text-success,
        .text-info,
        .text-warning,
        .text-secondary {
            color: #000000;
            /* Warna teks hitam untuk kontras di PDF */
        }

        /* Container Styles */
        .signature-container {
            margin-top: 30px;
            page-break-inside: avoid !important;
        }

        .signature-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 10px;
            page-break-inside: avoid;
            background: #ffffff;
        }

        /* Table Layout */
        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }

        .signature-table td {
            vertical-align: top;
            padding: 0;
        }

        /* QR Code Section */
        .qr-section {
            width: 160px;
        }

        .qr-container {
            text-align: center;
            padding: 10px;
        }

        .qr-title {
            font-size: 12px;
            font-weight: 700;
            color: #4361ee;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0 0 10px 0;
        }

        .qr-code {
            width: 150px;
            height: 150px;
            display: block;
            margin: 0 auto;
        }

        .qr-caption {
            font-size: 10px;
            color: #6c757d;
            margin-top: 10px;
            line-height: 1.3;
        }

        /* Spacer Section */
        .spacer-section {
            width: 300px;
            /* Atur lebar spacer sesuai kebutuhan */
        }

        /* Signature Section */
        .signature-section {
            width: 300px;
            /* Atur lebar sesuai kebutuhan */
        }

        .signature-content {
            text-align: center;
        }

        .signature-location {
            font-size: 14px;
            color: #000000;
            margin: 0 0 20px 0;
        }

        .signature-role {
            font-size: 14px;
            color: #000000;
            margin: 0 0 2px 0;
        }

        /* .signature-line {
            height: 1px;
            background-color: #000;
            width: 180px;
            margin: 0 auto 5px auto;
        } */

        .signature-name {
            font-size: 14px;
            font-weight: 700;
            color: #000;
            margin: 0 0 2px 0;
        }

        .signature-nip {
            font-size: 14px;
            color: #000000;
            margin: 0;
        }
    </style>

</head>


<body>
    <!-- Judul Halaman Cetak -->
    <div class="print-header">
        <h1>LEMBAR BUKU INDUK REGISTER</h1>
        <table style="margin: 0 auto; font-size: 10pt;">
            <tr>
                <td><strong>NIPD:</strong> {{ $student->nipd }}</td>
                <td style="padding-left: 2cm;"><strong>NISN:</strong> {{ $student->nisn }}</td>
            </tr>
        </table>
    </div>




    <!-- Data Identitas Siswa -->
    <div class="card card-border-primary mb-4 printable-page">
        <div class="card-header bg-primary-lt">
            <h3 class="card-title text-primary fw-semibold">
                <i class="ti ti-user-circle me-2"></i>A. KETERANGAN PESERTA DIDIK
            </h3>
        </div>
        <div class="card-body">
            <div class="row align-items-start">
                <div class="col-md-3 text-center ">
                    <table class="foto-table">
                        @foreach ($fotoSiswa->chunk(3) as $chunk)
                            <tr>
                                @foreach ($chunk as $foto)
                                    <td class="foto-cell">
                                        <img src="{{ asset('storage/' . $foto->path_foto) }}" alt="Foto Siswa"
                                            class="student-photo">
                                        <div class="foto-caption">
                                            Foto Tahun - {{ $foto->tahunPelajaran->tahun_ajaran ?? 'Tidak Diketahui' }}
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </table>
                </div>


                <div class="col-md-9">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <tbody>
                                <tr>
                                    <th class="bg-light-theme">NIPD</th>
                                    <td>{{ $student->nipd }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light-theme">NISN</th>
                                    <td>{{ $student->nisn }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light-theme">Nama Lengkap</th>
                                    <td>{{ $student->nama }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light-theme">Nama Panggilan</th>
                                    <td>{{ $student->nama_panggilan }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light-theme">Jenis Kelamin</th>
                                    <td>{{ $student->jk }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light-theme">Tempat Lahir</th>
                                    <td>{{ $student->tempat_lahir }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light-theme">Tanggal Lahir</th>
                                    <td>{{ \Carbon\Carbon::parse($student->tanggal_lahir)->isoFormat('D MMMM Y') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light-theme">Agama</th>
                                    <td>{{ $student->agama->nama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light-theme">Kewarganegaraan</th>
                                    <td>{{ $student->kewarganegaraan }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light-theme">Anak ke</th>
                                    <td>{{ $student->anak_ke }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light-theme">Jumlah Saudara Kandung</th>
                                    <td>{{ $student->jumlah_saudara_kandung }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light-theme">Jumlah Saudara Tiri</th>
                                    <td>{{ $student->saudara_tiri }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light-theme">Jumlah Saudara Angkat</th>
                                    <td>{{ $student->saudara_angkat }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light-theme">Status Anak</th>
                                    <td>{{ $student->status_anak }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light-theme">Bahasa sehari-hari</th>
                                    <td>{{ $student->bahasa_keseharian }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light-theme">Alamat</th>
                                    <td>{{ $student->alamat }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light-theme">Kontak</th>
                                    <td>{{ $student->telepon ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light-theme">Nomor Dokumen</th>
                                    <td>{{ $student->nomor_dokumen ?? 'Belum Dibuat' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div>
    </div>

    <div class="card card-border-info mb-4 printable-page">
        <div class="card-header bg-info-lt">
            <h3 class="card-title text-info fw-semibold"><i class="ti ti-school me-2"></i>B. KETERANGAN TEMPAT TINGGAL
            </h3>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <tbody>
                        <tr>
                            <th class="bg-light-theme">Alamat Jalan</th>
                            <td>{{ $student->alamat }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light-theme">RT/RW</th>
                            <td>{{ $student->rt }}/{{ $student->rw }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light-theme">Kalurahan</th>
                            <td>{{ $student->kelurahan }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light-theme">Kecamatan</th>
                            <td>{{ $student->kecamatan }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light-theme">Kabupaten</th>
                            <td>{{ $student->kabupaten }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light-theme">Provinsi</th>
                            <td>{{ $student->provinsi }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light-theme">Kode POS</th>
                            <td>{{ $student->kode_pos }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light-theme">Nomor Telepon/HP</th>
                            <td>{{ $student->telepon }} / {{ $student->hp }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light-theme">Jenis Tinggal</th>
                            <td>{{ $student->jenisTinggal->nama ?? '-' }} </td>

                        </tr>
                        <tr>
                            <th class="bg-light-theme">Jarak ke sekolah</th>
                            <td>{{ $student->jarak_rumah_km }} km</td>
                        </tr>

                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <div class="card card-border-success mb-4 printable-page">
        <div class="card-header bg-success-lt">
            <h3 class="card-title text-success fw-semibold"><i class="ti ti-users me-2"></i>DATA ORANG TUA/WALI
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach ($student->orangTuas as $orangTua)
                    <div class="col-md-6 mb-3">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <tbody>
                                    <tr>
                                        <th width="35%" class="bg-light-theme">Nama Orang Tua</th>
                                        <td>{{ $orangTua->nama }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light-theme">Hubungan</th>
                                        <td>{{ $orangTua->tipe }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light-theme">Pendidikan</th>
                                        <td>{{ $orangTua->pendidikan->jenjang }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light-theme">Pekerjaan</th>
                                        <td>{{ $orangTua->pekerjaan->nama }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light-theme">Penghasilan</th>
                                        <td>{{ $orangTua->penghasilan->rentang }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light-theme">Kewarganegaraan</th>
                                        <td>{{ $orangTua->kewarganegaraan }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card card-border-info mb-4 printable-page">
        <div class="card-header bg-info-lt">
            <h3 class="card-title text-info fw-semibold"><i class="ti ti-school me-2"></i>RIWAYAT SEKOLAH</h3>
        </div>
        <div class="card-body">
            @if ($riwayatSekolah)
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <tbody>
                            <tr>
                                <th class="bg-light-theme">Sekolah Asal</th>
                                <td>{{ $riwayatSekolah->sekolah_asal }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light-theme">Jenis Pendaftaran</th>
                                <td>{{ $riwayatSekolah->jenis_pendaftar }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light-theme">Tanggal Masuk</th>
                                <td>{{ \Carbon\Carbon::parse($riwayatSekolah->tanggal_masuk)->isoFormat('D MMMM Y') }}
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-light-theme">Tahun Lulus</th>
                                <td>{{ $riwayatSekolah->tahun_lulus ?? 'Masih Bersekolah' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-muted fst-italic">Data riwayat sekolah belum tersedia.</div>
            @endif
        </div>
    </div>

    <div class="card card-border-warning mb-4 printable-page">
        <div class="card-header bg-warning-lt">
            <h3 class="card-title text-warning fw-semibold"><i class="ti ti-chalkboard-user me-2"></i>RIWAYAT
                KELAS</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="table-light">
                        <tr>
                            <th>Tahun Pelajaran</th>
                            <th>Semester</th>
                            <th>Rombel</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($riwayatRombel as $riwayat)
                            <tr>
                                <td>{{ $riwayat->tahunPelajaran->tahun_ajaran }}</td>
                                <td>{{ $riwayat->semester->semester }}</td>
                                <td>{{ $riwayat->rombel->nama }}</td>
                                <td>{{ $riwayat->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card card-border-secondary printable-page">
        <div class="card-header bg-secondary-lt">
            <h3 class="card-title text-secondary fw-semibold"><i class="ti ti-info-circle me-2"></i>INFORMASI
                TAMBAHAN</h3>
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

    <div class="signature-container" style="page-break-inside: avoid;">
        <div class="signature-card">
            <table class="signature-table">
                <tr>
                    <!-- QR Code Section -->
                    <td class="qr-section">
                        <div class="qr-container">
                            <h6 class="qr-title">VERIFIKASI DIGITAL</h6>
                            <img class="qr-code"
                                src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($qrUrl) }}&margin=0"
                                alt="QR Code">
                            <p class="qr-caption">Scan QR code untuk verifikasi</p>
                        </div>
                    </td>

                    <!-- Spacer Section -->
                    <td class="spacer-section">
                        <!-- Kosong, hanya untuk spacing -->
                    </td>

                    <!-- Signature Section -->
                    <td class="signature-section">
                        <div class="signature-content">
                            <p class="signature-location">Pengasih,
                                {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                            <p class="signature-role">Kepala Sekolah</p>
                            <br>
                            <br>
                            <br>
                            <br>
                            <p class="signature-name"><strong>Titanium, S.Pd.</strong></p>
                            <p class="signature-nip">NIP. 1996998 200019 2 002</p>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>





</body>


</html>
