<?php

namespace App\Http\Controllers\baak;

use App\Http\Controllers\Controller;

use App\Models\Userujian;
use App\Jobs\ImportJobtemu;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Imports\UserujianImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class UserujianController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:userujian.index |userujian.upload|userujian.hapus']);
        if (!$this->middleware('auth:sanctum')) {
            return redirect('/login');
        }
    }
    public function index()
    {
        $userujian = DB::table('users')
            ->rightjoin('user_ujian', 'users.email', 'user_ujian.email')
            ->select('users.kode as kode_user', 'users.username as no_induk', 'users.email AS email_user', 'user_ujian.*')
            ->get();

        $duplicate = Userujian::select('email', DB::raw('count(email) as count'))
            ->groupBy('email')
            ->havingRaw('count(email) > 1')
            ->first();


        return view('baak.userujian.index', compact('userujian', 'duplicate'));
    }

    public function datajson()
    {
        return Datatables::of(Userujian::get())->make(true);
    }

    public function storeData(Request $request)
    {
        //VALIDASI
        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file'); //GET FILE
            Excel::import(new UserujianImport, $file); //IMPORT FILE 
            return redirect()->back()->with(['success' => 'Upload success']);
        }
        return redirect()->back()->with(['error' => 'Please choose file before']);
    }
    public function tuserujian()
    {
        $temu = DB::select('call t_userujian');
        return redirect()->back()->with(['success' => 'success terhapus']);
    }
    public function singkronuser()
    {
        $temu = DB::select('call insert_userujian');
        return redirect()->back()->with(['success' => 'semua user ujian success di singkron ']);
    }
    public function destroy($id)
    {
        $userujian = Userujian::findOrFail($id);
        $userujian->delete();

        return redirect()->back()->with('success', 'Userujian berhasil dihapus');
    }
}
