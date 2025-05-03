<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Semester extends Model
{
    use HasFactory;

    protected $table = 'semester';

    protected $fillable = [
        'semester',
        'tahun_pelajaran_id',
        'is_aktif',
        'tanggal_mulai',
        'tanggal_selesai',
    ];

    public $timestamps = true;


    public function tahunPelajaran()
    {
        return $this->belongsTo(TahunPelajaran::class);
    }

    public function getTanggalMulaiIndoAttribute()
    {
        return $this->tanggal_mulai ? Carbon::parse($this->tanggal_mulai)->translatedFormat('d F Y') : null;
    }

    public function getTanggalSelesaiIndoAttribute()
    {
        return $this->tanggal_selesai ? Carbon::parse($this->tanggal_selesai)->translatedFormat('d F Y') : null;
    }
}
