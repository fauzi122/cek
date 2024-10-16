<?php

namespace App\Http\Controllers\ujian\uts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Perakit_soal;
use App\Models\Paket_ujian;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UjianPerakitImport;

class PerakitSoalController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:perakit_ujian|add_perakit_ujian|destroy_perakit_ujian']);
        if (!$this->middleware('auth:sanctum')) {
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
        return view('admin.ujian.uts.baak.perakit_soal.utama', compact('encryptedExamTypes', 'paketUjian'));
       
    }

    public function index($jenis)
    {
       
        $pecah = explode(',', Crypt::decryptString($jenis)); // Decrypt the jenis and split
        
        $panitia = DB::table('perakit_soals')
                    ->select(
                        'users.name',
                        'users.id',
                        'users.username',
                        'perakit_soals.*',
                        DB::raw("CASE 
                                    WHEN mtk_ujians.jenis_mtk = 'PG ONLINE' THEN ujian_detailsoals.id_user
                                    WHEN mtk_ujians.jenis_mtk = 'ESSAY ONLINE' THEN ujian_detail_soal_esays.id_user
                                 END AS id_user"),
                        DB::raw("CASE 
                                    WHEN mtk_ujians.jenis_mtk = 'PG ONLINE' THEN ujian_detailsoals.kd_mtk
                                    WHEN mtk_ujians.jenis_mtk = 'ESSAY ONLINE' THEN ujian_detail_soal_esays.kd_mtk
                                 END AS kd_mtk"),
                        'mtk_ujians.jenis_mtk'
                    )
                    ->join('users', 'perakit_soals.kd_dosen', '=', 'users.kode')
                    ->join('mtk_ujians', 'perakit_soals.kd_mtk', '=', 'mtk_ujians.kd_mtk')
                    ->leftJoin('ujian_detailsoals', function ($join) use ($pecah) {
                        $join->on('perakit_soals.kd_mtk', '=', 'ujian_detailsoals.kd_mtk')
                             ->where('perakit_soals.paket', '=', $pecah[0])
                             ->where('ujian_detailsoals.jenis', '=', $pecah[0]);
                    })
                    ->leftJoin('ujian_detail_soal_esays', function ($join) use ($pecah) {
                        $join->on('perakit_soals.kd_mtk', '=', 'ujian_detail_soal_esays.kd_mtk')
                             ->where('perakit_soals.paket', '=', $pecah[0])
                             ->where('ujian_detail_soal_esays.jenis', '=', $pecah[0]);
                    })
                    ->where('perakit_soals.paket', '=', $pecah[0])
                    ->where('mtk_ujians.paket', '=', $pecah[0])
                    ->where(function($query) use ($pecah) {
                        $query->where(function($q) use ($pecah) {
                            $q->where('mtk_ujians.jenis_mtk', '=', 'PG ONLINE')
                              ->where('ujian_detailsoals.jenis', '=', $pecah[0]);
                        })
                        ->orWhere(function($q) use ($pecah) {
                            $q->where('mtk_ujians.jenis_mtk', '=', 'ESSAY ONLINE')
                              ->where('ujian_detail_soal_esays.jenis', '=', $pecah[0]);
                        });
                    })
                    ->groupBy('perakit_soals.kd_mtk')
                    ->get();
        // dd($panitia);
        return view('admin.ujian.uts.baak.perakit_soal.index', compact('panitia','pecah'));
    }
    
    
    public function update(Request $request, $id)
    {
        // dd($request->jenis);
        // Validasi data yang diterima
        $request->validate([
            'perakit_new' => 'required',
            'kd_mtk' => 'required',
            'jenis' => 'required'
        ]);

        DB::table('ujian_detailsoals')
        ->where('kd_mtk', $request->kd_mtk)
        ->where('jenis', $request->jenis) // Sesuaikan dengan kolom yang tepat
        ->update(['id_user' => $request->perakit_new]);

        // Redirect setelah sukses
        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
    }


    public function create()
    {
        $user = DB::table('karyawanbs1')
        ->whereIn('dept', ['BSI2', 'BSI3'])
        ->where('status_kry', '1')
        ->get();
        $kampus = DB::table('kampus')->get();

        return view('admin.ujian.uts.baak.perakit_soal.create',compact('user','kampus'));
    }


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

    public function storeData_Perakit(Request $request)
    {
        // Validasi
        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);

        if ($request->hasFile('file')) {
            $set = [
                'paket'    => $request->input('paket'),
                'status'     => 1,
                'petugas'   => Auth::user()->kode,
            ];
            $file = $request->file('file'); // Mengambil file

            $import = new UjianPerakitImport($set); // Membuat instance import dengan konfigurasi
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

    public function edit($id)
    {
        //
    }


    public function destroy($id)
    {
        Perakit_soal::find($id)->delete();
        return redirect()->back()->with('status', 'Data Berhasil Dihapus');
    }
}
