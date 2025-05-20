<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_uuid',
        'status',
        'tanggal',
        'alasan',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_uuid', 'uuid');
    }
}
