<?php

namespace App\Http\Controllers\baak;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\Importpenilaian;
use Excel;
use App\Jobs\ImportJob;

class UploadjadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        if(!$this->middleware('auth:sanctum')){
            return redirect('/login');
        }
    }
    public function index()
    {
        return view('baak.jadwal.upload_penilaian');
        
    }

    public function storeData(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);
    
        if ($request->hasFile('file')) {
            //UPLOAD FILE
            $file = $request->file('file');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs(
                'public', $filename
            );
            
            //MEMBUAT JOBS DENGAN MENGIRIMKAN PARAMETER FILENAME
            ImportJob::dispatch($filename);
            return redirect()->back()->with(['success' => 'Upload success']);
        }  
        return redirect()->back()->with(['error' => 'Please choose file before']);
    }
}
