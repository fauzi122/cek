// Route::group(['middleware' => 'checksinglesession'], function () {

//     Route::get('/user/dashboard', function () {
//         return view('mhs.dashboard');
//     })->name('dashboard');
//     Route::controller(KuisonerpmdController::class)->group(function () {
//         Route::get('/kuisoner-mpd', 'index');
//         Route::post('/store/kuisoner-mpd', 'store');
//     });
//     Route::get('/halaman-ujian', [LoginmhsController::class, 'redirectToUjian'])->name('Ujian.redirect');

//     //materi dan tugas
//     Route::get('/sch', [JadwalmhsController::class, 'index']);
//     Route::get('/learning/{id}', [MaterimhsController::class, 'index'])->name('mhs.materi.index');
//     Route::post('/download-file-materi', [MaterimhsController::class, 'download_file_materi']);
//     Route::get('/assignment/{id}', [TugasmhsController::class, 'index'])->name('mhs.tugas.index');
//     Route::get('/assignment/send/{id}', [TugasmhsController::class, 'send'])->name('mhs.tugas.send');
//     Route::post('/assignment', [TugasmhsController::class, 'store']);
//     Route::post('/download-file-tugas', [TugasmhsController::class, 'download_file_tugas']);

//     //Forum Diskusi
//     Route::get('/form-diskusimhs/{id}', [DiskusimhsController::class, 'index']);
//     Route::post('/tambah-diskusimhs', [DiskusimhsController::class, 'store_diskusi']);
//     Route::get('/form-komentarmhs/{id}', [DiskusimhsController::class, 'komentar']);
//     Route::post('/send-komentarmhs', [DiskusimhsController::class, 'store_komen']);
//     Route::delete('/hapus-diskusimhs/{id}', [DiskusimhsController::class, 'destroy_diskusi']);
//     Route::post('/download-file-diskusimhs', [DiskusimhsController::class, 'download_file_diskusi']);

//     //Absen Mahasiswa
//     Route::get('/absen-mhs/{id}', [JadwalmhsController::class, 'show_absen']);
//     Route::get('/rekap-side/{id}', [JadwalmhsController::class, 'rekap_side']);
//     Route::post('/mhs-absen', [JadwalmhsController::class, 'mhs_absen']);
//     Route::post('/komentar-mhs', [JadwalmhsController::class, 'komentar_mhs']);
//     Route::get('/modul-mbkm', [JadwalmhsController::class, 'modul']);
//     //Kuliah Pengganti
//     Route::get('/kuliah-pengganti', [JadwalpenggantiController::class, 'index']);
//     Route::get('/absen-mhs-pengganti/{id}', [JadwalpenggantiController::class, 'show_absen']);

//     // latihan ujian mhs
//     Route::get('/exercise', [LatihanUjianmhsController::class, 'index']);
//     Route::get('/exercise-show/{id}', [LatihanUjianmhsController::class, 'show']);
//     Route::post('/jawaban', [LatihanUjianmhsController::class, 'jawab']);
//     Route::get('/penomoran', [LatihanUjianmhsController::class, 'getNomor']);
//     Route::get('/get-soal', [LatihanUjianmhsController::class, 'getSoal']);
//     Route::get('/get-soal_essay', [LatihanUjianmhsController::class, 'getDetailEssay']);
//     Route::get('/simpan-jawaban-essay', [LatihanUjianmhsController::class, 'simpanJawabanEssay']);
//     Route::get('/selesai-ujian/{id}', [LatihanUjianmhsController::class, 'selesai_ujian']);
//     Route::get('/cetak-ujian-pdf/{id}', [LatihanUjianmhsController::class, 'cetak_pdf']);

//     // Toefl
//     Route::get('/toefl', [ToeflUjianmhsController::class, 'index']);
//     Route::get('/toefl-show/{id}', [ToeflUjianmhsController::class, 'show']);
//     Route::post('/toefl-jawaban', [ToeflUjianmhsController::class, 'jawab']);
//     Route::get('/toefl-penomoran', [ToeflUjianmhsController::class, 'getNomor']);
//     Route::get('/toefl-get-soal', [ToeflUjianmhsController::class, 'getSoal']);
//     Route::get('/toefl-get-soal_essay', [ToeflUjianmhsController::class, 'getDetailEssay']);
//     Route::get('/toefl-simpan-jawaban-essay', [ToeflUjianmhsController::class, 'simpanJawabanEssay']);
//     Route::get('/toefl-selesai-ujian/{id}', [ToeflUjianmhsController::class, 'selesai_ujian']);
//     Route::get('/toefl-cetak-ujian-pdf/{id}', [ToeflUjianmhsController::class, 'cetak_pdf']);
//     Route::post('/download-file-toef', [ToeflUjianmhsController::class, 'download_file_toef']);
// });