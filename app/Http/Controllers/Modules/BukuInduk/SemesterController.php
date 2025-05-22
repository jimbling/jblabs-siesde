<?php

namespace App\Http\Controllers\Modules\BukuInduk;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSemesterRequest;
use App\Services\Akademik\SemesterService;

class SemesterController extends Controller
{
    protected $semesterService;

    public function __construct(SemesterService $semesterService)
    {
        $this->semesterService = $semesterService;
    }

    public function store(StoreSemesterRequest $request)
    {
        $validated = $request->validated();
        $validated['is_aktif'] = $request->boolean('is_aktif');

        $this->semesterService->storeSemester($validated);

        return back()->with('success', 'Semester berhasil ditambahkan.');
    }

    public function aktifkan($tahunPelajaranId, $semesterId)
    {
        try {
            $this->semesterService->aktifkanSemester($tahunPelajaranId, $semesterId);
            return back()->with('success', "Semester berhasil diaktifkan.");
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function nonaktifkan($tahunPelajaranId, $semesterId)
    {
        try {
            $this->semesterService->nonaktifkanSemester($tahunPelajaranId, $semesterId);
            return back()->with('success', "Semester berhasil dinonaktifkan.");
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($tahunPelajaranId)
    {
        $this->semesterService->destroySemester($tahunPelajaranId);
        return back()->with('success', 'Semester berhasil dihapus.');
    }
}
