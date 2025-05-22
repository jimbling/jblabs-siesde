<?php

namespace App\Services\BukuInduk\Foto;

use App\Models\FotoSiswa;
use App\Models\Student;
use App\Models\Semester;
use App\Models\Rombel;
use App\Models\TahunPelajaran;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class FotoSiswaService
{
    public function getStudentPhotos($siswaUuid)
    {
        $tahunPelajarans = TahunPelajaran::all();
        $semesters = Semester::all();
        $rombels = Rombel::all();

        $siswa = Student::where('uuid', $siswaUuid)->with([
            'rombels.rombel',
            'rombels.tahunPelajaran',
            'rombels.semester'
        ])->firstOrFail();

        $fotos = FotoSiswa::where('siswa_uuid', $siswaUuid)
            ->with(['tahunPelajaran', 'semester', 'rombel'])
            ->latest()
            ->get();

        $tanggal_lahir = $siswa->tanggal_lahir
            ? Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y')
            : null;

        return compact('siswa', 'fotos', 'tanggal_lahir', 'tahunPelajarans', 'semesters', 'rombels');
    }

    public function storePhoto($request)
    {
        $request->validate([
            'siswa_uuid' => 'required|exists:students,uuid',
            'tahun_pelajaran_id' => 'required|exists:tahun_pelajaran,id',
            'semester_id' => 'required|exists:semester,id',
            'rombel_id' => 'required|exists:rombel,id',
            'path_foto' => 'required|image|mimes:jpg,jpeg,png|max:512',
        ]);

        return $this->savePhoto($request);
    }

    private function savePhoto($request)
    {
        $foto = $request->file('path_foto');
        $imageManager = new ImageManager(new Driver());

        $originalFilename = uniqid('foto_asli_') . '.' . $foto->getClientOriginalExtension();
        $originalPath = 'foto_siswa/asli/' . $originalFilename;
        Storage::disk('public')->put($originalPath, file_get_contents($foto));

        $image = $imageManager->read($foto);
        $size = min($image->width(), $image->height());
        $x = intval(($image->width() - $size) / 2);
        $image->crop($size, $size, $x, 0);

        $webpFilename = uniqid('foto_web_') . '.webp';
        $webpPath = 'foto_siswa/web/' . $webpFilename;
        Storage::disk('public')->put($webpPath, (string) $image->toWebp(80));

        return FotoSiswa::create([
            'siswa_uuid' => $request->siswa_uuid,
            'tahun_pelajaran_id' => $request->tahun_pelajaran_id,
            'semester_id' => $request->semester_id,
            'rombel_id' => $request->rombel_id,
            'path_foto' => $webpPath,
            'path_foto_asli' => $originalPath,
        ]);
    }

    public function updatePhoto($request, $id)
    {
        $foto = FotoSiswa::findOrFail($id);
        $request->validate([
            'tahun_pelajaran_id' => 'required|exists:tahun_pelajaran,id',
            'semester_id' => 'required|exists:semester,id',
            'rombel_id' => 'required|exists:rombel,id',
            'path_foto' => 'nullable|image|mimes:jpg,jpeg,png|max:512',
        ]);

        if ($request->hasFile('path_foto')) {
            Storage::disk('public')->delete([$foto->path_foto, $foto->path_foto_asli]);
            return $this->savePhoto($request);
        }

        $foto->update($request->only(['tahun_pelajaran_id', 'semester_id', 'rombel_id']));
        return $foto;
    }

    public function deletePhoto($id)
    {
        $foto = FotoSiswa::findOrFail($id);
        Storage::disk('public')->delete([$foto->path_foto, $foto->path_foto_asli]);
        $foto->delete();
    }
}
