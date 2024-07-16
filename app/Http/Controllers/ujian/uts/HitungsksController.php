<?php

namespace App\Http\Controllers\ujian\uts;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;


class HitungsksController extends Controller
{
    public function index_uas()
    {
        // Mengumpulkan tanggal ujian yang unik dengan filter paket = 'UAS'
        $dates = DB::table('ujian_berita_acaras')
                    ->selectRaw('DISTINCT tgl_ujian')
                    ->where('paket', 'UAS')
                    ->pluck('tgl_ujian');
    
        // Membentuk bagian dinamis dari query
        $caseStatements = [];
        foreach ($dates as $date) {
            $caseStatements[] = "SUM(CASE WHEN ujian_berita_acaras.tgl_ujian = '{$date}' THEN 2 ELSE 0 END) AS `{$date}`";
        }
        $caseQuery = implode(', ', $caseStatements);
    
        // Membentuk subquery untuk menghitung jumlah ruang unik pada setiap tanggal dengan filter paket = 'UAS'
        $subquery = DB::table('ujian_berita_acaras')
                    ->selectRaw('kd_dosen, tgl_ujian, COUNT(DISTINCT RIGHT(no_ruang, 2)) as jumlah_temu')
                    ->where('paket', 'UAS')
                    ->groupBy('kd_dosen', 'tgl_ujian');
    
        // Membentuk query lengkap dengan kolom dinamis berdasarkan tanggal ujian dengan filter paket = 'UAS'
        $finalQuery = DB::table('ujian_berita_acaras')
            ->join('karyawanbs1', 'ujian_berita_acaras.kd_dosen', '=', 'karyawanbs1.kd_dosen')
            ->leftJoinSub($subquery, 'sub', function ($join) {
                $join->on('ujian_berita_acaras.kd_dosen', '=', 'sub.kd_dosen')
                     ->on('ujian_berita_acaras.tgl_ujian', '=', 'sub.tgl_ujian');
            })
            ->selectRaw("
                ujian_berita_acaras.kd_dosen,
                ujian_berita_acaras.ot,
                karyawanbs1.nip,
                karyawanbs1.nama,
                karyawanbs1.dept,
                ujian_berita_acaras.paket,
                SUM(2) AS total_sks,
                COUNT(DISTINCT CONCAT(ujian_berita_acaras.tgl_ujian, RIGHT(ujian_berita_acaras.no_ruang, 2))) AS jumlah_temu,
                {$caseQuery}
            ")
            ->where('ujian_berita_acaras.paket', 'UAS')
            ->groupBy(
                'ujian_berita_acaras.kd_dosen', 
                'ujian_berita_acaras.ot', 
                'karyawanbs1.nip', 
                'karyawanbs1.nama', 
                'karyawanbs1.dept',
                'ujian_berita_acaras.paket'
            )
            ->where('karyawanbs1.status_kry', 1)
            ->get();
    
        // Mengambil kolom dinamis
        $results = $finalQuery;
        $dynamicColumns = $results ? array_keys((array) $results[0]) : [];
    
        return view('admin.ujian.uts.baak.hitung_sks.index', compact('results', 'dynamicColumns'));
    }


    public function index_uts()
    {
        // Mengumpulkan tanggal ujian yang unik dengan filter paket = 'UAS'
        $dates = DB::table('ujian_berita_acaras')
                    ->selectRaw('DISTINCT tgl_ujian')
                    ->where('paket', 'UTS')
                    ->pluck('tgl_ujian');
    
        // Membentuk bagian dinamis dari query
        $caseStatements = [];
        foreach ($dates as $date) {
            $caseStatements[] = "SUM(CASE WHEN ujian_berita_acaras.tgl_ujian = '{$date}' THEN 2 ELSE 0 END) AS `{$date}`";
        }
        $caseQuery = implode(', ', $caseStatements);
    
        // Membentuk subquery untuk menghitung jumlah ruang unik pada setiap tanggal dengan filter paket = 'UTS'
        $subquery = DB::table('ujian_berita_acaras')
                    ->selectRaw('kd_dosen, tgl_ujian, COUNT(DISTINCT RIGHT(no_ruang, 2)) as jumlah_temu')
                    ->where('paket', 'UTS')
                    ->groupBy('kd_dosen', 'tgl_ujian');
    
        // Membentuk query lengkap dengan kolom dinamis berdasarkan tanggal ujian dengan filter paket = 'UTS'
        $finalQuery = DB::table('ujian_berita_acaras')
            ->join('karyawanbs1', 'ujian_berita_acaras.kd_dosen', '=', 'karyawanbs1.kd_dosen')
            ->leftJoinSub($subquery, 'sub', function ($join) {
                $join->on('ujian_berita_acaras.kd_dosen', '=', 'sub.kd_dosen')
                     ->on('ujian_berita_acaras.tgl_ujian', '=', 'sub.tgl_ujian');
            })
            ->selectRaw("
                ujian_berita_acaras.kd_dosen,
                ujian_berita_acaras.ot,
                karyawanbs1.nip,
                karyawanbs1.nama,
                karyawanbs1.dept,
                ujian_berita_acaras.paket,
                SUM(2) AS total_sks,
                COUNT(DISTINCT CONCAT(ujian_berita_acaras.tgl_ujian, RIGHT(ujian_berita_acaras.no_ruang, 2))) AS jumlah_temu,
                {$caseQuery}
            ")
            ->where('ujian_berita_acaras.paket', 'UTS')
            ->groupBy(
                'ujian_berita_acaras.kd_dosen', 
                'ujian_berita_acaras.ot', 
                'karyawanbs1.nip', 
                'karyawanbs1.nama', 
                'karyawanbs1.dept',
                'ujian_berita_acaras.paket'
            )
            ->where('karyawanbs1.status_kry', 1)
            ->get();
    
        // Mengambil kolom dinamis
        $results = $finalQuery;
        $dynamicColumns = $results ? array_keys((array) $results[0]) : [];
    
        return view('admin.ujian.uts.baak.hitung_sks.index_uts', compact('results', 'dynamicColumns'));
    }
     
}
