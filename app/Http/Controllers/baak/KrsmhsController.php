<?php

namespace App\Http\Controllers\baak;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PenilaianBaak;
use Illuminate\Support\Facades\DB;


class KrsmhsController extends Controller
{
    public function __construct()
    {
      $this->middleware(['permission:krsmhs_baak.index']);
       if(!$this->middleware('auth:sanctum')){
        return redirect('/login');
        }
    }
    public function index()
    {
        $penilaian=PenilaianBaak::first();
        $krsmhs = DB::table('penilaian')
        ->when(request()->q, function ($krsmhs) {
        $krsmhs = $krsmhs->where('nim', 'like', '%' . request()->q . '%');
        })->paginate(15);
       // dd($krsmhs);
        return view('baak.krs.krsmhs',compact('krsmhs','penilaian'));
       
    }
    
   
}
