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
        'kelas',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;


    public function siswa()
    {
        return $this->belongsTo(Student::class, 'siswa_uuid', 'siswa_uuid');
    }
}
