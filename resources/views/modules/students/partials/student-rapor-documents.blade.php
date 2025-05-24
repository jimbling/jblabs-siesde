<!-- Modal Upload Rapor -->
<div class="modal fade" id="uploadRaporModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="uploadRaporForm" action="{{ route('students.rapor.upload', $student->uuid) }}" method="POST"
            enctype="multipart/form-data">

            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Scan Nilai Rapor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="semester_id" class="form-label">Semester (Tahun Pelajaran)</label>
                        <select name="semester_id" class="form-select" required>
                            @foreach ($semesterList as $semester)
                                <option value="{{ $semester->id }}">
                                    Semester {{ $semester->semester }} - {{ $semester->tahunPelajaran->tahun_ajaran }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="nama_file" class="form-label">Nama File (misal: Rapor Semester 1)</label>
                        <input type="text" name="nama_file" class="form-control" required
                            placeholder="Contoh: Rapor Semester Ganjil 2024">
                    </div>

                    <div class="mb-3">
                        <label for="document" class="form-label">Upload File Rapor</label>
                        <input type="file" name="document" class="form-control" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Upload</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
