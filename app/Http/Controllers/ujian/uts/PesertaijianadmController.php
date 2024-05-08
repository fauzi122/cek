<?php

namespace App\Http\Controllers\ujian\uts;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Imports\PesertaujianImport;
use App\Models\Distribusisoal_ujian_tmp;
use App\Models\Distribusisoal_ujian;
use App\Models\Paket_ujian;

class PesertaijianadmController extends Controller
{
    public function __construct()
    {
       $this->middleware(['permission:peserta_administrasi_ujian']);
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
        return view('admin.ujian.uts.adm.peserta.index', compact('encryptedExamTypes', 'paketUjian'));
       
    }

        public function uts($id)
        {
            $pecah = explode(',', Crypt::decryptString($id));
    
    
            $peserta = DB::table('ujian_distribusisoals')
                ->when(request()->q, function ($query) {
                    return $query->where('nim', 'like', '%' . request()->q . '%');
                })
                ->where('paket', $pecah[0])
                ->paginate(10);

            $kampus = DB::table('kampus')->get();

        return view('admin.ujian.uts.adm.peserta.uts', compact('peserta','kampus','pecah'));
    }

    public function show_cabang($kd_cabang)
    {
        $kelas = DB::table('ujian_distribusisoals')
                   ->whereRaw("SUBSTRING_INDEX(id_kelas, '.', -1) = ?", [$kd_cabang])
                   ->groupby('id_kelas')->get();
        $cabang= DB::table('kampus')->where('kd_cabang',$kd_cabang)->first();

        return view('admin.ujian.uts.adm.peserta.show_cabang', compact('kelas','cabang'));
    }

    public function show_kelas($id_kelas)
    {
        $kelas_all = DB::table('ujian_distribusisoals')
                   ->where('id_kelas',$id_kelas)->get();

        $kelas= DB::table('ujian_distribusisoals')->where('id_kelas',$id_kelas)->first();

        return view('admin.ujian.uts.adm.peserta.show_kls', compact('kelas','kelas_all'));
    }

    public function cari(Request $request)
    {
        $query = DB::table('ujian_distribusisoals') ->join('mtk', 'ujian_distribusisoals.kd_mtk', '=', 'mtk.kd_mtk')
        ->select('ujian_distribusisoals.*', 'mtk.nm_mtk');

        // Pencarian berdasarkan NIM
        if ($request->has('nim') && $request->nim != '') {
            $query->where('nim', $request->nim);
        }

        // Pencarian berdasarkan id_kelas
        if ($request->has('id_kelas') && $request->id_kelas != '') {
            $query->where('id_kelas', $request->id_kelas);
        }

        // Pencarian berdasarkan no_kel_ujn
        if ($request->has('no_kel_ujn') && $request->no_kel_ujn != '') {
            $query->where('no_kel_ujn', $request->no_kel_ujn);
        }

        // Pencarian berdasarkan no_kel_ujn
        if ($request->has('paket') && $request->paket != '') {
            $query->where('paket', $request->paket);
        }

        $hasil = $query->get();

        // Kembalikan view dengan hasil pencarian
        return view('admin.ujian.uts.adm.peserta.cari', compact('hasil'));
    }


    


    
}
