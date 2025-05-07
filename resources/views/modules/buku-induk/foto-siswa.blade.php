@extends('layouts.tabler')

@section('title', $title ?? 'Dashboard')

@section('page-title', 'Detail Siswa')

@section('content')
    <div class="container-fluid">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title mb-0">{{ $siswa->nama ?? '-' }}</h2>
                <div class="text-secondary mt-1">NISN : {{ $siswa->nisn ?? '-' }}</div>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="d-flex">

                    <a href="#" class="btn btn-primary btn-3" data-bs-toggle="modal" data-bs-target="#modalTambahFoto"
                        data-semester-add data-foto-id="tambah">
                        <!-- Download SVG icon from http://tabler.io/icons/icon/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-photo-plus">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M15 8h.01" />
                            <path d="M12.5 21h-6.5a3 3 0 0 1 -3 -3v-12a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v6.5" />
                            <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l4 4" />
                            <path d="M14 14l1 -1c.67 -.644 1.45 -.824 2.182 -.54" />
                            <path d="M16 19h6" />
                            <path d="M19 16v6" />
                        </svg>
                        Tambah Foto
                    </a>
                </div>
            </div>
        </div>



        <!-- BEGIN PAGE BODY -->
        <div class="page-body">

            <div class="row row-cards">
                @forelse ($fotos as $foto)
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="card card-sm shadow-lg hover-shadow-xl transition-shadow">
                            <div class="card-img-top img-responsive img-responsive-16by9"
                                style="background-image: url('{{ asset('storage/' . $foto->path_foto) }}');
                                            background-size: cover;
                                            background-position: center;">
                            </div>

                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="me-auto">
                                        <h3 class="card-title mb-1">{{ $siswa->nama ?? '-' }}</h3>
                                        <div class="text-muted">
                                            <small>{{ $tanggal_lahir_formatted ?? '-' }}</small>
                                        </div>
                                    </div>

                                    <!-- Avatar dengan Preview Hover -->
                                    <div class="avatar-preview-container">
                                        <span class="avatar avatar-sm avatar-preview-trigger"
                                            style="background-image: url('{{ asset('storage/' . $foto->path_foto) }}')">
                                        </span>

                                        <!-- Preview Bubble -->
                                        <div class="avatar-preview-bubble">
                                            <img src="{{ asset('storage/' . $foto->path_foto) }}" alt="Preview Foto"
                                                class="preview-image">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="d-flex flex-wrap gap-1">
                                        <span class="badge bg-primary-lt" data-bs-placement="top" data-bs-toggle="tooltip"
                                            title="Tahun Pelajaran">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-calendar" width="16" height="16"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                                <path d="M16 3v4" />
                                                <path d="M8 3v4" />
                                                <path d="M4 11h16" />
                                            </svg>
                                            {{ $foto->tahunPelajaran->tahun_ajaran ?? 'N/A' }}
                                        </span>

                                        <span class="badge bg-green-lt" data-bs-placement="top" data-bs-toggle="tooltip"
                                            title="Semester">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-school" width="16" height="16"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M22 9l-10 -4l-10 4l10 4l10 -4v6" />
                                                <path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4" />
                                            </svg>
                                            {{ $foto->semester->semester ?? 'N/A' }}
                                        </span>

                                        <span class="badge bg-yellow-lt" data-bs-placement="top" data-bs-toggle="tooltip"
                                            title="Rombel">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-users" width="16" height="16"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                            </svg>
                                            {{ $foto->rombel->nama ?? 'N/A' }}
                                        </span>
                                    </div>

                                </div>

                                <div class="d-flex">
                                    <span data-bs-placement="top" data-bs-toggle="tooltip" title="Edit Foto">
                                        <a href="#"class="btn btn-icon btn-outline-primary me-2"
                                            data-bs-toggle="modal" data-bs-target="#modalEditFoto-{{ $foto->id }}"
                                            data-semester-edit data-foto-id="{{ $foto->id }}"
                                            data-tahun-pelajaran="{{ $foto->tahun_pelajaran_id }}"
                                            data-semester="{{ $foto->semester_id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                <path
                                                    d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                <path d="M16 5l3 3" />
                                            </svg>
                                        </a>

                                    </span>


                                    {{-- Modal Edit Foto --}}
                                    <div class="modal modal-blur fade" id="modalEditFoto-{{ $foto->id }}"
                                        tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                            <form action="{{ route('induk.akademik.foto-siswa.update', $foto->id) }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="siswa_uuid" value="{{ $siswa->uuid }}">

                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Foto Siswa</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Tutup"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="row">
                                                            {{-- Preview Foto Asli --}}
                                                            <div class="col-lg-12 mb-3 text-center">
                                                                <label class="form-label">Foto Sebelumnya</label><br>
                                                                <img src="{{ asset('storage/' . $foto->path_foto_asli) }}"
                                                                    class="img-thumbnail" style="max-height: 200px;">
                                                            </div>

                                                            <div class="col-lg-6 mb-3">
                                                                <label class="form-label">Tahun Pelajaran</label>
                                                                <select id="tahunPelajaranSelect-{{ $foto->id }}"
                                                                    class="form-select" required>
                                                                    @foreach ($tahunPelajarans as $tp)
                                                                        <option value="{{ $tp->id }}"
                                                                            {{ $tp->id == $foto->tahun_pelajaran_id ? 'selected' : '' }}>
                                                                            {{ $tp->tahun_ajaran }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="col-lg-6 mb-3">
                                                                <label class="form-label">Semester</label>
                                                                <select id="semesterSelect-{{ $foto->id }}"
                                                                    class="form-select" required>
                                                                    {{-- Akan diisi via JavaScript --}}
                                                                </select>
                                                            </div>

                                                            <div class="col-lg-12 mb-3">
                                                                <label class="form-label">Rombel</label>
                                                                <select class="form-select" name="rombel_id" required>
                                                                    <option value="">-- Pilih Rombel --</option>
                                                                    @foreach ($rombels as $rombel)
                                                                        <option value="{{ $rombel->id }}"
                                                                            {{ $foto->rombel_id == $rombel->id ? 'selected' : '' }}>
                                                                            {{ $rombel->nama }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="col-lg-12 mb-3">
                                                                <label class="form-label">Ganti Foto (Opsional)</label>
                                                                <input type="file" class="form-control"
                                                                    name="path_foto" accept="image/*">
                                                                <small class="form-hint text-muted">Kosongkan jika tidak
                                                                    ingin mengganti foto. Maks
                                                                    500KB.</small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <input type="hidden" name="tahun_pelajaran_id"
                                                        id="tahunPelajaranId-{{ $foto->id }}"
                                                        value="{{ $foto->tahun_pelajaran_id }}">
                                                    <input type="hidden" name="semester_id"
                                                        id="semesterId-{{ $foto->id }}"
                                                        value="{{ $foto->semester_id }}">



                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-warning">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="icon icon-tabler icon-tabler-photo-edit"
                                                                width="24" height="24" viewBox="0 0 24 24"
                                                                stroke-width="2" stroke="currentColor" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M15 8h.01" />
                                                                <path d="M7 16l4.5 -4.5a2.121 2.121 0 0 1 3 0l.5 .5" />
                                                                <path d="M19.5 12.5l-2.5 2.5" />
                                                                <path d="M17 19h6" />
                                                                <path d="M3 20v-15a2 2 0 0 1 2 -2h11a2 2 0 0 1 2 2v7" />
                                                            </svg>
                                                            Update Foto
                                                        </button>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <span data-bs-placement="top" data-bs-toggle="tooltip" title="Hapus Foto">
                                        <button type="button"
                                            class="btn btn-icon btn-outline-danger btn-konfirmasi-hapus"
                                            data-bs-toggle="modal" data-bs-target="#modalKonfirmasiHapus"
                                            data-action="{{ route('induk.akademik.foto-siswa.destroy', $foto->id) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M4 7l16 0" />
                                                <path d="M10 11l0 6" />
                                                <path d="M14 11l0 6" />
                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                            </svg>
                                        </button>
                                    </span>


                                    <a href="{{ asset('storage/' . $foto->path_foto) }}"
                                        class="btn btn-icon btn-outline-secondary ms-auto" download
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Download Foto">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                            <path d="M7 11l5 5l5 -5" />
                                            <path d="M12 4l0 12" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card card-empty">
                            <div class="card-body text-center py-5">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-photo-off mb-3 text-muted" width="48"
                                    height="48" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M15 8h.01" />
                                    <path
                                        d="M7 3h11a3 3 0 0 1 3 3v11m-.856 3.099a2.991 2.991 0 0 1 -2.144 .901h-12a3 3 0 0 1 -3 -3v-12c0 -.845 .349 -1.608 .91 -2.153" />
                                    <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l5 5" />
                                    <path d="M16.33 12.338c.574 -.054 1.155 .166 1.67 .662l3 3" />
                                    <path d="M3 3l18 18" />
                                </svg>
                                <h3 class="text-muted mb-3">Belum ada foto yang tersedia</h3>
                                <p class="text-muted mb-3">Silakan unggah foto siswa untuk menampilkannya di sini</p>
                                <a href="#" class="btn btn-primary btn-3" data-bs-toggle="modal"
                                    data-bs-target="#modalTambahFoto" data-semester-add data-foto-id="tambah">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-upload"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                        <path d="M7 9l5 -5l5 5" />
                                        <path d="M12 4l0 12" />
                                    </svg>
                                    Unggah Foto Pertama
                                </a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>


        </div>

    </div>

    <!-- Modal Tambah Foto -->
    <div class="modal modal-blur fade" id="modalTambahFoto" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <form action="{{ route('induk.akademik.foto-siswa.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="siswa_uuid" value="{{ $siswa->uuid }}">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Foto Siswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label class="form-label">Tahun Pelajaran</label>
                                <select class="form-select" name="tahun_pelajaran_id" id="tahunPelajaranSelect-tambah"
                                    required>
                                    <option value="">-- Pilih Tahun Pelajaran --</option>
                                    @foreach ($tahunPelajarans as $tp)
                                        <option value="{{ $tp->id }}">{{ $tp->tahun_ajaran }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label">Semester</label>
                                <select class="form-select" name="semester_id" id="semesterSelect-tambah" required>
                                    <option value="">-- Pilih Semester --</option>
                                    {{-- Akan diisi dinamis lewat JavaScript --}}
                                </select>
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="form-label">Rombel</label>
                                <select class="form-select" name="rombel_id" required>
                                    <option value="">-- Pilih Rombel --</option>
                                    @foreach ($rombels as $rombel)
                                        <option value="{{ $rombel->id }}">{{ $rombel->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="form-label">Unggah Foto</label>
                                <input type="file" class="form-control" name="path_foto" accept="image/*" required>
                                <small class="form-hint text-muted">Format: JPG, PNG, maksimal 500KB.</small>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="tahun_pelajaran_id" id="tahunPelajaranId-tambah">
                    <input type="hidden" name="semester_id" id="semesterId-tambah">

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-upload"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                <path d="M7 9l5 -5l5 5" />
                                <path d="M12 4l0 12" />
                            </svg>
                            Simpan Foto
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>




    <x-modal.konfirmasi id="modalKonfirmasiHapus" title="Hapus Data Terpilih?"
        body="Data yang dipilih akan dihapus permanen. Tindakan ini tidak dapat dibatalkan." btnLabel="Ya, Hapus"
        btnColor="danger" :formAction="''" method="DELETE" />



    @push('scripts')
        <script>
            function setupSemesterDropdown(tahunSelectId, semesterSelectId, selectedSemesterId = null) {
                const tahunSelect = document.getElementById(tahunSelectId);
                const semesterSelect = document.getElementById(semesterSelectId);

                tahunSelect.addEventListener('change', function() {
                    const tahunPelajaranId = this.value;
                    semesterSelect.innerHTML = '<option value="">-- Mengambil data... --</option>';

                    if (tahunPelajaranId) {
                        fetch(`/get-semesters/${tahunPelajaranId}`)
                            .then(response => response.json())
                            .then(data => {
                                semesterSelect.innerHTML = '<option value="">-- Pilih Semester --</option>';
                                data.forEach(item => {
                                    const label =
                                        `${item.tahun_pelajaran?.tahun_ajaran ?? ''} - ${item.semester}`;
                                    const selected = selectedSemesterId == item.id ? 'selected' : '';
                                    semesterSelect.innerHTML +=
                                        `<option value="${item.id}" ${selected}>${label}</option>`;
                                });
                            })
                            .catch(() => {
                                semesterSelect.innerHTML = '<option value="">-- Gagal mengambil data --</option>';
                            });
                    } else {
                        semesterSelect.innerHTML = '<option value="">-- Pilih Semester --</option>';
                    }
                });

                // Trigger 'change' event to fetch semester data if a year is already selected
                if (tahunSelect.value) {
                    tahunSelect.dispatchEvent(new Event('change'));
                }

                // Update input tersembunyi saat tahun pelajaran atau semester dipilih
                tahunSelect.addEventListener('change', function() {
                    // Update input tersembunyi tahun_pelajaran_id
                    const tahunPelajaranInput = document.getElementById(
                        `tahunPelajaranId-${tahunSelectId.split('-')[1]}`);
                    if (tahunPelajaranInput) {
                        tahunPelajaranInput.value = this.value;
                    }

                    // Trigger perubahan semester jika tahun pelajaran berubah
                    const semesterSelect = document.getElementById(semesterSelectId);
                    const semesterInput = document.getElementById(`semesterId-${tahunSelectId.split('-')[1]}`);
                    if (semesterInput && semesterSelect.value) {
                        semesterInput.value = semesterSelect.value;
                    }
                });

                semesterSelect.addEventListener('change', function() {
                    // Update input tersembunyi semester_id
                    const semesterInput = document.getElementById(`semesterId-${tahunSelectId.split('-')[1]}`);
                    if (semesterInput) {
                        semesterInput.value = this.value;
                    }
                });
            }

            // Setup dropdown dan input tersembunyi untuk setiap modal
            document.querySelectorAll('[data-semester-edit]').forEach(btn => {
                const fotoId = btn.dataset.fotoId;
                const tahunId = btn.dataset.tahunPelajaran;
                const semesterId = btn.dataset.semester;

                // Setup input tersembunyi untuk form edit
                const tahunPelajaranInput = document.getElementById(`tahunPelajaranId-${fotoId}`);
                const semesterInput = document.getElementById(`semesterId-${fotoId}`);

                // Set nilai untuk input tersembunyi saat modal dibuka
                if (tahunPelajaranInput) {
                    tahunPelajaranInput.value = tahunId;
                }
                if (semesterInput) {
                    semesterInput.value = semesterId;
                }

                // Setup dropdown semester sesuai tahun pelajaran
                const tahunSelectId = `tahunPelajaranSelect-${fotoId}`;
                const semesterSelectId = `semesterSelect-${fotoId}`;

                btn.addEventListener('click', function() {
                    // Pastikan dropdown semester di-setup dengan benar
                    setupSemesterDropdown(tahunSelectId, semesterSelectId, semesterId);

                    // Trigger fetch manual saat modal dibuka
                    const tahunSelect = document.getElementById(tahunSelectId);
                    if (tahunSelect) {
                        tahunSelect.dispatchEvent(new Event('change'));
                    }
                });
            });

            // Setup untuk form tambah (tanpa data edit sebelumnya)
            document.querySelectorAll('[data-semester-add]').forEach(btn => {
                const fotoId = btn.dataset.fotoId;

                // Setup input tersembunyi untuk form tambah
                const tahunPelajaranInput = document.getElementById(`tahunPelajaranId-${fotoId}`);
                const semesterInput = document.getElementById(`semesterId-${fotoId}`);

                // Set nilai kosong untuk input tersembunyi saat modal dibuka
                if (tahunPelajaranInput) {
                    tahunPelajaranInput.value = '';
                }
                if (semesterInput) {
                    semesterInput.value = '';
                }

                // Setup dropdown semester sesuai tahun pelajaran
                const tahunSelectId = `tahunPelajaranSelect-${fotoId}`;
                const semesterSelectId = `semesterSelect-${fotoId}`;

                btn.addEventListener('click', function() {
                    // Pastikan dropdown semester di-setup dengan benar
                    setupSemesterDropdown(tahunSelectId, semesterSelectId);

                    // Trigger fetch manual saat modal dibuka
                    const tahunSelect = document.getElementById(tahunSelectId);
                    if (tahunSelect) {
                        tahunSelect.dispatchEvent(new Event('change'));
                    }
                });
            });
        </script>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const hapusButtons = document.querySelectorAll('.btn-konfirmasi-hapus');
                const form = document.querySelector('#modalKonfirmasiHapus form');

                hapusButtons.forEach(button => {
                    button.addEventListener('click', () => {
                        const action = button.getAttribute('data-action');
                        form.setAttribute('action', action);
                    });
                });
            });
        </script>
        <script>
            const inputFoto = document.querySelector('input[name="path_foto"]');
            const previewContainer = document.createElement('div');
            previewContainer.style.marginTop = '10px';
            inputFoto.parentNode.appendChild(previewContainer);

            inputFoto.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (!file) return;

                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                const maxSize = 512 * 1024; // 500KB

                if (!allowedTypes.includes(file.type)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Format tidak didukung',
                        text: 'Hanya diperbolehkan file JPG, JPEG, atau PNG.',
                    });
                    e.target.value = '';
                    previewContainer.innerHTML = '';
                    return;
                }

                if (file.size > maxSize) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ukuran terlalu besar',
                        text: 'Ukuran maksimal foto adalah 500KB.',
                    });
                    e.target.value = '';
                    previewContainer.innerHTML = '';
                    return;
                }

                // Jika valid, tampilkan preview
                const reader = new FileReader();
                reader.onload = function(event) {
                    previewContainer.innerHTML =
                        `<img src="${event.target.result}" alt="Preview Foto" style="max-width: 100%; max-height: 300px; border: 1px solid #ddd; padding: 5px; border-radius: 8px;">`;
                };
                reader.readAsDataURL(file);
            });
        </script>
    @endpush
@endsection
