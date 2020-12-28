<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    public function student_class()
    {
        return $this->hasMany(StudentClass::class, 'student_id', 'id');
    }
}
