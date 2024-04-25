<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogTrait;

class Panitiaujian extends Model
{
    use LogTrait, HasFactory;
    protected $table="absen_ujian_ajars";
    protected $guarded=[];

    public function jadwalUjian($where,$group)
    {
        return $jadwal = DB::table('jadwal_ujian')
        ->where($where)
        ->groupBy($group);
    }

    public function cek_jam($where,$jam)
    {
        return $jadwal = DB::table('jadwal_ujian')
        ->where('mulai', '<', $jam)
        ->where('selesai', '>', $jam)
        ->where($where);
    }

    public function cek_bap($where)
    {
        return $jadwal = DB::table('absen_ujian_ajars')
        ->where($where);
    }

    public function showMhs($kd_lokal)
    {
        $mhs = DB::connection('kampus.id')->table('b51users')
            ->where('kd_lokal',$kd_lokal);
            $mhs->get();
            if($mhs->count()>0){
                    foreach($mhs->get() as $i){
                    $h[$i->userid]=$i->user_firstname;
                }
                    return $h;
                }
    }

    public function jumlah_mhs($kd_lokal)
    {
        return $mhs = DB::connection('kampus.id')->table('b51users')
            ->where('kd_lokal', $kd_lokal)->count();
           
    }

    public function jml_hadir($kd_lokal,$kd_mtk,$pert)
    {
        $mtk=$kd_mtk.'0';
        return DB::connection('kampus.id')->table('b51results as a')
        ->join('b51users as b', 'a.userid', '=', 'b.userid')
        ->join('b51tests as c', 'a.testid', '=', 'c.testid')
        ->where('b.kd_lokal', $kd_lokal)
        ->where('c.test_code', $mtk)->count();
    }

    public function mhs_hadir($kd_lokal,$kd_mtk,$pert)
    {
        $mtk=$kd_mtk.'0';
        $mahasiswa = DB::connection('kampus.id')->table('b51results as a')
        ->join('b51users as b', 'a.userid', '=', 'b.userid')
        ->join('b51tests as c', 'a.testid', '=', 'c.testid')
        ->where('b.kd_lokal', $kd_lokal)
        ->where('c.test_code', $mtk);
        if($mahasiswa->count()>0){
                        foreach($mahasiswa->get() as $i){
                            $h[$i->userid]=$i;
                    }
                    return $h;
                }
                else
                {
                return $mahasiswa->get();
                }
    }
    public function stsMhs($kd_lokal,$kd_mtk)
    {
        $mtk=$kd_mtk.'0';
        $mahasiswa = DB::connection('kampus.id')->table('b51groups_users')
        ->whereRaw('LEFT(kelompok,8)="'.$kd_lokal.'"')
        ->where('kd_soal', $mtk);
        if($mahasiswa->count()>0){
                        foreach($mahasiswa->get() as $i){
                            $h[$i->userid]=$i;
                    }
                    return $h;
                }
                else
                {
                return $mahasiswa->get();
                }
    }

    public function jadwal($where)
    {
        return $jadwal = DB::table('jadwal_ujian')
        ->where($where);
    }

    public function groupUser()
    {
        return DB::connection('kampus.id')->select("SELECT * FROM `b51groups_users` LIMIT 1");
    }

    public function cek_jam_keluar($where,$jam)
    {
        return $jadwal = DB::table('jadwal_ujian')
        ->where('selesai_interval', '<=', $jam)
        ->where('selesai', '>=', $jam)
        ->where($where);
    // ->groupBy($group);
    }

    public function temu_ajar($w_showMhs)
   {
    return $mhs = DB::table('absen_ujian_ajars')
    ->select('pertemuan','berita_acara','file_ajar','nip','rangkuman')
    ->where($w_showMhs)
    ->orderByDesc('pertemuan')
    ->limit(1)
    ->get();
   }

