<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\ApiPenilaian;
use App\Models\MhsSisfo;
use App\Http\Controllers\Api\ApiPenilaianController;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Crypt;

class JobapiPenilaian implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $post;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($post)
    {
         $this->post = $post; 
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // dd($this->post);
        for ($i = 1; $i <= $this->post; $i++) {
            $sisfo = MhsSisfo::with('PenilaianSisfo')
                ->where('kondisi',1)
                ->orderBy('nim')
                ->paginate(
                    $perPage = 1300, $columns = ['*'], $pageName = 'azis', $currentPage=$i
                );
                $result = array();
        foreach($sisfo as $mhs){
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
            // echo $mhs->PenilaianSisfo->nim;
        }
        $chunk=collect($result)->chunk(1000);
        foreach($chunk as $arr){
            ApiPenilaian::insert($arr->toArray());
        }
    }
        
       
    }
    // public function handle()
    // {
   
    //     $chunk=collect($this->flight)->chunk(10);
    //     foreach($chunk as $arr){
    //         ApiPenilaian::insert($arr->toArray());
    //     }
    // }
}
