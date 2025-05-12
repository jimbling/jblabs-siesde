<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatSekolah extends Model
{
    use HasFactory;

    protected $table = 'riwayat_sekolah';

    protected $fillable = [
        'siswa_uuid',
        'sekolah_asal',
        'jenis_pendaftar',
        'tanggal_masuk',
        'alasan_pindah',
        'catatan_kembali',
        'dari_sekolah',
        'lama_belajar',
        'nomor_ijazah',
        'tanggal_ijazah',
        'kelas_diterima',
    ];

    public $timestamps = true;


    public function siswa()
    {
        return $this->belongsTo(Student::class, 'siswa_uuid', 'siswa_uuid');
    }

    // Accessor untuk tanggal_ijazah
    public function getTanggalIjazahIndoAttribute()
    {
        return $this->tanggal_ijazah ? Carbon::parse($this->tanggal_ijazah)->translatedFormat('d F Y') : null;
    }

    // Accessor untuk tanggal_masuk
    public function getTanggalMasukIndoAttribute()
    {
        return $this->tanggal_masuk ? Carbon::parse($this->tanggal_masuk)->translatedFormat('d F Y') : null;
    }
}
