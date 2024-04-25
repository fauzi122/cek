<?php

namespace App\Http\Controllers\Dosen;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Imports\LatihanSoalpgImport;
use App\Imports\LatihanSoalEssayImport;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\DetailSoalEssay;
use App\Models\Distribusisoal;
use App\Models\Detailsoal;
use App\Models\Jadwal;
use App\Models\Soal;
use App\Models\Kelas;

class LatihanujianController extends Controller
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
        $soals = Soal::leftjoin('mtk', 'soals.kd_mtk', '=', 'mtk.kd_mtk')
            ->select('soals.*', 'mtk.nm_mtk')
            ->where('soals.kd_dosen', Auth::user()->kode)
            ->where('soals.toef', null)
            ->get();

        return view('admin.latihanujian.index', compact('soals'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $materis = Jadwal::where('kd_dosen', Auth::user()->kode)

            ->groupBy('kd_mtk')
            ->get();
        return view('admin.latihanujian.create', compact('materis'));
    }
    public function create_pilih($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        $soal = Soal::where([
            'soals.id'      => $pecah[0]
        ])->first();
        return view('admin.soal.createpilih', compact('id', 'soal'));
    }

    public function create_essay($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        $soal = Soal::where([
            'soals.id'      => $pecah[0]
        ])->first();
        return view('admin.soal.createessay', compact('id', 'soal'));
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

            'kd_mtk'            => 'required',
            'paket'             => 'required',
            'deskripsi'         => 'required',
            'kkm'               => 'required',
            'waktu'             => 'required',
            'jml_soal'          => 'required',
            'tgl_ujian'         => 'required',
            'jam_mulai_ujian'   => 'required',
            'tgl_selsai_ujian'  => 'required',
            'jam_selsai_ujian'  => 'required',

        ]);

        $soal = Soal::create([
            'id_user'           => Auth::user()->id,
            'jenis'             => 1,
            'kd_dosen'          => Auth::user()->kode,
            'kd_mtk'            => $request->input('kd_mtk'),
            'paket'             => $request->input('paket'),
            'deskripsi'         => $request->input('deskripsi'),
            'kkm'               => $request->input('kkm'),
            'waktu'             => $request->input('waktu'),
            'jml_soal'          => $request->input('jml_soal'),
            'tgl_ujian'         => $request->input('tgl_ujian') . ' ' . $request->input('jam_mulai_ujian'),
            'tgl_selsai_ujian'  => $request->input('tgl_selsai_ujian') . ' ' . $request->input('jam_selsai_ujian'),

        ]);

        if ($soal) {
            return redirect('/latihan')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            return redirect('/latihan')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }


    public function store_pilihan(Request $request)
    {
        $this->validate($request, [
            'soal'      => 'required',
            'file'      => 'nullable|file|mimes:jpg,jpeg,png,mp3|max:2500',
            'pila'      => 'required',
            'pilb'      => 'required',
            'pilc'      => 'required',
            'pild'      => 'required',
            'pile'      => 'required',
            'kunci'     => 'required',
            'score'     => 'required',
            'status'    => 'required',
        ]);

        $file = $request->file('file');

        if (isset($file)) {
            $fileName = $file->hashName();
            $file->storeAs('public/soal', $fileName);
        } else {
            $fileName = null;
        }

        $detailsoal = Detailsoal::create([
            'id_soal'   => $request->input('id_soal'),
            'jenis'     => 1,
            'soal'      => $request->input('soal'),
            'file'      => $fileName,
            'pila'      => $request->input('pila'),
            'pilb'      => $request->input('pilb'),
            'pilc'      => $request->input('pilc'),
            'pild'      => $request->input('pild'),
            'pile'      => $request->input('pile'),
            'kunci'     => $request->input('kunci'),
            'score'     => $request->input('score'),
            'id_user'   => $request->input('id_user'),
            'status'    => $request->input('status'),
            'sesi'      => $request->input('sesi')
        ]);

        $gabung = Crypt::encryptString($request->input('id_soal'));

        if ($detailsoal) {
            return redirect('/soal-show/' . $gabung)->with('status', 'Data Ditambah');
        } else {
            return redirect('/soal-show/' . $gabung)->with(['error' => 'Data Gagal Disimpan!']);
        }
    }


    public function storeData_SoalPg(Request $request)
    {
        //VALIDASI
        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);

        if ($request->hasFile('file')) {
            $set = [

                'id_soal'       => $request->input('id_soal'),
                'jenis'         => 1,
                'id_user'       => Auth::user()->id,
                'status'        => 'Y',
                'sesi'          => $request->input('sesi')

            ];
            $file = $request->file('file'); //GET FILE

            Excel::import(new LatihanSoalpgImport($set), $file); //IMPORT FILE 
            return redirect()->back()->with(['success' => 'Upload Soal Pilihan Ganda Berhasil']);
        }
        return redirect()->back()->with(['error' => 'Please choose file before']);
    }

    public function storeData_SoalEssay(Request $request)
    {
        //VALIDASI
        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);

        if ($request->hasFile('file')) {
            $set = [

                'id_soal'       => $request->input('id_soal'),
                'id_user'       => Auth::user()->id,
                'status'        => 'Y'

            ];

            $file = $request->file('file'); //GET FILE

            Excel::import(new LatihanSoalEssayImport($set), $file); //IMPORT FILE 
            return redirect()->back()->with(['success' => 'Upload Soal Essay Berhasil']);
        }
        return redirect()->back()->with(['error' => 'Please choose file before']);
    }

    public function store_essay(Request $request)
    {
        $file = $request->file('file');
        if (isset($file)) {
            $this->validate($request, [

                'soal'      => 'required',
                'status'    => 'required',
                'file'      => 'file|mimes:jpg,jepg,png,mp3|max:2500'
            ]);

            $file = $request->file('file');
            $file->storeAs('public/soalessay', $file->hashName());
            $essaysoal = DetailSoalEssay::create([

                'id_soal'       => $request->input('id_soal'),
                'soal'          => $request->input('soal'),
                'status'        => $request->input('status'),
                'id_user'       => $request->input('id_user'),
                'file'          => $file->hashName()


            ]);
        } else {
            $this->validate($request, [

                'soal'      => 'required',
                'status'    => 'required'

            ]);
            $essaysoal = DetailSoalEssay::create([

                'id_soal'       => $request->input('id_soal'),
                'soal'          => $request->input('soal'),
                'status'        => $request->input('status')

            ]);
        }
        $gabung = Crypt::encryptString($request->input('id_soal'));

        if ($essaysoal) {
            return redirect('/soal-show/' . $gabung)->with('status', 'Data Ditambah');
        } else {
            return redirect('/soal-show/' . $gabung)->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {

        $pecah = explode(',', Crypt::decryptString($id));
        if (Auth::user()->utype == 'ADM') {

            $soals = Detailsoal::where([
                'id_soal'        => $pecah[0]
            ])
                ->orderBy('created_at', 'DESC')
                ->get();

            $essay = DetailSoalEssay::where([
                'id_soal'        => $pecah[0]
            ])
                ->orderBy('created_at', 'DESC')
                ->get();

            $soal = Soal::join('mtk', 'soals.kd_mtk', '=', 'mtk.kd_mtk')
                ->select('mtk.*', 'soals.*')
                ->where([
                    'soals.id'      => $pecah[0]
                ])->first();

            // $cekDistribusisoal = Distribusisoal::get();

            // $cekDistribusisoal = Distribusisoal::get();
            // if (count($cekDistribusisoal) > 0) {
            //     $kelas = Kelas::leftjoin('distribusisoals', 'kelas.id', '=', 'distribusisoals.id_kelas')
            //         ->select('distribusisoals.id_soal', 'kelas.*')
            //         ->orderBy('kelas.id', 'ASC')
            //         ->groupBy('kelas.id')
            //         ->get();
            // } else {
            //     $kelas = Kelas::get();
            // }

            // dd($kelas);

            //  $cekDistribusisoal = Distribusisoal::get();
            // if (count($cekDistribusisoal) > 0) {
            // $kelas =  DB::table('jadwal')
            //     ->leftjoin('distribusisoals', 'jadwal.kd_lokal', '=', 'distribusisoals.id_kelas')
            //     ->select(
            //         'distribusisoals.id_soal',
            //         'distribusisoals.id_kelas',
            //         'distribusisoals.id as id_terbit',
            //         'jadwal.kd_lokal',
            //         'jadwal.kd_dosen',
            //         'jadwal.kd_mtk',
            //         'jadwal.kd_gabung'
            //     )
            //     ->where('jadwal.kd_dosen', Auth::user()->kode)
            //     ->orderBy('distribusisoals.id_kelas', 'DESC')
            //     ->get();
            $kelas =  DB::table('jadwal')
                ->select(
                    'jadwal.kd_lokal',
                    'jadwal.kd_dosen',
                    'jadwal.kd_mtk',
                    'jadwal.kd_gabung'
                )
                ->where('jadwal.kd_dosen', Auth::user()->kode)
                ->get();
            $distribusi = app('App\Models\Soal')->distribusi(['id_soal' => $pecah[0]]);

            //    } else {
            //     $kelas = DB::table('jadwal')
            //     ->where('jadwal.kd_dosen', Auth::user()->kode)
            //     ->get();

            // }
            // dd($distribusi);
            return view('admin.soal.show', compact('soal', 'kelas', 'soals', 'essay', 'distribusi'));
        } else {
            return redirect('/dashboard');
        }
    }

    public function show_detailsoal($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        $detailsoal = Detailsoal::where([
            'id'   => $pecah[0]
        ])->first();
        return view('admin.soal.detailsoal', compact('detailsoal', 'id'));
    }
    public function show_detalessay($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        $detailsoal = DetailSoalEssay::where([
            'id'   => $pecah[0]
        ])->first();
        return view('admin.soal.detailsoal_essay', compact('detailsoal', 'id'));
    }

    public function terbitSoal(Request $request)
    {
        if ($request->status == '1') {
            $terbit = Distribusisoal::create([
                'id_soal'       => $request->id_soal,
                'id_kelas'      => $request->nm_kelas
            ]);
        } else {
            $cek = Distribusisoal::where('id_soal', $request->id_soal)
                ->where('id_kelas', $request->nm_kelas)->delete();
        }
        return response()->json(['success' => 'Berhasil Cuy']);


        // if ($terbit) {
        //     return back();
        // } else {
        //     return back();
        // }
        //   Distribusisoal::where('id_soal', $request->id_soal)->where('id_kelas', $request->id_kelas)->delete();

    }
    public function terbitSoalNetral(Request $request)
    {
        Distribusisoal::where('id_soal', $request->id_soal)
            ->where('id_kelas', $request->id_kelas)->delete();
        return back();
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));

        $materis = Jadwal::where('kd_dosen', Auth::user()->kode)
            ->groupBy('kd_mtk')
            ->get();

        $editjadwal = Soal::where([
            'id'   => $pecah[0]
        ])->first();
        return view('admin.latihanujian.editjadwal', compact('editjadwal', 'id', 'materis'));
    }

    public function edit_detalsoal($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        $editsoal = Detailsoal::where([
            'id'   => $pecah[0]
        ])->first();
        return view('admin.soal.form.editsoal', compact('editsoal', 'id'));
    }

    public function edit_detalessay($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        $editsoal = DetailSoalEssay::where([
            'id'   => $pecah[0]
        ])->first();
        return view('admin.soal.form.editsoal_essay', compact('editsoal', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Soal $soal)
    {

        $this->validate($request, [
            'kd_mtk'            => 'required',
            'paket'             => 'required',
            'deskripsi'         => 'required',
            'kkm'               => 'required',
            'waktu'             => 'required',
            'jml_soal'          => 'required',
            'tgl_selsai_ujian'  => 'required',
        ]);

        $soal = Soal::findOrFail($soal->id);
        $soal->update([
            'id_user'           => Auth::user()->id,
            'jenis'             => 1,
            'kd_dosen'          => Auth::user()->kode,
            'kd_mtk'            => $request->input('kd_mtk'),
            'paket'             => $request->input('paket'),
            'deskripsi'         => $request->input('deskripsi'),
            'kkm'               => $request->input('kkm'),
            'waktu'             => $request->input('waktu'),
            'jml_soal'          => $request->input('jml_soal'),
            'tgl_ujian'         => $request->input('tgl_ujian'),
            'tgl_selsai_ujian'  => $request->input('tgl_selsai_ujian'),
        ]);

        if ($soal) {
            //redirect dengan pesan sukses
            return redirect('/latihan')->with('status', 'Data Diupdate');
        } else {
            return redirect('/latihan')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    public function update_soalpilih(Request $request, Detailsoal $detailsoal)
    {
        $validator = Validator::make($request->all(), [
            'soal'      => 'required',
            'pila'      => 'required',
            'pilb'      => 'required',
            'pilc'      => 'required',
            'pild'      => 'required',
            'pile'      => 'required',
            'kunci'     => 'required',
            'score'     => 'required',
            'file'      => 'nullable|file|mimes:pdf,doc,docx,mp3|max:2500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('file')) {
            // Remove old file
            Storage::disk('public')->delete('soal/' . $detailsoal->file);

            // Upload new file
            $file = $request->file('file');
            $file->storeAs('public/soal', $file->hashName());

            $detailsoal->file = $file->hashName();
        }

        $detailsoal->id_soal = $request->input('id_soal');
        $detailsoal->jenis = 1;
        $detailsoal->soal = $request->input('soal');
        $detailsoal->pila = $request->input('pila');
        $detailsoal->pilb = $request->input('pilb');
        $detailsoal->pilc = $request->input('pilc');
        $detailsoal->pild = $request->input('pild');
        $detailsoal->pile = $request->input('pile');
        $detailsoal->kunci = $request->input('kunci');
        $detailsoal->score = $request->input('score');
        $detailsoal->id_user = $request->input('id_user');
        $detailsoal->status = $request->input('status');
        $detailsoal->sesi = $request->input('sesi');

        $detailsoal->save();

        $gabung = Crypt::encryptString($request->input('id_soal'));

        if ($detailsoal) {
            return redirect('/soal-show/' . $gabung)->with('status', 'Data Diupdate');
        } else {
            return redirect('/soal-show/' . $gabung)->with(['error' => 'Data Gagal Diupdate!']);
        }
    }


    public function update_essay(Request $request, DetailSoalEssay $detailSoalEssay)
    {
        $this->validate($request, [
            'soal'      => 'required',
            'status'    => 'required'
            // 'file'      => 'file|mimes:jpg,jepg,png|max:2500'
        ]);
        if ($request->file('file') == "") {

            $detailSoalEssay = DetailSoalEssay::findOrFail($detailSoalEssay->id);
            $detailSoalEssay->update([
                'id_soal'       => $request->input('id_soal'),
                'soal'          => $request->input('soal'),
                'status'        => $request->input('status'),
                'id_user'       => $request->input('id_user')
            ]);
        } else {

            //remove old image
            Storage::disk('local')->delete('public/soalessay/' . $detailSoalEssay->file);

            //upload new image
            $image = $request->file('file');
            $image->storeAs('public/soalessay', $image->hashName());

            $detailSoalEssay = DetailSoalEssay::findOrFail($detailSoalEssay->id);
            $detailSoalEssay->update([
                'id_soal'       => $request->input('id_soal'),
                'soal'          => $request->input('soal'),
                'status'        => $request->input('status'),
                'id_user'       => $request->input('id_user'),
                'file'          => $image->hashName()
            ]);
        }
        $gabung = Crypt::encryptString($request->input('id_soal'));

        if ($detailSoalEssay) {
            //redirect dengan pesan sukses
            return redirect('/soal-show/' . $gabung)->with('status', 'Data Ditambah');
        } else {
            return redirect('/soal-show/' . $gabung)->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
