<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\ApiPenilaian;
use App\Models\PenilaianBaak;
use App\Models\MhsSisfo;
use Illuminate\Support\Facades\Http;
use App\Jobs\JobapiPenilaian;
use Redirect;


class ApiPenilaianController extends Controller
{
    public function index()
    {
        $req = MhsSisfo::with('PenilaianSisfo')
        ->where('kondisi',1)
        ->orderBy('nim')
        ->paginate(
            $perPage = 600, $columns = ['*'], $pageName = 'azis', $currentPage=1
        );
        PenilaianBaak::truncate();
        PenilaianBaak::create(['smt' => '1', 'total' => $req->total(), 'lastPage' => $req->lastPage()]);
        // $dec_pen=json_decode(json_encode($flight->lastPage()), true);
        dd($req);
        // return JobapiPenilaian::dispatch($dec_pen);
        // $back=array();
        for ($i = 1; $i <= 10; $i++) {
            echo "<script>window.open('/proses-penilaian/".$i."', '_blank')</script>";
        }
    }

    public function proses($id)
    {
        // for ($i = 1; $i <= $id; $i++) {
            $flight = MhsSisfo::with('PenilaianSisfo')
                ->where('kondisi',1)
                ->orderBy('nim')
                ->paginate(
            $perPage = 600, $columns = ['*'], $pageName = 'azis', $currentPage=$id
            );
        $result = array();
        foreach($flight as $mhs){
            foreach($mhs->PenilaianSisfo as $pen){
                $result[] = array(
                    'nim'=>$pen->nim,
                    'no_krs'=>$pen->no_krs,
                    'kd_mtk'=>$pen->kd_mtk,
                    'nilai_uts'=>$pen->nilai_uts,
                    'nilai_uas'=>$pen->nilai_uas,
                    'total_nilai'=>$pen->total_nilai,
                    'nil_absen'=>$pen->nil_absen,
                    'nil_tgs'=>$pen->nil_tgs,
                    'grade_akhir'=>$pen->grade_akhir,
                    'kel_praktek'=>$pen->kel_praktek,
                    'unggulan'=>$pen->unggulan,
                    'minat'=>$pen->minat
                );
            }
        }
        $chunk=collect($result)->chunk(500);
        foreach($chunk as $arr){
            ApiPenilaian::insert($arr->toArray());
        }
    // }
    return view('api.penilaian');

    
    }

    public function penilaianSisfo()
    {
        $jml_mhs = app('App\Models\PenilaianSisfo')->penilaian();
        dd($jml_mhs);
        dd($jml_mhs[0]);
        // $dec_pen=json_decode(json_encode($jml_mhs), true);
                $result = array();
                foreach($jml_mhs as $pen){
                    // echo $pen->nim;
                    $result[] = array(
                        'nim'=>$pen->nim,
                        'no_krs'=>$pen->no_krs,
                        'kd_mtk'=>$pen->kd_mtk,
                        'nilai_uts'=>$pen->nilai_uts,
                        'nilai_uas'=>$pen->nilai_uas,
                        'total_nilai'=>$pen->total_nilai,
                        'nil_absen'=>$pen->nil_absen,
                        'nil_tgs'=>$pen->nil_tgs,
                        'grade_akhir'=>$pen->grade_akhir,
                        'kel_praktek'=>$pen->kel_praktek,
                        'unggulan'=>$pen->unggulan,
                        'minat'=>$pen->minat
                    );
                }
        dd ($result);
        JobapiPenilaian::dispatch($result);
}

//     public function penilaianSisfo()
// {
//     $query="SELECT
//     a.`nim`,
//     a.`no_krs`,
//     a.`kd_mtk`,
//     a.`nilai_uts`,
//     a.`nilai_uas`,
//     a.`total_nilai`,
//     a.`nil_absen`,
//     a.`nil_tgs`,
//     a.`grade_akhir`,
//     a.`kel_praktek`,
//     a.`unggulan`,
//     a.`minat`
//   FROM
//     penilaian a
//     JOIN mhs b
//       ON a.`nim` = b.`nim`
//   WHERE b.`kondisi` = '1'
//     AND (MID(a.no_krs, 6,1) IN ('1','2','3','5','7','8','9') OR MID(a.no_krs, 7,1) IN ('1','2','3','5','7','8','9'))
//     AND (MID(a.no_krs, 6,1)=MID(b.`kd_lokal`, 4,1) OR MID(a.no_krs, 7,1)=MID(b.`kd_lokal`, 4,1)) limit 100";
            
//            // $penilaian =DB::connection('sisfo.bsi')->table($query);
            
//             $penilaian = app('db')->connection('sisfo.bsi')->select($query);
//             $dec_pen=json_decode(json_encode($penilaian), true);
//             $result = array();
//             foreach($dec_pen as $pen){
//                 $result[] = array(
//                     'nim'=>$pen['nim'],
//                     'no_krs'=>$pen['no_krs'],
//                     'kd_mtk'=>$pen['kd_mtk'],
//                     'nilai_uts'=>$pen['nilai_uts'],
//                     'nilai_uas'=>$pen['nilai_uas'],
//                     'total_nilai'=>$pen['total_nilai'],
//                     'nil_absen'=>$pen['nil_absen'],
//                     'nil_tgs'=>$pen['nil_tgs'],
//                     'grade_akhir'=>$pen['grade_akhir'],
//                     'kel_praktek'=>$pen['kel_praktek'],
//                     'unggulan'=>$pen['unggulan'],
//                     'minat'=>$pen['minat']
//                 );
//             }
//     JobapiPenilaian::dispatch($result);
//     if($penilaian) {

//         return response()->json([
//             "response" => [
//                 "status"    => 200,
//                 "message"   => "Detail Data Agenda"
//             ],
//             "data" => $penilaian
//         ], 200);

//     } else {

//         return response()->json([
//             "response" => [
//                 "status"    => 404,
//                 "message"   => "Data Agenda Tidak Ditemukan!"
//             ],
//             "data" => null
//         ], 404);

//     }
// }


public function apiPenilaian()
{
    $penilaian=Http::get('http://localhost/api_lumen/public/penilaian');
    $dec_pen=json_decode($penilaian, true);
    $result = array();
    foreach($dec_pen as $pen){
        $result[] = array(
            'nim'=>$pen['nim'],
            'no_krs'=>$pen['no_krs'],
            'kd_mtk'=>$pen['kd_mtk'],
            'nilai_uts'=>$pen['nilai_uts'],
            'nilai_uas'=>$pen['nilai_uas'],
            'total_nilai'=>$pen['total_nilai'],
            'nil_absen'=>$pen['nil_absen'],
            'nil_tgs'=>$pen['nil_tgs'],
            'grade_akhir'=>$pen['grade_akhir'],
            'kel_praktek'=>$pen['kel_praktek'],
            'unggulan'=>$pen['unggulan'],
            'minat'=>$pen['minat']
          );
    }
    //   dd(collect($result)->chunk(100));
    $chunk=collect($result)->chunk(5000);
    foreach($chunk as $arr){

        ApiPenilaian::insert($arr->toArray());
    }
    //   dd(collect($result)->chunk(100));
    //  die;
    //  return $dec_pen;
}
}
