<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
// use App\Models\MhsSisfo;



class PenilaianSisfo extends Model
{
    protected $table='penilaian';
    protected $guarded=[];
    protected $connection = 'sisfo.bsi';

    public function MhsSisfo(){
    	return $this->belongsTo(MhsSisfo::class,'nim','nim');
    }
    public function penilaian()
    {
         $data = DB::connection('sisfo.bsi')->table('penilaian as a')
            ->select('a.nim',
            'a.no_krs',
            'a.kd_mtk',
            'a.nilai_uts',
            'a.nilai_uas',
            'a.total_nilai',
            'a.nil_absen',
            'a.nil_tgs',
            'a.grade_akhir',
            'a.kel_praktek',
            'a.unggulan',
            'a.minat')
            ->join('mhs as b', 'a.nim', '=', 'b.nim')
            ->where('b.kondisi','1')
            ->whereNotNull(DB::raw("(MID(a.no_krs, 6,1) IN ('1','2','3','5','7','8','9') OR MID(a.no_krs, 7,1) IN ('1','2','3','5','7','8','9'))"))
            ->whereNotNull(DB::raw("(MID(a.no_krs, 6,1)=MID(b.kd_lokal, 4,1) OR MID(a.no_krs, 7,1)=MID(b.kd_lokal, 4,1))"))
            ->limit(1)
            ->paginate(
                $perPage = 100, $columns = ['*'], $pageName = 'azis', $currentPage=4
            );
            // DB::connection('mysql')->table('penilaian_baak')->truncate();
            // DB::connection('mysql')->table('penilaian_baak')->insert(
            //     ['smt' => '1', 'total' => $data->total(), 'lastPage' => $data->lastPage()]
            // );
            return $data;
            // return response()->json([
            //     'posts' => $data
            // ], 200);
    }
}
