<!-- Modal Import Siswa -->
<div class="modal fade" id="tambahSiswaModal" tabindex="-1" aria-labelledby="tambahSiswaModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">

        <div class="modal-content">
            <div class="modal-header custom-header">
                <h5 class="modal-title" id="tambahSiswaModalLabel">Tambah Data Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <!-- Form Import Siswa -->
                <form id="form-siswa" action="{{ route('induk.siswa.store') }}" method="POST"
                    enctype="multipart/form-data" novalidate>
                    @csrf

                    <div class="card-body">
                        <!-- Identitas Pribadi -->
                        <div class="card mb-4">
                            <div class="card-header card-header-custom d-flex justify-content-between align-items-center bg-outline-success"
                                data-bs-toggle="collapse" href="#identitasPribadi" style="cursor: pointer;">
                                <h5 class="mb-0">Identitas Pribadi</h5>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-down collapse-icon">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M6 9l6 6l6 -6" />
                                </svg>
                            </div>

                            <div class="collapse show" id="identitasPribadi">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label required">NIPD</label>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" name="nipd" id="nipd"
                                                placeholder="Nomor Induk Peserta Didik" required>
                                            <div class="invalid-feedback">NIPD wajib diisi.</div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label required">NISN</label>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" name="nisn"
                                                placeholder="Nomor Induk Siswa Nasional" required>
                                            <div class="invalid-feedback">NISN wajib diisi.</div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label required">Nama Lengkap</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="nama"
                                                placeholder="Nama lengkap sesuai akta" required>
                                            <div class="invalid-feedback">Nama Peserta Didik wajib diisi.</div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Nama Panggilan</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="nama_panggilan"
                                                placeholder="Nama panggilan sehari-hari">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label required">Jenis Kelamin</label>
                                        <div class="col-md-9">
                                            <select class="form-select" name="jk" required>
                                                <option value="">Pilih Jenis Kelamin</option>
                                                <option value="L">Laki-laki</option>
                                                <option value="P">Perempuan</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label required">Tanggal Lahir</label>
                                        <div class="col-md-9">
                                            <input type="text" id="tanggal_lahir_display" class="form-control"
                                                placeholder="Pilih tanggal..." required>
                                            <div class="invalid-feedback">
                                                Tanggal lahir wajib diisi.
                                            </div>

                                            <input type="hidden" id="tanggal_lahir" name="tanggal_lahir" required>

                                        </div>
                                    </div>


                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label required">Tempat Lahir</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="tempat_lahir"
                                                placeholder="Kota/kabupaten lahir" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">No. Registrasi Akta</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="no_registrasi_akta"
                                                placeholder="Nomor akta kelahiran">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label required">NIK</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="nik"
                                                placeholder="Nomor Induk Kependudukan" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label required">Agama</label>
                                        <div class="col-md-9">
                                            <select class="form-select" name="agama_id" required>
                                                @foreach ($agamaData as $agama)
                                                    <option value="{{ $agama->id }}">{{ $agama->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label required">Kewarganegaraan</label>
                                        <div class="col-md-9">
                                            <select class="form-select" name="kewarganegaraan" required>
                                                <option value="WNI">WNI</option>
                                                <option value="WNA">WNA</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label required">No. KK</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="no_kk"
                                                placeholder="Nomor Kartu Keluarga" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Anak Ke-</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="anak_ke"
                                                    placeholder="Anak keberapa">
                                                <span class="input-group-text">dari</span>
                                                <input type="number" class="form-control"
                                                    name="jumlah_saudara_kandung" placeholder="Jumlah saudara">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Saudara Tiri</label>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" name="saudara_tiri"
                                                placeholder="Saudara Tiri">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Saudara Angkat</label>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" name="saudara_angkat"
                                                placeholder="Saudara Angkat">
                                        </div>
                                    </div>


                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Status Anak</label>
                                        <div class="col-md-9">
                                            <select class="form-select" name="status_anak">
                                                <option value="Kandung">Kandung</option>
                                                <option value="Tiri">Tiri</option>
                                                <option value="Angkat">Angkat</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Bahasa Sehari-hari</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="bahasa_keseharian"
                                                placeholder="Bahasa yang digunakan">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Kebutuhan Khusus</label>
                                        <div class="col-md-9">
                                            <select id="select-kebutuhan-khusus" class="form-select"
                                                name="kebutuhan_khusus" data-toggle="select">
                                                @foreach ($kebutuhanKhususData as $item)
                                                    <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>





                                </div>
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="card mb-4">
                            <div class="card-header card-header-custom d-flex justify-content-between align-items-center"
                                data-bs-toggle="collapse" href="#alamat" style="cursor: pointer;">
                                <h5 class="mb-0">Alamat</h5>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-down collapse-icon">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M6 9l6 6l6 -6" />
                                </svg>
                            </div>
                            <div class="collapse show" id="alamat">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label required">Alamat Jalan</label>
                                        <div class="col-md-9">
                                            <textarea class="form-control" name="alamat" rows="2" placeholder="Jalan, nomor rumah, blok/komplek"
                                                required></textarea>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">RT / RW</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" name="rt"
                                                placeholder="RT, misal: 001">
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="rw"
                                                placeholder="RW, misal: 002">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Dusun</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="dusun"
                                                placeholder="Nama dusun / lingkungan">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label required">Provinsi</label>
                                        <div class="col-md-9">
                                            <select class="form-select" name="provinsi" id="provinsi"
                                                required></select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label required">Kabupaten / Kota</label>
                                        <div class="col-md-9">
                                            <select class="form-select" name="kabupaten" id="kabupaten"
                                                required></select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label required">Kecamatan</label>
                                        <div class="col-md-9">
                                            <select class="form-select" name="kecamatan" id="kecamatan"
                                                required></select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label required">Kelurahan / Desa</label>
                                        <div class="col-md-9">
                                            <select class="form-select" name="kelurahan" id="kelurahan"
                                                required></select>
                                        </div>
                                    </div>



                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Kode Pos</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="kode_pos"
                                                placeholder="Kode pos wilayah">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Jarak ke Sekolah (km)</label>
                                        <div class="col-md-9">
                                            <input type="number" step="0.1" class="form-control"
                                                name="jarak_rumah_km" placeholder="Dalam kilometer">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Alat Transportasi</label>
                                        <div class="col-md-9">
                                            <select class="form-select" name="alat_transportasi_id">
                                                @foreach ($alatTransportasiData as $transport)
                                                    <option value="{{ $transport->id }}">{{ $transport->nama }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Jenis Tinggal</label>
                                        <div class="col-md-9">
                                            <select class="form-select" name="jenis_tinggal_id">
                                                @foreach ($jenisTinggalData as $tinggal)
                                                    <option value="{{ $tinggal->id }}">{{ $tinggal->nama }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Koordinat (Lintang)</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="lintang"
                                                placeholder="Contoh: -7.819759 (Lintang Selatan)">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Koordinat (Bujur)</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="bujur"
                                                placeholder="Contoh: 110.133455 (Bujur Timur)">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Kontak -->
                        <div class="card mb-4">
                            <div class="card-header card-header-custom d-flex justify-content-between align-items-center"
                                data-bs-toggle="collapse" href="#kontak" style="cursor: pointer;">
                                <h5 class="mb-0">Kontak</h5>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-down collapse-icon">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M6 9l6 6l6 -6" />
                                </svg>
                            </div>
                            <div class="collapse show" id="kontak">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Nomor Telepon</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="telepon"
                                                placeholder="Nomor telepon rumah">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label required">Nomor HP</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="hp"
                                                placeholder="Nomor handphone aktif" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Email</label>
                                        <div class="col-md-9">
                                            <input type="email" class="form-control" name="email"
                                                placeholder="Alamat email aktif">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Orang Tua -->

                        <div class="card mb-4">
                            <div class="card-header card-header-custom d-flex justify-content-between align-items-center"
                                data-bs-toggle="collapse" href="#orangTua" style="cursor: pointer;">
                                <h5 class="mb-0">Data Orang Tua/Wali</h5>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-down collapse-icon">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M6 9l6 6l6 -6" />
                                </svg>
                            </div>
                            <div class="collapse show" id="orangTua">
                                <div class="card-body">
                                    <!-- Ayah -->
                                    <div class="parent-form-section form-ayah" data-title="Data Ayah">
                                        <div class="form-header">
                                            <h6 class="mb-0 text-primary"><i
                                                    class="bi bi-gender-male me-2"></i>Informasi Ayah</h6>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label">Nama Ayah</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="ayah_nama"
                                                    placeholder="Nama Ayah" />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label">Tahun Lahir</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="ayah_tahun_lahir"
                                                    placeholder="Tahun Lahir" />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label required">Kewarganegaraan</label>
                                            <div class="col-md-9">
                                                <select class="form-select" name="ayah_kewarganegaraan" required>
                                                    <option value="WNI">WNI</option>
                                                    <option value="WNA">WNA</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label">Pendidikan</label>
                                            <div class="col-md-9">
                                                <select class="form-select" name="ayah_pendidikan_id">
                                                    <option value="">Pilih Pendidikan</option>
                                                    @foreach ($pendidikanData as $pendidikan)
                                                        <option value="{{ $pendidikan->id }}">
                                                            {{ $pendidikan->jenjang }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label">Pekerjaan</label>
                                            <div class="col-md-9">
                                                <select class="form-select" name="ayah_pekerjaan_id">
                                                    <option value="">Pilih Pekerjaan</option>
                                                    @foreach ($pekerjaanData as $pekerjaan)
                                                        <option value="{{ $pekerjaan->id }}">
                                                            {{ $pekerjaan->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label">Penghasilan</label>
                                            <div class="col-md-9">
                                                <select class="form-select" name="ayah_penghasilan_id">
                                                    <option value="">Pilih Penghasilan</option>
                                                    @foreach ($penghasilanData as $penghasilan)
                                                        <option value="{{ $penghasilan->id }}">
                                                            {{ $penghasilan->rentang }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label">NIK</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="ayah_nik"
                                                    placeholder="Nomor Induk Kependudukan" />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Ibu -->
                                    <div class="parent-form-section form-ibu" data-title="Data Ibu">
                                        <div class="form-header">
                                            <h6 class="mb-0 text-pink"><i
                                                    class="bi bi-gender-female me-2"></i>Informasi Ibu</h6>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label">Nama Ibu</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="ibu_nama"
                                                    placeholder="Nama Ibu" />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label">Tahun Lahir</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="ibu_tahun_lahir"
                                                    placeholder="Tahun Lahir" />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label required">Kewarganegaraan</label>
                                            <div class="col-md-9">
                                                <select class="form-select" name="ibu_kewarganegaraan" required>
                                                    <option value="WNI">WNI</option>
                                                    <option value="WNA">WNA</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label">Pendidikan</label>
                                            <div class="col-md-9">
                                                <select class="form-select" name="ibu_pendidikan_id">
                                                    <option value="">Pilih Pendidikan</option>
                                                    @foreach ($pendidikanData as $pendidikan)
                                                        <option value="{{ $pendidikan->id }}">
                                                            {{ $pendidikan->jenjang }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label">Pekerjaan</label>
                                            <div class="col-md-9">
                                                <select class="form-select" name="ibu_pekerjaan_id">
                                                    <option value="">Pilih Pekerjaan</option>
                                                    @foreach ($pekerjaanData as $pekerjaan)
                                                        <option value="{{ $pekerjaan->id }}">
                                                            {{ $pekerjaan->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label">Penghasilan</label>
                                            <div class="col-md-9">
                                                <select class="form-select" name="ibu_penghasilan_id">
                                                    <option value="">Pilih Penghasilan</option>
                                                    @foreach ($penghasilanData as $penghasilan)
                                                        <option value="{{ $penghasilan->id }}">
                                                            {{ $penghasilan->rentang }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-md-3 col-form-label">NIK</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="ibu_nik"
                                                    placeholder="Nomor Induk Kependudukan" />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Dynamic Guardian Section -->
                                    <div id="guardian-sections"></div>

                                    <!-- Add Guardian Button -->
                                    <div class="d-flex justify-content-end mt-4">
                                        <button id="add-guardian-btn" type="button"
                                            class="btn btn-outline-success btn-add-guardian"
                                            onclick="addGuardianForm()">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-user-plus">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                <path d="M16 19h6" />
                                                <path d="M19 16v6" />
                                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
                                            </svg>Tambah Wali
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>




                        <!-- Data Lainnya -->
                        <div class="card mb-4">
                            <div class="card-header card-header-custom d-flex justify-content-between align-items-center"
                                data-bs-toggle="collapse" href="#dataLainnya" style="cursor: pointer;">
                                <h5 class="mb-0">Data Kesejahteraan</h5>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-down collapse-icon">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M6 9l6 6l6 -6" />
                                </svg>
                            </div>
                            <div class="collapse show" id="dataLainnya">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Penerima KPS</label>
                                        <div class="col-md-9">
                                            <select class="form-select" name="penerima_kps" id="penerima-kps">
                                                <option value="0">Tidak</option>
                                                <option value="1">Ya</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3" id="field-no-kps">
                                        <label class="col-md-3 col-form-label">Nomor KPS</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="no_kps"
                                                placeholder="Jika penerima KPS">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Penerima KIP</label>
                                        <div class="col-md-9">
                                            <select class="form-select" name="penerima_kip" id="penerima-kip">
                                                <option value="0">Tidak</option>
                                                <option value="1">Ya</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3" id="field-no-kip">
                                        <label class="col-md-3 col-form-label">Nomor KIP</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="nomor_kip"
                                                placeholder="Jika penerima KIP">
                                        </div>
                                    </div>

                                    <div class="row mb-3" id="field-nama-di-kip">
                                        <label class="col-md-3 col-form-label">Nama di KIP</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="nama_di_kip"
                                                placeholder="Nama sesuai KIP">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Nomor KKS</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="nomor_kks"
                                                placeholder="Nomor Kartu Keluarga Sejahtera">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Layak PIP</label>
                                        <div class="col-md-9">
                                            <select class="form-select" name="layak_pip" id="layak_pip_select">
                                                <option value="0">Tidak</option>
                                                <option value="1">Ya</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3 d-none" id="alasan_layak_pip_section">
                                        <label class="col-md-3 col-form-label">Alasan Layak PIP</label>
                                        <div class="col-md-9">
                                            <select class="form-select" name="alasan_layak_pip">
                                                <option value="">Pilih Alasan Layak PIP</option>
                                                <option value="Daerah Konflik">Daerah Konflik</option>
                                                <option value="Dampak Bencana Alam">Dampak Bencana Alam</option>
                                                <option value="Kelainan Fisik">Kelainan Fisik</option>
                                                <option value="Keluarga terpidana / berada di LAPAS">Keluarga terpidana
                                                    / berada di LAPAS</option>
                                                <option value="Pemegang PKH/KPS/KKS">Pemegang PKH/KPS/KKS</option>
                                                <option value="Pernah Drop Out">Pernah Drop Out</option>
                                                <option value="Siswa Miskin/Rentan Miskin">Siswa Miskin/Rentan Miskin
                                                </option>
                                                <option value="Yatim Piatu/Panti Asuhan/Panti Sosial">Yatim Piatu/Panti
                                                    Asuhan/Panti Sosial</option>
                                            </select>
                                        </div>
                                    </div>







                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Bank</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="bank"
                                                placeholder="Nama bank">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Nomor Rekening</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="nomor_rekening"
                                                placeholder="Nomor rekening bank">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Atas Nama Rekening</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="rekening_atas_nama"
                                                placeholder="Nama pemilik rekening">
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>


                        <!-- Registrasi -->
                        <div class="card mb-4">
                            <div class="card-header card-header-custom d-flex justify-content-between align-items-center"
                                data-bs-toggle="collapse" href="#registrasi" style="cursor: pointer;">
                                <h5 class="mb-0">Data Registrasi</h5>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-down collapse-icon">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M6 9l6 6l6 -6" />
                                </svg>
                            </div>
                            <div class="collapse show" id="registrasi">
                                <div class="card-body">
                                    <!-- Dropdown Jenis Pendaftaran -->
                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">Jenis Pendaftaran</label>
                                        <div class="col-md-9">
                                            <select class="form-select" name="jenis_pendaftar" id="jenis-pendaftar">
                                                <option value="Siswa Baru">Siswa Baru</option>
                                                <option value="Pindahan">Pindahan</option>
                                                <option value="Kembali Bersekolah">Kembali Bersekolah</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Container untuk field dinamis -->
                                    <div id="dynamic-fields" class="dynamic-fields"></div>

                                    <!-- Field umum yang selalu ada -->
                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label">SKHUN</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="skhun"
                                                placeholder="Nomor SKHUN">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-end">
                        <button type="reset" class="btn btn-outline-secondary me-2">
                            <i class="ti ti-reload me-1"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i> Simpan Data
                        </button>
                    </div>
                </form>

                <!-- JavaScript untuk toggle icon -->

            </div>
        </div>
    </div>
</div>
