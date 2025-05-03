<?php

namespace App\Http\Controllers\Modules\BukuInduk;

use App\Models\Semester;
use Illuminate\Http\Request;
use App\Models\TahunPelajaran;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSemesterRequest;

class SemesterController extends Controller
{

    protected $casts = [
        'is_aktif' => 'boolean',
    ];

    public function store(StoreSemesterRequest $request)
    {


        $validated = $request->validated();

        if ($request->boolean('is_aktif')) {

            Semester::where('tahun_pelajaran_id', $validated['tahun_pelajaran_id'])
                ->update(['is_aktif' => false]);

            $validated['is_aktif'] = true;
        } else {
            $validated['is_aktif'] = false;
        }

        Semester::create($validated);

        return back()->with('success', 'Semester berhasil ditambahkan.');
    }


    public function aktifkan($tahunPelajaranId, $semesterId)
    {
        $tahunPelajaran = TahunPelajaran::findOrFail($tahunPelajaranId);

        // Pastikan semester tersebut milik tahun pelajaran yang sama
        $semester = $tahunPelajaran->semesters()->where('id', $semesterId)->firstOrFail();

        // Cek apakah sudah ada semester aktif di tempat lain
        $semesterAktifLain = \App\Models\Semester::where('is_aktif', true)
            ->where('id', '!=', $semester->id)
            ->first();

        if ($semesterAktifLain) {
            return back()->with('error', 'Sudah ada semester aktif lainnya. Nonaktifkan dulu sebelum mengaktifkan semester ini.');
        }

        // Lanjut update
        $tahunPelajaran->semesters()->update(['is_aktif' => false]);

        $updated = $semester->update(['is_aktif' => true]);

        if ($updated) {
            return back()->with('success', "Semester {$semester->nama} berhasil diaktifkan.");
        } else {
            return back()->with('error', 'Gagal mengaktifkan semester. Silakan coba lagi.');
        }
    }

    public function nonaktifkan($tahunPelajaranId, $semesterId)
    {


        $tahunPelajaran = TahunPelajaran::findOrFail($tahunPelajaranId);

        // Pastikan semester tersebut milik tahun pelajaran yang sama
        $semester = $tahunPelajaran->semesters()->where('id', $semesterId)->firstOrFail();

        if (!$semester->is_aktif) {
            return back()->with('info', "Semester {$semester->nama} sudah dalam keadaan nonaktif.");
        }

        $updated = $semester->update(['is_aktif' => false]);

        if ($updated) {
            return back()->with('success', "Semester {$semester->nama} berhasil dinonaktifkan.");
        } else {
            return back()->with('error', 'Gagal menonaktifkan semester.');
        }
    }



    public function destroy($tahunPelajaranId)
    {
        $tahunPelajaran = TahunPelajaran::findOrFail($tahunPelajaranId);

        // Logika untuk menghapus semester
        $semester = $tahunPelajaran->semesters->first(); // Mengambil semester pertama, sesuaikan dengan logika
        $semester->delete();

        return back()->with('success', 'Semester berhasil dihapus.');
    }
}
