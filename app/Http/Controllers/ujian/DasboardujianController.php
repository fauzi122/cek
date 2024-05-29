<?php

namespace App\Http\Controllers\ujian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\Uts_soal;


class DasboardujianController extends Controller
{
    public function __construct()
    {
           $this->middleware(['permission:examschedule.index']);
        if (!$this->middleware('auth:sanctum')) {
            return redirect('/login');
        }
    }

    public function index()
    {
        $utsData = Uts_soal::where('paket', 'UTS')
        ->selectRaw('tgl_ujian, COUNT(*) as jumlah')
        ->groupBy('tgl_ujian')
        ->orderBy('tgl_ujian')
        ->get();

        $uasData = Uts_soal::where('paket', 'UAS')
        ->selectRaw('tgl_ujian, COUNT(*) as jumlah')
        ->groupBy('tgl_ujian')
        ->orderBy('tgl_ujian')
        ->get();

        $tgl_hari_ini = date('Y-m-d'); // Format tanggal: tahun-bulan-tanggal
        $jadwal = Uts_soal::where('tgl_ujian', $tgl_hari_ini)->get();

        return view('admin.ujian.dashboardujian', compact('jadwal','utsData','uasData'));
    }
}
