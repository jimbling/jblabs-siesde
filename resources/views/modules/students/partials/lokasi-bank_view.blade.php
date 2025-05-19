<div class="row">

    <div class="card mb-4">
        <div class="card-body p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="m-0">Data Lokasi & Bank</h3>
                    <small class="text-muted">Informasi lokasi dan Bank PIP siswa</small>
                </div>
                <button class="btn btn-yellow" id="btn-edit-lokasi" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Edit Lokasi & Bank">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                        <path d="M16 5l3 3" />
                    </svg> Lokasi & Bank
                </button>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-purple-lt">
                <h3 class="card-title">Lokasi</h3>
            </div>
            <div class="card-body">
                <div class="datagrid">
                    <div class="datagrid-item">
                        <div class="datagrid-title">Jarak Rumah ke Sekolah</div>
                        <div class="datagrid-content">
                            {{ $student->jarak_rumah_km ?? '0' }} km</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Koordinat</div>
                        <div class="datagrid-content">
                            @if ($student->lintang && $student->bujur)
                                <a href="https://maps.google.com/?q={{ $student->lintang }},{{ $student->bujur }}"
                                    target="_blank" class="text-primary">
                                    {{ $student->lintang }}, {{ $student->bujur }}
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-external-link" width="16" height="16"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6" />
                                        <path d="M11 13l9 -9" />
                                        <path d="M15 4h5v5" />
                                    </svg>
                                </a>
                            @else
                                -
                            @endif
                        </div>
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
                <div class="datagrid">
                    <div class="datagrid-item">
                        <div class="datagrid-title">Bank</div>
                        <div class="datagrid-content">{{ $student->bank ?? '-' }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">No Rekening</div>
                        <div class="datagrid-content">
                            {{ $student->nomor_rekening ?? '-' }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Atas Nama</div>
                        <div class="datagrid-content">
                            {{ $student->rekening_atas_nama ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
