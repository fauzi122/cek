<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ref_cabang extends Model
{
    use HasFactory;
     
    protected $fillable = [
        'kd_kampus',
        'nm_kampus',
        'alm_kampus',
        'kd_cabang',
        'wilayah',
        
        
         
    ];
}
