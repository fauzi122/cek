<?php

namespace App\Http\Controllers\ujian\uts;

use App\Http\Controllers\ujian\DasboardujianController;
use App\Http\Controllers\Api\{AuthController};
use Illuminate\Support\Facades\Route;

Route::controller(DasboardujianController::class)->group(function () {
    Route::get('/dashboard-ujian', 'index');
});

Route::controller(SettingtimeUjianController::class)->group(function () {
    Route::get('/time-setting', 'index')->name('time-setting');
    Route::get('/detail-time-setting/{id}', 'show');
    Route::get('/edit-time-setting/{id}', 'edit');
    Route::put('/update-time-setting/{id}', 'update');
    Route::delete('/delete-time-setting/{id}', 'destroy');
});

// UJIAN master soal
Route::controller(UjianController::class)->group(function () {
    Route::get('/master-soal', 'index')->name('master-soal');
    Route::get('/uts-soal/{id}', 'index_uts');
    Route::get('/uts-soal-show/{id}', 'show');
    Route::get('/uts-create-pilih/{id}', 'create_pilih_uts');
    Route::get('/uts-create-essay/{id}', 'create_essay_uts');
    Route::post('/store/pilih-uts', 'store_pilihan_uts');
    Route::post('/store/essay-uts', 'store_essay_uts');
    Route::get('/detail/soal-show-uts/{id}', 'show_detailsoal_uts');
    Route::get('/edit-detail/soal-uts/{id}', 'edit_detalsoal_uts');
    Route::get('/edit-essay/soal-uts/{id}', 'edit_detalessay_uts');
    Route::get('/essay/soal-show-uts/{id}', 'show_detalessay_uts');
    Route::delete('/delete-soal-uts', 'destroy');
    Route::delete('/delete-soal-essay-uts', 'destroy_essay');


    Route::get('/kirim-soal-uts/{kirim}', 'kirimSoalUts')->name('kirim.soal.uts');
    Route::get('/kirim-soalessay-uts/{kirim}', 'kirimSoalEssayUts')->name('kirim.soalessay.uts');


    Route::patch('/uts-pilih/update/{detailsoal_ujian}', 'update_soalpilih_uts');
    Route::patch('/uts-essay/update/{detailSoalEssay_ujian}', 'update_essay_uts');
    Route::post('/upload-soalpg-ujian', 'storeData_SoalPg');
    Route::post('/upload-soalessay-ujian', 'storeData_SoalEssay');

    Route::post('/hapus-soal', 'hapus')->name('soal.hapus');
    Route::post('/dosen/download-data-pg', 'downloadDataPgdosen')->name('download.datapg.dosen');
});
// master ujian baak
Route::controller(MastersoalController::class)->group(function () {
    Route::get('/soal/master-baak', 'index')->name('master-soal');
    Route::get('/soal/ujian-baak/{id}', 'index_uts');
    Route::get('/baak/uts-soal-show/{id}', 'show');

    Route::get('/baak/uts-create-pilih/{id}', 'create_pilih_uts');
    Route::get('/baak/uts-create-essay/{id}', 'create_essay_uts');
    Route::post('/baak/store/pilih-uts', 'store_pilihan_uts');
    Route::post('/baak/store/essay-uts', 'store_essay_uts');

    Route::get('/baak/detail/soal-show-uts/{id}', 'show_detailsoal_uts');
    Route::get('/baak/edit-detail/soal-uts/{id}', 'edit_detalsoal_uts');
    Route::get('/baak/edit-essay/soal-uts/{id}', 'edit_detalessay_uts');
    Route::get('/baak/essay/soal-show-uts/{id}', 'show_detalessay_uts');

    Route::patch('/baak/uts-pilih/update/{detailsoal_ujian}', 'update_soalpilih_uts');
    Route::patch('/baak/uts-essay/update/{detailSoalEssay_ujian}', 'update_essay_uts');

    // Route::post('/baak/singkron-mtkuji', 'singmtkuji');
    Route::post('/baak/upload-soalpg-ujian', 'storeData_SoalPg');
    Route::post('/baak/upload-soalessay-ujian', 'storeData_SoalEssay');
});

Route::controller(ApproveController::class)->group(function () {
    Route::post('/prodi/aprov-soal', 'approveKaprodi')->name('kaprodi.approve');
    Route::post('/prodi/aprov-soal-essay', 'approveKaprodiessay')->name('kaprodi.approve.essay');
    Route::post('/baak/aprov-soal', 'approveBaak')->name('baak.approve');
    Route::post('/baak/aprov-soal-essay', 'approveBaakEssay')->name('approveBaakEssay');
    Route::post('/baak/download-data-pg', 'downloadDataPg')->name('download.datapg');
});

