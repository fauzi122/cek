<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\Kampus;

class JadwalujianController extends Controller
{
    public function __construct()
    {
        if(!$this->middleware('auth:sanctum')){
            return redirect('/login');
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function branch()
    {
        $kampus = Kampus::get();
        //dd($kampus);
        return view('admin.jadwal_ujian.branch', compact('kampus'));
    }

    public function jadwal_ujian($id)
    {
        $pecah=explode(',',Crypt::decryptString($id));

        $schedule=DB::table('jadwal_ujian')
        ->where(DB::raw('RIGHT(no_ruang, 2)'), '=',$pecah[0])
        ->get();
      return view('admin.jadwal_ujian.schedule', compact('schedule'));
    }

    public function edit_jadwal_ujian($id)
    {
       $pecah=explode(',',Crypt::decryptString($id));

        $editsch=DB::table('jadwal_ujian')
        ->where([
                'kd_dosen'  =>$pecah[0],
                'kd_lokal'  =>$pecah[1],
                'kd_mtk'    =>$pecah[2]
                ])->first();
        // dd($schedule);
      return view('admin.jadwal_ujian.edit_schedule',compact('editsch'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
      
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
