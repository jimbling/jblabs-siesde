<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Modules\Admin\DashboardController;
use App\Http\Controllers\Modules\Pengaturan\PengaturanController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Pengaturan
Route::prefix('pengaturan')->middleware(['auth', 'verified'])->name('pengaturan.')->group(function () {
    Route::get('/', [PengaturanController::class, 'index'])->name('index');
    Route::get('/lisensi', [PengaturanController::class, 'lisensi'])->name('lisensi');
});


// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [PengaturanController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [PengaturanController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [PengaturanController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/update-avatar', [PengaturanController::class, 'updateAvatar'])->name('profile.update-avatar');
    Route::get('/profile/delete-avatar', [PengaturanController::class, 'deleteAvatar'])->name('profile.delete-avatar');
});

require __DIR__ . '/auth.php';
