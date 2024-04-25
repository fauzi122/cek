<?php

namespace App\Http\Controllers\Administrasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Absen_praktisi;
use App\Models\Dosen_praktisi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class DosenPraktisiController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['permission:dosen_praktisi']);
        // if (!$this->middleware('auth:sanctum')) {
        //     return redirect('/login');
        // }
    }

    public function index()
    {
        $jadwal = Dosen_praktisi::get();
        return view('administrasi.praktisi.dosen.index', compact('jadwal'));
    }
    public function rekap_ajar()
    {
        $rekap = Absen_praktisi::get();
        return view('administrasi.praktisi.rekap_ajar.index', compact('rekap'));
    }

    public function showJadwal($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        $absen = DB::table('jadwal')
            ->where('kd_dosen2', $pecah[0])
            ->select('jadwal.*')
            ->get();
        return view('administrasi.praktisi.dosen.show', compact('absen'));
    }

    public function cariDataRekap(Request $request)
    {
        $kd_dosen = $request->input('kd_dosen');
        $tgl_awal = $request->input('tgl_awal');
        $tgl_akhir = $request->input('tgl_akhir');

        $rekapData = Absen_praktisi::query();

        if ($kd_dosen) {
            $rekapData->where('kd_dosen', $kd_dosen);
        }

        $rekapData->whereBetween('tgl_ajar_masuk', [$tgl_awal, $tgl_akhir]);
        $rekapData = $rekapData->get();

        return view('administrasi.praktisi.rekap_ajar.caridata', compact('rekapData', 'tgl_awal', 'tgl_akhir'));
    }
}
