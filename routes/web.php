<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\administrasi\{
    KuliahpenggantiController,
    InputmanualController
};
use App\Http\Controllers\baak\UploadjadwalController;
use App\Http\Controllers\mhs\{
    JadwalmhsController,
    MaterimhsController,
    TugasmhsController,
    DiskusimhsController,
    JadwalpenggantiController,
    LatihanUjianmhsController,
    ToeflUjianmhsController,
    KuisonerpmdController
};

use App\Http\Controllers\baak\{
    MhsController,
    KpbaakController,
    PertemuanController,
    AgamakristenController,
    PenilaianController,
    MtkController,
    KrsagamaController,
    KrsmhsController,
    UserujianController,
    MbkmController,
    DosenpenggantiController
};

use App\Http\Controllers\adminbti\{
    UserstaffController,
    PengumumanController,
    UmumController,
    IpruangController,
    AkunstaffController,
    LogController
};

//administrasi
use App\Http\Controllers\administrasi\{
    Select2SearchController,
    UserdosenController,
    UsermhsController,
    JadwaldosenController,
    RekapdosenController,
    DatakelasController,
    DosenPraktisiController
};
use App\Http\Controllers\Api\{
    ApipertemuanController,
    ApiPenilaianController
};
use App\Http\Controllers\Api\Mhs\{
    LoginmhsController
};
use App\Http\Controllers\ujian\uts\KomplainController;
use App\Jobs\JobapiPenilaian;

use Illuminate\Support\Facades\Redirect;

Route::get('/', function () {
    return Redirect::to('https://elearning.bsi.ac.id');
});

Route::get('/authenticate', [AuthController::class, 'authenticateWithToken']);

Route::controller(JadwalkuliahController::class)->group(function () {
    Route::get('/jadwalkuliah/{id}',  'index')->name('jadwalkuliah');
});

Route::middleware('auth')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::group(['middleware' => 'cekadmin'], function () {
        Route::group(['middleware' => 'checksinglesession'], function () {

            include __DIR__ . '/ujian/ujian.php';
            include __DIR__ . '/ujian/toefl.php';

            // mengawas ujian di dosen
         Route::controller(MengawasController::class)->group(function () {
             Route::get('/mengawas-ujian', 'index');
             Route::get('/mengawas-uts/{id}', 'm_uts');              // -->di dalam fusngsi ini ada juga buat nilai
             Route::get('/nilai-essay-online/{id}', 'nilai_essay');  //--> di sini kusus pengganti dan her
             Route::get('/nilai-essay-online-her/{id}', 'nilai_essay_her');  //--> di sini kusus pengganti dan her

             Route::get('/show/mengawas-uts/{id}', 'show_uts');
             Route::get('/show/nilai-essay/{id}', 'show_nilai_essay');
             Route::get('/show/log-mhs/mengawas-uts/{id}', 'show_log');

             Route::post('/store/mengawas-uts/', 'store')->name('store-mengawas-ujian');
             Route::post('/store/berita-mengawas-uts/', 'updateBeritaAcara')->name('store-berita-mengaws-ujian');
             Route::post('/update-attendance', 'UpdateAbsenUjian')->name('update_attendance');
             Route::post('/update-ket-ujian', 'updateKeterangan')->name('update.ket-ujian-uts');
             Route::get('/get-nilai-essay/{id}', 'getnilaiEssay');
             Route::post('/update-nilai-essay', 'updateNilai');
        });

            // mengawas uts
        Route::controller(MengawasGabungController::class)->group(function () {
            Route::get('/show/mengawas-uts-gabung/{id}', 'show_uts');
            Route::post('/store/mengawas-uts-gabung/', 'store')->name('store-mengawas-ujian-gabung');
            Route::post('/store/berita-mengawas-uts-gabung/', 'updateBeritaAcara')->name('store-berita-mengaws-ujian-gabung');
        });

            // dasboard mengawas
        Route::controller(InfoController::class)->group(function () {
            Route::get('/dashboard', 'index')->name('dashboard');
        });


            //pengaturan user
            Route::get('/user', [UserController::class, 'index'])->name('user.index');
            Route::get('/adm/user', [UserController::class, 'adm']);

            //pengumuman
            Route::get('/announce', [UmumController::class, 'index']);
            Route::get('/add/announcement', [UmumController::class, 'create']);
            Route::post('/announce', [UmumController::class, 'store']);

            Route::get('/muser', [UserController::class, 'mhsuser'])->name('user.mhsuser');
            Route::get('/muser/json', [UserController::class, 'jsonusermhs'])->name('user.index');
            Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
            Route::post('/user', [UserController::class, 'store'])->name('user.index');
            Route::get('/user/edit/{user}', [UserController::class, 'edit'])->name('user.edit');
            Route::patch('/user/update/{user}', [UserController::class, 'update']);
            Route::delete('/hapus-user/{user}', [UserController::class, 'destroy']);

            //permissions
            Route::get('/permission', [PermissionController::class, 'index'])->name('permission.index');
            Route::get('/permission/json', [PermissionController::class, 'jsonpermission'])->name('permission.index');
            Route::get('/permission/create', [PermissionController::class, 'create'])->name('permission.create');
            Route::post('/permission', [PermissionController::class, 'store'])->name('permission.index');

            //pengaturan akses role
            Route::get('/role', [RoleController::class, 'index'])->name('role.index');
            Route::get('/role/create', [RoleController::class, 'create'])->name('role.create');
            Route::post('/role', [RoleController::class, 'store'])->name('role.index');
            Route::get('/role/edit/{role}', [RoleController::class, 'edit'])->name('role.edit');
            Route::patch('/role/update/{role}', [RoleController::class, 'update']);


             //  Api sisfo
             Route::get('/meeting', [ApipertemuanController::class, 'index']);
             Route::get('/meeting-store', [ApipertemuanController::class, 'store']);
             Route::get('/sisfo-penilaian', [ApiPenilaianController::class, 'index']);
             Route::get('/proses-penilaian/{id}', [ApiPenilaianController::class, 'proses']);
             Route::get('/sisfo-job', [JobapiPenilaian::class, 'handle']);
             Route::get('/sisfo-assessment', [ApiPenilaianController::class, 'index']);
             // Route::get('/api-penilaian', [ApiPenilaianController::class, 'apiPenilaian']);
 
             // Route::get('/dashboard', function () {
             //     return view('admin.dashboard');
             // })->name('dashboard');
       });
    });
});

Route::middleware('auth')->group(function () {
    Route::group(['middleware' => 'cekopd'], function () {
        
    });
});



require __DIR__ . '/auth.php';
