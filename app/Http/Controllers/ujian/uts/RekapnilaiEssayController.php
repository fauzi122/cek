<?php

namespace App\Http\Controllers\ujian\uts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paket_ujian;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\JawabEsay;

class RekapnilaiEssayController extends Controller
{
    public function __construct()
    {
    //    $this->middleware(['permission:']);
       if(!$this->middleware('auth:sanctum')){
        return redirect('/login');
    }
    }

    public function index()
    {
        $examTypes = Paket_ujian::distinct()->pluck('paket');

        $encryptedExamTypes = $examTypes->mapWithKeys(function ($item) {
            return [$item => Crypt::encryptString($item)];
        });
    
        $paketUjian = Paket_ujian::all();
        return view('admin.ujian.uts.baak.rekap_nilai.essay.utama', compact('encryptedExamTypes', 'paketUjian'));
       
    }

    public function essay($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));

        $essay = JawabEsay::where([
            'paket'    => $pecah[0]
            ])->get();
        return view('admin.ujian.uts.baak.rekap_nilai.essay.index', compact('essay'));
    }
}
