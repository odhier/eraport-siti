<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TeacherCourse;

class Course extends Model
{
    use HasFactory;
    public function teacher_course()
    {
        return $this->hasMany(TeacherCourse::class, 'course_id', 'id');
    }
    public function kompetensi_dasar()
    {
        return $this->hasMany(KompetensiDasar::class, 'course_id', 'id');
    }
    public function kkm()
    {
        return $this->hasMany(KKM::class, 'course_id', 'id');
    }
    public function message()
    {
        return $this->hasMany(Message::class, 'course_id', 'id');
    }
}
