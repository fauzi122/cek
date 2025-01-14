<?php

namespace App\Http\Controllers\ujian\uts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use App\Exports\RekapabsenExport;
use App\Models\Soal_ujian;

class RekapAbsenController extends Controller
{
    public function __construct()
    {
       $this->middleware(['permission:ujian_absen']);
       if(!$this->middleware('auth:sanctum')){
        return redirect('/login');
    }
    }
    public function index()
    {
    if (Auth::user()->utype == 'ADM') {

        $cabangs =Soal_ujian::groupBy('nm_kampus')->get();
        $tgl =Soal_ujian::whereIn('paket', ['UTS', 'UAS'])->groupBy('tgl_ujian')->get();
        return view('admin.ujian.uts.adm.rekap_absen.index', compact('cabangs','tgl'));
        } else {
            return redirect('/dashboard');
        }
    }

   
    public function exportToExcel(Request $request)
    {
        // Validasi request
        $request->validate([
            'paket' => 'nullable|string',
            'tgl_ujian' => 'nullable|date',
            'bermasalah' => 'nullable|in:1,0',
            'nm_kampus' => 'nullable|string'
        ]);
    
        // Initialize data array
        $data = collect();
    
        // Query dasar
        $baseQuery = DB::table('uts_soals as us')
            ->join('absen_ujians as au', function($join) {
                $join->on('us.kd_mtk', '=', 'au.kd_mtk')
                     ->on('us.kel_ujian', '=', 'au.no_kel_ujn')
                     ->on('us.paket', '=', 'au.paket');
            })
            ->select(
                'au.nim', 'au.nm_mhs', 'au.status', DB::raw('au.paket AS paket_absen'),
                DB::raw('au.kd_dosen AS kd_dosen_absen'), 'us.kd_lokal',
                DB::raw('LEFT(us.kd_lokal, 2) AS kd_jurusan'), DB::raw('RIGHT(us.kd_lokal, 2) AS kd_cabang'),
                'au.no_kel_ujn', 'us.hari_t', 'us.no_ruang', 'us.nm_mtk', 'us.kd_mtk',
                'us.jam_t', 'us.nm_kampus', 'us.paket', 'us.tgl_ujian',
                DB::raw('au.kd_mtk AS kd_mtk_absen'), 'au.ket'
            )->where('au.kd_dosen','<>','');
    
        // Menambahkan filter
        if ($request->filled('bermasalah')) {
            $baseQuery->where($request->bermasalah == '1' ? 'au.ket' : 'au.ket', $request->bermasalah == '1' ? '!=' : '=', null);
        }
        if ($request->filled('paket')) {
            $baseQuery->where('us.paket', $request->paket);
        }
        if ($request->filled('tgl_ujian')) {
            $baseQuery->whereDate('us.tgl_ujian', '=', $request->tgl_ujian);
        }
        if ($request->filled('nm_kampus')) {
            $baseQuery->where('us.nm_kampus', '=', $request->nm_kampus);
        }
    
        // Menggunakan cursor
        foreach ($baseQuery->cursor() as $row) {
            $data->push($row);
        }
    
        // Export to Excel
        return Excel::download(new RekapabsenExport($data), 'rekapabsen_data.xlsx');
    }
    
}
