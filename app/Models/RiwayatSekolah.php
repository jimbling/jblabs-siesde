<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatSekolah extends Model
{
    use HasFactory;

    protected $table = 'riwayat_sekolah';

    protected $fillable = [
        'siswa_uuid',
        'sekolah_asal',
        'jenis_pendaftar',
        'tanggal_masuk',
    ];

    public $timestamps = true;


    public function siswa()
    {
        return $this->belongsTo(Student::class, 'siswa_uuid', 'siswa_uuid');
    }
}
