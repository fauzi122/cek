<?php

namespace App\Http\Controllers\Dosen;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\Models\Absen_praktisi;
use App\Models\Absen_ajar_praktek;




class Absen_praktisiController extends Controller
{

    public function __construct()
    {
        if(!$this->middleware('auth:sanctum')){
            return redirect('/login');
        }
    }


    public function store(Request $request)
    {
        $request->validate([
            'rangkuman' => 'required',
            'bap' => 'required',
            'file' => 'required|file|mimes:pdf,jpeg,jpg,doc,docx|max:2000',
        ]);
        $tabel = $request->kelas=='praktek'?'Absen_ajar_praktek':'Absen_ajar';
        $field = $request->kelas=='praktek'?'kel_praktek':'kd_lokal';
        $where = [$field => $request->kd_lokal, 'tgl_ajar_masuk' => date('Y-m-d'), 'kd_mtk' => $request->kd_mtk, 'jam_t' => $request->jam_t];
        $lokal = DB::table('pertemuan')
            ->select(DB::raw('GROUP_CONCAT(kd_lokal) AS kd_lokal'))
            ->where('kd_gabung', '=', $request->kd_lokal)->first();
        $xx = $lokal->kd_lokal;
        $absen_ajar = Absen_praktisi::where($where)->count();
        if ($absen_ajar < 1) {
            $file = $request->file('file');
            $file->storeAs('public/ajar', $file->hashName());
            Absen_praktisi::create([
                'nip' => Auth::user()->username,
                $field => $request->kd_lokal,
                'detail_gabung' => $request->kelas=='gabung'?$xx:"",
                'kd_mtk' => $request->kd_mtk,
                'nm_mtk' => $request->nm_mtk,
                'sks' => $request->sks,
                'tgl_ajar_masuk' => date('Y-m-d'),
                'hari_ajar_masuk' => $request->hari_t,
                'jam_masuk' => date('H:i:s'),
                'no_ruang' => $request->no_ruang,
                // 'pertemuan' => $pert,
                'jam_t' => $request->jam_t,
                'kd_dosen' => Auth::user()->kode,
                'rangkuman'=>$request->rangkuman,
                'berita_acara'=>$request->bap,
                'file_ajar'=>$file->hashName()
            ]);
        return redirect('/jadwal')->with('status', 'Absen Masuk');
        }else{
        return redirect('/jadwal')->with('status', 'Telah Melakukan Absen Masuk');
        }

    }

}
