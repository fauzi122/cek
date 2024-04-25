<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Traits\LogTrait;
class Dosen_pengganti extends Model
{
  use LogTrait, HasFactory;

    protected $table='dosen_pengganti';
    protected $guarded =[];

    public function jadwalDosenpengganti($where,$group)
    {
        return DB::table('dosen_pengganti')
        ->select('dosen_pengganti.kd_dp','dosen_pengganti.tgl_ganti','dosen_pengganti.ket','jadwal.*' )
        ->rightJoin('jadwal', function($join)
            {
                $join->on('dosen_pengganti.kd_lokal', '=', 'jadwal.kd_gabung')->orOn('dosen_pengganti.kd_lokal', '=', 'jadwal.kel_praktek')->orOn('dosen_pengganti.kd_lokal', '=', 'jadwal.kd_lokal');
                $join->on('dosen_pengganti.kd_mtk', '=', 'jadwal.kd_mtk');
                $join->on('dosen_pengganti.kd_dosen', '=', 'jadwal.kd_dosen');
            })
        ->where($where)
        ->groupBy($group);
    }
}
