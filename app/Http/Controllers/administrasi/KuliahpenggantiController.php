<?php

namespace App\Http\Controllers\administrasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Jadwal;
use App\Models\Kuliah_pengganti;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Crypt;

class KuliahpenggantiController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:kuliahganti_adm.index']);
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
        if (isset($_POST['kampus'])) {
            $kuliah_pengganti=DB::table('kuliah_pengganti')
            ->where(DB::raw('RIGHT(no_ruang, 2)'), '=', $_POST['kampus'])
            ->get();
            $kampus = DB::table('kampus')->get();
            $compect=['kampus','kuliah_pengganti'];
        }else{
            $kampus = DB::table('kampus')->get();
            $compect=['kampus'];
        }
        
        return view('administrasi.kelaspengganti.kelaspengganti',compact($compect));

    }
    public function edit($id)
    {
    // 0 => "WP2.12.3A.03.A"
    // 1 => "682"
    // 2 => "2021-02-03"
    // 3 => "2021-02-11"
    $exp = explode(",",Crypt::decryptString($id));
    $cek = Kuliah_pengganti::where(['kd_lokal'=>$exp[0],'kd_mtk'=>$exp[1],'tgl_yg_digantikan'=>$exp[2],'tgl_klh_pengganti'=>$exp[3]])->count();
    if ($cek<1) { // bukan teori
        $cek = Kuliah_pengganti::where(['kel_praktek'=>$exp[0],'kd_mtk'=>$exp[1],'tgl_yg_digantikan'=>$exp[2],'tgl_klh_pengganti'=>$exp[3]])->count();
        if ($cek>0) {// jika praktek
            $jadwal=Kuliah_pengganti::where(['kel_praktek'=>$exp[0],'kd_mtk'=>$exp[1],'tgl_yg_digantikan'=>$exp[2],'tgl_klh_pengganti'=>$exp[3]])
                ->first();
        } else {//jika gabung
            $jadwal=Kuliah_pengganti::where(['kd_gabung'=>$exp[0],'kd_mtk'=>$exp[1],'tgl_yg_digantikan'=>$exp[2],'tgl_klh_pengganti'=>$exp[3]])
                ->first();
        }
        
    } else {//jika teori
        $jadwal=Kuliah_pengganti::where(['kd_lokal'=>$exp[0],'kd_mtk'=>$exp[1],'tgl_yg_digantikan'=>$exp[2],'tgl_klh_pengganti'=>$exp[3]])
        ->first();
    }

        return view('administrasi.kelaspengganti.form_pengganti',compact('jadwal'));

    }
    public function pengganti_side($id)
   {
        $kuliah_pengganti=DB::table('kuliah_pengganti')
        ->where(DB::raw('RIGHT(no_ruang, 2)'), '=', $id)
        ->get();
        return Datatables::of($kuliah_pengganti)
        ->addColumn('sts_pengajuan', function ($kuliah_pengganti) {
            if ($kuliah_pengganti->sts_pengajuan=='0') {
                $aksi='<span class="badge badge-danger">Pengajuan Dosen</span>';
            } elseif($kuliah_pengganti->sts_pengajuan=='1') {
                $aksi='<span class="badge badge-warning">ACC dari ADM</span>';
            }else{
                $aksi='<span class="badge badge-success">ACC Ka. BAAK</span>';
            }
                        return $aksi;
                })
        ->addColumn('kelas', function ($kuliah_pengganti) {
            if ($kuliah_pengganti->kd_lokal<>null) {
                $aksi=$kuliah_pengganti->kd_lokal;
            } elseif($kuliah_pengganti->kel_praktek<>null) {
                $aksi=$kuliah_pengganti->kel_praktek;
            }else{
                $aksi=$kuliah_pengganti->kd_gabung;
            }
                        return $aksi;
                })
        ->addColumn('acc', function ($kuliah_pengganti) {
            if ($kuliah_pengganti->kd_lokal<>null) {
                $id=Crypt::encryptString($kuliah_pengganti->kd_lokal.','.$kuliah_pengganti->kd_mtk.','.$kuliah_pengganti->tgl_yg_digantikan.','.$kuliah_pengganti->tgl_klh_pengganti);
            } elseif($kuliah_pengganti->kel_praktek<>null) {
                $id=Crypt::encryptString($kuliah_pengganti->kel_praktek.','.$kuliah_pengganti->kd_mtk.','.$kuliah_pengganti->tgl_yg_digantikan.','.$kuliah_pengganti->tgl_klh_pengganti);
            }else{
                $id=Crypt::encryptString($kuliah_pengganti->kd_gabung.','.$kuliah_pengganti->kd_mtk.','.$kuliah_pengganti->tgl_yg_digantikan.','.$kuliah_pengganti->tgl_klh_pengganti);
            }
            if ($kuliah_pengganti->sts_pengajuan=='0') {
            $aksi='

            ';
    }else{
        $aksi='';
        }
                        return $aksi;
                })

            ->rawColumns(['sts_pengajuan','kelas','acc'])
            // ->rawColumns(['nomer'])
        ->make(true);
    
   }
   public function acc_pengganti($id)
   {
    // 0 => "WP2.12.3A.03.A"
    // 1 => "682"
    // 2 => "2021-02-03"
    // 3 => "2021-02-11"
    $exp = explode(",",Crypt::decryptString($id));
    $cek = Kuliah_pengganti::where(['kd_lokal'=>$exp[0],'kd_mtk'=>$exp[1],'tgl_yg_digantikan'=>$exp[2],'tgl_klh_pengganti'=>$exp[3]])->count();
    if ($cek<1) { // bukan teori
        $cek = Kuliah_pengganti::where(['kel_praktek'=>$exp[0],'kd_mtk'=>$exp[1],'tgl_yg_digantikan'=>$exp[2],'tgl_klh_pengganti'=>$exp[3]])->count();
        if ($cek>0) {// jika praktek
            Kuliah_pengganti::where(['kel_praktek'=>$exp[0],'kd_mtk'=>$exp[1],'tgl_yg_digantikan'=>$exp[2],'tgl_klh_pengganti'=>$exp[3]])
                ->update([
                    'sts_pengajuan'=>'1']);
        } else {//jika gabung
            Kuliah_pengganti::where(['kd_gabung'=>$exp[0],'kd_mtk'=>$exp[1],'tgl_yg_digantikan'=>$exp[2],'tgl_klh_pengganti'=>$exp[3]])
                ->update([
                    'sts_pengajuan'=>'1']);
        }
        
    } else {//jika teori
        Kuliah_pengganti::where(['kd_lokal'=>$exp[0],'kd_mtk'=>$exp[1],'tgl_yg_digantikan'=>$exp[2],'tgl_klh_pengganti'=>$exp[3]])
        ->update([
            'sts_pengajuan'=>'1']);
    }
    
    
            return redirect('/cek-kuliah-pengganti')->with('status','Terupdate');
   }
   public function hapus_pengganti($id)
   {
    // 0 => "WP2.12.3A.03.A"
    // 1 => "682"
    // 2 => "2021-02-03"
    // 3 => "2021-02-11"
    $exp = explode(",",Crypt::decryptString($id));
    $cek = Kuliah_pengganti::where(['kd_lokal'=>$exp[0],'kd_mtk'=>$exp[1],'tgl_yg_digantikan'=>$exp[2],'tgl_klh_pengganti'=>$exp[3]])->count();
    if ($cek<1) { // bukan teori
        $cek = Kuliah_pengganti::where(['kel_praktek'=>$exp[0],'kd_mtk'=>$exp[1],'tgl_yg_digantikan'=>$exp[2],'tgl_klh_pengganti'=>$exp[3]])->count();
        if ($cek>0) {// jika praktek
            Kuliah_pengganti::where(['kel_praktek'=>$exp[0],'kd_mtk'=>$exp[1],'tgl_yg_digantikan'=>$exp[2],'tgl_klh_pengganti'=>$exp[3]])
                ->delete();
        } else {//jika gabung
            Kuliah_pengganti::where(['kd_gabung'=>$exp[0],'kd_mtk'=>$exp[1],'tgl_yg_digantikan'=>$exp[2],'tgl_klh_pengganti'=>$exp[3]])
                ->delete();
        }
        
    } else {//jika teori
        Kuliah_pengganti::where(['kd_lokal'=>$exp[0],'kd_mtk'=>$exp[1],'tgl_yg_digantikan'=>$exp[2],'tgl_klh_pengganti'=>$exp[3]])
        ->delete();
    }
    
            return redirect('/cek-kuliah-pengganti')->with('status','Terhapus');
   }

   public function update(Request $request)
   {
    $date=date_create($request->jam_keluar);
    date_add($date, date_interval_create_from_date_string('-10 minutes'));
    $day = date('D', strtotime($request->tgl_pengganti));
$dayList = array(
    'Sun' => 'Minggu',
    'Mon' => 'Senin',
    'Tue' => 'Selasa',
    'Wed' => 'Rabu',
    'Thu' => 'Kamis',
    'Fri' => 'Jumat',
    'Sat' => 'Sabtu'
);
    $cek = Kuliah_pengganti::where(['kd_lokal'=>$request->kelas,'kd_mtk'=>$request->kd_mtk,'tgl_yg_digantikan'=>$request->tgl_sebelum_old,'tgl_klh_pengganti'=>$request->tgl_pengganti_old])->count();
    if ($cek<1) { // bukan teori
        $cek = Kuliah_pengganti::where(['kel_praktek'=>$request->kelas,'kd_mtk'=>$request->kd_mtk,'tgl_yg_digantikan'=>$request->tgl_sebelum_old,'tgl_klh_pengganti'=>$request->tgl_pengganti_old])->count();
        if ($cek>0) {// jika praktek
            Kuliah_pengganti::where(['kel_praktek'=>$request->kelas,'kd_mtk'=>$request->kd_mtk,'tgl_yg_digantikan'=>$request->tgl_sebelum_old,'tgl_klh_pengganti'=>$request->tgl_pengganti_old])
                ->update([
                    'hari_t'=>$dayList[$day],
                    'tgl_yg_digantikan'=>$request->tgl_sebelum,
                    'tgl_klh_pengganti'=>$request->tgl_pengganti,
                    'jam_t'=>$request->jam_masuk.'-'.$request->jam_keluar,
                    'no_ruang'=>$request->ruang,
                    'mulai'=>$request->jam_masuk,
                    'selesai'=>$request->jam_keluar,
    'selesai_interval'=>date_format($date, 'H:i')]);
        } else {//jika gabung
            Kuliah_pengganti::where(['kd_gabung'=>$request->kelas,'kd_mtk'=>$request->kd_mtk,'tgl_yg_digantikan'=>$request->tgl_sebelum_old,'tgl_klh_pengganti'=>$request->tgl_pengganti_old])
                ->update([
                    'hari_t'=>$dayList[$day],
                    'tgl_yg_digantikan'=>$request->tgl_sebelum,
                    'tgl_klh_pengganti'=>$request->tgl_pengganti,
                    'jam_t'=>$request->jam_masuk.'-'.$request->jam_keluar,
                    'no_ruang'=>$request->ruang,
                    'mulai'=>$request->jam_masuk,
                    'selesai'=>$request->jam_keluar,
    'selesai_interval'=>date_format($date, 'H:i')]);
        }
    } else {//jika teori
        Kuliah_pengganti::where(['kd_lokal'=>$request->kelas,'kd_mtk'=>$request->kd_mtk,'tgl_yg_digantikan'=>$request->tgl_sebelum_old,'tgl_klh_pengganti'=>$request->tgl_pengganti_old])
        ->update([
            'hari_t'=>$dayList[$day],
            'tgl_yg_digantikan'=>$request->tgl_sebelum,
            'tgl_klh_pengganti'=>$request->tgl_pengganti,
            'jam_t'=>$request->jam_masuk.'-'.$request->jam_keluar,
            'no_ruang'=>$request->ruang,
            'mulai'=>$request->jam_masuk,
            'selesai'=>$request->jam_keluar,
    'selesai_interval'=>date_format($date, 'H:i')]);
    }
    return redirect('/cek-kuliah-pengganti')->with('status','Terupdate');
   }

}
