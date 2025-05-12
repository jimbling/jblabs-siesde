@extends('layouts.tabler')

@section('title', $title ?? 'Dashboard')

@section('page-title', 'Detail Siswa')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <!-- Tambah justify-content-between -->
                        <!-- Bagian kiri (foto & nama) -->
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-xl me-3"
                                style="background-image: url('{{ $student->fotoTerbaru ? asset('storage/' . $student->fotoTerbaru->path_foto) : asset('default-avatar.png') }}');
                                        background-size: cover;
                                        background-position: center;">
                            </div>
                            <div>
                                <h2 class="card-title mb-0">{{ $student->nama }}</h2>
                                <small class="text-muted">{{ $student->nipd }} | {{ $student->nisn }}</small>
                            </div>
                        </div>

                        <!-- Tombol Kembali -->
                        <a href="{{ url()->previous() }}" class="btn btn-outline-warning me-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l14 0" />
                                <path d="M5 12l6 6" />
                                <path d="M5 12l6 -6" />
                            </svg>
                            Kembali
                        </a>
                    </div>


                    <div class="card-body">
                        <!-- Tabs Navigation -->
                        <ul class="nav nav-tabs" data-bs-toggle="tabs">
                            <li class="nav-item">
                                <a href="#tabs-biodata" class="nav-link active" data-bs-toggle="tab">Biodata</a>
                            </li>
                            <li class="nav-item">
                                <a href="#tabs-ortu" class="nav-link" data-bs-toggle="tab">Orang Tua</a>
                            </li>
                            <li class="nav-item">
                                <a href="#tabs-lokasi" class="nav-link" data-bs-toggle="tab">Lokasi & Bank</a>
                            </li>
                            <li class="nav-item">
                                <a href="#tabs-sosial" class="nav-link" data-bs-toggle="tab">Data Sosial</a>
                            </li>
                            <li class="nav-item">
                                <a href="#tabs-registrasi" class="nav-link" data-bs-toggle="tab">Registrasi</a>
                            </li>
                            <li class="nav-item">
                                <a href="#tabs-rombel" class="nav-link" data-bs-toggle="tab">Rombel</a>
                            </li>
                        </ul>

                        <!-- Tabs Content -->
                        <div class="tab-content mt-3">
                            <!-- Tab Biodata -->
                            <div class="tab-pane active show fade" id="tabs-biodata">
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item"><strong>Jenis Kelamin:</strong> {{ $student->jk }}</div>
                                    <div class="list-group-item"><strong>Tempat, Tanggal Lahir:</strong>
                                        {{ $student->tempat_lahir }}, {{ $student->tanggal_lahir }}</div>
                                    <div class="list-group-item"><strong>NIK:</strong> {{ $student->nik }}</div>
                                    <div class="list-group-item"><strong>Alamat:</strong> {{ $student->alamat }}, RT
                                        {{ $student->rt }}/RW {{ $student->rw }}, Dusun {{ $student->dusun }}</div>
                                    <div class="list-group-item"><strong>Kelurahan / Kecamatan:</strong>
                                        {{ $student->kelurahan }} / {{ $student->kecamatan }}</div>
                                    <div class="list-group-item"><strong>Telepon / HP:</strong> {{ $student->telepon }} /
                                        {{ $student->hp }}</div>
                                    <div class="list-group-item"><strong>Email:</strong> {{ $student->email }}</div>
                                    <div class="list-group-item"><strong>Agama:</strong> {{ $student->agama->nama ?? '-' }}
                                    </div>
                                    <div class="list-group-item"><strong>Alat Transportasi:</strong>
                                        {{ $student->alatTransportasi->nama ?? '-' }}</div>
                                    <div class="list-group-item"><strong>Jenis Tinggal:</strong>
                                        {{ $student->jenisTinggal->nama ?? '-' }}</div>
                                </div>
                            </div>

                            <!-- Tab Data Sosial -->
                            <div class="tab-pane fade" id="tabs-sosial">
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item"><strong>Penerima KPS:</strong>
                                        {{ $student->penerima_kps ? 'Ya' : 'Tidak' }}</div>
                                    <div class="list-group-item"><strong>No KPS:</strong> {{ $student->no_kps }}</div>
                                    <div class="list-group-item"><strong>Penerima KIP:</strong>
                                        {{ $student->penerima_kip ? 'Ya' : 'Tidak' }}</div>
                                    <div class="list-group-item"><strong>No KIP:</strong> {{ $student->nomor_kip }}</div>
                                    <div class="list-group-item"><strong>Nama di KIP:</strong> {{ $student->nama_di_kip }}
                                    </div>
                                    <div class="list-group-item"><strong>No KKS:</strong> {{ $student->nomor_kks }}</div>
                                    <div class="list-group-item"><strong>Layak PIP:</strong>
                                        {{ $student->layak_pip ? 'Ya' : 'Tidak' }}</div>
                                    <div class="list-group-item"><strong>Alasan Layak PIP:</strong>
                                        {{ $student->alasan_layak_pip }}</div>
                                </div>
                            </div>

                            <!-- Tab Lokasi & Bank -->
                            <div class="tab-pane fade" id="tabs-lokasi">
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item"><strong>Jarak Rumah ke Sekolah:</strong>
                                        {{ $student->jarak_rumah_km }} km</div>
                                    <div class="list-group-item"><strong>Lintang / Bujur:</strong> {{ $student->lintang }}
                                        / {{ $student->bujur }}</div>
                                    <div class="list-group-item"><strong>Bank:</strong> {{ $student->bank }}</div>
                                    <div class="list-group-item"><strong>No Rekening:</strong>
                                        {{ $student->nomor_rekening }}</div>
                                    <div class="list-group-item"><strong>Atas Nama Rekening:</strong>
                                        {{ $student->rekening_atas_nama }}</div>
                                </div>
                            </div>

                            <!-- Tab Orang Tua -->
                            <div class="tab-pane fade" id="tabs-ortu">
                                <div class="row g-2">
                                    @foreach ($student->orangTuas as $ortu)
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    <strong>{{ ucfirst($ortu->tipe) }}</strong>
                                                </div>
                                                <div class="card-body p-2">
                                                    <ul class="list-unstyled mb-0">
                                                        <li><strong>Nama:</strong> {{ $ortu->nama }}</li>
                                                        <li><strong>Tahun Lahir:</strong> {{ $ortu->tahun_lahir }}</li>
                                                        <li><strong>NIK:</strong> {{ $ortu->nik }}</li>
                                                        <li><strong>Pendidikan:</strong>
                                                            {{ $ortu->pendidikan->jenjang ?? '-' }}</li>
                                                        <li><strong>Pekerjaan:</strong> {{ $ortu->pekerjaan->nama ?? '-' }}
                                                        </li>
                                                        <li><strong>Penghasilan:</strong>
                                                            {{ $ortu->penghasilan->rentang ?? '-' }}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="tab-pane fade" id="tabs-registrasi">
                                <div class="row g-2">
                                    <h3>Riwayat Sekolah</h3>
                                    @if ($student->riwayatSekolah)
                                        <table class="table table-bordered">
                                            <tbody>

                                                <tr>
                                                    <th>Jenis Pendaftar</th>
                                                    <td>{{ $student->riwayatSekolah->jenis_pendaftar ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal Masuk</th>
                                                    <td>{{ $riwayatSekolah->tanggal_masuk_indo ?? '-' }}</td>
                                                </tr>
                                                @if ($student->riwayatSekolah->kelas_diterima)
                                                    <tr>
                                                        <th>Kelas Diterima</th>
                                                        <td>{{ $student->riwayatSekolah->kelas_diterima ?? '-' }}</td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <th>SKHUN</th>
                                                    <td>{{ $student->riwayatSekolah->skhun ?? '-' }}</td>
                                                </tr>


                                                @if ($student->riwayatSekolah->jenis_pendaftar === 'Siswa Baru')
                                                    <tr>
                                                        <th>Sekolah Asal</th>
                                                        <td>{{ $student->riwayatSekolah->sekolah_asal ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Tanggal Ijazah</th>
                                                        <td>{{ $student->riwayatSekolah->tanggal_ijazah_indo ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Nomor Ijazah</th>
                                                        <td>{{ $student->riwayatSekolah->nomor_ijazah ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Lama Belajar</th>
                                                        <td>{{ $student->riwayatSekolah->lama_belajar ? $student->riwayatSekolah->lama_belajar . ' tahun' : '-' }}
                                                        </td>
                                                    </tr>
                                                @elseif ($student->riwayatSekolah->jenis_pendaftar === 'Pindahan')
                                                    <tr>
                                                        <th>Dari Sekolah</th>
                                                        <td>{{ $student->riwayatSekolah->dari_sekolah ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Alasan Pindah</th>
                                                        <td>{{ $student->riwayatSekolah->alasan_pindah ?? '-' }}</td>
                                                    </tr>
                                                @elseif ($student->riwayatSekolah->jenis_pendaftar === 'Kembali Bersekolah')
                                                    <tr>
                                                        <th>Catatan Kembali</th>
                                                        <td>{{ $student->riwayatSekolah->catatan_kembali ?? '-' }}</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    @else
                                        <p class="text-muted fst-italic">Belum ada data riwayat sekolah.</p>
                                    @endif
                                </div>
                            </div>

                            <div class="tab-pane fade" id="tabs-rombel">
                                <div class="row g-2">
                                    <div>
                                        <h3>Riwayat Rombel</h3>
                                        <ul>
                                            @foreach ($riwayatRombel as $rombel)
                                                <li>
                                                    Tahun:
                                                    {{ $rombel->tahunPelajaran ? $rombel->tahunPelajaran->tahun_ajaran : 'Tahun Tidak Ditemukan' }},
                                                    Semester:
                                                    {{ $rombel->semester ? $rombel->semester->semester : 'Semester Tidak Ditemukan' }},
                                                    Kelas:
                                                    {{ $rombel->rombel ? $rombel->rombel->tingkat : 'Kelas Tidak Ditemukan' }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                </div>
                            </div>


                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
        <script>
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
        </script>

        <style>
            .fade-out {
                opacity: 0;
                transition: opacity 0.3s ease;
            }
        </style>
    @endpush
@endsection
