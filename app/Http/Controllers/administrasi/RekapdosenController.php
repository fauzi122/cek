<?php

namespace App\Http\Controllers\administrasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Absen_ajar;
use App\Models\Absen_ajar_praktek;

class RekapdosenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        return view('administrasi.rekap.index');
    }

    public function teori()
    {

        $rekapajarhari = DB::table('absen_ajars')
            ->where([

                'tgl_ajar_masuk' => date('Y-m-d')
            ])->get();

        return view('administrasi.rekap.teori', compact('rekapajarhari'));
    }


    public function praktek()
    {

        $rekapajar_praktek = DB::table('absen_ajar_prakteks')
            ->where([

                'tgl_ajar_masuk' => date('Y-m-d')
            ])->get();

        return view('administrasi.rekap.praktek', compact('rekapajar_praktek'));
    }


    public function teori_all()
    {

        //     $rekapajarall = DB::table('absen_ajars')
        //    ->get();

        $rekapajarall = DB::table('absen_ajars')
            ->when(request()->q, function ($rekapajarall) {
                $rekapajarall = $rekapajarall->where('kd_dosen', 'like', '%' . request()->q . '%');
            })->paginate(150);
        //dd($rekapajarall);
        return view('administrasi.rekap.teori_all2', compact('rekapajarall'));
    }

    public function praktek_all()
    {

        $rekapajar_praktek_all = DB::table('absen_ajar_prakteks')
            ->get();
        // dd($rekapajar_praktek_all);
        return view('administrasi.rekap.praktek_all', compact('rekapajar_praktek_all'));
    }

    public function cariDataRekapt(Request $request)
    {
        $kd_dosen = $request->input('kd_dosen');
        $tgl_awal = $request->input('tgl_awal');
        $tgl_akhir = $request->input('tgl_akhir');

        $rekapData = Absen_ajar::query();

        if ($kd_dosen) {
            $rekapData->where('kd_dosen', $kd_dosen);
        }

        $rekapData->whereBetween('tgl_ajar_masuk', [$tgl_awal, $tgl_akhir]);
        $rekapData = $rekapData->get();

        return view('administrasi.rekap.caridata', compact('rekapData', 'tgl_awal', 'tgl_akhir'));
    }

    public function cariDataRekapp(Request $request)
    {
        $kd_dosen = $request->input('kd_dosen');
        $tgl_awal = $request->input('tgl_awal');
        $tgl_akhir = $request->input('tgl_akhir');

        $rekapData = Absen_ajar_praktek::query();

        if ($kd_dosen) {
            $rekapData->where('kd_dosen', $kd_dosen);
        }

        $rekapData->whereBetween('tgl_ajar_masuk', [$tgl_awal, $tgl_akhir]);
        $rekapData = $rekapData->get();

        return view('administrasi.rekap.caridata_praktek', compact('rekapData', 'tgl_awal', 'tgl_akhir'));
    }
}
