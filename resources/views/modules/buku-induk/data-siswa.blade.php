@extends('layouts.tabler') <!-- Gunakan layout utama Tabler -->

@section('title', $title ?? 'Dashboard')

@section('page-title', 'Welcome to the Dashboard')

@section('content')
    <div class="container-xl">
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
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#importSiswaModal">
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

                                        <button type="button" class="btn btn-outline-danger" id="btn-konfirmasi-hapus-pd">
                                            Hapus PD
                                        </button>
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
                                                    data-sort="sort-kelas">Kelas</button>
                                            </th>
                                            <th>
                                                <button class="table-sort d-flex justify-content-between"
                                                    data-sort="sort-tanggal">Tanggal
                                                    Dibuat</button>
                                            </th>
                                            <th>
                                                <button class="table-sort d-flex justify-content-between">Aksi</button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-tbody">
                                        @foreach ($students as $student)
                                            <tr>
                                                <td>
                                                    <input class="form-check-input m-0 align-middle table-selectable-check"
                                                        type="checkbox" aria-label="Select siswa"
                                                        value="{{ $student->id }}" />
                                                </td>

                                                <td class="sort-nama">{{ $student->nama }}</td>
                                                <td class="sort-nipd">{{ $student->nipd }}</td>
                                                <td class="sort-nisn">{{ $student->nisn }}</td>
                                                <td class="sort-kelas">{{ $student->kelas }}</td>
                                                <td class="sort-tanggal">
                                                    {{ $student->created_at->translatedFormat('F d, Y') }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn dropdown-toggle align-text-top"
                                                            data-bs-toggle="dropdown">
                                                            Aksi
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a href="{{ route('induk.siswa.show', $student->uuid) }}"
                                                                class="dropdown-item">
                                                                Lihat Detail
                                                            </a>
                                                            <a href="#" class="dropdown-item">Edit</a>
                                                            <form action="#" method="POST" style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="dropdown-item text-danger">Hapus</button>
                                                            </form>
                                                        </div>

                                                    </div>
                                                </td>
                                            </tr>
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


    <!-- Modal Import Siswa -->
    <div class="modal fade" id="importSiswaModal" tabindex="-1" aria-labelledby="importSiswaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('induk.import-siswa') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="importSiswaModalLabel">Import Data Siswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="file">Pilih file Excel (.xlsx)</label>
                            <input type="file" name="file" class="form-control" required>
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
                        "data-sort": "sort-kelas",
                        name: "Kelas"
                    },
                    {
                        "data-sort": "sort-tanggal",
                        name: "Tanggal Dibuat"
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






@endsection
