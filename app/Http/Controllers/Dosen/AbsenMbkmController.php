<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Mbkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Nilai_mbkm;


class AbsenMbkmController extends Controller
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
        $mbkm_pts = DB::table('pts_mbkm')->get();
        return view('admin.mbkm.pts_mbkm', compact('mbkm_pts'));
    }

    public function nilai_mbkm()
    {
        $nilai = DB::table('jadwal_mbkm')
            ->where('kd_dosen', Auth::user()->kode)
            ->groupBy('kd_dosen', 'kd_mtk', 'kd_lokal')->get();
        // dd($nilai);
        return view('admin.mbkm.nilai_mbkm', compact('nilai'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function create_nilai($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));

        // pts
        $dosen = DB::table('nilai_mbkm')
            ->where([
                'kd_dosen' => $pecah[0],
                'kd_lokal' => $pecah[1],
                'kd_mtk'   => $pecah[2]
            ])->select('nilai_mbkm.*')
            ->first();

        // absen mbkm
        $nilai = DB::table('nilai_mbkm')->leftjoin('pts_mbkm', 'pts_mbkm.kd_pt', '=', 'nilai_mbkm.kd_kampus')
            ->where([
                'nilai_mbkm.kd_dosen' => $pecah[0],
                'nilai_mbkm.kd_lokal' => $pecah[1],
                'nilai_mbkm.kd_mtk'   => $pecah[2]

            ])->select('nilai_mbkm.*', 'pts_mbkm.*')
            ->get();

        // dd($nilai);
        return view('admin.mbkm.nilai_perkls_mbkm', compact('nilai', 'dosen'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));

        // pts
        $pts = DB::table('pts_mbkm')
            ->where(['kd_pt' => $pecah[0],])->select('pts_mbkm.*')
            ->first();

        // absen mbkm
        $absen = DB::table('rekap_absen_mbkm')
            ->where(['kd_pt' => $pecah[0],])->select('rekap_absen_mbkm.*')
            ->get();
        DB::select('call absen_mbkm');
        return view('admin.mbkm.absen_mhs_mbkm', compact('pts', 'absen'));
    }

    public function show_jadwal($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));

        $pts = DB::table('pts_mbkm')
            ->where(['kd_pt' => $pecah[0],])->select('pts_mbkm.*')
            ->first();

        $jadwalmbkm_all = mbkm::join('mtk', 'jadwal_mbkm.kd_mtk', '=', 'mtk.kd_mtk')
            ->where(['jadwal_mbkm.kd_kampus' => $pecah[0],])
            ->select('jadwal_mbkm.*', 'mtk.nm_mtk', 'mtk.sks')
            ->get();
        return view('admin.mbkm.jadwalmbkm_all', compact('jadwalmbkm_all', 'pts'));
    }

    public function show_nilai($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));

        // pts
        $pts = DB::table('pts_mbkm')
            ->where(['kd_pt' => $pecah[0],])->select('pts_mbkm.*')
            ->first();

        // absen mbkm
        $nilaipic = DB::table('nilai_mbkm')->leftjoin('pts_mbkm', 'pts_mbkm.kd_pt', '=', 'nilai_mbkm.kd_kampus')
            ->where([
                'nilai_mbkm.kd_kampus'   => $pecah[0]
            ])->select('nilai_mbkm.*', 'pts_mbkm.*')
            ->get();

        // dd($nilaipic);
        return view('admin.mbkm.nilai_mbkm_pts', compact('nilaipic', 'pts'));
    }

    public function store_teori(Request $request)
    {

        for ($i = 1; $i <= count($request->no_urut); $i++) {
            DB::table('absen_mhs')
                ->updateOrInsert(
                    [
                        'nim' => $request->no_urut[$i],
                        'kd_mtk' => $request->kd_mtk,
                        'kd_lokal' => $request->kd_lokal,
                        'pertemuan' => $request->temuke
                    ],
                    [
                        'nip' => Auth::user()->username,
                        'nim' => $request->no_urut[$i],
                        'kd_lokal' => $request->kd_lokal,
                        'kd_mtk' => $request->kd_mtk,
                        'tgl_hadir' => $request->tgl_hadir[$i],
                        'jam_hadir' => $request->jam_t[$i],
                        'pertemuan' => $request->temuke,
                        'status_hadir' => $request->nama_radio[$i]
                    ]
                );
        }
        if ($request->id == '1') {
            return redirect('/rekap-mbkm');
        } else {
            if ($request->id_ke == '1') {
                return redirect('/ajar-teori-pengganti/' . $request->id);
            } else {
                return redirect('/ajar-teori/' . $request->id);
            }
        }
    }


    public function simpanNilai(Request $request)
    {
        $check_nilai = Nilai_mbkm::where(['nim' => $request->nim, 'kd_mtk' => $request->kd_mtk])->first();
        if ($check_nilai) {
            Nilai_mbkm::where(['nim' => $request->nim, 'kd_mtk' => $request->kd_mtk])->update(['nilai' => $request->nilai]);
            return response()->json(['success' =>  $request->nilai]);
        } else {
            return response()->json(['success' => 'false']);
        }
    }
}
