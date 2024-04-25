<?php

namespace App\Http\Controllers\ujian\uts;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Panitia_ujian;
use App\Models\User;


class PanitiaujianController extends Controller
{
    public function __construct()
    {
        if (!$this->middleware('auth:sanctum')) {
            return redirect('/login');
        }
    }

    public function index()
    {

        $panitia = Panitia_ujian::join('users', 'panitia_ujians.kode', '=', 'users.kode')
            ->select('users.name', 'users.id', 'users.username', 'panitia_ujians.*')
            ->get();

        return view('admin.ujian.uts.baak.panitia.index', compact('panitia'));
    }
    public function create()
    {
        $roles = Role::where('id', '<>', '1')->get();
        $user = User::where('utype', '<>', 'MHS')->get();
        return view('admin.ujian.uts.baak.panitia.create', compact('user', 'roles'));
    }

    // administrasi
    public function index_adm()
    {
        $panitia_adm = DB::table('panitia_ujians')
            ->join('users', 'panitia_ujians.kode', '=', 'users.kode')
            ->select('users.name', 'users.username', 'panitia_ujians.*')
            ->where(
                'panitia_ujians.petugas',
                Auth::user()->username
            )

            ->get();

        return view('admin.ujian.uts.adm.panitia.index', compact('panitia_adm'));
    }

    public function create_adm()
    {
        $user = DB::table('karyawanbs1')
                ->whereIn('dept', ['BSI2', 'BSI3'])
                ->where('status_kry', '1')
                ->get();
                $kampus = DB::table('kampus')->get();
        return view('admin.ujian.uts.adm.panitia.create', compact('user','kampus'));
    }

    public function store_adm(Request $request)
    {
        $this->validate($request, [
            'kode'         => 'required|unique:panitia_ujians,kode',
            'jenis'        => 'required',
            'kampus'       => 'required',

        ]);

        $panitia_adm = Panitia_ujian::create([
            'kode'       => $request->input('kode'),
            'jenis'      => $request->input('jenis'),
            'kampus'     => $request->input('kampus'),
            'petugas'    => Auth::user()->username,

        ]);

        if ($panitia_adm) {
            //redirect dengan pesan sukses          
            return redirect('/adm-panitia-uji')->with('status', 'Data Berhasil Ditambah');
        } else {
            //redirect dengan pesan error
            return redirect('/adm-panitia-uji')->with('error', 'Data Gagal Ditambah');
        }
    }

    public function destroy($id)
    {

        Panitia_ujian::find($id)->delete();
        return redirect('/adm-panitia-uji')->with('status', 'Data Berhasil Dihapus');
    }
}
