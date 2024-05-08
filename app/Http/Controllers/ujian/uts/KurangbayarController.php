<?php

namespace App\Http\Controllers\ujian\uts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class KurangbayarController extends Controller
{
    public function __construct()
    {
       $this->middleware(['permission:ujian_mhs_kurang_bayar']);
       if(!$this->middleware('auth:sanctum')){
        return redirect('/login');
    }
    }

    public function index()
    {

    if (Auth::user()->utype == 'ADM') {

        $mhs = user::join('ujian_kurang_bayar', 'users.username', '=', 'ujian_kurang_bayar.nim')
        ->select('users.name','ujian_kurang_bayar.*')
        ->get();
    
        return view('admin.ujian.uts.baak.kurang_bayar.index', compact('mhs'));
        } else {
            return redirect('/dashboard');
        }
    }
}
