<?php

namespace App\Http\Controllers\ujian\uts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ujian_berita_acara;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class RekapBapController extends Controller
{
    public function __construct()
    {
       $this->middleware(['permission:ujian_bap']);
       if(!$this->middleware('auth:sanctum')){
        return redirect('/login');
    }
    }
    public function index()
    {
    if (Auth::user()->utype == 'ADM') {

        $result = DB::table('ujian_berita_acaras')
        ->join('kampus', DB::raw('RIGHT(ujian_berita_acaras.no_ruang, 2)'), '=', 'kampus.kd_kampus')
        ->select('ujian_berita_acaras.*', 'kampus.*')
        ->get();

        $kampus=DB::table('kampus')->select('nm_kampus','kd_kampus')->get();

    
        return view('admin.ujian.uts.adm.rekap_bap.index', compact('result','kampus'));
        } else {
            return redirect('/dashboard');
        }
    }


    public function caribap(Request $request)
    {
        $query = Ujian_berita_acara::query();
    
        // Join dengan tabel kampus berdasarkan dua digit terakhir no ruang
        $query->join('kampus', function($join) {
            $join->on(DB::raw('RIGHT(ujian_berita_acara.no_ruang, 2)'), '=', 'kampus.kd_kampus');
        });
    
        // Pencarian berdasarkan kode dosen
        if ($request->has('kd_dosen') && !empty($request->kd_dosen)) {
            $query->where('ujian_berita_acara.kd_dosen', $request->kd_dosen);
        }
    
        // Pencarian berdasarkan kelompok ujian
        if ($request->has('kel_ujian') && !empty($request->kel_ujian)) {
            $query->where('ujian_berita_acara.kel_ujian', $request->kel_ujian);
        }
    
        // Pencarian berdasarkan dua digit terakhir no ruang
        if ($request->has('no_ruang') && !empty($request->no_ruang)) {
            $query->whereRaw('RIGHT(ujian_berita_acara.no_ruang, 2) = ?', [$request->no_ruang]);
        }
    
        // Pencarian berdasarkan tanggal ujian
        if ($request->has('tgl_ujian') && !empty($request->tgl_ujian)) {
            $query->whereDate('ujian_berita_acara.tgl_ujian', $request->tgl_ujian);
        }
    
        $peserta = $query->get();
    
        return view('admin.ujian.uts.adm.rekap_bap.index', compact('peserta'));
    }
    

}
