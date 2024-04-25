<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaysSetting extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'kd_pt',
        'periode_aktif',
        'logo',
        'nama_pt',
        'link',
        'telp',
        'email',
        'mysimliz_periode',
        'mysimliz_buka',
        'mysimliz_tutup',
        'status_setting',

        
         
    ];
}

