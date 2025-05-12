<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrangTua extends Model
{
    use HasFactory;

    protected $table = 'orang_tua';

    protected $fillable = [
        'siswa_uuid',
        'tipe',
        'nama',
        'tahun_lahir',
        'pendidikan_id',
        'pekerjaan_id',
        'penghasilan_id',
        'nik',
        'kewarganegaraan',
    ];


    public $timestamps = true;

    public function student()
    {
        return $this->belongsTo(Student::class, 'siswa_uuid', 'uuid');
    }


    public function pendidikan()
    {
        return $this->belongsTo(Pendidikan::class, 'pendidikan_id');
    }

    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class, 'pekerjaan_id');
    }

    public function penghasilan()
    {
        return $this->belongsTo(Penghasilan::class, 'penghasilan_id');
    }
}
