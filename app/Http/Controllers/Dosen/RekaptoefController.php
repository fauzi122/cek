<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Distribusisoal;
use App\Models\DetailSoalEssay;
use Illuminate\Http\Request;
use App\Models\Hasilujian;
use App\Models\Hasiltoeflujian;
use App\Models\JawabEsay;
use App\Models\Jadwal;
use App\Models\Jawab;
use App\Models\User;
use App\Models\Soal;

class RekaptoefController extends Controller
{
    public function __construct()
    {

        if (!$this->middleware('auth:sanctum')) {
            return redirect('/login');
        }
    }
    public function index()
    {
        if (Auth::user()->utype == 'ADM') {

            $kelas = DB::table('toef_mhs')
                ->join('mtk', 'toef_mhs.kd_mtk', '=', 'mtk.kd_mtk')
                ->select('mtk.nm_mtk', 'toef_mhs.*')
                ->groupBy('toef_mhs.kd_mtk', 'toef_mhs.kd_lokal')->get();
            // ->where('toef_mhs.kd_dosen', Auth::user()->kode)
            // ->where('toef_mhs.kd_dosen', Auth::user()->kode)->get();

            return view('admin.latihanujian.rekap_toef.index', compact('kelas'));
        } else {
            return redirect('/dashboard');
        }
    }

    public function show_mhs($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        //dd($pecah);
        $showmhs = DB::table('absen_mhs')
            ->where([
                'nim'            => $pecah[0],
                'kd_mtk'         => $pecah[1],
                'kd_lokal'       => $pecah[2]
            ])->get();
        return view('administrasi.rekap_toef.show_mhs', compact('showmhs'));
    }

    public function show_hasil($id_hasil)
    {

        $pecah = explode(',', Crypt::decryptString($id_hasil));

        $profil = User::where([
            'username'     => $pecah[0],
            'kode'         => $pecah[2]
        ])->first();


        $hasil = DB::table('hasilujians')
            ->join('jawabs', 'hasilujians.id_soal', '=', 'jawabs.id_soal')
            ->join('detailsoals', 'jawabs.no_soal_id', '=', 'detailsoals.id')
            ->select('jawabs.*', 'detailsoals.soal')
            ->where([
                'hasilujians.id_user'         => $pecah[0],
                'hasilujians.id_soal'         => $pecah[1],
                'hasilujians.kd_lokal'        => $pecah[2]
            ])->get();
        return view('admin.latihanujian.rekap_toef.hasilujian', compact('hasil', 'profil'));
    }

    public function show_rekap_kls($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));

        $rekap = DB::table('distribusisoals')
            ->join('soals', 'distribusisoals.id_soal', '=', 'soals.id')
            ->join('mtk', 'soals.kd_mtk', '=', 'mtk.kd_mtk')
            ->where([
                // 'soals.kd_dosen' => Auth::user()->kode,
                'distribusisoals.id_kelas' => $pecah[1],
                'soals.kd_mtk' => $pecah[2]
            ])
            ->select(
                'mtk.nm_mtk',
                'distribusisoals.id_kelas',
                'distribusisoals.id_soal',
                'soals.*'
            )->get();

        $jml_essay = DB::table('distribusisoals')
            ->join('soals', 'distribusisoals.id_soal', '=', 'soals.id')
            ->join('detail_soal_esays', 'soals.id', '=', 'detail_soal_esays.id_soal')
            ->where(['distribusisoals.id_kelas' => $pecah[1]])->count();


        // dd($jml_essay);
        return view('admin.latihanujian.rekap_toef.listujian', compact('id', 'rekap', 'jml_essay'));
    }

    public function hasil_nilai_all($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));


        $mahasiswa = app('App\Models\Hasiltoeflujian')->mhs($pecah[1]);

        // dd($mahasiswa);

        $nilai_mhs = app('App\Models\Hasiltoeflujian')->nilai($pecah[0], $pecah[1]);

        $nilai_mhs_essay = app('App\Models\Hasiltoeflujian')->nilai_essay($pecah[0], $pecah[1]);

        $nilai_mhs_pg = app('App\Models\Hasiltoeflujian')->nilai_pg($pecah[0], $pecah[1]);


        return view('admin.latihanujian.rekap_toef.nilaiall', compact(
            'nilai_mhs',
            'mahasiswa',
            'id',
            'nilai_mhs_essay',
            'nilai_mhs_pg'
        ));
    }

    public function show_mhs_uji($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));


        $profil = User::join('toef_mhs', 'users.username', '=', 'toef_mhs.nim')
            ->select('toef_mhs.*', 'users.*')
            ->where([
                'users.username'     => $pecah[1],
                'toef_mhs.kd_lokal'  => $pecah[2]
            ])->first();
        // dd($profil);

        // jawaban pilihan ganda
        $jawab = jawab::join('detailsoals', 'jawabs.no_soal_id', '=', 'detailsoals.id')
            ->select('jawabs.*', 'detailsoals.soal')
            ->where([
                'jawabs.id_soal'  => $pecah[0],
                'jawabs.id_user'  => $pecah[1],
                'jawabs.id_kelas' => $pecah[2]
            ])->get();

        // jawaban essay 
        $jawab_essay = JawabEsay::join('detail_soal_esays', 'jawab_esays.id_detail_soal_esay', '=', 'detail_soal_esays.id')
            ->select('jawab_esays.*', 'detail_soal_esays.soal')
            ->where([
                'jawab_esays.id_soal'  => $pecah[0],
                'jawab_esays.id_user'  => $pecah[1],
                'jawab_esays.id_kelas' => $pecah[2]
            ])->get();

        // dd($jawab_essay);
        return view('admin.latihanujian.rekap_toef.jawabmhs', compact('id', 'jawab', 'profil', 'jawab_essay'));
    }

    public function simpanScore(Request $request)
    {
        $check_nilai = JawabEsay::where('id', $request->essay_id)
            ->where('id_user', $request->id_user)->first();
        if ($check_nilai) {
            $check_nilai->score = $request->score;
            $check_nilai->save();
            // return response()->json(['success' =>   $check_nilai->save()]);
        }
    }

    public function destroy($id)
    {
        $tg = Hasiltoeflujian::find($id)->delete();

        if ($tg) {
            return back()->with('status', 'Di Reset');
        } else {
            return back()->with('error', 'Gagal Di Reset');
        }
    }
    public function destroy_all($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        $tg = Jawab::where([
            'jawabs.id_soal'  => $pecah[0],
            'jawabs.id_user'  => $pecah[1],
            'jawabs.id_kelas' => $pecah[2]
        ])->delete();

        $tg = JawabEsay::where([
            'jawab_esays.id_soal'  => $pecah[0],
            'jawab_esays.id_user'  => $pecah[1],
            'jawab_esays.id_kelas' => $pecah[2]
        ])->delete();

        if ($tg) {
            return back()->with('status', 'Di Reset');
        } else {
            return back()->with('error', 'Gagal Di Reset');
        }
    }
}
