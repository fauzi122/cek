<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Traits\LogTrait;
class Absen_mbkm extends Model
{
    use LogTrait, HasFactory;
    protected $guarded=[];

    public function jadwal_all($where,$group)
    {
        return DB::table('jadwal_mbkm')
        ->select('jadwal_mbkm.kel_praktek','jadwal_mbkm.nim','jadwal_mbkm.kd_mtk','jadwal_mbkm.kd_lokal_mbkm','jadwal.*' )
        ->join('jadwal', function($join)
                         {
                             $join->on('jadwal_mbkm.kd_lokal', '=', 'jadwal.kd_lokal');
                             $join->on('jadwal_mbkm.kd_mtk', '=', 'jadwal.kd_mtk');
                             $join->on('jadwal_mbkm.kd_dosen', '=', 'jadwal.kd_dosen');
                         })
        ->where($where)
        ->groupBy($group);
    }
    public function showMhsMbkm($kd_lokal,$pertemuan,$kd_mtk)
    {
        // dd($kd_lokal.$pertemuan.$kd_mtk);
        $mhs = DB::table('jadwal_mbkm as a')
        ->select('a.nim AS nim','a.nm_mhs AS nm_mhs')
        ->Join('absen_ajars as b', 'a.kd_lokal', '=', 'b.kd_lokal')
        ->where('b.kd_lokal', $kd_lokal)
        ->where('b.pertemuan', $pertemuan)
        ->where('a.kd_mtk', $kd_mtk)
        ->groupBy('a.nim');
        $mhs->get();
        if($mhs->count()>0){
            foreach($mhs->get() as $i){
            $h[$i->nim]=$i->nm_mhs;
        }
            return $h;
        }
    }
    public function jumlah_mhsMbkm($kd_lokal,$kd_mtk)
    {
        return $mhs = DB::table('jadwal_mbkm')
            ->where('kd_mtk', $kd_mtk)
            ->where('kd_lokal', $kd_lokal)->count();
           
    }
    public function jml_mhs_mbkm($kd_lokal)
    {
        return $mhs = DB::table('jadwal_mbkm')
            ->where('kd_lokal', $kd_lokal)
            ->groupBy('nim')->count();
           
    }
    public function showMhs($kd_lokal,$kd_mtk)
    {
        $lokal = DB::table('jadwal')
             ->select( DB::raw('GROUP_CONCAT(kd_lokal) AS kd_lokal'))
            ->where('kd_gabung', '=', $kd_lokal)->first();
            $xx=$lokal->kd_lokal;
            $x = explode(",",$xx);
        $mhs = DB::table('jadwal_mbkm')
            ->select('nim AS nim',
            DB::raw('UCASE(nm_mhs) AS nm_mhs'),
            'kd_lokal     AS kd_lokal'
           )
            ->whereIn('kd_lokal', $x)
            ->where('kd_mtk', '=', $kd_mtk);
            $mhs->get();
            if($mhs->count()>0){
                foreach($mhs->get() as $i){
                    $h[$i->nim]=$i;
                }
                return $h;
                }
             
    }
    public function showMhsPraktek($w_showMhs)
    {
        $mhs = DB::table('jadwal_mbkm as a')
            ->select('a.nim AS nim',
            DB::raw('UCASE(a.nm_mhs) AS nm_mhs'),
            'd.pertemuan    AS pertemuan',
            'd.jam_t        AS jam_t',
            'd.hari_ajar_masuk      AS hari_t',
            'd.kd_mtk      AS kd_mtk',
            'a.kel_praktek      AS kel_praktek')
            ->leftJoin('absen_ajar_prakteks as d', 'a.kel_praktek', '=', 'd.kel_praktek')
            ->where($w_showMhs);
            $mhs->get();
            if($mhs->count()>0){
                foreach($mhs->get() as $i){
                    $h[$i->nim]=$i->nm_mhs;
                }
                return $h;
                }
             
    }
    public function cek_bap($where)
    {
        return $jadwal = DB::table('absen_ajars')
        ->where($where);
    }
    public function jumlah_mhs($kd_lokal)
    {
        return $mhs = DB::table('mhs')
            ->where('kondisi', '=', '1')
            ->where('kd_lokal', '<>', '')
            ->where('kd_lokal', $kd_lokal)->count();
           
    }
    public function jml_hadir($kd_lokal,$kd_mtk,$pert)
    {
        $where=['kd_lokal'=>$kd_lokal,'kd_mtk'=>$kd_mtk,'pertemuan'=>$pert,'status_hadir'=>'1'];
        return $mahasiswa = DB::table('absen_mhs')
        ->where($where)->count();
    }
    public function mhs_hadir($kd_lokal,$kd_mtk,$pert)
    {
        $where=['kd_lokal'=>$kd_lokal,'kd_mtk'=>$kd_mtk,'pertemuan'=>$pert,'status_hadir'=>'1'];
        // dd($where);
         $mahasiswa = DB::table('absen_mhs')
        ->where($where);
        if($mahasiswa->count()>0){
                        foreach($mahasiswa->get() as $i){
                            $h[$i->nim]=$i;
                    }
                    return $h;
                }
                else
                {
                return $mahasiswa->get();
                }
    }
    public function temu_ajar($w_showMhs)
    {
     return $mhs = DB::table('absen_ajars')
     ->select('pertemuan','berita_acara','file_ajar','nip','rangkuman')
     ->where($w_showMhs)
     ->orderByDesc('pertemuan')
     ->limit(1)
     ->get();
    }
    public function jadwal($where)
    {
        return $jadwal = DB::table('jadwal')
        ->where($where);
    }
}
