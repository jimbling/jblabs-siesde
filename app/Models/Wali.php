<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wali extends Model
{
    use HasFactory;

    protected $table = 'wali';

    protected $fillable = [
        'siswa_uuid',
        'nama',
        'tahun_lahir',
        'pendidikan_id',
        'pekerjaan_id',
        'penghasilan_id',
        'nik',
    ];

    public $timestamps = true;

    /**
     * Relasi ke model Siswa
     */
    public function siswa()
    {
        return $this->belongsTo(Student::class, 'siswa_uuid', 'siswa_uuid');
    }

    /**
     * Relasi ke model Pendidikan
     */
    public function pendidikan()
    {
        return $this->belongsTo(Pendidikan::class, 'pendidikan_id', 'id');
    }

    /**
     * Relasi ke model Pekerjaan
     */
    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class, 'pekerjaan_id', 'id');
    }

    /**
     * Relasi ke model Penghasilan
     */
    public function penghasilan()
    {
        return $this->belongsTo(Penghasilan::class, 'penghasilan_id', 'id');
    }
}
