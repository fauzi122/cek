<?php

namespace App\Http\Controllers\administrasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserdosenController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:userdosen_adm.index|userdosen_adm.edit']);
        if (!$this->middleware('auth:sanctum')) {
            return redirect('/login');
        }
    }
    public function index()
    {
        $userdosen = User::where('utype', 'ADM')->get();
        // ->when(request()->q, function ($userdosen) {
        // $userdosen = $userdosen->where('username', 'like', '%' . request()->q . '%');
        // })->paginate(15);

        return view('administrasi.dosen.index', compact('userdosen'));
    }

    public function edit(User $user)
    {
        $roles = Role::where('id', '=', '')->get();
        return view('administrasi.dosen.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required'
        ]);

        $user = User::findOrFail($user->id);

        if ($request->input('password') == "") {
            $user->update([
                'name'      => $request->input('name'),
                'email'     => $request->input('email')

            ]);
        } else {
            $user->update([
                'name'      => $request->input('name'),
                'email'     => $request->input('email'),
                'password'  => bcrypt($request->input('password'))


            ]);
        }

        //assign role
        //$user->syncRoles($request->input('role'));

        if ($user) {
            //redirect dengan pesan sukses
            return redirect('/lecturer/users')->with('status', 'Data Berhasil Ditambah');
        } else {
            return redirect('/lecturer/users')->with('error', 'Gagal Ditambah');
        }
    }

    public function destroy(User $user)
    {
        $cek = User::where([
            'id'       => $user->id
        ])->first();
        User::destroy($user->id);
        return redirect('/user')->with('status', 'Data Berhasil Dihapus');
    }

    public function updateStatus(Request $request)
    {
        $product = User::find($request->id_dosen);
        $product->kondisi = $request->status;
        $product->save();
        return response()->json(['success' => 'Status change successfully.']);
    }
}
