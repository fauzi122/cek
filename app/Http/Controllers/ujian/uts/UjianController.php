<?php

namespace App\Http\Controllers\ujian\uts;

use Illuminate\Support\Facades\Storage;
use App\Imports\UjianSoalEssayImport;
use App\Imports\UjianSoalpgImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;
use App\Models\Mtk_ujian;
use App\Models\SettingUjian;
use App\Models\Soal_ujian;
use App\Models\Perakit_soal;
use App\Models\Paket_ujian;
use App\Models\ujian_aprov;
use App\Models\Distribusisoal;
use App\Models\Detailsoal_ujian;
use App\Models\ujian_aprov_essay;
use App\Models\perakit_bahan_ajar;
use App\Models\DetailSoalEssay_ujian;
use App\Exports\DetailsoalExport;

class UjianController extends Controller
{
    public function __construct()
    {
        if (!$this->middleware('auth:sanctum')) {
            return redirect('/login');
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $examTypes = Paket_ujian::distinct()->pluck('paket');

        $encryptedExamTypes = $examTypes->mapWithKeys(function ($item) {
            return [$item => Crypt::encryptString($item)];
        });

        $paketUjian = Paket_ujian::all();

        return view('admin.soalujian.index', compact('encryptedExamTypes', 'paketUjian'));
    }


    public function index_uts(Request $request, $id)
    {
        if (Auth::user()->utype == 'ADM') {

            try {
                $pecah = explode(',', Crypt::decryptString($id));
            } catch (\Exception $e) {
                return redirect()->back()->withErrors('Gagal mendekripsi ID.');
            }

            // Cek apakah pengguna dengan NIP tersebut memiliki entri di perakit_bahan_ajar
            $perakit = perakit_bahan_ajar::where('nip', Auth::user()->username)->exists(); // Ganti 'nip' dengan 'username' jika memang itu yang dimaksud

            if ($pecah[0] == 'LATIHAN' && $perakit) {
                // Ini akan dijalankan jika ada entri di perakit_bahan_ajar yang cocok dengan nip/username
                $soals = Mtk_ujian::where('paket', $pecah[0])
                    ->groupBy('kd_mtk')
                    ->get();
            } else if ($pecah[0] != 'LATIHAN') {

                // dd($pecah[0] );
                // Ini akan dijalankan jika 'paket' bukan 'LATIHAN', tanpa memperdulikan keberadaan di perakit_bahan_ajar
                $soals = Mtk_ujian::join('perakit_soals', 'mtk_ujians.kd_mtk', '=', 'perakit_soals.kd_mtk')
                    ->where('mtk_ujians.paket', $pecah[0])
                    ->where('perakit_soals.kd_dosen', Auth::user()->kode)
                    ->select('mtk_ujians.*', 'perakit_soals.kd_dosen')
                    ->groupBy('kd_mtk')
                    ->get();
                // dd($soals);
            } else {
                // Opsional: Penanganan khusus jika tidak ada entri di perakit_bahan_ajar dan paket adalah 'LATIHAN'
                $soals = collect(); // Mengembalikan koleksi kosong atau sesuai kebutuhan
            }


            $detailsoal = DB::table('ujian_detailsoals')
                ->select(DB::raw('kd_mtk, COUNT(*) as jumlah'))
                // ->where('status')
                ->where('id_user', Auth::user()->kode)
                ->where('jenis', $pecah[0])
                ->groupBy('kd_mtk')
                ->pluck('jumlah', 'kd_mtk');

            $detailsoal_essay = DB::table('ujian_detail_soal_esays')
                ->select(DB::raw('kd_mtk, COUNT(*) as jumlah'))
                // ->where('status')
                ->where('id_user', Auth::user()->kode)
                ->where('jenis', $pecah[0])
                ->groupBy('kd_mtk')
                ->pluck('jumlah', 'kd_mtk');

            return view('admin.soalujian.uts', compact('soals', 'detailsoal', 'detailsoal_essay'));
        } else {
            return redirect('/dashboard');
        }
    }


    public function create_pilih_uts($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        // dd($pecah);
        $soal = Mtk_ujian::where([
            'kd_mtk'      => $pecah[0],
            'paket'       => $pecah[1]

        ])->first();
        return view('admin.soalujian.createpilih_uts', compact('id', 'soal'));
    }

    public function create_essay_uts($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        // dd($pecah);
        $soal = Mtk_ujian::where([
            'kd_mtk'      => $pecah[0],
            'paket'       => $pecah[1]
        ])->first();
        return view('admin.soalujian.createessay_uts', compact('id', 'soal'));
    }

    public function store_pilihan_uts(Request $request)
    {
        $file = $request->file('file');
        if (isset($file)) {
            $this->validate($request, [

                'soal'      => 'required',
                'file'      => 'nullable|file|mimes:jpg,jpeg,png|max:2500',
                'pila'      => 'required',
                'pilb'      => 'required',
                'pilc'      => 'required',
                'pild'      => 'required',
                'pile'      => 'required',
                'kunci'     => 'required',
                // 'score'     => 'required',
                // 'status'    => 'required',
            ]);

            $file = $request->file('file');
            $file->storeAs('public/soal', $file->hashName());
            $detailsoal = Detailsoal_ujian::create([

                'kd_mtk'        => $request->input('kd_mtk'),
                'jenis'         => $request->input('jenis'),
                'soal'          => $request->input('soal'),
                'file'          => $file->hashName(),
                'pila'          => $request->input('pila'),
                'pilb'          => $request->input('pilb'),
                'pilc'          => $request->input('pilc'),
                'pild'          => $request->input('pild'),
                'pile'          => $request->input('pile'),
                'kunci'         => $request->input('kunci'),
                'score'         => 1,
                'id_user'       => $request->input('id_user'),
                'status'        => ('T'),
                'sesi'          => $request->input('sesi')

            ]);
        } else {
            $this->validate($request, [

                'soal'      => 'required',

                'pila'      => 'required',
                'pilb'      => 'required',
                'pilc'      => 'required',
                'pild'      => 'required',
                'pile'      => 'required',
                'kunci'     => 'required',
                // 'score'     => 'required',
                // 'status'    => 'required',

            ]);
            $detailsoal = Detailsoal_ujian::create([

                'kd_mtk'        => $request->input('kd_mtk'),
                'jenis'         =>  $request->input('jenis'),
                'soal'          => $request->input('soal'),
                'pila'          => $request->input('pila'),
                'pilb'          => $request->input('pilb'),
                'pilc'          => $request->input('pilc'),
                'pild'          => $request->input('pild'),
                'pile'          => $request->input('pile'),
                'kunci'         => $request->input('kunci'),
                'score'         => 1,
                'id_user'       => $request->input('id_user'),
                'status'        => ('T'),
                'sesi'          => $request->input('sesi')

            ]);
        }

        $gabung = Crypt::encryptString($request->input('kd_mtk') . ',' . $request->input('jenis'));

        if ($detailsoal) {
            return redirect('/uts-soal-show/' . $gabung)->with('status', 'Data Ditambah');
        } else {
            return redirect('/uts-soal-show/' . $gabung)->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function storeData_SoalPg(Request $request)
    {
        // Validasi
        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);

        if ($request->hasFile('file')) {
            $set = [
                'kd_mtk'    => $request->input('kd_mtk'),
                'jenis'     => $request->input('jenis'),
                'score'     => 1,
                'id_user'   => Auth::user()->kode,
                'status'    => 'T',
                'sesi'      => $request->input('sesi')
            ];
            $file = $request->file('file'); // Mengambil file

            $import = new UjianSoalpgImport($set); // Membuat instance import dengan konfigurasi
            Excel::import($import, $file); // Melakukan impor file

            // Cek jumlah pembaruan dan kirim notifikasi yang sesuai
            if ($import->getUpdatesCount() > 0) {
                // Jika ada pembaruan, kirim notifikasi tentang pembaruan
                $message = 'Upload Soal Pilihan Ganda Berhasil. ' . $import->getUpdatesCount() . ' data diperbarui.';
                return redirect()->back()->with(['success' => $message]);
            } else {
                // Jika tidak ada pembaruan, kirim notifikasi umum
                return redirect()->back()->with(['success' => 'Upload Soal Pilihan Ganda Berhasil.']);
            }
        }

        // Jika file tidak dipilih
        return redirect()->back()->with(['error' => 'Mohon pilih file terlebih dahulu.']);
    }


    public function storeData_SoalEssay(Request $request)
    {
        // Validasi
        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);

        if ($request->hasFile('file')) {
            $set = [
                'kd_mtk'  => $request->input('kd_mtk'),
                'jenis'   => $request->input('jenis'),
                'id_user' => Auth::user()->id, // Sesuaikan sesuai cara Anda mendapatkan ID pengguna
                'status'  => 'T',
            ];

            $file = $request->file('file');

            $import = new UjianSoalEssayImport($set);
            Excel::import($import, $file);

            if ($import->getUpdatesCount() > 0) {
                $message = 'Upload Soal Esai Berhasil. ' . $import->getUpdatesCount() . ' data diperbarui.';
                return redirect()->back()->with(['success' => $message]);
            } else {
                return redirect()->back()->with(['success' => 'Upload Soal Esai Berhasil.']);
            }
        }

        return redirect()->back()->with(['error' => 'Mohon pilih file terlebih dahulu.']);
    }

    public function store_essay_uts(Request $request)
    {
        // Validate the request first
        $this->validate($request, [
            'soal' => 'required',
            'kunci' => 'required',
            'file' => 'nullable|file|mimes:jpg,jpeg,png|max:2500', // This allows file to be optional
        ]);

        // Prepare data for DetailSoalEssay_ujian
        $data = [
            'kd_mtk'  => $request->input('kd_mtk'),
            'jenis'   => $request->input('jenis'),
            'soal'    => $request->input('soal'),
            'kunci'   => $request->input('kunci'),
            'status'  => 'T', // You can also use $request->input('status') if it's dynamic
            'id_user' => $request->input('id_user'),
        ];

        // Check if the file is uploaded
        $file = $request->file('file');
        if ($file) {
            $fileName = $file->hashName();
            if ($file->storeAs('public/soalessay', $fileName)) {
                $data['file'] = $fileName;
            } else {
                return redirect('/uts-soal-show/' . Crypt::encryptString($request->input('kd_mtk')))
                    ->with(['error' => 'File Upload Failed!']);
            }
        }

        // Create DetailSoalEssay_ujian
        $essaysoal = DetailSoalEssay_ujian::create($data);
        $gabung = Crypt::encryptString($request->input('kd_mtk') . ',' . $request->input('jenis'));

        // Redirect based on the result of the creation
        if ($essaysoal) {
            return redirect('/uts-soal-show/' . $gabung)->with('status', 'Data Ditambah');
        } else {
            return redirect('/uts-soal-show/' . $gabung)->with(['error' => 'Data Gagal Disimpan!']);
        }
    }


    public function show($id, Request $request)
    {

        $pecah = explode(',', Crypt::decryptString($id));
        // dd($pecah);
        if (Auth::user()->utype == 'ADM') {

            // PG
            $soals = Detailsoal_ujian::where([
                'kd_mtk'  => $pecah[0],
                'jenis'   => $pecah[1],
                'id_user' => Auth::user()->kode
            ])
                ->orderBy('created_at', 'DESC')
                ->get();
            // Check if data exists
            if ($soals->count() > 0) {
                // True, data exists
                $dataExists = true;
            } else {
                // False, data does not exist
                $dataExists = false;
            }

            // essay
            $essay = DetailSoalEssay_ujian::where([
                'kd_mtk' => $pecah[0],
                'jenis' => $pecah[1],
                'id_user' => Auth::user()->kode
            ])
                ->orderBy('created_at', 'DESC')
                ->get();

            if ($essay->count() > 0) {
                // True, data exists
                $dataExists = true;
            } else {
                // False, data does not exist
                $dataExists = false;
            }

            // Detail
            $soal = Mtk_ujian::where([
                'kd_mtk' => $pecah[0],
                'paket' => $pecah[1]

            ])->select('kd_mtk', 'paket', 'nm_mtk', 'jenis_mtk')
                ->first();
            // dd($soal);

            $aprov = ujian_aprov::where([
                'kd_mtk' => $pecah[0], // pastikan $pecah sudah didefinisikan sebelumnya
                'paket' => $pecah[1],
                'kd_dosen_perakit' => Auth::user()->kode
            ])->first();

            $aprov_essay = ujian_aprov_essay::where([
                'kd_mtk' => $pecah[0], // pastikan $pecah sudah didefinisikan sebelumnya
                'paket' => $pecah[1],
                'kd_dosen_perakit' => Auth::user()->kode
            ])->first();

            $setting = SettingUjian::where([
                'paket' => $pecah[1],
            ])->first();

            $acc = ujian_aprov::where([
                'kd_mtk' => $pecah[0],
                'paket' => $pecah[1],
                'kd_dosen_perakit' => Auth::user()->kode

            ])->select(
                'kd_mtk',
                'paket',
                'kd_dosen_perakit',
                'perakit_kirim',
                'perakit_kirim_essay',
                'tgl_perakit'
            )
                ->first();

            return view('admin.soalujian.show_uts', compact('soals', 'essay', 'soal', 'aprov', 'aprov_essay', 'setting', 'acc'));
        } else {
            return redirect('/dashboard');
        }
    }

    public function show_detailsoal_uts($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));

