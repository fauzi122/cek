<?php

namespace App\Http\Controllers\Dosen;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use App\Models\Absen_ajar;
use App\Models\Absen_ajar_praktek;
use App\Models\Dosen_pengganti;
use App\Models\Dosen_praktisi;
use App\Models\Ip_absen;



class Jadwal_mengajarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     */
    public function __construct()
    {
        if (!$this->middleware('auth:sanctum')) {
            return redirect('/login');
        }
    }
    function get_client_ip_2()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'IP tidak dikenali';
        return $ipaddress;
    }

    public function index()
    {
        $cek_praktisi = Dosen_praktisi::where('nip', Auth::user()->username)->count();
// dd($cek_praktisi);
        if ($cek_praktisi > 0) {
            $where = ['kd_dosen2' => Auth::user()->kode];
            $group = ['kd_gabung', 'kd_mtk', 'no_ruang', 'jam_t', 'hari_t'];
            $jadwal = app('App\Models\Absen_ajar')->jadwal_all($where, $group)->get();
        } else {
            $where = ['nip' => Auth::user()->username];
            $group = ['kd_gabung', 'kd_mtk', 'no_ruang', 'jam_t', 'hari_t'];
            $jadwal = app('App\Models\Absen_ajar')->jadwal_all($where, $group)->get();
        }
        $ipclient = $this->get_client_ip_2();
        $expip = explode(".", $ipclient);
        $inip = $expip[0] . '.' . $expip[1] . '.' . $expip[2];
        $ip = Ip_absen::where('ip', $inip)->first();
        // dd($ip);

        // dd($cek_praktisi);
        return view('admin.mengajar.jadwal_mengajar', compact('jadwal', 'ip', 'ipclient','cek_praktisi'));
    }

    public function apiPenilaian()
    {
        return Http::get('http://localhost:8000/penilaian');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_praktek(Request $request)
    {
        $jam = date("H:i");
        $where = ['kel_praktek' => $request->kel_praktek, 'tgl_ajar_masuk' => date('Y-m-d'), 'kd_mtk' => $request->kd_mtk, 'jam_t' => $request->jam_t];
        $w_cek = ['kel_praktek' => $request->kel_praktek, 'kd_mtk' => $request->kd_mtk, 'jam_t' => $request->jam_t];
        $w_pert = ['kel_praktek' => $request->kel_praktek, 'kd_mtk' => $request->kd_mtk];
        //    $w_absen = ['kel_praktek'=>$request->kel_praktek,'kd_mtk'=>$request->kd_mtk,'tgl_hadir'=>date('Y-m-d'),'status_hadir'=>'1'];
        $cek_dp = Dosen_pengganti::where(['kd_lokal' => $request->kel_praktek, 'kd_mtk' => $request->kd_mtk, 'tgl_ganti' => date('Y-m-d'), 'jam_t' => $request->jam_t])->where('kd_dosen', '=', Auth::user()->kode)->count();
        if ($cek_dp) {
            return redirect('/jadwal-dosen-pengganti')->with('jam', 'Jadwal Anda Telah Digantikan');
        }
        $absen_pert = Absen_ajar_praktek::where($w_pert)
            ->orderByDesc('pertemuan');
        $cek_absen = Absen_ajar_praktek::where($where)
            ->orderByDesc('pertemuan');
        if ($absen_pert->count() > 0) {
            $temu = $absen_pert->first();
            $jml_pert = $temu->pertemuan + 1;
            if ($cek_absen->count() > 0) {
                $pert = $temu->pertemuan;
            } elseif ($jml_pert == '8') {
                $pert = $temu->pertemuan + 2;
            } else {
                $pert = $temu->pertemuan + 1;
            }
        } else {
            $pert = '1';
        }
        $absen_ajar = Absen_ajar_praktek::where($where)->count();
        $cek_jam = app('App\Models\Absen_ajar')->cek_jam($w_cek, $jam)->first();
        //    dd($cek_jam);
        if (isset($cek_jam)) {
            if ($absen_ajar < 1) {
                Absen_ajar_praktek::create([
                    'nip' => Auth::user()->username,
                    'kel_praktek' => $request->kel_praktek,
                    'kd_mtk' => $request->kd_mtk,
                    'nm_mtk' => $request->nm_mtk,
                    'sks' => $request->sks,
                    'tgl_ajar_masuk' => date('Y-m-d'),
                    'hari_ajar_masuk' => $request->hari_t,
                    'jam_masuk' => date('H:i:s'),
                    'no_ruang' => $request->no_ruang,
                    'pertemuan' => $pert,
                    'jam_t' => $request->jam_t,
                    'kd_dosen' => $request->kd_dosen
                ]);
            }
        } else {
            return redirect('/jadwal')->with('jam', 'Anda Belum Waktunya Masuk Kelas');
        }
        //    dd($pert);
        $id = Crypt::encryptString($request->kd_mtk . ',' . preg_replace("/[^a-zA-Z0-9]/", "", $request->nm_mtk) . ',' . $request->kd_dosen . ',' . $request->sks . ',' . $request->kel_praktek . ',' . $request->hari_t . ',' . $request->jam_t . ',' . $request->no_ruang . ',' . $pert);
        return redirect('/ajar-praktek/' . $id);
    }

    public function store_teori(Request $request)
    {
        $jam = date("H:i");
        $where = ['kd_lokal' => $request->kd_lokal, 'tgl_ajar_masuk' => date('Y-m-d'), 'kd_mtk' => $request->kd_mtk, 'jam_t' => $request->jam_t];
        $w_cek = ['kd_lokal' => $request->kd_lokal, 'kd_mtk' => $request->kd_mtk, 'jam_t' => $request->jam_t];
        $w_pert = ['kd_lokal' => $request->kd_lokal, 'kd_mtk' => $request->kd_mtk];
        $cek_dp = Dosen_pengganti::where(['kd_lokal' => $request->kd_lokal, 'kd_mtk' => $request->kd_mtk, 'tgl_ganti' => date('Y-m-d'), 'jam_t' => $request->jam_t])->where('kd_dosen', '=', Auth::user()->kode)->count();
        if ($cek_dp) {
            return redirect('/jadwal-dosen-pengganti')->with('jam', 'Jadwal Anda Telah Digantikan');
        }
        //    $w_absen = ['kd_lokal'=>$request->kd_lokal,'kd_mtk'=>$request->kd_mtk,'tgl_hadir'=>date('Y-m-d'),'status_hadir'=>'1'];
        $absen_pert = Absen_ajar::where($w_pert)
            ->orderByDesc('pertemuan');
        $cek_absen = Absen_ajar::where($where)
            ->orderByDesc('pertemuan');
        if ($absen_pert->count() > 0) {
            $temu = $absen_pert->first();
            $jml_pert = $temu->pertemuan + 1;
            if ($cek_absen->count() > 0) {
                $pert = $temu->pertemuan;
            } elseif ($jml_pert == '8') {
                $pert = $temu->pertemuan + 2;
            } else {
                $pert = $temu->pertemuan + 1;
            }
        } else {
            $pert = '1';
        }
        $absen_ajar = Absen_ajar::where($where)->count();
        $cek_jam = app('App\Models\Absen_ajar')->cek_jam($w_cek, $jam)->first();
        //    dd($cek_jam);
        if (isset($cek_jam)) {
            if ($absen_ajar < 1) {
                Absen_ajar::create([
                    'nip' => Auth::user()->username,
                    'kd_lokal' => $request->kd_lokal,
                    'kd_mtk' => $request->kd_mtk,
                    'nm_mtk' => $request->nm_mtk,
                    'sks' => $request->sks,
                    'tgl_ajar_masuk' => date('Y-m-d'),
                    'hari_ajar_masuk' => $request->hari_t,
                    'jam_masuk' => date('H:i:s'),
                    'no_ruang' => $request->no_ruang,
                    'pertemuan' => $pert,
                    'jam_t' => $request->jam_t,
                    'kd_dosen' => $request->kd_dosen
                ]);
            }
        } else {
            return redirect('/jadwal')->with('jam', 'Anda Belum Waktunya Masuk Kelas');
        }
        $id = Crypt::encryptString($request->kd_mtk . ',' . preg_replace("/[^a-zA-Z0-9]/", "", $request->nm_mtk) . ',' . $request->kd_dosen . ',' . $request->sks . ',' . $request->kd_lokal . ',' . $request->hari_t . ',' . $request->jam_t . ',' . $request->no_ruang . ',' . $pert);
        return redirect('/ajar-teori/' . $id);
    }



    public function store_gabung(Request $request)
    {
        // 0 => "882"
        // 1 => "MULTIMEDIA"
        // 2 => "GNB"
        // 3 => "3"
        // 4 => "KG.882.12.A"
        // 5 => "Senin"
        // 6 => "07:30-10:00"
        // 7 => "202-G1"
        // 8 => "12"
        // $request = explode(",",Crypt::decryptString($id));
        $jam = date("H:i");
        $lokal = DB::table('pertemuan')
            ->select(DB::raw('GROUP_CONCAT(kd_lokal) AS kd_lokal'))
            ->where('kd_gabung', '=', $request->kd_lokal)->first();
        $xx = $lokal->kd_lokal;
        $w_cek = ['kd_gabung' => $request->kd_lokal, 'kd_mtk' => $request->kd_mtk, 'jam_t' => $request->jam_t];
        $where = ['kd_lokal' => $request->kd_lokal, 'tgl_ajar_masuk' => date('Y-m-d'), 'jam_t' => $request->jam_t];
        $w_pert = ['kd_lokal' => $request->kd_lokal, 'kd_mtk' => $request->kd_mtk];
        $cek_dp = Dosen_pengganti::where(['kd_lokal' => $request->kd_lokal, 'kd_mtk' => $request->kd_mtk, 'tgl_ganti' => date('Y-m-d'), 'jam_t' => $request->jam_t])->where('kd_dosen', '=', Auth::user()->kode)->count();
        if ($cek_dp) {
            return redirect('/jadwal-dosen-pengganti')->with('jam', 'Jadwal Anda Telah Digantikan');
        }
        $absen_pert = Absen_ajar::where($w_pert)
            ->orderByDesc('pertemuan');
        // dd($absen_pert->count());
        if ($absen_pert->count() > 0) {
            $temu = $absen_pert->first();
            $jml_pert = $temu->pertemuan + 1;
            if ($temu->tgl_ajar_masuk == date('Y-m-d')) {
                $pert = $temu->pertemuan;
            } elseif ($jml_pert == '8') {
                $pert = $temu->pertemuan + 2;
            } else {
                $pert = $temu->pertemuan + 1;
            }
        } else {
            $pert = '1';
        }
        $absen_ajar = Absen_ajar::where($where)->count();
        $cek_jam = app('App\Models\Absen_ajar')->cek_jam($w_cek, $jam)->first();
        if (isset($cek_jam)) {
            if ($absen_ajar < 1) {
                $simpan = Absen_ajar::create([
                    'nip' => Auth::user()->username,
                    'kd_lokal' => $request->kd_lokal,
                    'detail_gabung' => $xx,
                    'kd_mtk' => $request->kd_mtk,
                    'nm_mtk' => $request->nm_mtk,
                    'sks' => $request->sks,
                    'tgl_ajar_masuk' => date('Y-m-d'),
                    'hari_ajar_masuk' => $request->hari_t,
                    'jam_masuk' => date('H:i:s'),
                    'no_ruang' => $request->no_ruang,
                    'pertemuan' => $pert,
                    'jam_t' => $request->jam_t,
                    'kd_dosen' => $request->kd_dosen
                ]);
            }
        } else {
            return redirect('/jadwal')->with('jam', 'Anda Belum Waktunya Masuk Kelas');
        }
        $id = Crypt::encryptString($request->kd_mtk . ',' . preg_replace("/[^a-zA-Z0-9]/", "", $request->nm_mtk) . ',' . $request->kd_dosen . ',' . $request->sks . ',' . $request->kd_lokal . ',' . $request->hari_t . ',' . $request->jam_t . ',' . $request->no_ruang . ',' . $pert);
        return redirect('/ajar-gabung/' . $id);
    }

    public function ajar_gabung($id)
    {
        $request = explode(",", Crypt::decryptString($id));
        // dd($request);
        $w_pert = ['kd_lokal' => $request[4], 'kd_mtk' => $request[0]];
        $w_jadwal = ['kd_mtk' => $request[0], 'jam_t' => $request[6], 'hari_t' => $request[5]];
        // $w_showMhs = ['a.kd_lokal'=>$request[4],'d.tgl_ajar_masuk'=>date('Y-m-d'),'b.kd_mtk'=>$request[0]];
        $w_temu = ['kd_lokal' => $request[4], 'tgl_ajar_masuk' => date('Y-m-d'), 'kd_mtk' => $request[0], 'jam_t' => $request[6]];
        $berita_acara = Absen_ajar::select('pertemuan', 'berita_acara', 'rangkuman', 'kd_lokal', 'file_ajar', 'jam_masuk', 'jam_keluar')
            ->where($w_pert)->get();
        $w_cek = ['kd_lokal' => $request[4], 'kd_mtk' => $request[0], 'tgl_ajar_masuk' => date('Y-m-d'), 'jam_t' => $request[6]];
        $absen_keluar = app('App\Models\Absen_gabung')->cek_bap($w_cek)->first();
        $mahasiswa = app('App\Models\Absen_gabung')->showMhs($request[4], $request[0]);
        $mhs_foto = app('App\Models\Absen_gabung')->mhs_foto($request[4], $request[0]);
        $jml_mhs = app('App\Models\Absen_gabung')->jumlah_mhs($request[4], $request[0]);
        $jml_hadir = app('App\Models\Absen_gabung')->jml_hadir($request[4], $request[0], $request[8]);
        // dd($mhs_foto);
        $mhs_hadir = app('App\Models\Absen_gabung')->mhs_hadir($request[4], $request[0], $request[8]);
        $temu_ajar = app('App\Models\Absen_gabung')->temu_ajar($w_temu);
        // dd($w_jadwal);
        $jadwal = app('App\Models\Absen_gabung')->jadwal($w_jadwal, $request[4])->get();
        // dd($jadwal);
        return view('admin.mengajar.ajar_gabung', compact('mahasiswa', 'mhs_hadir', 'temu_ajar', 'jadwal', 'jml_mhs', 'jml_hadir', 'berita_acara', 'id', 'absen_keluar', 'mhs_foto'));
    }

    public function ajar_teori($id)
    {
        $request = explode(",", Crypt::decryptString($id));
        // dd($request);
        $w_jadwal = ['kd_mtk' => $request[0], 'kd_lokal' => $request[4], 'jam_t' => $request[6]];
        $w_pert = ['kd_lokal' => $request[4], 'kd_mtk' => $request[0]];
        $w_cek = ['kd_lokal' => $request[4], 'kd_mtk' => $request[0], 'tgl_ajar_masuk' => date('Y-m-d'), 'jam_t' => $request[6]];
        $w_showMhs = ['a.kd_lokal' => $request[4], 'd.tgl_ajar_masuk' => date('Y-m-d'), 'b.kd_mtk' => $request[0], 'd.jam_t' => $request[6]];
        $w_mhs_mbkm = ['a.kd_lokal' => $request[4], 'b.tgl_ajar_masuk' => date('Y-m-d'), 'b.kd_mtk' => $request[0], 'b.jam_t' => $request[6]];
        $w_showFoto = ['a.kode' => $request[4], 'd.tgl_ajar_masuk' => date('Y-m-d'), 'b.kd_mtk' => $request[0]];
        $w_temu = ['kd_lokal' => $request[4], 'tgl_ajar_masuk' => date('Y-m-d'), 'kd_mtk' => $request[0], 'jam_t' => $request[6]];
        $berita_acara = Absen_ajar::select('pertemuan', 'berita_acara', 'rangkuman', 'kd_lokal', 'file_ajar', 'jam_masuk', 'jam_keluar')
            ->where($w_pert)->get();
        $absen_keluar = app('App\Models\Absen_ajar')->cek_bap($w_cek)->first();
        $mahasiswa = app('App\Models\Absen_ajar')->showMhs($w_showMhs);
        $mhs_foto = app('App\Models\Absen_ajar')->mhs_foto($w_showFoto);
        $jml_mhs = app('App\Models\Absen_ajar')->jumlah_mhs($request[4]);
        $jml_hadir = app('App\Models\Absen_ajar')->jml_hadir($request[4], $request[0], $request[8]);
        $mhs_hadir = app('App\Models\Absen_ajar')->mhs_hadir($request[4], $request[0], $request[8]);
        $temu_ajar = app('App\Models\Absen_ajar')->temu_ajar($w_temu);
        $jadwal = app('App\Models\Absen_ajar')->jadwal($w_jadwal)->get();
        //MBKM
        // $mhs_mbkm = app('App\Models\Absen_ajar')->showMhsMbkm($w_mhs_mbkm);
        // $jml_mhs_mbkm = app('App\Models\Absen_ajar')->jumlah_mhsMbkm($request[4],$request[0]);
        // $jml_hadir = app('App\Models\Absen_ajar')->jml_hadir($request[4],$request[0],$request[8]);
        // $mhs_hadir = app('App\Models\Absen_ajar')->mhs_hadir($request[4],$request[0],$request[8]);

        return view('admin.mengajar.ajar_teori', compact('mahasiswa', 'mhs_hadir', 'temu_ajar', 'jadwal', 'jml_mhs', 'jml_hadir', 'berita_acara', 'id', 'absen_keluar', 'mhs_foto'));
    }

    public function ajar_praktek($id)
    {
        $request = explode(",", Crypt::decryptString($id));
        // dd($request);
        $w_jadwal = ['kd_mtk' => $request[0], 'kel_praktek' => $request[4], 'jam_t' => $request[6]];
        $w_cek = ['kel_praktek' => $request[4], 'kd_mtk' => $request[0], 'tgl_ajar_masuk' => date('Y-m-d'), 'jam_t' => $request[6]];
        $w_pert = ['kel_praktek' => $request[4], 'kd_mtk' => $request[0]];
        $w_showMhs = ['b.kel_praktek' => $request[4], 'd.tgl_ajar_masuk' => date('Y-m-d'), 'b.kd_mtk' => $request[0], 'd.jam_t' => $request[6]];
        $w_temu = ['kel_praktek' => $request[4], 'tgl_ajar_masuk' => date('Y-m-d'), 'kd_mtk' => $request[0], 'jam_t' => $request[6]];
        $berita_acara = Absen_ajar_praktek::select('pertemuan', 'berita_acara', 'rangkuman', 'kel_praktek', 'file_ajar', 'jam_masuk', 'jam_keluar')
            ->where($w_pert)->get();
        $absen_keluar = app('App\Models\Absen_ajar_praktek')->cek_bap($w_cek)->first();
        $mahasiswa = app('App\Models\Absen_ajar_praktek')->showMhs($w_showMhs);
        $mhs_foto = app('App\Models\Absen_ajar_praktek')->mhs_foto($w_showMhs);
        $jml_mhs = app('App\Models\Absen_ajar_praktek')->jumlah_mhs($w_showMhs);
        $jml_hadir = app('App\Models\Absen_ajar_praktek')->jml_hadir($request[4], $request[0], $request[8]);
        $mhs_hadir = app('App\Models\Absen_ajar_praktek')->mhs_hadir($request[4], $request[0], $request[8]);
        $temu_ajar = app('App\Models\Absen_ajar_praktek')->temu_ajar($w_temu);
        $jadwal = app('App\Models\Absen_ajar_praktek')->jadwal($w_jadwal)->get();
        return view('admin.mengajar.ajar_praktek', compact('mahasiswa', 'mhs_hadir', 'temu_ajar', 'jadwal', 'jml_mhs', 'jml_hadir', 'berita_acara', 'id', 'absen_keluar', 'mhs_foto'));
    }

    public function absen_keluar(Request $request)
    {
        $exp = explode(",", Crypt::decryptString($request->id));
        $w_cek = ['kd_lokal' => $exp[4], 'kd_mtk' => $exp[0], 'tgl_ajar_masuk' => date('Y-m-d'), 'jam_t' => $exp[6]];
        $jam = date("H:i");
        $tgl_keluar = date("Y-m-d");
        $jam_keluar = date("H:i:s");
        $w_jam = ['kd_lokal' => $exp[4], 'kd_mtk' => $exp[0]];
        $cek_bap = app('App\Models\Absen_ajar')->cek_bap($w_cek)->first();
        if ($cek_bap->berita_acara <> null && $cek_bap->berita_acara <> '' && $cek_bap->rangkuman <> null && $cek_bap->rangkuman <> '' && $cek_bap->file_ajar <> null && $cek_bap->file_ajar <> '') {
            if ($request->pengganti == '1') {
                $cek_jam = app('App\Models\Absen_ajar')->cek_jam_keluar_pengganti($w_jam, $jam)->first();
            } else {
                $cek_jam = app('App\Models\Absen_ajar')->cek_jam_keluar($w_jam, $jam)->first();
            }
            if (isset($cek_jam)) {
                Absen_ajar::where($w_cek)
                    ->update([
                        'tgl_ajar_keluar' => $tgl_keluar,
                        'jam_keluar' => $jam_keluar
                    ]);

                if ($request->pengganti == '1') {
                    return redirect('/jadwal-pengganti')->with('status', 'Absen Keluar Mengajar');
                } else {
                    return redirect('/jadwal')->with('status', 'Absen Keluar Mengajar');
                }
            } else {
                if ($request->pengganti == '1') {
                    return redirect('/ajar-teori-pengganti/' . $request->id)->with('error', 'Anda Tidak Dapat Melakukan Absen Keluar');
                } else {
                    return redirect('/ajar-teori/' . $request->id)->with('error', 'Anda Tidak Dapat Melakukan Absen Keluar');
                }
            }
        } else {
            if ($request->pengganti == '1') {
                return redirect('/ajar-teori-pengganti/' . $request->id)->with('error', 'Pokok Pembahasan Tidak Boleh Kosong');
            } else {
                return redirect('/ajar-teori/' . $request->id)->with('error', 'Pokok Pembahasan Tidak Boleh Kosong');
            }
        }
    }
    public function absen_keluar_praktek(Request $request)
    {
        $exp = explode(",", Crypt::decryptString($request->id));
        $w_cek = ['kel_praktek' => $exp[4], 'kd_mtk' => $exp[0], 'tgl_ajar_masuk' => date('Y-m-d'), 'jam_t' => $exp[6]];
        $jam = date("H:i");
        $tgl_keluar = date("Y-m-d");
        $jam_keluar = date("H:i:s");
        $w_jam = ['kel_praktek' => $exp[4], 'kd_mtk' => $exp[0]];
        $cek_bap = app('App\Models\Absen_ajar_praktek')->cek_bap($w_cek)->first();
        if ($cek_bap->berita_acara <> null && $cek_bap->berita_acara <> '' && $cek_bap->rangkuman <> null && $cek_bap->rangkuman <> '' && $cek_bap->file_ajar <> null && $cek_bap->file_ajar <> '') {
            $cek_jam = app('App\Models\Absen_ajar_praktek')->cek_jam_keluar($w_jam, $jam)->first();
            if (isset($cek_jam)) {
                Absen_ajar_praktek::where($w_cek)
                    ->update([
                        'tgl_ajar_keluar' => $tgl_keluar,
                        'jam_keluar' => $jam_keluar
                    ]);
                return redirect('/jadwal')->with('status', 'Absen Keluar Mengajar');
            } else {
                return redirect('/ajar-praktek/' . $request->id)->with('error', 'Anda Tidak Dapat Melakukan Absen Keluar');
            }
        } else {
            return redirect('/ajar-praktek/' . $request->id)->with('error', 'Pokok Pembahasan Tidak Boleh Kosong');
        }
    }
    public function absen_keluar_gabung(Request $request)
    {
        $exp = explode(",", Crypt::decryptString($request->id));
        $w_cek = ['kd_lokal' => $exp[4], 'kd_mtk' => $exp[0], 'tgl_ajar_masuk' => date('Y-m-d'), 'jam_t' => $exp[6]];
        $jam = date("H:i");
        $tgl_keluar = date("Y-m-d");
        $jam_keluar = date("H:i:s");
        $w_jam = ['kd_gabung' => $exp[4], 'kd_mtk' => $exp[0]];
        $cek_bap = app('App\Models\Absen_gabung')->cek_bap($w_cek)->first();
        if ($cek_bap->berita_acara <> null && $cek_bap->berita_acara <> '' && $cek_bap->rangkuman <> null && $cek_bap->rangkuman <> '' && $cek_bap->file_ajar <> null && $cek_bap->file_ajar <> '') {
            if ($request->pengganti == '1') {
                $cek_jam = app('App\Models\Absen_gabung')->cek_jam_keluar_pengganti($w_jam, $jam)->first();
            } else {
                $cek_jam = app('App\Models\Absen_gabung')->cek_jam_keluar($w_jam, $jam)->first();
            }
            if (isset($cek_jam)) {
                Absen_ajar::where($w_cek)
                    ->update([
                        'tgl_ajar_keluar' => $tgl_keluar,
                        'jam_keluar' => $jam_keluar
                    ]);
                if ($request->pengganti == '1') {
                    return redirect('/jadwal-pengganti')->with('status', 'Absen Keluar Mengajar');
                } else {
                    return redirect('/jadwal')->with('status', 'Absen Keluar Mengajar');
                }
            } else {
                if ($request->pengganti == '1') {
                    return redirect('/ajar-gabung-pengganti/' . $request->id)->with('error', 'Anda Tidak Dapat Melakukan Absen Keluar');
                } else {
                    return redirect('/ajar-gabung/' . $request->id)->with('error', 'Anda Tidak Dapat Melakukan Absen Keluar');
                }
            }
        } else {
            if ($request->pengganti == '1') {
                return redirect('/ajar-gabung-pengganti/' . $request->id)->with('error', 'Pokok Pembahasan Tidak Boleh Kosong');
            } else {
                return redirect('/ajar-gabung/' . $request->id)->with('error', 'Pokok Pembahasan Tidak Boleh Kosong');
            }
        }
    }

    public function download_file_ajar(Request $request)
    {
        $files = public_path() . '/storage/ajar/' . $request->file; //Mencari file dari model yang sudah dicari
        if (file_exists($files)) {
            return response()->download($files, $request->file);
        } else {
            echo "kosong";
        }

        // dd($file);
        // $model_file = Absen_ajar::findOrFail($id); //Mencari model atau objek yang dicari
    }
    public function download_file_ajarr(Request $request)
    {
        $files = public_path() . '/storage/materi/' . $request->file; //Mencari file dari model yang sudah dicari
        if (file_exists($files)) {
            return response()->download($files, $request->file);
        } else {
            echo "kosong";
        }

        // dd($file);
        // $model_file = Absen_ajar::findOrFail($id); //Mencari model atau objek yang dicari
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
