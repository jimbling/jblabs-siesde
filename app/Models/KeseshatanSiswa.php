<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KesehatanSiswa extends Model
{
    use HasFactory;

    protected $table = 'kesehatan_siswa';
    protected $fillable = [
        'siswa_uuid',
        'golongan_darah',
        'penyakit_diderita',
        'kelainan_jasmani',
    ];


    public function student()
    {
        return $this->belongsTo(Student::class, 'siswa_uuid', 'uuid');
    }
}
