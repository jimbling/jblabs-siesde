<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'nama',
        'nipd',
        'jk',
        'nisn',
        'tempat_lahir',
        'tanggal_lahir',
        'nik',
        'alamat',
        'rt',
        'rw',
        'dusun',
        'kelurahan',
        'kecamatan',
        'kode_pos',
        'telepon',
        'hp',
        'email',
        'skhun',
        'penerima_kps',
        'no_kps',
        'penerima_kip',
        'nomor_kip',
        'nama_di_kip',
        'nomor_kks',
        'no_registrasi_akta',
        'bank',
        'nomor_rekening',
        'rekening_atas_nama',
        'layak_pip',
        'alasan_layak_pip',
        'kebutuhan_khusus',
        'anak_ke',
        'no_kk',
        'jumlah_saudara_kandung',
        'jarak_rumah_km',
        'lintang',
        'bujur',
        'agama_id',
        'alat_transportasi_id',
        'jenis_tinggal_id',
        'riwayat_sekolah_id'
    ];

    // Contoh relasi ke tabel agama
    public function agama()
    {
        return $this->belongsTo(Agama::class);
    }


    public function alatTransportasi()
    {
        return $this->belongsTo(AlatTransportasi::class, 'alat_transportasi_id');
    }

    public function jenisTinggal()
    {
        return $this->belongsTo(JenisTinggal::class, 'jenis_tinggal_id');
    }

    public function orangTuas()
    {
        return $this->belongsToMany(OrangTua::class, 'student_orang_tua', 'siswa_uuid', 'orang_tua_uuid')
            ->withPivot('tipe');
    }
}
