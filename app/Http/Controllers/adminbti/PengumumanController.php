<?php

namespace App\Http\Controllers\adminbti;

use App\Http\Controllers\Controller;

use App\Models\Info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;



class PengumumanController extends Controller
{
    public function __construct()
    {
     
       if(!$this->middleware('auth:sanctum')){
        return redirect('/login');
        }
    }
    public function index()
    {
       $info=DB::table('infos')->orderBy('id', 'DESC')->get();
       return view('admin.dashboard',compact('info'));
        
    }


    public function download_file_info(Request $request)
    {
        $files = public_path() . '/storage/info/' . $request->file;//Mencari file dari model yang sudah dicari
        if(file_exists($files)){
            return response()->download($files, $request->file);
        }else{
            echo"kosong";
        }
        
    }

 
}
