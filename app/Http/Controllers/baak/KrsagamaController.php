<?php

namespace App\Http\Controllers\baak;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Krsagama;
use Illuminate\Support\Facades\DB;
use App\Jobs\ImportJobtemu;
use App\Imports\KrsagamaImport;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\Datatables\Datatables;

class KrsagamaController extends Controller
{
    public function __construct()
    {
      $this->middleware(['permission:krsagamak_baak.index |krsagamak_baak.upload|krsagamak_baak.singkron|krsagamak_baak.delete']);
       if(!$this->middleware('auth:sanctum')){
        return redirect('/login');
        }
    }
    public function index()
    {
       $krsmhsagama= Krsagama::get();
        return view('baak.krs.krsagama',compact('krsmhsagama'));
    }
    public function datajson()
	{
		return Datatables::of(Krsagama::get())->make(true);
	}

    public function storeData(Request $request)
    {
        //VALIDASI
        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file'); //GET FILE
            Excel::import(new KrsagamaImport, $file); //IMPORT FILE 
            return redirect()->back()->with(['success' => 'Upload success']);
        }  
        return redirect()->back()->with(['error' => 'Please choose file before']);
    }
    public function tpertemuan()
    {
        $temu = DB::select('call t_penilaian_agama');
        return redirect()->back()->with(['success' => 'Data Mahasiswa Success Terhapus']);
    }
    public function singkrontemu()
    {
        $temu = DB::select('call penilaian_agama');
      
        return redirect()->back()->with(['success' => 'success di singkron']);
    }
   
}
