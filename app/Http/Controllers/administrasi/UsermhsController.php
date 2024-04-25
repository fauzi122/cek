<?php

namespace App\Http\Controllers\administrasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UsermhsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:usermhs.index|usermhs.edit']);
        if (!$this->middleware('auth:sanctum')) {
            return redirect('/login');
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usermhs = User::where('utype', 'MHS')
            ->when(request()->q, function ($usermhs) {
                $usermhs = $usermhs->where('username', 'like', '%' . request()->q . '%');
            })->paginate(15);
        //dd($usermhs);
        return view('administrasi.mhs.index', compact('usermhs'));
    }
    public function index_baak()
    {
        $usermhs = User::where('utype', 'MHS')
            ->when(request()->q, function ($usermhs) {
                $usermhs = $usermhs->where('username', 'like', '%' . request()->q . '%');
            })->paginate(15);
        //dd($usermhs);
        return view('baak.mhs.index_mhs', compact('usermhs'));
    }

    public function search(Request $request)
    {
        $username = $request->input('username');
        $kode = $request->input('kode');
    
        $users = User::where('utype', 'MHS');
    
        if ($username) {
            $users->where('username', $username);
        }
    
        if ($kode) {
            if ($username) {
                $users->orWhere('kode', $kode);
            } else {
                $users->where('kode', $kode);
            }
        }
    
        $users = $users->get();
    
        return view('baak.mhs.cari', compact('users'));
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
    public function store(Request $request)
    {
        //
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
    public function edit(User $user)
    {
        $roles = Role::where('id', '=', '')->get();
        return view('administrasi.mhs.edit', compact('user', 'roles'));
    }
    public function edit_baak(User $user)
    {
        $roles = Role::where('id', '=', '')->get();
        return view('baak.mhs.edit', compact('user', 'roles'));
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
        //$user->syncRoles($request->input('role'));

        if ($user) {
            //redirect dengan pesan sukses
            return redirect('/std/users')->with('status', 'Data Berhasil Ditambah');
        } else {
            return redirect('/std/users')->with('error', 'Gagal Ditambah');
        }
    }
    public function update_baak(Request $request, User $user)
    {
        $this->validate($request, [
            'username'  => 'required',
            'name'      => 'required',
            'kode'      => 'required',
            'email'     => 'required'
        ]);
        // dd($request->input('kode'));
        $user = User::findOrFail($user->id);

        if ($request->input('password') == "") {
            $user->update([
                'username'  => $request->input('username'),
                'name'      => $request->input('name'),
                'email'     => $request->input('email'),
                'kode'      => $request->input('kode')

            ]);
        } else {
            $user->update([
                'username'  => $request->input('username'),
                'name'      => $request->input('name'),
                'email'     => $request->input('email'),
                'kode'      => $request->input('kode'),
                'password'  => bcrypt($request->input('password'))


            ]);
        }

        //assign role
        //$user->syncRoles($request->input('role'));

        if ($user) {
            //redirect dengan pesan sukses
            return redirect('/std/users/baak')->with('status', 'Data Berhasil Ditambah');
        } else {
            return redirect('/std/users/baak')->with('error', 'Gagal Ditambah');
        }
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

    public function password_res(Request $request)
    {
    //   return response()->json(['success'=>$request->id_user]);
      $user=User::where('id', $request->id_user)
      ->where('name', $request->name)->first();
      if ($request->status=='1') {
        $user->two_password = $user->password;
        $user->password = '$2y$10$ZvFYk2KBIO0JIfsCd2StEeusT98qLmoXTdCE8y0X/BrZlfB94buiq';
        $user->save();
        return response()->json(['success' =>   'Oke 1']);
    }else{
        $user->password = $user->two_password;
        $user->two_password = null;
        $user->save();
        return response()->json(['success' =>   'Oke 2']);
    } 
        # code...
    }
}
