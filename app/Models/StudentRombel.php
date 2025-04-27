<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentRombel extends Model
{
    use HasFactory;

    protected $table = 'student_rombel';

    protected $fillable = [
        'siswa_uuid',
        'rombel_id',
        'tahun_pelajaran_id',
        'semester_id',
        'tanggal_masuk',
        'tanggal_keluar',
        'status',
    ];

    public $timestamps = true;


    public function siswa()
    {
        return $this->belongsTo(Student::class, 'siswa_uuid', 'uuid');
    }


    public function rombel()
    {
        return $this->belongsTo(Rombel::class, 'rombel_id');
    }


    public function tahunPelajaran()
    {
        return $this->belongsTo(TahunPelajaran::class, 'tahun_pelajaran_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }
}
