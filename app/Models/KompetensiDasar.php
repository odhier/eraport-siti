<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KompetensiDasar extends Model
{
    use HasFactory;
    protected $fillable = ['course_id', 'tahun_ajaran_id'];

    protected $table = 'kompetensi_dasar';
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
    public function tahun_ajaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id', 'id');
    }
    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'kd_id', 'id');
    }
}