   public function showMhsgabung($kd_lokal,$kd_mtk)
    {
        $lokal = DB::table('jadwal_ujian')
             ->select( DB::raw('GROUP_CONCAT(kd_lokal) AS kd_lokal'))
            ->where('kd_gabung', '=', $kd_lokal)->first();
            $xx=$lokal->kd_lokal;
            $x = explode(",",$xx);
            $mtk=$kd_mtk.'0';

        $mhs = DB::connection('kampus.id')->table('b51users')
            ->whereIn('kd_lokal',$x);
            $mhs->get();
            if($mhs->count()>0){
                    foreach($mhs->get() as $i){
                    $h[$i->userid]=$i;
                }
                    return $h;
                }
             
    }
    public function jmlMhsgabung($kd_lokal)
    {
        $lokal = DB::table('jadwal_ujian')
             ->select( DB::raw('GROUP_CONCAT(kd_lokal) AS kd_lokal'))
            ->where('kd_gabung', '=', $kd_lokal)->first();
            $xx=$lokal->kd_lokal;
            $x = explode(",",$xx);
        return $mhs = DB::connection('kampus.id')->table('b51users')
            ->whereIn('kd_lokal', $x)->count();
           
    }
    public function jml_hadirGabung($kd_lokal,$kd_mtk)
    {
        $lokal = DB::table('jadwal_ujian')
             ->select( DB::raw('GROUP_CONCAT(kd_lokal) AS kd_lokal'))
            ->where('kd_gabung', '=', $kd_lokal)->first();
            $xx=$lokal->kd_lokal;
            $x = explode(",",$xx);
        $mtk=$kd_mtk.'0';
        return DB::connection('kampus.id')->table('b51results as a')
        ->join('b51users as b', 'a.userid', '=', 'b.userid')
        ->join('b51tests as c', 'a.testid', '=', 'c.testid')
        ->whereIn('b.kd_lokal', $x)
        ->where('c.test_code', $mtk)->count();
    }

    public function mhs_hadirGabung($kd_lokal,$kd_mtk)
    {
        $lokal = DB::table('jadwal_ujian')
             ->select( DB::raw('GROUP_CONCAT(kd_lokal) AS kd_lokal'))
            ->where('kd_gabung', '=', $kd_lokal)->first();
            $xx=$lokal->kd_lokal;
            $x = explode(",",$xx);
        $mtk=$kd_mtk.'0';
        $mahasiswa = DB::connection('kampus.id')->table('b51results as a')
        ->join('b51users as b', 'a.userid', '=', 'b.userid')
        ->join('b51tests as c', 'a.testid', '=', 'c.testid')
        ->whereIn('b.kd_lokal', $x)
        ->where('c.test_code', $mtk);
        if($mahasiswa->count()>0){
                        foreach($mahasiswa->get() as $i){
                            $h[$i->userid]=$i;
                    }
                    return $h;
                }
                else
                {
                return $mahasiswa->get();
                }
    }

    public function temu_ajarGabung($w_showMhs)
    {
     return $mhs = DB::table('absen_ujian_ajars')
     ->select('pertemuan','berita_acara','file_ajar','nip','rangkuman')
     ->where($w_showMhs)
     ->orderByDesc('pertemuan')
     ->limit(1)
     ->get();
    }
    public function jadwalGabung($where,$kd_gabung)
    {
        $lokal = DB::table('jadwal_ujian')
        ->select( DB::raw('GROUP_CONCAT(kd_lokal) AS kd_lokal'))
        ->where('kd_gabung', '=', $kd_gabung)->first();
        $xx=$lokal->kd_lokal;
        $x = explode(",",$xx);
        return $jadwal = DB::table('jadwal_ujian')
        ->whereIn('kd_lokal', $x)
        ->where($where);
    }
    public function stsMhsGabung($kd_lokal,$kd_mtk)
    {
        $lokal = DB::table('jadwal_ujian')
        ->select( DB::raw('GROUP_CONCAT(kd_lokal) AS kd_lokal'))
        ->where('kd_gabung', '=', $kd_lokal)->first();
        $xx=$lokal->kd_lokal;
        $x = explode(",",$xx);
        $mtk=$kd_mtk.'0';
        $mahasiswa = DB::connection('kampus.id')->table('b51groups_users as a')
        ->join('b51users as b', 'a.userid', '=', 'b.userid')
        ->whereIn('b.kd_lokal',$x)
        ->where('a.kd_soal', $mtk);
        if($mahasiswa->count()>0){
                        foreach($mahasiswa->get() as $i){
                            $h[$i->userid]=$i;
                    }
                    return $h;
                }
                else
                {
                return $mahasiswa->get();
                }
    }
}
