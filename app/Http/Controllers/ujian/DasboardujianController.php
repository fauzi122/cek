<?php

namespace App\Http\Controllers\ujian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\Uts_soal;


class DasboardujianController extends Controller
{
    public function __construct()
    {
       $this->middleware(['permission:examschedule.index']);
       if(!$this->middleware('auth:sanctum')){
        return redirect('/login');
    }
    }

    public function index()
    {
        $senin  = Uts_soal::where('hari_t', 'Senin')->count();
        $selasa = Uts_soal::where('hari_t', 'Selasa')->count();
        $rabu   = Uts_soal::where('hari_t', 'Rabu')->count();
        $kamis  = Uts_soal::where('hari_t', 'Kamis')->count();
        $jumat  = Uts_soal::where('hari_t', 'Jumat')->count();
        $sabtu  = Uts_soal::where('hari_t', 'Sabtu')->count();

        $jadwal= Uts_soal::where([
            'hari_t' => hari_ini()
            ])->get();
           
        return view('admin.ujian.dashboardujian',compact('jadwal','senin','selasa','rabu','kamis','jumat','sabtu'));
    }
}
