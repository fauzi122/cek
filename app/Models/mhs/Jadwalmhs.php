<?php

namespace App\Models\mhs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Query\JoinClause;

class Jadwalmhs extends Model
{
    public function jadwal($kd_lokal,$nim)
    {
        return DB::table('penilaian')
        ->select('penilaian.kel_praktek','penilaian.nim','penilaian.kd_mtk','jadwal.*' )
        ->LeftJoin('jadwal','penilaian.kd_mtk', '=', 'jadwal.kd_mtk')
        ->where('penilaian.kel_praktek','=','')
        ->where('jadwal.kd_lokal',$kd_lokal)
        ->where('penilaian.nim',$nim); 
    }
    public function jadwal_km($kd_lokal,$nim)
    {
        return DB::table('jadwal_mbkm')
        ->select('jadwal_mbkm.kel_praktek','jadwal_mbkm.nim','jadwal_mbkm.kd_mtk','jadwal.*' )
        ->LeftJoin('jadwal', function ($join) {
            $join->on('jadwal_mbkm.kd_mtk', '=', 'jadwal.kd_mtk');
            $join->on('jadwal_mbkm.kd_dosen', '=', 'jadwal.kd_dosen');
            $join->on('jadwal_mbkm.kd_lokal', '=', 'jadwal.kd_lokal');
        })
        // ->LeftJoin('jadwal','jadwal_mbkm.kd_mtk', '=', 'jadwal.kd_mtk')
        ->whereNull('jadwal_mbkm.kel_praktek')
        ->where('jadwal_mbkm.kd_lokal_mbkm',$kd_lokal)
        ->where('jadwal_mbkm.nim',$nim)
        ->groupBy('jadwal_mbkm.kd_mtk'); 
    }
    public function jadwal_km_praktek($kd_lokal,$nim)
    {
        return DB::table('jadwal_mbkm')
        ->select('jadwal_mbkm.kel_praktek','jadwal_mbkm.nim','jadwal_mbkm.kd_mtk','jadwal.*' )
        ->LeftJoin('jadwal', function ($join) {
            $join->on('jadwal_mbkm.kd_mtk', '=', 'jadwal.kd_mtk');
            $join->on('jadwal_mbkm.kd_dosen', '=', 'jadwal.kd_dosen');
            $join->on('jadwal_mbkm.kel_praktek', '=', 'jadwal.kel_praktek');
        })
        // ->LeftJoin('jadwal','jadwal_mbkm.kd_mtk', '=', 'jadwal.kd_mtk')
        ->whereNotNull ('jadwal_mbkm.kel_praktek')
        ->where('jadwal_mbkm.kd_lokal_mbkm',$kd_lokal)
        ->where('jadwal_mbkm.nim',$nim)
        ->groupBy('jadwal_mbkm.kd_mtk'); 
    }
    public function jadwal_pengganti($kd_lokal,$nim)
    {
        return DB::table('penilaian')
        ->select('penilaian.kel_praktek','penilaian.nim','penilaian.kd_mtk','kuliah_pengganti.*' )
        ->LeftJoin('kuliah_pengganti','penilaian.kd_mtk', '=', 'kuliah_pengganti.kd_mtk')
        ->where('penilaian.kel_praktek','=','')
        ->where('kuliah_pengganti.kd_lokal',$kd_lokal)
        ->where('penilaian.nim',$nim); 
    }
    public function jadwal_praktek($kd_lokal,$nim)
    {
        
        // dd($kd_lokal);
        return DB::table('penilaian')
        ->select('penilaian.kel_praktek','penilaian.nim','penilaian.kd_mtk','jadwal.*' )
        // ->leftJoin('mtk','penilaian.kd_mtk', '=', 'mtk.kd_mtk')
        ->join('jadwal','penilaian.kel_praktek', '=', 'jadwal.kel_praktek')
        ->where('penilaian.kel_praktek','<>','')
        ->where('jadwal.kd_lokal',$kd_lokal)
        ->where('penilaian.nim',$nim); 

    }
    public function jadwal_praktek_km($kd_lokal,$nim)
    {
        
        // dd($kd_lokal);
        $kd_lokal_km = DB::table('kd_lokal_km')->where('kd_lokal_km','=',$kd_lokal)->get();
        foreach($kd_lokal_km as $lokal_km){
            return $post_km=DB::table('penilaian')
        ->select('penilaian.kel_praktek','penilaian.nim','penilaian.kd_mtk','jadwal.*' )
        ->join('jadwal','penilaian.kel_praktek', '=', 'jadwal.kel_praktek')
        ->where('penilaian.kel_praktek','<>','')
        ->where('jadwal.kd_lokal',$lokal_km->kd_lokal)
        ->where('penilaian.nim',$nim); 
        // dump($post);
        // dd($post_km->first());
        }
        // return $post_km;

    }
    public function jadwal_praktek_pengganti($kd_lokal,$nim)
    {
        
        // dd($kd_lokal);
        return DB::table('penilaian')
        ->select('penilaian.kel_praktek','penilaian.nim','penilaian.kd_mtk','kuliah_pengganti.*' )
        // ->leftJoin('mtk','penilaian.kd_mtk', '=', 'mtk.kd_mtk')
        ->join('kuliah_pengganti','penilaian.kel_praktek', '=', 'kuliah_pengganti.kel_praktek')
        ->where('penilaian.kel_praktek','<>','')
        ->where('kuliah_pengganti.kel_praktek', 'like', "%".$kd_lokal."%")
        ->where('penilaian.nim',$nim); 

    }
    public function jadwal_gabung_pengganti($kd_lokal,$nim)
    {
        
        // dd($kd_lokal);
        return DB::table('penilaian')
        ->select('penilaian.kel_praktek','penilaian.nim','penilaian.kd_mtk','kuliah_pengganti.*' )
        // ->leftJoin('mtk','penilaian.kd_mtk', '=', 'mtk.kd_mtk')
        ->join('kuliah_pengganti','penilaian.kd_mtk', '=', 'kuliah_pengganti.kd_mtk')
        // ->where('penilaian.kd_gabung','<>','')
        ->where('kuliah_pengganti.detail_gabung', 'like', "%".$kd_lokal."%")
        // ->where('kuliah_pengganti.kd_lokal',$kd_lokal)
        ->where('penilaian.nim',$nim); 

    }
    public function rekap_absen($id)
    {
        $exp = explode(",",Crypt::decryptString($id));
        $where=['a.kel_praktek'=>$exp[4],'a.kd_mtk'=>$exp[0],'b.nim'=>Auth::user()->username];
        return DB::table('absen_ajar_prakteks as a')
        ->select('a.tgl_ajar_masuk as tgl_ajar_masuk','a.nm_mtk as nm_mtk','a.pertemuan as pertemuan','a.berita_acara as berita_acara','a.rangkuman as rangkuman','b.status_hadir as status_hadir')
        ->LeftJoin('absen_mhs as b', 'a.kel_praktek', '=', 'b.kel_praktek')
        ->where($where);
    }
    // public function cek_ajar($kd_lokal,$nim)
    // {
    //     return DB::table('absen_ajar')
    //     ->where('kd_lokal',$kd_lokal)
    //     ->where('penilaian.nim',$nim)
    //     ->get(); 
    // }
    // public function absen_ajar($kd_lokal,$tgl)
    // {

    //         $ajar= DB::table('absen_ajars')
    //         ->where('kd_lokal',$kd_lokal)
    //         ->where('tgl_ajar_masuk',$tgl); 
    //     if($ajar->count()>0){
    //         foreach($ajar->get() as $i){
    //             $h[$i->kd_mtk]=$i;
    //     }
    //     return $h;
    // }
    // else
    // {
    // return $ajar->get();
    // }

    // }

    // public function absen_ajar_praktek($kd_lokal,$tgl)
    // {
    //     $jadwal = DB::table('jadwal')
    //     ->where('kd_lokal',$kd_lokal)->first();
    //     dd($jadwal);
    //         $ajar= DB::table('absen_ajar_prakteks')
    //         ->where('kel_praktek',$jadwal->kel_praktek)
    //         ->where('tgl_ajar_masuk',$tgl); 
    //     if($ajar->count()>0){
    //         foreach($ajar->get() as $i){
    //             $h[$i->kd_mtk]=$i;
    //     }
    //     return $h;
    // }
    // else
    // {
    // return $ajar->get();
    // }

    // }


}
