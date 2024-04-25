<?php

namespace App\Http\Controllers\administrasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Jadwal;
use App\Models\Kuliah_pengganti;
use App\Models\Absen_ajar;
use App\Models\Absen_ajar_praktek;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Crypt;

class InputmanualController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:inputmanual_adm.index']);
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
        if (isset($_POST['dosen'])) {
            $kuliah_pengganti=DB::table('jadwal')
            ->where('kd_dosen', '=', $_POST['dosen'])
            ->get();
            $dosen = DB::table('users')
            ->where('utype', '=', 'ADM')
            ->get();
            $caridosen = DB::table('users')
            ->where('utype', '=', 'ADM')
            ->first();
            $compect=['dosen','kuliah_pengganti','caridosen'];
        }else{
            $dosen = DB::table('users')
            ->where('utype', '=', 'ADM')
            ->get();
            $caridosen = DB::table('users')
            ->where('utype', '=', 'ADM')
            ->first();
            $compect=['dosen','caridosen'];
        }
        
        return view('administrasi.inputmanual.inputmanual',compact($compect));

    }

    public function manual_side($id)
   {
        $kuliah_pengganti=DB::table('jadwal')
        ->where('kd_dosen', '=', $id)
        ->groupBy(['kd_gabung','kd_mtk','no_ruang','jam_t','hari_t'])
        ->get();
        return Datatables::of($kuliah_pengganti)
        
        ->addColumn('kelas', function ($kuliah_pengganti) {
            if ($kuliah_pengganti->kd_gabung<>'') {
                $aksi=$kuliah_pengganti->kd_gabung;
            } elseif($kuliah_pengganti->kel_praktek<>'') {
                $aksi=$kuliah_pengganti->kel_praktek;
            }else{
                $aksi=$kuliah_pengganti->kd_lokal;
            }
                        return $aksi;
                })
        ->addColumn('acc', function ($kuliah_pengganti) {
            if ($kuliah_pengganti->kd_gabung<>null) {
                $id=Crypt::encryptString($kuliah_pengganti->kd_mtk.','.$kuliah_pengganti->kd_gabung.','.$kuliah_pengganti->jam_t);
            } elseif($kuliah_pengganti->kel_praktek<>null) {
                $id=Crypt::encryptString($kuliah_pengganti->kd_mtk.','.$kuliah_pengganti->kel_praktek.','.$kuliah_pengganti->jam_t);
            }else{
                $id=Crypt::encryptString($kuliah_pengganti->kd_mtk.','.$kuliah_pengganti->kd_lokal.','.$kuliah_pengganti->jam_t);
            }
            
            $aksi='<a class="btn btn-primary btn-sm" href="'.url('/kelas-input-manual/'.$id).'"><i class="icon-controller-fast-forward"></i> Pilih</a>';
                        return $aksi;
                })

            ->rawColumns(['kelas','acc'])
            // ->rawColumns(['nomer'])
        ->make(true);
    
   }
   public function kelas_input_manual($id)
   {
    // 0 => "947"
    // 1 => "AFS.22.4B.12.A"
    // 2 => "17:00-19:30"
    $exp = explode(",",Crypt::decryptString($id));
    $cek=Jadwal::where(['kd_mtk'=>$exp[0],'kd_gabung'=>$exp[1]])->count();
    if ($cek>0) { //jika gabung
        $jadwal=Jadwal::where(['kd_mtk'=>$exp[0],'kd_gabung'=>$exp[1]])
        ->groupBy(['kd_gabung','kd_mtk','no_ruang','jam_t'])
        ->get();
        $absen=Absen_ajar::select('pertemuan')
        ->where(['kd_mtk'=>$exp[0],'kd_lokal'=>$exp[1]])
        ->orderByDesc('pertemuan')
        ->first();
    } else {//jika bukan gabung
        $cek = Jadwal::where(['kd_mtk'=>$exp[0],'kel_praktek'=>$exp[1]])->count();
        if ($cek>0) {//jika praktek
            $jadwal=Jadwal::where(['kd_mtk'=>$exp[0],'kel_praktek'=>$exp[1]])->get();
            $absen=Absen_ajar_praktek::select('pertemuan')
            ->where(['kd_mtk'=>$exp[0],'kel_praktek'=>$exp[1]])
            ->orderByDesc('pertemuan')
            ->first();
        } else {//jika lokal
            $jadwal=Jadwal::where(['kd_mtk'=>$exp[0],'kd_lokal'=>$exp[1]])->get();
            $absen=Absen_ajar::select('pertemuan')
                ->where(['kd_mtk'=>$exp[0],'kd_lokal'=>$exp[1]])
                ->orderByDesc('pertemuan')
                ->first();
           
        }
    }
    return view('administrasi.inputmanual.rekapinputmanual',compact('jadwal','absen','id'));
   }

   public function rekap_manual($id)
   {
    $exp = explode(",",Crypt::decryptString($id));
    $cek=Jadwal::where(['kd_mtk'=>$exp[0],'kd_gabung'=>$exp[1]])->count();
    if ($cek>0) { // jika gabung
            $jadwal=Absen_ajar::where(['kd_mtk'=>$exp[0],'kd_lokal'=>$exp[1]])->get();
            return Datatables::of($jadwal)
            ->addColumn('kelas', function ($jadwal) {
                $aksi=$jadwal->kd_lokal;
                            return $aksi;
                    })
                    ->rawColumns(['kelas'])
                ->make(true);
    } else {//jika bukan gabung
                $cek=Jadwal::where(['kd_mtk'=>$exp[0],'kel_praktek'=>$exp[1]])->count();
        if ($cek>0) {//jika praktek
                $jadwal=Absen_ajar_praktek::where(['kd_mtk'=>$exp[0],'kel_praktek'=>$exp[1]])->get();
                return Datatables::of($jadwal)
                ->addColumn('kelas', function ($jadwal) {
                    $aksi=$jadwal->kel_praktek;
                                return $aksi;
                        })
                        ->rawColumns(['kelas'])
                        ->make(true);
        } else {
            $jadwal=Absen_ajar::where(['kd_mtk'=>$exp[0],'kd_lokal'=>$exp[1]])->get();
            return Datatables::of($jadwal)
            ->addColumn('kelas', function ($jadwal) {
                $aksi=$jadwal->kd_lokal;
                            return $aksi;
                    })
                    ->rawColumns(['kelas'])
                    ->make(true);
        }
        
        
    }

   }

   public function rekap_manual_praktek(Request $request)
   {
       $jam=substr($request->jam_t,0,5).':00';
       $day = date('D', strtotime($request->tgl_ajar));
        $dayList = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        );
