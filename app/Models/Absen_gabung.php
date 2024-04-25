<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Traits\LogTrait;

class Absen_gabung extends Model
{
    use LogTrait, HasFactory;
    protected $guarded=[];
    
    public function jadwal($where,$kd_gabung)
    {
        $lokal = DB::table('jadwal')
        ->select( DB::raw('GROUP_CONCAT(kd_lokal) AS kd_lokal'))
        ->where('kd_gabung', '=', $kd_gabung)->first();
        $xx=$lokal->kd_lokal;
        // dd($xx);
        $x = explode(",",$xx);
        return $jadwal = DB::table('jadwal')
        ->whereIn('kd_lokal', $x)
        // ->where('kd_dosen',Auth::user()->kode)
        ->where($where);
    }
    public function jadwal_pengganti($where,$kd_gabung)
    {
        // $lokal = DB::table('jadwal')
        // ->select( DB::raw('GROUP_CONCAT(kd_lokal) AS kd_lokal'))
        // ->where('kd_gabung', '=', $kd_gabung)->first();
        // $xx=$lokal->kd_lokal;
        // $x = explode(",",$xx);
        return $jadwal = DB::table('kuliah_pengganti')
        ->where('kd_gabung', $kd_gabung)
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
    return $jadwal = DB::table('absen_ajars')
    ->where($where);
    // ->groupBy($group);
}
    public function showMhs($kd_lokal,$kd_mtk)
    {
        $lokal = DB::table('jadwal')
             ->select( DB::raw('GROUP_CONCAT(kd_lokal) AS kd_lokal'))
            ->where('kd_gabung', '=', $kd_lokal)->first();
            $xx=$lokal->kd_lokal;
            $x = explode(",",$xx);
            // $floor->attachTags($x);
            // dd($x);
        $mhs = DB::table('mhs as a')
            ->select('a.nim AS nim',
            DB::raw('UCASE(a.nm_mhs) AS nm_mhs'),
            'a.kondisi      AS kondisi',
            'a.jen_kel      AS jen_kel',
            'a.kd_lokal     AS kd_lokal'
           )
            ->join('penilaian as b', 'a.nim', '=', 'b.nim')
            ->where('a.kondisi', '=', '1')
            // ->where('a.kd_lokal', '<>', '')
            ->whereIn('a.kd_lokal', $x)
            // ->where('a.kd_lokal', '=', $kd_lokal)
            // ->where('d.tgl_ajar_masuk', '=', date('Y-m-d'))
            // ->where('c.pertemuan', '=', $pert)
            ->where('b.kd_mtk', '=', $kd_mtk);
            $mhs->get();
            // dd($mhs->count());
            if($mhs->count()>0){
                foreach($mhs->get() as $i){
                    $h[$i->nim]=$i;
                }
                return $h;
                }
             
    }
    public function jumlah_mhs($kd_lokal,$kd_mtk)
    {
        $lokal = DB::table('jadwal')
        ->select( DB::raw('GROUP_CONCAT(kd_lokal) AS kd_lokal'))
       ->where('kd_gabung', '=', $kd_lokal)->first();
       $xx=$lokal->kd_lokal;
       $x = explode(",",$xx);
        $mhs = DB::table('mhs as a')
            ->select('a.nim AS nim',
            DB::raw('UCASE(a.nm_mhs) AS nm_mhs'),
            'a.kondisi      AS kondisi',
            'a.jen_kel      AS jen_kel',
            'a.kd_lokal     AS kd_lokal')
            ->join('penilaian as b', 'a.nim', '=', 'b.nim')
            ->where('a.kondisi', '=', '1')
            ->where('a.kd_lokal', '<>', '')
            ->whereIn('a.kd_lokal', $x)
            ->where('b.kd_mtk', '=', $kd_mtk);
            return $mhs->count();
    }
    public function mhs_foto($kd_lokal,$kd_mtk)
    {
        $lokal = DB::table('jadwal')
             ->select( DB::raw('GROUP_CONCAT(kd_lokal) AS kd_lokal'))
            ->where('kd_gabung', '=', $kd_lokal)->first();
        $xx=$lokal->kd_lokal;
        $x = explode(",",$xx);
        $mahasiswa = DB::table('users as a')
                        ->select('a.username AS nim',
                        DB::raw('UCASE(a.name) AS nm_mhs'),
                        'a.profile_photo_path      AS foto')
                        ->join('penilaian as b', 'a.username', '=', 'b.nim')
                        ->where('a.kode', '<>', '')
                        ->whereIn('a.kode', $x)
                        ->where('b.kd_mtk', '=', $kd_mtk);
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
        $where=['kd_gabung'=>$kd_lokal,'kd_mtk'=>$kd_mtk,'pertemuan'=>$pert,'status_hadir'=>'1'];
        // dd($where);
        return $mahasiswa = DB::table('absen_mhs')
        ->where($where)->count();
    }
    public function mhs_hadir($kd_lokal,$kd_mtk,$pert)
    {
        $where=['kd_gabung'=>$kd_lokal,'kd_mtk'=>$kd_mtk,'pertemuan'=>$pert,'status_hadir'=>'1'];
        // dd($where);
         $mahasiswa = DB::table('absen_mhs')
            // ->whereIn('a.kd_lokal', $x)
            ->where($where);
            // dd($mahasiswa->count());
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

}
