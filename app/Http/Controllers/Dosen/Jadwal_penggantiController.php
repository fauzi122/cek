<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Jadwal;
use App\Models\Kuliah_pengganti;
use App\Models\Absen_ajar;
use App\Models\Absen_ajar_praktek;
use Illuminate\Support\Facades\Crypt;
use App\Models\Absen_gabung;
use App\Models\Ip_absen;

class Jadwal_penggantiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
        $where = ['nip' => Auth::user()->username];
        $group = ['kd_gabung', 'kd_mtk', 'no_ruang', 'jam_t', 'hari_t'];
        $jadwal = app('App\Models\Absen_ajar')->jadwal_all($where, $group)->get();
        $compact = ['jadwal'];


        return view('admin.jadwal_pengganti.jadwal_mengajar', compact($compact));
    }
    public function pengganti_praktek(Request $request)
    {
        if (isset($request->tgl_pengganti)) {
            $w_kp = ['kel_praktek' => $request->kel_praktek, 'kd_mtk' => $request->kd_mtk, 'tgl_klh_pengganti' => $request->tgl_pengganti];
            $jadwal = Kuliah_pengganti::where($w_kp)->first();
            $kuliah_pengganti = Kuliah_pengganti::where($w_kp)->get();
        } else {
            $jadwal = Jadwal::where(['kel_praktek' => $request->kel_praktek, 'kd_mtk' => $request->kd_mtk])->first();
            $kuliah_pengganti = Kuliah_pengganti::where(['kel_praktek' => $request->kel_praktek, 'kd_mtk' => $request->kd_mtk])->get();
        }
        //    dd($jadwal->nm_mtk);

        $ipclient = $this->get_client_ip_2();
        $expip = explode(".", $ipclient);
        $inip = $expip[0] . '.' . $expip[1] . '.' . $expip[2];
        $ip = Ip_absen::where('ip', $inip)->first();

        // dd($ip);

        return view('admin.jadwal_pengganti.form_pengganti_praktek', compact('jadwal', 'kuliah_pengganti', 'ip', 'ipclient'));
    }

    public function pengganti_teori(Request $request)
    {
        if (isset($request->tgl_pengganti)) {
            $w_kp = ['kd_lokal' => $request->kd_lokal, 'kd_mtk' => $request->kd_mtk, 'tgl_klh_pengganti' => $request->tgl_pengganti];
            $jadwal = Kuliah_pengganti::where($w_kp)->first();
            $kuliah_pengganti = Kuliah_pengganti::where($w_kp)->get();
        } else {
            $jadwal = Jadwal::where(['kd_lokal' => $request->kd_lokal, 'kd_mtk' => $request->kd_mtk])->first();
            $kuliah_pengganti = Kuliah_pengganti::where(['kd_lokal' => $request->kd_lokal, 'kd_mtk' => $request->kd_mtk])->get();
        }
        $ipclient = $this->get_client_ip_2();
        $expip = explode(".", $ipclient);
        $inip = $expip[0] . '.' . $expip[1] . '.' . $expip[2];
        $ip = Ip_absen::where('ip', $inip)->first();
        //    dd($jadwal->nm_mtk);
        return view('admin.jadwal_pengganti.form_pengganti_teori', compact('jadwal', 'kuliah_pengganti', 'ip', 'ipclient'));
    }

    public function pengganti_gabung(Request $request)
    {
        if (isset($request->tgl_pengganti)) {
            $w_kp = ['kd_gabung' => $request->kd_lokal, 'kd_mtk' => $request->kd_mtk, 'tgl_klh_pengganti' => $request->tgl_pengganti];
            $jadwal = Kuliah_pengganti::where($w_kp)->first();
            $kuliah_pengganti = Kuliah_pengganti::where($w_kp)->get();
        } else {
            $jadwal = Jadwal::where(['kd_gabung' => $request->kd_lokal, 'kd_mtk' => $request->kd_mtk])->first();
            $kuliah_pengganti = Kuliah_pengganti::where(['kd_gabung' => $request->kd_lokal, 'kd_mtk' => $request->kd_mtk])->get();
        }
        $ipclient = $this->get_client_ip_2();
        $expip = explode(".", $ipclient);
        $inip = $expip[0] . '.' . $expip[1] . '.' . $expip[2];
        $ip = Ip_absen::where('ip', $inip)->first();
        //    dd($jadwal->nm_mtk);
        return view('admin.jadwal_pengganti.form_pengganti_gabung', compact('jadwal', 'kuliah_pengganti', 'ip', 'ipclient'));
    }

    public function store_praktek(Request $request)
    {
        // "matkul" => "SPEED TYPING I"
        // "no_j_klh" => "0420"
        // "kd_dosen" => "GNB"
        // "kd_mtk" => "064"
        // "sks" => "2"
        // "kampus" => "Ciledug A"
        // "kelas" => "ST1.21.1A.12.A"
        // "tgl_sebelum" => "2021-01-18"
        // "tgl_pengganti" => "2021-01-19"
        // "jam_masuk" => "12:30"
        // "jam_keluar" => "21:50"
        // "ruang" => "303-G1"
        // "alasan" => "mau ganti"
        $today = date_create(date("Y-m-d"));
        $pengganti = date_create($request->tgl_pengganti);
        $diff  = date_diff($today, $pengganti);
        // dd($diff->days);
        if ($diff->days < 3) {
            return redirect('/jadwal-pengganti')->with('error', 'Pengajukan KP tidak boleh kurang dari 3 hari dari tanggal pengajuan');
        }
        $w_cek = [
            'no_j_klh' => $request->no_j_klh,
            'nip' => Auth::user()->username,
            'tgl_klh_pengganti' => $request->tgl_pengganti,
            'jam_t' => $request->jam_masuk . '-' . $request->jam_keluar,
            'kd_mtk' => $request->kd_mtk
        ];
        $date = date_create($request->jam_keluar);
        $date_ex = date_create($request->jam_keluar);
        date_add($date, date_interval_create_from_date_string('-10 minutes'));
        date_add($date_ex, date_interval_create_from_date_string('10 minutes'));
        $day = date('D', strtotime($request->tgl_pengganti));
        $dayList = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        );
        $cek = Kuliah_pengganti::where($w_cek)->count();
        $in = [
            'no_j_klh' => $request->no_j_klh,
            'nip' => Auth::user()->username,
            'kd_dosen' => $request->kd_dosen,
            'tgl_yg_digantikan' => $request->tgl_sebelum,
            'tgl_klh_pengganti' => $request->tgl_pengganti,
            'kel_praktek' => $request->kelas,
            'hari_t' => $dayList[$day],
            'jam_t' => $request->jam_masuk . '-' . $request->jam_keluar,
            'no_ruang' => $request->ruang,
            'nm_mtk' => $request->matkul,
            'kd_mtk' => $request->kd_mtk,
            'sksajar' => $request->sks,
            'mulai' => $request->jam_masuk,
            'selesai' => date_format($date_ex, 'H:i'),
            'selesai_interval' => date_format($date, 'H:i'),
            'nm_kampus' => $request->kampus,
            'sts_pengajuan' => '0',
            'alasan' => $request->alasan
        ];

        if ($cek < 1) {
            Kuliah_pengganti::create($in);
            return redirect('/jadwal-pengganti')->with('status', 'Anda mengajukan perkuliahan pengganti');
        } else {
            return redirect('/jadwal-pengganti')->with('error', 'Gagal Mengajukan Perkuliahan pengganti');
        }
    }


    public function store_teori(Request $request)
    {
        $today = date_create(date("Y-m-d"));
        $pengganti = date_create($request->tgl_pengganti);
        $diff  = date_diff($today, $pengganti);
        // dd($diff->days);
        if ($diff->days < 3) {
            return redirect('/jadwal-pengganti')->with('error', 'Pengajukan KP tidak boleh kurang dari 3 hari dari tanggal pengajuan');
        }
        $w_cek = [
            'no_j_klh' => $request->no_j_klh,
            'nip' => Auth::user()->username,
            'tgl_klh_pengganti' => $request->tgl_pengganti,
            'jam_t' => $request->jam_masuk . '-' . $request->jam_keluar,
            'kd_mtk' => $request->kd_mtk
        ];
        $date = date_create($request->jam_keluar);
        $date_ex = date_create($request->jam_keluar);
        date_add($date, date_interval_create_from_date_string('-10 minutes'));
        date_add($date_ex, date_interval_create_from_date_string('10 minutes'));
        $day = date('D', strtotime($request->tgl_pengganti));
        $dayList = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        );
        $cek = Kuliah_pengganti::where($w_cek)->count();
        // dd($cek);
        $in = [
            'no_j_klh' => $request->no_j_klh,
            'nip' => Auth::user()->username,
            'kd_dosen' => $request->kd_dosen,
            'tgl_yg_digantikan' => $request->tgl_sebelum,
            'tgl_klh_pengganti' => $request->tgl_pengganti,
            'kd_lokal' => $request->kelas,
            'hari_t' => $dayList[$day],
            'jam_t' => $request->jam_masuk . '-' . $request->jam_keluar,
            'no_ruang' => $request->ruang,
            'nm_mtk' => $request->matkul,
            'kd_mtk' => $request->kd_mtk,
            'sksajar' => $request->sks,
            'mulai' => $request->jam_masuk,
            'selesai' => date_format($date_ex, 'H:i'),
            'selesai_interval' => date_format($date, 'H:i'),
            'nm_kampus' => $request->kampus,
            'sts_pengajuan' => '0',
            'alasan' => $request->alasan
        ];

        if ($cek < 1) {
            Kuliah_pengganti::create($in);
            return redirect('/jadwal-pengganti')->with('status', 'Anda  mengajukan perkuliahan pengganti');
        } else {
            return redirect('/jadwal-pengganti')->with('error', 'Gagal Mengajukan Perkuliahan pengganti');
        }
    }


    public function store_gabung(Request $request)
    {
        $today = date_create(date("Y-m-d"));
        $pengganti = date_create($request->tgl_pengganti);
        $diff  = date_diff($today, $pengganti);
        // dd($diff->days);
        if ($diff->days < 3) {
            return redirect('/jadwal-pengganti')->with('error', 'Pengajukan KP tidak boleh kurang dari 3 hari dari tanggal pengajuan');
        }
        $pertemuan = DB::table('jadwal')
            ->select(DB::raw('GROUP_CONCAT(kd_lokal) AS kd_lokal'))
            ->where('kd_gabung', '=', $request->kelas)->first();
        $w_cek = [
            'no_j_klh' => $request->no_j_klh,
            'nip' => Auth::user()->username,
            'tgl_klh_pengganti' => $request->tgl_pengganti,
            'jam_t' => $request->jam_masuk . '-' . $request->jam_keluar,
            'kd_mtk' => $request->kd_mtk
        ];
        $date = date_create($request->jam_keluar);
        $date_ex = date_create($request->jam_keluar);
        date_add($date, date_interval_create_from_date_string('-10 minutes'));
        date_add($date_ex, date_interval_create_from_date_string('10 minutes'));
        $day = date('D', strtotime($request->tgl_pengganti));
        $dayList = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        );
        $cek = Kuliah_pengganti::where($w_cek)->count();
        $in = [
            'no_j_klh' => $request->no_j_klh,
            'nip' => Auth::user()->username,
            'kd_dosen' => $request->kd_dosen,
            'tgl_yg_digantikan' => $request->tgl_sebelum,
            'tgl_klh_pengganti' => $request->tgl_pengganti,
            'kd_gabung' => $request->kelas,
            'detail_gabung' => $pertemuan->kd_lokal,
            'hari_t' => $dayList[$day],
            'jam_t' => $request->jam_masuk . '-' . $request->jam_keluar,
            'no_ruang' => $request->ruang,
            'nm_mtk' => $request->matkul,
            'kd_mtk' => $request->kd_mtk,
            'sksajar' => $request->sks,
            'mulai' => $request->jam_masuk,
            'selesai' => date_format($date_ex, 'H:i'),
            'selesai_interval' => date_format($date, 'H:i'),
            'nm_kampus' => $request->kampus,
            'sts_pengajuan' => '0',
            'alasan' => $request->alasan
        ];

        if ($cek < 1) {
            Kuliah_pengganti::create($in);
            return redirect('/jadwal-pengganti')->with('status', 'Anda mengajukan perkuliahan pengganti');
        } else {
            return redirect('/jadwal-pengganti')->with('error', 'Gagal Mengajukan Perkuliahan pengganti');
        }
    }

    public function update_praktek(Request $request)
    {
        $date = date_create($request->jam_keluar);
        date_add($date, date_interval_create_from_date_string('-10 minutes'));
        $day = date('D', strtotime($request->tgl_pengganti));
        $dayList = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        );
        $w_kp = ['tgl_klh_pengganti' => $request->tgl_pengganti_old, 'kel_praktek' => $request->kelas, 'kd_mtk' => $request->kd_mtk];
        Kuliah_pengganti::where($w_kp)
            ->update([
                'tgl_yg_digantikan' => $request->tgl_sebelum,
                'tgl_klh_pengganti' => $request->tgl_pengganti,
                'mulai' => $request->jam_masuk,
                'selesai' => $request->jam_keluar,
                'selesai_interval' => date_format($date, 'H:i'),
                'hari_t' => $dayList[$day],
                'no_ruang' => $request->ruang,
                'alasan' => $request->alasan
            ]);
        return redirect('/jadwal-pengganti')->with('status', 'Berhasil Update Data');
    }

    public function update_teori(Request $request)
    {
        // $request->validate([
        //     'komentar' => 'required|min:10',
        //     'nilai' => 'required|unique:users,email_address',

        //     ]);
        $date = date_create($request->jam_keluar);
        date_add($date, date_interval_create_from_date_string('-10 minutes'));
        $day = date('D', strtotime($request->tgl_pengganti));
        $dayList = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        );
        $w_kp = ['tgl_klh_pengganti' => $request->tgl_pengganti_old, 'kd_lokal' => $request->kelas, 'kd_mtk' => $request->kd_mtk];
        Kuliah_pengganti::where($w_kp)
            ->update([
                'tgl_yg_digantikan' => $request->tgl_sebelum,
                'tgl_klh_pengganti' => $request->tgl_pengganti,
                'mulai' => $request->jam_masuk,
                'selesai' => $request->jam_keluar,
                'selesai_interval' => date_format($date, 'H:i'),
                'hari_t' => $dayList[$day],
                'no_ruang' => $request->ruang,
                'alasan' => $request->alasan
            ]);
        return redirect('/jadwal-pengganti')->with('status', 'Berhasil Update Data');
    }

    public function update_gabung(Request $request)
    {
        $date = date_create($request->jam_keluar);
        date_add($date, date_interval_create_from_date_string('-10 minutes'));
        $day = date('D', strtotime($request->tgl_pengganti));
        $dayList = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        );
        $w_kp = ['tgl_klh_pengganti' => $request->tgl_pengganti_old, 'kd_gabung' => $request->kelas, 'kd_mtk' => $request->kd_mtk];
        Kuliah_pengganti::where($w_kp)
            ->update([
                'tgl_yg_digantikan' => $request->tgl_sebelum,
                'tgl_klh_pengganti' => $request->tgl_pengganti,
                'mulai' => $request->jam_masuk,
                'selesai' => $request->jam_keluar,
                'selesai_interval' => date_format($date, 'H:i'),
                'hari_t' => $dayList[$day],
                'no_ruang' => $request->ruang,
                'alasan' => $request->alasan
            ]);
        return redirect('/jadwal-pengganti')->with('status', 'Berhasil Update Data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function hapus_praktek(Request $request)
    {
        $w_kp = ['tgl_klh_pengganti' => $request->tgl_pengganti, 'kel_praktek' => $request->kel_praktek, 'kd_mtk' => $request->kd_mtk];
        // dd($w_kp);
        // Kuliah_pengganti::destroy($w_kp);
        Kuliah_pengganti::where($w_kp)->delete();
        return redirect('/jadwal-pengganti')->with('status', 'Terhapus');
    }

    public function hapus_teori(Request $request)
    {
        $w_kp = ['tgl_klh_pengganti' => $request->tgl_pengganti, 'kd_lokal' => $request->kd_lokal, 'kd_mtk' => $request->kd_mtk];
        // dd($w_kp);
        // Kuliah_pengganti::destroy($w_kp);
        Kuliah_pengganti::where($w_kp)->delete();
        return redirect('/jadwal-pengganti')->with('status', 'Terhapus');
    }

    public function hapus_gabung(Request $request)
    {
        $w_kp = ['tgl_klh_pengganti' => $request->tgl_pengganti, 'kd_gabung' => $request->kd_lokal, 'kd_mtk' => $request->kd_mtk];
        // dd($w_kp);
        // Kuliah_pengganti::destroy($w_kp);
        Kuliah_pengganti::where($w_kp)->delete();
        return redirect('/jadwal-pengganti')->with('status', 'Terhapus');
    }

    public function store_praktek_pengganti(Request $request)
    {
        $jam = date("H:i");
        $where = ['kd_mtk' => $request->kd_mtk, 'kel_praktek' => $request->kel_praktek, 'tgl_ajar_masuk' => date('Y-m-d'), 'jam_t' => $request->jam_t];
        $w_cek = ['kel_praktek' => $request->kel_praktek, 'kd_mtk' => $request->kd_mtk, 'jam_t' => $request->jam_t];
        $w_pert = ['kd_mtk' => $request->kd_mtk, 'kel_praktek' => $request->kel_praktek];
        $w_absen = ['kel_praktek' => $request->kel_praktek, 'kd_mtk' => $request->kd_mtk, 'tgl_hadir' => date('Y-m-d'), 'status_hadir' => '1'];
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
        $cek_jam = app('App\Models\Absen_ajar')->cek_jam_pengganti($w_cek, $jam)->first();
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
                    'sts_ajar' => 'KP',
                    'jam_t' => $request->jam_t,
                    'kd_dosen' => $request->kd_dosen
                ]);
            }
        } else {
            return redirect('/jadwal-pengganti')->with('jam', 'Anda Belum Waktunya Masuk Kelas ' . $request->kel_praktek);
        }
        //    dd($pert);
        $id = Crypt::encryptString($request->kd_mtk . ',' . $request->nm_mtk . ',' . $request->kd_dosen . ',' . $request->sks . ',' . $request->kel_praktek . ',' . $request->hari_t . ',' . $request->jam_t . ',' . $request->no_ruang . ',' . $pert);
        return redirect('/ajar-praktek-pengganti/' . $id);
    }

    public function store_teori_pengganti(Request $request)
    {
        $jam = date("H:i");
        $where = ['kd_lokal' => $request->kd_lokal, 'tgl_ajar_masuk' => date('Y-m-d'), 'kd_mtk' => $request->kd_mtk, 'jam_t' => $request->jam_t];
        $w_cek = ['kd_lokal' => $request->kd_lokal, 'kd_mtk' => $request->kd_mtk, 'jam_t' => $request->jam_t];
        $w_pert = ['kd_mtk' => $request->kd_mtk, 'kd_lokal' => $request->kd_lokal];
        $w_absen = ['kd_lokal' => $request->kd_lokal, 'kd_mtk' => $request->kd_mtk, 'tgl_hadir' => date('Y-m-d'), 'status_hadir' => '1'];
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
        $cek_jam = app('App\Models\Absen_ajar')->cek_jam_pengganti($w_cek, $jam)->first();
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
                    'sts_ajar' => 'KP',
                    'jam_t' => $request->jam_t,
                    'kd_dosen' => $request->kd_dosen
                ]);
            }
        } else {
            return redirect('/jadwal-pengganti')->with('jam', 'Anda Belum Waktunya Masuk Kelas');
        }
        $id = Crypt::encryptString($request->kd_mtk . ',' . $request->nm_mtk . ',' . $request->kd_dosen . ',' . $request->sks . ',' . $request->kd_lokal . ',' . $request->hari_t . ',' . $request->jam_t . ',' . $request->no_ruang . ',' . $pert);
        return redirect('/ajar-teori-pengganti/' . $id);
    }

    public function store_gabung_pengganti(Request $request)
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
        $where = ['kd_mtk' => $request->kd_mtk, 'kd_lokal' => $request->kd_lokal, 'tgl_ajar_masuk' => date('Y-m-d'), 'jam_t' => $request->jam_t];
        $w_pert = ['kd_mtk' => $request->kd_mtk, 'kd_lokal' => $request->kd_lokal];
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
        $cek_jam = app('App\Models\Absen_ajar')->cek_jam_pengganti($w_cek, $jam)->first();
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
                    'sts_ajar' => 'KP',
                    'jam_t' => $request->jam_t,
                    'kd_dosen' => $request->kd_dosen
                ]);
            }
        } else {
            return redirect('/jadwal-pengganti')->with('jam', 'Anda Belum Waktunya Masuk Kelas');
        }
        $id = Crypt::encryptString($request->kd_mtk . ',' . $request->nm_mtk . ',' . $request->kd_dosen . ',' . $request->sks . ',' . $request->kd_lokal . ',' . $request->hari_t . ',' . $request->jam_t . ',' . $request->no_ruang . ',' . $pert);
        return redirect('/ajar-gabung-pengganti/' . $id);
    }
    public function ajar_gabung_pengganti($id)
    {
        $request = explode(",", Crypt::decryptString($id));
        // $w_pert = ['kd_mtk'=>$request[0],'kd_lokal'=>$request[4]];
        $w_jadwal = ['kd_mtk' => $request[0], 'jam_t' => $request[6]];
        // $w_showMhs = ['a.kd_lokal'=>$request[4],'d.tgl_ajar_masuk'=>date('Y-m-d'),'b.kd_mtk'=>$request[0]];
        $w_temu = ['kd_lokal' => $request[4], 'tgl_ajar_masuk' => date('Y-m-d'), 'kd_mtk' => $request[0]];
        $berita_acara = Absen_ajar::select('pertemuan', 'berita_acara', 'rangkuman', 'kd_lokal', 'file_ajar')
            ->where(['kd_mtk' => $request[0], 'kd_lokal' => $request[4]])->get();
        $w_cek = ['kd_lokal' => $request[4], 'kd_mtk' => $request[0], 'tgl_ajar_masuk' => date('Y-m-d')];
        $absen_keluar = app('App\Models\Absen_gabung')->cek_bap($w_cek)->first();
        // dd($absen_keluar);
        $mahasiswa = app('App\Models\Absen_gabung')->showMhs($request[4], $request[0]);
        $jml_mhs = app('App\Models\Absen_gabung')->jumlah_mhs($request[4], $request[0]);
        $jml_hadir = app('App\Models\Absen_gabung')->jml_hadir($request[4], $request[0], $request[8]);
        // dd($jml_hadir);
        $mhs_hadir = app('App\Models\Absen_gabung')->mhs_hadir($request[4], $request[0], $request[8]);
        $temu_ajar = app('App\Models\Absen_gabung')->temu_ajar($w_temu);
        $jadwal = app('App\Models\Absen_gabung')->jadwal_pengganti($w_jadwal, $request[4])->get();
        return view('admin.jadwal_pengganti.ajar_gabung', compact('mahasiswa', 'mhs_hadir', 'temu_ajar', 'jadwal', 'jml_mhs', 'jml_hadir', 'berita_acara', 'id', 'absen_keluar'));
    }

    public function ajar_teori_pengganti($id)
    {
        $request = explode(",", Crypt::decryptString($id));
        // dd($request);
        $w_jadwal = ['kd_mtk' => $request[0], 'kd_lokal' => $request[4], 'jam_t' => $request[6]];
        $w_pert = ['kd_mtk' => $request[0], 'kd_lokal' => $request[4]];
        $w_cek = ['kd_lokal' => $request[4], 'kd_mtk' => $request[0], 'tgl_ajar_masuk' => date('Y-m-d'), 'jam_t' => $request[6]];
        $w_showMhs = ['a.kd_lokal' => $request[4], 'd.tgl_ajar_masuk' => date('Y-m-d'), 'b.kd_mtk' => $request[0], 'd.jam_t' => $request[6]];
        $w_temu = ['kd_lokal' => $request[4], 'tgl_ajar_masuk' => date('Y-m-d'), 'kd_mtk' => $request[0], 'jam_t' => $request[6]];
        $berita_acara = Absen_ajar::select('pertemuan', 'berita_acara', 'rangkuman', 'kd_lokal', 'file_ajar')
            ->where($w_pert)->get();
        $absen_keluar = app('App\Models\Absen_ajar')->cek_bap($w_cek)->first();
        $mahasiswa = app('App\Models\Absen_ajar')->showMhs($w_showMhs);
        $jml_mhs = app('App\Models\Absen_ajar')->jumlah_mhs($w_showMhs);
        $jml_hadir = app('App\Models\Absen_ajar')->jml_hadir($request[4], $request[0], $request[8]);
        $mhs_hadir = app('App\Models\Absen_ajar')->mhs_hadir($request[4], $request[0], $request[8]);
        $temu_ajar = app('App\Models\Absen_ajar')->temu_ajar($w_temu);
        $jadwal = app('App\Models\Absen_ajar')->jadwal_pengganti($w_jadwal)->get();
        return view('admin.jadwal_pengganti.ajar_teori', compact('mahasiswa', 'mhs_hadir', 'temu_ajar', 'jadwal', 'jml_mhs', 'jml_hadir', 'berita_acara', 'id', 'absen_keluar'));
    }

    public function ajar_praktek_pengganti($id)
    {
        $request = explode(",", Crypt::decryptString($id));
        // dd($request);
        $w_jadwal = ['kd_mtk' => $request[0], 'kel_praktek' => $request[4], 'jam_t' => $request[6]];
        $w_cek = ['kel_praktek' => $request[4], 'kd_mtk' => $request[0], 'tgl_ajar_masuk' => date('Y-m-d'), 'jam_t' => $request[6]];
        $w_pert = ['kd_mtk' => $request[0], 'kel_praktek' => $request[4]];
        $w_showMhs = ['b.kel_praktek' => $request[4], 'd.tgl_ajar_masuk' => date('Y-m-d'), 'b.kd_mtk' => $request[0], 'd.jam_t' => $request[6]];
        $w_temu = ['kel_praktek' => $request[4], 'tgl_ajar_masuk' => date('Y-m-d'), 'kd_mtk' => $request[0], 'jam_t' => $request[6]];
        $berita_acara = Absen_ajar_praktek::select('pertemuan', 'berita_acara', 'rangkuman', 'kel_praktek', 'file_ajar')
            ->where($w_pert)->get();
        $absen_keluar = app('App\Models\Absen_ajar_praktek')->cek_bap($w_cek)->first();
        $mahasiswa = app('App\Models\Absen_ajar_praktek')->showMhs($w_showMhs);
        $jml_mhs = app('App\Models\Absen_ajar_praktek')->jumlah_mhs($w_showMhs);
        $jml_hadir = app('App\Models\Absen_ajar_praktek')->jml_hadir($request[4], $request[0], $request[8]);
        $mhs_hadir = app('App\Models\Absen_ajar_praktek')->mhs_hadir($request[4], $request[0], $request[8]);
        $temu_ajar = app('App\Models\Absen_ajar_praktek')->temu_ajar($w_temu);
        $jadwal = app('App\Models\Absen_ajar_praktek')->jadwal_pengganti($w_jadwal)->get();
        return view('admin.jadwal_pengganti.ajar_praktek', compact('mahasiswa', 'mhs_hadir', 'temu_ajar', 'jadwal', 'jml_mhs', 'jml_hadir', 'berita_acara', 'id', 'absen_keluar'));
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
            $cek_jam = app('App\Models\Absen_ajar')->cek_jam_keluar_pengganti($w_jam, $jam)->first();
            if (isset($cek_jam)) {
                Absen_ajar::where($w_cek)
                    ->update([
                        'tgl_ajar_keluar' => $tgl_keluar,
                        'jam_keluar' => $jam_keluar
                    ]);
                return redirect('/jadwal-pengganti')->with('status', 'Absen Keluar Mengajar');
            } else {
                return redirect('/ajar-teori-pengganti/' . $request->id)->with('error', 'Anda Tidak Dapat Melakukan Absen Keluar');
            }
        } else {
            return redirect('/ajar-teori-pengganti/' . $request->id)->with('error', 'Pokok Pembahasan Tidak Boleh Kosong');
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
            $cek_jam = app('App\Models\Absen_ajar_praktek')->cek_jam_keluar_pengganti($w_jam, $jam)->first();
            if (isset($cek_jam)) {
                Absen_ajar_praktek::where($w_cek)
                    ->update([
                        'tgl_ajar_keluar' => $tgl_keluar,
                        'jam_keluar' => $jam_keluar
                    ]);
                return redirect('/jadwal-pengganti')->with('status', 'Absen Keluar Mengajar');
            } else {
                return redirect('/ajar-praktek-pengganti/' . $request->id)->with('error', 'Anda Tidak Dapat Melakukan Absen Keluar');
            }
        } else {
            return redirect('/ajar-praktek-pengganti/' . $request->id)->with('error', 'Pokok Pembahasan Tidak Boleh Kosong');
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
            $cek_jam = app('App\Models\Absen_gabung')->cek_jam_keluar($w_jam, $jam)->first();
            if (isset($cek_jam)) {
                Absen_ajar::where($w_cek)
                    ->update([
                        'tgl_ajar_keluar' => $tgl_keluar,
                        'jam_keluar' => $jam_keluar
                    ]);
                return redirect('/jadwal')->with('status', 'Absen Keluar Mengajar');
            } else {
                return redirect('/ajar-gabung/' . $request->id)->with('error', 'Anda Tidak Dapat Melakukan Absen Keluar');
            }
        } else {
            return redirect('/ajar-gabung/' . $request->id)->with('error', 'Pokok Pembahasan Tidak Boleh Kosong');
        }
    }
}
