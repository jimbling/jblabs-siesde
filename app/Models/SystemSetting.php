<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class SystemSetting extends Model
{
    // Nama tabel jika tidak sesuai dengan konvensi Laravel (opsional jika pakai nama 'system_settings')
    protected $table = 'system_settings';

    // Isi kolom yang boleh diisi massal
    protected $fillable = [
        'nama_sekolah',
        'npsn',
        'alamat_lengkap',
        'desa_kelurahan',
        'kecamatan',
        'kabupaten_kota',
        'provinsi',
        'negara',
        'kode_pos',
        'website',
        'email',
        'no_telp',
        'kepala_sekolah',
        'nip_kepala_sekolah',
        'logo',
        'favicon',
        'tahun_berdiri',
        'jenjang_pendidikan',
        'status_sekolah',
        'kurikulum_berlaku',
        'kop_sekolah',
        'qrcode_logo',
    ];

    // Jika ingin menonaktifkan timestamps (kalau misal tidak pakai created_at dan updated_at)
    // public $timestamps = false;
}
