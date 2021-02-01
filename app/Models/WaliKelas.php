<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaliKelas extends Model
{
    use HasFactory;

    protected $table = 'wali_kelas';

    public function user()
    {
        return $this->belongsTo(User::class, 'teacher_id', 'id');
    }
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id', 'id');
    }
    public function tahun_ajaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id', 'id');
    }
}
