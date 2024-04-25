<?php

namespace App\Http\Controllers\baak;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Jobs\ImportJobmhs;
use App\Imports\MahasiswaImport;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\Datatables\Datatables;

class MhsController extends Controller
{
    public function index()
    {
       
        return view('baak.mhs.index');
    }
    public function datajson()
	{
		return Datatables::of(Mahasiswa::get())->make(true);
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
            ImportJobmhs::dispatch($filename);
            return redirect()->back()->with(['success' => 'Upload Data Mahasiswa Success']);
        }  
        return redirect()->back()->with(['error' => 'Please choose file before']);
    }

}
