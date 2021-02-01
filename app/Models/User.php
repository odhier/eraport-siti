<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'picture',
        'NIP',
        'user_type',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }
    public function teacher_course()
    {
        return $this->hasMany(TeacherCourse::class, 'teacher_id', 'id');
    }
    public function wali_kelas()
    {
        return $this->hasMany(WaliKelas::class, 'teacher_id', 'id');
    }
    public function last_course()
    {
        return $this->hasMany(LastCourse::class, 'teacher_id', 'id');
    }
    public function nilai_ki()
    {
        return $this->hasMany(NilaiKI::class, 'teacher_id', 'id');
    }
    public function message_ki()
    {
        return $this->hasMany(MessageKI::class, 'teacher_id', 'id');
    }
}
