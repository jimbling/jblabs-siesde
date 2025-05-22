<?php

namespace App\Http\Controllers\Modules\Akademik\Rombel;

use App\Models\Rombel;
use Illuminate\Http\Request;
use App\Helpers\BreadcrumbHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Akademik\StoreRombelRequest;
use App\Http\Requests\Akademik\UpdateRombelRequest;
use App\Services\Akademik\Rombel\RombelService;

class RombelController extends Controller
{
    protected $rombelService;

    public function __construct(RombelService $rombelService)
    {
        $this->rombelService = $rombelService;
    }

    public function index()
    {
        return view('modules.buku-induk.akademik-kelas', [
            'title' => 'Data Kelas',
            'breadcrumbs' => BreadcrumbHelper::generate([
                ['name' => 'Akademik'],
                ['name' => 'Data Kelas'],
            ]),
            'rombels' => $this->rombelService->getAllRombels(),
        ]);
    }

    public function create()
    {
        return view('modules.buku-induk.kelas.create', [
            'title' => 'Tambah Kelas',
        ]);
    }

    public function store(StoreRombelRequest $request)
    {
        $this->rombelService->createRombel($request->validated());
        return redirect()->route('induk.akademik.kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function edit(Rombel $rombel)
    {
        return view('modules.buku-induk.kelas.edit', [
            'title' => 'Edit Kelas',
            'rombel' => $rombel,
        ]);
    }

    public function update(UpdateRombelRequest $request, Rombel $rombel)
    {
        $this->rombelService->updateRombel($rombel, $request->validated());
        return redirect()->route('induk.akademik.kelas.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function massDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:rombel,id',
        ]);

        $this->rombelService->deleteRombels($request->ids);
        return redirect()->route('induk.akademik.kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
