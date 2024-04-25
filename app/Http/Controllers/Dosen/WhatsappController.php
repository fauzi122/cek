<?php

namespace App\Http\Controllers\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Send_wa;

class WhatsappController extends Controller
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
    public function index($id)
    {
            //di buat array utuk deskrip kode nya
            // 0 => "DPG.17.1C.12.A"
            // 1 => "894"
            // 2 => "201704121"
        $pecah=explode(',',Crypt::decryptString($id));
            //dd($pecah);
            // select materi tambahan
        $wa= Send_wa::where([
            'kd_dosen'  =>Auth::user()->kode,
            'kd_mtk'    =>$pecah[1],
            'kd_lokal'  =>$pecah[0]
            ])->count();
            //dd($wa);

        return view('admin.whatsapp.index',compact('id','wa','pecah'));
        
        }

        // public function create(Request $request)
        // {
        //     $gabung=Crypt::encryptString($request->input('kd_lokal').','.$request->input('kd_mtk').','.$request->input('nip'));
        //     $response = Http::post('https://mybest-wapi.herokuapp.com/send-group-message', [
        //         'name' => $request->input('nm_group'),
        //             'message' => 'Salam kenal teman-teman saya mybest, tugas saya adalah untuk memberitahukan materi tambahan, video ataupun tugas dari dosen '.Auth::user()->name,
        //         ]);
        //         $responseData = json_decode($response, true);
        //         // dd($responseData['status']);
        //         if (!isset($responseData)) {
        //             return redirect('/grup-wa/'.$gabung)->with('error','Bot MyBest Sedang Offline');
        //         }elseif ($responseData['status']==true) {
        //         Send_wa::create([
        //             'kd_mtk'        => $request->input('kd_mtk'),
        //             'kd_lokal'      => $request->input('kd_lokal'),
        //             'kd_dosen'      => Auth::user()->kode,
        //             'nm_grup'      => $request->input('nm_group')
        //         ])->save();
        //         return redirect('/grup-wa/'.$gabung)->with('status','Sinkron');
        //     }else if($responseData['status']==null || $responseData['status']==false){
        //         return redirect('/grup-wa/'.$gabung)->with('error','Nomer Bot MyBest Belum ada Didalam Group "'.$request->input('nm_group').'"');
        //     }
        // }
        public function create(Request $request)
        {
            $gabung=Crypt::encryptString($request->input('kd_lokal').','.$request->input('kd_mtk').','.$request->input('nip'));
                $send=Send_wa::create([
                    'kd_mtk'        => $request->input('kd_mtk'),
                    'kd_lokal'      => $request->input('kd_lokal'),
                    'kd_dosen'      => Auth::user()->kode,
                    'nm_grup'      => $request->input('nm_group'),
                    'sts_wa'      => '0'
                ])->save();
                return redirect('/grup-wa/'.$gabung)->with('status','Sinkron');
          
        }
        
        public function store(Request $request)
        { 
            $gabung=Crypt::encryptString($request->input('kd_lokal').','.$request->input('kd_mtk').','.$request->input('nip'));
            $cek_nm_group = Send_wa::where(['nm_grup'=>$request->input('nm_grup')])->count();
            if($cek_nm_group>0){
                return redirect('/grup-wa/'.$gabung)->with('error','Nama Group Sudah Ada');
            }else{
            $this->validate($request, [
    
                'nm_grup'         => 'required'
            ]);
            
            $up=Send_wa::updateOrCreate(
                [     
                    'kd_dosen'      => $request->input('kd_dosen'),
                    'kd_mtk'        => $request->input('kd_mtk'),
                    'kd_lokal'      => $request->input('kd_lokal')

            ],
                [
                    'nm_grup'      => $request->input('nm_grup')
                  
                    ]
            );
        }
            $send_wa = Send_wa::where(['kd_dosen'=>$request->input('kd_dosen'),'kd_mtk'=> $request->input('kd_mtk'),'kd_lokal'=>     $request->input('kd_lokal')])->first();

            $response = Http::post('https://whatsapp-api-mybest.herokuapp.com/send-group-message', [
            'name' => $send_wa->nm_grup,
                'message' => 'Salam kenal sobat BSI. Nama saya adalah SOBI, Terimakasih telah menyambut sobi dalam group teman-teman, disini sobi akan memberikan informasi jika dosen '.$send_wa->kd_dosen.' memberikan tugas, video pembelajaran maupun materi tambahan :senyum',
            ]);
            $responseData = json_decode($response, true);
            if ($responseData['status']==true) {
                $this->validate($request, [
    
                    'nm_grup'         => 'required'
                ]);
                
                $up=Send_wa::updateOrCreate(
                    [     
                        'kd_dosen'      => $request->input('kd_dosen'),
                        'kd_mtk'        => $request->input('kd_mtk'),
                        'kd_lokal'      => $request->input('kd_lokal')
    
                ],
                    [
                        'nm_grup'      => $request->input('nm_grup')
                      
                        ]
                );
                return redirect('/grup-wa/'.$gabung)->with('status','Data Berhasil Ditambah');
            }else{
                Send_wa::where(['kd_dosen'=>$request->input('kd_dosen'),'kd_mtk'=> $request->input('kd_mtk'),'kd_lokal'=>     $request->input('kd_lokal')])->delete();
                return redirect('/grup-wa/'.$gabung)->with('error','Nomer Bot MyBest Belum ada Didalam Group "'.$send_wa->nm_grup.'"');
            }
            
        return redirect('/grup-wa/'.$gabung)->with('error','Gagal Ditambah');

        }

        public function destroy($id)
        {
            // dd($id);
            $wa = Send_wa::findOrFail($id)->delete();
            // dd($id_mtk);
            // $wa;
          
            if($wa){
              return response()->json([
                'status' => 'success'
              ]);
            }else{
              return response()->json([
                'status' => 'error'
              ]);
            }
        }
    
}
