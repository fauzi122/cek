<?php

namespace App\Http\Controllers\ujian\uts;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;


class HitungsksController extends Controller
{
    public function index()
    {
        // Mengumpulkan tanggal ujian yang unik
        $dates = DB::table('ujian_berita_acaras')
                    ->selectRaw('DISTINCT tgl_ujian')
                    ->pluck('tgl_ujian');

        // Membentuk bagian dinamis dari query
        $caseStatements = [];
        foreach ($dates as $date) {
            $caseStatements[] = "SUM(CASE WHEN tgl_ujian = '{$date}' THEN 2 ELSE 0 END) AS `{$date}`";
        }
        $caseQuery = implode(', ', $caseStatements);

        // Membentuk query lengkap dengan kolom dinamis berdasarkan tanggal ujian
        $finalQuery = "SELECT kd_dosen,ot, SUM(2) AS total_sks, {$caseQuery} 
                       FROM ujian_berita_acaras 
                       GROUP BY kd_dosen";

        // Eksekusi query dan mendapatkan hasil
        $results = DB::select($finalQuery);

        // dd($results);
        return view('admin.ujian.uts.baak.hitung_sks.index', compact('results'));
    }
}
