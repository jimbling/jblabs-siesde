<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatRombel extends Model
{
    use HasFactory;

    protected $table = 'riwayat_rombel';

    protected $fillable = [
        'siswa_uuid',
        'rombel_id',
        'tahun',
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
     * Relasi ke model Rombel
     */
    public function rombel()
    {
        return $this->belongsTo(Rombel::class, 'rombel_id', 'id');
    }
}
