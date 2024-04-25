<?php

namespace App\Http\Controllers\mhs;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\MhsModel;

class KuisonerpmdController extends Controller
{
    public function index()
    {
        $result = DB::table('mhs')
        ->join('jrskampus', 'mhs.kd_jrs', '=', 'jrskampus.kd_jrs')
        ->select('mhs.nim', 'jrskampus.nm_jrs', 'jrskampus.upps', 'jrskampus.fakultas')
        ->where('mhs.nim', Auth::user()->username)
        ->whereRaw("jrskampus.kd_cab = SUBSTRING('" . Auth::user()->kode . "', -2, 2)")
        ->where('mhs.kondisi', 1)
        ->first();
    
        return view('mhs.kusioner.index', compact('result'));
    
       
    }

    public function store(Request $request)
    {
        // Validasi request input sesuai kebutuhan Anda di sini, jika diperlukan
    
        // Menggunakan metode create untuk membuat dan menyimpan model MhsModel
        $mhs = MhsModel::create([
            'nim' => $request->input('nim'),
            'name' => $request->input('name'),
            'nip_dosen' => $request->input('nip_dosen'),
            'mtk' => $request->input('mtk'),
            'kelas' => $request->input('kelas'),
            'prodi' => $request->input('prodi'),
            'upps' => $request->input('upps'),
            'periode' => $request->input('periode'),
            'f31' => $request->input('cf31'),
            'f32' => $request->input('cf32'),
            'f33' => $request->input('cf33'),
            'f34' => $request->input('cf34'),
            'f41' => $request->input('cf41'),
            'f42' => $request->input('cf42'),
            'f43' => $request->input('cf43'),
            'f44' => $request->input('cf44'),
            'f51' => $request->input('cf51'),
            'f52' => $request->input('cf52'),
            'f53' => $request->input('cf53'),
            'f54' => $request->input('cf54'),
            'pts' => 'UBSI',
            'f6' => $request->input('cf6'),
            'status' => 1,
            // 'tgl_input' => now()
        ]);
    
        if ($mhs) {
            return redirect()->back()->with(['success' => 'Berhasil disimpan']);
        } else {
            return redirect()->back()->with(['error' => 'Gagal disimpan']);
        }
    }
    
}