        $detailsoal = Detailsoal_ujian::where([
            'id'   => $pecah[0]
        ])->first();
        return view('admin.soalujian.detailsoal_uts', compact('detailsoal', 'id'));
    }
    public function show_detalessay_uts($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        $detailsoal = DetailSoalEssay_ujian::where([
            'id'   => $pecah[0]
        ])->first();
        return view('admin.soalujian.detailsoal_essay_uts', compact('detailsoal', 'id'));
    }

    public function edit_detalsoal_uts($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        $editsoal = Detailsoal_ujian::where([
            'id'   => $pecah[0]
        ])->first();
        return view('admin.soalujian.form.editsoal_uts', compact('editsoal', 'id'));
    }

    public function edit_detalessay_uts($id)
    {
        $pecah = explode(',', Crypt::decryptString($id));
        // dd($pecah);
        $editsoal = DetailSoalEssay_ujian::where([
            'id'   => $pecah[0]
        ])->first();
        return view('admin.soalujian.form.editsoal_essay_uts', compact('editsoal', 'id'));
    }


    public function kirimSoalUts($kirim)
    {
        try {
            $decrypted = Crypt::decryptString($kirim);


            [$kd_mtk, $paket, $kd_dosen] = explode(',', $decrypted);


            $affectedRows = Detailsoal_ujian::where('kd_mtk', $kd_mtk)
                ->where('jenis', $paket)
                ->where('id_user', $kd_dosen)
                ->update([
                    'sts_kirim' => 1,
                    'petugas' => Auth::user()->kode
                ]);

            Log::debug("Affected rows: $affectedRows");

            // Menggunakan DB::table untuk memasukkan data ke dalam tabel ujian_aprov
            DB::table('ujian_aprovs')->insert([
                'kd_mtk' => $kd_mtk,
                'paket' => $paket,
                'kd_dosen_perakit' => Auth::user()->kode,
                'perakit_kirim' => 1,
                'tgl_perakit' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            if ($affectedRows > 0) {
                return redirect()->back()->with('status', 'Soal berhasil dikirim.');
            } else {
                return redirect()->back()->with('error', 'Tidak ada soal yang ditemukan untuk dikirim.');
            }
        } catch (\Exception $e) {
            Log::error("Error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan.');
        }
    }

    public function kirimSoalEssayUts($kirim)
    {
        try {
            // Dekripsi string
            $decrypted = Crypt::decryptString($kirim);
            [$kd_mtk, $paket, $kd_dosen] = explode(',', $decrypted);

            // Update status kirim pada soal essay
            $affectedRows = Detailsoal_ujian::where([
                'kd_mtk' => $kd_mtk,
                'jenis' => $paket,
                'id_user' => $kd_dosen
            ])->update([
                'sts_kirim' => 1,
                'petugas' => Auth::user()->kode
            ]);

            // Tambahkan log untuk memonitor baris yang terpengaruh
            Log::debug("Affected rows: $affectedRows");

            // Insert ke tabel ujian_aprovs
            DB::table('ujian_aprovs')->insert([
                'kd_mtk' => $kd_mtk,
                'paket' => $paket,
                'kd_dosen_perakit' => Auth::user()->kode,
                'perakit_kirim_essay' => 1,
                'tgl_perakit' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Cek jika ada record yang terupdate
            if ($affectedRows > 0) {
                return redirect()->back()->with('status', 'Soal berhasil dikirim.');
            } else {
                return redirect()->back()->with('error', 'Tidak ada soal yang ditemukan untuk dikirim.');
            }
        } catch (\Exception $e) {
            Log::error("Error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengirim soal.');
        }
    }


    public function update_soalpilih_uts(Request $request, Detailsoal_ujian $detailsoal_ujian)
    {
        $this->validate($request, [
            'soal'  => 'required',
            'pila'  => 'required',
            'pilb'  => 'required',
            'pilc'  => 'required',
            'pild'  => 'required',
            'pile'  => 'required',
            'kunci' => 'required',
            'file'  => 'nullable|file|mimes:jpg,jpeg,png|max:2500', // Validation for file
        ]);

        if ($request->hasFile('file')) {
            // Remove old image
            Storage::disk('local')->delete('public/soal/' . $detailsoal_ujian->file);

            // Upload new image and get the filename
            $file = $request->file('file');
            $filename = $file->hashName();
            $file->storeAs('public/soal', $filename);

            $detailsoal_ujian->file = $filename; // Update the file name in the model
        }

        // Update other fields
        $detailsoal_ujian->update([
            'kd_mtk' => $request->input('kd_mtk'),
            'jenis'  => $request->input('jenis'),
            'soal'   => $request->input('soal'),
            'pila'   => $request->input('pila'),
            'pilb'   => $request->input('pilb'),
            'pilc'   => $request->input('pilc'),
            'pild'   => $request->input('pild'),
            'pile'   => $request->input('pile'),
            'kunci'  => $request->input('kunci'),
            'id_user' => $request->input('id_user'),
            'sesi'   => $request->input('sesi')
        ]);

        $gabung = Crypt::encryptString($request->input('kd_mtk') . ',' . $request->input('jenis'));

        return redirect('/uts-soal-show/' . $gabung)->with('status', 'Data Diupdate');
    }

    public function update_essay_uts(Request $request, DetailSoalEssay_ujian $detailSoalEssay_ujian)
    {
        $this->validate($request, [
            'soal'      => 'required',
            'kunci'      => 'required',
            'file'      => 'nullable|file|mimes:jpg,jpeg,png|max:2500',
        ]);
        if ($request->file('file') == "") {

            $detailSoalEssay_ujian = DetailSoalEssay_ujian::findOrFail($detailSoalEssay_ujian->id);
            $detailSoalEssay_ujian->update([
                'kd_mtk'        => $request->input('kd_mtk'),
                'jenis'         => $request->input('jenis'),
                'soal'          => $request->input('soal'),
                'kunci'         => $request->input('kunci'),
                // 'status'        => $request->input('status'),
                'id_user'       => $request->input('id_user')
            ]);
        } else {

            //remove old image
            Storage::disk('local')->delete('public/soalessay/' . $detailSoalEssay_ujian->file);

            //upload new image
            $image = $request->file('file');
            $image->storeAs('public/soalessay', $image->hashName());

            $detailSoalEssay_ujian = DetailSoalEssay_ujian::findOrFail($detailSoalEssay_ujian->id);
            $detailSoalEssay_ujian->update([
                'kd_mtk'         => $request->input('kd_mtk'),
                'jenis'         => $request->input('jenis'),
                'soal'          => $request->input('soal'),
                // 'status'        => $request->input('status'),
                'id_user'       => $request->input('id_user'),
                'file'          => $image->hashName()
            ]);
        }
        $gabung = Crypt::encryptString($request->input('kd_mtk') . ',' . $request->input('jenis'));

        if ($detailSoalEssay_ujian) {
            //redirect dengan pesan sukses
            return redirect('/uts-soal-show/' . $gabung)->with('status', 'Data Ditambah');
        } else {
            return redirect('/uts-soal-show/' . $gabung)->with(['error' => 'Data Gagal Disimpan!']);
        }
    }


    public function destroy(Request $request)
    {
        $idsToDelete = $request->input('deleteIds');
        if (!empty($idsToDelete)) {
            // Menggunakan Materi::destroy() untuk menghapus berdasarkan ID
            Detailsoal_ujian::destroy($idsToDelete);


            return back()->with('success', 'Materi terpilih berhasil dihapus.');
        }
        return back()->with('error', 'Tidak ada materi yang dipilih untuk dihapus.');
    }

    public function destroy_essay(Request $request)
    {
        $essayIds = $request->input('essayIds');
        if (!$essayIds) {
            return redirect()->back()->with('error', 'No essays selected for deletion.');
        }
        DetailSoalEssay_ujian::destroy($essayIds);

        return redirect()->back()->with('success', 'Selected essays have been deleted successfully.');
    }

    // Fungsi untuk mengunduh data dalam format Excel
    public function downloadDataPgdosen(Request $request)
    {
        // Validasi input
        $request->validate([
            'kd_mtk' => 'required',
            'jenis' => 'required'
        ]);

        // Ambil data berdasarkan parameter kd_mtk dan jenis_mtk
        $data = Detailsoal_ujian::select(
            'kd_mtk',
            'jenis',
            'soal',
            'file',
            'pila',
            'pilb',
            'pilc',
            'pild',
            'pile',
            'kunci'
        )->where([
            'kd_mtk' => $request->kd_mtk,
            'jenis' => $request->jenis
        ])->orderBy('created_at', 'DESC')->get();

        // Export data ke dalam file Excel
        return Excel::download(new DetailsoalExport($data), 'detail_soal_pg.xlsx');
    }
}
