<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Ref_cabang;
use App\Models\SaysSetting;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalkuliahController extends Controller
{


  function index($id)
  {
    // dd("asd");
    $sekarang = Carbon::now();
    $namaHari = $sekarang->locale('id')->dayName;
    $datasays = SaysSetting::where('status_setting', 'aktif')->orderBy('updated_at', 'desc')->firstOrFail();
    $ref_cabang = Ref_cabang::where('kd_kampus', $id)->firstOrFail();
    $ref_cabangpilih = Ref_cabang::select('kd_kampus', 'nm_kampus')->whereNotIn('kd_kampus', ['I2', 'I1', 'X1', 'N', 'B5', 'K3', 'B3', 'A7', 'K8', 'A5', 'K2'])->orderby('nm_kampus', 'asc')->get();

    try {
      $datajadwal = DB::table('jadwal')
        ->select(
          'jam_t',
          'no_ruang',
          DB::raw("SUBSTRING_INDEX(no_ruang, '-', 1) as no_ruangx"),
          DB::raw("SUBSTRING_INDEX(kd_lokal, '-', 1) as kd_lokalx"), // Perbaikan di sini
          'kel_praktek',
          'nm_mtk',
          'kd_dosen',
          DB::raw("UPPER(nm_dosen) as nm_dosen")
        )
        ->where(DB::raw('RIGHT(no_ruang, 2)'), '=', $id)
        ->where('hari_t', $namaHari)

        ->orderByRaw('SUBSTRING(jam_t, 1, LOCATE("-", jam_t) - 1)')
        ->get();
      // Konversi datajadwalharian ke JSON
      $datajadwalharianJson = $datajadwal->toJson();

      // Kirim data ke view
      return view('singlecolom', compact('ref_cabangpilih', 'namaHari', 'ref_cabang', 'datasays', 'datajadwal', 'datajadwalharianJson'));
    } catch (QueryException $e) {
      // Jika terjadi kesalahan pada koneksi basis data, arahkan ke halaman error
      // return redirect('/page_eror/dbakses');
    }
  }
}
