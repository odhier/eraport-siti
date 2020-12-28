<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model
{
    use HasFactory;
    protected $table = 'student_class';
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
    public function tahun_ajaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id', 'id');
    }
    public function classes()
    {
        return $this->belongsTo(Classes::class, 'class_id', 'id');
    }
    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'student_class_id', 'id');
    }
    public function message()
    {
        return $this->hasMany(Message::class, 'student_class_id', 'id');
    }
}
