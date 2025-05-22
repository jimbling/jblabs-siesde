<?php

namespace App\Http\Controllers\Modules\BukuInduk;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\BukuInduk\Dokumen\DokumenSiswaService;

class DokumenSiswaController extends Controller
{
    protected $dokumenSiswaService;

    public function __construct(DokumenSiswaService $dokumenSiswaService)
    {
        $this->dokumenSiswaService = $dokumenSiswaService;
    }

    public function store(Request $request, Student $student)
    {
        return $this->dokumenSiswaService->store($request, $student);
    }

    public function destroy($id)
    {
        return $this->dokumenSiswaService->destroy($id);
    }

    public function partial($studentId)
    {
        $student = $this->dokumenSiswaService->getStudentDocuments($studentId);
        return view('modules.students.partials.student-documents', compact('student'));
    }
}
