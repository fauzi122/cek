<?php

namespace App\Http\Controllers\baak;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agamakristen;
use Illuminate\Support\Facades\DB;
use App\Jobs\ImportJobtemu;
use App\Imports\AgamaImport;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Http;

class AgamakristenController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:agamak_baak.index |agamak_baak.upload|agamak_baak.singkron|agamak_baak.delete']);
        if (!$this->middleware('auth:sanctum')) {
            return redirect('/login');
        }
    }
    public function index()
    {
        $agamak = Agamakristen::get();
        return view('baak.pertemuan.agama_kristen', compact('agamak'));
    }
    public function datajson()
    {
        return Datatables::of(Agamakristen::get())->make(true);
    }

    public function storeData(Request $request)
    {
        //VALIDASI
        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx,xml'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file'); //GET FILE
            Excel::import(new AgamaImport, $file); //IMPORT FILE 
            return redirect()->back()->with(['success' => 'Upload success']);
        }
        return redirect()->back()->with(['error' => 'Please choose file before']);
    }
    public function tpertemuan()
    {
        $temu = DB::select('call t_pertemuan_agama');
        return redirect()->back()->with(['success' => 'success terhapus']);
    }
    public function singkrontemu()
    {
        $response = Http::get('https://elearning.bsi.ac.id/hapus-jadwal');
        $temu = DB::select('call insert_jadwal');
        $temu1 = DB::select('call jadwal_agama');
        return redirect()->back()->with(['success' => 'success di singkron']);
    }

    public function edit(Agamakristen $agamakristen)
    {
        return view('baak.pertemuan.edit_temuagama', compact('agamakristen'));
    }
}
