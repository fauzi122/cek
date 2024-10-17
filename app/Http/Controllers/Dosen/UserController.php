<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use app\Models\User;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:users.index|users.create|users.edit|users.delete']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
               // Ambil semua user dengan tipe 'ADM', kecuali 'pkbn' dan 'AAU', dan muat data role mereka sekaligus
               $users = User::where('utype', 'ADM')
               ->whereNotIn('kode', ['pkbn','AAU'])
               ->with('roles') // Eager load roles
               ->get();

        return view('admin.user.index', compact('users'));
    }


    public function staffjson()
	{
		return Datatables::of(User::where('utype', 'ADM'))->make(true);
	}


    public function mhsuser()
    {   
        return view('admin.user.mhsuser');
    }

    public function jsonusermhs()
	{
		return Datatables::of(User::where('utype', 'MHS'))->make(true);
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $roles = Role::latest()->get();
        $roles = Role::where('id','<>','1')->get();
        return view('admin.user.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   
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
    public function edit(User $user)
    {
        $roles = Role::where('id','<>','1')->get();
        return view('admin.user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        $user->syncRoles($request->input('role'));

        if ($user) {
            //redirect dengan pesan sukses
            return redirect('/user')->with('status','Data Berhasil Ditambah');
        }
            else{
                return redirect('/user')->with('error','Gagal Ditambah');
            }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $cek= User::where([
            'id'       =>$user->id
            ])->first();
        User::destroy($user->id);
        return redirect('/user')->with('status','Data Berhasil Dihapus');
  
    }
}
