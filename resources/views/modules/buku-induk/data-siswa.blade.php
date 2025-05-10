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
                                        <!-- Tombol untuk membuka modal -->
                                        <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal"
                                            data-bs-target="#tambahSiswaModal">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-users-plus">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M5 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4c.96 0 1.84 .338 2.53 .901" />
                                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                                <path d="M16 19h6" />
                                                <path d="M19 16v6" />
                                            </svg>
                                            Tambah Siswa
                                        </button>
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#importSiswaModal">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-file-import">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                <path
                                                    d="M5 13v-8a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2h-5.5m-9.5 -2h7m-3 -3l3 3l-3 3" />
                                            </svg>
                                            Import Siswa
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
                                            <input id="siswa-table-search" type="text" class="form-control"
                                                autocomplete="off" />
                                            <span class="input-group-text">
                                                <kbd>ctrl + K</kbd>
                                            </span>
                                        </div>

                                        <form id="form-mass-delete" method="POST"
                                            action="{{ route('induk.siswa.massDelete') }}">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="ids[]" id="selected-students">
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
                                                    data-sort="sort-nipd">NIPD</button>
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
                                                <td class="sort-nipd">{{ $student->nipd }}</td>
                                                <td class="sort-nisn">{{ $student->nisn }}</td>
                                                <td class="sort-tempat-lahir">{{ $student->tempat_lahir }}</td>
                                                <td class="sort-tanggal-lahir">{{ $student->tanggal_lahir_formatted }}</td>

                                                <td class="text-end">
                                                    <div class="btn-list justify-content-end">
                                                        {{-- Lihat Detail --}}
                                                        <a href="{{ route('induk.siswa.show', $student->uuid) }}"
                                                            class="btn btn-outline-primary btn-icon"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Lihat Detail">
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

                                                        {{-- Edit --}}
                                                        <a href="#" class="btn btn-outline-warning btn-icon"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Edit Siswa">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path
                                                                    d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                                <path
                                                                    d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                                <path d="M16 5l3 3" />
                                                            </svg>
                                                        </a>

                                                        {{-- Hapus --}}
                                                        <button type="button"
                                                            class="btn btn-outline-danger btn-icon btn-hapus-siswa"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Hapus Siswa"
                                                            data-url="{{ route('induk.siswa.destroy', $student->uuid) }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="icon icon-tabler icon-tabler-trash" width="24"
                                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                                stroke="currentColor" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <line x1="4" y1="7" x2="20"
                                                                    y2="7" />
                                                                <line x1="10" y1="11" x2="10"
                                                                    y2="17" />
                                                                <line x1="14" y1="11" x2="14"
                                                                    y2="17" />
                                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                <path d="M9 7v-3h6v3" />
                                                            </svg>
                                                        </button>

                                                        {{-- Foto Siswa --}}
                                                        <a href="{{ route('induk.akademik.foto-siswa.by-siswa', $student->uuid) }}"
                                                            class="btn btn-outline-info btn-icon" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Foto Siswa">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-photo-cog">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M15 8h.01" />
                                                                <path
                                                                    d="M12 21h-6a3 3 0 0 1 -3 -3v-12a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v6" />
                                                                <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l3 3" />
                                                                <path d="M14 14l1 -1c.48 -.461 1.016 -.684 1.551 -.67" />
                                                                <path d="M19.001 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                                <path d="M19.001 15.5v1.5" />
                                                                <path d="M19.001 21v1.5" />
                                                                <path d="M22.032 17.25l-1.299 .75" />
                                                                <path d="M17.27 20l-1.3 .75" />
                                                                <path d="M15.97 17.25l1.3 .75" />
                                                                <path d="M20.733 20l1.3 .75" />
                                                            </svg>
                                                        </a>
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


    <!-- Modal Import Siswa -->
    <div class="modal fade" id="importSiswaModal" tabindex="-1" aria-labelledby="importSiswaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="importForm" action="{{ route('induk.import-siswa') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="importSiswaModalLabel">Import Data Siswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <div class="alert alert-info" role="alert">
                                <strong>Informasi:</strong> Silakan unduh dan isi file template Excel dengan benar sebelum
                                melakukan import.
                            </div>

                            <a href="{{ asset('storage/panduan/dummy_siswa_22.xlsx') }}"
                                class="btn btn-outline-primary btn-sm mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-cloud-down">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M12 18.004h-5.343c-2.572 -.004 -4.657 -2.011 -4.657 -4.487c0 -2.475 2.085 -4.482 4.657 -4.482c.393 -1.762 1.794 -3.2 3.675 -3.773c1.88 -.572 3.956 -.193 5.444 1c1.488 1.19 2.162 3.007 1.77 4.769h.99c1.38 0 2.573 .813 3.13 1.99" />
                                    <path d="M19 16v6" />
                                    <path d="M22 19l-3 3l-3 -3" />
                                </svg>
                                Template Excel
                            </a>

                            <a href="{{ asset('storage/panduan/panduan.pdf') }}"
                                class="btn btn-outline-warning btn-sm mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-book-download">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 20h-6a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12v5" />
                                    <path d="M13 16h-7a2 2 0 0 0 -2 2" />
                                    <path d="M15 19l3 3l3 -3" />
                                    <path d="M18 22v-9" />
                                </svg>
                                Panduan
                            </a>
                        </div>

                        <div class="form-group">
                            <label for="file">Pilih file Excel (.xlsx)</label>
                            <input type="file" name="file" class="form-control">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- Modal Konfirmasi Hapus --}}
    <x-modal.konfirmasi id="modalKonfirmasiHapus" title="Hapus Data Terpilih?"
        body="Data yang dipilih akan dihapus permanen. Tindakan ini tidak dapat dibatalkan." btnLabel="Ya, Hapus"
        btnColor="danger" :formAction="''" {{-- formAction dikosongkan, nanti diisi JS --}} method="DELETE" />

    {{-- Modal Peringatan Tidak Ada Data --}}
    <x-modal.peringatan id="modalPeringatanTidakAdaData" title="Tidak Ada Data Dipilih"
        message="Silakan pilih setidaknya satu data untuk dihapus." btnLabel="Tutup" btnColor="warning" formAction="#"
        method="GET" />

    @include('components.modal.tambah-siswa')


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
                            "data-sort": "sort-nipd",
                            name: "NIPD"
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
            document.getElementById('btn-konfirmasi-hapus-pd').addEventListener('click', function() {
                const selected = document.querySelectorAll('.table-selectable-check:checked');

                if (selected.length === 0) {

                    const warningModal = new bootstrap.Modal(document.getElementById('modalPeringatanTidakAdaData'));
                    warningModal.show();
                    return;
                }

                const ids = Array.from(selected).map(checkbox => checkbox.value);

                let form = document.getElementById('form-mass-delete');
                if (!form) {
                    form = document.createElement('form');
                    form.method = 'POST';
                    form.action = "{{ route('induk.siswa.massDelete') }}";
                    form.id = 'form-mass-delete';

                    form.innerHTML = `
                        @csrf
                        @method('DELETE')
                    `;
                    document.body.appendChild(form);
                }

                form.querySelectorAll('input[name="ids[]"]').forEach(e => e.remove());

                ids.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'ids[]';
                    input.value = id;
                    form.appendChild(input);
                });

                const konfirmasiModal = new bootstrap.Modal(document.getElementById('modalKonfirmasiHapus'));
                konfirmasiModal.show();

                document.querySelector('#modalKonfirmasiHapus form').onsubmit = function(e) {
                    e.preventDefault();
                    form.submit();
                };
            });
        </script>

        <script>
            document.querySelectorAll('.btn-hapus-siswa').forEach(button => {
                button.addEventListener('click', function() {
                    const url = this.dataset.url;

                    const form = document.querySelector('#modalKonfirmasiHapus form');
                    form.action = url;

                    form.querySelectorAll('input[name="ids[]"]').forEach(e => e.remove());

                    const konfirmasiModal = new bootstrap.Modal(document.getElementById(
                        'modalKonfirmasiHapus'));
                    konfirmasiModal.show();

                    form.onsubmit = function(e) {

                    };
                });
            });
        </script>

        <script>
            document.getElementById('importForm').addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Memproses Import...',
                    text: 'Mohon tunggu beberapa saat.',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Submit form setelah SweetAlert ditampilkan
                setTimeout(() => {
                    e.target.submit();
                }, 300);
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const importForm = document.getElementById('importForm');
                const submitButton = importForm.querySelector('button[type="submit"]');
                const fileInput = importForm.querySelector('input[name="file"]');

                // Validasi saat file dipilih (format file)
                fileInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (!file) return;

                    const allowedExtensions = ['xls', 'xlsx'];
                    const fileExtension = file.name.split('.').pop().toLowerCase();

                    if (!allowedExtensions.includes(fileExtension)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Format file tidak didukung',
                            text: 'Silakan pilih file dengan format .xls atau .xlsx',
                        });
                        this.value = ''; // reset input
                    }
                });

                // Validasi sebelum submit (file kosong)
                submitButton.addEventListener('click', function(e) {
                    const file = fileInput.files[0];

                    if (!file) {
                        e.preventDefault(); // Hentikan submit jika file kosong
                        Swal.fire({
                            icon: 'warning',
                            title: 'File belum dipilih',
                            text: 'Silakan pilih file Excel terlebih dahulu sebelum mengimpor.',
                        });
                    }
                });
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Fungsi untuk update icon
                const updateChevron = (trigger) => {
                    const target = document.querySelector(trigger.getAttribute('href'));
                    const icon = trigger.querySelector('.collapse-icon path:last-child');

                    if (target.classList.contains('show')) {
                        icon.setAttribute('d', 'M6 15l6 -6l6 6'); // Chevron up
                    } else {
                        icon.setAttribute('d', 'M6 9l6 6l6 -6'); // Chevron down
                    }
                };

                // Inisialisasi untuk semua collapse element
                document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(trigger => {
                    const target = document.querySelector(trigger.getAttribute('href'));

                    // Update icon saat pertama kali load
                    updateChevron(trigger);

                    // Gunakan event Bootstrap resmi
                    target.addEventListener('shown.bs.collapse', () => updateChevron(trigger));
                    target.addEventListener('hidden.bs.collapse', () => updateChevron(trigger));

                    // Fallback untuk click langsung
                    trigger.addEventListener('click', () => {
                        setTimeout(() => updateChevron(trigger), 50);
                    });
                });
            });
        </script>

        <script>
            function initTomSelectWithTheme() {
                const isDark = document.body.classList.contains('theme-dark');
                const select = new TomSelect("#select-kebutuhan-khusus", {
                    render: {
                        option: function(data, escape) {
                            return `<div class="${isDark ? 'bg-dark text-white' : ''}">${escape(data.text)}</div>`;
                        }
                    }
                });
            }

            // Jika Anda punya tombol toggle dark/light:
            document.getElementById('themeToggleBtn')?.addEventListener('click', function() {
                // Hapus dan inisialisasi ulang (atau perbarui class)
                document.querySelectorAll('.ts-wrapper').forEach(el => el.remove());
                initTomSelectWithTheme();
            });

            // Panggil saat pertama
            initTomSelectWithTheme();
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modalEl = document.getElementById('tambahSiswaModal');

                modalEl.addEventListener('shown.bs.modal', function() {
                    window.initializeFlatpickr("#tanggal_lahir_display", {
                        altInput: true,
                        altFormat: "d F Y",
                        dateFormat: "Y-m-d",
                        maxDate: "today",
                        defaultDate: "1994-01-01",
                        locale: "id",
                        onChange: function(selectedDates, dateStr) {
                            document.getElementById('tanggal_lahir').value = dateStr;
                        }
                    });
                });
            });
        </script>


        <script>
            const apiUrl = "https://jimbling.github.io/api-wilayah-indonesia/api";

            document.addEventListener('DOMContentLoaded', function() {
                const provinsiSelect = document.getElementById('provinsi');
                const kabupatenSelect = document.getElementById('kabupaten');
                const kecamatanSelect = document.getElementById('kecamatan');
                const kelurahanSelect = document.getElementById('kelurahan');

                // Ambil daftar provinsi
                fetch(`${apiUrl}/provinces.json`)
                    .then(res => res.json())
                    .then(data => {
                        provinsiSelect.innerHTML = `<option value="">-- Pilih Provinsi --</option>`;
                        data.forEach(item => {
                            provinsiSelect.innerHTML +=
                                `<option value="${item.id}" data-nama="${item.name}">${item.name}</option>`;
                        });
                    });

                // Saat provinsi dipilih
                provinsiSelect.addEventListener('change', function() {
                    const provinsiId = this.value;
                    kabupatenSelect.innerHTML = `<option value="">-- Pilih Kabupaten/Kota --</option>`;
                    kecamatanSelect.innerHTML = `<option value="">-- Pilih Kecamatan --</option>`;
                    kelurahanSelect.innerHTML = `<option value="">-- Pilih Kelurahan --</option>`;

                    if (!provinsiId) return;

                    fetch(`${apiUrl}/regencies/${provinsiId}.json`)
                        .then(res => res.json())
                        .then(data => {
                            data.forEach(item => {
                                kabupatenSelect.innerHTML +=
                                    `<option value="${item.id}" data-nama="${item.name}">${item.name}</option>`;
                            });
                        });
                });

                // Saat kabupaten dipilih
                kabupatenSelect.addEventListener('change', function() {
                    const kabupatenId = this.value;
                    kecamatanSelect.innerHTML = `<option value="">-- Pilih Kecamatan --</option>`;
                    kelurahanSelect.innerHTML = `<option value="">-- Pilih Kelurahan --</option>`;

                    if (!kabupatenId) return;

                    fetch(`${apiUrl}/districts/${kabupatenId}.json`)
                        .then(res => res.json())
                        .then(data => {
                            data.forEach(item => {
                                kecamatanSelect.innerHTML +=
                                    `<option value="${item.id}" data-nama="${item.name}">${item.name}</option>`;
                            });
                        });
                });

                // Saat kecamatan dipilih
                kecamatanSelect.addEventListener('change', function() {
                    const kecamatanId = this.value;
                    kelurahanSelect.innerHTML = `<option value="">-- Pilih Kelurahan --</option>`;

                    if (!kecamatanId) return;

                    fetch(`${apiUrl}/villages/${kecamatanId}.json`)
                        .then(res => res.json())
                        .then(data => {
                            data.forEach(item => {
                                kelurahanSelect.innerHTML +=
                                    `<option value="${item.name}" data-nama="${item.name}">${item.name}</option>`;
                            });
                        });
                });
            });

            // Fungsi untuk ambil nama dari select sebelum disubmit (jika dibutuhkan)
            function getSelectedWilayahNames() {
                return {
                    provinsi: document.getElementById('provinsi').selectedOptions[0]?.dataset.nama || '',
                    kabupaten: document.getElementById('kabupaten').selectedOptions[0]?.dataset.nama || '',
                    kecamatan: document.getElementById('kecamatan').selectedOptions[0]?.dataset.nama || '',
                    kelurahan: document.getElementById('kelurahan').selectedOptions[0]?.dataset.nama || ''
                };
            }
        </script>
    @endpush







@endsection
