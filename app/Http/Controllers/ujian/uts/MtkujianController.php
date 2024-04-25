<?php

namespace App\Http\Controllers\ujian\uts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\Mtk_ujian;
use App\Models\Paket_ujian;



class MtkujianController extends Controller
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
        return view('admin.ujian.uts.baak.mtk.utama', compact('encryptedExamTypes', 'paketUjian'));
       
    }
    public function index($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));

        $mtk_ujian = Mtk_ujian::where([
            'paket'    => $pecah[0]
            ])->get();
        return view('admin.ujian.uts.baak.mtk.index', compact('mtk_ujian'));
    }

    public function create()
    {
        $mtk = DB::table('mtk')->get();
        return view('admin.ujian.uts.baak.mtk.create', compact('mtk'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'kd_mtk'      => 'required',
            'nm_mtk'      => 'required',
            'sks'         => 'required',
            'jenis_mtk'   => 'required',
            'jml_soal'    => 'required'
        ]);
        $mtk_ujian = Mtk_ujian::create([
            'kd_mtk'      => $request->input('kd_mtk'),
            'nm_mtk'      => $request->input('status'),
            'sks'         => $request->input('sks'),
            'jenis'       => $request->input('jenis'),
            'jml_soal'    => $request->input('jml_soal')
        ]);

        if ($mtk_ujian) {
            return redirect('/mtk-uji')->with('status', 'Data Berhasil Ditambah');
        } else {
            return redirect('/mtk-uji')->with('error', 'Gagal Ditambah');
        }
    }

    public function edit($id)
    {
        $mtk_ujian = Mtk_ujian::where('kd_mtk', $id)->first();
        return view('admin.ujian.uts.baak.mtk.edit', compact('mtk_ujian'));
    }

    public function update(Request $request, Mtk_ujian $mtk_ujian)
    {
        $this->validate($request, [
            'keterangan'    => 'required',
            'status'        => 'required'

        ]);

        $mtk = Mtk_ujian::findOrFail($mtk_ujian->id);
        $mtk->update([

            'keterangan'   => $request->input('keterangan'),
            'status'       => $request->input('status')

        ]);

        if ($mtk) {
            //redirect dengan pesan sukses
            return redirect('/mtk-uji')->with(['success' => 'update successfully!']);
        } else {
            //redirect dengan pesan error
            return redirect('/mtk-uji')->with(['error' => 'unsuccessfully!']);
        }
    }

    public function destroy($id)
    {
        Mtk_ujian::find($id)->delete();
        return back()->with(['success' => ' successfully!']);
    }
}
