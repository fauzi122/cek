<?php

namespace App\Http\Controllers\ujian\uts;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Paket_ujian;
use App\Imports\PesertaujianImport;
use App\Models\Distribusisoal_ujian_tmp;

class PesertaujianController extends Controller
{
    public function __construct()
    {
    $this->middleware(['permission:peserta_ujian|peserta_ujian.edit|peserta_ujian.add|peserta_ujian.singkron']);
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
        return view('admin.ujian.uts.baak.peserta.index', compact('encryptedExamTypes', 'paketUjian'));
       
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

        $peserta_upload = Distribusisoal_ujian_tmp::where('paket', $pecah[0])->get();

        return view('admin.ujian.uts.baak.peserta.uts', compact('peserta', 'peserta_upload'));
    }
    

    // public function uas()
    // {

    //     $peserta = DB::table('ujian_distribusisoals')
    //         ->when(request()->q, function ($peserta) {
    //             $peserta = $peserta->where('nim', 'like', '%' . request()->q . '%');
    //         })->where('paket', 'UAS')->paginate(10);

    //     // dd($peserta);
    //     $peserta_upload = Distribusisoal_ujian_tmp::where('paket', 'UAS')->get();

    //     return view('admin.ujian.uts.baak.peserta.uas', compact('peserta', 'peserta_upload'));
    // }

    public function storeData_Pesertaujian(Request $request)
    {
        //VALIDASI
        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);

        if ($request->hasFile('file')) {

            $file = $request->file('file'); //GET FILE

            Excel::import(new PesertaujianImport, $file); //IMPORT FILE 
            return redirect()->back()->with(['success' => 'Upload Peserta Ujian Berhasil']);
        }
        return redirect()->back()->with(['error' => 'Please choose file before']);
    }


    // public function singpesertauji()
    // {
    //     $singpesertauji = DB::select('call uts_insert_peserta_ujian');
    //     return redirect()->back()->with(['success' => 'peserta ujian success di singkron']);
    // }
    // public function singpesertauji_t()
    // {
    //     $singpesertauji_t = DB::select('call insert_peserta_ujian');
    //     return redirect()->back()->with(['success' => 'peserta ujian success di singkron']);
    // }

    public function destroy($id)
    {
        Distribusisoal_ujian_tmp::find($id)->delete();
        return redirect('/peserta-ujian')->with('success', 'Data Berhasil Dihapus');
    }

    public function destroy_all()
    {
        Distribusisoal_ujian_tmp::truncate();
        return redirect('/peserta-ujian')->with('success', 'Data Berhasil dikosongkan');
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

        $hasil = $query->get();

        // Kembalikan view dengan hasil pencarian
        return view('admin.ujian.uts.baak.peserta.cari', compact('hasil'));
    }
}
