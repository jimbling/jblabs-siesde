<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisTinggal extends Model
{
    use HasFactory;

    protected $table = 'jenis_tinggal';

    protected $fillable = [
        'nama',
    ];

    // Laravel secara otomatis mengelola kolom created_at dan updated_at
    public $timestamps = true; // Mengaktifkan penggunaan timestamps otomatis
}
