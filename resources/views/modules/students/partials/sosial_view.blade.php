<div class="card mb-4">
    <div class="card-body p-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h3 class="m-0">Data Kesejahteraan</h3>
                <small class="text-muted">Informasi kesejahteraan dan sosial siswa</small>
            </div>
            <button type="button" class="btn btn-yellow" id="btn-edit-sosial" onclick="toggleSosialEdit(true)"
                data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data Kesejahteraan">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                    <path d="M16 5l3 3" />
                </svg> Data Kesejahteraan
            </button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-orange-lt">
                <h3 class="card-title">Program Bantuan</h3>
            </div>
            <div class="card-body">
                <div class="datagrid">
                    <div class="datagrid-item">
                        <div class="datagrid-title">Penerima KPS</div>
                        <div class="datagrid-content">
                            <span class="status status-{{ $student->penerima_kps ? 'success' : 'danger' }}">
                                {{ $student->penerima_kps ? 'Ya' : 'Tidak' }}
                            </span>
                        </div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">No KPS</div>
                        <div class="datagrid-content">{{ $student->no_kps ?? '-' }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Penerima KIP</div>
                        <div class="datagrid-content">
                            <span class="status status-{{ $student->penerima_kip ? 'success' : 'danger' }}">
                                {{ $student->penerima_kip ? 'Ya' : 'Tidak' }}
                            </span>
                        </div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">No KIP</div>
                        <div class="datagrid-content">{{ $student->nomor_kip ?? '-' }}
                        </div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Nama di KIP</div>
                        <div class="datagrid-content">{{ $student->nama_di_kip ?? '-' }}
                        </div>
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
                <div class="datagrid">
                    <div class="datagrid-item">
                        <div class="datagrid-title">No KKS</div>
                        <div class="datagrid-content">{{ $student->nomor_kks ?? '-' }}
                        </div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Layak PIP</div>
                        <div class="datagrid-content">
                            <span class="status status-{{ $student->layak_pip ? 'success' : 'danger' }}">
                                {{ $student->layak_pip ? 'Ya' : 'Tidak' }}
                            </span>
                        </div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Alasan Layak PIP</div>
                        <div class="datagrid-content">
                            {{ $student->alasan_layak_pip ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
