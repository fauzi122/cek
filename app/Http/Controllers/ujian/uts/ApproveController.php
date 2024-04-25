<?php

namespace App\Http\Controllers\ujian\uts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Soal;
use App\Models\Soal_ujian;
use App\Models\Mtk_ujian;
use App\Models\ujian_aprov;
use App\Models\Paket_ujian;
use App\Models\Detailsoal_ujian;
use App\Models\DetailSoalEssay_ujian;
use App\Models\perakit_bahan_ajar;
use Carbon\Carbon;
use App\Exports\DetailsoalExport;
use Maatwebsite\Excel\Facades\Excel; 

class ApproveController extends Controller
{
    public function __construct()
    {
       $this->middleware(['permission:master_soal_ujian|master_soal_ujian.acc_prodi']);
       if(!$this->middleware('auth:sanctum')){
        return redirect('/login');
    }
    }

    public function approveKaprodi(Request $request)
    {
        // dd($request->all());

        $this->validate($request, [
            'soal_ids'   => 'required|array',
            'soal_ids.*' => 'exists:ujian_detailsoals,id', 
            'kd_mtk'     => 'required', 
            'paket'      => 'required'  
        ]);

        $tgl_kaprodi = Carbon::now(); // Mendapatkan waktu dan tanggal saat ini

        // Update setiap soal yang dipilih di database
        foreach ($request->soal_ids as $soal_id) {
            Detailsoal_ujian::where('id', $soal_id)->update([

                'status'    => 'Y',
                'sts_kirim' => '1',
                'petugas'   => Auth::user()->kode,

            ]);
        }

        // Update pada UjianAprov berdasarkan kd_mtk dan paket
        ujian_aprov::where('kd_mtk', $request->kd_mtk)
                ->where('paket', $request->paket)
                ->update([

                    'kd_dosen_kaprodi' => Auth::user()->kode,
                    'acc_kaprodi' => '1',  
                    'tgl_kaprodi' => $tgl_kaprodi

                ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Soal berhasil disetujui.');
    }
    public function approveKaprodiessay(Request $request)
    {
        // dd($request->all());

        $this->validate($request, [
            'soal_ids'   => 'required|array',
            'soal_ids.*' => 'exists:ujian_detail_soal_esays,id', 
            'kd_mtk'     => 'required', 
            'paket'      => 'required'  
        ]);

        $tgl_kaprodi = Carbon::now(); // Mendapatkan waktu dan tanggal saat ini

        // Update setiap soal yang dipilih di database
        foreach ($request->soal_ids as $soal_id) {
            DetailSoalEssay_ujian::where('id', $soal_id)->update([

                'status'    => 'Y',
                'sts_kirim' => '1',
                'petugas'   => Auth::user()->kode,

            ]);
        }

        // Update pada UjianAprov berdasarkan kd_mtk dan paket
        ujian_aprov::where('kd_mtk', $request->kd_mtk)
                ->where('paket', $request->paket)
                ->update([

                    'kd_dosen_kaprodi'      => Auth::user()->kode,
                    'acc_kaprodi_essay'   => '1',  
                    'tgl_kaprodi'           => $tgl_kaprodi

                ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Soal berhasil disetujui.');
    }

    // public function approveBaak(Request $request)
    // {
        
    //     $request->validate([
    //         'kd_mtk' => 'required',
    //         'paket' => 'required',
    //         // 'jenis_mtk' => 'required|in:PG ONLINE,ESSAY ONLINE', // Pastikan 'jenis_mtk' dikirim dan valid
    //     ]);
    
    //     // Cari record berdasarkan 'kd_mtk' dan 'paket'
    //     $baak = ujian_aprov::where('kd_mtk', $request->kd_mtk)
    //                 ->where('paket', $request->paket)
    //                 ->first();
    
    //     if (!$baak) {
    //         return redirect()->back()->withErrors(['msg' => 'Record not found!']);
    //     }
    
    //     // Perbarui field berdasarkan jenis materi
    //     if ($request->jenis_mtk == 'PG ONLINE') {
    //         $baak->kd_dosen_baak = Auth::user()->kode;
    //         $baak->acc_baak = '1'; // Mengeset persetujuan untuk PG
    //     } elseif ($request->jenis_mtk == 'ESSAY ONLINE') {
    //         $baak->kd_dosen_baak = Auth::user()->kode;
    //         $baak->acc_baak_essay = '1'; // Mengeset persetujuan untuk Essay
    //     }
    
    //     $baak->tgl_baak = Carbon::now();
    //     $baak->save();
    
    //     return redirect()->back()->with('success', 'Soal berhasil disetujui.');
    // }
           
    public function approveBaak(Request $request)
    {
        $request->validate([
            'kd_mtk' => 'required',
            'paket' => 'required',
        ]);

        // Find the record based on 'kd_mtk' and 'paket'
        $baak = ujian_aprov::where('kd_mtk', $request->kd_mtk)
                    ->where('paket', $request->paket)
                    ->first();

        if (!$baak) {
            return redirect()->back()->withErrors(['msg' => 'Record not found!']);
        }

        // Update the fields
        $baak->kd_dosen_baak = Auth::user()->kode;
        $baak->acc_baak = '1';
        $baak->tgl_baak = Carbon::now();

        $baak->save();

        return redirect()->back()->with('success', 'Soal berhasil disetujui.');
    } 

    public function approveBaakEssay(Request $request)
    {
      
        $request->validate([
            'kd_mtk' => 'required',
            'paket' => 'required',
        ]);

        // Find the record based on 'kd_mtk' and 'paket'
        $baak = ujian_aprov::where('kd_mtk', $request->kd_mtk)
                    ->where('paket', $request->paket)
                    ->first();

        if (!$baak) {
            return redirect()->back()->withErrors(['msg' => 'Record not found!']);
        }

        // Update the fields
        $baak->kd_dosen_baak = Auth::user()->kode;
        $baak->acc_baak_essay = '1';
        $baak->tgl_baak = Carbon::now();

        $baak->save();

        return redirect()->back()->with('success', 'Soal berhasil disetujui.');
    } 

    // Fungsi untuk mengunduh data dalam format Excel
    public function downloadDataPg(Request $request)
    {
        // Validasi input
        $request->validate([
            'kd_mtk' => 'required',
            'jenis' => 'required'
        ]);

        // Ambil data berdasarkan parameter kd_mtk dan jenis_mtk
        $data = Detailsoal_ujian::select('kd_mtk',
        'jenis',
        'soal',
        'file',
        'pila',
        'pilb',
        'pilc',
        'pild',
        'pile',
        'kunci')->where([
                'kd_mtk' => $request->kd_mtk,
                'jenis' => $request->jenis
            ])->orderBy('created_at', 'DESC')->get();

        // Export data ke dalam file Excel
        return Excel::download(new DetailsoalExport($data), 'detail_soal_pg.xlsx');
    }
}
