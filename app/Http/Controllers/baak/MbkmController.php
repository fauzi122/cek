<?php

namespace App\Http\Controllers\baak;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mbkm;
use Illuminate\Support\Facades\DB;
use App\Imports\MbkmImport;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Crypt;



class MbkmController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:mbkm_baak.index |mbkm_baak.upload|mbkm_baak.edit|mbkm_baak.delete']);
        if (!$this->middleware('auth:sanctum')) {
            return redirect('/login');
        }
    }
    public function index()
    {
        $jadwal = mbkm::get();
        return view('baak.jadwalmbkm.index', compact('jadwal'));
    }

    public function nilai_mbkm()
    {
        $nilai = DB::table('jadwal_mbkm')
            // ->where('kd_dosen',Auth::user()->kode)
            ->groupBy('kd_dosen', 'kd_mtk', 'kd_lokal')->get();
        // dd($nilai);
        return view('baak.jadwalmbkm.nilai_mbkm', compact('nilai'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function create_nilai($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));

        // pts
        $dosen = DB::table('nilai_mbkm')
            ->where([
                'kd_dosen' => $pecah[0],
                'kd_lokal' => $pecah[1],
                'kd_mtk'   => $pecah[2]
            ])->select('nilai_mbkm.*')
            ->first();

        // absen mbkm
        $nilai = DB::table('nilai_mbkm')->leftjoin('pts_mbkm', 'pts_mbkm.kd_pt', '=', 'nilai_mbkm.kd_kampus')
            ->where([
                'nilai_mbkm.kd_dosen' => $pecah[0],
                'nilai_mbkm.kd_lokal' => $pecah[1],
                'nilai_mbkm.kd_mtk'   => $pecah[2]

            ])->select('nilai_mbkm.*', 'pts_mbkm.*')
            ->get();

        // dd($nilai);
        return view('baak.jadwalmbkm.nilai_perkls_mbkm', compact('nilai', 'dosen'));
    }

    public function nilia_mbkm_all()
    {
        $nilaiall = DB::table('nilai_mbkm')->leftjoin('pts_mbkm', 'pts_mbkm.kd_pt', '=', 'nilai_mbkm.kd_kampus')
            ->select('nilai_mbkm.*', 'pts_mbkm.*')
            ->get();
        // dd($nilaiall);
        return view('baak.jadwalmbkm.nilai_all_mbkm', compact('nilaiall'));
    }

    public function ajar_dosen_mbkm()
    {

        $ajar_mbkm = DB::table('absen_ajars')->whereRaw("(left(kd_lokal, 2) IN('77','80'))")->get();
        return view('baak.jadwalmbkm.ajar_dosen', compact('ajar_mbkm'));
    }
    public function absenmhs_mbkm()
    {

        $absen_mbkm = DB::table('rekap_absen_mbkm')->get();
        $temu = DB::select('call absen_mbkm');
        return view('baak.jadwalmbkm.absen_dosen', compact('absen_mbkm'));
    }

    public function storeData(Request $request)
    {
        //VALIDASI
        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file'); //GET FILE
            Excel::import(new MbkmImport, $file); //IMPORT FILE 
            return redirect()->back()->with(['success' => 'Upload success']);
        }
        return redirect()->back()->with(['error' => 'Please choose file before']);
    }
    public function tjadwalmbkm()
    {
        $temu = DB::table('jadwal_mbkm')->truncate();
        return redirect()->back()->with(['success' => 'success terhapus']);
    }
}
