<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Traits\LogTrait;
class Absen_ajar_praktek extends Model
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

public function cek_jam($where,$jam)
    {
    return $jadwal = DB::table('jadwal')
    ->where('mulai', '<', $jam)
    ->where('selesai', '>', $jam)
    ->where($where);
    // ->groupBy($group);
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
    // ->groupBy($group);
}

public function cek_bap($where)
    {
    return $jadwal = DB::table('absen_ajar_prakteks')
    ->where($where);
    // ->groupBy($group);
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
            'd.kd_mtk      AS kd_mtk',
            'b.kel_praktek      AS kel_praktek')
            ->join('penilaian as b', 'a.nim', '=', 'b.nim')
            ->leftJoin('absen_ajar_prakteks as d', 'b.kel_praktek', '=', 'd.kel_praktek')
            ->where('a.kondisi', '=', '1')
            ->where('b.kel_praktek', '<>', '')
            ->where($w_showMhs);
            // ->where('d.tgl_ajar_masuk', '=', date('Y-m-d'))
            // ->where('d.pertemuan', '=', $pert)
            // ->where('b.kd_mtk', '=', $kd_mtk);
            $mhs->get();
            if($mhs->count()>0){
                foreach($mhs->get() as $i){
                    $h[$i->nim]=$i->nm_mhs;
                }
                return $h;
                }
             
    }
    public function jumlah_mhs($w_jumlahmhs)
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
            'd.kd_mtk      AS kd_mtk',
            'b.kel_praktek      AS kel_praktek')
            ->join('penilaian as b', 'a.nim', '=', 'b.nim')
            ->leftJoin('absen_ajar_prakteks as d', 'b.kel_praktek', '=', 'd.kel_praktek')
            ->where('a.kondisi', '=', '1')
            ->where('b.kel_praktek', '<>', '')
            // ->where('b.kel_praktek', '=', $kelprak)
            // // ->where('d.tgl_ajar_masuk', '=', date('Y-m-d'))
            // ->where('d.pertemuan', '=', $pert)
            ->where($w_jumlahmhs);
           return $mhs->count();
    }

    public function jml_hadir($kd_praktek,$kd_mtk,$pert)
    {
        $where=['kel_praktek'=>$kd_praktek,'kd_mtk'=>$kd_mtk,'pertemuan'=>$pert,'status_hadir'=>'1'];
        // dd($where);
        return $mahasiswa = DB::table('absen_mhs')
        ->where($where)->count();
    }
    public function mhs_hadir($kd_praktek,$kd_mtk,$pert)
    {
        $where=['kel_praktek'=>$kd_praktek,'kd_mtk'=>$kd_mtk,'pertemuan'=>$pert,'status_hadir'=>'1'];
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
public function mhs_foto($w_jumlahmhs)
    {
        $mahasiswa = DB::table('users as a')
                        ->select('a.username AS nim',
                        DB::raw('UCASE(a.name) AS nm_mhs'),
                        'a.profile_photo_path      AS foto')
                        ->join('penilaian as b', 'a.username', '=', 'b.nim')
                        ->leftJoin('absen_ajar_prakteks as d', 'b.kel_praktek', '=', 'd.kel_praktek')
                        ->where('b.kel_praktek', '<>', '')
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

   public function temu_ajar($w_showMhs)
   {
    return $mhs = DB::table('absen_ajar_prakteks')
    ->select('pertemuan','berita_acara','file_ajar','nip','rangkuman')
    ->where($w_showMhs)
    // ->where('kel_praktek', '=', $kd_praktek)
    ->orderByDesc('pertemuan')
    ->limit(1)
    ->get();
   }
}
