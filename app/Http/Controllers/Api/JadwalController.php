<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use App\Models\Jadwal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;


class JadwalController extends Controller
{
    public function index()
    {
        $jadwals = Cache::remember('jadwals', now()->addMinutes(60), function () {
            return Jadwal::all();
        });

        return response()->json(['status' => 'success', 'data' => $jadwals]);
    }
    public function hapusJadwal()
    {
        Artisan::call('cache:clear');
        return response()->json(['message' => 'Cache cleared successfully']);
    }
    public function jadwalKampus()
    {
        // Menggunakan alamat IP sebagai kunci cache
        $alamatIP = request()->ip();
        $cacheKey = 'jadwal_ip_' . $alamatIP;

        $data = Cache::remember($cacheKey, now()->addMinutes(60), function () use ($alamatIP) {
            return Jadwal::join('ip_absen', function ($join) {
                $join->on(DB::raw('SUBSTRING_INDEX(jadwal.no_ruang, "-", -1)'), '=', 'ip_absen.kd_cabang');
            })
                ->where('ip_absen.ip', '=', $alamatIP) // Filter berdasarkan alamat IP yang diberikan
                ->select('jadwal.*', 'ip_absen.*') // Pilih kolom yang ingin ditampilkan
                ->get();
        });

        return response()->json($data);
    }
}
