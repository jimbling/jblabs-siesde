<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunPelajaran extends Model
{
    use HasFactory;

    protected $table = 'tahun_pelajaran';

    protected $fillable = [
        'tahun_ajaran',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    public $timestamps = true;


    public function semesters()
    {
        return $this->hasMany(Semester::class);
    }
}
