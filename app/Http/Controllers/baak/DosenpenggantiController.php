<?php

namespace App\Http\Controllers\baak;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Jadwal;
use App\Models\User;
use App\Models\Kuliah_pengganti;
use App\Models\Dosen_pengganti;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Crypt;

class DosenpenggantiController extends Controller
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
    public function index(Request $request)
    {

        $jadwal = DB::table('jadwal')
            ->groupBy('kd_gabung', 'kd_mtk', 'no_ruang', 'jam_t', 'hari_t')
            ->get();
        $data = [];
        if ($request->has('q')) {
            $search = $request->q;

            $data = DB::table('users')
                ->select("username", "kode")
                ->where('utype', '=', "ADM")
                ->where('kode', 'LIKE', "%$search%")
                ->get();
            return response()->json($data);
        }
        if ($request->ajax()) {
            return DataTables::of($jadwal)
                ->addIndexColumn()
                ->addColumn('kelas', function ($jadwal) {
                    if ($jadwal->kd_gabung <> null) {
                        $aksi = $jadwal->kd_gabung;
                    } elseif ($jadwal->kel_praktek <> null) {
                        $aksi = $jadwal->kel_praktek;
                    } else {
                        $aksi = $jadwal->kd_lokal;
                    }
                    return $aksi;
                })
                ->addColumn('nip', function ($jadwal) {
                    if ($jadwal->kd_gabung <> null) {
                        $id = Crypt::encryptString($jadwal->kd_mtk . ',' . $jadwal->kd_dosen . ',' . $jadwal->kd_gabung . ',' . $jadwal->hari_t . ',' . $jadwal->jam_t . ',' . $jadwal->no_ruang . ',gabung');
                    } elseif ($jadwal->kel_praktek <> null) {
                        $id = Crypt::encryptString($jadwal->kd_mtk . ',' . $jadwal->kd_dosen . ',' . $jadwal->kel_praktek . ',' . $jadwal->hari_t . ',' . $jadwal->jam_t . ',' . $jadwal->no_ruang . ',praktek');
                    } else {
                        $id = Crypt::encryptString($jadwal->kd_mtk . ',' . $jadwal->kd_dosen . ',' . $jadwal->kd_lokal . ',' . $jadwal->hari_t . ',' . $jadwal->jam_t . ',' . $jadwal->no_ruang . ',teori');
                    }
                    return '
                <a class="btn btn-primary btn-lg" href="' . url('/dosen-pengganti/' . $id) . '">' . $jadwal->nip . '</a>
                ';
                })
                ->addColumn('kd_dosen', function ($jadwal) {
                    return '(' . $jadwal->kd_dosen . ')
                ';
                })
                ->rawColumns(['kelas', 'nip', 'kd_dosen'])
                ->toJson();
        }
        return view('baak.dosenpengganti.jadwal');
    }
    public function dosenPengganti($id)
    {
        // 0 => "0002"
        // 1 => "ITH"
        // 2 => "64.4A.25"
        // 3 => "Kamis"
        // 4 => "10:00-12:30"
        // 5 => "EN1-M1"
        // 6 => "teori"
        $exp = explode(",", Crypt::decryptString($id));
        if ($exp[6] == 'teori') {
            $jadwal = Jadwal::where(['kd_mtk' => $exp[0], 'kd_dosen' => $exp[1], 'kd_lokal' => $exp[2], 'hari_t' => $exp[3], 'jam_t' => $exp[4], 'no_ruang' => $exp[5]])->first();
        } elseif ($exp[6] == 'praktek') {
            $jadwal = Jadwal::where(['kd_mtk' => $exp[0], 'kd_dosen' => $exp[1], 'kel_praktek' => $exp[2], 'hari_t' => $exp[3], 'jam_t' => $exp[4], 'no_ruang' => $exp[5]])->first();
        } else {
            $jadwal = Jadwal::where(['kd_mtk' => $exp[0], 'kd_dosen' => $exp[1], 'kd_gabung' => $exp[2], 'hari_t' => $exp[3], 'jam_t' => $exp[4], 'no_ruang' => $exp[5]])->first();
        }

        $dosen = Jadwal::groupBy('kd_dosen')->get();
        // dd($dosen);

        return view('baak.dosenpengganti.form_dosenPengganti', compact('jadwal', 'id', 'dosen'));
    }

    public function insertDosenpengganti(Request $request)
    {
        $Dp = Dosen_pengganti::where(['kd_dosen' => $request->kd_dosen, 'kd_mtk' => $request->kd_mtk, 'kd_lokal' => $request->kelas, 'hari_t' => $request->hari_t, 'jam_t' => $request->jam_t, 'no_ruang' => $request->ruang, 'kd_dp' => $request->dosen_pengganti, 'tgl_ganti' => $request->tgl_pengganti])->first();
        if (!$Dp) {
            $Dp = new Dosen_pengganti;
            $Dp->kd_dosen = $request->kd_dosen;
            $Dp->kd_mtk = $request->kd_mtk;
            $Dp->kd_lokal = $request->kelas;
            $Dp->hari_t = $request->hari_t;
            $Dp->jam_t = $request->jam_t;
            $Dp->no_ruang = $request->ruang;
            $Dp->kd_dp = $request->dosen_pengganti;
            $Dp->tgl_ganti = $request->tgl_pengganti;
            $Dp->ket = $request->alasan;
            $Dp->petugas = Auth::user()->username;
            $Dp->save();
        } else {
            return redirect('/jadwal-dosen');
        }
        return redirect('/jadwal-dosen')->with('status', 'Tersimpan');
    }
    public function dataDP(Request $request)
    {
        $jadwal = DB::table('dosen_pengganti')
            ->where(['kd_mtk' => $request->kd_mtk, 'kd_dosen' => $request->kd_dosen, 'kd_lokal' => $request->kelas, 'hari_t' => $request->hari_t, 'jam_t' => $request->jam_t, 'no_ruang' => $request->ruang])
            ->get();
        return DataTables::of($jadwal)
            ->addIndexColumn()
            ->addColumn('aksi', function ($jadwal) use ($request) {
                $id = Crypt::encryptString($jadwal->id . ',' . $request->id);
                return '
            <a class="btn btn-primary btn-lg" href="' . url('/hapus-dosen-pengganti/' . $id) . '"><i class="icon-shopping-bag"></i></a>
            ';
            })
            ->rawColumns(['aksi'])
            ->toJson();
        // return response()->json($jadwal);
    }
    public function hapus_dp($id)
    {
        $exp = explode(",", Crypt::decryptString($id));
        Dosen_pengganti::find($exp[0])->delete();
        return redirect('/dosen-pengganti/' . $exp[1])->with('status', 'Terhapus');
    }
}
