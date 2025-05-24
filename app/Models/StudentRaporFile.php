<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentRaporFile extends Model
{
    protected $fillable = [
        'student_uuid',
        'tahun_pelajaran_id',
        'semester_id',
        'nama_file', // Sekarang ini saja yang digunakan
        'file_id_drive',
        'mime_type',
        'drive_url',
    ];


    public function tahunPelajaran()
    {
        return $this->belongsTo(TahunPelajaran::class, 'tahun_pelajaran_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
