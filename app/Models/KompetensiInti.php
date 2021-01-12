<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KompetensiInti extends Model
{
    use HasFactory;
    protected $table = 'kompetensi_inti';
    public function ki_detail()
    {
        return $this->hasMany(KompetensiIntiDetail::class, 'ki_id', 'id');
    }
}
