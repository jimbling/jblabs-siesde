@php
    $ortuAyah = $student->orangTuas->firstWhere('tipe', 'ayah');
    $ortuIbu = $student->orangTuas->firstWhere('tipe', 'ibu');
@endphp

@foreach (['ayah' => $ortuAyah, 'ibu' => $ortuIbu] as $tipe => $ortu)
    <div class="card mb-4">

        <div class="card-header bg-{{ $tipe === 'ayah' ? 'blue' : 'pink' }}-lt">
            <strong class="text-capitalize">{{ $tipe }}</strong>
        </div>
        <div class="card-body">
            <input type="hidden" name="{{ $tipe }}[id]" value="{{ $ortu->id ?? '' }}">
            <div class="mb-3">
                <label class="form-label">Nama {{ $tipe }}</label>
                <input type="text" class="form-control" name="{{ $tipe }}[nama]"
                    value="{{ old($tipe . '.nama', $ortu->nama ?? '') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Tahun Lahir</label>
                <input type="text" class="form-control" name="{{ $tipe }}[tahun_lahir]"
                    value="{{ old($tipe . '.tahun_lahir', $ortu->tahun_lahir ?? '') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">NIK</label>
                <input type="text" class="form-control" name="{{ $tipe }}[nik]"
                    value="{{ old($tipe . '.nik', $ortu->nik ?? '') }}">
            </div>
            <!-- Kewarganegaraan -->
            <div class="mb-3">
                <label class="form-label">Kewarganegaraan</label>
                <select class="form-select" name="{{ $tipe }}[kewarganegaraan]">
                    <option value="WNI"
                        {{ old($tipe . '.kewarganegaraan', $ortu->kewarganegaraan ?? '') == 'WNI' ? 'selected' : '' }}>
                        WNI</option>
                    <option value="WNA"
                        {{ old($tipe . '.kewarganegaraan', $ortu->kewarganegaraan ?? '') == 'WNA' ? 'selected' : '' }}>
                        WNA</option>
                </select>
            </div>

            <!-- Pendidikan -->
            <div class="mb-3">
                <label class="form-label">Pendidikan</label>
                <select class="form-select" name="{{ $tipe }}[pendidikan_id]">
                    <option value="">Pilih Pendidikan</option>
                    @foreach ($pendidikanList as $id => $jenjang)
                        <option value="{{ $id }}"
                            {{ old($tipe . '.pendidikan_id', $ortu->pendidikan_id ?? '') == $id ? 'selected' : '' }}>
                            {{ $jenjang }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Pekerjaan -->
            <div class="mb-3">
                <label class="form-label">Pekerjaan</label>
                <select class="form-select" name="{{ $tipe }}[pekerjaan_id]">
                    <option value="">Pilih Pekerjaan</option>
                    @foreach ($pekerjaanList as $id => $nama)
                        <option value="{{ $id }}"
                            {{ old($tipe . '.pekerjaan_id', $ortu->pekerjaan_id ?? '') == $id ? 'selected' : '' }}>
                            {{ $nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Penghasilan -->
            <div class="mb-3">
                <label class="form-label">Penghasilan</label>
                <select class="form-select" name="{{ $tipe }}[penghasilan_id]">
                    <option value="">Pilih Penghasilan</option>
                    @foreach ($penghasilanList as $id => $rentang)
                        <option value="{{ $id }}"
                            {{ old($tipe . '.penghasilan_id', $ortu->penghasilan_id ?? '') == $id ? 'selected' : '' }}>
                            {{ $rentang }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>
    </div>
@endforeach
