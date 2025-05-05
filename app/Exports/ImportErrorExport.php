<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class ImportErrorExport implements FromCollection
{
    protected $errors;

    public function __construct(array $errors)
    {
        $this->errors = $errors;
    }

    public function collection()
    {
        return collect($this->errors);
    }
}
