<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-orange-lt">
                <h3 class="card-title">Program Bantuan</h3>
            </div>
            <div class="card-body">
                <div class="mb-3 row">
                    <label class="col-md-4 col-form-label">Penerima KPS</label>
                    <div class="col-md-8">
                        <select name="penerima_kps" class="form-select">
                            <option value="1"
                                {{ old('penerima_kps', $student->penerima_kps) == 1 ? 'selected' : '' }}>Ya</option>
                            <option value="0"
                                {{ old('penerima_kps', $student->penerima_kps) == 0 ? 'selected' : '' }}>Tidak
                            </option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-4 col-form-label">No KPS</label>
                    <div class="col-md-8">
                        <input type="text" name="no_kps" class="form-control"
                            value="{{ old('no_kps', $student->no_kps) }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-4 col-form-label">Penerima KIP</label>
                    <div class="col-md-8">
                        <select name="penerima_kip" class="form-select">
                            <option value="1"
                                {{ old('penerima_kip', $student->penerima_kip) == 1 ? 'selected' : '' }}>Ya</option>
                            <option value="0"
                                {{ old('penerima_kip', $student->penerima_kip) == 0 ? 'selected' : '' }}>Tidak
                            </option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-4 col-form-label">No KIP</label>
                    <div class="col-md-8">
                        <input type="text" name="nomor_kip" class="form-control"
                            value="{{ old('nomor_kip', $student->nomor_kip) }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-4 col-form-label">Nama di KIP</label>
                    <div class="col-md-8">
                        <input type="text" name="nama_di_kip" class="form-control"
                            value="{{ old('nama_di_kip', $student->nama_di_kip) }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-orange-lt">
                <h3 class="card-title">Bantuan Lainnya</h3>
            </div>
            <div class="card-body">
                <div class="mb-3 row">
                    <label class="col-md-4 col-form-label">No KKS</label>
                    <div class="col-md-8">
                        <input type="text" name="nomor_kks" class="form-control"
                            value="{{ old('nomor_kks', $student->nomor_kks) }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-4 col-form-label">Layak PIP</label>
                    <div class="col-md-8">
                        <select name="layak_pip" class="form-select">
                            <option value="1" {{ old('layak_pip', $student->layak_pip) == 1 ? 'selected' : '' }}>Ya
                            </option>
                            <option value="0" {{ old('layak_pip', $student->layak_pip) == 0 ? 'selected' : '' }}>
                                Tidak</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-md-4 col-form-label">Alasan Layak PIP</label>
                    <div class="col-md-8">
                        <select class="form-select" name="alasan_layak_pip">
                            <option value="">Pilih Alasan Layak PIP</option>
                            <option value="Daerah Konflik"
                                {{ old('alasan_layak_pip', $student->alasan_layak_pip) == 'Daerah Konflik' ? 'selected' : '' }}>
                                Daerah Konflik</option>
                            <option value="Dampak Bencana Alam"
                                {{ old('alasan_layak_pip', $student->alasan_layak_pip) == 'Dampak Bencana Alam' ? 'selected' : '' }}>
                                Dampak Bencana Alam</option>
                            <option value="Kelainan Fisik"
                                {{ old('alasan_layak_pip', $student->alasan_layak_pip) == 'Kelainan Fisik' ? 'selected' : '' }}>
                                Kelainan Fisik</option>
                            <option value="Keluarga terpidana / berada di LAPAS"
                                {{ old('alasan_layak_pip', $student->alasan_layak_pip) == 'Keluarga terpidana / berada di LAPAS' ? 'selected' : '' }}>
                                Keluarga terpidana / berada di LAPAS</option>
                            <option value="Pemegang PKH/KPS/KKS"
                                {{ old('alasan_layak_pip', $student->alasan_layak_pip) == 'Pemegang PKH/KPS/KKS' ? 'selected' : '' }}>
                                Pemegang PKH/KPS/KKS</option>
                            <option value="Pernah Drop Out"
                                {{ old('alasan_layak_pip', $student->alasan_layak_pip) == 'Pernah Drop Out' ? 'selected' : '' }}>
                                Pernah Drop Out</option>
                            <option value="Siswa Miskin/Rentan Miskin"
                                {{ old('alasan_layak_pip', $student->alasan_layak_pip) == 'Siswa Miskin/Rentan Miskin' ? 'selected' : '' }}>
                                Siswa Miskin/Rentan Miskin</option>
                            <option value="Yatim Piatu/Panti Asuhan/Panti Sosial"
                                {{ old('alasan_layak_pip', $student->alasan_layak_pip) == 'Yatim Piatu/Panti Asuhan/Panti Sosial' ? 'selected' : '' }}>
                                Yatim Piatu/Panti Asuhan/Panti Sosial</option>
                        </select>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
