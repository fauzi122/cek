<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
// use App\Models\PenilaianSisfo;


class MhsSisfo extends Model
{
    protected $table='mhs';
    protected $guarded=[];
    protected $connection = 'sisfo.bsi';

    public function PenilaianSisfo()
    {
        return $this->hasMany(PenilaianSisfo::class,'nim','nim')
        // ->join('mhs as b', 'penilaian.nim', '=', 'b.nim')
        // ->whereRaw("(MID(penilaian.no_krs, 6,1) IN ($smt) OR MID(penilaian.no_krs, 7,1) IN ($smt))")
        // ->whereRaw("(MID(penilaian.no_krs, 6,1)=MID(b.kd_lokal, 4,1) OR MID(penilaian.no_krs, 7,1)=MID(b.kd_lokal, 4,1))")
        // ->where('b.kondisi',1)
        ;
    }
}
