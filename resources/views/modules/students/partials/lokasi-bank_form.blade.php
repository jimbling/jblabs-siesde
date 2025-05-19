<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-purple-lt">
                <h3 class="card-title">Lokasi</h3>
            </div>
            <div class="card-body">
                <div class="mb-3 row">
                    <label class="col-md-4 col-form-label">Jarak Rumah ke Sekolah (km)</label>
                    <div class="col-md-8">
                        <input type="number" step="0.01" name="jarak_rumah_km" class="form-control"
                            value="{{ old('jarak_rumah_km', $student->jarak_rumah_km) }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-4 col-form-label">Lintang (Latitude)</label>
                    <div class="col-md-8">
                        <input type="text" name="lintang" class="form-control"
                            value="{{ old('lintang', $student->lintang) }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-4 col-form-label">Bujur (Longitude)</label>
                    <div class="col-md-8">
                        <input type="text" name="bujur" class="form-control"
                            value="{{ old('bujur', $student->bujur) }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-purple-lt">
                <h3 class="card-title">Informasi Bank</h3>
            </div>
            <div class="card-body">
                <div class="mb-3 row">
                    <label class="col-md-4 col-form-label">Bank</label>
                    <div class="col-md-8">
                        <input type="text" name="bank" class="form-control"
                            value="{{ old('bank', $student->bank) }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-4 col-form-label">No Rekening</label>
                    <div class="col-md-8">
                        <input type="text" name="nomor_rekening" class="form-control"
                            value="{{ old('nomor_rekening', $student->nomor_rekening) }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-4 col-form-label">Atas Nama</label>
                    <div class="col-md-8">
                        <input type="text" name="rekening_atas_nama" class="form-control"
                            value="{{ old('rekening_atas_nama', $student->rekening_atas_nama) }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
