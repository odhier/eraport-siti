<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiKI extends Model
{
    use HasFactory;

    protected $table = 'nilai_ki';
    public function ki()
    {
        return $this->belongsTo(KompetensiIntiDetail::class, 'ki_detail_id', 'id');
    }
    public function student_class()
    {
        return $this->belongsTo(StudentClass::class, 'student_class_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'teacher_id', 'id');
    }
}
