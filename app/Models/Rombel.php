<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rombel extends Model
{
    use HasFactory;

    protected $table = 'rombel';

    protected $fillable = [
        'nama',
        'tingkat',
    ];

    public $timestamps = true;

    public function students()
    {
        return $this->hasMany(\App\Models\StudentRombel::class, 'rombel_id')
            ->whereNull('tanggal_keluar') // jika hanya ingin siswa yang masih aktif di rombel ini
            ->with('siswa'); // include data siswa
    }
}
