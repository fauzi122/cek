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

class MengawasGabungController extends Controller
{
    public function show_uts($id)
    {
        try {
            // Dekripsi dan pecah string $id menjadi array
            $pecah = explode(',', Crypt::decryptString($id));

            $kelUjianParts = array_slice($pecah, 5);
            $kelUjianParts = array_map('trim', $kelUjianParts);
            // Gabungkan semua kel_ujian menjadi satu string, pisahkan lagi untuk memastikan array bersih
            $kelUjianArray1 = explode(',', implode(',', $kelUjianParts));
// dd($kelUjianArray1);
            // Buat query menggunakan whereIn untuk memfilter berdasarkan kel_ujian
            $soal = Soal_ujian::where([
                'kd_dosen'  => $pecah[0],
                'kd_mtk'    => $pecah[1],
                'kd_gabung' => $pecah[4],
                'paket'     => $pecah[2],
                'tgl_ujian' => $pecah[3]
            ])->whereIn('kel_ujian', $kelUjianArray1)->first();

            // Mengambil data berita acara ujian
            $beritaAcara = Ujian_berita_acara::where([
                'kd_dosen'  => $pecah[0],
                'kd_mtk'    => $pecah[1],
                'kd_gabung' => $pecah[4],
                'paket'     => $pecah[2]
            ])->first();
            // dd($beritaAcara);
               // Ambil array dari indeks 5 dan seterusnya yang mungkin berisi lebih dari satu kel_ujian
            $kelUjianParts = array_slice($pecah, 5);
            // Bersihkan setiap bagian dari whitespace yang tidak diinginkan
            $kelUjianParts = array_map('trim', $kelUjianParts);
            // Gabungkan semua kel_ujian menjadi satu string, pisahkan lagi untuk memastikan array bersih
            $kelUjianArray = explode(',', implode(',', $kelUjianParts));
       
            // Debug untuk melihat output array kel_ujian
            

            // Buat query untuk mengambil data absensi ujian
            $mhsujian = Absen_ujian::where('kd_mtk', $pecah[1])
                                    ->where('paket', $pecah[2])
                                    ->whereIn('no_kel_ujn', $kelUjianArray)
                                    ->get()->map(function ($item) {
                        $item->isInHasilUjian = DB::table('ujian_hasilujians')
                            ->where('nim', $item->nim)
                            ->where('kd_mtk', $item->kd_mtk)
                            ->where('kel_ujian', $item->no_kel_ujn)
                            ->where('paket', $item->paket)
                            ->exists();
                        return $item;
                    });
            // dd($mhsujian);
            return view('admin.mengawas.show', compact('soal', 'id', 'beritaAcara', 'mhsujian','kelUjianArray1'));
        } catch (\Exception $e) {
            // Tangani kesalahan yang mungkin terjadi saat proses dekripsi atau query
            return back()->with('error', 'Terjadi kesalahan saat memproses data: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'kd_mtk'    => 'required',
            'kel_ujian' => 'required|array', // Pastikan ini tetap sebagai array untuk validasi
            'hari'      => 'required',
            'paket'     => 'required',
            'kd_gabung' => 'required',
        ]);
    
        // Gabungkan semua kel_ujian ke dalam satu string yang dipisahkan oleh koma
        $kelUjianStr = implode(',', $request->input('kel_ujian'));
    
        $uniqueKeys = [
            'kd_mtk'    => $request->input('kd_mtk'),
            'kd_gabung' => $request->input('kd_gabung'), // Menggunakan kd_gabung sebagai kunci unik
            'paket'     => $request->input('paket'),
        ];
    
        $data = [
            'kd_dosen'  => Auth::user()->kode,
            'hari'      => $request->input('hari'),
            'tgl_ujian' => $request->input('tgl_ujian'),
            'kel_ujian' => $kelUjianStr, // Menyimpan string yang dipisahkan koma
        ];
    
        // Update or create
        $berita = Ujian_berita_acara::updateOrCreate($uniqueKeys, $data);
    
        if ($berita) {
            return back()->with(['status' => ' Masuk Mengawas']);
        } else {
            return back()->with(['error' => 'Gagal Masuk Mengawas']);
        }
    }
    
    public function updateBeritaAcara(Request $request)
    {
        $this->validate($request, [
            'kd_mtk'    => 'required',
            'kd_gabung' => 'required',
            'paket'     => 'required',
            'isi'       => 'required', // misalkan Anda memperbarui field 'isi' dari berita acara
        ]);

        // Mencari record yang sesuai
        $beritaAcara = Ujian_berita_acara::where([
            'kd_mtk'    => $request->kd_mtk,
            'kd_gabung' => $request->kd_gabung,
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
    
    
}
