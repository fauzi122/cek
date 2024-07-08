<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\Ujian_berita_acara;
use App\Models\SettingUjian;
use Illuminate\Http\Request;
use App\Models\Soal_ujian;
use App\Models\Absen_ujian;
use App\Models\JawabEsay;
use App\Models\SettingEssayOnline;

class MengawasController extends Controller
{

    public function index()
    {
        return view('admin.mengawas.index');
    }


    public function m_uts($id)
    {
       
        // Mengambil semua soal ujian yang memenuhi kriteria
        $groupedSoals = Soal_ujian::where('no_ruang', 'not like', 'E%')
            ->where('paket', $id)
            ->where('kd_dosen', Auth::user()->kode)
            ->get();

        $essay =  DB::table('uts_soal_kusus_essay')->join('mtk_ujians', 'uts_soal_kusus_essay.kd_mtk', '=', 'mtk_ujians.kd_mtk')
            ->where('uts_soal_kusus_essay.paket', $id)
            ->where('mtk_ujians.paket', $id)
            ->where('mtk_ujians.jenis_mtk', 'ESSAY ONLINE')
            ->where('uts_soal_kusus_essay.kd_dosen', Auth::user()->kode)
            ->get();

        return view('admin.mengawas.uts', compact('groupedSoals','essay'));
    }

