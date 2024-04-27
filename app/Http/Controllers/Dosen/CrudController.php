<?php

namespace App\Http\Controllers\Dosen;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Image;

use Session;
use App\User;
use App\Models\Materi;
use App\Models\Distribusisoal;
use App\Models\School;
use App\Models\Kelas;
use App\Models\Aktifitas;
use App\Models\Jawab;
use App\Imports\UserImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;


class CrudController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function updateProfil(Request $request)
  {
    if ($request->nama == "") {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Nama tidak boleh kosong.";
    } elseif ($request->jk == "") {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Jenis kelamin tidak boleh kosong.";
    } elseif ($request->email == "") {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Email tidak boleh kosong.";
    } elseif (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Email tidak valid.";
    } else {
      $cek_email = User::where('id', '!=', auth()->user()->id)->where('email', $request->email)->first();
      if ($cek_email != "") {
        return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Email sudah terdaftar, silahkan ganti dengan yang lain.";
      } else {
        $query = User::where('id', $request->id)->first();
        if ($query != "") {
          $query->nama = $request->nama;
          $query->no_induk = $request->no_induk;
          $query->jk = $request->jk;
          $cek_email = User::where('email', $request->email)->where('id', '!=', $request->id)->first();
          if ($cek_email == "") {
            $query->email = $request->email;
          }
          if ($request->password != "") {
            $query->password = bcrypt($request->password);
          }
          $query->save();
        }
        return 'ok';
      }
    }
  }
  public function simpanMateri(Request $request)
  {
    // return $request->judul;
    if ($request->kode == "") {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Kode tidak boleh kosong.";
    } elseif ($request->judul == "") {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Judul tidak boleh kosong.";
    } elseif ($request->status == "") {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Status tampil materi tidak boleh kosong.";
    } else {
      $cek = Materi::where('sesi', $request->sesi)->first();
      if ($cek == "") {
        $query          = new Materi;
        $query->id_user = auth()->user()->id;
        $query->sesi    = $request->sesi;
      } else {
        $query = Materi::where('sesi', $request->sesi)->first();
      }
      $query->id      = $request->kode;
      $query->judul   = $request->judul;
      $query->status  = $request->status;
      $query->save();
      return 'ok';
    }
  }

  public function terbitSoal(Request $request)
  {
    $cek = Distribusisoal::where('id_soal', $request->id_soal)->where('id_kelas', $request->id_kelas)->first();
    if ($cek != "") {
      Distribusisoal::where('id_soal', $request->id_soal)->where('id_kelas', $request->id_kelas)->delete();
      return 'N';
    } else {
      $query = new Distribusisoal;
      $query->id_soal = $request->id_soal;
      $query->id_kelas = $request->id_kelas;
      $query->save();
      return 'Y';
    }
  }



  public function updateSiswa(Request $request)
  {
    // dd($request->all());
    if ($request->id == 'N') {
      $query = new User;
      $query->password = bcrypt(123456);
    } else {
      $query = User::where('id', $request->id)->first();
      if ($request->password != '') {
        $query->password = bcrypt($request->password);
      }
    }
    $query->id_kelas = $request->kelas;
    $query->nama = $request->nama;
    $query->no_induk = $request->no_induk;
    // $query->nisn = $request->nisn;
    $query->jk = $request->jk;
    $query->email = $request->email;
    $query->save();
    return 'ok';
  }


  public function simpanKelas(Request $request)
  {
    if (!$request->nama) {
      return 'Nama kelas tidak boleh kosong';
    }
    if ($request->id == 'N') {
      $query = new Kelas;
    } else {
      $query = Kelas::find($request->id);
    }
    $query->id_wali = $request->id_wali;
    $query->nama = $request->nama;
    if ($query->save()) {
      return 1;
    }
  }

  public function deleteKelas(Request $request)
  {
    User::where('id_kelas', $request->id_kelas)->update(['id_kelas' => '']);
    Kelas::find($request->id_kelas)->delete();
    return 1;
  }

  public function deleteGuru(Request $request)
  {
    User::where('id', $request->id_guru)->delete();
    return 1;
  }

  public function deleteSiswa(Request $request)
  {
    User::where('id', $request->id_siswa)->delete();
    return 1;
  }

  public function simpanSiswa(Request $request)
  {
    if ($request->nama == "") {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Nama tidak boleh kosong.";
    } elseif ($request->id_kelas == "") {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Kelas tidak boleh kosong.";
    } elseif ($request->no_induk == "") {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> NIS tidak boleh kosong.";
    } elseif ($request->jk == "") {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Jenis kelamin tidak boleh kosong.";
    } elseif ($request->email == "") {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Email tidak boleh kosong.";
    } elseif (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
      return "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> Email tidak valid.";
    }

    $query = new User;
    $query->id_kelas = $request->id_kelas;
    $query->nama = $request->nama;
    $query->no_induk = $request->no_induk;
    // $query->nisn = $request->nisn;
    $query->jk = $request->jk;
    $query->status = 'S';
    $query->status_sekolah = 'Y';
    $query->email = $request->email;
    $query->password = bcrypt(123456);
    $query->save();
    return 1;
  }

  public function import_excel(Request $request)
  {
    if (auth()->user()->status == 'G' or auth()->user()->status == 'A') {
      $user = User::where('id', auth()->user()->id)->first();
      // validasi
      $this->validate($request, [
        'file' => 'required|mimes:csv,xls,xlsx'
      ]);

      // menangkap file excel
      $file = $request->file('file');

      // membuat nama file unik
      $nama_file = rand() . $file->getClientOriginalName();

      // upload ke folder file_siswa di dalam folder public
      $file->move('file_siswa', $nama_file);

      // import data
      Excel::import(new UserImport, public_path('/file_siswa/' . $nama_file));

      // notifikasi dengan session
      Session::flash('sukses', 'Data Siswa Berhasil Diimport!');

      // alihkan halaman kembali
      return redirect('/master/siswa', compact('user'));
    } else {
      return redirect('/home');
    }
  }



  public function update_profil(Request $request, User $user)
  {
    $this->validate($request, [
      'nama'   => 'required'

    ]);

    if ($request->file('gambar') == "") {

      $user = User::findOrFail($user->id);
      $user->update([
        'nama'        => $request->input('nama')

      ]);
    } else {

      //remove old gambar
      Storage::disk('local')->delete('public/guru/' . $user->gambar);

      //upload new gambar
      $gambar = $request->file('gambar');
      $gambar->storeAs('public/guru', $gambar->hashName());

      $user = User::findOrFail($user->id);
      $user->update([
        'nama'        => $request->input('nama'),
        'gambar'       => $gambar->hashName()


      ]);
    }

    if ($user) {
      //redirect dengan pesan sukses
      return redirect('/pengaturan')->with(['success' => 'Data Berhasil Diupdate!']);
    } else {
      //redirect dengan pesan error
      return redirect('/pengaturan')->with(['error' => 'Data Gagal Diupdate!']);
    }
  }

  public function updateGuru(Request $request)
  {
    // dd($request->all());
    if ($request->id == 'N') {
      $query = new User;
      $query->password = bcrypt(123456);
    } else {
      $query = User::where('id', $request->id)->first();
      if ($request->password != '') {
        $query->password = bcrypt($request->password);
      }
    }
    $query->nama = $request->nama;
    $query->no_induk = $request->no_induk;
    $query->jk = $request->jk;
    $query->email = $request->email;
    $query->save();
    return 'ok';
  }

  public function resetUjian(Request $request)
  {
    $jawab = Jawab::findorfail($request->id_ujian);
    Jawab::where('id_soal', $jawab->id_soal)
      ->where('id_user', $jawab->id_user)
      ->where('id_kelas', $jawab->id_kelas)
      ->delete();
    $siswa = User::findorfail($jawab->id_user);
    $aktifitas = new Aktifitas;
    $aktifitas->id_user = auth()->user()->id;
    $aktifitas->nama = 'Mereset data nilai siswa atas nama: ' . $siswa->nama;
    $aktifitas->save();
  }
}
