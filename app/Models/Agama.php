<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agama extends Model
{
    protected $table = 'agama'; // pastikan nama tabelnya benar ('agama', bukan 'agamas')

    protected $fillable = ['nama'];

    public function siswa()
    {
        return $this->hasMany(Student::class);
    }
}
