<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageKI extends Model
{
    use HasFactory;
    protected $table = 'messages_ki';
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id', 'id');
    }
    public function student_class()
    {
        return $this->belongsTo(StudentClass::class, 'student_class_id', 'id');
    }
    public function ki()
    {
        return $this->belongsTo(KompetensiInti::class, 'ki_id', 'id');
    }
}
