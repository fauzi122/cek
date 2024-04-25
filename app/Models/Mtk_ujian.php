<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Perakit_soal;

class Mtk_ujian extends Model
{
    // use HasFactory;
    protected $table='mtk_ujians';
    protected $guarded=[];

    public function perakitSoal()
    {
        return $this->hasMany(Perakit_soal::class, 'kd_mtk', 'kd_mtk');
    }
}
