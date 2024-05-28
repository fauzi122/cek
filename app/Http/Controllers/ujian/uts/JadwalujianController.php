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
    //    $this->middleware(['permission:jadwal_ujian']);
       if(!$this->middleware('auth:sanctum')){
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
    // dd($pecah);
        $jadwal = Soal_ujian::where([
                    'paket' => $pecah[0]
                ])
                // ->where('no_ruang', 'not like', 'E%')
                ->get();
    
        // Query untuk mengambil data dari tabel uts_soals dan ujian_berita_acaras
        $result = DB::table('uts_soals')
                    ->join('ujian_berita_acaras', function($join) {
                        $join->on('uts_soals.kel_ujian', '=', 'ujian_berita_acaras.kel_ujian')
                             ->on('uts_soals.kd_mtk', '=', 'ujian_berita_acaras.kd_mtk');
                    })
                    ->select('ujian_berita_acaras.*', 'uts_soals.kd_dosen', 'uts_soals.kel_ujian', 'uts_soals.kd_mtk', 'uts_soals.paket',
                     'ujian_berita_acaras.verifikasi','ujian_berita_acaras.ot')
                    ->where(['uts_soals.paket' => $pecah[0]])
                    ->where(['ujian_berita_acaras.paket' => $pecah[0]])
                    ->get();
    
        // Membuat array untuk pencocokan data dengan menyertakan 'paket' dalam kunci
        $resultArray = $result->mapWithKeys(function ($item) {
            return [$item->kd_dosen . '_' . $item->kel_ujian . '_' . $item->kd_mtk . '_' . $item->paket => $item];
        })->toArray();

        return view('admin.ujian.uts.baak.jadwal.jadwal', compact('jadwal', 'resultArray'));
    }


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
    if (Auth::user()->utype == 'ADM') {
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
                'kd_mtk'    => $pecah[1],
                'no_kel_ujn'=> $pecah[2],
                'paket'     => $pecah[3]
            ])->get()->map(function ($item) {
                $item->isInHasilUjian = DB::table('ujian_hasilujians')
                    ->where('nim', $item->nim)
                    ->where('kd_mtk', $item->kd_mtk)
                    ->where('kel_ujian', $item->no_kel_ujn)
                    ->where('paket', $item->paket)
                    ->exists();
                return $item;
            });

        return view('admin.ujian.uts.baak.jadwal.show',compact('soal','id','beritaAcara','mhsujian'));
    } else {
        return redirect('/dashboard');
    }
    }

    public function show_log($id)
    {
        try {
            // Dekripsi dan pecah string $id menjadi array
            $pecah = explode(',', Crypt::decryptString($id));

            // Mengambil data berita acara ujian
            $log_mulai = DB::table('ujian_hasilujians')->where([
                'nim'       => $pecah[0],
                'kel_ujian' => $pecah[1],
                'kd_mtk'    => $pecah[2],
                'paket'     => $pecah[3]
            ])->first();

            // PG
            $pg = DB::table('ujian_jawabs')->where([
                'nim'       => $pecah[0],
                'kel_ujian' => $pecah[1],
                'kd_mtk'    => $pecah[2],
                'paket'     => $pecah[3]
            ])->get();
            // dd($pg);

            // essay
            $essay = DB::table('ujian_jawab_esays')->where([
                'nim'       => $pecah[0],
                'kel_ujian' => $pecah[1],
                'kd_mtk'    => $pecah[2],
                'paket'     => $pecah[3]
            ])
                ->get();

            // Mengirim data ke view
            return view('admin.ujian.uts.baak.jadwal.log', compact('log_mulai', 'pg', 'essay'));
        } catch (\Exception $e) {
            // Tangani kesalahan yang mungkin terjadi saat proses dekripsi atau query
            return back()->with('error', 'Terjadi kesalahan saat memproses data: ' . $e->getMessage());
        }
    }

    public function updateUtsSoal(Request $request)
    {
        // Ambil record lama terlebih dahulu
        $oldData = DB::table('uts_soals')
            ->where('kd_dosen', $request->kd_dosen)
            ->where('nip', $request->nip)
            ->where('kel_ujian', $request->kel_ujian)
            ->where('kd_mtk', $request->kd_mtk)
            ->where('paket', $request->paket)
            ->first();
    
        if (!$oldData) {
            return redirect()->back()->with('error', 'Data ujian tidak ditemukan.');
        }
    
        // Data yang akan diupdate
        $newData = [
            'tgl_ujian' => $request->tgl_ujian,
            'jam_t'     => $request->jam_t,
            'hari_t'    => $request->hari_t,
            'no_ruang'  => $request->no_ruang,
            'mulai'     => $request->mulai,
            'selesai'   => $request->selesai,
            'petugas_edit' => Auth::user()->kode
        ];
    
        // Update record
        DB::table('uts_soals')
            ->where('kd_dosen', $request->kd_dosen)
            ->where('nip', $request->nip)
            ->where('kel_ujian', $request->kel_ujian)
            ->where('kd_mtk', $request->kd_mtk)
            ->where('paket', $request->paket)
            ->update($newData);
    
        // Bandingkan data lama dan baru untuk mencari perubahan
        $changes = array_diff_assoc($newData, (array) $oldData);
        $message = count($changes) > 0 ? 'Data ujian berhasil diperbarui. Perubahan: ' . json_encode($changes) : 'Tidak ada data yang diubah.';
    
        return redirect()->back()->with('success', $message);
    }
    

    public function edit($id)
    {
        if (Auth::user()->utype == 'ADM') {
        $pecah = explode(',', Crypt::decryptString($id));
        $jadwal = Soal_ujian::where([
            'kd_dosen'    => $pecah[0],
            'kd_mtk'      => $pecah[1],
            'kel_ujian'   => $pecah[2],
            'paket'       => $pecah[3],       
            // 'nm_kampus'   => $pecah[4]        
            ])->first();
        
        return view('admin.ujian.uts.baak.jadwal.edit',compact('jadwal'));
    } else {
        return redirect('/dashboard');
    }
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'verifikasi' => 'required',
            'id'         => 'required' 
        ]);
        $id = $request->id;
        $ujian = Ujian_berita_acara::find($id);
        if (!$ujian) {
            return redirect()->back()->with('error', 'Data ujian tidak ditemukan.');
        }
    
        $ujian->verifikasi           = $request->verifikasi;
        $ujian->ot                   = $request->ot;
        $ujian->petugas              = Auth::user()->kode; 
        $ujian->waktu_verifikasi     = Carbon::now(); 
        $ujian->save(); 
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }
    
    
}
