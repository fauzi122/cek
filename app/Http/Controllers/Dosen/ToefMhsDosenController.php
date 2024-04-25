<?php

namespace App\Http\Controllers\Dosen;

use App\Imports\DatamhstoefImport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Toef_mhs;
use App\Models\Toef_dosen;

class ToefMhsDosenController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['permission:toef.tambah.mhs |toef.edit.hapus.mhs']);
        if (!$this->middleware('auth:sanctum')) {
            return redirect('/login');
        }
    }

    public function index_mhs()
    {
        $usermhs = DB::table('toef_mhs')
            ->when(request()->q, function ($usermhs) {
                $usermhs = $usermhs->where('nim', 'like', '%' . request()->q . '%');
            })->paginate(15);

        return view('admin.toef.mhs.index', compact('usermhs'));
    }

    public function create()
    {
        return view('admin.toef.mhs.create');
    }

    public function index_dosen()
    {
        $dosen = DB::table('toef_dosen')->get();
        return view('admin.toef.dosen.index', compact('dosen'));
    }

    public function store_mhs(Request $request)
    {
        $data = $request->validate([
            'nim'       => 'required',
            'nama'      => 'required',
            'kd_lokal'  => 'required',
            'kd_mtk'    => 'required',
            'kd_dosen'  => 'required',
        ]);

        $record = new Toef_mhs();
        $record->nim        = $data['nim'];
        $record->nama       = $data['nama'];
        $record->kd_lokal   = $data['kd_lokal'];
        $record->kd_mtk     = $data['kd_mtk'];
        $record->kd_dosen   = $data['kd_dosen'];
        $record->petugas    = Auth::user()->email;
        $record->save();

        if ($data) {
            return redirect('/list-toef-mhs')->with('status', 'Data Ditambah');
        } else {
            return redirect('/list-toef-mhs')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function storeData_mhs(Request $request)
    {
        // Validasi
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        if ($request->hasFile('file')) {
            $set = ['petugas' => Auth::user()->email,];
            $file = $request->file('file'); // Dapatkan file

            Excel::import(new DatamhstoefImport($set), $file); // Impor file

            return redirect()->back()->with('success', 'Upload Data Mahasiswa Berhasil');
        }

        return redirect()->back()->with('error', 'Please choose a file before uploading');
    }


    public function edit_mhs($id)
    {
        $data = Toef_mhs::findOrFail($id);
        return view('admin.toef.mhs.editmhs', compact('data'));
    }

    public function update_mhs(Request $request, $id)
    {
        $data = $request->validate([
            'nim' => 'required',
            'nama' => 'required',
            'kd_lokal' => 'required',
            'kd_mtk' => 'required',
            'kd_dosen' => 'required',
        ]);

        $record = Toef_mhs::findOrFail($id);
        $record->nim = $data['nim'];
        $record->nama = $data['nama'];
        $record->kd_lokal = $data['kd_lokal'];
        $record->kd_mtk = $data['kd_mtk'];
        $record->kd_dosen = $data['kd_dosen'];
        $record->save();

        if ($data) {
            return redirect('/list-toef-mhs')->with('status', 'Data Ditambah');
        } else {
            return redirect('/list-toef-mhs')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function destroy_mhs($id)
    {
        $record = Toef_mhs::findOrFail($id);
        $record->delete();
        return redirect()->back()->with(['success' => 'Berhasil di Hapus']);
    }
    public function removeAll()
    {
        // Menghapus semua data mahasiswa
        Toef_mhs::truncate();

        // Redirect ke halaman list mahasiswa
        return redirect('/list-toef-mhs')->with('status', 'Semua data mahasiswa berhasil dihapus');
    }
}
