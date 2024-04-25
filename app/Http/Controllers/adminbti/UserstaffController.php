<?php

namespace App\Http\Controllers\adminbti;

use App\Http\Controllers\Controller;

use App\Models\Userstaff;
use App\Jobs\ImportJobtemu;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Imports\StaffImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class UserstaffController extends Controller
{
    public function __construct()
    {
      $this->middleware(['permission:userstaff.index |userstaff.create|userstaff.upload']);
       if(!$this->middleware('auth:sanctum')){
        return redirect('/login');
        }
    }
    public function index()
    {
        $userstaff = DB::table('users')
        ->rightjoin('user_staf','users.kode','user_staf.kode')
        ->select('users.kode as kode_dosen','users.username','users.email AS email_user','user_staf.*')
        ->get();
        
        return view('adminbti.userstaff.index',compact('userstaff'));
        
    }

    public function datajson()
	{
		return Datatables::of(Userstaff::get())->make(true);
	}

    public function storeData(Request $request)
    {
        //VALIDASI
        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file'); //GET FILE
            Excel::import(new StaffImport, $file); //IMPORT FILE 
            return redirect()->back()->with(['success' => 'Upload success']);
        }  
        return redirect()->back()->with(['error' => 'Please choose file before']);
    }
    public function tuserujian()
    {
        $temu = DB::select('call t_userujian');
        return redirect()->back()->with(['success' => 'success terhapus']);
    }
    public function singkronuser()
    {
        $temu = DB::select('call insert_userujian');
        return redirect()->back()->with(['success' => 'semua user ujian success di singkron ']);
    }
}
