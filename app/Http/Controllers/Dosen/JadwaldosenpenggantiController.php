<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\jadwalDosenpengganti;
use App\Models\Absen_ajar_praktek;
use App\Models\Absen_ajar;
use App\Models\Ip_absen;
use Illuminate\Support\Facades\Crypt;

class JadwaldosenpenggantiController extends Controller
{
    public function __construct()
    {
        if(!$this->middleware('auth:sanctum')){
            return redirect('/login');
        }
    }
    function get_client_ip_2() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'IP tidak dikenali';
        return $ipaddress;
    }
    public function index(Request $request)
    {
        $where = ['dosen_pengganti.kd_dp' => Auth::user()->kode];
        $group = ['jadwal.kd_gabung', 'jadwal.kd_mtk', 'jadwal.no_ruang', 'jadwal.jam_t', 'jadwal.hari_t','dosen_pengganti.tgl_ganti'];
        $jadwal = app('App\Models\Dosen_pengganti')->jadwalDosenpengganti($where, $group)->get();
        $ipclient=$this->get_client_ip_2();
        $expip=explode(".",$ipclient);
        $inip=$expip[0].'.'.$expip[1].'.'.$expip[2];
        $ip=Ip_absen::where('ip',$inip)->first();
        return view('admin.dosenpengganti.jadwal_mengajar',compact('jadwal','ip','ipclient'));
    }

    public function store_praktek(Request $request)
    {
        if(STRTOTIME($request->tgl_ganti) < STRTOTIME(DATE("Y-m-d"))){  
            return redirect('/jadwal-dosen-pengganti')->with('jam','Jadwal Pengganti Sudah Lewat');   
        }elseif(STRTOTIME($request->tgl_ganti) > STRTOTIME(DATE("Y-m-d"))){
            return redirect('/jadwal-dosen-pengganti')->with('jam','Jadwal Pengganti Belum Mulai');   
                      
        }else{
        $jam=date("H:i");
       $where = ['kel_praktek'=>$request->kel_praktek,'tgl_ajar_masuk'=>date('Y-m-d'),'kd_mtk'=>$request->kd_mtk,'jam_t'=>$request->jam_t];
       $w_cek = ['kel_praktek'=>$request->kel_praktek,'kd_mtk'=>$request->kd_mtk,'jam_t'=>$request->jam_t];
       $w_pert = ['kel_praktek'=>$request->kel_praktek,'kd_mtk'=>$request->kd_mtk];
       $absen_pert = Absen_ajar_praktek::where($w_pert)
       ->orderByDesc('pertemuan');
       $cek_absen = Absen_ajar_praktek::where($where)
       ->orderByDesc('pertemuan');
      if($absen_pert->count() > 0){
       $temu=$absen_pert->first();
       $jml_pert=$temu->pertemuan+1;
       if($cek_absen->count()>0){
           $pert=$temu->pertemuan;
       }elseif($jml_pert=='8'){
        $pert=$temu->pertemuan+2;
       }else{
           $pert=$temu->pertemuan+1;
       }
        }else{
           $pert='1';
        }
   $absen_ajar = Absen_ajar_praktek::where($where)->count();
   $cek_jam = app('App\Models\Absen_ajar')->cek_jam($w_cek,$jam)->first();
   if(isset($cek_jam)){
       if($absen_ajar < 1){
       Absen_ajar_praktek::create([
           'nip'=>Auth::user()->username,
           'kel_praktek'=>$request->kel_praktek,
           'kd_mtk'=>$request->kd_mtk,
           'nm_mtk'=>$request->nm_mtk,
           'sks'=>$request->sks,
           'tgl_ajar_masuk'=>date('Y-m-d'),
           'hari_ajar_masuk'=>$request->hari_t,
           'jam_masuk'=>date('H:i:s'),
           'no_ruang'=>$request->no_ruang,
           'pertemuan'=>$pert,
           'sts_ajar'=>'DP',
           'jam_t'=>$request->jam_t,
           'kd_dosen'=>$request->kd_dosen]);
       }
    }else{
        return redirect('/jadwal-dosen-pengganti')->with('jam','Anda Belum Waktunya Masuk Kelas');
    }
    $id=Crypt::encryptString($request->kd_mtk.','.preg_replace("/[^a-zA-Z0-9]/", "", $request->nm_mtk).','.$request->kd_dosen.','.$request->sks.','.$request->kel_praktek.','.$request->hari_t.','.$request->jam_t.','.$request->no_ruang.','.$pert);
    return redirect('/ajar-praktek/'.$id);
    }
}

