<?php

namespace App\Http\Controllers\adminbti;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;

class AkunstaffController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:addakun.index |addakun.create|addakun.edit|addakun.update']);
        if (!$this->middleware('auth:sanctum')) {
            return redirect('/login');
        }
    }
    public function index()
    {
        // $akunstaff = User::where('utype', 'ADM')
        //     ->orderBy('username', 'desc')
        //     ->get();
            $usermhs = User::where('utype', 'ADM')->whereNotIn('kode', ['AAU', 'mmz'])
            ->when(request()->q, function ($usermhs) {
                $usermhs = $usermhs->where('username', 'like', '%' . request()->q . '%');
            })->paginate(15);
            // dd($akunstaff);
        return view('adminbti.userstaff.listakun', compact('usermhs'));
    }

    public function search(Request $request)
    {
        $username = $request->input('username');
        $kode = $request->input('kode');
    
        // Start the query with basic conditions
        $query = User::where('utype', 'ADM')
                     ->whereNotIn('kode', ['AAU', 'mmz']);
    
        // Apply conditions based on the input
        if ($username) {
            $query->where(function ($q) use ($username, $kode) {
                $q->where('username', $username);
    
                if ($kode) {
                    // Use 'orWhere' only within this closure to ensure it only applies if username is also provided
                    $q->orWhere('kode', $kode);
                }
            });
        } elseif ($kode) {
            // If there is no username provided, just filter by 'kode'
            $query->where('kode', $kode);
        }
    
        // Execute the query
        $users = $query->get();
    
        // Return the view with the users
        return view('adminbti.userstaff.cari', compact('users'));
    }
    

    public function create()
    {

        return view('adminbti.userstaff.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [

            'name'          => 'required',
            'username'      => 'required|numeric|unique:users,username',
            'kode'          => 'required',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required'
        ]);

        $adduser = User::create([

            'name'          => $request->input('name'),
            'username'      => $request->input('username'),
            'kode'          => $request->input('kode'),
            'email'         => $request->input('email'),
            'password'      => bcrypt($request->input('password')),
            'utype'         => ('ADM')
        ]);

        if ($adduser) {
            return redirect('/lecturer-data')->with('status', 'Data Ditambah');
        } else {
            return redirect('/lecturer-data')->with('error', 'Gagal Ditambah');
        }
    }

    public function edit(User $user)
    {
        return view('adminbti.userstaff.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name'           => 'required',
            'username'       => 'required',
            'kode'           => 'required',
            'email'          => 'required'
        ]);

        $user = User::findOrFail($user->id);

        if ($request->input('password') == "") {
            $user->update([
                'name'           => $request->input('name'),
                'username'       => $request->input('username'),
                'kode'           => $request->input('kode'),
                'email'          => $request->input('email')

            ]);
        } else {
            $user->update([
                'name'          => $request->input('name'),
                'username'      => $request->input('username'),
                'kode'          => $request->input('kode'),
                'email'         => $request->input('email'),
                'password'      => bcrypt($request->input('password'))


            ]);
        }

        if ($user) {
            //redirect dengan pesan sukses
            return redirect('/lecturer-data')->with('status', 'Data Berhasil Ditambah');
        } else {
            return redirect('/lecturer-data')->with('error', 'Gagal Ditambah');
        }
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
