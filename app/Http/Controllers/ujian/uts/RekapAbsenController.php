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
       $this->middleware(['permission:ujian_bap']);
       if(!$this->middleware('auth:sanctum')){
        return redirect('/login');
    }
    }
    public function index()
    {
    if (Auth::user()->utype == 'ADM') {

        $cabangs =Soal_ujian::groupBy('nm_kampus')->get();

        $result = DB::table('el_ujian.uts_soals as us')
        ->join('el_ujian.absen_ujians as au', function($join) {
            $join->on('us.kd_mtk', '=', 'au.kd_mtk')
                 ->on('us.kel_ujian', '=', 'au.no_kel_ujn')
                 ->on('us.paket', '=', 'au.paket');
        })
        ->select(
            'au.nim',
            'au.nm_mhs',
            'au.status',
            'au.paket as paket_absen',
            'au.kd_dosen as kd_dosen_absen',
            'us.kd_lokal',
            DB::raw('LEFT(us.kd_lokal, 2) as kd_jurusan'),   // Mengambil 2 karakter dari kiri untuk kd_jurusan
            DB::raw('RIGHT(us.kd_lokal, 2) as kd_cabang'),  // Mengambil 2 karakter dari kanan untuk kd_cabang
            'au.no_kel_ujn',
            'us.hari_t',
            'us.no_ruang',
            'us.nm_mtk',
            'us.kd_mtk',
            'us.jam_t',
            'us.nm_kampus',
            'us.paket',
            'us.tgl_ujian',
            'au.kd_mtk as kd_mtk_absen',
            'au.ket'
        )
        ->when(request()->tgl, function ($query) {
            return $query->whereDate('us.tgl_ujian', '=', request()->tgl);
        })
        ->when(request()->ket, function ($query) {
            return $query->whereNotNull('au.ket')
                         ->where('au.ket', '<>', '');
        })
        ->when(request()->nm_kampus, function ($query) {
            return $query->where('us.nm_kampus', '=', request()->nm_kampus);
        }, function ($query) {
            // Tidak menerapkan filter jika 'nm_kampus' tidak disediakan, menampilkan semua kampus
            return $query;
        })
        ->where('au.kd_dosen', '<>', '')
        ->whereNotNull('au.kd_dosen')
        ->paginate(20);

    
        return view('admin.ujian.uts.adm.rekap_absen.index', compact('cabangs','result'));
        } else {
            return redirect('/dashboard');
        }
    }

    public function exportToExcel(Request $request)
    {
        $query = DB::table('el_ujian.uts_soals as us')
            ->join('el_ujian.absen_ujians as au', function($join) {
                $join->on('us.kd_mtk', '=', 'au.kd_mtk')
                     ->on('us.kel_ujian', '=', 'au.no_kel_ujn')
                     ->on('us.paket', '=', 'au.paket');
            })
            ->select(
                'au.nim',
                'au.nm_mhs',
                'au.status',
                DB::raw('au.paket AS paket_absen'),
                DB::raw('au.kd_dosen AS kd_dosen_absen'),
                'us.kd_lokal',
                DB::raw('LEFT(us.kd_lokal, 2) AS kd_jurusan'),
                DB::raw('RIGHT(us.kd_lokal, 2) AS kd_cabang'),
                'au.no_kel_ujn',
                'us.hari_t',
                'us.no_ruang',
                'us.nm_mtk',
                'us.kd_mtk',
                'us.jam_t',
                'us.nm_kampus',
                'us.paket',
                'us.tgl_ujian',
                DB::raw('au.kd_mtk AS kd_mtk_absen'),
                'au.ket'
            )
            ->where('au.kd_dosen', '<>', '')
            ->whereNotNull('au.kd_dosen');
        dd($query);
    
        // Filter berdasarkan status masalah
        if ($request->filled('bermasalah')) {
            if ($request->bermasalah == '1') {
                // Bermasalah: 'ket' harus memiliki isi
                $query->whereNotNull('au.ket');
            } elseif ($request->bermasalah == '0') {
                // Tidak Bermasalah: 'ket' harus null
                $query->whereNull('au.ket');
            }
        }
    
        // Filter paket dan tanggal ujian
        if ($request->filled('paket')) {
            $query->where('us.paket', $request->paket);
        }
        if ($request->filled('tgl_ujian')) {
            $query->whereDate('us.tgl_ujian', '=', $request->tgl_ujian);
        }
    
        $data = $query->get();
    
        return Excel::download(new RekapabsenExport($data), 'rekapabsen_data.xlsx');
    }
    
}
