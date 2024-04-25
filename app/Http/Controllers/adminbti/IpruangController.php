<?php

namespace App\Http\Controllers\adminbti;

use App\Http\Controllers\Controller;

use App\Models\Ip_ruang;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;

class IpruangController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:ip_ruang.index |ip_ruang.create|ip_ruang.edit|ip_ruang.update']);
        if (!$this->middleware('auth:sanctum')) {
            return redirect('/login');
        }
    }
    public function index()
    {
        $ipruang = Ip_ruang::get();
        // dd($ipruang);
        return view('adminbti.ipruang.index', compact('ipruang'));
    }

    public function create()
    {

        return view('adminbti.ipruang.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'no_ruang'      => 'required|unique:ip_ruang,no_ruang',
        ]);

        $adduser = Ip_ruang::create([
           
            'no_ruang'       => $request->input('no_ruang'),
            'kapasitas'      => $request->input('kapasitas'),
            'kondisi'        => 1,
            'updater'        => Auth::user()->username
        ]);

        if ($adduser) {
            return redirect('/ip-ruang')->with('status', 'Data Ditambah');
        } else {
            return redirect('/ip-ruang')->with('error', 'Gagal Ditambah');
        }
    }

    public function edit($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        $editip = Ip_ruang::where([
            'no_ruang'   => $pecah[0]
        ])->first();
        return view('adminbti.ipruang.edit', compact('editip', 'id'));
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'no_ruang'         => 'required',
            'kondisi'          => 'required'
        ]);

        if ($request->file('ket') == "") {

            $id = Ip_ruang::where('no_ruang', $id);
            $id->update([
                'no_ruang'          => $request->input('no_ruang'),
                'kapasitas'         => $request->input('kapasitas'),
                'network_id'        => $request->input('network_id'),
                'ip_address'        => $request->input('ip_address'),
                'ip_address_2'      => $request->input('ip_address_2'),
                'updater'           => $request->input('updater'),
                'kondisi'           => $request->input('kondisi')

            ]);
        } else {

            $id = Ip_ruang::where('no_ruang', $id);
            $id->update([
                'no_ruang'          => $request->input('no_ruang'),
                'kapasitas'         => $request->input('kapasitas'),
                'network_id'        => $request->input('network_id'),
                'ip_address'        => $request->input('ip_address'),
                'ip_address_2'      => $request->input('ip_address_2'),
                'updater'           => $request->input('updater'),
                'kondisi'           => $request->input('kondisi')


            ]);
        }

        if ($id) {
            //redirect dengan pesan sukses
            return redirect('/ip-ruang')->with('status', 'Data Diupdate');
        } else {
            return redirect('/ip-ruang')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
}
