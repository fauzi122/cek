<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\Ujian_berita_acara;
use Illuminate\Http\Request;
use App\Models\Soal_ujian;
use App\Models\Absen_ujian;
use App\Models\Distribusisoal_ujian;


class MengawasController extends Controller
{

    public function index()
    {
        return view('admin.mengawas.index');
    }

    public function m_uts()
    {
        $uts = Soal_ujian::where('kd_dosen', Auth::user()->kode)
            ->where('paket', 'UTS')
            ->get();
        return view('admin.mengawas.uts', compact('uts'));
    }

    public function m_uas()
    {
        $uas = DB::table('uts_soals')
            ->where('kd_dosen', Auth::user()->kode)
            ->where('paket', 'UAS')
            ->get();
        return view('admin.mengawas.uas', compact('uas'));
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
        $this->validate($request, [
            'kd_mtk'    => 'required',
            'kel_ujian' => 'required',
            'hari'      => 'required',
            'paket'     => 'required',

        ]);

        // Define the unique keys for searching. Example: 'kd_mtk' and 'kel_ujian'
        $uniqueKeys = [
            'kd_mtk'    => $request->input('kd_mtk'),
            'kel_ujian' => $request->input('kel_ujian'),
            'paket'     => $request->input('paket'),
        ];

        // Data to be updated or created
        $data = [
            'kd_dosen'      => Auth::user()->kode,
            'hari'          => $request->input('hari'),
            'tgl_ujian'     => $request->input('tgl_ujian'),

        ];

        // Update or create
        $berita = Ujian_berita_acara::updateOrCreate($uniqueKeys, $data);

        if ($berita) {
            return back()->with(['status' => 'Berhasil Masuk Mengawas']);
        } else {
            return back()->with(['error' => 'Gagal Berhasil Masuk Mengawas']);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_uts($id)
    {
        try {
            // Dekripsi dan pecah string $id menjadi array
            $pecah = explode(',', Crypt::decryptString($id));

            // Mengambil data soal ujian
            $soal = Soal_ujian::where([
                'kd_dosen'  => $pecah[0],
                'kd_mtk'    => $pecah[1],
                'kel_ujian' => $pecah[2],
                'paket'     => $pecah[3],
                'hari_t'    => $pecah[4]
            ])->first();

            // Mengambil data berita acara ujian
            $beritaAcara = Ujian_berita_acara::where([
                'kd_dosen'  => $pecah[0],
                'kd_mtk'    => $pecah[1],
                'kel_ujian' => $pecah[2],
                'paket'     => $pecah[3]
            ])->first();
            // dd($beritaAcara);
            // Mengambil dan memproses data absen ujian
            $mhsujian = Absen_ujian::where([
                'kd_mtk'    => $pecah[1],
                'no_kel_ujn' => $pecah[2],
                'paket'     => $pecah[3]
            ])->get()->map(function ($item) {
                $item->isInHasilUjian = DB::table('ujian_hasilujians')
                    ->where('nim', $item->nim)
                    ->where('kd_mtk', $item->kd_mtk)
                    ->where('kel_ujian', $item->no_kel_ujn)
                    ->where('paket', $item->paket)
                    ->exists();
                return $item;
            });

            return view('admin.mengawas.show', compact('soal', 'id', 'beritaAcara', 'mhsujian'));
        } catch (\Exception $e) {
            // Tangani kesalahan yang mungkin terjadi saat proses dekripsi atau query
            return back()->with('error', 'Terjadi kesalahan saat memproses data: ' . $e->getMessage());
        }
    }


    public function show_log($id)
    {
        try {
            // Dekripsi dan pecah string $id menjadi array
            $pecah = explode(',', Crypt::decryptString($id));

            // Mengambil data berita acara ujian
            $log_mulai = DB::table('ujian_hasilujians')->where([
                'nim'       => $pecah[0],
                'kel_ujian' => $pecah[1],
                'kd_mtk'    => $pecah[2],
                'paket'     => $pecah[3]
            ])->first();

            // PG
            $pg = DB::table('ujian_jawabs')->where([
                'nim'       => $pecah[0],
                'kel_ujian' => $pecah[1],
                'kd_mtk'    => $pecah[2],
                'paket'     => $pecah[3]
            ])->orderBy('id', 'DESC')
                ->get();

            // essay
            $essay = DB::table('ujian_jawab_esays')->where([
                'nim'       => $pecah[0],
                'kel_ujian' => $pecah[1],
                'kd_mtk'    => $pecah[2],
                'paket'     => $pecah[3]
            ])->orderBy('id', 'DESC')
                ->get();

            // Mengirim data ke view
            return view('admin.mengawas.log', compact('log_mulai', 'pg', 'essay'));
        } catch (\Exception $e) {
            // Tangani kesalahan yang mungkin terjadi saat proses dekripsi atau query
            return back()->with('error', 'Terjadi kesalahan saat memproses data: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function updateBeritaAcara(Request $request)
    {
        $this->validate($request, [
            'kd_mtk'    => 'required',
            'kel_ujian' => 'required',
            'paket'     => 'required',
            'isi'       => 'required', // misalkan Anda memperbarui field 'isi' dari berita acara
        ]);

        // Mencari record yang sesuai
        $beritaAcara = Ujian_berita_acara::where([
            'kd_mtk'    => $request->kd_mtk,
            'kel_ujian' => $request->kel_ujian,
            'paket'     => $request->paket
        ])->first();

        if ($beritaAcara) {
            // Memperbarui record yang ditemukan
            $beritaAcara->isi = $request->isi; // asumsikan 'isi' adalah kolom yang ingin Anda perbarui
            if ($beritaAcara->save()) {
                return back()->with('status', 'Berita acara berhasil diperbarui.');
            } else {
                return back()->with('error', 'Gagal memperbarui berita acara.');
            }
        } else {
            return back()->with('error', 'Berita acara tidak ditemukan.');
        }
    }


    public function UpdateAbsenUjian(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');

        try {
            $kutipan = Absen_ujian::find($id);
            $kutipan->status = $status;
            $kutipan->kd_dosen = Auth::user()->kode;
            $kutipan->save();

            return response()->json(['message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error updating status'], 500);
        }
    }

    public function updateKeterangan(Request $request)
    {
        // dd($request->all()); // Ini akan menampilkan semua data request di browser

        // Sisa kode untuk memproses data
        $item = Absen_ujian::findOrFail($request->id);
        $item->ket = $request->ket;
        $item->save();

        return response()->json(['message' => 'Keterangan berhasil diperbarui']);
    }
}
