<?php

namespace App\Http\Controllers\ujian\uts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Perakit_soal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class PerakitSoalController extends Controller
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
        $panitia = Perakit_soal::join('users', 'perakit_soals.kd_dosen', '=', 'users.kode')
        ->select('users.name', 'users.id', 'users.username', 'perakit_soals.*')
        ->get();

    return view('admin.ujian.uts.baak.perakit_soal.index', compact('panitia'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = DB::table('karyawanbs1')
        ->whereIn('dept', ['BSI2', 'BSI3'])
        ->where('status_kry', '1')
        ->get();
        $kampus = DB::table('kampus')->get();

        return view('admin.ujian.uts.baak.perakit_soal.create',compact('user','kampus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'kd_dosen'         => 'required',
            'kd_mtk'        => 'required|numeric',
           
        ]);

        $panitia_adm = Perakit_soal::create([
            'kd_dosen'     => $request->input('kd_dosen'),
            'kd_mtk'       => $request->input('kd_mtk'),
            'paket'        => $request->input('paket'),
            'petugas'      => Auth::user()->username,

        ]);

        if ($panitia_adm) {
            //redirect dengan pesan sukses          
            return redirect('/perakit-soal')->with('status', 'Data Berhasil Ditambah');
        } else {
            //redirect dengan pesan error
            return redirect('/perakit-soal')->with('error', 'Data Gagal Ditambah');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'status' => 'required',
            'id'        => 'required' 
        ]);
        $id = $request->id;
        $ujian = Perakit_soal::find($id);
        if (!$ujian) {
            return redirect()->back()->with('error', 'Data ujian tidak ditemukan.');
        }
    
        $ujian->status           = $request->status;
        $ujian->petugas_acc      = Auth::user()->kode; 
        // $ujian->waktu_verifikasi    = Carbon::now(); 
        $ujian->save(); 
    
        // Redirect back with a success message
        return redirect()->back()->with('status', 'Status berhasil diperbarui.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Perakit_soal::find($id)->delete();
        return redirect('/perakit-soal')->with('status', 'Data Berhasil Dihapus');
    }
}
