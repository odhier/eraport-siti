<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Physique extends Model
{
    use HasFactory;
    protected $table = 'physique';
    protected $fillable = ['student_class_id', 'semester', 'tinggi', 'berat', 'pendengaran', 'penglihatan', 'gigi'];
    public function student_class()
    {
        return $this->belongsTo(StudentClass::class, 'student_class_id', 'id');
    }
}
