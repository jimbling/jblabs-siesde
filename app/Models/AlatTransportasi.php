<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class AlatTransportasi extends Model
{
    protected $table = 'alat_transportasi';

    protected $fillable = ['nama'];

    public function siswa()
    {
        return $this->hasMany(Student::class);
    }
}
