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
                                    <h3 class="card-title mb-0">Pengguna</h3>
                                    <p class="text-secondary m-0">Jumlah Pengguna Terdaftar : {{ $totalUsers }}</p>
                                    <!-- Menampilkan jumlah pengguna -->
                                </div>
                                <div class="col-md-auto col-sm-12">
                                    <div class="ms-auto d-flex flex-wrap btn-list">
                                        <div class="input-group input-group-flat w-auto">
                                            <span class="input-group-text">
                                                <!-- Download SVG icon from http://tabler.io/icons/icon/search -->
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-1">
                                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                                    <path d="M21 21l-6 -6" />
                                                </svg>
                                            </span>
                                            <input id="advanced-table-search" type="text" class="form-control"
                                                autocomplete="off" />
                                            <span class="input-group-text">
                                                <kbd>ctrl + K</kbd>
                                            </span>
                                        </div>


                                        <button type="button" class="btn btn-outline-danger"
                                            id="btn-konfirmasi-hapus-akun">
                                            Hapus Akun
                                        </button>

                                        <a href="{{ route('pengaturan.akses.edit-permission') }}"
                                            class="btn btn-outline-primary">
                                            Atur Hak Akses
                                        </a>



                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="advanced-table">
                            <div class="table-responsive">
                                <table class="table table-vcenter table-selectable datatables">
                                    <thead>
                                        <tr>
                                            <th class="w-1"></th>
                                            <th>
                                                <button class="table-sort d-flex justify-content-between"
                                                    data-sort="sort-nama">Nama</button>
                                            </th>
                                            <th>
                                                <button class="table-sort d-flex justify-content-between"
                                                    data-sort="sort-email">Email</button>
                                            </th>
                                            <th>
                                                <button class="table-sort d-flex justify-content-between"
                                                    data-sort="sort-peran">Peran</button>
                                            </th>
                                            <th>
                                                <button class="table-sort d-flex justify-content-between"
                                                    data-sort="sort-tanggal">Tanggal dibuat</button>
                                            </th>
                                            <th>
                                                <button class="table-sort d-flex justify-content-between">Aksi</button>
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody class="table-tbody">
                                        @foreach ($users as $u)
                                            <tr @if ($u->hasRole('super-admin')) class="bg-super-admin" @endif>
                                                <td>
                                                    <label
                                                        class="d-block {{ $u->hasRole('super-admin') ? 'cursor-not-allowed' : '' }}"
                                                        data-bs-toggle="tooltip"
                                                        title="{{ $u->hasRole('super-admin') ? 'Super Admin tidak dapat dihapus' : '' }}">
                                                        <input
                                                            class="form-check-input m-0 align-middle table-selectable-check"
                                                            type="checkbox" aria-label="Select user"
                                                            value="{{ $u->id }}"
                                                            {{ $u->hasRole('super-admin') ? 'disabled' : '' }} />
                                                    </label>
                                                </td>

                                                <td class="sort-nama">
                                                    <span class="avatar avatar-xs me-2"
                                                        style="background-image: url({{ $u->avatar ? asset('storage/' . $u->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($u->name) . '&background=random' }})">
                                                    </span>
                                                    {{ $u->name }}
                                                </td>
                                                <td class="sort-email">{{ $u->email }}</td>
                                                <td class="sort-peran">{{ implode(', ', $u->getRoleNames()->toArray()) }}
                                                </td>
                                                <td class="sort-tanggal">{{ $u->created_at->translatedFormat('F d, Y') }}
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn dropdown-toggle align-text-top"
                                                            data-bs-toggle="dropdown">
                                                            Aksi
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            @if (!$u->hasRole('super-admin'))
                                                                <a href="javascript:void(0)"
                                                                    class="dropdown-item btn-ubah-peran"
                                                                    data-id="{{ $u->id }}"
                                                                    data-role="{{ $u->getRoleNames()->first() ?? '' }}"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#modal-ubah-peran">
                                                                    Ubah Peran
                                                                </a>
                                                            @endif

                                                            <button type="button"
                                                                class="dropdown-item text-danger btn-reset-password"
                                                                data-bs-toggle="modal" data-bs-target="#resetPasswordModal"
                                                                data-action="{{ route('pengaturan.akses.reset-password', $u->id) }}">
                                                                Reset Password
                                                            </button>
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
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                            <!-- Download SVG icon from http://tabler.io/icons/icon/chevron-left -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-1">
                                                <path d="M15 6l-6 6l6 6" />
                                            </svg>
                                            prev
                                        </a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item active"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                                    <li class="page-item"><a class="page-link" href="#">5</a></li>
                                    <li class="page-item"><a class="page-link" href="#">6</a></li>
                                    <li class="page-item"><a class="page-link" href="#">7</a></li>
                                    <li class="page-item"><a class="page-link" href="#">8</a></li>
                                    <li class="page-item"><a class="page-link" href="#">9</a></li>
                                    <li class="page-item"><a class="page-link" href="#">10</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">
                                            next
                                            <!-- Download SVG icon from http://tabler.io/icons/icon/chevron-right -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-1">
                                                <path d="M9 6l6 6l-6 6" />
                                            </svg>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal Ubah Peran -->

    <div class="modal modal-blur fade" id="modal-ubah-peran" tabindex="-1" aria-labelledby="logoutModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <form method="POST" action="{{ route('pengaturan.akses.update-role') }}">
                @csrf
                <input type="hidden" name="user_id" id="modal-user-id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ubah Peran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Pilih Peran</label>
                            <select class="form-select" name="role" id="modal-role-select">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary ms-auto">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <!-- Modal Konfirmasi Reset Password -->
    <x-modal.konfirmasi id="resetPasswordModal" title="Apakah Anda yakin?"
        body="Apakah Anda benar-benar ingin mereset password untuk pengguna ini? Proses ini tidak dapat dibatalkan."
        btnLabel="Reset Password" btnColor="danger" formAction="{{ route('pengaturan.akses.reset-password', $u->id) }}"
        method="POST">
        <div class="mt-3">
            <strong>Password Default:</strong>
            <p><code>defaultpassword</code></p>
            <small class="text-muted">
                Setelah reset, pengguna akan menggunakan password ini untuk login pertama kali.
            </small>
        </div>
    </x-modal.konfirmasi>

    <!-- Modal Konfirmasi Hapus Akun -->
    <x-modal.konfirmasi id="modalKonfirmasiHapusAkun" title="Hapus Akun?"
        body="Apakah Anda yakin ingin menghapus akun-akun ini?" btnLabel="Hapus" btnColor="danger"
        formAction="{{ route('pengaturan.akses.hapus-akun') }}" method="DELETE">
        <div id="user-ids-field-container"></div>
    </x-modal.konfirmasi>

    <!-- Modal Peringatan Tidak Ada Data Terpilih -->
    <x-modal.peringatan id="modalTidakAdaDataDipilih" title="Tidak ada data terpilih"
        message="Silakan pilih minimal satu akun sebelum menghapus." icon="warning" statusColor="bg-warning"
        buttonColor="btn-warning" />


    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modal = document.getElementById('resetPasswordModal');
                modal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const action = button.getAttribute('data-action');

                    const form = modal.querySelector('form');
                    form.setAttribute('action', action);
                });
            });
        </script>

        <script>
            let list; // buat variabel list di luar supaya bisa diakses global

            document.addEventListener("DOMContentLoaded", function() {
                // Inisialisasi List.js
                const advancedTable = {
                    headers: [{
                            "data-sort": "sort-nama",
                            name: "Nama"
                        },
                        {
                            "data-sort": "sort-email",
                            name: "Email"
                        },
                        {
                            "data-sort": "sort-peran",
                            name: "Peran"
                        },
                        {
                            "data-sort": "sort-tanggal",
                            name: "Tanggal dibuat"
                        },

                    ],
                };

                // Inisialisasi list
                list = new List("advanced-table", {
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
                    valueNames: advancedTable.headers.map((header) => header["data-sort"]),
                });

                const searchInput = document.querySelector("#advanced-table-search");
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
                    list.update(); // untuk memastikan List.js menyesuaikan pagination
                }

                // Update tampilan dropdown count
                document.getElementById('page-count').textContent = newPageCount;
            }
        </script>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.btn-ubah-peran').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        const userId = this.dataset.id;
                        const role = this.dataset.role;

                        document.querySelector('#modal-user-id').value = userId;
                        document.querySelector('#modal-role-select').value = role;
                    });
                });
            });
        </script>


        <script>
            document.getElementById('btn-konfirmasi-hapus-akun').addEventListener('click', function() {
                const checked = document.querySelectorAll('.table-selectable-check:checked');
                const ids = Array.from(checked).map(el => el.value);
                const container = document.getElementById('user-ids-field-container');

                container.innerHTML = '';

                if (ids.length === 0) {
                    const peringatanModal = new bootstrap.Modal(document.getElementById('modalTidakAdaDataDipilih'));
                    peringatanModal.show();
                } else {
                    ids.forEach(id => {
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'user_ids[]';
                        hiddenInput.value = id;
                        container.appendChild(hiddenInput);
                    });

                    const hapusModal = new bootstrap.Modal(document.getElementById('modalKonfirmasiHapusAkun'));
                    hapusModal.show();
                }
            });
        </script>
    @endpush














@endsection
