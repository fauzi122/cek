<?php

namespace App\Http\Controllers\ujian\uts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\Ujian_berita_acara;
use App\Models\Soal_ujian;
use App\Models\Absen_ujian;
use App\Models\Paket_ujian;
use App\Models\Mtk_ujian;
use Carbon\Carbon;

class JadwalujianController extends Controller
{
    public function __construct()
    {
        if (!$this->middleware('auth:sanctum')) {
            return redirect('/login');
        }
    }
    public function index()
    {
        $examTypes = Paket_ujian::distinct()->pluck('paket');

        $encryptedExamTypes = $examTypes->mapWithKeys(function ($item) {
            return [$item => Crypt::encryptString($item)];
        });
    
        $paketUjian = Paket_ujian::all();
        return view('admin.ujian.uts.baak.jadwal.index', compact('encryptedExamTypes', 'paketUjian'));
       
    }

    public function jadwal($id)
    {
        
        $pecah = explode(',', Crypt::decryptString($id));

        $jadwal = Soal_ujian::where([
            'paket'    => $pecah[0]
            ])->get();

        $result = DB::table('uts_soals')
                ->join('ujian_berita_acaras', function($join) {
                    $join->on('uts_soals.kel_ujian', '=', 'ujian_berita_acaras.kel_ujian')
                    ->on('uts_soals.kd_mtk', '=', 'ujian_berita_acaras.kd_mtk');
                    })
                ->select('ujian_berita_acaras.*', 'uts_soals.kd_dosen', 'uts_soals.kel_ujian', 'uts_soals.kd_mtk')
                ->where(['uts_soals.paket'    => $pecah[0]])->get();
    
        // Membuat array untuk pencocokan data
        $resultArray = $result->mapWithKeys(function ($item) {
            return [$item->kd_dosen . '_' . $item->kel_ujian . '_' . $item->kd_mtk => $item];
        })->toArray();
    
        return view('admin.ujian.uts.baak.jadwal.jadwal', compact('jadwal', 'resultArray'));
    }

    // public function jadwal($id, Request $request)
    // {
    //     $pecah = explode(',', Crypt::decryptString($id));
    //     $paket = $pecah[0];
    
    //     if ($request->ajax()) {
    //         $query = DB::table('uts_soals')
    //             ->join('ujian_berita_acaras', function($join) {
    //                 $join->on('uts_soals.kel_ujian', '=', 'ujian_berita_acaras.kel_ujian')
    //                      ->on('uts_soals.kd_mtk', '=', 'ujian_berita_acaras.kd_mtk');
    //             })
    //             ->select('ujian_berita_acaras.*', 'uts_soals.kd_dosen', 'uts_soals.kel_ujian', 'uts_soals.kd_mtk')
    //             ->where('uts_soals.paket', $paket);
    
    //         return datatables()->of($query)
    //             ->addColumn('action', function ($item) {
    //                 return '<button class="btn btn-primary">Edit</button>';
    //             })
    //             ->rawColumns(['action'])
    //             ->make(true);
    //     }
    //     $encryptedId = $id; 
    //     // Fallback for non-AJAX request
    //     $jadwal = Soal_ujian::where('paket', $paket)->get();

    //     // dd($jadwal);
    //     return view('admin.ujian.uts.baak.jadwal.jadwal', compact('jadwal','encryptedId'));
    // }
    


    public function search(Request $request)
    {
        $query = Soal_ujian::query();

        if ($request->filled('kd_lokal')) {
            $query->where('kd_lokal', $request->kd_lokal);
        }

        if ($request->filled('kel_ujian')) {
            $query->where('kel_ujian', $request->kel_ujian);
        }

        if ($request->filled('tgl_ujian')) {
            $query->whereDate('tgl_ujian', $request->tgl_ujian);
        }

        $jadwal = $query->get();

        return view('admin.ujian.uts.baak.jadwal.cari', compact('jadwal'));
    }
    
    public function show_uts($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        $soal = Soal_ujian::where([
            'kd_dosen'    => $pecah[0],
            'kd_mtk'      => $pecah[1],
            'kel_ujian'   => $pecah[2],
            'paket'       => $pecah[3]        
            ])->first();
        
        $beritaAcara = Ujian_berita_acara::where([
            'kd_dosen' => $pecah[0],
            'kd_mtk' => $pecah[1],
            'kel_ujian'   => $pecah[2],
            'paket'       => $pecah[3] 
            ])->first();

            // dd($beritaAcara);

            $mhsujian = Absen_ujian::where([    
                'kd_mtk'        => $pecah[1],
                'no_kel_ujn'    => $pecah[2],
                'paket'         => $pecah[3]
               
                ])->get(); 

        return view('admin.ujian.uts.baak.jadwal.show',compact('soal','id','beritaAcara','mhsujian'));
    }

    public function edit($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        $jadwal = Soal_ujian::where([
            'kd_dosen'    => $pecah[0],
            'kd_mtk'      => $pecah[1],
            'kel_ujian'   => $pecah[2],
            'paket'       => $pecah[3]        
            ])->first();
        
        return view('admin.ujian.uts.baak.jadwal.edit',compact('jadwal'));
    }

    public function update(Request $request, $id)
    {
        try {
            $keys = explode(',', Crypt::decryptString($id));
    
            $validatedData = $request->validate([
                'tgl_ujian'     => 'required|date',
                'hari_t'        => 'required|string|max:255',
                'no_ruang'      => 'required|string|max:255',
                'mulai'         => 'required|date_format:H:i',
                'selesai'       => 'required|date_format:H:i',
                'nm_kampus'     => 'required|string|max:255'
            ]);

            $encryptedPaket = Crypt::encryptString($request->input('paket'));

            $soalUjian = Soal_ujian::where([
                'kd_dosen'  => $keys[0],
                'kd_mtk'    => $keys[1],
                'kel_ujian' => $keys[2],
                'paket'     => $keys[3]
            ])->firstOrFail();
          
            $soalUjian->fill($validatedData);
            if ($soalUjian->isDirty()) { // Check if there are any changes
                $soalUjian->save(); // This will trigger the model events
                $successMessage = 'Jadwal ujian untuk kode dosen ' . $keys[0] . 
                                  ' dan kelompok ujian ' . $keys[2] . 
                                  ' berhasil diperbarui';
            } else {
                $successMessage = 'Tidak ada perubahan yang dilakukan pada data';
            }
    
            return redirect('/baak/jadwal-ujian/'. $encryptedPaket)->with('success', $successMessage);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui jadwal ujian: ' . $e->getMessage());
        }
    }
     
    public function updateStatus(Request $request)
    {
        $request->validate([
            'verifikasi' => 'required',
            'id'        => 'required' 
        ]);
        $id = $request->id;
        $ujian = Ujian_berita_acara::find($id);
        if (!$ujian) {
            return redirect()->back()->with('error', 'Data ujian tidak ditemukan.');
        }
    
        $ujian->verifikasi           = $request->verifikasi;
        $ujian->petugas             = Auth::user()->kode; 
        $ujian->waktu_verifikasi    = Carbon::now(); 
        $ujian->save(); 
    
        // Redirect back with a success message
        return redirect()->back()->with('status', 'Status berhasil diperbarui.');
    }
    
    
}
