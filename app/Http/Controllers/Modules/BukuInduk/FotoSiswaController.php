<?php

namespace App\Http\Controllers\Modules\BukuInduk;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\BukuInduk\Foto\FotoSiswaService;

class FotoSiswaController extends Controller
{
    protected $fotoSiswaService;

    public function __construct(FotoSiswaService $fotoSiswaService)
    {
        $this->fotoSiswaService = $fotoSiswaService;
    }

    public function index($siswaUuid)
    {
        $data = $this->fotoSiswaService->getStudentPhotos($siswaUuid);
        return view('modules.buku-induk.foto-siswa', $data);
    }

    public function store(Request $request)
    {
        $this->fotoSiswaService->storePhoto($request);
        return redirect()->back()->with('success', 'Foto siswa berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $this->fotoSiswaService->updatePhoto($request, $id);
        return back()->with('success', 'Foto siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->fotoSiswaService->deletePhoto($id);
        return back()->with('success', 'Foto berhasil dihapus.');
    }
}
