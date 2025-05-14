<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Induk_{{ $student->nama }}</title>
    <style>
        @import url("https://rsms.me/inter/inter.css");
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let theme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', theme);
        });
    </script>
    <!-- Link ke CSS, jika menggunakan Vite atau Laravel Mix -->
    @vite('resources/css/app.css') <!-- Jika menggunakan Vite -->
    <link rel="stylesheet" href="{{ asset('css/print.css') }}" media="print">
</head>



<!-- Judul Halaman Cetak -->
<div class="print-header">
    <h1>LEMBAR BUKU INDUK REGISTER</h1>
    <div class="header-info">
        <div><strong>NIPD:</strong> {{ $student->nipd }}</div>
        <div><strong>NISN:</strong> {{ $student->nisn }}</div>
    </div>
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
            <div class="col-md-3 text-center mb-3 d-flex flex-wrap gap-3 flex-md-column flex-print-row">
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

<div class="signature-section mt-5 printable-page">
    <div class="row justify-content-end">
        <div class="col-md-6 text-center">
            <div class="signature-line mb-1 border-bottom border-dark w-50 mx-auto"></div>
            <p class="mb-0">Kepala Sekolah</p>
            <p class="mt-3">(..................................................)</p>
        </div>
    </div>
</div>

<div class="text-center my-4">
    <h6 class="fw-semibold">Verifikasi Dokumen</h6>
    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($qrUrl) }}" alt="QR Code">
    <div class="mt-2 small text-muted">Pindai untuk verifikasi keaslian</div>
</div>
<script>
    window.onload = () => window.print();
</script>

</body>


</html>
