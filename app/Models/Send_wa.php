<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Send_wa extends Model
{
    protected $fillable=
    [
        
        'kd_mtk',
        'kd_lokal',
        'kd_dosen',
        'nm_grup',
        'sts_wa',
        'created_at',
        'updated_at'
        
    ];
}
