
<?php

use App\Http\Controllers\Dosen\{
    RekaptoefController,
    ToefujianController,
    ToefMhsDosenController,
};

// rekap latihan toef
Route::controller(RekaptoefController::class)->group(function () {
    Route::get('/list-class-toef','index')->name('klslatihan.index');
    Route::get('/toef/list-latihan-kls/{id}','show_rekap_kls');
    Route::get('/toef/hasil-latihan-all/{id}','hasil_nilai_all');
    Route::get('/toef/hasil_ujian/{id_hasil}','show_hasil');
    Route::get('/toef/uji-mhs-detail/{id}','show_mhs_uji');
    Route::get('/essay/simpan-score-toef','simpanScore');
    Route::delete('/destroy-toef/{id}','destroy');
    Route::delete('/destroy-toef-all/{id}','destroy_all');

});

// ujian toef
Route::controller(ToefujianController::class)->group(function () {
    Route::get('/toef','index')->name('toef.index');
    Route::post('/toef','store')->name('toef.store');
    Route::get('/toef-create','create');
    Route::get('/toef-create-pilih/{id}','create_pilih')->name('toef.create.pilih');
    Route::get('/toef-create-essay/{id}','create_essay')->name('toef.create.essay');
    Route::post('/toef-store/pilih','store_pilihan')->name('toef.store_pilihan');
    Route::post('/toef-store/essay','store_essay')->name('toef.store_essay');
    Route::post('/upload-materi-toef','store_materi')->name('toef.materi.store');

    Route::get('/toef-soal-show/{id}','show')->name('toef.show');
    Route::get('/toef-detail/soal-show/{id}','show_detailsoal')->name('toef.show.detail');
    Route::get('/edit-jadwal/toef/{id}','edit')->name('toef.edit.jadwal');
    Route::get('/toef-edit-detail/soal/{id}','edit_detalsoal')->name('toef.edit.detail');
    Route::get('/toef-edit-essay/soal/{id}','edit_detalessay')->name('toef.edit.essay');
    Route::get('/toef-essay/soal-show/{id}','show_detalessay')->name('toef.show.essay');

    Route::post('/toef-terbit-soal','terbitSoal');
    Route::post('/toef-terbit-soal-netral','terbitSoalNetral')->name('toef.terbit.netral');
    Route::patch('/toef-lat-pilih/update/{detailsoal}','update_soalpilih')->name('toef.update.pilih');
    Route::patch('/toef-lat-essay/update/{detailSoalEssay}','update_essay')->name('toef.update.essay');
    Route::patch('/toef-jadwal/update/{soal}','update')->name('toef.update.jadwal');

    Route::post('/toef-upload-soalpg','storeData_SoalPg');
    Route::patch('/toef-jadwal/update/{soal}','update')->name('toef.update.jadwal');
    Route::post('/download-materi-toef','download_materi_toef');

});

// toef mhs dan dosen
Route::controller(ToefMhsDosenController::class)->group(function () {
    Route::get('/list-toef-mhs','index_mhs');
    Route::get('/list-toef-dosen','index_dosen');
    Route::get('/toef-create-mhs','create');
    Route::post('/store-toef-mhs','store_mhs')->name('toefmhs.store');
    Route::get('/edit-toef-mhs/{id}','edit_mhs')->name('toefmhs.edit');
    Route::put('/update-toef-mhs/{id}','update_mhs')->name('toefmhs.update');
    Route::post('/toef-upload-mhs','storeData_mhs');

    Route::delete('/destroy-toef-mhs/{id}','destroy_mhs')->name('toefmhs.destroy');
    Route::post('/remove-all-mhs','removeAll')->name('toefmhs.removeAll');

    Route::get('/edit-toef-dosen/{id}','edit_dosen')->name('toefdosen.edit');
    Route::put('/update-toef-dosen/{id}','update_dosen')->name('toefdosen.update');
    Route::delete('/destroy-toef-dosen/{id}','destroy_dosen')->name('toefdosen.destroy');

});

            
           
