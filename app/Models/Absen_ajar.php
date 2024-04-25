<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Traits\LogTrait;
class Absen_ajar extends Model
{
    use LogTrait, HasFactory;
    protected $guarded=[];

    public function jadwal($where)
    {
        return $jadwal = DB::table('jadwal')
        ->where($where);
    }
    public function jadwal_pengganti($where)
    {
        return $jadwal = DB::table('kuliah_pengganti')
        ->where($where);
    }
    public function jadwal_all($where,$group)
    {
        return $jadwal = DB::table('jadwal')
        ->where($where)
        ->groupBy($group);
    }
public function cek_jam($where,$jam)
    {
        return $jadwal = DB::table('jadwal')
        ->where('mulai', '<', $jam)
        ->where('selesai', '>', $jam)
        ->where($where);
        //  dd($jam);
    // ->groupBy($group);
    }
public function cek_jam_pengganti($where,$jam)
    {
        return $jadwal = DB::table('kuliah_pengganti')
        ->where('mulai', '<', $jam)
        ->where('selesai', '>', $jam)
        ->where($where);
    }
public function cek_jam_keluar($where,$jam)
    {
        return $jadwal = DB::table('jadwal')
        ->where('selesai_interval', '<=', $jam)
        ->where('selesai', '>=', $jam)
        ->where($where);
    // ->groupBy($group);
    }
public function cek_jam_keluar_pengganti($where,$jam)
    {
        return $jadwal = DB::table('kuliah_pengganti')
        ->where('selesai_interval', '<=', $jam)
        ->where('selesai', '>=', $jam)
        ->where($where);
    }

public function cek_bap($where)
    {
        return $jadwal = DB::table('absen_ajars')
        ->where($where);
    }
    public function showMhs($w_showMhs)
    {
        $mhs = DB::table('mhs as a')
            ->select('a.nim AS nim',
            DB::raw('UCASE(a.nm_mhs) AS nm_mhs'),
            'a.kondisi      AS kondisi',
            'a.jen_kel      AS jen_kel',
            'a.kd_lokal     AS kd_lokal',
            'd.pertemuan    AS pertemuan',
            'd.jam_t        AS jam_t',
            'd.hari_ajar_masuk      AS hari_t',
            'd.kd_mtk      AS kd_mtk')
            ->join('penilaian as b', 'a.nim', '=', 'b.nim')
            ->leftJoin('absen_ajars as d', 'a.kd_lokal', '=', 'd.kd_lokal')
            ->where('a.kondisi', '=', '1')
            ->where('a.kd_lokal', '<>', '')
            ->where($w_showMhs);
            $mhs->get();
            if($mhs->count()>0){
                    foreach($mhs->get() as $i){
                    $h[$i->nim]=$i->nm_mhs;
                }
                    return $h;
                }
    }
    public function showMhsMbkm($kd_lokal,$pertemuan,$kd_mtk)
    {
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
    public function jumlah_mhs($kd_lokal)
    {
        return $mhs = DB::table('mhs')
            ->where('kondisi', '=', '1')
            ->where('kd_lokal', '<>', '')
            ->where('kd_lokal', $kd_lokal)->count();
           
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

    public function mhs_foto($w_jumlahmhs)
    {
        $mahasiswa = DB::table('users as a')
                        ->select('a.username AS nim',
                        DB::raw('UCASE(a.name) AS nm_mhs'),
                        'a.profile_photo_path      AS foto')
                        ->join('penilaian as b', 'a.username', '=', 'b.nim')
                        ->leftJoin('absen_ajars as d', 'a.kode', '=', 'd.kd_lokal')
                        ->where('a.kode', '<>', '')
                        ->where($w_jumlahmhs);
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

//    public function diskusi($kd_lokal,$kd_mtk)
//    {
//     return $jadwal = DB::table('forum_chat')
//     ->where('kd_lokal', '=', $kd_lokal)
//     ->where('kd_mtk', '=', $kd_mtk);
//    }
}
