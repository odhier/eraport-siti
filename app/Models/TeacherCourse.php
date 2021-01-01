<?php

namespace App\Models;

use App\Models\Course;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherCourse extends Model
{
    use HasFactory;

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
    public function classes()
    {
        return $this->belongsTo(Classes::class, 'class_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'teacher_id', 'id');
    }
    public function tahun_ajaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id', 'id');
    }
    public function last_course()
    {
        return $this->hasMany(LastCourse::class, 'teacher_course_id', 'id');
    }
    protected $table = 'teacher_course';
}
