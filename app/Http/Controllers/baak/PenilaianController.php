<?php

namespace App\Http\Controllers\baak;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penilaian_tem;
use App\Jobs\ImportJobkrs;
use App\Imports\PenilaianImport;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\Datatables\Datatables;
use App\Models\ApiPenilaian;
use App\Models\PenilaianBaak;
use App\Models\MhsSisfo;
use App\Models\ApiMhs;
use Illuminate\Support\Facades\Crypt;


class PenilaianController extends Controller
{
    public function index()
    {
       
        return view('baak.krs.index');
    }
    public function datajson()
	{
		return Datatables::of(Penilaian_tem::all())->make(true);
	}

    public function storeData(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);
    
        if ($request->hasFile('file')) {
            //UPLOAD FILE
            $file = $request->file('file');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs(
                'public', $filename
            );
            
            //MEMBUAT JOBS DENGAN MENGIRIMKAN PARAMETER FILENAME
            ImportJobkrs::dispatch($filename);
            return redirect()->back()->with(['success' => 'Upload success']);
        }  
        return redirect()->back()->with(['error' => 'Please choose file before']);
    }

    public function tampilIndex()
    {
        $penilaian=PenilaianBaak::first();
        return view('baak.penilaian.index',compact('penilaian'));
    }
    public function inputPertemuan(Request $request)
    {
        ApiPenilaian::truncate();
        PenilaianBaak::truncate();
        PenilaianBaak::create(['smt' => $request->semester]);
        $req = MhsSisfo::with(array('PenilaianSisfo'=>function($query){
            $select=PenilaianBaak::first();
            $query->join('mhs as b', 'penilaian.nim', '=', 'b.nim')
            ->whereRaw("(MID(penilaian.no_krs, 6,1) IN ($select->smt) OR MID(penilaian.no_krs, 7,1) IN ($select->smt))")
            ->whereRaw("(MID(penilaian.no_krs, 6,1)=MID(b.kd_lokal, 4,1) OR MID(penilaian.no_krs, 7,1)=MID(b.kd_lokal, 4,1))")
            ->where('b.kondisi',1);
        }))
        ->where('kondisi',1)
        ->orderBy('nim')
        ->paginate(
            $perPage = 600, $columns = ['*'], $pageName = 'azis', $currentPage=1
        );
        PenilaianBaak::where('id', 0)
        ->update(['total' => $req->total(), 'lastPage' => $req->lastPage()]);;
        return redirect('/krs/mhs');
    }
    public function send($id)
    {
        if (substr(Crypt::decryptString($id),1)!=0) {
            for ($i = Crypt::decryptString($id)-substr(Crypt::decryptString($id),1)+1; $i <= Crypt::decryptString($id); $i++) {
                echo "<script>window.open('/proses-penilaian/".$i."', '_blank')</script>";
            }
        }else{
            for ($i = Crypt::decryptString($id)-9; $i <= Crypt::decryptString($id); $i++) {
                echo "<script>window.open('/proses-penilaian/".$i."', '_blank')</script>";
            }
        }
        echo "<a href='".url("/krs/mhs") ."' type='button' class='btn btn-info'>Kembali Kehalaman Awal</a>";
    }
    public function sendMhs($id)
    {
        if (substr(Crypt::decryptString($id),1)!=0) {
            for ($i = Crypt::decryptString($id)-substr(Crypt::decryptString($id),1)+1; $i <= Crypt::decryptString($id); $i++) {
                echo "<script>window.open('/proses-mahasiswa/".$i."', '_blank')</script>";
            }
        }else{
            for ($i = Crypt::decryptString($id)-9; $i <= Crypt::decryptString($id); $i++) {
                echo "<script>window.open('/proses-mahasiswa/".$i."', '_blank')</script>";
            }
        }
    }
    public function prosesPenilaian($id)
    {
        // for ($i = 1; $i <= $id; $i++) {
            $flight = MhsSisfo::with(array('PenilaianSisfo'=>function($query){
                $select=PenilaianBaak::first();
                $query->join('mhs as b', 'penilaian.nim', '=', 'b.nim')
                ->whereRaw("(MID(penilaian.no_krs, 6,1) IN ($select->smt) OR MID(penilaian.no_krs, 7,1) IN ($select->smt))")
                ->whereRaw("(MID(penilaian.no_krs, 6,1)=MID(b.kd_lokal, 4,1) OR MID(penilaian.no_krs, 7,1)=MID(b.kd_lokal, 4,1))")
                ->where('b.kondisi',1);
            }))
            ->where('kondisi',1)
            ->orderBy('nim')
            ->paginate(
                $perPage = 600, $columns = ['*'], $pageName = 'azis', $currentPage=$id
            );
        $result = array();
        foreach($flight as $mhs){
            foreach($mhs->PenilaianSisfo as $pen){
                $result[] = array(
                    'nim'=>$pen->nim,
                    'no_krs'=>$pen->no_krs,
                    'kd_mtk'=>$pen->kd_mtk,
                    'nilai_uts'=>$pen->nilai_uts,
                    'nilai_uas'=>$pen->nilai_uas,
                    'total_nilai'=>$pen->total_nilai,
                    'nil_absen'=>$pen->nil_absen,
                    'nil_tgs'=>$pen->nil_tgs,
                    'grade_akhir'=>$pen->grade_akhir,
                    'kel_praktek'=>$pen->kel_praktek,
                    'unggulan'=>$pen->unggulan,
                    'minat'=>$pen->minat
                );
            }
        }
        $chunk=collect($result)->chunk(500);
        foreach($chunk as $arr){
            ApiPenilaian::insert($arr->toArray());
        }
    // }
    return view('api.penilaian');

    
    }
    public function prosesMhs($id)
    {
        // for ($i = 1; $i <= $id; $i++) {
            $flight = MhsSisfo::with(array('PenilaianSisfo'=>function($query){
                $select=PenilaianBaak::first();
                $query->join('mhs as b', 'penilaian.nim', '=', 'b.nim')
                ->whereRaw("(MID(penilaian.no_krs, 6,1) IN ($select->smt) OR MID(penilaian.no_krs, 7,1) IN ($select->smt))")
                ->whereRaw("(MID(penilaian.no_krs, 6,1)=MID(b.kd_lokal, 4,1) OR MID(penilaian.no_krs, 7,1)=MID(b.kd_lokal, 4,1))")
                ->where('b.kondisi',1);
            }))
            ->where('kondisi',1)
            ->orderBy('nim')
            ->paginate(
                $perPage = 600, $columns = ['*'], $pageName = 'azis', $currentPage=$id
            );
        $result = array();
        foreach($flight as $mhs){
                $result[] = array(  
                    'nim'=>$mhs->nim,
                    'nm_mhs'=>$mhs->nm_mhs,
                    'jen_kel'=>$mhs->jen_kel,
                    'agm'=>$mhs->agm,
                    't_lhr'=>$mhs->t_lhr,
                    'tgl_lhr'=>$mhs->tgl_lhr,
                    'alm'=>$mhs->alm,
                    'no_rmh'=>$mhs->no_rmh,
                    'kota'=>$mhs->kota,
                    'rt_rw'=>$mhs->rt_rw,
                    'kd_pos'=>$mhs->kd_pos,
                    'telp'=>$mhs->telp,
                    'kd_jrs'=>$mhs->kd_jrs,
                    'no_by_klh'=>$mhs->no_by_klh,
                    'no_ta'=>$mhs->no_ta,
                    'kondisi'=>$mhs->kondisi,
                    'nm_wali'=>$mhs->nm_wali,
                    'waktu'=>$mhs->waktu,
                    'kd_lokal'=>$mhs->kd_lokal,
                    'th_masuk'=>$mhs->th_masuk,
                    'kd_paket'=>$mhs->kd_paket,
                    'prd'=>$mhs->prd,
                    'gel'=>$mhs->gel,
                    'kd_minat'=>$mhs->kd_minat,
                    'no_frm'=>$mhs->no_frm,
                    'no_telp_hp'=>$mhs->no_telp_hp,
                    'emailaddress'=>$mhs->emailaddress
                    );
            
        }
        $chunk=collect($result)->chunk(500);
        foreach($chunk as $arr){
            ApiMhs::insert($arr->toArray());
        }
    // }
    return view('api.penilaian');
    }
    public function hapusMhs()
    {
        ApiMhs::truncate();
        return redirect('/krs/mhs');
    }
}

