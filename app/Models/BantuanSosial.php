<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BantuanSosial extends Model
{
    use HasFactory;

    protected $table = 'bantuan_sosial';

    protected $fillable = [
        'siswa_uuid',
        'penerima_kps',
        'no_kps',
        'penerima_kip',
        'no_kip',
        'nama_di_kip',
        'no_kks',
        'layak_pip',
        'alasan_layak_pip',
    ];

    public function siswa()
    {
        return $this->belongsTo(Student::class, 'siswa_uuid', 'uuid');
    }
}
