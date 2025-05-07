<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoSiswa extends Model
{
    use HasFactory;

    protected $table = 'foto_siswa';

    protected $fillable = [
        'siswa_uuid',
        'path_foto',
        'tahun_pelajaran_id',
        'rombel_id',
        'semester_id',
        'path_foto',
        'path_foto_asli',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;


    public function siswa()
    {
        return $this->belongsTo(Student::class, 'siswa_uuid', 'uuid');
    }

    public function tahunPelajaran()
    {
        return $this->belongsTo(TahunPelajaran::class, 'tahun_pelajaran_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    public function rombel()
    {
        return $this->belongsTo(Rombel::class, 'rombel_id');
    }
}
