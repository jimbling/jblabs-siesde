@extends('layouts.tabler')

@section('title', 'Buku Induk Siswa - ' . $student->nama)

@section('content')
    <div class="container-fluid print-container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-print-12">
                <!-- Cover Page -->
                <div class="cover-page text-center py-5 mb-5 d-print-none">
                    <h1 class="display-4">BUKU INDUK SISWA</h1>

                </div>

                <!-- Student Information Card -->
                <div class="card mb-4 printable-page">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title"><i class="fas fa-user-graduate me-2"></i>IDENTITAS SISWA</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 text-center mb-3">
                                <img src="{{ asset('storage/' . $student->fotoTerbaru->path_foto) }}" alt="Foto Siswa"
                                    class="img-thumbnail student-photo" style="max-height: 200px;">
                                <div class="mt-2 small text-muted">Foto Terbaru</div>
                            </div>
                            <div class="col-md-9">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <tbody>
                                            <tr>
                                                <th width="25%" class="bg-light">Nama Lengkap</th>
                                                <td>{{ $student->nama }}</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">NIPD</th>
                                                <td>{{ $student->nipd }}</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">NISN</th>
                                                <td>{{ $student->nisn }}</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">TTL</th>
                                                <td>{{ $student->tempat_lahir }},
                                                    {{ \Carbon\Carbon::parse($student->tanggal_lahir)->isoFormat('D MMMM Y') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">Alamat</th>
                                                <td>{{ $student->alamat }}</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">Kontak</th>
                                                <td>{{ $student->telepon ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">Nomor Dokumen</th>
                                                <td>{{ $student->nomor_dokumen ?? 'Belum Dibuat' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Parent Information -->
                <div class="card mb-4 printable-page">
                    <div class="card-header bg-success text-white">
                        <h3 class="card-title"><i class="fas fa-users me-2"></i>DATA ORANG TUA/WALI</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($student->orangTuas as $orangTua)
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm">
                                            <tbody>
                                                <tr>
                                                    <th width="35%" class="bg-light">Nama Orang Tua</th>
                                                    <td>{{ $orangTua->nama }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Hubungan</th>
                                                    <td>{{ $orangTua->hubungan }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Pendidikan</th>
                                                    <td>{{ $orangTua->pendidikan->jenjang }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Pekerjaan</th>
                                                    <td>{{ $orangTua->pekerjaan->nama }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="bg-light">Penghasilan</th>
                                                    <td>{{ $orangTua->penghasilan->rentang }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- School History -->
                <div class="card mb-4 printable-page">
                    <div class="card-header bg-info text-white">
                        <h3 class="card-title"><i class="fas fa-school me-2"></i>RIWAYAT SEKOLAH</h3>
                    </div>
                    <div class="card-body">
                        @if ($riwayatSekolah)
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <tbody>
                                        <tr>
                                            <th width="25%" class="bg-light">Sekolah Asal</th>
                                            <td>{{ $riwayatSekolah->sekolah_asal }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Jenis Pendaftaran</th>
                                            <td>{{ $riwayatSekolah->jenis_pendaftar }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Tanggal Masuk</th>
                                            <td>{{ \Carbon\Carbon::parse($riwayatSekolah->tanggal_masuk)->isoFormat('D MMMM Y') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Tahun Lulus</th>
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

                <!-- Class History -->
                <div class="card mb-4 printable-page">
                    <div class="card-header bg-warning text-dark">
                        <h3 class="card-title"><i class="fas fa-chalkboard-teacher me-2"></i>RIWAYAT KELAS</h3>
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

                <!-- Additional Information -->
                <div class="card printable-page">
                    <div class="card-header bg-secondary text-white">
                        <h3 class="card-title"><i class="fas fa-info-circle me-2"></i>INFORMASI TAMBAHAN</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Keterangan Khusus</h5>
                                <p class="text-muted">-</p>
                            </div>
                            <div class="col-md-6">
                                <h5>Catatan Penting</h5>
                                <p class="text-muted">-</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Signature Section -->
                <div class="signature-section mt-5 printable-page">
                    <div class="row">
                        <div class="col-md-6 offset-md-6 text-center">
                            <div class="signature-line mb-1"
                                style="border-bottom: 1px solid #000; width: 200px; display: inline-block;"></div>
                            <p class="mb-0">Kepala Sekolah</p>
                        </div>
                    </div>
                </div>

                <!-- Print Button -->
                <div class="text-center mt-4 d-print-none">
                    <button onclick="window.print()" class="btn btn-primary">
                        <i class="fas fa-print me-2"></i>Cetak Buku Induk
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            /* Print-specific styles */
            @media print {
                body {
                    background: white;
                    font-size: 12pt;
                }

                .print-container {
                    padding: 0;
                    margin: 0;
                }

                .printable-page {
                    page-break-inside: avoid;
                    margin-bottom: 20px;
                }

                .d-print-none {
                    display: none !important;
                }

                .card {
                    border: 1px solid #ddd;
                }

                .student-photo {
                    max-height: 150px !important;
                }

                .table {
                    font-size: 10pt;
                }

                .signature-section {
                    margin-top: 50px;
                }
            }

            /* Screen-specific styles */
            @media screen {
                .print-container {
                    padding: 20px;
                }

                .cover-page {
                    border: 2px solid #333;
                    border-radius: 10px;
                    background: #f8f9fa;
                    margin-bottom: 30px;
                }
            }

            /* General styles */
            .card-header {
                font-weight: bold;
            }

            .table th {
                white-space: nowrap;
            }

            .student-photo {
                background: #f8f9fa;
                padding: 5px;
                border: 1px solid #dee2e6;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Add any necessary JavaScript here
            document.addEventListener('DOMContentLoaded', function() {
                // You can add print-specific JS if needed
            });
        </script>
    @endpush
@endsection
