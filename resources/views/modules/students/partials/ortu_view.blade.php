<div class="row g-3">


    <div class="card mb-4">
        <div class="card-body p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="m-0">Data Orang Tua</h3>
                    <small class="text-muted">Informasi orang tua dan wali siswa</small>
                </div>
                <button type="button" class="btn btn-pill btn-yellow" id="editOrtuBtn" onclick="toggleOrtuEdit(true)"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Data Orang Tua">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                        <path d="M16 5l3 3" />
                    </svg> Orang Tua
                </button>
            </div>
        </div>
    </div>

    @forelse ($student->orangTuas as $ortu)
        <div class="col-md-6">
            <div class="card">
                @php
                    $color = $ortu->tipe == 'ayah' ? 'blue' : 'pink';
                @endphp

                <div class="card-header d-flex align-items-center justify-content-between bg-{{ $color }}-lt">
                    <h3 class="card-title text-capitalize">{{ $ortu->tipe }}</h3>
                    <span class="badge bg-{{ $color }} text-{{ $color }}-fg">
                        {{ ucfirst($ortu->tipe) }}
                    </span>
                </div>

                <div class="card-body">
                    <div class="datagrid">
                        <div class="datagrid-item">
                            <div class="datagrid-title">Nama</div>
                            <div class="datagrid-content">{{ $ortu->nama }}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Tahun Lahir</div>
                            <div class="datagrid-content">{{ $ortu->tahun_lahir }}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">NIK</div>
                            <div class="datagrid-content">{{ $ortu->nik }}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Pendidikan</div>
                            <div class="datagrid-content">
                                {{ $ortu->pendidikan->jenjang ?? '-' }}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Pekerjaan</div>
                            <div class="datagrid-content">
                                {{ $ortu->pekerjaan->nama ?? '-' }}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Penghasilan</div>
                            <div class="datagrid-content">
                                {{ $ortu->penghasilan->rentang ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">
                <div class="d-flex">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-info-circle"
                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                            <path d="M12 8l.01 0" />
                            <path d="M11 12l1 0l0 4l1 0" />
                        </svg>
                    </div>
                    <div class="ms-3">
                        <h4>Data Orang Tua Belum Tersedia</h4>
                        <div class="text-muted">Silahkan tambahkan data orang tua siswa.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforelse
</div>
