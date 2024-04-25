<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absen_ajar_praktek;
use App\Models\Absen_ajar;
use App\Models\Jadwal;

class AbsenAjarController extends Controller
{
    public function index(Request $request)
    {
        $kdDosen = $request->input('kd_dosen');
        $kdLokal = $request->input('kd_lokal');
        $kdMtk = $request->input('kd_mtk');
        $limit = $request->input('limit', 10); // default limit: 10

        $query = Absen_ajar::query();

        if ($kdDosen) {
            $query->where('kd_dosen', $kdDosen);
        }

        if ($kdLokal) {
            $query->where('kd_lokal', $kdLokal);
        }

        if ($kdMtk) {
            $query->where('kd_mtk', $kdMtk);
        }

        $absenAjars = $query->take($limit)->get();

        if ($absenAjars->isEmpty()) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        return response()->json($absenAjars);
    }

    public function ajar_praktek(Request $request)
    {
        $kdDosen = $request->input('kd_dosen');
        $kdLokal = $request->input('kel_praktek');
        $kdMtk = $request->input('kd_mtk');
        $limit = $request->input('limit', 10); // default limit: 10

        $query = Absen_ajar_praktek::query();

        if ($kdDosen) {
            $query->where('kd_dosen', $kdDosen);
        }

        if ($kdLokal) {
            $query->where('kel_praktek', $kdLokal);
        }

        if ($kdMtk) {
            $query->where('kd_mtk', $kdMtk);
        }

        $absenAjars = $query->take($limit)->get();

        if ($absenAjars->isEmpty()) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        return response()->json($absenAjars);
    }


    public function jadwal(Request $request)
    {
        $kdDosen = $request->input('kd_dosen');
        $limit = $request->input('limit', 10); // default limit: 10

        $query = Jadwal::query();

        if ($kdDosen) {
            $query->where('kd_dosen', $kdDosen);
        }

        $jadwals = $query->take($limit)->get();

        if ($jadwals->isEmpty()) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        return response()->json($jadwals);
    }
}
