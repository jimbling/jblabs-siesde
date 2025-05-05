@extends('layouts.tabler') <!-- Gunakan layout utama Tabler -->

@section('title', $title ?? 'Dashboard')

@section('page-title', 'Welcome to the Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="card card-link card-link-pop mb-4">
            <div class="card-stamp ">
                <div class="card-stamp-icon bg-danger">
                    <!-- Download SVG icon from http://tabler.io/icons/icon/bell -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-1">
                        <path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                        <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                    </svg>
                </div>
            </div>
            <div class="card-body">
                <h3 class="card-title">Informasi Pengaturan Rombel Siswa:</h3>
                <p class="text-secondary">
                    Halaman ini digunakan untuk mengatur rombel siswa, yaitu memilih siswa yang akan dipindahkan ke rombel
                    tertentu. Anda dapat memilih data siswa yang ingin dipindahkan (siswa awal) serta menentukan tujuan
                    rombel yang sesuai. Proses ini memudahkan pengelolaan rombel siswa untuk memastikan setiap siswa berada
                    pada kelas yang tepat sesuai dengan tingkat dan tahun pelajaran yang berlaku.
                </p>
            </div>
        </div>



        <div class="row">
            <!-- Card Kiri -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <!-- Tombol Kiri -->
                        <button type="button" class="btn btn-warning" id="btn-alumni">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-school">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M22 9l-10 -4l-10 4l10 4l10 -4v6" />
                                <path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4" />
                            </svg>
                            Atur Sebagai Alumni
                        </button>

                        <!-- Tombol Kanan -->
                        <button type="button" class="btn btn-success d-flex align-items-center gap-1" id="btn-pindah">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-bar-right">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M20 12l-10 0" />
                                <path d="M20 12l-4 4" />
                                <path d="M20 12l-4 -4" />
                                <path d="M4 4l0 16" />
                            </svg>
                            Pindah ke Kelas Tujuan

                        </button>

                    </div>


                    <div class="card-body">
                        <div class="mb-3 d-flex align-items-center">
                            <label for="tingkat" class="me-3 mb-0" style="width: 250px;">Pilih Kelas Awal</label>
                            <select class="form-select" id="tingkat" name="tingkat">
                                <option value="">Belum diatur</option>
                                @foreach ($rombels->pluck('tingkat')->unique() as $tingkatOption)
                                    <option value="{{ $tingkatOption }}">{{ 'Kelas ' . $tingkatOption }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3 d-flex align-items-center">
                            <label for="tahun_pelajaran_id" class="me-3 mb-0" style="width: 250px;">Tahun Pelajaran</label>
                            <select class="form-select" id="tahun_pelajaran_id" name="tahun_pelajaran_id">
                                <option value="">-- Pilih Tahun Pelajaran --</option>
                                @foreach ($tahunPelajarans as $tahunPelajaran)
                                    <option value="{{ $tahunPelajaran->id }}">{{ $tahunPelajaran->tahun_ajaran }}</option>
                                @endforeach
                            </select>
                        </div>


                        {{-- Tombol Aksi --}}
                        <div class="mb-3 d-flex gap-2 ms-auto justify-content-end">


                            <div class="mb-3 d-flex gap-2 ms-auto justify-content-end">
                                <!-- Form Pindah -->
                                <form method="POST" action="{{ route('rombel.siswa.moveToNextClass') }}" id="form-pindah">
                                    @csrf
                                    <input type="hidden" name="siswa_terpilih" id="siswa_terpilih">
                                    <input type="hidden" name="tingkat_tujuan" id="tingkat_tujuan_input">
                                    <input type="hidden" name="tahun_pelajaran_tujuan" id="tahun_pelajaran_tujuan_input">
                                    <input type="hidden" name="semester_id" id="semester_id" value="">
                                    {{-- Tambahan untuk validasi di controller --}}
                                    <input type="hidden" name="tingkat_awal" id="tingkat_awal_input">
                                    <input type="hidden" name="tahun_pelajaran_awal" id="tahun_pelajaran_awal_input">
                                </form>



                            </div>
                        </div>

                        <div class="table-responsive mt-4">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            <label class="form-check mb-0">
                                                <input class="form-check-input" type="checkbox" id="select-all">
                                            </label>
                                        </th>
                                        <th>Nama</th>
                                        <th>NISN</th>
                                        <th>Rombel</th>
                                    </tr>
                                </thead>
                                <tbody id="siswa-table-body">
                                    <tr>
                                        <td colspan="4" class="text-muted text-center">Silakan pilih tingkat dan tahun
                                            pelajaran.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div>

            <!-- Card Kanan -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between ms-auto">
                        <button type="button" class="btn btn-danger d-flex align-items-center gap-1"
                            id="btn-hapus-siswa">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 7l16 0" />
                                <path d="M10 11l0 6" />
                                <path d="M14 11l0 6" />
                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                            </svg>
                            Hapus dari Kelas
                        </button>

                    </div>
                    <div class="card-body">
                        <!-- Form Select Tingkat Tujuan -->
                        <form method="POST" action="#">
                            @csrf
                            <div class="mb-3 d-flex align-items-center">
                                <label for="tingkat_tujuan" class="me-3 mb-0" style="width: 350px;">Pilih Kelas
                                    Tujuan</label>
                                <select class="form-select" name="tingkat_tujuan" id="tingkat_tujuan" required>
                                    <option value="">-- Pilih Kelas Tujuan --</option>
                                    @foreach ($rombels->pluck('tingkat')->unique() as $tingkatOption)
                                        <option value="{{ $tingkatOption }}"
                                            {{ $tingkatOption == old('tingkat_tujuan') ? 'selected' : '' }}>
                                            {{ $tingkatOption }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>



                            <!-- Form Select Tahun Pelajaran Tujuan dan Semester -->
                            <div class="mb-3 d-flex align-items-center">
                                <label for="semester_tujuan" class="me-3 mb-0" style="width: 350px;">Tahun Pelajaran &
                                    Semester Tujuan</label>
                                <select class="form-select" name="pilihan_semester_tujuan" id="tahun_pelajaran_tujuan"
                                    required>
                                    required>
                                    <option value="">-- Pilih Tahun Pelajaran dan Semester Tujuan --</option>
                                    @foreach ($tahunPelajarans as $tahun)
                                        @foreach ($tahun->semesters as $sem)
                                            <option value="{{ $tahun->id }}|{{ $sem->id }}"
                                                {{ $sem->id == old('semester_tujuan') ? 'selected' : '' }}>
                                                {{ $tahun->tahun_ajaran }} - {{ ucfirst($sem->semester) }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>




                        </form>


                        <!-- Tabel untuk menampilkan data siswa -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><input class="form-check-input" type="checkbox" id="check-all"></th>
                                    <th>Nama</th>
                                    <th>NISN</th>
                                    <th>Rombel</th>
                                </tr>
                            </thead>
                            <tbody id="students-tujuan-body">
                                <tr>
                                    <td colspan="4" class="text-muted text-center">Silakan pilih tingkat dan tahun
                                        pelajaran.</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>



        {{-- Modal Peringatan Tidak Ada Data --}}
        <x-modal.peringatan id="modalPeringatanTidakAdaData" title="Tidak Ada Data Dipilih"
            message="Silahkan pilih siswa yang ingin diproses" btnLabel="Tutup" btnColor="warning" formAction="#"
            method="GET" />

        <!-- Modal Konfirmasi -->
        <x-modal.konfirmasi-tindakan id="konfirmasiModal" title="Konfirmasi Pindah Kelas"
            confirmLabel="Pindah ke Kelas Tujuan" confirmColor="success" onConfirm="submitFormPindah()">
            <p>Apakah Anda yakin ingin memindahkan siswa-siswa yang dipilih ke kelas tujuan?</p>
            <p id="siswa-list-konfirmasi"></p>
        </x-modal.konfirmasi-tindakan>

        <x-modal.konfirmasi id="modalKonfirmasi" title="Konfirmasi Hapus"
            body="Yakin ingin menghapus siswa dari kelas ini?" btnLabel="Ya, Hapus" btnColor="danger" :formAction="route('rombel.siswa.hapus-rombel')"
            method="DELETE">
            {{-- ⬇️ Isi slot dengan input hidden dinamis --}}
            {{-- biarkan JavaScript mengisi ini saat tombol diklik --}}
        </x-modal.konfirmasi>





    </div>




    @push('scripts')
        {{-- Script Card Kiri --}}
        <script>
            let selectedTahunId = '';
            let selectedSemesterId = '';
            document.addEventListener('DOMContentLoaded', function() {
                const tahunSelect = document.getElementById('tahun_pelajaran_tujuan');
                const semesterInput = document.getElementById('semester_id');
                const tahunInput = document.getElementById('tahun_pelajaran_tujuan_input'); // Input hidden untuk tahun
                const tingkatSelect = document.getElementById('tingkat');
                const tahunSelect2 = document.getElementById('tahun_pelajaran_id');
                const tbody = document.getElementById('siswa-table-body');
                const selectAllCheckbox = document.getElementById('select-all');
                const form = document.getElementById('form-pindah');
                const siswaInput = document.getElementById('siswa_terpilih');
                const tingkatInput = document.getElementById('tingkat_tujuan_input');
                const btnPindah = document.getElementById('btn-pindah');
                const konfirmasiModal = new bootstrap.Modal(document.getElementById('konfirmasiModal'));
                const btnKonfirmasiPindah = document.getElementById('btn-konfirmasi-pindah');
                const siswaListKonfirmasi = document.getElementById('siswa-list-konfirmasi');

                // Menangani perubahan pada tahun pelajaran dan semester
                tahunSelect.addEventListener('change', function() {
                    const selectedValue = this.value;

                    if (selectedValue) {
                        const [tahunId, semesterId] = selectedValue.split('|');

                        // Set nilai ke hidden input
                        semesterInput.value = semesterId;
                        tahunInput.value = tahunId;

                        // JANGAN LUPA: Set juga ke variabel global
                        selectedTahunId = tahunId;
                        selectedSemesterId = semesterId;
                    } else {
                        semesterInput.value = '';
                        tahunInput.value = '';
                        selectedTahunId = '';
                        selectedSemesterId = '';
                    }
                });


                // Fungsi untuk fetch siswa
                function fetchStudents() {
                    const tingkat = tingkatSelect.value || ''; // Jika tidak ada tingkat, set ke string kosong
                    const tahun = tahunSelect2.value || ''; // Jika tidak ada tahun, set ke string kosong

                    let url = `/rombel/siswa/json?tingkat=${tingkat}&tahun_pelajaran_id=${tahun}`;

                    // Jika tingkat dan tahun kosong, cari siswa yang belum memiliki kelas
                    if (!tingkat && !tahun) {
                        url = `/rombel/siswa/json?tingkat=&tahun_pelajaran_id=`;
                    }

                    fetch(url)
                        .then(res => {
                            if (!res.ok) {
                                throw new Error('Gagal mengambil data');
                            }
                            return res.json();
                        })
                        .then(data => {
                            tbody.innerHTML = '';

                            if (!data.students || data.students.length === 0) {
                                tbody.innerHTML = `
                        <tr>
                            <td colspan="4" class="text-center text-warning">
                                Tidak ada siswa yang ditemukan.
                            </td>
                        </tr>`;
                                return;
                            }

                            data.students.forEach(siswa => {
                                const rombelNama = siswa.student_rombels && siswa.student_rombels.length >
                                    0 ?
                                    siswa.student_rombels[0].rombel?.tingkat : '-';
                                const row = `
                        <tr>
                            <td>
                                <input type="checkbox"
                                       class="form-check-input siswa-checkbox"
                                       data-id="${siswa.id}"
                                       data-uuid="${siswa.uuid}"
                                       data-nama="${siswa.nama}">
                            </td>
                            <td>${siswa.nama}</td>
                            <td>${siswa.nisn ?? '-'}</td>
                            <td>${rombelNama}</td>
                        </tr>
                    `;
                                tbody.insertAdjacentHTML('beforeend', row);
                            });

                            document.querySelectorAll('.siswa-checkbox').forEach(box => {
                                box.addEventListener('change', handleCheckboxChange);
                            });
                        })
                        .catch(err => {
                            console.error('Error:', err);
                            tbody.innerHTML = `
                    <tr>
                        <td colspan="4" class="text-center text-danger">
                            Terjadi kesalahan saat memuat data siswa.
                        </td>
                    </tr>`;
                        });
                }

                fetchStudents();

                tingkatSelect.addEventListener('change', fetchStudents);
                tahunSelect2.addEventListener('change', fetchStudents);

                selectAllCheckbox.addEventListener('change', function() {
                    const isChecked = selectAllCheckbox.checked;
                    document.querySelectorAll('.siswa-checkbox').forEach(checkbox => {
                        checkbox.checked = isChecked;
                    });

                    handleCheckboxChange();
                    updateSiswaTerpilih();
                });

                function handleCheckboxChange() {
                    const selectedCheckboxes = Array.from(document.querySelectorAll('.siswa-checkbox:checked'));
                    const selectedSiswa = selectedCheckboxes.map(cb => ({
                        id: cb.dataset.id,
                        uuid: cb.dataset.uuid,
                        nama: cb.dataset.nama
                    }));

                    siswaInput.value = JSON.stringify(selectedSiswa);
                }

                function updateSiswaTerpilih() {
                    const selectedCheckboxes = Array.from(document.querySelectorAll('.siswa-checkbox:checked'));
                    const siswaNames = selectedCheckboxes.map(cb => cb.dataset.nama).join(', ');
                    siswaListKonfirmasi.innerText = siswaNames;
                }

                btnPindah.addEventListener('click', function(e) {
                    e.preventDefault();

                    const selectedCheckboxes = Array.from(document.querySelectorAll('.siswa-checkbox:checked'));
                    const selectedSiswa = selectedCheckboxes.map(cb => ({
                        id: cb.dataset.id,
                        uuid: cb.dataset.uuid,
                        nama: cb.dataset.nama
                    }));

                    if (selectedSiswa.length === 0) {
                        const modalPeringatan = new bootstrap.Modal(document.getElementById(
                            'modalPeringatanTidakAdaData'));
                        modalPeringatan.show();
                        return;
                    }

                    // ✅ Set semua input hidden dengan nilai terbaru
                    tingkatInput.value = document.getElementById('tingkat_tujuan').value;
                    tahunInput.value = selectedTahunId;
                    semesterInput.value = selectedSemesterId;

                    document.getElementById('tingkat_awal_input').value = document.getElementById('tingkat')
                        .value;
                    document.getElementById('tahun_pelajaran_awal_input').value = document.getElementById(
                        'tahun_pelajaran_id').value;

                    konfirmasiModal.show();
                });

            });
        </script>

        <script>
            function submitFormPindah() {
                document.getElementById('form-pindah').submit();
            }
        </script>

        {{-- Script Card Kanan --}}
        <script>
            const tingkatTujuan = document.getElementById('tingkat_tujuan');
            const tahunTujuan = document.getElementById('tahun_pelajaran_tujuan');
            const tbody = document.getElementById('students-tujuan-body');

            function fetchStudents() {
                const tingkat = tingkatTujuan.value;
                const tahun = tahunTujuan.value;

                if (tingkat && tahun) {
                    fetch(`/rombel/siswa/json?tingkat=${tingkat}&tahun_pelajaran_id=${tahun}`)
                        .then(res => res.json())
                        .then(data => {
                            tbody.innerHTML = '';

                            if (!data.students.length) {
                                tbody.innerHTML =
                                    `<tr><td colspan="4" class="text-center text-warning">Tidak ada siswa di kelas ini.</td></tr>`;
                                return;
                            }

                            data.students.forEach(siswa => {
                                const rombelNama = siswa.student_rombels && siswa.student_rombels.length > 0 ?
                                    siswa.student_rombels[0].rombel?.tingkat :
                                    '-';

                                const row = `
                                    <tr>
                                        <td><input class="form-check-input student-checkbox" type="checkbox" value="${siswa.uuid}"></td>
                                        <td>${siswa.nama}</td>
                                        <td>${siswa.nisn ?? '-'}</td>
                                        <td>${rombelNama}</td>
                                    </tr>
                                `;
                                tbody.insertAdjacentHTML('beforeend', row);
                            });

                            setupCheckAll();
                        })
                        .catch(err => {
                            console.error('Gagal memuat data siswa:', err);
                            tbody.innerHTML =
                                `<tr><td colspan="4" class="text-danger text-center">Terjadi kesalahan saat mengambil data.</td></tr>`;
                        });
                }
            }

            tingkatTujuan.addEventListener('change', fetchStudents);
            tahunTujuan.addEventListener('change', fetchStudents);



            function setupCheckAll() {
                const checkAll = document.getElementById('check-all');
                const checkboxes = document.querySelectorAll('.student-checkbox');

                if (!checkAll) return;

                checkAll.addEventListener('change', function() {
                    checkboxes.forEach(cb => cb.checked = this.checked);
                });
            }

            document.getElementById('btn-hapus-siswa').addEventListener('click', function() {
                const checkboxes = document.querySelectorAll('.student-checkbox:checked');

                if (!checkboxes.length) {
                    const modalPeringatan = new bootstrap.Modal(document.getElementById('modalPeringatanTidakAdaData'));
                    modalPeringatan.show();
                    return;
                }



                const uuids = Array.from(checkboxes).map(cb => cb.value);

                // Ambil elemen form dalam modal
                const modalForm = document.querySelector('#modalKonfirmasi form');

                // Hapus input lama jika ada
                modalForm.querySelectorAll('input[name="siswa_uuids[]"]').forEach(el => el.remove());

                // Tambahkan input hidden baru untuk setiap UUID
                uuids.forEach(uuid => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'siswa_uuids[]';
                    input.value = uuid;
                    modalForm.appendChild(input);
                });

                // Tampilkan modal
                const modal = new bootstrap.Modal(document.getElementById('modalKonfirmasi'));
                modal.show();
            });
        </script>
        <script>
            document.querySelector('#modalKonfirmasi form').addEventListener('submit', function(e) {
                e.preventDefault(); // Cegah submit biasa

                const form = this;
                const formData = new FormData(form);
                const action = form.getAttribute('action');
                const method = form.getAttribute('method') || 'POST';

                fetch(action, {
                        method: method,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: data.message,
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });

                            // Tutup modal
                            const modal = bootstrap.Modal.getInstance(document.getElementById('modalKonfirmasi'));
                            modal.hide();

                            // Refresh data
                            fetchStudents();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: data.message || 'Terjadi kesalahan.',
                            });
                        }
                    })
                    .catch(() => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Terjadi kesalahan jaringan.',
                        });
                    });
            });
        </script>
    @endpush

@endsection
