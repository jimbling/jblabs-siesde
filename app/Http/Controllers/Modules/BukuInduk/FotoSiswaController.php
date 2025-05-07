<?php

namespace App\Http\Controllers\Modules\BukuInduk;

use Carbon\Carbon;
use App\Models\Rombel;
use App\Models\Student;
use App\Models\Semester;
use App\Models\FotoSiswa;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Image;
use App\Models\TahunPelajaran;
use App\Helpers\BreadcrumbHelper;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;

class FotoSiswaController extends Controller
{
    public function index($siswa_uuid)
    {
        $tahunPelajarans = TahunPelajaran::all();
        $semesters = Semester::all();
        $rombels = Rombel::all();
        // Ambil data siswa berdasarkan UUID dan muat relasi rombel, tahun pelajaran, dan semester
        $siswa = Student::where('uuid', $siswa_uuid)
            ->with([
                'rombels.rombel', // Ambil data rombel
                'rombels.tahunPelajaran', // Ambil data tahun pelajaran
                'rombels.semester' // Ambil data semester
            ])
            ->first();

        // Jika siswa tidak ditemukan
        if (!$siswa) {
            return redirect()->route('siswa.index')->with('error', 'Siswa tidak ditemukan');
        }

        // Ambil semua foto siswa (bisa jadi kosong)
        $fotos = FotoSiswa::where('siswa_uuid', $siswa_uuid)
            ->with(['tahunPelajaran', 'semester', 'rombel']) // Pastikan relasi ini dimuat
            ->latest()
            ->get();

        $tanggal_lahir = $siswa->tanggal_lahir
            ? Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y')
            : null;

        return view('modules.buku-induk.foto-siswa', [
            'title' => $siswa ? 'Foto - ' . $siswa->nama : 'Foto Siswa',
            'siswa' => $siswa,
            'fotos' => $fotos,
            'tanggal_lahir_formatted' => $tanggal_lahir,
            'tahunPelajarans' => $tahunPelajarans,
            'semesters' => $semesters,
            'rombels' => $rombels,
        ]);
    }






    public function create()
    {
        $siswas = Student::all();
        return view('modules.buku-induk.foto.create', compact('siswas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_uuid' => 'required|exists:students,uuid',
            'tahun_pelajaran_id' => 'required|exists:tahun_pelajaran,id',
            'semester_id' => 'required|exists:semester,id',
            'rombel_id' => 'required|exists:rombel,id',
            'path_foto' => 'required|image|mimes:jpg,jpeg,png|max:512',
        ], [
            'path_foto.required' => 'Foto wajib diunggah.',
            'path_foto.image' => 'File harus berupa gambar.',
            'path_foto.mimes' => 'Foto harus berformat JPG, JPEG, atau PNG.',
            'path_foto.max' => 'Ukuran foto maksimal 500KB.',
        ]);

        $foto = $request->file('path_foto');

        // Validasi tambahan: maksimal 2 per tahun pelajaran
        $existingCount = FotoSiswa::where('siswa_uuid', $request->siswa_uuid)
            ->where('tahun_pelajaran_id', $request->tahun_pelajaran_id)
            ->count();

        if ($existingCount >= 2) {
            return redirect()->back()->withErrors(['path_foto' => 'Foto siswa untuk tahun pelajaran ini sudah mencapai batas maksimal (2 semester).']);
        }

        $imageManager = new ImageManager(new \Intervention\Image\Drivers\Gd\Driver());

        // Simpan versi asli (untuk cetak)
        $originalFilename = uniqid('foto_asli_') . '.' . $foto->getClientOriginalExtension();
        $originalPath = 'foto_siswa/asli/' . $originalFilename;
        Storage::disk('public')->put($originalPath, file_get_contents($foto));

        // Versi crop square untuk web
        $image = $imageManager->read($foto);
        $width = $image->width();
        $height = $image->height();
        $size = min($width, $height);
        $x = intval(($width - $size) / 2);  // tetap center horizontal
        $y = 0; // dari atas, bukan dari tengah
        $image->crop($size, $size, $x, $y);
        $webpImage = $image->toWebp(80);

        $webpFilename = uniqid('foto_web_') . '.webp';
        $webpPath = 'foto_siswa/web/' . $webpFilename;
        Storage::disk('public')->put($webpPath, (string) $webpImage);


        FotoSiswa::create([
            'siswa_uuid' => $request->siswa_uuid,
            'tahun_pelajaran_id' => $request->tahun_pelajaran_id,
            'semester_id' => $request->semester_id,
            'rombel_id' => $request->rombel_id,
            'path_foto' => $webpPath,
            'path_foto_asli' => $originalPath,
        ]);

        return redirect()->back()->with('success', 'Foto siswa berhasil ditambahkan.');
    }


    public function update(Request $request, $id)
    {
        // dd($request->all());
        $foto = FotoSiswa::findOrFail($id);

        $request->validate([
            'tahun_pelajaran_id' => 'required|exists:tahun_pelajaran,id',
            'semester_id' => 'required|exists:semester,id',
            'rombel_id' => 'required|exists:rombel,id',
            'path_foto' => 'nullable|image|mimes:jpg,jpeg,png|max:512',
        ]);

        if ($request->hasFile('path_foto')) {
            // Hapus file lama
            Storage::disk('public')->delete([$foto->path_foto, $foto->path_foto_asli]);

            $fotoBaru = $request->file('path_foto');
            $imageManager = new ImageManager(new \Intervention\Image\Drivers\Gd\Driver());

            // Simpan asli
            $originalFilename = uniqid('foto_asli_') . '.' . $fotoBaru->getClientOriginalExtension();
            $originalPath = 'foto_siswa/asli/' . $originalFilename;
            Storage::disk('public')->put($originalPath, file_get_contents($fotoBaru));

            // Crop untuk versi web
            $image = $imageManager->read($fotoBaru);
            $size = min($image->width(), $image->height());
            $x = intval(($image->width() - $size) / 2);
            $image->crop($size, $size, $x, 0);
            $webpFilename = uniqid('foto_web_') . '.webp';
            $webpPath = 'foto_siswa/web/' . $webpFilename;
            Storage::disk('public')->put($webpPath, (string) $image->toWebp(80));

            // Update path di DB
            $foto->path_foto = $webpPath;
            $foto->path_foto_asli = $originalPath;
        }

        $foto->update([
            'tahun_pelajaran_id' => $request->tahun_pelajaran_id,
            'semester_id' => $request->semester_id,
            'rombel_id' => $request->rombel_id,
        ]);

        return back()->with('success', 'Foto siswa berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $foto = FotoSiswa::findOrFail($id);

        // Hapus file WebP
        if ($foto->path_foto && Storage::disk('public')->exists($foto->path_foto)) {
            Storage::disk('public')->delete($foto->path_foto);
        }

        // Hapus file Asli
        if ($foto->path_foto_asli && Storage::disk('public')->exists($foto->path_foto_asli)) {
            Storage::disk('public')->delete($foto->path_foto_asli);
        }

        $foto->delete();

        return back()->with('success', 'Foto berhasil dihapus.');
    }
}
