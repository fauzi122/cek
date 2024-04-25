<?php

namespace App\Http\Controllers\baak;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pertemuan;
use App\Models\PertemuanBaak;
use App\Models\PertemuanSisfo;
use Illuminate\Support\Facades\DB;
use App\Imports\PertemuanImport;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;


class PertemuanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:temu_baak.index |temu_baak.upload|temu_baak.singkron|temu_baak.delete']);
        if (!$this->middleware('auth:sanctum')) {
            return redirect('/login');
        }
    }
    public function index()
    {
        $pertemuan = PertemuanBaak::first();

        $temu = DB::table('pertemuan')
            ->when(request()->q, function ($temu) {
                $temu = $temu->where('kd_dosen', 'like', '%' . request()->q . '%');
            })->paginate(15);

        return view('baak.pertemuan.index', compact('pertemuan', 'temu'));
    }
    public function datajson()
    {
        return Datatables::of(Pertemuan::get())->make(true);
    }

    public function storeData(Request $request)
    {
        //VALIDASI
        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file'); //GET FILE
            Excel::import(new PertemuanImport, $file); //IMPORT FILE 
            return redirect()->back()->with(['success' => 'Upload success']);
        }
        return redirect()->back()->with(['error' => 'Please choose file before']);
    }
    public function tpertemuan()
    {
        $temu = DB::select('call t_pertemuan');
        return redirect()->back()->with(['success' => 'success terhapus']);
    }
    public function singkrontemu()
    {
        $response = Http::withOptions([
            'verify' => false, // Menonaktifkan verifikasi SSL
        ])->get('https://elearning.bsi.ac.id/hapus-jadwal');
        $temu = DB::select('call insert_jadwal');
        $temu1 = DB::select('call jadwal_agama');
        return redirect()->back()->with(['success' => 'success di singkron']);
    }

    public function inputPertemuan(Request $request)
    {
        Pertemuan::truncate();
        PertemuanBaak::truncate();
        PertemuanBaak::create(['smt' => $request->no_j_klh]);
        $req = PertemuanSisfo::where('no_j_klh', $request->no_j_klh)
            ->paginate(
                $perPage = 600,
                $columns = ['*'],
                $pageName = 'azis',
                $currentPage = 1
            );
        PertemuanBaak::where('id', 0)
            ->update(['total' => $req->total(), 'lastPage' => $req->lastPage()]);
        // dd($req);
        return redirect('/pertemuan');
    }

    public function send($id)
    {
        if (substr(Crypt::decryptString($id), 1) != 0) {
            for ($i = Crypt::decryptString($id) - substr(Crypt::decryptString($id), 1) + 1; $i <= Crypt::decryptString($id); $i++) {
                echo "<script>window.open('/proses-jadwal/" . $i . "', '_blank')</script>";
            }
        } else {
            for ($i = Crypt::decryptString($id) - 9; $i <= Crypt::decryptString($id); $i++) {
                echo "<script>window.open('/proses-jadwal/" . $i . "', '_blank')</script>";
            }
        }
        echo "<a href='" . url("/pertemuan") . "' type='button' class='btn btn-info'>Kembali Kehalaman Awal</a>";
    }
    public function prosesPertemuan($id)
    {
        $select = PertemuanBaak::first();
        $flight = PertemuanSisfo::where('no_j_klh', $select->smt)
            ->paginate(
                $perPage = 600,
                $columns = ['*'],
                $pageName = 'azis',
                $currentPage = $id
            );
        $result = array();
        foreach ($flight as $mhs) {
            $result[] = array(
                'no_j_klh' => $mhs->no_j_klh,
                'kd_mtk' => $mhs->kd_mtk,
                'jml_pertemuan' => $mhs->jml_pertemuan,
                'kd_dosen' => $mhs->kd_dosen,
                'jam_t' => $mhs->jam_t,
                'hari_t' => $mhs->hari_t,
                'no_ruang' => $mhs->no_ruang,
                'kd_lokal' => $mhs->kd_lokal,
                'smt_ajar' => $mhs->smt_ajar,
                'kel_praktek' => $mhs->kel_praktek,
                'ket' => $mhs->ket,
                'f' => $mhs->f,
                'sksajar' => $mhs->sksajar,
                'nohari' => $mhs->nohari,
                'status_ajar' => $mhs->status_ajar,
                'last_update' => $mhs->last_update,
                'cek' => $mhs->cek,
                'konfirmasi' => $mhs->konfirmasi,
                'calondosen' => $mhs->calondosen,
                'wawancara' => $mhs->wawancara,
                'kd_dosen2' => $mhs->kd_dosen2,
                'nip_aslab' => $mhs->nip_aslab,
                'nip_aslab2' => $mhs->nip_aslab2,
                'kd_gabung' => $mhs->kd_gabung,
                'u_trans' => $mhs->u_trans
            );
        }
        $chunk = collect($result)->chunk(500);
        // dd($chunk);
        foreach ($chunk as $arr) {
            Pertemuan::insert($arr->toArray());
        }
        return view('api.penilaian');
    }

    public function cariDataRekapp(Request $request)
    {
        $kd_dosen = $request->input('kd_dosen');
        $kd_mtk = $request->input('kd_mtk');

        $rekapData = Pertemuan::query();

        if ($kd_dosen) {
            $rekapData->where('kd_dosen', $kd_dosen);
        }

        if ($kd_mtk) {
            $rekapData->where('kd_mtk', $kd_mtk);
        }

        $rekapData = $rekapData->get();
        return view('administrasi.rekap.caridata_praktek', compact('rekapData', 'kd_dosen', 'kd_mtk'));
    }
}