public function store_teori(Request $request)
    {
        if(STRTOTIME($request->tgl_ganti) < STRTOTIME(DATE("Y-m-d"))){  
            return redirect('/jadwal-dosen-pengganti')->with('jam','Jadwal Pengganti Sudah Lewat');   
        }elseif(STRTOTIME($request->tgl_ganti) > STRTOTIME(DATE("Y-m-d"))){
            return redirect('/jadwal-dosen-pengganti')->with('jam','Jadwal Pengganti Belum Mulai');   
        }else{
        $jam=date("H:i");
       $where = ['kd_lokal'=>$request->kd_lokal,'tgl_ajar_masuk'=>date('Y-m-d'),'kd_mtk'=>$request->kd_mtk,'jam_t'=>$request->jam_t];
       $w_cek = ['kd_lokal'=>$request->kd_lokal,'kd_mtk'=>$request->kd_mtk,'jam_t'=>$request->jam_t];
       $w_pert = ['kd_lokal'=>$request->kd_lokal,'kd_mtk'=>$request->kd_mtk];
       $absen_pert = Absen_ajar::where($w_pert)
       ->orderByDesc('pertemuan');
       $cek_absen = Absen_ajar::where($where)
       ->orderByDesc('pertemuan');
      if($absen_pert->count() > 0){
       $temu=$absen_pert->first();
       $jml_pert=$temu->pertemuan+1;
       if($cek_absen->count()>0){
           $pert=$temu->pertemuan;
       }elseif($jml_pert=='8'){
        $pert=$temu->pertemuan+2;
       }else{
           $pert=$temu->pertemuan+1;
       }
   }else{
           $pert='1';
   }
   $absen_ajar = Absen_ajar::where($where)->count();
   $cek_jam = app('App\Models\Absen_ajar')->cek_jam($w_cek,$jam)->first();
   if(isset($cek_jam)){
       if($absen_ajar < 1){
       Absen_ajar::create([
           'nip'=>Auth::user()->username,
           'kd_lokal'=>$request->kd_lokal,
           'kd_mtk'=>$request->kd_mtk,
           'nm_mtk'=>$request->nm_mtk,
           'sks'=>$request->sks,
           'tgl_ajar_masuk'=>date('Y-m-d'),
           'hari_ajar_masuk'=>$request->hari_t,
           'jam_masuk'=>date('H:i:s'),
           'no_ruang'=>$request->no_ruang,
           'pertemuan'=>$pert,
           'sts_ajar'=>'DP',
           'jam_t'=>$request->jam_t,
           'kd_dosen'=>$request->kd_dosen]);
       }
    }else{
        return redirect('/jadwal-dosen-pengganti')->with('jam','Anda Belum Waktunya Masuk Kelas');
    }
       $id=Crypt::encryptString($request->kd_mtk.','.preg_replace("/[^a-zA-Z0-9]/", "", $request->nm_mtk).','.$request->kd_dosen.','.$request->sks.','.$request->kd_lokal.','.$request->hari_t.','.$request->jam_t.','.$request->no_ruang.','.$pert);
       return redirect('/ajar-teori/'.$id); 
}
          
    }

    public function store_gabung(Request $request)
    { 
        if(STRTOTIME($request->tgl_ganti) < STRTOTIME(DATE("Y-m-d"))){  
            return redirect('/jadwal-dosen-pengganti')->with('jam','Jadwal Pengganti Sudah Lewat');   
        }elseif(STRTOTIME($request->tgl_ganti) > STRTOTIME(DATE("Y-m-d"))){
            return redirect('/jadwal-dosen-pengganti')->with('jam','Jadwal Pengganti Belum Mulai');   
        }else{
        $jam=date("H:i");
        $lokal = DB::table('pertemuan')
        ->select( DB::raw('GROUP_CONCAT(kd_lokal) AS kd_lokal'))
        ->where('kd_gabung', '=', $request->kd_lokal)->first();
        $xx=$lokal->kd_lokal;
       $w_cek = ['kd_gabung'=>$request->kd_lokal,'kd_mtk'=>$request->kd_mtk,'jam_t'=>$request->jam_t];
        $where = ['kd_lokal'=>$request->kd_lokal,'tgl_ajar_masuk'=>date('Y-m-d'),'jam_t'=>$request->jam_t];
        $w_pert = ['kd_lokal'=>$request->kd_lokal,'kd_mtk'=>$request->kd_mtk];
        $absen_pert = Absen_ajar::where($w_pert)
        ->orderByDesc('pertemuan');
        if($absen_pert->count() > 0){
            $temu=$absen_pert->first();
            $jml_pert=$temu->pertemuan+1;
            if($temu->tgl_ajar_masuk==date('Y-m-d')){
                $pert=$temu->pertemuan;
            }elseif($jml_pert=='8'){
                $pert=$temu->pertemuan+2;
            }else{
                $pert=$temu->pertemuan+1;
            }
        }else{
            $pert='1';
        }
        $absen_ajar = Absen_ajar::where($where)->count();
        $cek_jam = app('App\Models\Absen_ajar')->cek_jam($w_cek,$jam)->first();
   if(isset($cek_jam)){
        if($absen_ajar < 1){
            Absen_ajar::create([
                'nip'=>Auth::user()->username,
                'kd_lokal'=>$request->kd_lokal,
                'detail_gabung'=>$xx,
                'kd_mtk'=>$request->kd_mtk,
                'nm_mtk'=>$request->nm_mtk,
                'sks'=>$request->sks,
                'tgl_ajar_masuk'=>date('Y-m-d'),
                'hari_ajar_masuk'=>$request->hari_t,
                'jam_masuk'=>date('H:i:s'),
                'no_ruang'=>$request->no_ruang,
                'pertemuan'=>$pert,
                'sts_ajar'=>'DP',
                'jam_t'=>$request->jam_t,
                'kd_dosen'=>$request->kd_dosen
                ]);
       }
    }else{
        return redirect('/jadwal-dosen-pengganti')->with('jam','Anda Belum Waktunya Masuk Kelas');
    }
       $id=Crypt::encryptString($request->kd_mtk.','.preg_replace("/[^a-zA-Z0-9]/", "", $request->nm_mtk).','.$request->kd_dosen.','.$request->sks.','.$request->kd_lokal.','.$request->hari_t.','.$request->jam_t.','.$request->no_ruang.','.$pert);
       return redirect('/ajar-gabung/'.$id); 
}   
    }
    
}
