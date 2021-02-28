<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilai';
    protected $fillable = ['student_class_id', 'semester', 'kd_id', 'teacher_id', 'NH', 'NUTS', 'NUAS', 'created_at', 'updated_at'];
    public function kd()
    {
        return $this->belongsTo(KompetensiDasar::class, 'kd_id', 'id');
    }
    public function student_class()
    {
        return $this->belongsTo(StudentClass::class, 'student_class_id', 'id');
    }
}
