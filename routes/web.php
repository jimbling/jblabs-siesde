<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Modules\Admin\DashboardController;
use App\Http\Controllers\Modules\BukuInduk\SiswaController;
use App\Http\Controllers\Modules\BukuInduk\RombelController;
use App\Http\Controllers\Modules\Pengaturan\AksesController;
use App\Http\Controllers\Modules\Pengaturan\SistemController;
use App\Http\Controllers\Modules\BukuInduk\KenaikanController;
use App\Http\Controllers\Modules\BukuInduk\SemesterController;
use App\Http\Controllers\Modules\Pengaturan\PembaruanController;
use App\Http\Controllers\Modules\Pengaturan\PengaturanController;
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
    Route::get('/siswa/{uuid}', [SiswaController::class, 'show'])->name('siswa.show');
    Route::delete('/siswa/{uuid}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
});



Route::prefix('induk')->middleware(['auth', 'verified'])->name('induk.')->group(function () {

    Route::prefix('akademik')->name('akademik.')->group(function () {
        Route::resource('kelas', RombelController::class)
            ->middleware('can:atur kelas');

        Route::resource('tahun-pelajaran', TahunPelajaranController::class)
            ->middleware('can:atur tahun pelajaran');

        Route::resource('semester', SemesterController::class)
            ->middleware('can:atur semester');

        Route::resource('rombel', KenaikanController::class)
            ->middleware('can:atur rombel');
    });
});

Route::prefix('induk')->name('induk.')->group(function () {
    Route::delete('/kelas/mass-delete', [RombelController::class, 'massDelete'])->name('kelas.massDelete');
});

Route::get('/rombel/siswa/by-tingkat', [KenaikanController::class, 'filterByTingkat'])->name('rombel.siswa.by-tingkat');
Route::post('/rombel/naikkan', [KenaikanController::class, 'naikkan'])->name('rombel.naikkan');

// Route untuk menampilkan halaman dengan filter tingkat dan tahun pelajaran
Route::get('rombel/siswa', [KenaikanController::class, 'index'])->name('rombel.siswa.index');

// Route untuk proses naik kelas (naikkan siswa ke rombel baru)
Route::post('rombel/siswa/naikkelas', [KenaikanController::class, 'naikKelas'])->name('rombel.siswa.naikkelas');

// Route untuk hapus rombel siswa
Route::delete('rombel/siswa/{uuid}/hapusrombel', [KenaikanController::class, 'hapusRombel'])->name('rombel.siswa.hapusrombel');
Route::post('rombel/siswa/move', [KenaikanController::class, 'moveToNextClass'])->name('rombel.siswa.moveToNextClass');
Route::get('/rombel/siswa/json', [KenaikanController::class, 'getFilteredStudents'])->name('rombel.siswa.json');
Route::delete('/rombel/siswa/hapus-rombel', [KenaikanController::class, 'hapusDariRombel'])->name('rombel.siswa.hapus-rombel');




// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [PengaturanController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [PengaturanController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [PengaturanController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/update-avatar', [PengaturanController::class, 'updateAvatar'])->name('profile.update-avatar');
    Route::get('/profile/delete-avatar', [PengaturanController::class, 'deleteAvatar'])->name('profile.delete-avatar');
});

Route::post('/clear-session-flash', function (Illuminate\Http\Request $request) {
    foreach ($request->keys as $key) {
        session()->forget($key);
    }
    return response()->json(['status' => 'success']);
})->name('clear.session.flash');

require __DIR__ . '/auth.php';
