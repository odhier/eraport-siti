<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;
    protected $table = 'absensi';
    public function student_class()
    {
        return $this->belongsTo(StudentClass::class, 'student_class_id', 'id');
    }
}
