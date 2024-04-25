<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Tugas;
use App\Models\Tugasmhs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use App\Models\Wa_status;
use App\Models\Send_wa;

class TugasController extends Controller
{
    public function __construct()
    {
        if (!$this->middleware('auth:sanctum')) {
            return redirect('/login');
        }
        // return $this->middleware('auth:sanctum');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        // phpinfo();die;
        //di buat array utuk deskrip kode nya
        // 0 => "DPG.17.1C.12.A"
        // 1 => "894"
        // 2 => "201704121"
        $pecah = explode(',', Crypt::decryptString($id));
        $tugas = Tugas::where([
            'kd_dosen'       => Auth::user()->kode,
            'kd_mtk'    => $pecah[1],
            'kd_lokal'  => $pecah[0]
        ])->get();
        return view('admin.tugas.index', compact('tugas', 'id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));

        //tugas gabungan
        $w_cek = [
            // 'nip'        => Auth::user()->username,
            'kd_mtk'     => $pecah[1],
            'kd_gabung'  => $pecah[0]
        ];
        $cek = app('App\Models\Absen_ajar_praktek')->jadwal($w_cek)->count();

        //tugas bukan gabung 
        if ($cek < 1) {

            $where =  [
                // 'nip'       => Auth::user()->username,
                'kd_mtk'    => $pecah[1],
                'kd_lokal'  => $pecah[0]
            ];

            $tugas = app('App\Models\Absen_ajar_praktek')->jadwal($where)->first();
        } else {
            $tugas = app('App\Models\Absen_ajar_praktek')->jadwal($w_cek)->first();
        }
        // dd($tugas);
        return view('admin.tugas.create', compact('tugas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        // dd($request->input('tgl_mulai').' '.$request->input('jam_mulai'));

        $file = $request->file('file');
        if (isset($file)) {
            $this->validate($request, [
                'nip'         => 'required',
                'kd_dosen'    => 'required',
                'kd_mtk'      => 'required',
                'kd_lokal'    => 'required',
                'judul'       => 'required',
                'deskripsi'   => 'required',
                'pertemuan'   => 'required',
                'tgl_mulai'   => 'required',
                'jam_mulai'   => 'required',
                'tgl_selsai'  => 'required',
                'jam_selsai'  => 'required',
                'file'        => 'required|file|mimes:pdf,|max:2000',

            ]);

            $file = $request->file('file');
            $file->storeAs('public/tugas', $file->hashName());
            $tugas = Tugas::create([

                'nip'           => $request->input('nip'),
                'kd_dosen'      => $request->input('kd_dosen'),
                'kd_mtk'        => $request->input('kd_mtk'),
                'kd_lokal'      => $request->input('kd_lokal'),
                'judul'         => $request->input('judul'),
                'deskripsi'     => $request->input('deskripsi'),
                'pertemuan'     => $request->input('pertemuan'),
                'mulai'         => $request->input('tgl_mulai') . ' ' . $request->input('jam_mulai'),
                'selsai'        => $request->input('tgl_selsai') . ' ' . $request->input('jam_selsai'),
                'file'          => $file->hashName(),
                'sts_wa'        => '0'

            ]);
        } else {
            $this->validate($request, [

                'nip'         => 'required',
                'kd_mtk'      => 'required',
                'kd_lokal'    => 'required',
                'judul'       => 'required',
                'deskripsi'   => 'required',
                'pertemuan'   => 'required',
                'tgl_mulai'      => 'required',
                'jam_mulai'      => 'required',
                'tgl_selsai'       => 'required',
                'jam_selsai'       => 'required',

            ]);

            $tugas = Tugas::create([

                'nip'           => $request->input('nip'),
                'kd_mtk'        => $request->input('kd_mtk'),
                'kd_lokal'      => $request->input('kd_lokal'),
                'judul'         => $request->input('judul'),
                'deskripsi'     => $request->input('deskripsi'),
                'pertemuan'     => $request->input('pertemuan'),
                'mulai'         => $request->input('tgl_mulai') . ' ' . $request->input('jam_mulai'),
                'selsai'        => $request->input('tgl_selsai') . ' ' . $request->input('jam_selsai'),
                'sts_wa'        => '0'

            ]);
        }
        // dd($tugas);
        $gabung = Crypt::encryptString($request->input('kd_lokal') . ',' . $request->input('kd_mtk') . ',' . $request->input('nip'));
        if ($tugas) {
            return redirect('/tugas/' . $gabung)->with('status', 'Data Berhasil Ditambah');
        } else {
            return redirect('/tugas/' . $gabung)->with('error', 'Gagal Ditambah');
        }
    }

    public function send_tugas(Request $request)
    {
        for ($i = 1; $i <= count($request->no_urut); $i++) {
            $tugas = Tugasmhs::updateOrCreate(
                [
                    'nim' => $request->no_urut[$i],
                    'id_tugas' => $request->id_tugas
                ],

                [
                    'nim' => $request->no_urut[$i],
                    'nilai' => $request->nilai[$i],
                    'komentar' => $request->komentar[$i]
                ]
            );
        }
        if ($tugas) {
            return redirect('/tugas-show/' . $request->id)->with('status', 'Data Berhasil Diupdate');
        } else {
            return redirect('/tugas-show/' . $request->id)->with('error', 'Gagal Diupdate');
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
        // 0 => "11"
        // 1 => "12.3A.06"
        // 2 => "328"
        // 3 => "1"
        $pecah = explode(',', Crypt::decryptString($id));
        // dd($pecah);
        $tugas = Tugas::where(['id'  => $pecah[0]])->first();
        $mahasiswa = app('App\Models\Tugas')->showMhs($pecah[2], $pecah[1]);
        $nilai = app('App\Models\Tugas')->nilai_mhs($pecah[0]);
        if(!isset($mahasiswa)){
            $mahasiswa = app('App\Models\Tugas')->showMhsMbkm($pecah[1]);
        }
        // dd($mahasiswa);
        // dd($nilai['12190874 ']->isi);
        return view('admin.tugas.show', compact('tugas', 'mahasiswa', 'nilai', 'id'));
        // return view('admin.tugas.create',compact('tugas'));


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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tugas $tugas)
    {
        $tg = Tugas::destroy($tugas->id);
        $file = Storage::disk('local')->delete('public/tugas/' . $tugas->file);
        if ($tg) {
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }

    public function download_file_tugas(Request $request)
    {
        if ($request->file <> '') {
            $files = public_path() . '/storage/tugas/' . $request->file; //Mencari file dari model yang sudah dicari
            return response()->download($files, $request->file);
        } else {
            return redirect('/tugas/' . $request->id)->with('error', 'File Kosong');
            echo "kosong";
        }
    }
}
