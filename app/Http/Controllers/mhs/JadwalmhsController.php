<?php

namespace App\Http\Controllers\mhs;

use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Absen_ajar_praktek;
use App\Models\Absen_ajar;
use App\Models\Jadwal;
use App\Models\Absen_mhs;
use App\Models\Komentar_mhs;
use App\Models\Sapa;
use App\Models\MhsModel;
// use App\Models\mhs\Jadwalmhs;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class JadwalmhsController extends Controller
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

        $lastPasswordUpdate = Auth::user()->password_update;

        if ($lastPasswordUpdate === null || now()->diffInYears($lastPasswordUpdate) >= 1) {

            return redirect('/profile')->with('info', ' Update Password Anda dan Pastikan Email Anda Aktif.');
        }
        // dd($request->user()->kode);

        $schedule = app('App\Models\mhs\Jadwalmhs')->jadwal($request->user()->kode, $request->user()->username);
        $praktek = app('App\Models\mhs\Jadwalmhs')->jadwal_praktek($request->user()->kode, $request->user()->username);
        $kampus_merdeka = app('App\Models\mhs\Jadwalmhs')->jadwal_km($request->user()->kode, $request->user()->username);
        $kampus_merdeka_praktek = app('App\Models\mhs\Jadwalmhs')->jadwal_km_praktek($request->user()->kode, $request->user()->username);
        // dd($kampus_merdeka_praktek->first());
        // $kampus_merdeka_praktek = app('App\Models\mhs\Jadwalmhs')->jadwal_praktek_km($request->user()->kode,$request->user()->username);
        // $cek=$schedule->get();
        // dd($kampus_merdeka->count());
        // dump($ck->kd_mtk);
        // $cek_ajar = app('App\Models\mhs\Jadwalmhs')->absen_ajar($request->user()->kode,date('Y-m-d'));
        // $cek_ajar_praktek = app('App\Models\mhs\Jadwalmhs')->absen_ajar_praktek($request->user()->kode,date('Y-m-d'));
        // echo $cek_ajar['894']->pertemuan;
        // echo $cek_ajar['328']->pertemuan;
        // die;
        // dd($cek_ajar_praktek['894']->pertemuan);

        // $cek_ajar = app('App\Models\mhs\Jadwalmhs')->jadwal($request->user()->kode,$request->user()->username);
        return view('mhs.jadwal.index', compact('schedule', 'praktek', 'kampus_merdeka', 'kampus_merdeka_praktek'));
    }

    public function show_absen($id)
    {
        // 0 => "894"
        // 1 => "DASAR PEMROGRAMAN "
        // 2 => "GNB"
        // 3 => "4"
        // 4 => "DPG.19.1A.12.A"
        // 5 => "Senin"
        // 6 => "11:40-15:00"
        // 7 => "201-G1"
        $tgl = date('Y-m-d');
        $exp = explode(",", Crypt::decryptString($id));
        $w_cek = ['kel_praktek' => $exp[4], 'kd_mtk' => $exp[0]];
        $jam = date("H:i");
        $cek = Absen_ajar_praktek::where($w_cek)->count();
        $userIpAddress = ambilIP();
        if ($cek > 0) {
            // $absen      = Absen_ajar_praktek::where(['kel_praktek'=>$exp[4],'kd_mtk'=>$exp[0],'tgl_ajar_masuk'=>date('Y-m-d'),'jam_t'=>$exp[6]]);
            $absen = Absen_ajar_praktek::where([
                'kel_praktek' => $exp[4],
                'kd_mtk' => $exp[0],
                'tgl_ajar_masuk' => $tgl,
                'jam_t' => $exp[6]
            ])
                ->leftJoin(
                    DB::raw('(
                SELECT kd_cabang, ip_address, ruangan 
                FROM ip_kelas 
                GROUP BY kd_cabang, ip_address, ruangan
            ) as ip_kelas_unique'),
                    function ($join) use ($userIpAddress) {
                        $join->on(DB::raw("SUBSTRING_INDEX(absen_ajar_prakteks.no_ruang, '-', -1)"), '=', 'ip_kelas_unique.kd_cabang')
                            ->whereRaw("SUBSTRING_INDEX(ip_kelas_unique.ip_address, '.', 2) = SUBSTRING_INDEX('" . $userIpAddress . "', '.', 2)");
                    }
                )
                ->select('absen_ajar_prakteks.*', 'ip_kelas_unique.ip_address', 'ip_kelas_unique.ruangan');

            $absen_cek      = Absen_ajar_praktek::where(['kel_praktek' => $exp[4], 'kd_mtk' => $exp[0]])->orderByDesc('pertemuan');
            if ($absen_cek->count() < 1) {
                $pertemuan = '0';
            } else {
                $pertemuan = $absen_cek->first()->pertemuan;
            }
            $durasi     = Jadwal::where($w_cek)
                ->where('selesai', '>=', $jam)->count();
            $absen_mhs  = Absen_mhs::Where(['kel_praktek' => $exp[4], 'kd_mtk' => $exp[0], 'pertemuan' => $pertemuan, 'nim' => Auth::user()->username])->count();
            // $sapaan = Sapa::where(['kd_dosen'=>$exp[2],'kd_lokal'=>Auth::user()->username,'kd_mtk'=>$exp[0],'pertemuan'=>$pertemuan])->first();
            $sapaan = DB::table('sapaans as a')
                ->join('users as b', 'a.nip', '=', 'b.username')
                ->where(['a.kd_dosen' => $exp[2], 'a.kd_lokal' => Auth::user()->kode, 'a.kd_mtk' => $exp[0], 'a.pertemuan' => $pertemuan])
                ->select('a.*', 'b.name', 'b.email', 'b.profile_photo_path')->first();
            // dd($sapaan);
        } else {
            // dd($exp[4]);
            $cek_teori  = Jadwal::where(['kd_lokal' => $exp[4], 'kd_mtk' => $exp[0]])->count();
            //    $absen      = Absen_ajar::where(['kd_lokal'=>$exp[4],'kd_mtk'=>$exp[0],'tgl_ajar_masuk'=>date('Y-m-d'),'jam_t'=>$exp[6]]);
            $absen = Absen_ajar::where([
                'kd_lokal' => $exp[4],
                'kd_mtk' => $exp[0],
                'tgl_ajar_masuk' => $tgl,
                'jam_t' => $exp[6]
            ])
                ->leftJoin(
                    DB::raw('(
                SELECT kd_cabang, ip_address, ruangan 
                FROM ip_kelas 
                GROUP BY kd_cabang, ip_address, ruangan
            ) as ip_kelas_unique'),
                    function ($join) use ($userIpAddress) {
                        $join->on(DB::raw("SUBSTRING_INDEX(absen_ajars.no_ruang, '-', -1)"), '=', 'ip_kelas_unique.kd_cabang')
                            ->whereRaw("SUBSTRING_INDEX(ip_kelas_unique.ip_address, '.', 2) = SUBSTRING_INDEX('" . $userIpAddress . "', '.', 2)");
                    }
                )
                ->select('absen_ajars.*', 'ip_kelas_unique.ip_address', 'ip_kelas_unique.ruangan');

            $absen_cek  = Absen_ajar::where(['kd_lokal' => $exp[4], 'kd_mtk' => $exp[0]])->orderByDesc('pertemuan');
            if ($absen_cek->count() == 0) {
                $pertemuan = '0';
            } else {
                $pertemuan = $absen_cek->first()->pertemuan;
            }

            if ($cek_teori > 0) {
                $durasi     = Jadwal::where(['kd_lokal' => $exp[4], 'kd_mtk' => $exp[0]])
                    ->where('selesai', '>=', $jam)->count();
                $absen_mhs  = Absen_mhs::Where(['kd_lokal' => Auth::user()->kode, 'kd_mtk' => $exp[0], 'pertemuan' => $pertemuan, 'nim' => Auth::user()->username])->count();
                $sapaan = DB::table('sapaans as a')
                    ->join('users as b', 'a.nip', '=', 'b.username')
                    ->where(['a.kd_dosen' => $exp[2], 'a.kd_lokal' => Auth::user()->kode, 'a.kd_mtk' => $exp[0], 'a.pertemuan' => $pertemuan])
                    ->select('a.*', 'b.name', 'b.email', 'b.profile_photo_path')->first();
            } else {
                // dd($pertemuan);
                $durasi     = Jadwal::where(['kd_gabung' => $exp[4], 'kd_mtk' => $exp[0]])
                    ->where('selesai', '>=', $jam)->count();
                $absen_mhs  = Absen_mhs::Where(['kd_gabung' => $exp[4], 'kd_mtk' => $exp[0], 'pertemuan' => $pertemuan, 'nim' => Auth::user()->username])->count();
                $sapaan = DB::table('sapaans as a')
                    ->join('users as b', 'a.nip', '=', 'b.username')
                    ->where(['a.kd_dosen' => $exp[2], 'a.kd_lokal' => $exp[4], 'a.kd_mtk' => $exp[0], 'a.pertemuan' => $pertemuan])
                    ->select('a.*', 'b.name', 'b.email', 'b.profile_photo_path')->first();
            }
        }
        // dd($pertemuan);
        $komentar = DB::table('komentar_mhs')
            ->where(['user' => Auth::user()->username, 'kd_mtk' => $exp[0], 'kd_lokal' => $exp[4]])
            ->where(DB::raw('LEFT(created_at,10)'), $tgl)
            ->count();

        $result = DB::table('mhs')
            ->join('jrskampus', 'mhs.kd_jrs', '=', 'jrskampus.kd_jrs')
            ->select('mhs.nim', 'jrskampus.nm_jrs', 'jrskampus.upps', 'jrskampus.fakultas')
            ->where('mhs.nim', Auth::user()->username)
            ->whereRaw("jrskampus.kd_cab = SUBSTRING('" . Auth::user()->kode . "', -2, 2)")
            ->where('mhs.kondisi', 1)
            ->first();

        $user = Auth::user();
        $nim = $user->username; // Asumsi bahwa username adalah NIM
        $nip_dosen = $exp[2]; // Pastikan variabel ini sudah diatur sebelumnya
        $kd_mtk = $exp[0]; // Pastikan variabel ini sudah diatur sebelumnya

        $kuisionerExists = MhsModel::where('nim', $nim)
            ->where('nip_dosen', $nip_dosen)
            ->where('mtk', $kd_mtk)
            ->exists();
        $pengganti = '0';

        return view('mhs.jadwal.absen_mhs', compact('id', 'absen', 'exp', 'durasi', 'absen_mhs', 'komentar', 'sapaan', 'result', 'kuisionerExists', 'pengganti'));
    }
    public function rekap_side($id)
    {
        $exp = explode(",", Crypt::decryptString($id));
        $where = ['kel_praktek' => $exp[4], 'kd_mtk' => $exp[0]];
        $cek = Absen_ajar_praktek::where($where)->count();
        if ($cek > 0) {
            $ajar = DB::table('absen_ajar_prakteks')
                ->where($where)->get();
        } else {
            $ajar = DB::table('absen_ajars')
                ->where(['kd_lokal' => $exp[4], 'kd_mtk' => $exp[0]])->get();
        }

        return Datatables::of($ajar)
            ->addColumn('status_hadir', function ($ajar) {
                $w_mhs = ['pertemuan' => $ajar->pertemuan, 'kd_mtk' => $ajar->kd_mtk, 'nim' => Auth::user()->username];
                $absen_mhs = DB::table('absen_mhs')
                    ->where($w_mhs)->first();
                if (isset($absen_mhs->status_hadir)) {
                    if ($absen_mhs->status_hadir == '0') {
                        $aksi = '<a href="javascript:void(0)" class="btn btn-danger">Tidak Hadir</a>';
                    } else {
                        $aksi = '<a href="javascript:void(0)" class="btn btn-primary">Hadir</a>';
                    }
                } else {
                    $aksi = '<a href="javascript:void(0)" class="btn btn-danger">Tidak Hadir</a>';
                }
                return $aksi;
            })
            ->rawColumns(['status_hadir'])
            // ->rawColumns(['nomer'])
            ->make(true);
    }

    public function mhs_absen(Request $request)
    {
        // 0 => "894"
        // 1 => "DASAR PEMROGRAMAN "
        // 2 => "GNB"
        // 3 => "4"
        // 4 => "DPG.19.1A.12.A"
        // 5 => "Senin"
        // 6 => "11:40-15:00"
        // 7 => "201-G1"
        $pert = explode(",", Crypt::decryptString($request->pertemuan));
        $exp = explode(",", Crypt::decryptString($request->id));
        $w_cek = ['kel_praktek' => $exp[4], 'kd_mtk' => $exp[0]];
        $cek = Absen_ajar_praktek::where($w_cek)->count();
        if ($cek > 0) {
            DB::table('absen_mhs')->insert([
                'nip' => $pert[2],
                'nim' => Auth::user()->username,
                'kd_lokal' => Auth::user()->kode,
                'kd_mtk' => $exp[0],
                'kel_praktek' => $exp[4],
                'tgl_hadir' => date('Y-m-d'),
                'jam_hadir' => date('H:i:s'),
                'pertemuan' => $pert[0],
                'ip_address' => ambilIP(),
                'status_hadir' => $pert[1]
            ]);
        } else {
            $cek_teori   = Jadwal::where(['kd_lokal' => $exp[4], 'kd_mtk' => $exp[0]])->count();
            if ($cek_teori > 0) {
                DB::table('absen_mhs')->insert([
                    'nip' => $pert[2],
                    'nim' => Auth::user()->username,
                    'kd_lokal' => Auth::user()->kode,
                    'kd_mtk' => $exp[0],
                    'tgl_hadir' => date('Y-m-d'),
                    'jam_hadir' => date('H:i:s'),
                    'pertemuan' => $pert[0],
                    'ip_address' => ambilIP(),
                    'status_hadir' => $pert[1]
                ]);
            } else {
                DB::table('absen_mhs')->insert([
                    'nip' => $pert[2],
                    'nim' => Auth::user()->username,
                    'kd_lokal' => Auth::user()->kode,
                    'kd_mtk' => $exp[0],
                    'tgl_hadir' => date('Y-m-d'),
                    'jam_hadir' => date('H:i:s'),
                    'pertemuan' => $pert[0],
                    'status_hadir' => $pert[1],
                    'ip_address' => ambilIP(),
                    'kd_gabung' => $exp[4]
                ]);
            }
        }
        if ($pert[3] == '1') {

            return redirect('/absen-mhs-pengganti/' . $request->id);
        } else {

            return redirect('/absen-mhs/' . $request->id);
        }
    }
    public function komentar_mhs(Request $request)
    {
        $pert = explode(",", Crypt::decryptString($request->pertemuan));
        $request->validate([
            'komentar' => 'required|min:10',
            'nilai' => 'required',
        ]);
        $exp = explode(",", Crypt::decryptString($request->id));
        Komentar_mhs::updateOrCreate(
            [
                'kd_mtk' => $exp[0],
                'kd_lokal' => $exp[4],
                'user' => Auth::user()->username,
                'pertemuan' => $pert[0]
            ],
            [
                'kd_mtk' => $exp[0],
                'kd_lokal' => $exp[4],
                'pertemuan' => $pert[0],
                'user' => Auth::user()->username,
                'penilai' => $request->nilai,
                'komentar' => $request->komentar
            ]
        );
        if ($pert[3] = '1') {
            # code...
            return redirect('/absen-mhs-pengganti/' . $request->id);
        } else {
            # code...
            return redirect('/absen-mhs/' . $request->id);
        }
    }

    public function modul()
    {
        // dd("asd");
        return view('mhs.materi.modul');
    }
}
