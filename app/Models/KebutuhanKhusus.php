<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KebutuhanKhusus extends Model
{
    use HasFactory;

    protected $table = 'kebutuhan_khusus';

    protected $fillable = [
        'nama',
    ];


    public $timestamps = true;
}
