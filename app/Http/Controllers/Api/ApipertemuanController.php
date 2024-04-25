<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PertemuanSisfo;
use App\Models\Pertemuan;
use App\Jobs\JobPertemuan;


class ApipertemuanController extends Controller
{
    public function index()
    {
    $pertemuan = PertemuanSisfo::get();
    if($pertemuan) {

        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "Detail Data Agenda"
            ],
            "data" => $pertemuan
        ], 200);

    } else {

        return response()->json([
            "response" => [
                "status"    => 404,
                "message"   => "Data Agenda Tidak Ditemukan!"
            ],
            "data" => null
        ], 404);

    }
    }

    public function store(Request $request)
    {
     $pertemuan=PertemuanSisfo::get();
    $dec_pen=json_decode(json_encode($pertemuan), true);
    // dd();
    $result = array();
    foreach($dec_pen as $pen){
        $result[] = array(
            'no_j_klh'=>$pen['no_j_klh'],
            'kd_mtk'=>$pen['kd_mtk'],
            'jml_pertemuan'=>$pen['jml_pertemuan'],
            'kd_dosen'=>$pen['kd_dosen'],
            'jam_t'=>$pen['jam_t'],
            'hari_t'=>$pen['hari_t'],
            'no_ruang'=>$pen['no_ruang'],
            'kd_lokal'=>$pen['kd_lokal'],
            'smt_ajar'=>$pen['smt_ajar'],
            'kel_praktek'=>$pen['kel_praktek'],
            'kd_praktek'=>$pen['kd_praktek'],
            'ket'=>$pen['ket'],
            'sksajar'=>$pen['sksajar'],
            'nohari'=>$pen['nohari'],
            'status_ajar'=>$pen['status_ajar'],
            'last_update'=>$pen['last_update'],
            'cek'=>$pen['cek'],
            'kd_dosen2'=>$pen['kd_dosen2'],
            'nip_aslab'=>$pen['nip_aslab'],
            'kd_gabung'=>$pen['kd_gabung'],
            'u_trans'=>$pen['u_trans']
           
          );
    }
    JobPertemuan::dispatch($result);

    
    // if($pertemuan) {
    //     return response()->json([
    //         "response" => [
    //             "status"    => 200,
    //             "message"   => "Detail Data Agenda"
    //         ],
    //         "data" => "sukses"
    //     ], 200);

    // } else {

    //     return response()->json([
    //         "response" => [
    //             "status"    => 404,
    //             "message"   => "Data Agenda Tidak Ditemukan!"
    //         ],
    //         "data" => null
    //     ], 404);

    // }
    }
}





