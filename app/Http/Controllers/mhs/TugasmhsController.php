<?php

namespace App\Http\Controllers\mhs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tugas;
use App\Models\Tugasmhs;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class TugasmhsController extends Controller
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
    public function index(Request $request, $id )
    {
        
        //  di buat array utuk deskrip kode nya
        // 0 => "DPG.17.1C.12.A"
        // 1 => "894"
        // 2 => "201704121"
        $pecah=explode(',',Crypt::decryptString($id));
        
        $nilaitugas = Tugasmhs::leftJoin('tugas','tugasmhs.id_tugas', '=', 'tugas.id')
        ->select('tugas.judul','tugas.kd_mtk','tugas.kd_lokal','tugasmhs.*' )
        ->where('tugasmhs.nim',$request->user()->username)
        ->where([
            'kd_mtk'    =>$pecah[1],
            'kd_lokal'  =>$pecah[0]
            ])
        ->get(); 

        $tugasmhs= Tugas::where([
            'kd_mtk'    =>$pecah[1],
            'kd_lokal'  =>$pecah[0]
            ])->get(); 
        return view('mhs.tugas.index',compact('tugasmhs','id','nilaitugas'));
    }

    public function send($id)
    {
        $show=explode(',',Crypt::decryptString($id));
        // dd($show);
        $sendtugas= Tugas::where([
            'id'    =>$show[3],
            'pertemuan' =>$show[2],
            'kd_mtk'    =>$show[1],
            'kd_lokal'  =>$show[0]
            ])->first(); 
        
        return view('mhs.tugas.send',compact('sendtugas','id'));
    }

    public function nilai_tugas()
    {
       
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

            $this->validate($request, [
    
                'nim'         => 'required',
                'id_tugas'    => 'required',
                'isi'         => 'required',
             ]);
             
            $tugas= Tugasmhs::updateOrCreate(
                
                ['nim' => $request->nim, 
                'id_tugas' => $request->id_tugas],

                ['isi' => $request->isi]
            );
   
          
            $gabung=Crypt::encryptString($request->input('kd_lokal').','.$request->input('kd_mtk'));                                    

            if($tugas){
            return redirect('/assignment/'.$gabung)->with('status','Data Berhasil Ditambah');}
            else{
                return redirect('/assignment/'.$gabung)->with('status','Gagal Ditambah');
            
            }
         
        
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
    public function download_file_tugas(Request $request)
    {
        $files = public_path() . '/storage/tugas/' . $request->file;//Mencari file dari model yang sudah dicari
        if(file_exists($files)){
            return response()->download($files, $request->file);
        }else{
            echo"kosong";
        }
        
    }
}
