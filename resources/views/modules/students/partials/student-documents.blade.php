@if (optional($student->dokumen)->count() > 0)
    <div class="table-responsive">
        <table class="table table-hover table-nowrap card-table">
            <thead class="bg-light">
                <tr>
                    <th class="w-30">Jenis Dokumen</th>
                    <th>Keterangan</th>
                    <th>Tanggal Unggah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($student->dokumen as $doc)
                    <tr class="document-row">
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    @switch($doc->tipe_dokumen)
                                        @case('kk')
                                            <span class="avatar avatar-sm bg-blue-lt">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path
                                                        d="M3 5m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                                                    <path d="M7 10h2l2 2l2 -2h2" />
                                                </svg>
                                            </span>
                                        @break

                                        @case('akta_kelahiran')
                                            <span class="avatar avatar-sm bg-purple-lt">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-baby-carriage">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M8 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                    <path d="M18 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                    <path
                                                        d="M2 5h2.5l1.632 4.897a6 6 0 0 0 5.693 4.103h2.675a5.5 5.5 0 0 0 0 -11h-.5v6" />
                                                    <path d="M6 9h14" />
                                                    <path d="M9 17l1 -3" />
                                                    <path d="M16 14l1 3" />
                                                </svg>
                                            </span>
                                        @break

                                        @default
                                            <span class="avatar avatar-sm bg-azure-lt">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                    <path
                                                        d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                                </svg>
                                            </span>
                                    @endswitch
                                </div>
                                <div>
                                    <div class="font-weight-medium">{{ $doc->type_name }}</div>
                                    <div class="text-muted small">
                                        {{ strtoupper(pathinfo($doc->path_file, PATHINFO_EXTENSION)) }} •
                                        {{ round(Storage::disk('public')->size($doc->path_file) / 1024) }}KB
                                    </div>
                                </div>
                        </td>
                        <td>
                            <div class="text-wrap" style="min-width: 160px">
                                {{ $doc->keterangan ?? '-' }}
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="me-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock"
                                        width="16" height="16" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                        <path d="M12 7v5l3 3" />
                                    </svg>
                                </div>
                                <div>
                                    <div>{{ $doc->tanggal_upload_indo }}</div>
                                    <div class="text-muted small">{{ $doc->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-end">
                            <div class="btn-list flex-nowrap">
                                {{-- Download --}}
                                <a href="{{ Storage::url($doc->path_file) }}"
                                    class="btn btn-md btn-icon btn-outline-success d-flex align-items-center justify-content-center"
                                    download data-bs-toggle="tooltip" data-bs-placement="top" title="Download">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icon-tabler-download">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                        <path d="M7 11l5 5l5 -5" />
                                        <path d="M12 4l0 12" />
                                    </svg>
                                </a>

                                {{-- Pratinjau --}}
                                <button type="button"
                                    class="btn btn-md btn-icon btn-outline-warning d-flex align-items-center justify-content-center btn-preview"
                                    data-url="{{ Storage::url($doc->path_file) }}" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Pratinjau">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icon-tabler-eye">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path
                                            d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                    </svg>
                                </button>

                                {{-- Hapus --}}
                                <button type="button"
                                    class="btn btn-md btn-icon btn-outline-danger d-flex align-items-center justify-content-center btn-delete-doc"
                                    data-id="{{ $doc->id }}"
                                    data-action="{{ route('student.documents.destroy', $doc->id) }}"
                                    data-target-modal="#modalHapusDokumen" data-bs-toggle="tooltip"
                                    data-bs-placement="top" title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icon-tabler-trash">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 7l16 0" />
                                        <path d="M10 11l0 6" />
                                        <path d="M14 11l0 6" />
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                    </svg>
                                </button>
                            </div>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="empty">
        <div class="empty-img">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-folder-off" width="48"
                height="48" viewBox="0 0 24 24" stroke-width="1.5" stroke="#adb5bd" fill="none"
                stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M8 4h1l3 3h7a2 2 0 0 1 2 2v8m-2 2h-14a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 1.189 -1.829" />
                <path d="M3 3l18 18" />
            </svg>
        </div>
        <p class="empty-title">Tidak ada dokumen ditemukan</p>
        <p class="empty-subtitle text-muted">
            Siswa belum memiliki dokumen terunggah. Klik tombol "Unggah Dokumen" untuk menambahkan.
        </p>
        <div class="empty-action">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadDocumentModal">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 5l0 14" />
                    <path d="M5 12l14 0" />
                </svg>
                Unggah Dokumen Pertama
            </button>
        </div>
    </div>
@endif
