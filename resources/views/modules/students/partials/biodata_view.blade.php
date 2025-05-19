<div class="row">
    <div class="card mb-4">
        <div class="card-body p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="m-0">Biodata Siswa</h3>
                    <small class="text-muted">Informasi lengkap identitas siswa</small>
                </div>
                <a href="{{ request()->fullUrlWithQuery(['edit' => 'biodata']) }}" class="btn btn-yellow"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Biodata">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                        <path d="M16 5l3 3" />
                    </svg>Biodata
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-primary-lt">
                <h3 class="card-title">Identitas Pribadi</h3>
            </div>
            <div class="card-body">
                <div class="datagrid">
                    <div class="datagrid-item">
                        <div class="datagrid-title">NIK</div>
                        <div class="datagrid-content">{{ $student->nik ?? '-' }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Tempat Lahir</div>
                        <div class="datagrid-content">{{ $student->tempat_lahir ?? '-' }}
                        </div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Tanggal Lahir</div>
                        <div class="datagrid-content">
                            {{ $student->tanggal_lahir_indo ?? '-' }}
                            ({{ \Carbon\Carbon::parse($student->tanggal_lahir)->age }}
                            tahun)</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Agama</div>
                        <div class="datagrid-content">{{ $student->agama->nama ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-primary-lt">
                <h3 class="card-title">Kontak</h3>
            </div>
            <div class="card-body">
                <div class="datagrid">
                    <div class="datagrid-item">
                        <div class="datagrid-title">Telepon</div>
                        <div class="datagrid-content">{{ $student->telepon ?? '-' }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">HP</div>
                        <div class="datagrid-content">{{ $student->hp ?? '-' }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Email</div>
                        <div class="datagrid-content">{{ $student->email ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-primary-lt">
                <h3 class="card-title">Alamat</h3>
            </div>
            <div class="card-body">
                <div class="datagrid">
                    <div class="datagrid-item">
                        <div class="datagrid-title">Alamat Lengkap</div>
                        <div class="datagrid-content">{{ $student->alamat ?? '-' }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">RT/RW</div>
                        <div class="datagrid-content">RT {{ $student->rt ?? '-' }} / RW
                            {{ $student->rw ?? '-' }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Dusun</div>
                        <div class="datagrid-content">{{ $student->dusun ?? '-' }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Kelurahan/Kecamatan</div>
                        <div class="datagrid-content">{{ $student->kelurahan ?? '-' }} /
                            {{ $student->kecamatan ?? '-' }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Jenis Tinggal</div>
                        <div class="datagrid-content">
                            {{ $student->jenisTinggal->nama ?? '-' }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Alat Transportasi</div>
                        <div class="datagrid-content">
                            {{ $student->alatTransportasi->nama ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