Route::controller(JadwalujianController::class)->group(function () {
    Route::get('/jadwal-uji-baak', 'index');
    Route::get('/baak/jadwal-ujian/{id}', 'jadwal');
    Route::get('/show/jadwal-uji-baak/{id}', 'show_uts');
    Route::get('/baak/cari-jadwal-ujian', 'search');
    Route::post('/update/jadwal-ujian', 'updateUtsSoal');
    Route::get('/edit/jadwal-ujian/{id}', 'edit');

    Route::post('/verifikasi-berita-acara', 'updateStatus')->name('verifikasi.status');
});

// pengganti mengawas
Route::controller(PenggantiMengawasController::class)->group(function () {
    Route::get('/pengganti-mengawas', 'index');
    Route::post('/stor/pengganti-mengawas', 'store');
    Route::get('/ganti-pengawas/{id}', 'edit');
    
});

// kurang bayar
Route::controller(KurangbayarController::class)->group(function () {
    Route::get('/kurang-bayar', 'index');
    
});

// kurang bayar
Route::controller(RekapBapController::class)->group(function () {
    Route::get('/rekap-bap', 'index');
    Route::get('/cari/rekap-bap', 'caribap');
    
});

// matakuliah ujian
Route::controller(MtkujianController::class)->group(function () {
    Route::get('/pilih-mtk-uji', 'utama');
    Route::get('/mtk-uji/{id}', 'index');
    Route::get('/create-mtk-uji', 'create');
    Route::post('/mtk-uji', 'store');
});
// peserta Ujian
Route::controller(PesertaujianController::class)->group(function () {
    Route::get('/peserta-ujian', 'index');
    Route::get('/peserta-ujian-uts/{id}', 'uts');
    Route::get('/baak/cari-peserta-ujian', 'cari');
    Route::post('/upload-peserta-ujian', 'storeData_Pesertaujian');
    // Route::post('/baak/pesertauji', 'singpesertauji');
    // Route::post('/baak/pesertauji-tambahan', 'singpesertauji_t');
    Route::delete('/baak-peserta/{id}/destroy', 'destroy');
    Route::get('/baak-peserta/destroy-all', 'destroy_all');
});


// panitia ujian new
Route::controller(PanitiaujianController::class)->group(function () {
    Route::get('/panitia-uji', 'index');
    Route::get('/panitia-uji-create', 'create');
    Route::get('/adm-panitia-uji', 'index_adm');
    Route::get('/adm-panitia-uji-create', 'create_adm');
    Route::post('/adm-panitia-uji', 'store_adm');
    Route::delete('/adm-panitia/{id}/destroy', 'destroy');
});

Route::controller(PerakitSoalController::class)->group(function () {
    Route::get('/perakit-soal', 'index');
    Route::get('/perakit-soal-create', 'create');
    Route::get('/adm-perakit-soal', 'index_adm');
    Route::get('/adm-perakit-soal-create', 'create_adm');
    Route::post('/adm-perakit-soal', 'store');
    Route::post('/update-stsperakit', 'updateStatus')->name('update-stsperakit');
    Route::delete('/adm-perakit-soal/{id}/destroy', 'destroy');
});

// rekap mengawas administrasi
Route::controller(AdmRekapMengawasController::class)->group(function () {
    Route::get('/adm-rekap-mengawas', 'index');
    Route::get('/adm/rekap-mengawas/{id}', 'uts');
    Route::get('/adm/show-rekap-mengawas/{id}', 'show');
    Route::get('/adm/jadwal-ujian/{id}', 'jadwal');
});

// peserta ujian Adminsistrasi
Route::controller(PesertaijianadmController::class)->group(function () {
    Route::get('/adm-peserta-uji', 'index');
    Route::get('/adm/kampus', 'kampus');
    Route::get('/adm/peserta-ujian/{id}', 'uts');
    Route::get('/adm/lihat-peserta-ujian/{kd_cabang}', 'show_cabang');
    Route::get('/adm/lihat-kls-peserta-ujian/{id_kelas}', 'show_kelas');
    Route::get('/adm/cari-peserta-ujian-uts', 'cari');
});

Route::controller(KomplainController::class)->group(function () {
    Route::get('/halaman-komplain-soal', 'halamanSoal');
    Route::get('/komplain-soal/{paket}', 'komplainSoal');
    Route::post('/api/save-location', 'lokasi');
});
