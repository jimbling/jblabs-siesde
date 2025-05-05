@extends('layouts.tabler')
@section('title', $title ?? 'Dashboard')

@section('page-title', 'Welcome to the Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body p-0">
                <div class="card">
                    <div class="card-table">
                        <div class="card-header">
                            <div class="row w-full">
                                <div class="col">


                                </div>
                                <div class="col-md-auto col-sm-12">
                                    <div class="ms-auto d-flex flex-wrap btn-list">
                                        <!-- Tombol untuk membuka modal -->
                                        <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal"
                                            data-bs-target="#modalTambahTahunPelajaran">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="currentColor"
                                                class="icon icon-tabler icons-tabler-filled icon-tabler-copy-plus">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M18.333 6a3.667 3.667 0 0 1 3.667 3.667v8.666a3.667 3.667 0 0 1 -3.667 3.667h-8.666a3.667 3.667 0 0 1 -3.667 -3.667v-8.666a3.667 3.667 0 0 1 3.667 -3.667zm-4.333 4a1 1 0 0 0 -1 1v2h-2a1 1 0 0 0 -.993 .883l-.007 .117a1 1 0 0 0 1 1h2v2a1 1 0 0 0 .883 .993l.117 .007a1 1 0 0 0 1 -1v-2h2a1 1 0 0 0 .993 -.883l.007 -.117a1 1 0 0 0 -1 -1h-2v-2a1 1 0 0 0 -.883 -.993zm1 -8c1.094 0 1.828 .533 2.374 1.514a1 1 0 1 1 -1.748 .972c-.221 -.398 -.342 -.486 -.626 -.486h-10c-.548 0 -1 .452 -1 1v9.998c0 .32 .154 .618 .407 .805l.1 .065a1 1 0 1 1 -.99 1.738a3 3 0 0 1 -1.517 -2.606v-10c0 -1.652 1.348 -3 3 -3z" />
                                            </svg>
                                            Tahun Pelajaran
                                        </button>

                                        <button type="button" class="btn btn-outline-info" data-bs-toggle="modal"
                                            data-bs-target="#modalTambahSemester">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="currentColor"
                                                class="icon icon-tabler icons-tabler-filled icon-tabler-copy-plus">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M18.333 6a3.667 3.667 0 0 1 3.667 3.667v8.666a3.667 3.667 0 0 1 -3.667 3.667h-8.666a3.667 3.667 0 0 1 -3.667 -3.667v-8.666a3.667 3.667 0 0 1 3.667 -3.667zm-4.333 4a1 1 0 0 0 -1 1v2h-2a1 1 0 0 0 -.993 .883l-.007 .117a1 1 0 0 0 1 1h2v2a1 1 0 0 0 .883 .993l.117 .007a1 1 0 0 0 1 -1v-2h2a1 1 0 0 0 .993 -.883l.007 -.117a1 1 0 0 0 -1 -1h-2v-2a1 1 0 0 0 -.883 -.993zm1 -8c1.094 0 1.828 .533 2.374 1.514a1 1 0 1 1 -1.748 .972c-.221 -.398 -.342 -.486 -.626 -.486h-10c-.548 0 -1 .452 -1 1v9.998c0 .32 .154 .618 .407 .805l.1 .065a1 1 0 1 1 -.99 1.738a3 3 0 0 1 -1.517 -2.606v-10c0 -1.652 1.348 -3 3 -3z" />
                                            </svg>
                                            Semester
                                        </button>


                                        <div class="input-group input-group-flat w-auto">
                                            <span class="input-group-text">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-1">
                                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                                    <path d="M21 21l-6 -6" />
                                                </svg>
                                            </span>
                                            <input id="tahunPelajaran-tabler-search" type="text" class="form-control"
                                                autocomplete="off" />
                                            <span class="input-group-text">
                                                <kbd>ctrl + K</kbd>
                                            </span>
                                        </div>

                                        <form id="form-hapus-tp" method="POST"
                                            action="{{ route('induk.akademik.tahun-pelajaran.bulk-destroy') }}">
                                            @csrf
                                            @method('DELETE')
                                            <div id="ids-container"></div>
                                            <button type="button" class="btn btn-outline-danger"
                                                id="btn-konfirmasi-hapus-pd">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M4 7l16 0" />
                                                    <path d="M10 11l0 6" />
                                                    <path d="M14 11l0 6" />
                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="tahunPelajaran-tabler">
                            <div class="table-responsive">
                                <table class="table table-vcenter card-table">
                                    <thead>
                                        <tr>
                                            <th class="w-1">
                                                <input class="form-check-input m-0 align-middle" type="checkbox"
                                                    id="select-all" />
                                            </th>
                                            <th>
                                                <button class="table-sort" data-sort="sort-tahun-pelajaran">Tahun
                                                    Pelajaran</button>
                                            </th>
                                            <th>
                                                <button class="table-sort " data-sort="sort-tanggal-mulai">Tanggal
                                                    Mulai</button>
                                            </th>
                                            <th>
                                                <button class="table-sort " data-sort="sort-tingkat">Tanggal
                                                    Selesai</button>
                                            </th>
                                            <th>
                                                <button class="table-sort " data-sort="sort-semester">Semester</button>
                                            </th>
                                            <th>
                                                <button class="table-sort " data-sort="sort-semester">Status
                                                    Semester</button>
                                            </th>
                                            <th>
                                                <button class="table-sort " data-sort="sort-aksi">Aksi Semester</button>
                                            </th>


                                        </tr>
                                    </thead>
                                    <tbody class="table-tbody">
                                        @foreach ($data as $item)
                                            @php
                                                $tp = $item;
                                                $semester = $item->semester;
                                                $semesterAktif = $semester && $semester->is_aktif;
                                            @endphp
                                            <tr>
                                                <td>
                                                    <input class="form-check-input m-0 align-middle row-checkbox"
                                                        type="checkbox" value="{{ $tp->tp_id }}" />
                                                </td>
                                                <td>{{ $tp->tahun_ajaran }}</td>
                                                <td>{{ $tp->semester?->tanggal_mulai_indo ?? '-' }}</td>
                                                <td>{{ $tp->semester?->tanggal_selesai_indo ?? '-' }}</td>


                                                {{-- Kolom Semester --}}
                                                <td>
                                                    @if ($semester)
                                                        <span class="text">{{ $semester->semester }}</span>
                                                    @else
                                                        <span class="text-muted fst-italic">Belum ada semester</span>
                                                    @endif
                                                </td>

                                                {{-- Kolom Status --}}
                                                <td>
                                                    @if ($semesterAktif)
                                                        <span class="badge bg-green-lt">Aktif</span>
                                                    @else
                                                        <span class="badge bg-yellow-lt">Tidak Aktif</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    {{-- Tombol Aktifkan Semester --}}
                                                    @if ($semester && !$semesterAktif)
                                                        <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Aktifkan Semester">
                                                            <button class="btn btn-outline-success btn-md btn-icon"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modalAktifkanSemester-{{ $tp->tp_id }}-{{ $semester->id }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-checkbox">
                                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                                        fill="none" />
                                                                    <path d="M9 11l3 3l8 -8" />
                                                                    <path
                                                                        d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9" />
                                                                </svg>
                                                            </button>
                                                        </span>
                                                    @else
                                                        <button class="btn btn-outline-secondary btn-md btn-icon" disabled
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Semester tidak tersedia atau sudah aktif">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-checkbox">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M9 11l3 3l8 -8" />
                                                                <path
                                                                    d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9" />
                                                            </svg>
                                                        </button>
                                                    @endif

                                                    {{-- Tombol Hapus Semester --}}
                                                    @if ($semester)
                                                        <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Hapus Semester">
                                                            <button class="btn btn-outline-danger btn-md btn-icon"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modalHapusSemester-{{ $tp->tp_id }}-{{ $semester->id }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                    height="20" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                                        fill="none" />
                                                                    <path d="M4 7l16 0" />
                                                                    <path d="M10 11l0 6" />
                                                                    <path d="M14 11l0 6" />
                                                                    <path
                                                                        d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                                </svg>
                                                            </button>
                                                        </span>
                                                    @else
                                                        <button class="btn btn-outline-secondary btn-md btn-icon" disabled
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Belum ada semester untuk dihapus">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                height="20" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M4 7l16 0" />
                                                                <path d="M10 11l0 6" />
                                                                <path d="M14 11l0 6" />
                                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                            </svg>
                                                        </button>
                                                    @endif

                                                    {{-- Tombol Nonaktifkan Semester --}}
                                                    @if ($semesterAktif)
                                                        <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Nonaktifkan Semester">
                                                            <button class="btn btn-outline-warning btn-md btn-icon"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modalNonaktifkanSemester-{{ $tp->tp_id }}-{{ $semester->id }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-progress-x">
                                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                                        fill="none" />
                                                                    <path d="M10 20.777a8.942 8.942 0 0 1 -2.48 -.969" />
                                                                    <path d="M14 3.223a9.003 9.003 0 0 1 0 17.554" />
                                                                    <path
                                                                        d="M4.579 17.093a8.961 8.961 0 0 1 -1.227 -2.592" />
                                                                    <path
                                                                        d="M3.124 10.5c.16 -.95 .468 -1.85 .9 -2.675l.169 -.305" />
                                                                    <path d="M6.907 4.579a8.954 8.954 0 0 1 3.093 -1.356" />
                                                                    <path d="M14 14l-4 -4" />
                                                                    <path d="M10 14l4 -4" />
                                                                </svg>
                                                            </button>
                                                        </span>
                                                    @else
                                                        <button class="btn btn-outline-secondary btn-md btn-icon" disabled
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Tidak ada semester aktif">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-progress-x">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M10 20.777a8.942 8.942 0 0 1 -2.48 -.969" />
                                                                <path d="M14 3.223a9.003 9.003 0 0 1 0 17.554" />
                                                                <path d="M4.579 17.093a8.961 8.961 0 0 1 -1.227 -2.592" />
                                                                <path
                                                                    d="M3.124 10.5c.16 -.95 .468 -1.85 .9 -2.675l.169 -.305" />
                                                                <path d="M6.907 4.579a8.954 8.954 0 0 1 3.093 -1.356" />
                                                                <path d="M14 14l-4 -4" />
                                                                <path d="M10 14l4 -4" />
                                                            </svg>
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>

                                            {{-- Modal Aktifkan Semester --}}
                                            @if ($semester && !$semesterAktif)
                                                <div class="modal fade"
                                                    id="modalAktifkanSemester-{{ $tp->tp_id }}-{{ $semester->id }}"
                                                    tabindex="-1"
                                                    aria-labelledby="modalAktifkanSemesterLabel-{{ $tp->tp_id }}-{{ $semester->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="modalAktifkanSemesterLabel-{{ $tp->tp_id }}-{{ $semester->id }}">
                                                                    Konfirmasi Aktifkan Semester</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Apakah Anda yakin ingin mengaktifkan semester
                                                                    <strong>{{ $semester->semester }}</strong> pada tahun
                                                                    pelajaran
                                                                    <strong>{{ $tp->tahun_ajaran }}</strong>?
                                                                </p>
                                                                <p>Semua semester lain di tahun pelajaran ini akan
                                                                    dinonaktifkan.</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <form
                                                                    action="{{ route('semesters.aktifkan', [$tp->tp_id, $semester->id]) }}"
                                                                    method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Aktifkan Semester</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            {{-- Modal Nonaktifkan Semester --}}
                                            @if ($semesterAktif)
                                                <x-modal.konfirmasi
                                                    id="modalNonaktifkanSemester-{{ $tp->tp_id }}-{{ $semester->id }}"
                                                    title="Konfirmasi Nonaktifkan Semester"
                                                    body="Apakah Anda yakin ingin menonaktifkan semester <strong>{{ $semester->semester }}</strong> untuk tahun pelajaran <strong>{{ $tp->tahun_ajaran }}</strong>? Semester akan dinonaktifkan dan tidak ada semester aktif untuk tahun pelajaran ini."
                                                    btnLabel="Nonaktifkan" btnColor="warning" :formAction="route('semester.nonaktifkan', [
                                                        $tp->tp_id,
                                                        $semester->id,
                                                    ])"
                                                    method="PATCH" />
                                            @endif

                                            {{-- Modal Hapus Semester --}}
                                            @if ($semester)
                                                <x-modal.konfirmasi
                                                    id="modalHapusSemester-{{ $tp->tp_id }}-{{ $semester->id }}"
                                                    title="Konfirmasi Hapus Semester"
                                                    body="Apakah Anda yakin ingin menghapus semester <strong>{{ $semester->semester }}</strong> dari tahun pelajaran <strong>{{ $tp->tahun_ajaran }}</strong>?"
                                                    btnLabel="Hapus" btnColor="danger" :formAction="route('induk.akademik.semester.destroy', [
                                                        $tp->tp_id,
                                                        $semester->id,
                                                    ])"
                                                    method="DELETE" />
                                            @endif
                                        @endforeach
                                    </tbody>









                                </table>
                            </div>

                            <div class="card-footer d-flex align-items-center">
                                <div class="dropdown">
                                    <a class="btn dropdown-toggle" data-bs-toggle="dropdown">
                                        <span id="page-count" class="me-1">10</span>
                                        <span>data</span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" onclick="setPageListItems(event)" data-value="10">10
                                            data</a>
                                        <a class="dropdown-item" onclick="setPageListItems(event)" data-value="20">20
                                            data</a>
                                        <a class="dropdown-item" onclick="setPageListItems(event)" data-value="50">50
                                            data</a>
                                        <a class="dropdown-item" onclick="setPageListItems(event)" data-value="100">100
                                            data</a>
                                    </div>
                                </div>
                                <ul class="pagination m-0 ms-auto">
                                    <!-- Pagination buttons -->
                                </ul>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>




    @foreach ($data as $tp)
        <x-modal.konfirmasi id="modalHapusSemester-{{ $tp->tp_id }}-{{ $tp->semester?->id }}" title="Hapus Semester"
            body="Apakah Anda yakin ingin menghapus semester ini? Tindakan ini tidak dapat dibatalkan." btnLabel="Hapus"
            btnColor="danger" :formAction="route('semester.hapus', [$tp->tp_id, $tp->semester?->id])" method="DELETE" />
    @endforeach


    {{-- Modal Konfirmasi Hapus --}}
    <x-modal.konfirmasi id="modalKonfirmasiHapus" title="Hapus Data Terpilih?"
        body="Data yang dipilih akan dihapus permanen. Tindakan ini tidak dapat dibatalkan." btnLabel="Ya, Hapus"
        btnColor="danger" :formAction="''" method="DELETE" />


    {{-- Modal Peringatan Tidak Ada Data --}}
    <x-modal.peringatan id="modalPeringatanTidakAdaData" title="Tidak Ada Data Dipilih"
        message="Silakan pilih setidaknya satu data untuk dihapus." btnLabel="Tutup" btnColor="warning" formAction="#"
        method="GET" />

    <div class="modal modal-blur fade" id="modalTambahTahunPelajaran" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('induk.akademik.tahun-pelajaran.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Tahun Pelajaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <!-- Tahun Ajaran -->
                        <div class="mb-3 row align-items-center">
                            <label class="col-sm-4 col-form-label">Tahun Ajaran</label>
                            <div class="col-sm-8">
                                <input type="text" name="tahun_ajaran" class="form-control"
                                    placeholder="Contoh: 2024/2025" required>
                            </div>
                        </div>



                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal modal-blur fade" id="modalTambahSemester" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('induk.akademik.semester.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Semester</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        {{-- Tahun Pelajaran --}}
                        <div class="mb-3 row align-items-center">
                            <label class="col-sm-4 col-form-label">Tahun Pelajaran</label>
                            <div class="col-sm-8">
                                <select name="tahun_pelajaran_id" class="form-select" required>
                                    <option value="">-- Pilih Tahun Pelajaran --</option>
                                    @foreach ($data as $tp)
                                        <option value="{{ $tp->tp_id }}">{{ $tp->tahun_ajaran }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Semester --}}
                        <div class="mb-3 row align-items-center">
                            <label class="col-sm-4 col-form-label">Semester</label>
                            <div class="col-sm-8">
                                <select name="semester" class="form-select" required>
                                    <option value="">-- Pilih Semester --</option>
                                    <option value="Ganjil">Ganjil</option>
                                    <option value="Genap">Genap</option>
                                </select>
                            </div>
                        </div>

                        {{-- Tanggal Mulai --}}
                        <div class="mb-3 row align-items-center">
                            <label class="col-sm-4 col-form-label">Tanggal Mulai</label>
                            <div class="col-sm-8">
                                <input type="text" id="tanggal_mulai_display" class="form-control datepicker"
                                    required>
                                <input type="hidden" name="tanggal_mulai" id="tanggal_mulai">
                            </div>
                        </div>

                        {{-- Tanggal Selesai --}}
                        <div class="mb-3 row align-items-center">
                            <label class="col-sm-4 col-form-label">Tanggal Selesai</label>
                            <div class="col-sm-8">
                                <input type="text" id="tanggal_selesai_display" class="form-control datepicker"
                                    required>
                                <input type="hidden" name="tanggal_selesai" id="tanggal_selesai">
                            </div>
                        </div>

                        {{-- Aktif --}}
                        <div class="mb-3 row align-items-center">
                            <label class="col-sm-4 col-form-label">Status Aktif</label>
                            <div class="col-sm-8">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_aktif" value="1">
                                    <label class="form-check-label">Aktifkan semester ini</label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>






    @push('scripts')
        <script>
            let list;

            document.addEventListener("DOMContentLoaded", function() {
                const advancedTable = {
                    headers: [{
                            "data-sort": "sort-tahun-pelajaran",
                            name: "Tahun Pelajaran"

                        },
                        {
                            "data-sort": "sort-tanggal-mulai",
                            name: "Tanggal Mulai"

                        },
                        {
                            "data-sort": "sort-tanggal-selesai",
                            name: "Tanggal Selesai"

                        },
                        {
                            "data-sort": "sort-semester",
                            name: "Semester"

                        },
                        {
                            "data-sort": "sort-aksi",
                            name: "Aksi"

                        }

                    ],
                };

                list = new List("tahunPelajaran-tabler", {
                    sortClass: "table-sort",
                    listClass: "table-tbody",
                    page: 10,
                    pagination: {
                        item: (value) =>
                            `<li class="page-item"><a class="page-link cursor-pointer">${value.page}</a></li>`,
                        innerWindow: 1,
                        outerWindow: 1,
                        left: 0,
                        right: 0,
                    },
                    valueNames: advancedTable.headers.map(header => header["data-sort"]),
                });

                const searchInput = document.querySelector("#tahunPelajaran-tabler-search");
                if (searchInput) {
                    searchInput.addEventListener("input", () => {
                        list.search(searchInput.value);
                    });
                }

                document.addEventListener("keydown", function(e) {
                    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                        e.preventDefault();
                        if (searchInput) searchInput.focus();
                    }
                });
            });

            function setPageListItems(event) {
                const newPageCount = parseInt(event.target.dataset.value);

                if (list) {
                    list.page = newPageCount;
                    list.update();
                }

                document.getElementById('page-count').textContent = newPageCount;
            }
        </script>
        <script>
            document.getElementById('btn-konfirmasi-hapus-pd').addEventListener('click', function() {
                const selected = document.querySelectorAll(
                    '.row-checkbox:checked'); // Mengubah kelas sesuai dengan checkbox di baris

                if (selected.length === 0) {
                    const warningModal = new bootstrap.Modal(document.getElementById('modalPeringatanTidakAdaData'));
                    warningModal.show();
                    return;
                }

                const ids = Array.from(selected).map(checkbox => checkbox.value);

                const idsContainer = document.getElementById('ids-container');
                idsContainer.innerHTML = '';

                ids.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'ids[]';
                    input.value = id;
                    idsContainer.appendChild(input);
                });

                const konfirmasiModal = new bootstrap.Modal(document.getElementById('modalKonfirmasiHapus'));
                konfirmasiModal.show();

                document.querySelector('#modalKonfirmasiHapus form').onsubmit = function(e) {
                    e.preventDefault();
                    document.getElementById('form-hapus-tp').submit();
                };
            });

            document.getElementById('select-all').addEventListener('change', function() {
                const isChecked = this.checked;
                const checkboxes = document.querySelectorAll('.row-checkbox');

                checkboxes.forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
            });
        </script>
        <script>
            document.querySelectorAll('.tp-row').forEach(row => {
                row.addEventListener('click', function() {
                    const icon = this.querySelector('i');
                    icon.classList.toggle('ti-chevron-down');
                    icon.classList.toggle('ti-chevron-up');
                });
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const tanggalMulaiDisplay = document.getElementById('tanggal_mulai_display');
                const tanggalMulai = document.getElementById('tanggal_mulai');
                const tanggalSelesaiDisplay = document.getElementById('tanggal_selesai_display');
                const tanggalSelesai = document.getElementById('tanggal_selesai');

                const pickerMulai = new Litepicker({
                    element: tanggalMulaiDisplay,
                    lang: 'id',
                    format: 'DD MMMM YYYY',
                    autoApply: true,
                    onSelect: (date) => {
                        tanggalMulai.value = date.format('YYYY-MM-DD');
                    }
                });

                const pickerSelesai = new Litepicker({
                    element: tanggalSelesaiDisplay,
                    lang: 'id',
                    format: 'DD MMMM YYYY',
                    autoApply: true,
                    onSelect: (date) => {
                        tanggalSelesai.value = date.format('YYYY-MM-DD');
                    }
                });


                document.querySelector('#modalTambahSemester form').addEventListener('submit', function(e) {
                    if (!tanggalMulai.value && tanggalMulaiDisplay.value) {
                        const d = pickerMulai.getDate();
                        tanggalMulai.value = d ? d.format('YYYY-MM-DD') : '';
                    }
                    if (!tanggalSelesai.value && tanggalSelesaiDisplay.value) {
                        const d = pickerSelesai.getDate();
                        tanggalSelesai.value = d ? d.format('YYYY-MM-DD') : '';
                    }
                });
            });
        </script>
    @endpush

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>






@endsection
