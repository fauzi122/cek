<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\video;
use App\Models\Sapa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use App\Models\Send_wa;
use App\Models\Wa_status;



class SapaanController extends Controller
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
    public function index($id)
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        $w_cek =

            [
                // 'nip' => Auth::user()->username,
                'kd_mtk'     => $pecah[1],
                'kd_gabung'  => $pecah[0]
            ];
        $cek = app('App\Models\Absen_ajar_praktek')->jadwal($w_cek)->count();

        if ($cek < 1) {
            $where =
                [
                    // 'nip' => Auth::user()->username,
                    'kd_mtk'    => $pecah[1],
                    'kd_lokal'  => $pecah[0]
                ];
            $materi = app('App\Models\Absen_ajar_praktek')->jadwal($where)->first();
        } else {
            $materi = app('App\Models\Absen_ajar_praktek')->jadwal($w_cek)->first();
        }

        return view('admin.materi.create-spa', compact('materi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $gabung = Crypt::encryptString($request->input('kd_lokal') . ',' . $request->input('kd_mtk') . ',' . $request->input('nip'));
        //video tambahan
        $this->validate($request, [

            'nip'         => 'required',
            'kd_dosen'    => 'required',
            'kd_mtk'      => 'required',
            'kd_lokal'    => 'required',
            'judul'       => 'required',
            'deskripsi'   => 'required',
            'pertemuan'   => 'required',
            'file'        => 'required|file|mimes:pdf,|max:2500',

        ]);
        $file = $request->file('file');
        $file->storeAs('public/materi', $file->hashName());
        $materi = Sapa::create([

            'nip'           => $request->input('nip'),
            'kd_dosen'      => $request->input('kd_dosen'),
            'kd_mtk'        => $request->input('kd_mtk'),
            'kd_lokal'      => $request->input('kd_lokal'),
            'judul'         => $request->input('judul'),
            'deskripsi'     => $request->input('deskripsi'),
            'pertemuan'     => $request->input('pertemuan'),
            'file'          => $file->hashName(),


        ]);

        $gabung = Crypt::encryptString($request->input('kd_lokal') . ',' . $request->input('kd_mtk') . ',' . $request->input('nip'));
        if ($materi) {
            return redirect('/materi/' . $gabung)->with('status', 'Data Ditambah');
        } else {
            return redirect('/materi/' . $gabung)->with('error', 'Gagal Ditambah');
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
    public function destroy(Sapa $sapa)
    {
        $cek = Sapa::where([
            'id'       => $sapa->id
        ])->first();
        $gabung = Crypt::encryptString($cek->kd_lokal . ',' . $cek->kd_mtk . ',' . $cek->nip);
        $mt = Sapa::destroy($sapa->id);
        $file = Storage::disk('local')->delete('public/materi/' . $cek->file);
        if ($mt) {
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }

    public function download_file_sapa(Request $request)
    {
        $files = public_path() . '/storage/materi/' . $request->file; //Mencari file dari model yang sudah dicari
        if (file_exists($files)) {
            return response()->download($files, $request->file);
        } else {
            echo "kosong";
        }
    }
}
