<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KompetensiIntiDetail extends Model
{
    use HasFactory;

    protected $table = 'kompetensi_inti_detail';

    public function ki()
    {
        return $this->belongsTo(KompetensiInti::class, 'ki_id', 'id');
    }
}
