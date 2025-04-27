<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penghasilan extends Model
{
    use HasFactory;

    protected $table = 'penghasilan';

    protected $fillable = [
        'rentang',
    ];

    public $timestamps = true;

    public function orangTuas()
    {
        return $this->hasMany(OrangTua::class, 'penghasilan_id');
    }
}
