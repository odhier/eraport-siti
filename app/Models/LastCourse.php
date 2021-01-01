<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LastCourse extends Model
{
    use HasFactory;

    protected $table = 'last_course';

    public function teacher_course()
    {
        return $this->belongsTo(TeacherCourse::class, 'teacher_course_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'teacher_id', 'id');
    }
}
