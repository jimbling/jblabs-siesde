<?php

namespace App\Models;

use Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentLog extends Model
{
    use HasFactory;

    protected $table = 'document_logs'; // Sesuaikan dengan nama tabel

    protected $fillable = [
        'uuid',
        'student_id',
        'jenis_dokumen',
        'nomor_dokumen',
        'dicetak_oleh',
        'waktu_cetak',
        'keterangan',
        'jenis',
        'is_valid',
        'short_code',
    ];

    // Relasi dengan model Student
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // Relasi dengan model User (pengguna yang mencetak dokumen)
    public function user()
    {
        return $this->belongsTo(User::class, 'dicetak_oleh');
    }

    // Menyimpan UUID dalam format yang benar
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $uuid = Str::uuid()->toString();
                $model->uuid = $uuid;
                $model->short_code = substr($uuid, 0, 8);

                // Optional: pastikan unik
                while (self::where('short_code', $model->short_code)->exists()) {
                    $uuid = Str::uuid()->toString();
                    $model->uuid = $uuid;
                    $model->short_code = substr($uuid, 0, 8);
                }
            }
        });
    }
}
