<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Jadwal;
use App\Models\PertemuanSisfo;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Crypt;

class Riwayat_mengajarController extends Controller
{
    public function __construct()
    {
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
      
        if (isset($_POST['jklh'])) {
            $all_riwayat = DB::connection('sisfo.bsi')->select("selectx * from pertemuan a join jdw_klh b on a.no_j_klh=b.no_j_klh join mtk c on a.kd_mtk=c.kd_mtk where a.kd_dosen='".Auth::user()->kode."' and a.no_j_klh='".$_POST['jklh']."'");
            $riwayat = DB::connection('sisfo.bsi')->select("selectx a.no_j_klh, b.tgl_j_klh, b.periode from pertemuan a join jdw_klh b on a.no_j_klh=b.no_j_klh where kd_dosen='".Auth::user()->kode."'  GROUP BY a.no_j_klh order by b.tgl_j_klh");
            $compect=['riwayat','all_riwayat'];

        }else{
            $riwayat = DB::connection('sisfo.bsi')->select("selectx a.no_j_klh, b.tgl_j_klh, b.periode from pertemuan a join jdw_klh b on a.no_j_klh=b.no_j_klh where kd_dosen='".Auth::user()->kode."'  GROUP BY a.no_j_klh order by b.tgl_j_klh");
            $compect=['riwayat'];
        }
        
        return view('admin.rwy_mengajar.rwy_mengajar',compact($compect));

    }
    

}
