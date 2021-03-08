<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekstrakurikuler extends Model
{
    use HasFactory;

    protected $table = 'ekstrakurikuler';
    protected $fillable = ['student_class_id', 'semester'];
    public function student_class()
    {
        return $this->belongsTo(StudentClass::class, 'student_class_id', 'id');
    }
    public function detail()
    {
        return $this->hasMany(EkstrakurikulerDetail::class, 'ekstrakurikuler_id', 'id');
    }
}
