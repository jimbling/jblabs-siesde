@if (!$documents || $documents->isEmpty())
    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i>Belum ada dokumen yang diupload
    </div>
@else
    <div class="table-responsive">
        <table class="table table-vcenter table-hover">
            <thead>
                <tr>
                    <th>Jenis Dokumen</th>
                    <th>Keterangan</th>
                    <th>Tanggal Upload</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($documents as $doc)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                @switch($doc->tipe_dokumen)
                                    @case('kk')
                                        <i class="fas fa-id-card text-blue me-2"></i>
                                        Kartu Keluarga
                                    @break

                                    @case('akta_kelahiran')
                                        <i class="fas fa-birthday-cake text-purple me-2"></i>
                                        Akta Kelahiran
                                    @break

                                    @case('ijazah_tk')
                                        <i class="fas fa-graduation-cap text-orange me-2"></i>
                                        Ijazah TK
                                    @break

                                    @case('ijazah_sd')
                                        <i class="fas fa-graduation-cap text-green me-2"></i>
                                        Ijazah SD
                                    @break

                                    @default
                                        <i class="fas fa-file text-muted me-2"></i>
                                        Lainnya
                                @endswitch
                            </div>
                        </td>
                        <td>{{ $doc->keterangan ?? '-' }}</td>
                        <td>{{ $doc->tanggal_upload->format('d/m/Y H:i') }}</td>
                        <td class="text-center">
                            <button class="btn btn-icon btn-preview" data-url="{{ Storage::url($doc->path_file) }}"
                                data-title="{{ $doc->type_name ?? 'Dokumen' }}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <a href="{{ Storage::url($doc->path_file) }}" class="btn btn-icon" download>
                                <i class="fas fa-download"></i>
                            </a>
                            <button class="btn btn-icon btn-danger btn-delete" data-id="{{ $doc->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
