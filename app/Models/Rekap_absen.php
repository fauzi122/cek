<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Rekap_absen extends Model
{
    public function get_editrekap($w_cektemu)
    {
        return $jadwal = DB::table('absen_ajar_prakteks')
        ->where($w_cektemu);
    }
    public function get_editrekap_teori($w_cektemu)
    {
        return $jadwal = DB::table('absen_ajars')
        ->where($w_cektemu);
    }


    public function get_rekapabsen_mhs_ext($w_rekapmhs)
    {
        return $jadwal = DB::table('absen_mhs as a')
        ->select('a.nip','a.nim AS nim','a.kd_mtk AS kd_mtk','b.nm_mhs AS nm_mhs','a.kd_lokal AS kd_lokal','a.kel_praktek AS kel_praktek','a.kd_gabung AS kd_gabung',
        DB::raw("CONCAT(
            '{',
            GROUP_CONCAT(
              CONCAT(
                '\"P',
                a.pertemuan,
                '\":',
                a.status_hadir
              ) SEPARATOR ','
            ),
            '}'
          ) AS rwyhadir"),
        DB::raw('SUM(IF(a.status_hadir = 1, 1, 0)) AS jml_hadir'),
        DB::raw('SUM(IF(a.status_hadir = 0, 1, 0)) AS jml_absen'),
        DB::raw('MAX(a.pertemuan) AS totalpertemuan'),
        DB::raw('SUM(IF(a.status_hadir = 1, 1, 0)) * 100 / MAX(a.pertemuan) AS prosentase')
        )
        ->leftJoin('mhs as b', 'a.nim', '=', 'b.nim')
        ->where($w_rekapmhs)
        ->groupBy('a.nim','a.kd_mtk')->get();
        // dd($jadwal);
    }
    
    public function get_mtk($kdmtk)
    {
        return $jadwal = DB::table('mtk')
        ->where('kd_mtk', '=', $kdmtk)->get();
    }



}
