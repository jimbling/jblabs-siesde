@extends('layouts.tabler') <!-- Gunakan layout utama Tabler -->

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
                                    <h3 class="card-title mb-0">Peserta Didik</h3>
                                    <p class="text-secondary m-0">Jumlah Peserta Didik : {{ $totalStudents }}</p>
                                </div>


                                <div class="col-md-auto col-sm-12">
                                    <div class="ms-auto d-flex flex-wrap btn-list">

                                        <form id="form-generate-nomor" method="POST"
                                            action="{{ route('induk.generateNomorDokumen') }}">
                                            @csrf
                                            <div id="selected-students-generate"></div>
                                            <button type="button" class="btn btn-outline-primary"
                                                id="btn-generate-dokumen">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-file-text">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                    <path
                                                        d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h4l6 6v10a2 2 0 0 1 -2 2z" />
                                                    <line x1="9" y1="9" x2="10" y2="9" />
                                                    <line x1="9" y1="13" x2="15" y2="13" />
                                                    <line x1="9" y1="17" x2="15" y2="17" />
                                                </svg>
                                                Generate Nomor Dokumen
                                            </button>
                                        </form>



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
                                            <input id="siswa-table-search" type="text" class="form-control"
                                                autocomplete="off" />
                                            <span class="input-group-text">
                                                <kbd>ctrl + K</kbd>
                                            </span>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="siswa-table">
                            <div class="table-responsive">
                                <table class="table table-vcenter table-selectable">
                                    <thead>
                                        <tr>
                                            <th class="w-1"></th>
                                            <th>
                                                <button class="table-sort d-flex justify-content-between"
                                                    data-sort="sort-nama">Nama</button>
                                            </th>
                                            <th>
                                                <button class="table-sort d-flex justify-content-between"
                                                    data-sort="sort-nomor-dokumen">No Dokumen</button>
                                            </th>
                                            <th>
                                                <button class="table-sort d-flex justify-content-between"
                                                    data-sort="sort-nisn">NISN</button>
                                            </th>
                                            <th>
                                                <button class="table-sort d-flex justify-content-between"
                                                    data-sort="sort-tempat-lahir">Tempat Lahir</button>
                                            </th>
                                            <th>
                                                <button class="table-sort d-flex justify-content-between"
                                                    data-sort="sort-tanggal-lahir">Tanggal
                                                    Lahir</button>
                                            </th>
                                            <th>
                                                <button class="table-sort text-center">Aksi</button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-tbody">
                                        @forelse ($students as $student)
                                            <tr>
                                                <td>
                                                    <input class="form-check-input m-0 align-middle table-selectable-check"
                                                        type="checkbox" aria-label="Select siswa"
                                                        value="{{ $student->id }}" />
                                                </td>

                                                <td class="sort-nama">{{ $student->nama }}</td>
                                                <td class="sort-nomor-dokumen">
                                                    @if ($student->nomor_dokumen)
                                                        <span class="badge bg-azure-lt">{{ $student->nomor_dokumen }}</span>
                                                    @else
                                                        <span class="badge bg-default-lt">Belum Dibuat</span>
                                                    @endif
                                                </td>

                                                <td class="sort-nisn">{{ $student->nisn }}</td>
                                                <td class="sort-tempat-lahir">{{ $student->tempat_lahir }}</td>
                                                <td class="sort-tanggal-lahir">{{ $student->tanggal_lahir_formatted }}</td>

                                                <td class="text-center">
                                                    <div class="btn-list justify-content-center">
                                                        {{-- Lihat Detail --}}
                                                        <a href="{{ route('induk.siswa.detail', $student->uuid) }}"
                                                            class="btn btn-outline-primary btn-icon"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Lihat Buku Induk">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-eye-search">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                                <path
                                                                    d="M12 18c-.328 0 -.652 -.017 -.97 -.05c-3.172 -.332 -5.85 -2.315 -8.03 -5.95c2.4 -4 5.4 -6 9 -6c3.465 0 6.374 1.853 8.727 5.558" />
                                                                <path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                                                <path d="M20.2 20.2l1.8 1.8" />
                                                            </svg>
                                                        </a>

                                                        {{-- Tombol Cetak Buku Induk --}}
                                                        <form action="{{ route('induk.buku-induk.cetak') }}"
                                                            method="POST" target="_blank" class="d-inline">
                                                            @csrf
                                                            <input type="hidden" name="student_id"
                                                                value="{{ $student->id }}">
                                                            <button type="submit"
                                                                class="btn btn-outline-success btn-icon"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Cetak Buku Induk" @disabled(!$student->can_generate_pdf)>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-printer">
                                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                                        fill="none" />
                                                                    <path
                                                                        d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                                                                    <path
                                                                        d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                                                                    <path
                                                                        d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                                                                </svg>
                                                            </button>
                                                        </form>

                                                        {{-- Tombol Unduh PDF --}}

                                                        @if ($student->can_generate_pdf)
                                                            <a href="{{ route('induk.generatePDF', ['uuid' => $student->uuid]) }}"
                                                                class="btn btn-outline-warning btn-icon"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Unduh PDF">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-file-type-pdf">
                                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                                        fill="none" />
                                                                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                    <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                                                    <path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" />
                                                                    <path d="M17 18h2" />
                                                                    <path d="M20 15h-3v6" />
                                                                    <path
                                                                        d="M11 15v6h1a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-1z" />
                                                                </svg>
                                                            </a>
                                                        @else
                                                            <a href="#"
                                                                class="btn btn-outline-warning btn-icon disabled"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Tidak bisa diunduh karena belum ada Nomor Dokumen"
                                                                onclick="return false;">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-file-type-pdf">
                                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                                        fill="none" />
                                                                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                                    <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                                                    <path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" />
                                                                    <path d="M17 18h2" />
                                                                    <path d="M20 15h-3v6" />
                                                                    <path
                                                                        d="M11 15v6h1a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-1z" />
                                                                </svg>
                                                            </a>
                                                        @endif

                                                    </div>
                                                </td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted py-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2"
                                                        width="48" height="48" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <circle cx="12" cy="12" r="9" />
                                                        <line x1="12" y1="8" x2="12"
                                                            y2="12" />
                                                        <line x1="12" y1="16" x2="12.01"
                                                            y2="16" />
                                                    </svg>
                                                    <div><strong>Tidak ada data siswa yang tersedia.</strong></div>
                                                    <div class="small text-muted">Silakan tambahkan data atau periksa
                                                        filter pencarian Anda.</div>
                                                </td>
                                            </tr>
                                        @endforelse
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




    {{-- Modal Konfirmasi Hapus --}}
    <x-modal.konfirmasi id="modalKonfirmasiHapus" title="Hapus Data Terpilih?"
        body="Data yang dipilih akan dihapus permanen. Tindakan ini tidak dapat dibatalkan." btnLabel="Ya, Hapus"
        btnColor="danger" :formAction="''" {{-- formAction dikosongkan, nanti diisi JS --}} method="DELETE" />

    {{-- Modal Peringatan Tidak Ada Data --}}
    <x-modal.peringatan id="modalPeringatanTidakAdaData" title="Tidak Ada Data Dipilih"
        message="Silakan pilih setidaknya satu data untuk di generate nomor dokumen." btnLabel="Tutup" btnColor="warning"
        formAction="#" method="GET" />


    @push('scripts')
        <script>
            let list;

            document.addEventListener("DOMContentLoaded", function() {
                const advancedTable = {
                    headers: [{
                            "data-sort": "sort-nama",
                            name: "Nama"
                        },
                        {
                            "data-sort": "sort-nomor-dokumen",
                            name: "Nomor DOkumen"
                        },
                        {
                            "data-sort": "sort-nisn",
                            name: "NISN"
                        },
                        {
                            "data-sort": "sort-tempat-lahir",
                            name: "Tempat Lahir"
                        },
                        {
                            "data-sort": "sort-tanggal-lahir",
                            name: "Tanggal Lahir"
                        },
                    ],
                };

                list = new List("siswa-table", {
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

                const searchInput = document.querySelector("#siswa-table-search");
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
            function getSelectedStudentIds() {
                const checkboxes = document.querySelectorAll('.table-selectable-check:checked');
                return Array.from(checkboxes).map(cb => cb.value);
            }

            document.addEventListener("DOMContentLoaded", function() {
                const generateButton = document.getElementById("btn-generate-dokumen");
                const inputContainer = document.getElementById("selected-students-generate");
                const modalPeringatan = new bootstrap.Modal(document.getElementById('modalPeringatanTidakAdaData'));

                generateButton.addEventListener("click", function() {
                    const selectedIds = getSelectedStudentIds();

                    if (selectedIds.length === 0) {

                        modalPeringatan.show();
                        return;
                    }


                    inputContainer.innerHTML = '';


                    selectedIds.forEach(id => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'student_ids[]';
                        input.value = id;
                        inputContainer.appendChild(input);
                    });


                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Silakan tunggu, sedang membuat nomor dokumen.',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });


                    setTimeout(() => {
                        document.getElementById("form-generate-nomor").submit();
                    }, 500);
                });
            });
        </script>
    @endpush







@endsection
