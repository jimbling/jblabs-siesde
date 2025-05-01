<?php

namespace App\Http\Controllers\Modules\BukuInduk;

use App\Models\Rombel;
use Illuminate\Http\Request;
use App\Helpers\BreadcrumbHelper;
use App\Http\Controllers\Controller;


class RombelController extends Controller
{


    public function index()
    {
        $rombels = Rombel::all();

        return view('modules.buku-induk.akademik-kelas', [
            'title' => 'Data Kelas',
            'breadcrumbs' => BreadcrumbHelper::generate([
                ['name' => 'Akademik'],
                ['name' => 'Data Kelas'],
            ]),
            'rombels' => $rombels,

        ]);
    }

    public function create()
    {
        return view('modules.buku-induk.kelas.create', [
            'title' => 'Tambah Kelas',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tingkat' => 'required|integer|unique:rombel,tingkat', // Validasi unik untuk tingkat
        ], [
            'nama.required' => 'Nama rombel harus diisi.',
            'nama.string' => 'Nama rombel harus berupa teks.',
            'nama.max' => 'Nama rombel maksimal 255 karakter.',
            'tingkat.required' => 'Tingkat harus diisi.',
            'tingkat.integer' => 'Tingkat harus berupa angka.',
            'tingkat.unique' => 'Tingkat sudah terdaftar, pilih tingkat lain.',
        ]);

        // Menyimpan data rombel
        Rombel::create($request->only('nama', 'tingkat'));

        return redirect()->route('induk.akademik.kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }


    public function edit(Rombel $rombel)
    {
        return view('modules.buku-induk.kelas.edit', [
            'title' => 'Edit Kelas',
            'rombel' => $rombel,
        ]);
    }

    public function update(Request $request, Rombel $rombel)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tingkat' => 'required|integer',
        ]);

        $rombel->update($request->only('nama', 'tingkat'));

        return redirect()->route('induk.akademik.kelas.index')->with('success', 'Kelas berhasil diperbarui.');
    }



    public function massDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:rombel,id', // Pastikan setiap ID valid
        ]);

        Rombel::whereIn('id', $request->ids)->delete();

        return redirect()->route('induk.akademik.kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
