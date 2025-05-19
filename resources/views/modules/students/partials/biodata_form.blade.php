<form action="{{ route('induk.siswa.update.biodata', $student) }}" method="POST">

    @csrf
    @method('PUT')

    <div class="row">


        {{-- Kolom kiri --}}
        <div class="col-md-6">
            {{-- Identitas Pribadi --}}
            <div class="card mb-4">
                <div class="card-header bg-primary-lt">
                    <h3 class="card-title">Identitas Pribadi</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">NIK</label>
                        <input type="text" name="nik" class="form-control"
                            value="{{ old('nik', $student->nik) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control"
                            value="{{ old('tempat_lahir', $student->tempat_lahir) }}">
                    </div>
                    <div class="row mb-3">
                        <label class="col-form-label required">Tanggal Lahir</label>

                        <input type="text" id="tanggal_lahir_display"
                            class="form-control @error('tanggal_lahir') is-invalid @enderror"
                            placeholder="Pilih tanggal..."
                            value="{{ old('tanggal_lahir', \Carbon\Carbon::parse($student->tanggal_lahir)->format('d F Y')) }}"
                            required>
                        <div class="invalid-feedback">
                            Tanggal lahir wajib diisi.
                        </div>

                        <input type="hidden" id="tanggal_lahir" name="tanggal_lahir"
                            value="{{ old('tanggal_lahir', $student->tanggal_lahir) }}" required>

                    </div>

                    <div class="mb-3">
                        <label class="form-label">Agama</label>
                        <select name="agama_id" class="form-select">
                            @foreach ($agamaList as $id => $nama)
                                <option value="{{ $id }}" {{ $student->agama_id == $id ? 'selected' : '' }}>
                                    {{ $nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Kontak --}}
            <div class="card mb-4">
                <div class="card-header bg-primary-lt">
                    <h3 class="card-title">Kontak</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Telepon</label>
                        <input type="text" name="telepon" class="form-control"
                            value="{{ old('telepon', $student->telepon) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">HP</label>
                        <input type="text" name="hp" class="form-control" value="{{ old('hp', $student->hp) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control"
                            value="{{ old('email', $student->email) }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom kanan --}}
        <div class="col-md-6">
            {{-- Alamat --}}
            <div class="card mb-4">
                <div class="card-header bg-primary-lt">
                    <h3 class="card-title">Alamat</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Alamat Lengkap</label>
                        <input type="text" name="alamat" class="form-control"
                            value="{{ old('alamat', $student->alamat) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">RT</label>
                        <input type="text" name="rt" class="form-control"
                            value="{{ old('rt', $student->rt) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">RW</label>
                        <input type="text" name="rw" class="form-control"
                            value="{{ old('rw', $student->rw) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dusun</label>
                        <input type="text" name="dusun" class="form-control"
                            value="{{ old('dusun', $student->dusun) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kelurahan</label>
                        <input type="text" name="kelurahan" class="form-control"
                            value="{{ old('kelurahan', $student->kelurahan) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kecamatan</label>
                        <input type="text" name="kecamatan" class="form-control"
                            value="{{ old('kecamatan', $student->kecamatan) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Tinggal</label>
                        <select name="jenis_tinggal_id" class="form-select">
                            @foreach ($jenisTinggalList as $id => $nama)
                                <option value="{{ $id }}"
                                    {{ $student->jenis_tinggal_id == $id ? 'selected' : '' }}>{{ $nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alat Transportasi</label>
                        <select name="alat_transportasi_id" class="form-select">
                            @foreach ($alatTransportasiList as $id => $nama)
                                <option value="{{ $id }}"
                                    {{ $student->alat_transportasi_id == $id ? 'selected' : '' }}>{{ $nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tombol Simpan dan Batal --}}
        <div class="d-flex  mb-3">
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ request()->url() }}" class="btn btn-secondary me-2">Batal</a>

        </div>
    </div>
</form>
