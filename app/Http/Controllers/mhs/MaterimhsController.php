<?php

namespace App\Http\Controllers\mhs;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Materi;
use App\Models\video;
class MaterimhsController extends Controller
{
    public function __construct() {
        if(!$this->middleware('auth:sanctum')){
            return redirect('/login');
        } 
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
         //di buat array utuk deskrip kode nya
        // 0 => "DPG.17.1C.12.A"
        // 1 => "894"
        // 2 => "201704121"
        $pecah=explode(',',Crypt::decryptString($id));
       
        // select video
        $videomhs= video::where([
            //'nim'       =>Auth::user()->username,
            'kd_mtk'    =>$pecah[1],
            'kd_lokal'  =>$pecah[0]
            ])->get();
            //dd($videomhs);

        //materi tambhan
        $materimhs= Materi::where([
            //'kd_dosen'  =>$pecah[2],
            'kd_mtk'    =>$pecah[1],
            'kd_lokal'  =>$pecah[0]
            ])->get(); 

        $cek = DB::table('jadwal_mbkm')->where('nim',Auth::user()->username)->groupBy('nim')->count();
        // dd($cek);
        //jadwal mhs
        if ($cek > 0) {
            $slidemhs = DB::table('jadwal_mbkm')
        ->join('jadwal',function ($join) {
            $join->on('jadwal_mbkm.kd_mtk', '=', 'jadwal.kd_mtk');
            $join->on('jadwal_mbkm.kd_lokal', '=', 'jadwal.kd_lokal');
        })
        ->select('jadwal_mbkm.nim','jadwal.*' )
        ->where([
            'jadwal_mbkm.nim'       =>Auth::user()->username,
            'jadwal_mbkm.kd_mtk'       =>$pecah[1]
            ])->first(); 
        }else{
        $slidemhs = DB::table('penilaian')
        ->leftJoin('mtk','penilaian.kd_mtk', '=', 'mtk.kd_mtk')
        ->LeftJoin('jadwal','mtk.kd_mtk', '=', 'jadwal.kd_mtk')
        ->select('penilaian.nim','penilaian.kd_mtk','mtk.nm_mtk','jadwal.*' )
        ->where([
            'penilaian.nim'       =>Auth::user()->username,
            'jadwal.kd_mtk'       =>$pecah[1]
            ])->first(); 
        }
            
// dd($slidemhs);
        return view('mhs.materi.index',compact('materimhs','id','videomhs','slidemhs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function download_file_materi(Request $request)
    {
        $files = public_path() . '/storage/materi/' . $request->file;//Mencari file dari model yang sudah dicari
        if(file_exists($files)){
            return response()->download($files, $request->file);
        }else{
            echo"kosong";
        }
        
    }
}
