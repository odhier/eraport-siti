<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;
    protected $table = 'tahun_ajaran';

    public function teacher_course()
    {
        return $this->hasMany(TeacherCourse::class, 'tahun_ajaran_id', 'id');
    }
    public function student_class()
    {
        return $this->hasMany(StudentClass::class, 'tahun_ajaran_id', 'id');
    }
    public function wali_kelas()
    {
        return $this->hasMany(WaliKelas::class, 'tahun_ajaran_id', 'id');
    }
    public function kompetensi_dasar()
    {
        return $this->hasMany(KompetensiDasar::class, 'tahun_ajaran_id', 'id');
    }
    public function kkm()
    {
        return $this->hasMany(KKM::class, 'tahun_ajaran_id', 'id');
    }
    public function message()
    {
        return $this->hasMany(Message::class, 'tahun_ajaran_id', 'id');
    }
}
