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
    // Validasi input paket
    $request->validate([
        'paket' => 'required|in:UTS,UAS'
    ]);

    // Inisialisasi query
    $query = Ujian_berita_acara::query();

    // Join dengan tabel kampus berdasarkan dua digit terakhir no ruang
    $query->join('kampus', function($join) {
        $join->on(DB::raw('RIGHT(ujian_berita_acaras.no_ruang, 2)'), '=', 'kampus.kd_kampus');
    });

    // Pencarian berdasarkan paket
    if ($request->filled('paket')) {
        $query->where('ujian_berita_acaras.paket', $request->paket);
    }

    // Pencarian berdasarkan kode dosen
    if ($request->filled('kd_dosen')) {
        $query->where('ujian_berita_acaras.kd_dosen', $request->kd_dosen);
    }

    // Pencarian berdasarkan kelompok ujian
    if ($request->filled('kel_ujian')) {
        $query->where('ujian_berita_acaras.kel_ujian', $request->kel_ujian);
    }

    // Pencarian berdasarkan dua digit terakhir no ruang
    if ($request->filled('no_ruang')) {
        $query->whereRaw('RIGHT(ujian_berita_acaras.no_ruang, 2) = ?', [$request->no_ruang]);
    }

    // Pencarian berdasarkan tanggal ujian
    if ($request->filled('tgl_ujian')) {
        $query->whereDate('ujian_berita_acaras.tgl_ujian', $request->tgl_ujian);
    }

    // Ambil hasil query
    $peserta = $query->get(['ujian_berita_acaras.*', 'kampus.nm_kampus']);
        // Kirim data ke view
        return view('admin.ujian.uts.adm.rekap_bap.cari', compact('peserta'));
    }
    

}
