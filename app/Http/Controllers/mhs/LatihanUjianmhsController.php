<?php

namespace App\Http\Controllers\mhs;

use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\DetailSoalEssay;
use App\Models\Distribusisoal;
use Illuminate\Http\Request;
use App\Models\Detailsoal;
use App\Models\Hasilujian;
use App\Models\JawabEsay;
use App\Models\Randomsoal;
use App\Models\Jawab;
use App\Models\Soal;
use App\Models\User;
// use App\Models\Session;
use PDF;

use Response;


class LatihanUjianmhsController extends Controller
{
  public function __construct()
  {
    if (!$this->middleware('auth:sanctum')) {
      return redirect('/login');
    }

    // $cek_sess = Randomsoal::where(['user_id'=>auth()->user()->id])->first();
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  function session()
  {
    return session_id();
  }
  public function index()
  {

    $pakets = app('App\Models\Hasilujian')->soals();
    $hasil_ujian = app('App\Models\Hasilujian')->hasil_ujian();
    return view('mhs.latihanujian.jadwal.index', compact('pakets', 'hasil_ujian'));
  }

  public function show($id)
  {
    // dd(request()->exec());
    $pecah = explode(',', Crypt::decryptString($id));
    $where = ['id_soal' => $pecah[0], 'id_user' => auth()->user()->username, 'kd_lokal' => auth()->user()->kode];

    $check_soal = Distribusisoal::where([
      'id_soal'          => $pecah[0]
    ])
      ->where('id_kelas', auth()->user()->kode)
      ->first();

    if ($check_soal) {

      $soal = Soal::with('detail_soal_essays')->where([
        'soals.id'          => $pecah[0],
        'soals.kd_mtk'      => $pecah[1]
      ])
        ->first();
      $cek = Detailsoal::where(['id_soal' => $pecah[0]])
        ->where('status', 'Y')
        ->skip(0)->take($soal->jml_soal)
        ->orderByRaw('RAND()')
        ->get();
      foreach ($cek as $acak) {
        $acak_nomer[] = $acak->id;
      }
      if ($cek == '[]') {
        return redirect('/exercise');
      }
      // echo json_encode($acak_nomer);die;
      $cek_rand = Randomsoal::where(['nim' => auth()->user()->username, 'id_soal' => $pecah[0]])->first();
      if (!isset($cek_rand)) {
        $Randomsoal = new Randomsoal;
        $Randomsoal->nim = auth()->user()->username;
        $Randomsoal->id_soal = $pecah[0];
        $Randomsoal->soal_acak =  json_encode($acak_nomer);
        $Randomsoal->save();
      }
      $no_rand = Randomsoal::where(['nim' => auth()->user()->username, 'id_soal' => $pecah[0]])->first();
      $randomx = preg_replace("/[^0-9, ]/", "", $no_rand->soal_acak);
      $myArray = explode(',', $randomx);
      $soals = Detailsoal::whereIn('id', $myArray)
        ->get();
      $cek_ujian = Hasilujian::where($where)->first();
      if ($cek_ujian == null) {
        $waktu = DATE("Y-m-d H:i:s");
        $Hasilujian = new Hasilujian;
        $Hasilujian->id_soal = $pecah[0];
        $Hasilujian->id_user = auth()->user()->username;
        $Hasilujian->kd_lokal = auth()->user()->kode;
        $Hasilujian->awal_ujian = $waktu;
        $Hasilujian->akhir_ujian = date('Y-m-d H:i:s', strtotime('+' . $soal->waktu . ' minutes', strtotime($waktu)));
        $Hasilujian->jml_soal =  $soal->jml_soal;
        // $Hasilujian->ipaddress =  $_SERVER['HTTP_X_FORWARDED_FOR'];
        $Hasilujian->save();
      }
      if ($cek_ujian != null) {
        if (STRTOTIME($cek_ujian->akhir_ujian) < STRTOTIME(DATE("Y-m-d H:i:s"))) {
          $jawab = Jawab::where(['id_soal' => $pecah[0], 'id_user' => auth()->user()->username, 'id_kelas' => auth()->user()->kode])
            ->where('score', '<>', 0)->count();
          Hasilujian::where($where)
            ->update([
              'sts' => '1',
              'soal_benar' => $jawab
            ]);
          return redirect('/exercise')->with(['success' => 'Waktu Anda Telah Habis']);
        } elseif ($cek_ujian->sts == '0' || $cek_ujian->sts == '1') {
          return redirect('/selesai-ujian/' . $id);
        }
      }
      $hasil_ujian = Hasilujian::where([
        'id_soal' => $pecah[0]
      ])
        ->where('kd_lokal', auth()->user()->kode)
        ->where('id_user', auth()->user()->username)
        ->first();
      return view('mhs.latihanujian.jadwal.show', compact('soal', 'id', 'soals', 'hasil_ujian'));
    } else {
      return redirect('/user/dashboard');
    }
  }

  public function detailUjian($id)
  {
    $pecah = explode(',', Crypt::decryptString($id));
    //dd($pecah);
    $check_soal = Distribusisoal::where([
      'id_soal' => $pecah[0]
    ])
      ->where('id_kelas', auth()->user()->id_kelas)->first();
    if ($check_soal) {
      $soal = Soal::with('detail_soal_essays')->where(['id' => $pecah[0]])->first();
      $soals = Detailsoal::where(['id_soal' => $pecah[0]])->where('status', 'Y')->get();
      return view('halaman-siswa.detail_ujian', compact('soal', 'soals', 'id'));
    } else {
      return redirect('/home');
    }
  }

  public function getSoal(Request $request)
  {
    $waktu = DATE("Y-m-d H:i:s");
    $no_urut = $request->no_urut;

    $soal = Detailsoal::find($request->id_soal);

    $where = ['id_soal' => $soal->id_soal, 'id_user' => auth()->user()->username, 'kd_lokal' => auth()->user()->kode];
    $hasil_ujian = Hasilujian::where($where)->first();
    $cek_soal = Soal::where('id', $soal->id_soal)->first();
    $jml_jawab = Jawab::where(['id_soal' => $soal->id_soal, 'id_user' => auth()->user()->username])->count();
    $soals = Detailsoal::where(['id_soal' => $soal->id_soal])
      ->where('status', 'Y')
      ->get();
    if (STRTOTIME($hasil_ujian->akhir_ujian) < STRTOTIME(DATE("Y-m-d H:i:s"))) {
      Hasilujian::where($where)
        ->update([
          'sts' => '1'
        ]);
      return response()->json(['success' => true, 'html' => "aktu habis"]);
    } else {
      if ($hasil_ujian == null) {
        Hasilujian::where($where)
          ->update([
            'awal_ujian' => $waktu,
            'akhir_ujian' => date('Y-m-d H:i:s', strtotime('+' . $cek_soal->waktu . ' minutes', strtotime($waktu))),
          ]);
      }
    }

    $html = view('mhs.latihanujian.jadwal.soal')->with(compact('soal', 'hasil_ujian', 'cek_soal', 'soals', 'no_urut', 'jml_jawab'))->render();
    return response()->json(['success' => true, 'html' => $html]);
  }

  public function jawab(Request $request)
  {
    $get_jawab = explode('/', $request->get_jawab);
    $pilihan = $get_jawab[0];
    $id_detail_soal = $get_jawab[1];
    $id_siswa = $get_jawab[2];
    $detail_soal = Detailsoal::find($id_detail_soal);

    $jawab = Jawab::where('no_soal_id', $id_detail_soal)->where('id_user', auth()->user()->username)->first();
    if (!$jawab) {
      $jawab = new Jawab;
      $jawab->revisi = 0;
    } else {
      $jawab->revisi = $jawab->revisi + 1;
    }

    $jawab->no_soal_id = $id_detail_soal;
    $jawab->id_soal = $detail_soal->id_soal;
    $jawab->id_user = auth()->user()->username;
    $jawab->id_kelas = auth()->user()->kode;
    $jawab->nama = auth()->user()->name;
    $jawab->pilihan = $pilihan;

    $check_jawaban = Detailsoal::where('id', $id_detail_soal)->where('kunci', $pilihan)->first();
    if ($check_jawaban) {
      $jawab->score = $detail_soal->score;
    } else {
      $jawab->score = 0;
    }
    $jawab->status = 0;
    // return response()->json(['success'=>$jawab->save()]); 
    $jawab->save();
    $jml_jawab = Jawab::where(['id_soal' => $detail_soal->id_soal, 'id_user' => auth()->user()->username])->count();
    $hasil_ujian = Hasilujian::where(['id_soal' => $detail_soal->id_soal, 'id_user' => auth()->user()->username])->first();
    if ($jml_jawab == $hasil_ujian->jml_soal) {
      // return response()->json(['success'=>"ada2"]); 

      return 2;
    } else {
      // return response()->json(['success'=>"ada1"]); 

      return 1;
    }
  }

  public function kirimJawaban(Request $request)
  {
    Jawab::where('id_soal', $request->id_soal)->where('id_user', auth()->user()->id)->update(['status' => 1]);
  }

  public function finishUjian($id)
  {
    $soal = Soal::find($id);
    $nilai = Jawab::where('id_soal', $id)->where('id_user', auth()->user()->id)->sum('score');
    return view('halaman-siswa.finish', compact('soal', 'nilai'));
  }

  public function delete()
  {
    return view('siswa.delete');
  }

  public function getBtnDelete($password)
  {
    $validate_admin = User::where('email', auth()->user()->email)->first();
    if ($validate_admin && Hash::check($password, $validate_admin->password)) {
      $cocok = 'Y';
    } else {
      $cocok = 'N';
    }
    return view('siswa.tombol_hapus', compact('cocok'));
  }

  public function deleteAll()
  {
    $users = User::where('status', 'S')->get();
    foreach ($users as $key => $value) {
      $jawab = Jawab::where('id_user', $value->id)->first();
      if ($jawab) {
        $jawab->delete();
      }
    }
    User::where('status', 'S')->delete();
  }

  public function getDetailEssay(Request $request)
  {
    $soal_essay = DetailSoalEssay::with('userJawab')->find($request->id_soal_esay);
    $no_urut = $request->no_urut;
    $hasil_ujian = Hasilujian::where([
      'id_soal'          => $soal_essay->id_soal
    ])
      ->where('kd_lokal', auth()->user()->kode)
      ->where('id_user', auth()->user()->username)
      ->first();
    // return response()->json(['success'=>$soal_essay]); 
    $html = view('mhs.latihanujian.jadwal.essaysoal')->with(compact('soal_essay', 'no_urut', 'hasil_ujian'))->render();
    return response()->json(['success' => true, 'html' => $html]);
    // return view('halaman-siswa.essaysoal', compact('soal_essay'));
  }

  public function simpanJawabanEssay(Request $request)
  {
    // return response()->json(['success'=>$request->jawab_essay]); 
    if ($request->jawab_essay == '' || $request->jawab_essay == null) {
      return '';
    }
    $check_jawaban = JawabEsay::where('id_user', auth()->user()->username)->where('id_detail_soal_esay', $request->id_soal_esay)->first();
    if (!$check_jawaban) {
      $save = new JawabEsay;
      $save->id_detail_soal_esay = $request->id_soal_esay;
      $save->id_soal = $request->id_soal;
      $save->id_user = auth()->user()->username;
      $save->id_kelas = auth()->user()->kode;
    } else {
      $save = $check_jawaban;
    }
    $save->jawab = $request->jawab_essay;
    if ($save->save()) {
      return 1;
    }
  }

  function selesai_ujian($id)
  {
    $pecah = explode(',', Crypt::decryptString($id));
    // dd($pecah);
    $waktu = DATE("Y-m-d H:i:s");
    $where1 = ['id_soal' => $pecah[0], 'id_user' => auth()->user()->username, 'id_kelas' => auth()->user()->kode];
    $where2 = ['id_soal' => $pecah[0], 'id_user' => auth()->user()->username, 'kd_lokal' => auth()->user()->kode];
    $jawab = Jawab::where($where1)
      ->where('score', '<>', 0)->count();
    Hasilujian::where($where2)
      ->update([
        'sts' => '0',
        'selesai_ujian' => $waktu,
        'soal_benar' => $jawab
      ]);
    return redirect('/exercise');
  }

  function cetak_pdf($id)
  {
    $pecah = explode(',', Crypt::decryptString($id));

    $soals = DB::table('jawabs as a')
      ->join('detailsoals as b', 'a.no_soal_id', '=', 'b.id')
      ->where('a.id_user', auth()->user()->username)
      ->where('a.id_soal', $pecah[0])
      ->get();
    $user = DB::table('users as a')
      ->select('b.id_user', 'a.name', 'c.tgl_ujian', 'c.tgl_selsai_ujian', 'c.jml_soal', 'd.nm_mtk', 'b.awal_ujian', 'b.akhir_ujian', 'b.selesai_ujian', 'b.soal_benar', 'd.kd_mtk')
      ->join('hasilujians as b', 'a.username', '=', 'b.id_user')
      ->join('soals as c', 'b.id_soal', '=', 'c.id')
      ->join('mtk_ujians as d', 'c.kd_mtk', '=', 'd.kd_mtk')
      ->where('b.id_user', auth()->user()->username)
      ->where('b.id_soal', $pecah[0])
      ->first();
    //  return view('mhs.latihanujian.jadwal.cetakujian_pdf', compact('soals','user'));
    //  $pecah=explode(',',Crypt::decryptString($id));
    $pdf = PDF::loadView('mhs.latihanujian.jadwal.cetakujian_pdf', ['soals' => $soals, 'user' => $user])->setOptions(['defaultFont' => 'sans-serif', 'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true, 'isPhpEnabled' => true]);
    // return $pdf->stream();
    return $pdf->download('Bukti Ujian ' . $user->id_user . ' (' . $user->kd_mtk . ')' . '.pdf');
  }
}
