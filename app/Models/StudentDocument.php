<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentDocument extends Model
{
    use HasFactory;

    protected $table = 'student_documents';

    protected $fillable = [
        'student_id',
        'tipe_dokumen',
        'path_file',
        'keterangan',
        'tanggal_upload',
    ];

    protected $casts = [
        'tanggal_upload' => 'datetime',
    ];

    // Relasi ke model Student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Accessor untuk path file full (misal jika pakai storage)
    public function getFileUrlAttribute()
    {
        // Pastikan path_file tidak null
        return $this->path_file ? Storage::disk('public')->url($this->path_file) : null;
    }



    public function getTypeNameAttribute()
    {
        $types = [
            'kk' => 'Kartu Keluarga',
            'akta_kelahiran' => 'Akta Kelahiran',
            'surat_pindah' => 'Surat Pindah',
            'ijazah_tk' => 'Ijazah TK',
            'ijazah_sd' => 'Ijazah SD',
            'lainnya' => 'Lainnya'
        ];

        return $types[$this->tipe_dokumen] ?? 'Unknown';
    }

    public function getTanggalUploadIndoAttribute()
    {
        return Carbon::parse($this->tanggal_upload)
            ->timezone('Asia/Jakarta') // pastikan ke WIB
            ->translatedFormat('l, d F Y H:i') . ' WIB';
    }
}