    public function nilai_essay($id)
    {
        // dd($id);
        $essay =  DB::table('uts_soal_kusus_essay')->join('mtk_ujians', 'uts_soal_kusus_essay.kd_mtk', '=', 'mtk_ujians.kd_mtk')
            ->where('uts_soal_kusus_essay.paket', $id)
            ->where('mtk_ujians.paket', $id)
            ->where('mtk_ujians.jenis_mtk', 'ESSAY ONLINE')
            ->where('uts_soal_kusus_essay.kd_dosen', Auth::user()->kode)
            ->get();
            // dd($essay);
        return view('admin.mengawas.nilai_essay.index', compact('essay'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'kd_mtk'    => 'required',
            'kel_ujian' => 'required',
            'hari'      => 'required',
            'paket'     => 'required',
            'no_ruang'     => 'required',
            'jam_t'     => 'required',

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
            'no_ruang'      => $request->input('no_ruang'),
            'jam_t'         => $request->input('jam_t'),

        ];

        // Update or create
        $berita = Ujian_berita_acara::updateOrCreate($uniqueKeys, $data);

        if ($berita) {
            return back()->with(['status' => 'Berhasil Masuk Mengawas']);
        } else {
            return back()->with(['error' => 'Gagal Berhasil Masuk Mengawas']);
        }
    }


    public function show_uts($id)
    {
        try {
            // Dekripsi dan pecah string $id menjadi array
            $pecah = explode(',', Crypt::decryptString($id));

            // dd($pecah);
            $setting = SettingUjian::where(['paket' => $pecah[3]])->first();

            // dd($setting);
            $soal = Soal_ujian::where([
                'kd_dosen'  => $pecah[0],
                'kd_mtk'    => $pecah[1],
                'kel_ujian' => $pecah[2],
                'paket'     => $pecah[3],
                'tgl_ujian' => $pecah[4]
            ])->first();

            // Mengambil data berita acara ujian
            $beritaAcara = Ujian_berita_acara::where([
                    'kd_dosen'  => $pecah[0],
                    'kd_mtk'    => $pecah[1],
                    'kel_ujian' => $pecah[2],
                    'paket'     => $pecah[3]
                    ])->first();


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

                // Tambahkan jawaban esay
                $item->isInJawabEssay = DB::table('ujian_jawab_esays')
                    ->where('nim', $item->nim)
                    ->where('kd_mtk', $item->kd_mtk)
                    ->where('kel_ujian', $item->no_kel_ujn)
                    ->where('paket', $item->paket)
                    ->first();

                return $item;
            });

            return view('admin.mengawas.show', compact('soal', 'id', 'beritaAcara', 'mhsujian','setting'));
        } catch (\Exception $e) {
            // Tangani kesalahan yang mungkin terjadi saat proses dekripsi atau query
            return back()->with('error', 'Terjadi kesalahan saat memproses data: ' . $e->getMessage());
        }
    }

    public function show_nilai_essay($id)
    {
        try {
            // Dekripsi dan pecah string $id menjadi array
            $pecah = explode(',', Crypt::decryptString($id));
            $setting = SettingEssayOnline::where(['paket' => $pecah[3]])->first();

            $soal = Soal_ujian::where([
                'kd_dosen'  => $pecah[0],
                'kd_mtk'    => $pecah[1],
                'kel_ujian' => $pecah[2],
                'paket'     => $pecah[3],
                'tgl_ujian' => $pecah[4]
            ])->first();

            // dd($soal);

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

                // Tambahkan jawaban esay
                $item->isInJawabEssay = DB::table('ujian_jawab_esays')
                    ->where('nim', $item->nim)
                    ->where('kd_mtk', $item->kd_mtk)
                    ->where('kel_ujian', $item->no_kel_ujn)
                    ->where('paket', $item->paket)
                    ->first();

                return $item;
            });

            return view('admin.mengawas.nilai_essay.show_essay', compact('soal', 'id', 'mhsujian','setting'));
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
            ])->get();
            // dd($pg);

            // essay
            $essay = DB::table('ujian_jawab_esays')->where([
                'nim'       => $pecah[0],
                'kel_ujian' => $pecah[1],
                'kd_mtk'    => $pecah[2],
                'paket'     => $pecah[3]
            ])
                ->get();

            // Mengirim data ke view
            return view('admin.mengawas.log', compact('log_mulai', 'pg', 'essay'));
        } catch (\Exception $e) {
            // Tangani kesalahan yang mungkin terjadi saat proses dekripsi atau query
            return back()->with('error', 'Terjadi kesalahan saat memproses data: ' . $e->getMessage());
        }
    }


    public function updateBeritaAcara(Request $request)
    {
        $this->validate($request, [
            'kd_mtk'    => 'required',
            'kel_ujian' => 'required',
            'paket'     => 'required',
            'isi'       => 'required',
        ]);

        DB::beginTransaction(); // Memulai transaksi

        try {
            // Update berita acara
            $beritaAcara = Ujian_berita_acara::where([
                'kd_mtk'    => $request->kd_mtk,
                'kel_ujian' => $request->kel_ujian,
                'paket'     => $request->paket
            ])->firstOrFail();

            $beritaAcara->isi = $request->isi;
            $beritaAcara->save();

            // Update batch di Absen_ujian jika kd_dosen adalah kosong atau null
            $kd_dosen = Auth::user()->kode;
            Absen_ujian::where(function ($query) {
                $query->where('kd_dosen', '')
                    ->orWhereNull('kd_dosen');
            })
                ->where([
                    'kd_mtk'    => $request->kd_mtk,
                    'no_kel_ujn' => $request->kel_ujian,
                    'paket'     => $request->paket
                ])->update(['kd_dosen' => $kd_dosen]);

            DB::commit(); // Commit transaksi
            return back()->with('status', 'Berita acara ujian berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback(); // Rollback transaksi jika terjadi kesalahan
            return back()->with('error', 'Gagal memperbarui berita acara ujian. Error: ' . $e->getMessage());
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

    function getnilaiEssay($id)
    {
        // nim => "22220056	"
        // kel_ujian => "22.4B.11.A"
        // kd_mtk => "053"
        // paket => "UTS"
        $pecah = explode(',', Crypt::decryptString($id));
        $result = DB::table('ujian_jawab_esays as jawab')
            ->join('ujian_detail_soal_esays as detail', 'jawab.id_detail_soal_esay', '=', 'detail.id')
            ->select(
                'jawab.id as id_jawaban',
                'jawab.nim',
                'jawab.jawab as jawaban_mahasiswa',
                'jawab.score as nilai',
                'detail.soal',
                'detail.kunci'
            )
            ->where([
                'jawab.nim'    => $pecah[0],
                'jawab.kel_ujian' => $pecah[1],
                'jawab.kd_mtk'    => $pecah[2],
                'jawab.paket'     => $pecah[3]
            ])
            ->get();
        // dd($result);
        return response()->json($result);
    }
    public function updateNilai(Request $request)
    {
        foreach ($request->updates as $update) {
            $essay = JawabEsay::find($update['id']);
            $essay->score = $update['nilai'];
            $essay->save();
        }

        return response()->json(['message' => 'Nilai berhasil diupdate']);
    }
}