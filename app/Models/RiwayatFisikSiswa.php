<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatFisikSiswa extends Model
{
    use HasFactory;

    protected $table = 'riwayat_fisik_siswa';
    protected $fillable = [
        'siswa_uuid',
        'semester_id',
        'tinggi_badan',
        'berat_badan',
        'lingkar_kepala',
    ];


    public function student()
    {
        return $this->belongsTo(Student::class, 'siswa_uuid', 'uuid');
    }


    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
