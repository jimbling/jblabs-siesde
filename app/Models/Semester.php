<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $table = 'semester';

    protected $fillable = [
        'semester',
        'tahun_pelajaran_id',
    ];

    public $timestamps = true;


    public function tahunPelajaran()
    {
        return $this->belongsTo(TahunPelajaran::class);
    }
}
