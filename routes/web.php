<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Modules\Pengaturan\GoogleDriveController;
use App\Http\Controllers\Modules\Admin\DashboardController;
use App\Http\Controllers\Modules\BukuInduk\SiswaController;
use App\Http\Controllers\Modules\BukuInduk\BindukController;
use App\Http\Controllers\Modules\BukuInduk\RombelController;
use App\Http\Controllers\Modules\Pengaturan\AksesController;
use App\Http\Controllers\Modules\Pengaturan\SistemController;
use App\Http\Controllers\Modules\BukuInduk\KenaikanController;
use App\Http\Controllers\Modules\BukuInduk\SemesterController;
use App\Http\Controllers\Modules\BukuInduk\FotoSiswaController;
use App\Http\Controllers\Modules\Pengaturan\PembaruanController;
use App\Http\Controllers\Modules\Pengaturan\PengaturanController;
use App\Http\Controllers\Modules\BukuInduk\DokumenSiswaController;
use App\Http\Controllers\Modules\Pengaturan\PemeliharaanController;
use App\Http\Controllers\Modules\BukuInduk\TahunPelajaranController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Pengaturan
Route::prefix('pengaturan')->middleware(['auth', 'verified'])->name('pengaturan.')->group(function () {
    Route::get('/lisensi', [PengaturanController::class, 'lisensi'])->name('lisensi');

    Route::get('/sistem', [SistemController::class, 'sistem'])
        ->can('lihat sistem')->name('sistem');
    Route::put('/sistem', [SistemController::class, 'update'])
        ->can('atur sistem')->name('sistem.update');

    Route::get('/akses', [AksesController::class, 'akses'])
        ->can('lihat hak akses')->name('akses');

    Route::get('/pembaruan', [PembaruanController::class, 'pembaruan'])
        ->can('lihat pembaruan')->name('pembaruan');

    Route::get('/pemeliharaan', [PemeliharaanController::class, 'pemeliharaan'])
        ->can('lihat pemeliharaan')->name('pemeliharaan');
});

Route::prefix('pengaturan/akses')->name('pengaturan.akses.')->group(function () {
    Route::get('edit-role/{id}', [AksesController::class, 'editRole'])
        ->can('edit peran')->name('edit-role');
    Route::get('edit-akses', [AksesController::class, 'editPermission'])
        ->can('edit hak akses')->name('edit-permission');
    Route::post('/update-permissions', [AksesController::class, 'updatePermission'])
        ->can('update hak akses')
        ->name('update-permissions');
    Route::post('update-role', [AksesController::class, 'updateRole'])
        ->can('update peran')->name('update-role');
    Route::post('reset-password/{id}', [AksesController::class, 'resetPassword'])
        ->can('reset password')->name('reset-password');
    Route::delete('hapus-akun', [AksesController::class, 'hapusAkun'])
        ->can('hapus akun')->name('hapus-akun');
});



