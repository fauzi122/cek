<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mtk_ujian;

class Perakit_soal extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function mtkUjian()
    {
        return $this->belongsTo(Mtk_ujian::class, 'kd_mtk', 'kd_mtk');
    }
}
