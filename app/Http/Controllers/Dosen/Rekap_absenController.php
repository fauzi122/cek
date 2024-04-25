<?php

namespace App\Http\Controllers\Dosen;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Absen_ajar;
use App\Models\Absen_gabung;
use App\Models\Absen_ajar_praktek;
use Storage;

class Rekap_absenController extends Controller
{
    public function __construct()
    {
        // dd("adfdadaf");
        if(!$this->middleware('auth:sanctum')){
            return redirect('/login');
        }
    }
    
    public function index()
    {
        $where=['nip'=>Auth::user()->username];
        $group=['kd_gabung','kd_mtk','no_ruang','jam_t','hari_t'];
        $jadwal = app('App\Models\Absen_ajar')->jadwal_all($where,$group)->get();
        $compact=['jadwal'];
        return view('admin.rekap_absen.jadwal_mengajar',compact($compact));
    }

    public function store_praktek(Request $request)
    {
        $w_cektemu=['kel_praktek'=>$request->kel_praktek,'kd_mtk'=>$request->kd_mtk];
        $w_rekapmhs=['a.kel_praktek'=>$request->kel_praktek,'a.kd_mtk'=>$request->kd_mtk];
        $cektemu = app('App\Models\Rekap_absen')->get_editrekap($w_cektemu)->get();
        $rekapmhs = app('App\Models\Rekap_absen')->get_rekapabsen_mhs_ext($w_rekapmhs);
        $mtk = app('App\Models\Rekap_absen')->get_mtk($request->kd_mtk);
        $kel_praktek=$request->kel_praktek;
        return view('admin.rekap_absen.rekap_absen',compact('cektemu','rekapmhs','mtk','kel_praktek'));
    }

    public function detail_praktek(Request $request)
    {
        $w_jadwal=['kd_mtk'=>$request->kd_mtk,'kel_praktek'=>$request->kel_praktek];
        $w_cek = ['kel_praktek'=>$request->kel_praktek,'kd_mtk'=>$request->kd_mtk,'tgl_ajar_masuk'=>date('Y-m-d')];
        $w_pert = ['kel_praktek'=>$request->kel_praktek,'kd_mtk'=>$request->kd_mtk];
        $w_showMhs = ['b.kel_praktek'=>$request->kel_praktek,'d.pertemuan'=>$request->pertemuan,'b.kd_mtk'=>$request->kd_mtk];
        $w_temu_ajar = ['kel_praktek'=>$request->kel_praktek,'pertemuan'=>$request->pertemuan,'kd_mtk'=>$request->kd_mtk];
        $berita_acara=Absen_ajar_praktek::select('pertemuan','berita_acara','rangkuman','kel_praktek','file_ajar')
        ->where($w_pert)->get();
        $absen_keluar = app('App\Models\Absen_ajar_praktek')->cek_bap($w_cek)->first();
        $mahasiswa = app('App\Models\Absen_ajar_praktek')->showMhs($w_showMhs);
        if(!isset($mahasiswa)){
            return redirect('/rekap-absen')->with('error','Maaf Pertemuan '.$request->pertemuan.' Kelas '. $request->kd_lokal.' yang Bapak/Ibu pilih kemungkinan belum tersedia!');
        }
        $jml_mhs = app('App\Models\Absen_ajar_praktek')->jumlah_mhs($w_showMhs);
        $jml_hadir = app('App\Models\Absen_ajar_praktek')->jml_hadir($request->kel_praktek,$request->kd_mtk,$request->pertemuan);
        $mhs_hadir = app('App\Models\Absen_ajar_praktek')->mhs_hadir($request->kel_praktek,$request->kd_mtk,$request->pertemuan);
        $temu_ajar = app('App\Models\Absen_ajar_praktek')->temu_ajar($w_temu_ajar);
        $jadwal = app('App\Models\Absen_ajar_praktek')->jadwal($w_jadwal)->get();
        $id=base64_encode($request->kd_mtk.','.$request->kel_praktek.','.$request->pertemuan);
        return view('admin.rekap_absen.ajar_praktek',compact('mahasiswa','mhs_hadir','temu_ajar','jadwal','jml_mhs','jml_hadir','berita_acara','id'));
    }

