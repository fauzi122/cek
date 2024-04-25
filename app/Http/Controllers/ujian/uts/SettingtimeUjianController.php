<?php

namespace App\Http\Controllers\ujian\uts;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\SettingUjian;

class SettingtimeUjianController extends Controller
{
    public function __construct()
    {
        if (!$this->middleware('auth:sanctum')) {
            return redirect('/login');
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = SettingUjian::get();
        return view('admin.ujian.uts.baak.setting.index',compact('setting'));
    }
    
    public function show($id, Request $request)
    {
        $pecah = explode(',', Crypt::decryptString($id));

        if (Auth::user()->utype == 'ADM') {
            $tgluji = DB::table('wkt_ujian')
                        ->where('paket', $pecah[0])
                        ->orderBy('tgl_ujian', 'DESC')
                        ->get();
            return view('admin.ujian.uts.baak.setting.show', compact('tgluji'));
        } else {

            return redirect('/dashboard');
        }
    }
    public function edit($id)
    {
        $decrypted = Crypt::decryptString($id);
        [$kel_ujian, $tgl_ujian, $hari_ujian, $paket] = explode(',', $decrypted);
    
        $wkt_ujian = DB::table('wkt_ujian')
            ->where('kel_ujian', $kel_ujian)
            ->where('tgl_ujian', $tgl_ujian)
            ->where('hari_ujian', $hari_ujian)
            ->where('paket', $paket)
            ->first();
    
        return view('admin.ujian.uts.baak.setting.edit', compact('wkt_ujian'));
    }
    
    public function update(Request $request, $id)
    {
        // Dekripsi ID untuk mendapatkan parameter yang diperlukan
        $decrypted = Crypt::decryptString($id);
        [$kel_ujian, $tgl_ujian, $hari_ujian, $paket] = explode(',', $decrypted);
    
        // Validasi request
        $request->validate([
            'kel_ujian'  => 'required',
            'tgl_ujian'  => 'required|date',
            'hari_ujian' => 'required',
            'status'     => 'required',
        ]);
    
        // Proses update data
        $affected = DB::table('wkt_ujian')
            ->where('kel_ujian', $kel_ujian)
            ->where('tgl_ujian', $tgl_ujian)
            ->where('hari_ujian', $hari_ujian)
            ->where('paket', $paket)
            ->update([
                'kel_ujian'  => $request->kel_ujian,
                'tgl_ujian'  => $request->tgl_ujian,
                'hari_ujian' => $request->hari_ujian,
                'status'     => $request->status,
                'petugas'    => Auth::user()->username  // Pastikan field ini ada di tabel Anda
            ]);

            $gabung = Crypt::encryptString($request->input('paket'));
       
            if ($affected) {
         return redirect('/detail-time-setting/' . $gabung)->with('success', 'Data Updated successfully');

        } else {
         return redirect('/detail-time-setting/' . $gabung)->with('error', 'No changes made to the data or record not found');

        }
    }
    
    

    public function destroy($id)
    {
        $decrypted = Crypt::decryptString($id);
        [$kel_ujian, $tgl_ujian, $hari_ujian, $paket] = explode(',', $decrypted);

        $deleted = DB::table('wkt_ujian')
            ->where('kel_ujian', $kel_ujian)
            ->where('tgl_ujian', $tgl_ujian)
            ->where('hari_ujian', $hari_ujian)
            ->where('paket', $paket)
            ->delete();

        return back()->with('success', 'Data deleted successfully');
    }
  
}
