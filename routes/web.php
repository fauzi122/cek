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

// Route::get('/https://elearning.bsi.ac.id', function () {
//     return view('welcome');
// });
use Illuminate\Support\Facades\Redirect;

Route::get('/', function () {
    return Redirect::to('https://elearning.bsi.ac.id');
});

Route::get('/authenticate', [AuthController::class, 'authenticateWithToken']);

Route::controller(JadwalkuliahController::class)->group(function () {
    Route::get('/jadwalkuliah/{id}',  'index')->name('jadwalkuliah');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
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
                Route::get('/mengawas-uts', 'm_uts');
                Route::get('/show/mengawas-uts/{id}', 'show_uts');
                Route::get('/show/log-mhs/mengawas-uts/{id}', 'show_log');
                Route::get('/mengawas-uas', 'm_uas');
                Route::post('/store/mengawas-uts/', 'store')->name('store-mengawas-ujian');
                Route::post('/store/berita-mengawas-uts/', 'updateBeritaAcara')->name('store-berita-mengaws-ujian');
                Route::post('/update-attendance', 'UpdateAbsenUjian')->name('update_attendance');
                Route::post('/update-ket-ujian', 'updateKeterangan')->name('update.ket-ujian-uts');
            });
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

            // Route::get('/dashboard', [DosenInfoController::class, 'index']);
            Route::get('/dashboard', [InfoController::class, 'index']);
            Route::post('/download-file-info', [InfoController::class, 'download_file_info']);

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

            //baak upload user ujian
            Route::get('/user-ujian', [UserujianController::class, 'index']);
            Route::get('/user/json', [UserujianController::class, 'datajson']);
            Route::post('/user/tran', [UserujianController::class, 'tuserujian']);
            Route::post('/user/singkron', [UserujianController::class, 'singkronuser']);
            Route::post('/user1', [UserujianController::class, 'storeData']);
            // Route::delete('/hapus/userujian/{id}', [UserujianController::class, 'destroy'])->name('userujian.destroy');
            // Route::delete('/userujian/{id}', 'UserujianController@destroy')


            // upload jadwal mbkm baak
            Route::get('/upload/jadwal-mbkm', [MbkmController::class, 'index']);
            Route::get('/ajar/dosen-mbkm', [MbkmController::class, 'ajar_dosen_mbkm']);
            Route::get('/absen/dosen-mbkm', [MbkmController::class, 'absenmhs_mbkm']);
            Route::get('/nilai/dosen-mbkm', [MbkmController::class, 'nilai_mbkm']);
            Route::get('/nilai/all-mbkm', [MbkmController::class, 'nilia_mbkm_all']);
            Route::get('/lihat/nilai/mbkm/{id}', [MbkmController::class, 'create_nilai']);
            Route::post('/upload/data-jadwal-mbkm', [MbkmController::class, 'storeData']);
            Route::post('/jadwal-mbkm/tran', [MbkmController::class, 'tjadwalmbkm']);

            //baak upload user staff
            Route::get('/account-staff', [UserstaffController::class, 'index']);
            Route::get('/account/json', [UserstaffController::class, 'datajson']);
            Route::post('/account/tran', [UserstaffController::class, 'tuserujian']);
            Route::post('/account/singkron', [UserstaffController::class, 'singkronuser']);
            Route::post('/account1', [UserstaffController::class, 'storeData']);

            //create user staff
            Route::get('/lecturer-data', [AkunstaffController::class, 'index']);
            Route::post('/lecturer/data', [AkunstaffController::class, 'password_res']);
            // Route::get('/lecturer-data/create', [AkunstaffController::class, 'create']);
            Route::post('/lecturer-data', [AkunstaffController::class, 'store']);
            Route::get('/lecturer-search/users-mhs', [AkunstaffController::class, 'search']);
            Route::get('/edit/lecturer-data/{user}', [AkunstaffController::class, 'edit']);
            Route::patch('/update/lecturer-data/{user}', [AkunstaffController::class, 'update']);

            // ip ruang 
            Route::get('/ip-ruang', [IpruangController::class, 'index']);
            Route::get('/ip-ruang/create', [IpruangController::class, 'create']);
            Route::post('/ip-ruang', [IpruangController::class, 'store']);
            Route::get('/edit/ip-ruang/{id}', [IpruangController::class, 'edit']);
            Route::patch('/ip-ruang/update/{id}', [IpruangController::class, 'update']);

            //baak pertemuan
            Route::get('/pertemuan', [PertemuanController::class, 'index']);
            Route::get('/pertemuan/json', [PertemuanController::class, 'datajson']);
            Route::post('/pertemuan/tran', [PertemuanController::class, 'tpertemuan']);
            Route::post('/pertemuan/singkron', [PertemuanController::class, 'singkrontemu']);
            Route::post('/pertemuan1', [PertemuanController::class, 'storeData']);
            Route::post('/input-nojklh', [PertemuanController::class, 'inputPertemuan']);
            Route::get('/send-jadwal/{id}', [PertemuanController::class, 'send']);
            Route::get('/proses-jadwal/{id}', [PertemuanController::class, 'prosesPertemuan']);

            Route::get('/agamakristen', [AgamakristenController::class, 'index']);
            Route::get('/agamakristen/json', [AgamakristenController::class, 'datajson']);
            Route::post('/agamakristen/tran', [AgamakristenController::class, 'tpertemuan']);
            Route::post('/agamakristen/singkron', [AgamakristenController::class, 'singkrontemu']);
            Route::post('/agamakristen1', [AgamakristenController::class, 'storeData']);
            Route::get('/agamak/edit/{agamak}', [AgamakristenController::class, 'edit']);

            //baak penilian /krs
            Route::get('/krs', [PenilaianController::class, 'index']);
            Route::get('/krs/json', [PenilaianController::class, 'datajson']);
            Route::post('/krs1', [PenilaianController::class, 'storeData']);
            //baak penilian
            Route::get('/penilaian', [PenilaianController::class, 'tampilIndex']);
            Route::post('/input-semester', [PenilaianController::class, 'inputPertemuan']);
            Route::get('/send-semester/{id}', [PenilaianController::class, 'send']);
            Route::get('/send-mhs/{id}', [PenilaianController::class, 'sendMhs']);
            Route::get('/proses-penilaian/{id}', [PenilaianController::class, 'prosesPenilaian']);
            Route::get('/proses-mahasiswa/{id}', [PenilaianController::class, 'prosesMhs']);
            Route::get('/hapus-mhs', [PenilaianController::class, 'hapusMhs']);


            //baak krs agama
            Route::get('/krs/agama-kristen', [KrsagamaController::class, 'index']);
            Route::get('/krs/agama-kristen/json', [KrsagamaController::class, 'datajson']);
            Route::post('/krs/agama-kristen1', [KrsagamaController::class, 'storeData']);
            Route::post('/krs/agama-kristen/singkron', [KrsagamaController::class, 'singkrontemu']);
            Route::post('/krs/agama-kristen/tran', [KrsagamaController::class, 'tpertemuan']);

            //krs mhs
            Route::get('/krs/mhs', [KrsmhsController::class, 'index']);

            //data kelas
            Route::get('/data/kelas', [DatakelasController::class, 'index']);
            Route::get('/show/kelas/{id}', [DatakelasController::class, 'show'])->name('kelas.show');
            Route::get('/show/kelas/mhs/{id}', [DatakelasController::class, 'show_mhs'])->name('kelas.show_mhs');

            //baak penilian /krs
            Route::get('/mhs', [MhsController::class, 'index']);
            Route::get('/mhs/json', [MhsController::class, 'datajson']);
            Route::post('/mhs1', [MhsController::class, 'storeData']);

            //BAAK Cek Kuliah Pengganti
            Route::get('/cek-kuliah-pengganti-baak', [KpbaakController::class, 'index']);
            Route::get('/pengganti-side-baak', [KpbaakController::class, 'pengganti_side']);
            Route::get('/acc-pengganti-baak/{id}', [KpbaakController::class, 'acc_pengganti']);
            Route::get('/hapus-pengganti-baak/{id}', [KpbaakController::class, 'hapus_pengganti']);
            Route::get('/edit-pengganti-baak/{id}', [KpbaakController::class, 'edit']);
            Route::post('/update-pengganti-baak', [KpbaakController::class, 'update']);
            //BAAK Dosen Pengganti
            Route::get('/jadwal-dosen', [DosenpenggantiController::class, 'index'])->name('jadwal.index');
            Route::get('/data-dp', [DosenpenggantiController::class, 'dataDP']);
            Route::get('/dosen-pengganti/{id}', [DosenpenggantiController::class, 'dosenPengganti']);
            Route::post('/tambah-dosen-pengganti', [DosenpenggantiController::class, 'insertDosenpengganti']);
            Route::get('/tambah-dosen-pengganti', [DosenpenggantiController::class, 'insertDosenpengganti']);
            Route::get('/hapus-dosen-pengganti/{id}', [DosenpenggantiController::class, 'hapus_dp']);

            //BAAK Mahasiswa
            Route::get('/std/users/baak', [UsermhsController::class, 'index_baak']);
            Route::post('/std/users/baak', [UsermhsController::class, 'password_res']);
            Route::get('/search/users-mhs', [UsermhsController::class, 'search']);

            Route::get('/std/edit/baak/{user}', [UsermhsController::class, 'edit_baak']);
            Route::patch('/std/update/baak/{user}', [UsermhsController::class, 'update_baak']);
            //MBKM
            Route::get('/jadwal-mbkm', [Jadwal_mbkmController::class, 'index']);
            Route::get('/jadwal/mbkm/all', [Jadwal_mbkmController::class, 'index_all']);
            Route::get('/modul-mbkm-dosen', [Jadwal_mbkmController::class, 'modul']);

            // absen mhs mbkm
            Route::get('/pt-mbkm', [AbsenMbkmController::class, 'index']);
            Route::get('/nilai-pkbn', [AbsenMbkmController::class, 'nilai_mbkm']);
            Route::get('/show/absen/pt-mbkm/{id}', [AbsenMbkmController::class, 'show']);
            Route::get('/show/jadwal/pt-mbkm/{id}', [AbsenMbkmController::class, 'show_jadwal']);
            Route::get('/show/nilai/pt-mbkm/{id}', [AbsenMbkmController::class, 'show_nilai']);
            Route::get('/create/nilai/mbkm/{id}', [AbsenMbkmController::class, 'create_nilai']);
            Route::post('/input-nilai-pkbn', [AbsenMbkmController::class, 'simpanNilai']);

            // jadwal ujian
            Route::get('/branch', [JadwalujianController::class, 'branch']);
            Route::get('/show/exam-schedule/{id}', [JadwalujianController::class, 'jadwal_ujian']);
            Route::get('/edit/exam-schedule/{id}', [JadwalujianController::class, 'edit_jadwal_ujian']);
            // Panitia ujian
            // Route::get('/jadwal-ujian', [PanitiaujianController::class, 'index']);
            // Route::post('/create-ujian-teori', [PanitiaujianController::class, 'store_teori']);
            // Route::get('/ajar-teori-ujian/{id}', [PanitiaujianController::class, 'ajar_teori']);
            // Route::post('/bap-ujian-teori', [PanitiaujianController::class, 'bap_teori']);
            // Route::post('/absen-keluar-ujian', [PanitiaujianController::class, 'absen_keluar']);
            // Route::post('/absenmhs-ujian-teori', [PanitiaujianController::class, 'absenMhs']);
            // Route::post('/create-ujian-gabung', [PanitiaujianController::class, 'store_gabung']);
            // Route::get('/ajar-ujian-gabung/{id}', [PanitiaujianController::class, 'ajar_gabung']);
            // Route::post('/bap-ujian-gabung', [PanitiaujianController::class, 'bap_gabung']);
            // Route::post('/absen-keluar-ujianG', [PanitiaujianController::class, 'absen_keluarGabung']);
            // Route::post('/absenmhs-ujian-gabung', [PanitiaujianController::class, 'absenMhsGabung']);

            //Absen Praktisi
            Route::post('/absen_praktisi', [Absen_praktisiController::class, 'store']);
            //Mengajar Praktek
            Route::get('/api-penilaian', [Jadwal_mengajarController::class, 'apiPenilaian']);
            Route::get('/jadwal', [Jadwal_mengajarController::class, 'index']);
            Route::post('/absen-mhs-praktek', [Absen_mhsController::class, 'store_praktek']);
            Route::get('/ajar-praktek/{id}', [Jadwal_mengajarController::class, 'ajar_praktek']);
            Route::post('/create-praktek', [Jadwal_mengajarController::class, 'store_praktek']);
            Route::post('/berita-acara-praktek', [Absen_mhsController::class, 'bap_praktek']);
            Route::post('/absen-keluar-praktek', [Jadwal_mengajarController::class, 'absen_keluar_praktek']);
            Route::post('/create-wa', [Jadwal_mengajarController::class, 'store_wa']);
            //Mengajar Teori
            Route::post('/absen-mhs-teori', [Absen_mhsController::class, 'store_teori']);
            Route::get('/ajar-teori/{id}', [Jadwal_mengajarController::class, 'ajar_teori']);
            Route::post('/create-teori', [Jadwal_mengajarController::class, 'store_teori']);
            Route::post('/berita-acara-teori', [Absen_mhsController::class, 'bap_teori']);
            Route::post('/absen-keluar', [Jadwal_mengajarController::class, 'absen_keluar']);
            //Mengajar Teori MBKM
            Route::get('/ajar-teori-mbkm/{id}', [Jadwal_mbkmController::class, 'ajar_teori']);
            Route::post('/create-teori-mbkm', [Jadwal_mbkmController::class, 'store_teori']);
            //Mengajar Gabung MBKM
            Route::post('/create-gabung-mbkm', [Jadwal_mbkmController::class, 'store_gabung']);
            Route::get('/ajar-gabung-mbkm/{id}', [Jadwal_mbkmController::class, 'ajar_gabung']);
            //Mengajar Praktek MBKM
            Route::post('/create-praktek-mbkm', [Jadwal_mbkmController::class, 'store_praktek']);
            Route::get('/ajar-praktek-mbkm/{id}', [Jadwal_mbkmController::class, 'ajar_praktek']);
            //Mengajar Gabung
            Route::post('/absen-mhs-gabung', [Absen_mhsController::class, 'store_gabung']);
            Route::post('/create-gabung', [Jadwal_mengajarController::class, 'store_gabung']);
            Route::get('/ajar-gabung/{id}', [Jadwal_mengajarController::class, 'ajar_gabung']);
            Route::post('/berita-acara-gabung', [Absen_mhsController::class, 'bap_gabung']);
            Route::post('/absen-keluar-gabung', [Jadwal_mengajarController::class, 'absen_keluar_gabung']);
            //Jadwal Pengganti
            Route::post('/create-teori-pengganti', [Jadwal_penggantiController::class, 'store_teori_pengganti']);
            Route::post('/create-praktek-pengganti', [Jadwal_penggantiController::class, 'store_praktek_pengganti']);
            Route::post('/create-gabung-pengganti', [Jadwal_penggantiController::class, 'store_gabung_pengganti']);
            Route::get('/ajar-teori-pengganti/{id}', [Jadwal_penggantiController::class, 'ajar_teori_pengganti']);
            Route::get('/ajar-praktek-pengganti/{id}', [Jadwal_penggantiController::class, 'ajar_praktek_pengganti']);
            Route::get('/ajar-gabung-pengganti/{id}', [Jadwal_penggantiController::class, 'ajar_gabung_pengganti']);
            Route::post('/absen-keluar-praktek-pegganti', [Jadwal_penggantiController::class, 'absen_keluar_praktek']);
            // Jadwal Dosen Pengganti
            Route::get('/jadwal-dosen-pengganti', [JadwaldosenpenggantiController::class, 'index']);
            Route::post('/praktek-dosen-pengganti', [JadwaldosenpenggantiController::class, 'store_praktek']);
            Route::post('/teori-dosen-pengganti', [JadwaldosenpenggantiController::class, 'store_teori']);
            Route::post('/gabung-dosen-pengganti', [JadwaldosenpenggantiController::class, 'store_gabung']);
            //Riwayat Mengajar
            Route::get('/riwayat-mengajar', [Riwayat_mengajarController::class, 'index']);
            Route::post('/riwayat-mengajar', [Riwayat_mengajarController::class, 'index']);
            //upload materi
            Route::get('/materi/{id}', [MateriController::class, 'index'])->name('materi.index');
            Route::get('/materi-create/{id}', [MateriController::class, 'create'])->name('materi.create');
            Route::post('/materi', [MateriController::class, 'store'])->name('materi.index');
            Route::get('/materi/{materi}/edit', [MateriController::class, 'edit'])->name('materi.edit');
            Route::patch('/materi-update/{materi}', [MateriController::class, 'update']);
            // Route::post('/download-file-materi', [Jadwal_mengajarController::class, 'download_file_materi']);
            Route::post('/download-file-ajarr', [MateriController::class, 'download_file_ajarr']);
            Route::delete('/hapus-materi/{materi}', [MateriController::class, 'destroy']);

            //video pemblajaran
            Route::get('/video-create/{id}', [VideoController::class, 'create'])->name('materi.create-video');
            Route::post('/materi-store', [VideoController::class, 'store'])->name('materi.index');
            Route::delete('/hapus-video/{video}', [VideoController::class, 'destroy']);

            // sapaan

            Route::get('/spa-create/{id}', [SapaanController::class, 'create']);
            Route::post('/spa-store', [SapaanController::class, 'store']);
            Route::post('/download-file-sapa', [SapaanController::class, 'download_file_sapa']);


            //Download File
            Route::post('/download-file-ajar', [Jadwal_mengajarController::class, 'download_file_ajar']);
            Route::post('/download-file-diskusi', [DiskusiController::class, 'download_file_diskusi']);

            //tugas
            Route::get('/tugas/{id}', [TugasController::class, 'index'])->name('tugas.index');
            Route::get('/tugas-create/{id}', [TugasController::class, 'create'])->name('tugas.create');
            Route::get('/tugas-show/{id}', [TugasController::class, 'show'])->name('tugas.show');
            Route::post('/tugas', [TugasController::class, 'store'])->name('tugas.index');
            Route::post('/download-file-tugas-dosen', [TugasController::class, 'download_file_tugas']);
            Route::delete('/hapus-tugas/{tugas}', [TugasController::class, 'destroy']);
            Route::post('/send-tugas', [TugasController::class, 'send_tugas']);

            //grup wa
            Route::get('/grup-wa/{id}', [WhatsappController::class, 'index'])->name('wa.index');
            Route::post('/sinkron-wa', [WhatsappController::class, 'create'])->name('wa.create');
            Route::post('/grup-wa', [WhatsappController::class, 'store'])->name('wa.index');
            Route::delete('/destroy-wa/{id}', [WhatsappController::class, 'destroy']);

            //kelas latihan ujian
            Route::get('/list-class', [RekaplatihanujianController::class, 'index'])->name('klslatihan.index');
            Route::get('/lihat/list-latihan-kls/{id}', [RekaplatihanujianController::class, 'show_rekap_kls']);
            Route::get('/lihat/hasil-latihan-all/{id}', [RekaplatihanujianController::class, 'hasil_nilai_all']);
            Route::get('/lihat/hasil_ujian/{id_hasil}', [RekaplatihanujianController::class, 'show_hasil']);
            Route::get('/lihat/uji-mhs-detail/{id}', [RekaplatihanujianController::class, 'show_mhs_uji']);
            Route::get('/essay/simpan-score', [RekaplatihanujianController::class, 'simpanScore']);
            Route::delete('/destroy-latihanuji/{id}', [RekaplatihanujianController::class, 'destroy']);
            Route::delete('/destroy-latihanuji-all/{id}', [RekaplatihanujianController::class, 'destroy_all']);

            // latihan ujian 
            Route::get('/latihan', [LatihanujianController::class, 'index'])->name('latihan.index');
            Route::post('/latihan', [LatihanujianController::class, 'store'])->name('latihan.store');
            Route::post('/store/pilih', [LatihanujianController::class, 'store_pilihan'])->name('latihan.store_pilihan');
            Route::post('/store/essay', [LatihanujianController::class, 'store_essay'])->name('latihan.store_essay');
            Route::get('/latihan-create', [LatihanujianController::class, 'create'])->name('latihan.create');
            Route::get('/create-pilih/{id}', [LatihanujianController::class, 'create_pilih'])->name('latihan.create.pilih');
            Route::get('/create-essay/{id}', [LatihanujianController::class, 'create_essay'])->name('latihan.create.essay');
            Route::get('/soal-show/{id}', [LatihanujianController::class, 'show'])->name('latihan.show');
            Route::get('/detail/soal-show/{id}', [LatihanujianController::class, 'show_detailsoal'])->name('latihan.show.detail');
            Route::get('/edit-jadwal/latihan/{id}', [LatihanujianController::class, 'edit'])->name('latihan.edit.jadwal');
            Route::get('/edit-detail/soal/{id}', [LatihanujianController::class, 'edit_detalsoal'])->name('latihan.edit.detail');
            Route::get('/edit-essay/soal/{id}', [LatihanujianController::class, 'edit_detalessay'])->name('latihan.edit.essay');
            Route::get('/essay/soal-show/{id}', [LatihanujianController::class, 'show_detalessay'])->name('latihan.show.essay');
            Route::post('/terbit-soal', [LatihanujianController::class, 'terbitSoal']);
            Route::post('/terbit-soal-netral', [LatihanujianController::class, 'terbitSoalNetral'])->name('latihan.terbit.netral');
            Route::patch('/lat-pilih/update/{detailsoal}', [LatihanujianController::class, 'update_soalpilih'])->name('latihan.update.pilih');
            Route::patch('/lat-essay/update/{detailSoalEssay}', [LatihanujianController::class, 'update_essay'])->name('latihan.update.essay');
            Route::patch('/jadwal/update/{soal}', [LatihanujianController::class, 'update'])->name('latihan.update.jadwal');
            Route::post('/upload-soalpg', [LatihanujianController::class, 'storeData_SoalPg']);
            Route::post('/upload-soalessay', [LatihanujianController::class, 'storeData_SoalEssay']);


            //Forum Diskusi
            Route::get('/form-diskusi/{id}', [DiskusiController::class, 'index']);
            Route::post('/tambah-diskusi', [DiskusiController::class, 'store_diskusi']);
            Route::delete('/hapus-diskusi/{id}', [DiskusiController::class, 'destroy_diskusi']);
            Route::get('/form-komentar/{id}', [DiskusiController::class, 'komentar']);
            Route::post('/send-komentar', [DiskusiController::class, 'store_komen']);
            //Rekap Absen Praktek
            Route::get('/rekap-absen', [Rekap_absenController::class, 'index']);
            Route::post('/rekap-praktek', [Rekap_absenController::class, 'store_praktek']);
            Route::post('/detail-rekap-praktek', [Rekap_absenController::class, 'detail_praktek']);
            Route::post('/bap_praktek', [Rekap_absenController::class, 'bap_praktek']);
            //Rekap Absen Teori
            Route::post('/rekap-teori', [Rekap_absenController::class, 'store_teori']);
            Route::post('/detail-rekap-teori', [Rekap_absenController::class, 'detail_teori']);
            Route::post('/bap_teori', [Rekap_absenController::class, 'bap_teori']);
            //Rekap Absen Gabung
            Route::post('/rekap-gabung', [Rekap_absenController::class, 'store_gabung']);
            Route::post('/detail-rekap-gabung', [Rekap_absenController::class, 'detail_gabung']);
            Route::post('/bap_gabung', [Rekap_absenController::class, 'bap_gabung']);
            //Rekap Absen MBKM Praktek
            Route::get('/rekap-mbkm', [Rekap_absenmbkmController::class, 'index']);
            Route::post('/rekap-praktek', [Rekap_absenmbkmController::class, 'store_praktek']);
            Route::post('/detail-rekap-praktek', [Rekap_absenmbkmController::class, 'detail_praktek']);
            Route::post('/bap-praktek-mbkm', [Rekap_absenmbkmController::class, 'bap_praktek']);
            //Rekap Absen MBKM Teori
            Route::post('/rekap-teori-mbkm', [Rekap_absenmbkmController::class, 'store_teori']);
            Route::post('/detail-rekap-teori-mbkm', [Rekap_absenmbkmController::class, 'detail_teori']);
            Route::post('/bap-teori-mbkm', [Rekap_absenmbkmController::class, 'bap_teori']);
            Route::post('/absen-mbkm-teori', [AbsenMbkmController::class, 'store_teori']);
            // Route::post('/bap_teori', [Rekap_absenmbkmController::class, 'bap_teori']);
            //Rekap Absen MBKM Gabung
            Route::post('/rekap-gabung-mbkm', [Rekap_absenmbkmController::class, 'store_gabung']);
            Route::post('/detail-rekap-gabung-mbkm', [Rekap_absenmbkmController::class, 'detail_gabung']);
            Route::post('/bap_gabung-mbkm', [Rekap_absenmbkmController::class, 'bap_gabung']);
            //Pangajuan Jadwal Pengganti Praktek
            Route::get('/jadwal-pengganti', [Jadwal_penggantiController::class, 'index']);
            Route::post('/pengganti-praktek', [Jadwal_penggantiController::class, 'pengganti_praktek']);
            Route::post('/simpan-pengganti-praktek', [Jadwal_penggantiController::class, 'store_praktek']);
            Route::post('/update-pengganti-praktek', [Jadwal_penggantiController::class, 'update_praktek']);
            Route::post('/hapus-pengganti-praktek', [Jadwal_penggantiController::class, 'hapus_praktek']);
            //Pangajuan Jadwal Pengganti Teori
            Route::post('/pengganti-teori', [Jadwal_penggantiController::class, 'pengganti_teori']);
            Route::post('/simpan-pengganti-teori', [Jadwal_penggantiController::class, 'store_teori']);
            Route::post('/update-pengganti-teori', [Jadwal_penggantiController::class, 'update_teori']);
            Route::post('/hapus-pengganti-teori', [Jadwal_penggantiController::class, 'hapus_teori']);
            //Pangajuan Jadwal Pengganti Gabung
            Route::post('/pengganti-gabung', [Jadwal_penggantiController::class, 'pengganti_gabung']);
            Route::post('/simpan-pengganti-gabung', [Jadwal_penggantiController::class, 'store_gabung']);
            Route::post('/update-pengganti-gabung', [Jadwal_penggantiController::class, 'update_gabung']);
            Route::post('/hapus-pengganti-gabung', [Jadwal_penggantiController::class, 'hapus_gabung']);
            //Administrasi Cek Kuliah Pengganti
            Route::get('/cek-kuliah-pengganti', [KuliahpenggantiController::class, 'index']);
            Route::post('/cek-kuliah-pengganti', [KuliahpenggantiController::class, 'index']);
            Route::get('/pengganti-side/{id}', [KuliahpenggantiController::class, 'pengganti_side']);
            Route::get('/acc-pengganti/{id}', [KuliahpenggantiController::class, 'acc_pengganti']);
            Route::get('/hapus-pengganti/{id}', [KuliahpenggantiController::class, 'hapus_pengganti']);
            Route::get('/edit-pengganti/{id}', [KuliahpenggantiController::class, 'edit']);
            Route::post('/update-pengganti', [KuliahpenggantiController::class, 'update']);
            //Administrasi Input Manual Mengajar
            Route::get('/input-manual', [InputmanualController::class, 'index']);
            Route::post('/input-manual', [InputmanualController::class, 'index']);
            Route::get('/manual-side/{id}', [InputmanualController::class, 'manual_side']);
            Route::get('/kelas-input-manual/{id}', [InputmanualController::class, 'kelas_input_manual']);
            Route::post('/simpan-manual', [InputmanualController::class, 'simpan_manual']);
            Route::get('/rekap-manual/{id}', [InputmanualController::class, 'rekap_manual']);
            Route::post('/rekap-manual-teori', [InputmanualController::class, 'rekap_manual_teori']);
            Route::post('/rekap-manual-praktek', [InputmanualController::class, 'rekap_manual_praktek']);
            Route::post('/rekap-manual-gabung', [InputmanualController::class, 'rekap_manual_gabung']);
            // Route::get('/cari-dosen', [InputmanualController::class,'cari_dosen'])->name('cari_dosen');
            //BAAK Upload Jadwal
            Route::get('/upload-jadwal', [UploadjadwalController::class, 'index']);
            Route::post('/upload-penilai', [UploadjadwalController::class, 'storeData']);

            //mtk baak
            Route::get('/mtk', [MtkController::class, 'index']);


            //administrasi usermhs dan dosen
            Route::get('/search', [Select2SearchController::class, 'index']);
            Route::get('/ajax-autocomplete-search', [Select2SearchController::class, 'selectSearch']);
            Route::get('/lecturer/users', [UserdosenController::class, 'index']);
            Route::post('/status/update/', [UserdosenController::class, 'updateStatus']);
            Route::get('/lecturer/edit/{user}', [UserdosenController::class, 'edit'])->name('user.edit');
            Route::patch('/lecturer/update/{user}', [UserdosenController::class, 'update']);

            Route::get('/std/users', [UsermhsController::class, 'index']);
            Route::get('/std/edit/{user}', [UsermhsController::class, 'edit']);
            Route::patch('/std/update/{user}', [UsermhsController::class, 'update']);

            //administrasi jadwal dosen
            Route::get('/lecturer/schedule', [JadwaldosenController::class, 'index']);
            Route::get('/cari-lecturer/schedule', [JadwaldosenController::class, 'search']);
            Route::get('/lecturer/schedule/edit/{id}', [JadwaldosenController::class, 'edit']);
            Route::put('/lecturer/schedule/update/{id}', [JadwaldosenController::class, 'update'])->name('jadwal.update');
            Route::get('/rekap/day', [RekapdosenController::class, 'index']);
            Route::get('/rekap/praktek-day', [RekapdosenController::class, 'praktek']);
            Route::get('/rekap/teori-day', [RekapdosenController::class, 'teori']);
            Route::get('/rekap/praktek-all', [RekapdosenController::class, 'praktek_all']);
            Route::get('/rekap/teori-all', [RekapdosenController::class, 'teori_all']);
            Route::get('/cari-rekap-teori', [RekapdosenController::class, 'cariDataRekapt']);
            Route::get('/cari-rekap-praktek', [RekapdosenController::class, 'cariDataRekapp']);

            Route::controller(LogController::class)->group(function () {
                Route::get('/log', 'index');
            });

            // administrasi dosen praktisi

            Route::get('/mengajar-praktisi', [DosenPraktisiController::class, 'index']);
            Route::get('/rekap-ajar-praktisi', [DosenPraktisiController::class, 'rekap_ajar']);
            Route::get('/show/jadwal/praktisi/{id}', [DosenPraktisiController::class, 'showJadwal']);
            Route::get('/cari-data-rekap', [DosenPraktisiController::class, 'cariDataRekap']);

            //rekap ajar dosen
            Route::get('/lecturer/rekap', [RekapajardosenController::class, 'index']);
            Route::get('/lecturer/t/rekap', [RekapajardosenController::class, 'index_t']);
            Route::get('/lecturer/p/rekap', [RekapajardosenController::class, 'index_p']);
            Route::get('/lecturer/praktisi/rekap', [RekapajardosenController::class, 'index_praktisi']);
            Route::get('/show/rekap-praktisi/{id}', [RekapajardosenController::class, 'show_praktisi']);

            Route::get('/lecturer/p/{id}', [RekapajardosenController::class, 'alasan_p']);
            Route::get('/lecturer/t/{id}', [RekapajardosenController::class, 'alasan_t']);
            Route::post('/alasan-prodi', [RekapajardosenController::class, 'alasan_prodi_praktek']);
            Route::post('/alasan-prodi-teori', [RekapajardosenController::class, 'alasan_prodi_teori']);
        });
    });
});