    public function bap_praktek(Request $request)
    {
        $request->validate([
            'rangkuman' => 'required',
            'bap' => 'required',
            'file' => 'required|file|mimes:pdf,jpeg,jpg,doc,docx,png|max:2000',
            ]);
            $w_pert = ['kd_mtk'=>$request->kd_mtk,'kel_praktek'=>$request->kel_praktek,'pertemuan'=>$request->pertemuan];
            $bap=Absen_ajar_praktek::select('file_ajar')
            ->where($w_pert)->first();
            // dd($bap->file_ajar);
            Storage::delete('public/ajar/'.$bap->file_ajar);
        $file = $request->file('file');
        $file->storeAs('public/ajar', $file->hashName());
        $simpan=Absen_ajar_praktek::where($w_pert)
                ->update([
                    'rangkuman'=>$request->rangkuman,
                    'berita_acara'=>$request->bap,
                    'file_ajar'=>$file->hashName()]);
        if ($simpan) {
            session()->flash('status', 'Diubah');
        }else{
            session()->flash('error', 'Gagal Diubah');
        }
                    
            return redirect('/rekap-absen');
    }


    public function store_teori(Request $request)
    {
        $w_cektemu=['kd_lokal'=>$request->kd_lokal,'kd_mtk'=>$request->kd_mtk];
        $w_rekapmhs=['a.kd_lokal'=>$request->kd_lokal,'a.kd_mtk'=>$request->kd_mtk];
        $cektemu = app('App\Models\Rekap_absen')->get_editrekap_teori($w_cektemu)->get();
        $rekapmhs = app('App\Models\Rekap_absen')->get_rekapabsen_mhs_ext($w_rekapmhs);
        $mtk = app('App\Models\Rekap_absen')->get_mtk($request->kd_mtk);
        $kd_lokal=$request->kd_lokal;
        return view('admin.rekap_absen.rekap_absen',compact('cektemu','rekapmhs','mtk','kd_lokal'));
    }

    public function detail_teori(Request $request)
    {
$w_jadwal=['kd_mtk'=>$request->kd_mtk,'kd_lokal'=>$request->kd_lokal];
$w_cek = ['kd_lokal'=>$request->kd_lokal,'kd_mtk'=>$request->kd_mtk,'tgl_ajar_masuk'=>date('Y-m-d')];
$w_pert = ['kd_mtk'=>$request->kd_mtk,'kd_lokal'=>$request->kd_lokal];
$w_showMhs = ['a.kd_lokal'=>$request->kd_lokal,'d.pertemuan'=>$request->pertemuan,'b.kd_mtk'=>$request->kd_mtk];
$w_temu_ajar = ['kd_lokal'=>$request->kd_lokal,'pertemuan'=>$request->pertemuan,'kd_mtk'=>$request->kd_mtk];
        $berita_acara=Absen_ajar::select('pertemuan','berita_acara','rangkuman','kd_lokal','file_ajar')
        ->where($w_pert)->get();
        $absen_keluar = app('App\Models\Absen_ajar')->cek_bap($w_cek)->first();
        $mahasiswa = app('App\Models\Absen_ajar')->showMhs($w_showMhs);
        if(!isset($mahasiswa)){
            return redirect('/rekap-absen')->with('error','Maaf Pertemuan '.$request->pertemuan.' Kelas '. $request->kd_lokal.' yang Bapak/Ibu pilih kemungkinan belum tersedia!');
        }
        $jml_mhs = app('App\Models\Absen_ajar')->jumlah_mhs($w_showMhs);
        $jml_hadir = app('App\Models\Absen_ajar')->jml_hadir($request->kd_lokal,$request->kd_mtk,$request->pertemuan);
        $mhs_hadir = app('App\Models\Absen_ajar')->mhs_hadir($request->kd_lokal,$request->kd_mtk,$request->pertemuan);
        $temu_ajar = app('App\Models\Absen_ajar')->temu_ajar($w_temu_ajar);
        $jadwal = app('App\Models\Absen_ajar')->jadwal($w_jadwal)->get();
        $id=base64_encode($request->kd_mtk.','.$request->kd_lokal.','.$request->pertemuan);
        return view('admin.rekap_absen.ajar_teori',compact('mahasiswa','mhs_hadir','temu_ajar','jadwal','jml_mhs','jml_hadir','berita_acara','id'));
    }

