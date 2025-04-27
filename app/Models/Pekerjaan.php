<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{
    use HasFactory;

    protected $table = 'pekerjaan';

    protected $fillable = [
        'nama',
    ];

    public $timestamps = true;

    public function orangTuas()
    {
        return $this->hasMany(OrangTua::class, 'pekerjaan_id');
    }
}
