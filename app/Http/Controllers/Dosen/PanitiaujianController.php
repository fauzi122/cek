<?php

namespace App\Http\Controllers\Dosen;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Http;
use App\Models\Panitiaujian;


class PanitiaujianController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['permission:users.index|users.create|users.edit|users.delete']);
        if(!$this->middleware('auth:sanctum')){
            return redirect('/login');
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $where=['nip'=>Auth::user()->username,'kel_praktek'=>''];
        $group=['kd_gabung','kd_mtk','no_ruang','jam_t','hari_t'];
        $jadwal = app('App\Models\Panitiaujian')->jadwalUjian($where,$group)->get();
        return view('admin.panitiaujian.jadwal_mengajar',compact('jadwal'));
    }

    public function store_teori(Request $request)
    {
        $jam=date("H:i");
       $where = ['kd_lokal'=>$request->kd_lokal,'tgl_ajar_masuk'=>date('Y-m-d'),'kd_mtk'=>$request->kd_mtk,'jam_t'=>$request->jam_t];
       $w_cek = ['kd_lokal'=>$request->kd_lokal,'kd_mtk'=>$request->kd_mtk,'jam_t'=>$request->jam_t];
       $w_pert = ['kd_lokal'=>$request->kd_lokal,'kd_mtk'=>$request->kd_mtk];
    //    $w_absen = ['kd_lokal'=>$request->kd_lokal,'kd_mtk'=>$request->kd_mtk,'tgl_hadir'=>date('Y-m-d'),'status_hadir'=>'1'];
       $absen_pert = Panitiaujian::where($w_pert)
       ->orderByDesc('pertemuan');
       $cek_absen = Panitiaujian::where($where)
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
   $absen_ajar = Panitiaujian::where($where)->count();
   $cek_jam = app('App\Models\Panitiaujian')->cek_jam($w_cek,$jam)->first();
//    dd($cek_jam);
   if(isset($cek_jam)){
       if($absen_ajar < 1){
        Panitiaujian::create([
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
           'jam_t'=>$request->jam_t,
           'kd_dosen'=>$request->kd_dosen]);
       }
    }else{
        return redirect('/jadwal-ujian')->with('jam','Anda Belum Waktunya Masuk Kelas');
    }
       $id=Crypt::encryptString($request->kd_mtk.','.$request->nm_mtk.','.$request->kd_dosen.','.$request->sks.','.$request->kd_lokal.','.$request->hari_t.','.$request->jam_t.','.$request->no_ruang.','.$pert);
       return redirect('/ajar-teori-ujian/'.$id); 
          
    }

    public function ajar_teori($id)
    {
        $request = explode(",",Crypt::decryptString($id));
        $w_jadwal=['kd_mtk'=>$request[0],'kd_lokal'=>$request[4],'jam_t'=>$request[6]];
        $w_pert = ['kd_lokal'=>$request[4],'kd_mtk'=>$request[0]];
        $w_cek = ['kd_lokal'=>$request[4],'kd_mtk'=>$request[0],'tgl_ajar_masuk'=>date('Y-m-d'),'jam_t'=>$request[6]];
        $w_showFoto = ['a.kode'=>$request[4],'d.tgl_ajar_masuk'=>date('Y-m-d'),'b.kd_mtk'=>$request[0]];
        $w_temu = ['kd_lokal'=>$request[4],'tgl_ajar_masuk'=>date('Y-m-d'),'kd_mtk'=>$request[0],'jam_t'=>$request[6]];
        $berita_acara=Panitiaujian::select('pertemuan','berita_acara','rangkuman','kd_lokal','file_ajar','jam_masuk','jam_keluar')
        ->where($w_pert)->get();
        $absen_keluar = app('App\Models\Panitiaujian')->cek_bap($w_cek)->first();
        $mahasiswa = app('App\Models\Panitiaujian')->showMhs($request[4]);
        $mhs_foto = app('App\Models\Absen_ajar')->mhs_foto($w_showFoto);
        $jml_mhs = app('App\Models\Panitiaujian')->jumlah_mhs($request[4]);
        $jml_hadir = app('App\Models\Panitiaujian')->jml_hadir($request[4],$request[0],$request[8]);
        $mhs_hadir = app('App\Models\Panitiaujian')->mhs_hadir($request[4],$request[0],$request[8]);
        $jadwal = app('App\Models\Panitiaujian')->jadwal($w_jadwal)->get();
        $temu_ajar = app('App\Models\Panitiaujian')->temu_ajar($w_temu);
        $mhs_sts = app('App\Models\Panitiaujian')->stsMhs($request[4],$request[0]);
        return view('admin.panitiaujian.ajar_teori',compact('mahasiswa','mhs_hadir','jadwal','jml_mhs','jml_hadir','berita_acara','id','absen_keluar','mhs_foto','temu_ajar','mhs_sts'));
    }

    public function bap_teori(Request $request)
    {
        $request->validate([
            'rangkuman' => 'required',
            'bap' => 'required',
            ]);
            $exp = explode(",",Crypt::decryptString($request->id));
            $w_bap = ['nip'=>Auth::user()->username,'kd_lokal'=>$request->kd_lokal,'kd_mtk'=>$exp[0],'tgl_ajar_masuk'=>date('Y-m-d'),'jam_t'=>$exp[6]];
        $simpan=Panitiaujian::where($w_bap)
                ->update([
                    'rangkuman'=>$request->rangkuman,
                    'berita_acara'=>$request->bap]);
        if ($simpan) {
            session()->flash('status', 'Ditambahkan');
        }else{
            session()->flash('error', 'Gagal Ditambahkan');
        }
        return redirect('/ajar-teori-ujian/'.$request->id);
                    
    }

    public function absen_keluar(Request $request)
    {
        $exp = explode(",",Crypt::decryptString($request->id));
        $w_cek = ['kd_lokal'=>$exp[4],'kd_mtk'=>$exp[0],'tgl_ajar_masuk'=>date('Y-m-d'),'jam_t'=>$exp[6]];
        $jam=date("H:i");
        $tgl_keluar=date("Y-m-d");
        $jam_keluar=date("H:i:s");
        $w_jam = ['kd_lokal'=>$exp[4],'kd_mtk'=>$exp[0]];
        $cek_bap = app('App\Models\Panitiaujian')->cek_bap($w_cek)->first();
        if ($cek_bap->berita_acara<>null && $cek_bap->berita_acara<>'' && $cek_bap->rangkuman<>null && $cek_bap->rangkuman<>'') {       
                $cek_jam = app('App\Models\Panitiaujian')->cek_jam_keluar($w_jam,$jam)->first();
        if (isset($cek_jam)) {
            Panitiaujian::where($w_cek)
                ->update([
                    'tgl_ajar_keluar'=>$tgl_keluar,
                    'jam_keluar'=>$jam_keluar]);
           
            return redirect('/jadwal-ujian')->with('status','Absen Keluar Mengajar');
        }else{

        return redirect('/ajar-teori-ujian/'.$request->id)->with('error','Anda Tidak Dapat Melakukan Absen Keluar');
        }
        }else{
        return redirect('/ajar-teori-ujian/'.$request->id)->with('error','Pokok Pembahasan Tidak Boleh Kosong');

            
        }

    }

    public function absenMhs(Request $request)
    {

    // for ($i=1;$i<=count($request->no_urut);$i++) {
    //     DB::connection('kampus.id')->table('b51groups_users')
    //     ->updateOrInsert(
    //     ['userid' => $request->no_urut[$i],
    //      'kd_soal'=>$request->kd_mtk[$i],
    //      'kelompok'=>$request->kd_lokal[$i]
    //     ],
    //     ['ket'=>$request->ket[$i]
    //     ]
    // );
    //    }

    for ($i=1;$i<=count($request->no_urut);$i++) {
        DB::connection('kampus.id')->table('b51results')
        ->updateOrInsert(
        ['resultid' => $request->resultid[$i]
        ],
        ['sts'=>$request->nama_radio[$i],
        'ket'=>$request->ket[$i]
        ]
    );
       }
       return redirect('/ajar-teori-ujian/'.$request->id);
       
    }

    public function store_gabung(Request $request)
    { 
         // 0 => "882"
        // 1 => "MULTIMEDIA"
        // 2 => "GNB"
        // 3 => "3"
        // 4 => "KG.882.12.A"
        // 5 => "Senin"
        // 6 => "07:30-10:00"
        // 7 => "202-G1"
        // 8 => "12"
        // $request = explode(",",Crypt::decryptString($id));
        $jam=date("H:i");
        $lokal = DB::table('jadwal_ujian')
        ->select( DB::raw('GROUP_CONCAT(kd_lokal) AS kd_lokal'))
        ->where('kd_gabung', '=', $request->kd_lokal)->first();
        $xx=$lokal->kd_lokal;
       $w_cek = ['kd_gabung'=>$request->kd_lokal,'kd_mtk'=>$request->kd_mtk,'jam_t'=>$request->jam_t];
        $where = ['kd_lokal'=>$request->kd_lokal,'tgl_ajar_masuk'=>date('Y-m-d'),'jam_t'=>$request->jam_t];
        $w_pert = ['kd_lokal'=>$request->kd_lokal,'kd_mtk'=>$request->kd_mtk];
        $absen_pert = Panitiaujian::where($w_pert)
        ->orderByDesc('pertemuan');
        // dd($absen_pert->count());
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
        $absen_ajar = Panitiaujian::where($where)->count();
        $cek_jam = app('App\Models\Panitiaujian')->cek_jam($w_cek,$jam)->first();
   if(isset($cek_jam)){
        if($absen_ajar < 1){
            $simpan= Panitiaujian::create([
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
                'jam_t'=>$request->jam_t,
                'kd_dosen'=>$request->kd_dosen
                ]);
       }
    }else{
        return redirect('/jadwal-ujian')->with('jam','Anda Belum Waktunya Masuk Kelas');
    }
       $id=Crypt::encryptString($request->kd_mtk.','.$request->nm_mtk.','.$request->kd_dosen.','.$request->sks.','.$request->kd_lokal.','.$request->hari_t.','.$request->jam_t.','.$request->no_ruang.','.$pert);
       return redirect('/ajar-ujian-gabung/'.$id);    
    }

    public function ajar_gabung($id)
    {
        $request = explode(",",Crypt::decryptString($id));
        // dd($request);
        $w_pert = ['kd_lokal'=>$request[4],'kd_mtk'=>$request[0]];
        $w_jadwal=['kd_mtk'=>$request[0],'jam_t'=>$request[6]];
        // $w_showMhs = ['a.kd_lokal'=>$request[4],'d.tgl_ajar_masuk'=>date('Y-m-d'),'b.kd_mtk'=>$request[0]];
        $w_temu = ['kd_lokal'=>$request[4],'tgl_ajar_masuk'=>date('Y-m-d'),'kd_mtk'=>$request[0],'jam_t'=>$request[6]];
        $berita_acara=Panitiaujian::select('pertemuan','berita_acara','rangkuman','kd_lokal','file_ajar','jam_masuk','jam_keluar')
        ->where($w_pert)->get();
        $w_cek = ['kd_lokal'=>$request[4],'kd_mtk'=>$request[0],'tgl_ajar_masuk'=>date('Y-m-d'),'jam_t'=>$request[6]];
        $absen_keluar = app('App\Models\Panitiaujian')->cek_bap($w_cek)->first();
        $mahasiswa = app('App\Models\Panitiaujian')->showMhsgabung($request[4],$request[0]);
        $mhs_foto = app('App\Models\Absen_gabung')->mhs_foto($request[4],$request[0]);
        $jml_mhs = app('App\Models\Panitiaujian')->jmlMhsgabung($request[4],$request[0]);
        $jml_hadir = app('App\Models\Panitiaujian')->jml_hadirGabung($request[4],$request[0],$request[8]);
        $mhs_hadir = app('App\Models\Panitiaujian')->mhs_hadirGabung($request[4],$request[0],$request[8]);
        $temu_ajar = app('App\Models\Panitiaujian')->temu_ajarGabung($w_temu);
        $jadwal = app('App\Models\Panitiaujian')->jadwalGabung($w_jadwal,$request[4])->get();
        $mhs_sts = app('App\Models\Panitiaujian')->stsMhsGabung($request[4],$request[0]);
        return view('admin.panitiaujian.ajar_gabung',compact('mahasiswa','mhs_hadir','temu_ajar','jadwal','jml_mhs','jml_hadir','berita_acara','id','absen_keluar','mhs_foto','mhs_sts'));
    }

    public function bap_gabung(Request $request)
    {
        $request->validate([
            'rangkuman' => 'required',
            'bap' => 'required',
            ]);
            $exp = explode(",",Crypt::decryptString($request->id));
            $w_bap = ['nip'=>Auth::user()->username,'kd_lokal'=>$request->kd_lokal,'kd_mtk'=>$exp[0],'tgl_ajar_masuk'=>date('Y-m-d'),'jam_t'=>$exp[6]];
        $simpan=Panitiaujian::where($w_bap)
                ->update([
                    'rangkuman'=>$request->rangkuman,
                    'berita_acara'=>$request->bap]);
        if ($simpan) {
            session()->flash('status', 'Ditambahkan');
        }else{
            session()->flash('error', 'Gagal Ditambahkan');
        }
        return redirect('/ajar-ujian-gabung/'.$request->id);
                    
    }

    public function absen_keluarGabung(Request $request)
    {
        $exp = explode(",",Crypt::decryptString($request->id));
        $w_cek = ['kd_lokal'=>$exp[4],'kd_mtk'=>$exp[0],'tgl_ajar_masuk'=>date('Y-m-d'),'jam_t'=>$exp[6]];
        $jam=date("H:i");
        $tgl_keluar=date("Y-m-d");
        $jam_keluar=date("H:i:s");
        $w_jam = ['kd_lokal'=>$exp[4],'kd_mtk'=>$exp[0]];
        $cek_bap = app('App\Models\Panitiaujian')->cek_bap($w_cek)->first();
        if ($cek_bap->berita_acara<>null && $cek_bap->berita_acara<>'' && $cek_bap->rangkuman<>null && $cek_bap->rangkuman<>'') {       
                $cek_jam = app('App\Models\Panitiaujian')->cek_jam_keluar($w_jam,$jam)->first();
        if (isset($cek_jam)) {
            Panitiaujian::where($w_cek)
                ->update([
                    'tgl_ajar_keluar'=>$tgl_keluar,
                    'jam_keluar'=>$jam_keluar]);
           
            return redirect('/jadwal-ujian')->with('status','Absen Keluar Mengajar');
        }else{

        return redirect('/ajar-ujian-gabung/'.$request->id)->with('error','Anda Tidak Dapat Melakukan Absen Keluar');
        }
        }else{
        return redirect('/ajar-ujian-gabung/'.$request->id)->with('error','Pokok Pembahasan Tidak Boleh Kosong');

            
        }

    }

    public function absenMhsGabung(Request $request)
    {

    // for ($i=1;$i<=count($request->no_urut);$i++) {
    //     DB::connection('kampus.id')->table('b51groups_users')
    //     ->updateOrInsert(
    //     ['userid' => $request->no_urut[$i],
    //      'kd_soal'=>$request->kd_mtk[$i],
    //      'kelompok'=>$request->kd_lokal[$i]
    //     ],
    //     ['ket'=>$request->ket[$i]
    //     ]
    // );
    //    }

    for ($i=1;$i<=count($request->no_urut);$i++) {
        DB::connection('kampus.id')->table('b51results')
        ->updateOrInsert(
        ['resultid' => $request->resultid[$i]
        ],
        ['sts'=>$request->nama_radio[$i],
        'ket'=>$request->ket[$i]
        ]
    );
       }
       return redirect('/ajar-ujian-gabung/'.$request->id);
       
    }



}
