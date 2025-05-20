<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentStatusSeeder extends Seeder
{
    public function run(): void
    {
        Student::doesntHave('statusHistories')->each(function ($student) {
            $student->statusHistories()->create([
                'status' => 'aktif',
                'tanggal' => now(),
                'alasan' => 'Inisialisasi status awal',
            ]);
        });
    }
}
