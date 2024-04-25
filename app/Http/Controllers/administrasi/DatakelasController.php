<?php

namespace App\Http\Controllers\administrasi;

use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;



class DatakelasController extends Controller
{
  public function __construct()
  {
    $this->middleware(['permission:toef.jadwal']);
    if (!$this->middleware('auth:sanctum')) {
      return redirect('/login');
    }
  }
  public function index()
  {
    $kelas = DB::table('jadwal')
      ->groupBy('kd_lokal', 'kd_mtk')
      ->where('kel_praktek', '<>', '')
      ->get();
    return view('administrasi.kelas.index', compact('kelas'));
  }

  public function show($id)
  {
    $pecah = explode(',', Crypt::decryptString($id));

    $showdosen = DB::table('jadwal')
      ->leftjoin('mhs', 'jadwal.kd_lokal', '=', 'mhs.kd_lokal')
      ->leftjoin('penilaian', 'jadwal.kd_mtk', '=', 'penilaian.kd_mtk')
      ->where([
        'jadwal.kd_dosen'       => $pecah[0],
        'jadwal.kd_lokal'       => $pecah[1],
        'jadwal.kd_mtk'         => $pecah[2]
      ])
      ->select('jadwal.*')
      ->groupBy('mhs.nim', 'mhs.kd_lokal')
      ->first();

    //dd($showdosen);
    $showkls = DB::table('jadwal')
      ->leftjoin('mhs', 'jadwal.kd_lokal', '=', 'mhs.kd_lokal')
      ->leftjoin('penilaian', 'jadwal.kd_mtk', '=', 'penilaian.kd_mtk')
      ->where([
        'jadwal.kd_dosen'       => $pecah[0],
        'jadwal.kd_lokal'       => $pecah[1],
        'jadwal.kd_mtk'         => $pecah[2]
      ])
      ->select(
        'penilaian.kd_mtk as mtk_penilaian',
        'penilaian.nim as nim_penilaian',
        'mhs.nim as nim_mhs',
        'mhs.kd_lokal as kd_lokal_mhs',
        'mhs.nm_mhs'
      )
      ->groupBy('mhs.nim', 'mhs.kd_lokal')
      ->get();
    return view('administrasi.kelas.show', compact('showkls', 'showdosen'));
  }

  public function show_mhs($id)
  {
    $pecah = explode(',', Crypt::decryptString($id));
    //dd($pecah);
    $showmhs = DB::table('absen_mhs')
      ->where([
        'nim'            => $pecah[0],
        'kd_mtk'         => $pecah[1],
        'kd_lokal'       => $pecah[2]
      ])->get();
    return view('administrasi.kelas.show_mhs', compact('showmhs'));
  }
}
