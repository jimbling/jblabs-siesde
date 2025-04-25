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
    ];


    public $timestamps = true;

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_orang_tua', 'orang_tua_uuid', 'siswa_uuid')
            ->withPivot('tipe');
    }
}