Route::middleware('auth')->group(function () {
    Route::group(['middleware' => 'cekopd'], function () {
        Route::group(['middleware' => 'checksinglesession'], function () {

            Route::get('/user/dashboard', function () {
                return view('mhs.dashboard');
            })->name('dashboard');
            Route::controller(KuisonerpmdController::class)->group(function () {
                Route::get('/kuisoner-mpd', 'index');
                Route::post('/store/kuisoner-mpd', 'store');
            });
            Route::get('/halaman-ujian', [LoginmhsController::class, 'redirectToUjian'])->name('Ujian.redirect');

            //materi dan tugas
            Route::get('/sch', [JadwalmhsController::class, 'index']);
            Route::get('/learning/{id}', [MaterimhsController::class, 'index'])->name('mhs.materi.index');
            Route::post('/download-file-materi', [MaterimhsController::class, 'download_file_materi']);
            Route::get('/assignment/{id}', [TugasmhsController::class, 'index'])->name('mhs.tugas.index');
            Route::get('/assignment/send/{id}', [TugasmhsController::class, 'send'])->name('mhs.tugas.send');
            Route::post('/assignment', [TugasmhsController::class, 'store']);
            Route::post('/download-file-tugas', [TugasmhsController::class, 'download_file_tugas']);

            //Forum Diskusi
            Route::get('/form-diskusimhs/{id}', [DiskusimhsController::class, 'index']);
            Route::post('/tambah-diskusimhs', [DiskusimhsController::class, 'store_diskusi']);
            Route::get('/form-komentarmhs/{id}', [DiskusimhsController::class, 'komentar']);
            Route::post('/send-komentarmhs', [DiskusimhsController::class, 'store_komen']);
            Route::delete('/hapus-diskusimhs/{id}', [DiskusimhsController::class, 'destroy_diskusi']);
            Route::post('/download-file-diskusimhs', [DiskusimhsController::class, 'download_file_diskusi']);

            //Absen Mahasiswa
            Route::get('/absen-mhs/{id}', [JadwalmhsController::class, 'show_absen']);
            Route::get('/rekap-side/{id}', [JadwalmhsController::class, 'rekap_side']);
            Route::post('/mhs-absen', [JadwalmhsController::class, 'mhs_absen']);
            Route::post('/komentar-mhs', [JadwalmhsController::class, 'komentar_mhs']);
            Route::get('/modul-mbkm', [JadwalmhsController::class, 'modul']);
            //Kuliah Pengganti
            Route::get('/kuliah-pengganti', [JadwalpenggantiController::class, 'index']);
            Route::get('/absen-mhs-pengganti/{id}', [JadwalpenggantiController::class, 'show_absen']);

            // latihan ujian mhs
            Route::get('/exercise', [LatihanUjianmhsController::class, 'index']);
            Route::get('/exercise-show/{id}', [LatihanUjianmhsController::class, 'show']);
            Route::post('/jawaban', [LatihanUjianmhsController::class, 'jawab']);
            Route::get('/penomoran', [LatihanUjianmhsController::class, 'getNomor']);
            Route::get('/get-soal', [LatihanUjianmhsController::class, 'getSoal']);
            Route::get('/get-soal_essay', [LatihanUjianmhsController::class, 'getDetailEssay']);
            Route::get('/simpan-jawaban-essay', [LatihanUjianmhsController::class, 'simpanJawabanEssay']);
            Route::get('/selesai-ujian/{id}', [LatihanUjianmhsController::class, 'selesai_ujian']);
            Route::get('/cetak-ujian-pdf/{id}', [LatihanUjianmhsController::class, 'cetak_pdf']);

            // Toefl
            Route::get('/toefl', [ToeflUjianmhsController::class, 'index']);
            Route::get('/toefl-show/{id}', [ToeflUjianmhsController::class, 'show']);
            Route::post('/toefl-jawaban', [ToeflUjianmhsController::class, 'jawab']);
            Route::get('/toefl-penomoran', [ToeflUjianmhsController::class, 'getNomor']);
            Route::get('/toefl-get-soal', [ToeflUjianmhsController::class, 'getSoal']);
            Route::get('/toefl-get-soal_essay', [ToeflUjianmhsController::class, 'getDetailEssay']);
            Route::get('/toefl-simpan-jawaban-essay', [ToeflUjianmhsController::class, 'simpanJawabanEssay']);
            Route::get('/toefl-selesai-ujian/{id}', [ToeflUjianmhsController::class, 'selesai_ujian']);
            Route::get('/toefl-cetak-ujian-pdf/{id}', [ToeflUjianmhsController::class, 'cetak_pdf']);
            Route::post('/download-file-toef', [ToeflUjianmhsController::class, 'download_file_toef']);
        });
    });
});



require __DIR__ . '/auth.php';
