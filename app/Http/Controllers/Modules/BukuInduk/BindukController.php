<?php

namespace App\Http\Controllers\Modules\BukuInduk;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\BukuInduk\BindukServices;
use App\Http\Requests\BukuInduk\GenerateNomorDokumenRequest;
use App\Services\BukuInduk\GenerateNomorDokumenServices;
use App\Services\BukuInduk\GeneratePDFService;
use App\Services\BukuInduk\ShowStudentDetailService;
use App\Services\BukuInduk\CetakService;
use App\Services\BukuInduk\VerifikasiDokumenservices;

class BindukController extends Controller
{

    protected $bindukService;
    protected $generateNomorDokumenService;
    protected $generatePDFService;
    protected $showStudentDetailService;
    protected $cetakService;
    protected $verifikasiDokumenService;

    public function __construct(
        BindukServices $bindukService,
        GenerateNomorDokumenServices $generateNomorDokumenService,
        GeneratePDFService $generatePDFService,
        ShowStudentDetailService $showStudentDetailService,
        CetakService $cetakService,
        VerifikasiDokumenservices $verifikasiDokumenService
    ) {
        $this->bindukService = $bindukService;
        $this->generateNomorDokumenService = $generateNomorDokumenService;
        $this->generatePDFService = $generatePDFService;
        $this->showStudentDetailService = $showStudentDetailService;
        $this->cetakService = $cetakService;
        $this->verifikasiDokumenService = $verifikasiDokumenService;
    }

    public function index(Request $request)
    {
        $students = $this->bindukService->getFilteredStudents($request->filter);

        return view('modules.buku-induk.binduk-index', [
            'title' => 'Data Siswa Buku Induk',
            'breadcrumbs' => $this->bindukService->getBreadcrumbs(),
            'students' => $students,
            'totalStudents' => $students->count(),
        ]);
    }


    public function generateNomorDokumen(GenerateNomorDokumenRequest $request)
    {
        $existingStudents = $this->generateNomorDokumenService->generateNomorDokumen($request->student_ids);

        if (count($existingStudents) > 0) {
            return redirect()->route('induk.index')->with('error', 'Peserta Didik ' . implode(', ', $existingStudents) . ' sudah memiliki nomor dokumen.');
        }

        return redirect()->route('induk.index')->with('success', 'Nomor dokumen berhasil digenerate untuk siswa yang dipilih.');
    }



    public function generatePDF($studentUuid)
    {
        return $this->generatePDFService->generate($studentUuid);
    }



    public function showStudentDetail($uuid)
    {
        $data = $this->showStudentDetailService->getStudentDetail($uuid);

        return view('modules.buku-induk.binduk-detail-siswa', $data);
    }



    public function cetak(Request $request)
    {
        $uuid = $this->cetakService->cetak($request->student_id);
        return redirect()->route('induk.buku-induk.print', $uuid);
    }

    public function print($uuid)
    {
        $data = $this->cetakService->getPrintData($uuid);
        return view('modules.buku-induk.binduk-print', $data);
    }


    public function verifikasiDokumen($uuid)
    {
        $data = $this->verifikasiDokumenService->getVerificationByUuid($uuid);

        if (isset($data['error'])) {
            return response()->view('modules.errors.verifikasi-tidak-ditemukan', [
                'title' => $data['error'],
            ], 404);
        }

        return view('modules.buku-induk.binduk-verifikasi', $data);
    }

    public function verifikasiDokumenShort($shortCode)
    {
        $data = $this->verifikasiDokumenService->getVerificationByShortCode($shortCode);

        if (isset($data['error'])) {
            return response()->view('modules.errors.verifikasi-tidak-ditemukan', [
                'title' => $data['error'],
            ], 404);
        }

        return view('modules.buku-induk.binduk-verifikasi', $data);
    }
}