    public function bap_teori(Request $request)
    {
        $request->validate([
            'rangkuman' => 'required',
            'bap' => 'required',
            'file' => 'required|file|mimes:pdf,jpeg,jpg,doc,docx,png|max:2000',
            ]);
            $w_pert = ['kd_mtk'=>$request->kd_mtk,'kd_lokal'=>$request->kd_lokal,'pertemuan'=>$request->pertemuan];
            $bap=Absen_ajar::select('file_ajar')
            ->where($w_pert)->first();
            // dd($bap);
            Storage::delete('public/ajar/'.$bap->file_ajar);
        $file = $request->file('file');
        $file->storeAs('public/ajar', $file->hashName());
        $simpan=Absen_ajar::where($w_pert)
                ->update([
                    'rangkuman'=>$request->rangkuman,
                    'berita_acara'=>$request->bap,
                    'file_ajar'=>$file->hashName()]);
        if ($simpan) {
            session()->flash('status', 'Diubah');
        }else{
            session()->flash('error', 'Gagal Diubah');
        }
                    
            return redirect('/rekap-absen');
    }
    public function store_gabung(Request $request)
    {
        
        $w_cektemu=['kd_lokal'=>$request->kd_lokal,'kd_mtk'=>$request->kd_mtk];
        $w_rekapmhs=['a.kd_gabung'=>$request->kd_lokal,'a.kd_mtk'=>$request->kd_mtk];
        $cektemu = app('App\Models\Rekap_absen')->get_editrekap_teori($w_cektemu)->get();
        $rekapmhs = app('App\Models\Rekap_absen')->get_rekapabsen_mhs_ext($w_rekapmhs);
        $mtk = app('App\Models\Rekap_absen')->get_mtk($request->kd_mtk);
        $kd_gabung=$request->kd_lokal;
        // dd();
        return view('admin.rekap_absen.rekap_absen',compact('cektemu','rekapmhs','mtk','kd_gabung'));
    }

    public function detail_gabung(Request $request)
    {
        // dd($request->kd_lokal);
        $w_jadwal=['kd_mtk'=>$request->kd_mtk,'kd_gabung'=>$request->kd_lokal];
        $w_cek = ['kd_lokal'=>$request->kd_lokal,'kd_mtk'=>$request->kd_mtk,'tgl_ajar_masuk'=>date('Y-m-d')];
        $w_pert = ['kd_mtk'=>$request->kd_mtk,'kd_lokal'=>$request->kd_lokal];
        $w_showMhs = ['a.kd_lokal'=>$request->kd_lokal,'d.pertemuan'=>$request->pertemuan,'b.kd_mtk'=>$request->kd_mtk];
        $w_temu_ajar = ['kd_lokal'=>$request->kd_lokal,'pertemuan'=>$request->pertemuan,'kd_mtk'=>$request->kd_mtk];
        $berita_acara=Absen_ajar::select('pertemuan','berita_acara','rangkuman','kd_lokal','file_ajar')
        ->where($w_pert)->get();
        $absen_keluar = app('App\Models\Absen_gabung')->cek_bap($w_cek)->first();
        $mahasiswa = app('App\Models\Absen_gabung')->showMhs($request->kd_lokal,$request->kd_mtk);
        if(!isset($mahasiswa)){
            return redirect('/rekap-absen')->with('error','Maaf Pertemuan '.$request->pertemuan.' Kelas '. $request->kd_lokal.' yang Bapak/Ibu pilih kemungkinan belum tersedia!');
        }
        $jml_mhs = app('App\Models\Absen_gabung')->jumlah_mhs($request->kd_lokal,$request->kd_mtk);
        $jml_hadir = app('App\Models\Absen_gabung')->jml_hadir($request->kd_lokal,$request->kd_mtk,$request->pertemuan);
        $mhs_hadir = app('App\Models\Absen_gabung')->mhs_hadir($request->kd_lokal,$request->kd_mtk,$request->pertemuan);
        $temu_ajar = app('App\Models\Absen_gabung')->temu_ajar($w_temu_ajar);
        $jadwal = app('App\Models\Absen_gabung')->jadwal($w_jadwal,$request->kd_lokal)->get();
        // dd($jadwal);
        $id=base64_encode($request->kd_mtk.','.$request->kd_lokal.','.$request->pertemuan);
        return view('admin.rekap_absen.ajar_gabung',compact('mahasiswa','mhs_hadir','temu_ajar','jadwal','jml_mhs','jml_hadir','berita_acara','id'));
    }

    public function bap_gabung(Request $request)
    {
        
        $request->validate([
            'rangkuman' => 'required',
            'bap' => 'required',
            'file' => 'required|file|mimes:pdf,jpeg,jpg,doc,docx,png|max:2000',
            ]);
            $w_pert = ['kd_mtk'=>$request->kd_mtk,'kd_lokal'=>$request->kd_lokal,'pertemuan'=>$request->pertemuan];
            $bap=Absen_ajar::select('file_ajar')
            ->where($w_pert)->first();
            // dd($bap->file_ajar);
            Storage::delete('public/ajar/'.$bap->file_ajar);
        $file = $request->file('file');
        $file->storeAs('public/ajar', $file->hashName());
        $simpan=Absen_ajar::where($w_pert)
                ->update([
                    'rangkuman'=>$request->rangkuman,
                    'berita_acara'=>$request->bap,
                    'file_ajar'=>$file->hashName()]);
        if ($simpan) {
            session()->flash('status', 'Diubah');
        }else{
            session()->flash('error', 'Gagal Diubah');
        }
                    
            return redirect('/rekap-absen');
    }

}
