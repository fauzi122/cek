<?php

namespace App\Http\Controllers\ujian\uts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\Ujian_berita_acara;
use App\Models\Soal_ujian;
use App\Models\Absen_ujian;
use Carbon\Carbon;
use App\Models\Paket_ujian;

class AdmRekapMengawasController extends Controller
{
    public function __construct()
    {
        if (!$this->middleware('auth:sanctum')) {
            return redirect('/login');
        }
    }

    public function index()
    {
        $examTypes = Paket_ujian::distinct()->pluck('paket');

        $encryptedExamTypes = $examTypes->mapWithKeys(function ($item) {
            return [$item => Crypt::encryptString($item)];
        });
    
        $paketUjian = Paket_ujian::all();
        return view('admin.ujian.uts.adm.rekap.index', compact('encryptedExamTypes', 'paketUjian'));
       
    } 

    public function uts($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));

        $jadwal = Soal_ujian::where([
            'paket'    => $pecah[0]
            ])->get();

        $result = DB::table('uts_soals')
                ->join('ujian_berita_acaras', function($join) {
                    $join->on('uts_soals.kel_ujian', '=', 'ujian_berita_acaras.kel_ujian')
                    ->on('uts_soals.kd_mtk', '=', 'ujian_berita_acaras.kd_mtk');
                    })
                ->select('ujian_berita_acaras.*', 'uts_soals.kd_dosen', 'uts_soals.kel_ujian', 'uts_soals.kd_mtk')
                ->where(['uts_soals.paket'    => $pecah[0]])->get();
    
        // Membuat array untuk pencocokan data
        $resultArray = $result->mapWithKeys(function ($item) {
            return [$item->kd_dosen . '_' . $item->kel_ujian . '_' . $item->kd_mtk => $item];
        })->toArray();

        return view('admin.ujian.uts.adm.rekap.uts',compact('jadwal', 'resultArray'));

    }

    public function show($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));

        dd($pecah[2]);

        $soal = Soal_ujian::where([
            'kd_dosen'    => $pecah[0],
            'kd_mtk'      => $pecah[1],
            'kel_ujian'   => $pecah[2],
            'paket'       => $pecah[3]        
            ])->first();
        
        $beritaAcara = Ujian_berita_acara::where([
            'kd_dosen'    => $pecah[0],
            'kd_mtk'      => $pecah[1],
            'kel_ujian'   => $pecah[2],
            'paket'       => $pecah[3] 
            ])->first();

        return view('admin.ujian.uts.adm.rekap.show',compact('beritaAcara','soal'));
    }

    public function jadwal($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));

        $jadwal = Soal_ujian::where([
            'paket'    => $pecah[0]
            ])->get();

        $result = DB::table('uts_soals')
                ->join('ujian_berita_acaras', function($join) {
                    $join->on('uts_soals.kel_ujian', '=', 'ujian_berita_acaras.kel_ujian')
                    ->on('uts_soals.kd_mtk', '=', 'ujian_berita_acaras.kd_mtk');
                    })
                ->select('ujian_berita_acaras.*', 'uts_soals.kd_dosen', 'uts_soals.kel_ujian', 'uts_soals.kd_mtk')
                ->where(['uts_soals.paket'    => $pecah[0]])->get();
    
        // Membuat array untuk pencocokan data
        $resultArray = $result->mapWithKeys(function ($item) {
            return [$item->kd_dosen . '_' . $item->kel_ujian . '_' . $item->kd_mtk => $item];
        })->toArray();
    
        return view('admin.ujian.uts.adm.rekap.jadwal', compact('jadwal', 'resultArray'));
    }
    
}