$cek = Absen_ajar_praktek::where(['nip'=>$request->nip,'kel_praktek'=>$request->kel_praktek,'kd_mtk'=>$request->kd_mtk,'tgl_ajar_masuk'=>$request->tgl_ajar,])->count();
if ($cek<1) {
    Absen_ajar_praktek::create([
        'nip'=>$request->nip,
        'kel_praktek'=>$request->kel_praktek,
        'kd_mtk'=>$request->kd_mtk,
        'nm_mtk'=>$request->nm_mtk,
        'sks'=>$request->sks,
        'tgl_ajar_masuk'=>$request->tgl_ajar,
        'hari_ajar_masuk'=>$dayList[$day],
        'jam_masuk'=>$jam,
        'no_ruang'=>$request->no_ruang,
        'pertemuan'=>$request->pertemuan,
        'sts_ajar'=>'M',
        'petugas_acc'=>Auth::user()->username,
        'jam_t'=>$request->jam_t,
        'kd_dosen'=>$request->kd_dosen]);
        return redirect('/kelas-input-manual/'.$request->id)->with('status','Menambah Pengajaran Manual');
} else {
    return redirect('/kelas-input-manual/'.$request->id)->with('error','Gagal Menambah Pengajaran Manual,Tanggal tidak boleh sama');

}

      
   }
   public function rekap_manual_teori(Request $request)
   {
    // dd($request->pertemuan);
       $jam=substr($request->jam_t,0,5).':00';
       $day = date('D', strtotime($request->tgl_ajar));
        $dayList = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        );
$cek = Absen_ajar::where(['nip'=>$request->nip,'kd_lokal'=>$request->kd_lokal,'kd_mtk'=>$request->kd_mtk,'tgl_ajar_masuk'=>$request->tgl_ajar,])->count();
if ($cek<1) {
    Absen_ajar::create([
        'nip'=>$request->nip,
        'kd_lokal'=>$request->kd_lokal,
        'kd_mtk'=>$request->kd_mtk,
        'nm_mtk'=>$request->nm_mtk,
        'sks'=>$request->sks,
        'tgl_ajar_masuk'=>$request->tgl_ajar,
        'hari_ajar_masuk'=>$dayList[$day],
        'jam_masuk'=>$jam,
        'no_ruang'=>$request->no_ruang,
        'pertemuan'=>$request->pertemuan,
        'sts_ajar'=>'M',
        'petugas_acc'=>Auth::user()->username,
        'jam_t'=>$request->jam_t,
        'kd_dosen'=>$request->kd_dosen]);
        return redirect('/kelas-input-manual/'.$request->id)->with('status','Menambah Pengajaran Manual');
} else {
    return redirect('/kelas-input-manual/'.$request->id)->with('error','Gagal Menambah Pengajaran Manual,Tanggal tidak boleh sama');

}

      
   }
   public function rekap_manual_gabung(Request $request)
   {
       $jam=substr($request->jam_t,0,5).':00';
       $day = date('D', strtotime($request->tgl_ajar));
        $dayList = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        );
$cek = Absen_ajar::where(['nip'=>$request->nip,'kd_lokal'=>$request->kd_lokal,'kd_mtk'=>$request->kd_mtk,'tgl_ajar_masuk'=>$request->tgl_ajar,])->count();
if ($cek<1) {
    Absen_ajar::create([
        'nip'=>$request->nip,
        'kd_lokal'=>$request->kd_lokal,
        'kd_mtk'=>$request->kd_mtk,
        'nm_mtk'=>$request->nm_mtk,
        'sks'=>$request->sks,
        'tgl_ajar_masuk'=>$request->tgl_ajar,
        'hari_ajar_masuk'=>$dayList[$day],
        'jam_masuk'=>$jam,
        'no_ruang'=>$request->no_ruang,
        'pertemuan'=>$request->pertemuan,
        'sts_ajar'=>'M',
        'petugas_acc'=>Auth::user()->username,
        'jam_t'=>$request->jam_t,
        'kd_dosen'=>$request->kd_dosen]);
        return redirect('/kelas-input-manual/'.$request->id)->with('status','Menambah Pengajaran Manual');
} else {
    return redirect('/kelas-input-manual/'.$request->id)->with('error','Gagal Menambah Pengajaran Manual,Tanggal tidak boleh sama');

}

      
   }
}
