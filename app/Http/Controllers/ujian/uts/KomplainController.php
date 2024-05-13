<?php

namespace App\Http\Controllers\ujian\uts;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use App\Models\{Paket_ujian};

class KomplainController extends Controller
{
    public function __construct()
    {
       $this->middleware(['permission:ralat_soal']);
       if(!$this->middleware('auth:sanctum')){
        return redirect('/login');
    }
    }

    public function halamanSoal()
    {
        $examTypes = Paket_ujian::distinct()->pluck('paket');

        $encryptedExamTypes = $examTypes->mapWithKeys(function ($item) {
            return [$item => Crypt::encryptString($item)];
        });
        return view('admin.ujian.uts.baak.komplain.indexSoal', compact('encryptedExamTypes'));
    }
    function komplainSoal($paket)
    {
        $komplainSoal = DB::table('ujian_komplain_soal')
            ->where('paket', Crypt::decryptString($paket))
            ->get();
        return view('admin.ujian.uts.baak.komplain.halamanSoal', compact('komplainSoal'));
    }

    public function halamanUjian()
    {
        $examTypes = Paket_ujian::distinct()->pluck('paket');

        $encryptedExamTypes = $examTypes->mapWithKeys(function ($item) {
            return [$item => Crypt::encryptString($item)];
        });
        return view('admin.ujian.uts.baak.komplain.indexUjian', compact('encryptedExamTypes'));
    }
    function komplainUjian($paket)
    {
        $komplainUjian = DB::table('ujian_komplains')
            ->where('paket', Crypt::decryptString($paket))
            ->get();
     
        return view('admin.ujian.uts.baak.komplain.halamanUjian', compact('komplainUjian'));
    }
}
