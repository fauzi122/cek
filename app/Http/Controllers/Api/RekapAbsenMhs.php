<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absen_mhs;

class RekapAbsenMhs extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'nim' => 'required|numeric',
            'kd_mtk' => 'required|numeric',
            'limit' => 'sometimes|numeric', // tambahkan validasi untuk input limit
            'sort' => 'sometimes|in:asc,desc' // tambahkan validasi untuk input sort
        ]);

        $nim = $request->input('nim');
        $kd_mtk = $request->input('kd_mtk');
        $limit = $request->input('limit', 10); // ambil nilai limit dari request body, default 10
        $sort = $request->input('sort', 'asc'); // ambil nilai sort dari request body, default asc

        $rekap = Absen_mhs::where('nim', '=', $nim)
            ->where('kd_mtk', '=', $kd_mtk)
            ->orderBy('pertemuan', $sort) // tambahkan kondisi orderBy()
            ->limit($limit)
            ->get();

        if ($rekap->isEmpty()) {
            return response()->json([
                "response" => [
                    "status"    => 404,
                    "message"   => "Data Agenda Tidak Ditemukan!"
                ],
                "data" => null
            ], 404);
        }

        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "Detail Data Agenda"
            ],
            "data" => $rekap
        ], 200);
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
