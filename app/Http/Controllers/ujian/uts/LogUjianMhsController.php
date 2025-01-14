<?php

namespace App\Http\Controllers\ujian\uts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mtk_ujian;
use App\Models\Paket_ujian;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class LogUjianMhsController extends Controller
{
    public function __construct()
    {
       $this->middleware(['permission:mtk_ujian|mtk_ujian.edit|mtk_ujian.add']);
       if(!$this->middleware('auth:sanctum')){
        return redirect('/login');
    }
    }

    public function utama()
    {
        $examTypes = Paket_ujian::distinct()->pluck('paket');

        $encryptedExamTypes = $examTypes->mapWithKeys(function ($item) {
            return [$item => Crypt::encryptString($item)];
        });
    
        $paketUjian = Paket_ujian::all();
        return view('admin.ujian.uts.baak.log_ujian_mhs.utama', compact('encryptedExamTypes', 'paketUjian'));
       
    }
    public function index($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));

        $mtk_ujian = Mtk_ujian::where([
            'paket'    => $pecah[0]
            ])->get();
        return view('admin.ujian.uts.baak.log_ujian_mhs.index', compact('mtk_ujian'));
    }
    
    public function show($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));

        $data= DB::table('ujian_jawabs')
        ->join('ujian_detailsoals', 'ujian_jawabs.no_soal_id', '=', 'ujian_detailsoals.id')
        ->select('ujian_jawabs.*', 'ujian_detailsoals.id', 'ujian_detailsoals.kd_mtk', 
                 'ujian_detailsoals.soal', 'ujian_detailsoals.pila', 'ujian_detailsoals.pilb', 
                 'ujian_detailsoals.pilc', 'ujian_detailsoals.pild', 'ujian_detailsoals.pile', 
                 'ujian_detailsoals.kunci')
        ->where('ujian_detailsoals.kd_mtk', $pecah[0])
        ->where('ujian_detailsoals.jenis', $pecah[1])
        ->groupBy('ujian_detailsoals.kd_mtk')
        ->get();
        dd($data);
        return view('admin.ujian.uts.baak.log_ujian_mhs.show', compact('data'));

    }
}