// Buku Induk
Route::prefix('induk')->middleware(['auth', 'verified'])->name('induk.')->group(function () {
    Route::get('/siswa', [SiswaController::class, 'index'])
        ->can('lihat siswa')->name('siswa');
    Route::delete('/siswa/mass-delete', [SiswaController::class, 'massDelete'])->name('siswa.massDelete');
    Route::post('/import-siswa', [SiswaController::class, 'import'])->name('import-siswa');
    Route::get('/siswa/tambah-baru', [SiswaController::class, 'addSiswa'])->name('siswa.tambah-baru');
    Route::get('/siswa/{uuid}', [SiswaController::class, 'show'])->name('siswa.show');
    Route::delete('/siswa/{uuid}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
    Route::post('/siswa', [SiswaController::class, 'store'])->name('siswa.store');

    Route::put('/siswa/{student}/biodata', [SiswaController::class, 'updateBiodata'])
        ->name('siswa.update.biodata');
    Route::put('/siswa/{student}/ortu', [SiswaController::class, 'updateOrtu'])->name('siswa.update.ortu');
    Route::put('/siswa/{student}/update-lokasi', [SiswaController::class, 'updateLokasi'])->name('siswa.update-lokasi');
    Route::put('/siswa/{student}/sosial', [SiswaController::class, 'updateSosial'])
        ->name('siswa.update-sosial');
});


Route::prefix('induk')->middleware(['auth', 'verified'])->name('induk.')->group(function () {

    Route::prefix('akademik')->name('akademik.')->group(function () {
        Route::resource('kelas', RombelController::class)
            ->middleware('can:atur kelas');

        Route::delete('tahun-pelajaran', [TahunPelajaranController::class, 'bulkDestroy'])
            ->name('tahun-pelajaran.bulk-destroy')
            ->middleware('can:atur tahun pelajaran');

        Route::resource('tahun-pelajaran', TahunPelajaranController::class)
            ->middleware('can:atur tahun pelajaran');

        Route::resource('semester', SemesterController::class)
            ->middleware('can:atur semester');

        Route::resource('rombel', KenaikanController::class)
            ->middleware('can:atur rombel');
    });
});

Route::prefix('induk/akademik')->middleware('auth')->group(function () {
    Route::patch('/tp/{tahunPelajaran}/sem/{semester}/aktifkan', [SemesterController::class, 'aktifkan'])
        ->name('semesters.aktifkan');

    Route::patch('semester/{tahunPelajaranId}/{semesterId}/nonaktifkan', [SemesterController::class, 'nonaktifkan'])
        ->name('semester.nonaktifkan')
        ->middleware('can:atur semester');

    Route::delete('semester/{tahunPelajaran}/hapus', [SemesterController::class, 'hapus'])
        ->name('semester.hapus');
});


// Buku Induk - Kelas
Route::prefix('induk')->name('induk.')->group(function () {
    Route::delete('/kelas/mass-delete', [RombelController::class, 'massDelete'])
        ->middleware('can:atur rombel')->name('kelas.massDelete');
});

// Buku Induk -  Foto Siswa
Route::prefix('induk/akademik')
    ->name('induk.akademik.')
    ->middleware(['auth', 'can:atur foto'])
    ->group(function () {

        Route::get('foto-siswa/by/{siswa_uuid}', [FotoSiswaController::class, 'index'])
            ->name('foto-siswa.by-siswa');

        Route::resource('foto-siswa', FotoSiswaController::class)
            ->parameters(['foto-siswa' => 'foto_siswa']); // Hindari bentrok dengan siswa_uuid
    });

Route::middleware(['auth', 'can:atur foto'])->group(function () {
    Route::get('/get-semesters/{tahunPelajaranId}', function ($id) {
        return \App\Models\Semester::where('tahun_pelajaran_id', $id)->get();
    })->name('get-semesters');
});

// Route khusus verifikasi dokumen (dapat diakses publik)
Route::get('induk/verifikasi-dokumen/{uuid}', [BindukController::class, 'verifikasiDokumen'])
    ->name('induk.dokumen.verifikasi');
Route::get('/v/{shortCode}', [BindukController::class, 'verifikasiDokumenShort'])->name('short.dokumen.verifikasi');

// Buku Induk - Cetak Dokumen (akses terbatas)
Route::prefix('induk')->name('induk.')->middleware(['auth', 'can:cetak buku induk'])->group(function () {
    Route::get('/', [BindukController::class, 'index'])->name('index');
    Route::post('/generate-nomor-dokumen', [BindukController::class, 'generateNomorDokumen'])->name('generateNomorDokumen');
    Route::get('/generate-pdf/{uuid}', [BindukController::class, 'generatePDF'])->name('generatePDF');
    Route::post('/buku-induk/cetak', [BindukController::class, 'cetak'])->name('buku-induk.cetak');
    Route::get('/buku-induk/print/{uuid}', [BindukController::class, 'print'])->name('buku-induk.print');
    Route::get('/siswa/{uuid}/detail', [BindukController::class, 'showStudentDetail'])->name('siswa.detail');
});



// Rombel Siswa (Kenaikan Kelas)
Route::prefix('rombel/siswa')
    ->name('rombel.siswa.')
    ->middleware('can:atur rombel')
    ->controller(KenaikanController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/by-tingkat', 'filterByTingkat')->name('by-tingkat');
        Route::get('/json', 'getFilteredStudents')->name('json');

        Route::post('/naikkan', 'naikkan')->name('naikkan');
        Route::post('/naikkelas', 'naikKelas')->name('naikkelas');
        Route::post('/move', 'moveToNextClass')->name('moveToNextClass');

        Route::delete('/{uuid}/hapusrombel', 'hapusRombel')->name('hapusrombel');
        Route::delete('/hapus-rombel', 'hapusDariRombel')->name('hapus-rombel');
    });

Route::prefix('student-documents')->middleware(['auth', 'can:atur dokumen'])->group(function () {
    Route::post('/{student}', [DokumenSiswaController::class, 'store'])
        ->name('student.documents.store');

    Route::get('/{student}/list', [DokumenSiswaController::class, 'index'])
        ->name('student.documents.list');

    Route::delete('/{document}', [DokumenSiswaController::class, 'destroy'])
        ->name('student.documents.destroy');

    Route::get('/{student}/documents/partial', [DokumenSiswaController::class, 'partial'])
        ->name('student.documents.partial');
});


// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [PengaturanController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [PengaturanController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [PengaturanController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/update-avatar', [PengaturanController::class, 'updateAvatar'])->name('profile.update-avatar');
    Route::get('/profile/delete-avatar', [PengaturanController::class, 'deleteAvatar'])->name('profile.delete-avatar');
});


// Route grup untuk pengaturan Google Drive (butuh login & izin)
Route::prefix('pengaturan/gdrive')
    ->middleware(['auth', 'can:atur gdrive'])
    ->name('google.drive.')
    ->group(function () {
        Route::get('/', [GoogleDriveController::class, 'index'])->name('index');

        Route::post('/revoke', [GoogleDriveController::class, 'revokeAccess'])->name('revoke');

        Route::get('/upload', function () {
            return view('google_drive_upload');
        })->name('upload.view');
    });

// 👇 Callback harus di luar middleware `auth`
Route::get('/pengaturan/gdrive/callback', [GoogleDriveController::class, 'handleCallback'])
    ->name('google.drive.callback');

// Upload raport siswa (login saja)
Route::post('/induk/siswa/{uuid}/upload-rapor', [GoogleDriveController::class, 'uploadRapor'])
    ->middleware(['auth'])
    ->name('students.rapor.upload');

// Hapus file raport (login saja)
Route::delete('/students/rapor/{id}', [GoogleDriveController::class, 'destroy'])
    ->middleware(['auth'])
    ->name('students.rapor.delete');


Route::post('/clear-session-flash', function (Illuminate\Http\Request $request) {
    foreach ($request->keys as $key) {
        session()->forget($key);
    }
    return response()->json(['status' => 'success']);
})->name('clear.session.flash');


require __DIR__ . '/auth.php';
