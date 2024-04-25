<?php

namespace App\Http\Controllers\adminbti;

use App\Http\Controllers\Controller;

use App\Models\Info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



class UmumController extends Controller
{
    public function __construct()
    {
       $this->middleware(['permission:umum.index |umum.create|umum.upload|umum.delete']);
       if(!$this->middleware('auth:sanctum')){
        return redirect('/login');
        }
    }
    public function index()
    {
        
       $umum=DB::table('infos')->orderBy('id', 'DESC')->get();
       return view('adminbti.pengumuman.index',compact('umum'));
        
    }
    public function create()
    {
        return view('adminbti.pengumuman.create'); 
    }
    public function store(Request $request)
    {
       
        $this->validate($request, [
            'title'   => 'required',
            'nip'   => 'required',
            'file'    => 'required|file|mimes:pdf,|max:2500'
           
        ]);
    
        $file = $request->file('file');
        $file->storeAs('public/info', $file->hashName());
        $umum = Info::create([
            'title'     => $request->input('title'),
            'nip'       => $request->input('nip'),
            'file'      => $file->hashName()
           
        ]);
        if($umum){
            return redirect('/announce')->with('status','Data Ditambah');
        }
        else{
            return redirect('/announce')->with('error','Gagal Ditambah');
        }
    }

    public function download_file_pengumuman(Request $request)
    {
        $files = public_path() . '/storage/info/' . $request->file;//Mencari file dari model yang sudah dicari
        if(file_exists($files)){
            return response()->download($files, $request->file);
        }else{
            echo"kosong";
        }
        
    }

 
}
