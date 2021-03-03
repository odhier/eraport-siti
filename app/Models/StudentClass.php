<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model
{
    use HasFactory;
    protected $table = 'student_class';

    protected $fillable = ['id', 'student_id', 'class_id', 'tahun_ajaran_id'];
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
    public function saran()
    {
        return $this->hasMany(Saran::class, 'student_class_id', 'id');
    }
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'student_class_id', 'id');
    }
    public function scopeSelectGroupedWeaponNames($query, $alias)
    {
        $query->addSelect([
            $alias => Absensi::select('absensi.sakit')->where('absensi.semester', 1)->whereColumn('absensi.student_class_id', 'student_class.id')
        ]);
    }
    public function nilai_ki()
    {
        return $this->hasMany(NilaiKI::class, 'student_class_id', 'id');
    }
    public function message_ki()
    {
        return $this->hasMany(MessageKI::class, 'student_class_id', 'id');
    }
}
