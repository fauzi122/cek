<?php

namespace App\Http\Controllers\ujian\uts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Soal_ujian;
use App\Models\Ganti_pengawas_ujian;

class PenggantiMengawasController extends Controller
{
    public function __construct()
    {
       $this->middleware(['permission:dosen_pengganti_mengawas']);
       if(!$this->middleware('auth:sanctum')){
        return redirect('/login');
    }
    }
    public function index()
    {
        $jadwal = Ganti_pengawas_ujian::get();

    
        return view('admin.ujian.uts.baak.pengganti.index', compact('jadwal',));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'kd_dosen_asli'       => 'required',
            'kd_dosen_pengganti'  => 'required',
            'kel_ujian'           => 'required',
            'kd_mtk'              => 'required',
            'paket'               => 'required',
            'ket'                 => 'required',
        ]);
    
        // Data untuk menemukan atau membuat record
        $criteria = [
            'kel_ujian' => $request->input('kel_ujian'),
            'kd_mtk'    => $request->input('kd_mtk'),
            'paket'     => $request->input('paket'),
        ];
    
        // Data yang akan diperbarui atau ditambahkan
        $data = [
            'kd_dosen_asli'       => $request->input('kd_dosen_asli'),
            'kd_dosen_pengganti'  => $request->input('kd_dosen_pengganti'),
            'nip_dosen_pengganti' => $request->input('nip_dosen_pengganti'),
            'petugas_input'       => Auth::user()->kode,
            'petugas_update'      => Auth::user()->kode,
            'ket'                 => $request->input('ket'),
        ];
    
        // Gunakan updateOrCreate untuk mencari atau membuat entri baru
        $jadwal = Ganti_pengawas_ujian::updateOrCreate($criteria, $data);
    
        // Periksa apakah model berhasil dibuat atau diubah
        if ($jadwal->wasRecentlyCreated || $jadwal->wasChanged()) {
            // Jika berhasil, perbarui Soal_ujian
            $updateSoalUjian = Soal_ujian::where($criteria)->update([
                'kd_dosen' => $request->input('kd_dosen_pengganti'),
                'nip'      => $request->input('nip_dosen_pengganti'),
                'petugas_edit_pengawas' => Auth::user()->kode  // Menambahkan petugas edit pengawas
            ]);
    
            if ($updateSoalUjian) {
                return redirect('/pengganti-mengawas')->with('success', 'Data Berhasil di Update dan Soal Ujian Diperbarui');
            } else {
                return redirect('/pengganti-mengawas')->with('error', 'Data Berhasil di Update tetapi Gagal Memperbarui Soal Ujian');
            }
        } else {
            // Jika tidak ada perubahan pada data Ganti_pengawas_ujian, kembalikan pesan error
            return redirect('/pengganti-mengawas')->with('error', 'Tidak ada perubahan pada data, Soal Ujian tidak diperbarui');
        }
    }
    
    
    public function edit($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        $jadwal = Soal_ujian::where([
            'kd_dosen'    => $pecah[0],
            'kd_mtk'      => $pecah[1],
            'kel_ujian'   => $pecah[2],
            'paket'       => $pecah[3],       
            'nm_kampus'   => $pecah[4]        
            ])->first();

        $dosens = DB::table('jadwal')->select('jadwal.kd_dosen','jadwal.nm_dosen','jadwal.nip')
        ->groupby('kd_dosen') ->get();
        
        return view('admin.ujian.uts.baak.pengganti.edit',compact('jadwal','dosens'));
    }
    
}
