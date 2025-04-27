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


    public $timestamps = true;
}
