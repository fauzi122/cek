<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RekapAbsenMhs;
use App\Http\Controllers\Api\{AbsenAjarController, JadwalController};
use App\Http\Controllers\Api\Admin\LoginController;
use App\Http\Controllers\Api\Mhs\{LoginmhsController, FileController};

Route::middleware('throttle:user-agent-based')->group(function () {
Route::get('/absen-ajars', [AbsenAjarController::class, 'index']);
Route::get('/absen-ajar-praktek', [AbsenAjarController::class, 'ajar_praktek']);
Route::get('/jadwal-dosen', [AbsenAjarController::class, 'jadwal']);
Route::get('/images/{filename}', [FileController::class, 'getImage'])->where('filename', '.*');
Route::get('/images-essay/{filename}', [FileController::class, 'getImageEssay'])->where('filename', '.*');

Route::middleware('checkip')->group(function () {
    // Rute-rute yang hanya dapat diakses oleh IP yang diizinkan
    Route::get('/jadwal-kuliah', [JadwalController::class, 'index']);
    Route::get('/hapus-jadwal', [JadwalController::class, 'hapusJadwal']);
    Route::get('/jadwal-kampus', [JadwalController::class, 'jadwalKampus']);
    // Tambahkan rute-rute lain di sini
});
//group route with prefix "admin"
Route::prefix('admin')->group(function () {
    Route::post('/login-dosen', [LoginController::class, 'index']);
    Route::middleware('auth:api_admin')->group(function () {
        Route::get('/jadwal', [JadwalController::class, 'index']);
        Route::get('/user', [LoginController::class, 'getUser']);
        Route::post('/refresh', [LoginController::class, 'refreshToken']);
        Route::post('/logout', [LoginController::class, 'logout']);
    });
});

Route::prefix('mahasiswa')->group(function () {
    Route::post('/login-mhs', [LoginmhsController::class, 'index'])->name('customer.login');

    Route::middleware('auth:api_mhs')->group(function () {
        Route::get('/user', [LoginmhsController::class, 'getUser'])->name('customer.user');
        Route::get('/refresh', [LoginmhsController::class, 'refreshToken'])->name('customer.refresh');
        Route::post('/logout', [LoginmhsController::class, 'logout'])->name('customer.logout');
    });
});
});
