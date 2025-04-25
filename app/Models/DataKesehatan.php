<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKesehatan extends Model
{
    use HasFactory;

    protected $table = 'data_kesehatan';

    protected $fillable = [
        'siswa_uuid',
        'tinggi_badan',
        'berat_badan',
        'lingkar_kepala',
    ];

    public function siswa()
    {
        return $this->belongsTo(Student::class, 'siswa_uuid', 'uuid');
    }
}
