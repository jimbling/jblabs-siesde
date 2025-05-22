<?php

namespace App\Services\BukuInduk\PesertaDidik;

use App\Imports\StudentsImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportService
{
    public function importStudents($file)
    {
        $importer = new StudentsImport;
        Excel::import($importer, $file);

        if ($importer->hasErrors()) {
            throw new \Exception(session('import_error_file'));
        }
    }
}
