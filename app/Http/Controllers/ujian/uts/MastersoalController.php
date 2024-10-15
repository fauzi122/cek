<?php

namespace App\Http\Controllers\ujian\uts;

use App\Imports\UjianSoalEssayImport;
use App\Imports\UjianSoalpgImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Stevebauman\Location\Facades\Location;
use Illuminate\Http\Request;
use App\Models\Soal;
use App\Models\Soal_ujian;
use App\Models\Mtk_ujian;
use App\Models\Jadwal;
use App\Models\ujian_aprov;
use App\Models\Paket_ujian;
use App\Models\Detailsoal_ujian;
use App\Models\DetailSoalEssay_ujian;
use App\Models\perakit_bahan_ajar;
use Carbon\Carbon; 

class MastersoalController extends Controller
{
    public function __construct()
    {
       $this->middleware(['permission:master_soal_ujian|master_soal_ujian.index|master_soal_ujian.edit|hapus_acc']);
       if(!$this->middleware('auth:sanctum')){
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
      
        $examTypes = Paket_ujian::distinct()->pluck('paket');

        $encryptedExamTypes = $examTypes->mapWithKeys(function ($item) {
            return [$item => Crypt::encryptString($item)];
        });
    
        $paketUjian = Paket_ujian::all();
        return view('admin.ujian.uts.baak.mastersoal.index', compact('encryptedExamTypes', 'paketUjian'));
    }
    
    public function index_uts($id)
    {

    if (Auth::user()->utype == 'ADM') {

        $pecah = explode(',', Crypt::decryptString($id));
        $soals = Mtk_ujian::where('mtk_ujians.paket', $pecah[0])->get();
    
        // Mendapatkan data aprovasi dan mengurutkannya berdasarkan perakit_kirim
        $aprov = ujian_aprov::select('kd_mtk', 'perakit_kirim',
                'perakit_kirim_essay',
                'acc_kaprodi',
                'acc_kaprodi_essay',
                'acc_baak',
                'acc_baak_essay',)
            ->where('paket', $pecah[0])
            ->get()
            ->sortByDesc('perakit_kirim') 
            ->keyBy('kd_mtk');
    
        $detailsoal = DB::table('ujian_detailsoals')
            ->select(DB::raw('kd_mtk, COUNT(*) as jumlah'))
            ->where('jenis', $pecah[0])
            ->groupBy('kd_mtk')
            ->pluck('jumlah', 'kd_mtk');

            // dd($detailsoal);
    
        $detailsoal_essay = DB::table('ujian_detail_soal_esays')
            ->select(DB::raw('kd_mtk, COUNT(*) as jumlah'))
            ->where('jenis', $pecah[0])
            ->groupBy('kd_mtk')
            ->pluck('jumlah', 'kd_mtk');
    
        return view('admin.ujian.uts.baak.mastersoal.uts', compact('soals', 'detailsoal', 'detailsoal_essay', 'aprov'));
        } else {
            return redirect('/dashboard');
        }
    }
    
    public function create_pilih_uts($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        // dd($pecah);
        $soal = Mtk_ujian::where([
            'kd_mtk'      => $pecah[0],
            'paket'       => $pecah[1]
            ])->first();
        return view('admin.ujian.uts.baak.mastersoal.createpilih_uts', compact('id', 'soal'));
    }

    public function create_essay_uts($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        // dd($pecah);
        $soal = Mtk_ujian::where([
            'kd_mtk'      => $pecah[0],
            'paket'       => $pecah[1]
            ])->first();
        return view('admin.ujian.uts.baak.mastersoal.createessay_uts', compact('id', 'soal'));
    }

    public function store_pilihan_uts(Request $request)
    {
        $file = $request->file('file');
        if (isset($file)) {
            $this->validate($request, [

                'soal'      => 'required',
                'file'      => 'nullable|file|mimes:jpg,jpeg,png|max:2500',
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
            $file->storeAs('public/soal', $file->hashName());
            $detailsoal = Detailsoal_ujian::create([

                'kd_mtk'        => $request->input('kd_mtk'),
                'jenis'         => $request->input('jenis'),
                'soal'          => $request->input('soal'),
                'file'          => $file->hashName(),
                'pila'          => $request->input('pila'),
                'pilb'          => $request->input('pilb'),
                'pilc'          => $request->input('pilc'),
                'pild'          => $request->input('pild'),
                'pile'          => $request->input('pile'),
                'kunci'         => $request->input('kunci'),
                'score'         => $request->input('score'),
                'id_user'       => $request->input('id_user'),
                'status'        => $request->input('status'),
                'sesi'          => $request->input('sesi')

            ]);
        } else {
            $this->validate($request, [

                'soal'      => 'required',

                'pila'      => 'required',
                'pilb'      => 'required',
                'pilc'      => 'required',
                'pild'      => 'required',
                'pile'      => 'required',
                'kunci'     => 'required',
                'score'     => 'required',
                'status'    => 'required',

            ]);
            $detailsoal = Detailsoal_ujian::create([

                'kd_mtk'        => $request->input('kd_mtk'),
                'jenis'         =>  $request->input('jenis'),
                'soal'          => $request->input('soal'),
                'pila'          => $request->input('pila'),
                'pilb'          => $request->input('pilb'),
                'pilc'          => $request->input('pilc'),
                'pild'          => $request->input('pild'),
                'pile'          => $request->input('pile'),
                'kunci'         => $request->input('kunci'),
                'score'         => $request->input('score'),
                'id_user'       => $request->input('id_user'),
                'status'        => $request->input('status'),
                'sesi'          => $request->input('sesi')

            ]);
        }

        $gabung = Crypt::encryptString($request->input('kd_mtk') . ',' .$request->input('jenis'));       

        if ($detailsoal) {
            return redirect('/baak/uts-soal-show/' . $gabung)->with('status', 'Data Ditambah');
        } else {
            return redirect('/baak/uts-soal-show/' . $gabung)->with(['error' => 'Data Gagal Disimpan!']);
        }
    }
    public function store_essay_uts(Request $request)
    {
        $file = $request->file('file');
        if (isset($file)) {
            $this->validate($request, [

                'soal'      => 'required',
                'status'    => 'required',
                'kunci' => 'required',
                'file'      => 'nullable|file|mimes:jpg,jpeg,png|max:2500',
            ]);

            $file = $request->file('file');
            $file->storeAs('public/soalessay', $file->hashName());
            $essaysoal = DetailSoalEssay_ujian::create([

                'kd_mtk'        => $request->input('kd_mtk'),
                'jenis'         => $request->input('jenis'),
                'soal'          => $request->input('soal'),
                'kunci'   => $request->input('kunci'),
                'status'        => $request->input('status'),
                'id_user'       => $request->input('id_user'),
                'file'          => $file->hashName()
            ]);
        } else {
            $this->validate($request, [

                'soal'      => 'required',
                'status'    => 'required',
                'kunci'     => 'required',
                

            ]);
            $essaysoal = DetailSoalEssay_ujian::create([

                'kd_mtk'        => $request->input('kd_mtk'),
                'jenis'         => $request->input('jenis'),
                'soal'          => $request->input('soal'),
                'kunci'   => $request->input('kunci'),
                'status'        => $request->input('status'),
                'id_user'       => $request->input('id_user'),

            ]);
        }
        $gabung = Crypt::encryptString($request->input('kd_mtk') . ',' .$request->input('jenis'));       

        if ($essaysoal) {
            return redirect('/baak/uts-soal-show/' . $gabung)->with('status', 'Data Ditambah');
        } else {
            return redirect('/baak/uts-soal-show/' . $gabung)->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function storeData_SoalPg(Request $request)
    {
        // Validasi
        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);
    
        if ($request->hasFile('file')) {
            $set = [
                'kd_mtk'    => $request->input('kd_mtk'),
                'jenis'     => $request->input('jenis'),
                'score'     => 1,
                'id_user'   => Auth::user()->kode,
                'status'    => 'Y',
                'sesi'      => $request->input('sesi')
            ];
            $file = $request->file('file'); // Mengambil file
    
            $import = new UjianSoalpgImport($set); // Membuat instance import dengan konfigurasi
            Excel::import($import, $file); // Melakukan impor file
    
            // Cek jumlah pembaruan dan kirim notifikasi yang sesuai
            if ($import->getUpdatesCount() > 0) {
                // Jika ada pembaruan, kirim notifikasi tentang pembaruan
                $message = 'Upload Soal Pilihan Ganda Berhasil. ' . $import->getUpdatesCount() . ' data diperbarui.';
                return redirect()->back()->with(['success' => $message]);
            } else {
                // Jika tidak ada pembaruan, kirim notifikasi umum
                return redirect()->back()->with(['success' => 'Upload Soal Pilihan Ganda Berhasil.']);
            }
        }
    
        // Jika file tidak dipilih
        return redirect()->back()->with(['error' => 'Mohon pilih file terlebih dahulu.']);
    }
    
    
    public function storeData_SoalEssay(Request $request)
        {
            // Validasi
            $this->validate($request, [
                'file' => 'required|mimes:xls,xlsx'
            ]);
    
            if ($request->hasFile('file')) {
                $set = [
                    'kd_mtk'  => $request->input('kd_mtk'),
                    'jenis'   => $request->input('jenis'),
                    'id_user' => Auth::user()->id, // Sesuaikan sesuai cara Anda mendapatkan ID pengguna
                    'status'  => 'Y',
                ];
    
                $file = $request->file('file');
    
                $import = new UjianSoalEssayImport($set);
                Excel::import($import, $file);
    
                if ($import->getUpdatesCount() > 0) {
                    $message = 'Upload Soal Esai Berhasil. ' . $import->getUpdatesCount() . ' data diperbarui.';
                    return redirect()->back()->with(['success' => $message]);
                } else {
                    return redirect()->back()->with(['success' => 'Upload Soal Esai Berhasil.']);
                }
            }
    
            return redirect()->back()->with(['error' => 'Mohon pilih file terlebih dahulu.']);
        }

  
    public function show($id, Request $request)
    {

        $pecah = explode(',', Crypt::decryptString($id));

        if (Auth::user()->utype == 'ADM') {

            // PG
            $soals = Detailsoal_ujian::where([
                'kd_mtk' => $pecah[0],
                'jenis' => $pecah[1]
                ])
            ->orderBy('created_at', 'DESC')
                ->get();
            
            $perakit_soal = Detailsoal_ujian::where([
                    'kd_mtk' => $pecah[0],
                    'jenis' => $pecah[1]
                    ])
                ->select('id_user')
                ->groupBy('id_user')
                ->first();
                // dd($perakit_soal);
        
            // essay
            $essay = DetailSoalEssay_ujian::where([
                'kd_mtk' => $pecah[0],
                'jenis' => $pecah[1]
                ])
                ->orderBy('created_at', 'DESC')
                ->get();

            // Detail
            $soal = Mtk_ujian::where([
                'kd_mtk' => $pecah[0],
                'paket' => $pecah[1]
                
                ])->select('kd_mtk','paket','nm_mtk','jenis_mtk')
                ->first();

            $acc = ujian_aprov::where([
                'kd_mtk' => $pecah[0],
                'paket' => $pecah[1]
                    
                ])->select('kd_mtk','paket','kd_dosen_perakit',
                'perakit_kirim',
                'perakit_kirim_essay',
                'tgl_perakit',
                'kd_dosen_kaprodi',
                'acc_kaprodi',
                'acc_kaprodi_essay',
                'tgl_kaprodi',
                'kd_dosen_baak',
                'acc_baak',
                'acc_baak_essay',
                'tgl_baak',)
                ->first();

            return view('admin.ujian.uts.baak.mastersoal.show_uts', compact('soals', 'essay', 'soal','acc','perakit_soal'));
        } else {
            return redirect('/dashboard');
        }
    }

    
    public function show_detailsoal_uts($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        $detailsoal = Detailsoal_ujian::where([
            'id'   => $pecah[0]
        ])->first();
        return view('admin.ujian.uts.baak.mastersoal.detailsoal_uts', compact('detailsoal', 'id'));
    }
    public function show_detalessay_uts($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        $detailsoal = DetailSoalEssay_ujian::where([
            'id'   => $pecah[0]
        ])->first();
        return view('admin.ujian.uts.baak.mastersoal.detailsoal_essay_uts', compact('detailsoal', 'id'));
    }


    public function edit_detalsoal_uts($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        $editsoal = Detailsoal_ujian::where([
            'id'   => $pecah[0]
        ])->first();
        return view('admin.ujian.uts.baak.mastersoal.form.editsoal_uts', compact('editsoal', 'id'));
    }

    public function edit_detalessay_uts($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        $editsoal = DetailSoalEssay_ujian::where([
            'id'   => $pecah[0]
        ])->first();
        return view('admin.ujian.uts.baak.mastersoal.form.editsoal_essay_uts', compact('editsoal', 'id'));
    }


    public function update_soalpilih_uts(Request $request, Detailsoal_ujian $detailsoal_ujian)
    {
        $this->validate($request, [
            'soal'      => 'required',
            'pila'      => 'required',
            'pilb'      => 'required',
            'pilc'      => 'required',
            'pild'      => 'required',
            'pile'      => 'required',
            'kunci'     => 'required',
            'score'     => 'required',
            'file'  => 'nullable|file|mimes:jpg,jpeg,png|max:2500',
        ]);

        if ($request->file('file') == "") {

            $detailsoal_ujian = Detailsoal_ujian::findOrFail($detailsoal_ujian->id);
            $detailsoal_ujian->update([
                'kd_mtk'        => $request->input('kd_mtk'),
                'jenis'         => $request->input('jenis'),
                'soal'          => $request->input('soal'),
                'pila'          => $request->input('pila'),
                'pilb'          => $request->input('pilb'),
                'pilc'          => $request->input('pilc'),
                'pild'          => $request->input('pild'),
                'pile'          => $request->input('pile'),
                'kunci'         => $request->input('kunci'),
                'score'         => $request->input('score'),
                // 'id_user'       => $request->input('id_user'),
                'status'        => $request->input('status'),
                'sesi'          => $request->input('sesi')

            ]);
        } else {

            //remove old image
            Storage::disk('local')->delete('public/soal/' . $detailsoal_ujian->file);

            //upload new image
            $image = $request->file('file');
            $image->storeAs('public/soal', $image->hashName());

            $detailsoal_ujian = Detailsoal_ujian::findOrFail($detailsoal_ujian->id);
            $detailsoal_ujian->update([
                'kd_mtk'        => $request->input('kd_mtk'),
                'jenis'         => $request->input('jenis'),
                'soal'          => $request->input('soal'),
                'file'          => $image->hashName(),
                'pila'          => $request->input('pila'),
                'pilb'          => $request->input('pilb'),
                'pilc'          => $request->input('pilc'),
                'pild'          => $request->input('pild'),
                'pile'          => $request->input('pile'),
                'kunci'         => $request->input('kunci'),
                'score'         => $request->input('score'),
                // 'id_user'       => $request->input('id_user'),
                'status'        => $request->input('status'),
                'sesi'          => $request->input('sesi')

            ]);
        }

        $gabung = Crypt::encryptString($request->input('kd_mtk') . ',' .$request->input('jenis'));       

        if ($detailsoal_ujian) {
            //redirect dengan pesan sukses
            return redirect('/baak/uts-soal-show/' . $gabung)->with('status', 'Data Diupdate');
        } else {
            return redirect('/baak/uts-soal-show/' . $gabung)->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    public function update_essay_uts(Request $request, DetailSoalEssay_ujian $detailSoalEssay_ujian)
    {
        $this->validate($request, [
            'soal'      => 'required',
            'status'    => 'required',
            'kunci'      => 'required',
            'file'      => 'nullable|file|mimes:jpg,jepg,png|max:2500'
        ]);
        if ($request->file('file') == "") {

            $detailSoalEssay_ujian = DetailSoalEssay_ujian::findOrFail($detailSoalEssay_ujian->id);
            $detailSoalEssay_ujian->update([
                'kd_mtk'        => $request->input('kd_mtk'),
                'jenis'         => $request->input('jenis'),
                'soal'          => $request->input('soal'),
                'kunci'         => $request->input('kunci'),
                'status'        => $request->input('status'),
                // 'id_user'       => $request->input('id_user')
            ]);
        } else {

            //remove old image
            Storage::disk('local')->delete('public/soalessay/' . $detailSoalEssay_ujian->file);

            //upload new image
            $image = $request->file('file');
            $image->storeAs('public/soalessay', $image->hashName());

            $detailSoalEssay_ujian = DetailSoalEssay_ujian::findOrFail($detailSoalEssay_ujian->id);
            $detailSoalEssay_ujian->update([
                'kd_mtk'         => $request->input('kd_mtk'),
                'jenis'         => $request->input('jenis'),
                'soal'          => $request->input('soal'),
                'kunci'         => $request->input('kunci'),
                'status'        => $request->input('status'),
                // 'id_user'       => $request->input('id_user'),
                'file'          => $image->hashName()
            ]);
        }
        $gabung = Crypt::encryptString($request->input('kd_mtk') . ',' .$request->input('jenis'));       

        if ($detailSoalEssay_ujian) {
            //redirect dengan pesan sukses
            return redirect('/baak/uts-soal-show/' . $gabung)->with('status', 'Data Ditambah');
        } else {
            return redirect('/baak/uts-soal-show/' . $gabung)->with(['error' => 'Data Gagal Disimpan!']);
        }
    }
     
    public function singmtkuji()
    {
        $singmtkuji = DB::select('call uts_insert_jadwal');
        return redirect()->back()->with(['success' => 'success di singkron']);
    }


    public function destroy1($id)
    {
        //
    }


    public function destroy($id)
    {
        
        try {
            // Decrypt the ID
            $decryptedId = Crypt::decryptString($id);
            // dd($decryptedId);
            // Split the decrypted string into an array
            list($kd_mtk, $paket) = explode(',', $decryptedId);

            // Find the record by kd_mtk and paket and delete it
            $record = ujian_aprov::where('kd_mtk', $kd_mtk)->where('paket', $paket)->first();

            if ($record) {
                $record->delete();
                return redirect()->back()->with('success', 'Record deleted successfully');
            } else {
                return redirect()->back()->with('error', 'Record not found');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Invalid ID or decryption error');
        }
    }

}
