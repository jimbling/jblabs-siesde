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
        'nama_sekolah',
        'jenis',
    ];

    public $timestamps = true;

    /**
     * Relasi ke model Siswa
     */
    public function siswa()
    {
        return $this->belongsTo(Student::class, 'siswa_uuid', 'siswa_uuid');
    }
}
