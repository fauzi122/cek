<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Traits\LogTrait;


class Tugas extends Model
{
    use LogTrait, HasFactory;
   protected $guarded=[];

   public function showMhs($kd_mtk,$kd_lokal)
   {
       
    $mhs = DB::table('mhs')
    ->where('kd_lokal',$kd_lokal)->count();
    
    if($mhs>0){
        $mhs = DB::table('mhs')
        ->where('kd_lokal',$kd_lokal);
        $mhs->get();
}elseif($kd_mtk=='007'||$kd_mtk=='005'||$kd_mtk=='0299'){
    $lokal = DB::table('jadwal')
        ->select( DB::raw('GROUP_CONCAT(kd_lokal) AS kd_lokal'))
        ->where('kd_gabung', '=', $kd_lokal)->first();
        $xx=$lokal->kd_lokal;
        $x = explode(",",$xx);
    $mhs = DB::table('penilaian_agama AS a')
    ->join('mhs AS b','a.nim', '=', 'b.nim')
    ->where('a.kd_mtk',$kd_mtk)
    ->whereIn('b.kd_lokal', $x);
    $mhs->get();

}else{
         $lokal = DB::table('jadwal')
        ->select( DB::raw('GROUP_CONCAT(kd_lokal) AS kd_lokal'))
        ->where('kd_gabung', '=', $kd_lokal)->first();
        $xx=$lokal->kd_lokal;
        $x = explode(",",$xx);
        $mhs = DB::table('mhs')
        ->whereIn('kd_lokal', $x);
        $mhs->get();
}
if($mhs->count()>0){
    foreach($mhs->get() as $i){
    $h[$i->nim]=$i->nm_mhs;
}
    return $h;
}
   }
   public function showMhsMbkm($kd_lokal)
   {
       
    $mhs = DB::table('jadwal_mbkm')
    ->where('kd_lokal',$kd_lokal)->count();
    
    if($mhs>0){
        $mhs = DB::table('jadwal_mbkm')
        ->where('kd_lokal',$kd_lokal);
        $mhs->get();
}else{
         $lokal = DB::table('jadwal_mbkm')
        ->select( DB::raw('GROUP_CONCAT(kd_lokal) AS kd_lokal'))
        ->where('kd_gabung', '=', $kd_lokal)->first();
        $xx=$lokal->kd_lokal;
        $x = explode(",",$xx);
        $mhs = DB::table('jadwal_mbkm')
        ->whereIn('kd_lokal', $x);
        $mhs->get();
}
if($mhs->count()>0){
    foreach($mhs->get() as $i){
    $h[$i->nim]=$i->nm_mhs;
}
    return $h;
}
   }

   public function nilai_mhs($id)
   {
    $nilai = DB::table('tugasmhs as a')
    ->select('a.nim AS nim',
    'a.created_at AS unix_mhs',
    'b.selsai AS unix',
    // DB::raw('IF (a.created_at > b.selsai, "0", "1") as hasil'),
    'a.nilai        AS nilai',
    'a.created_at   AS created_at',
    'a.isi          AS isi',
    'a.komentar     AS komentar')
    ->leftJoin('tugas as b', 'a.id_tugas', '=', 'b.id')
    ->where('a.id_tugas',$id);
    // dd($nilai);
    if($nilai->count()>0){
                    foreach($nilai->get() as $i){
                        $h[$i->nim]=$i;
                }
                return $h;
            }
            else
            {
            return $nilai->get();
            }
   }
}
