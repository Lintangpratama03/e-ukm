<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Ukm\JadwalController;
use App\Http\Controllers\Admin\KelolaAnggotaController;
use App\Http\Controllers\Admin\KelolaJadwalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\KelolaProfilController;
use App\Http\Controllers\Admin\ParafController;
use App\Http\Controllers\Admin\TempatController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Ukm\DashboardUkmController;
use App\Http\Controllers\Ukm\DokumentasiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('home');
});

// Authentication Routes (Public)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginRegister'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/reload-captcha', [AuthController::class, 'reloadCaptcha'])->name('reload.captcha');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/profile/edit', [KelolaProfilController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [KelolaProfilController::class, 'update'])->name('profile.update');
    Route::post('/profile/update-password', [KelolaProfilController::class, 'updatePassword'])->name('profile.updatePassword');


    Route::get('anggota', [KelolaAnggotaController::class, 'index'])->name('anggota.index');
    Route::get('anggota/get', [KelolaAnggotaController::class, 'getAnggota'])->name('anggota.get');
    Route::post('anggota/store', [KelolaAnggotaController::class, 'store'])->name('anggota.store');
    Route::get('anggota/edit/{id}', [KelolaAnggotaController::class, 'edit'])->name('anggota.edit');
    Route::post('anggota/update', [KelolaAnggotaController::class, 'update'])->name('anggota.update');
    Route::delete('anggota/delete/{id}', [KelolaAnggotaController::class, 'delete'])->name('anggota.delete');

    Route::prefix('dokumentasi')->name('dokumentasi.')->group(function () {
        Route::get('/', [DokumentasiController::class, 'index'])->name('index');
        Route::get('/data', [DokumentasiController::class, 'getData'])->name('getData');
        Route::get('/show/{id}', [DokumentasiController::class, 'show'])->name('show');
        Route::post('/upload/{id}', [DokumentasiController::class, 'uploadFoto'])->name('upload');
        Route::delete('/{id}', [DokumentasiController::class, 'destroy'])->name('destroy');
    });

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::prefix('tempat')->group(function () {
            Route::get('/', [TempatController::class, 'index'])->name('tempat.index');
            Route::get('/data', [TempatController::class, 'getData'])->name('tempat.getData');
            Route::post('/', [TempatController::class, 'store'])->name('tempat.store');
            Route::get('/edit/{id}', [TempatController::class, 'edit'])->name('tempat.edit');
            Route::post('/{id}', [TempatController::class, 'update'])->name('tempat.update');
            Route::delete('/{id}', [TempatController::class, 'destroy'])->name('tempat.destroy');
        });

        Route::prefix('user')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('user.index');
            Route::get('/getData', [UserController::class, 'getData'])->name('user.getData');
            Route::post('/activate/{id}', [UserController::class, 'activate'])->name('user.activate');
            Route::get('/detail/{id}', [UserController::class, 'detail'])->name('user.detail');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('user.destroy');
        });
        Route::prefix('jadwal')->name('jadwal.')->group(function () {
            Route::get('/', [KelolaJadwalController::class, 'index'])->name('index');
            Route::get('/data', [KelolaJadwalController::class, 'getData'])->name('getData');
            Route::post('/', [KelolaJadwalController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [KelolaJadwalController::class, 'edit'])->name('edit');
            Route::get('/show/{id}', [KelolaJadwalController::class, 'show'])->name('show');
            Route::put('/{id}', [KelolaJadwalController::class, 'update'])->name('update');
            Route::delete('/{id}', [KelolaJadwalController::class, 'destroy'])->name('destroy');
            Route::post('/upload/{id}', [KelolaJadwalController::class, 'uploadProposal'])->name('upload');
            Route::post('/validasi/{id}', [KelolaJadwalController::class, 'validasi'])->name('validasi');
            Route::get('/jadwal/{id}/generate-pdf', [KelolaJadwalController::class, 'generatePdf'])->name('generate-pdf');
        });
        Route::prefix('bem')->name('bem.')->group(function () {
            Route::get('/paraf-ketua', [ParafController::class, 'index'])->name('paraf.index');
            Route::post('/paraf-ketua', [ParafController::class, 'store'])->name('paraf.store');
        });
    });


    Route::middleware('role:user')->prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard-ukm', [DashboardUkmController::class, 'index'])->name('dashboard.index');

        Route::prefix('jadwal')->name('jadwal.')->group(function () {
            Route::get('/', [JadwalController::class, 'index'])->name('index');
            Route::get('/data', [JadwalController::class, 'getData'])->name('getData');
            Route::post('/', [JadwalController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [JadwalController::class, 'edit'])->name('edit');
            Route::get('/show/{id}', [JadwalController::class, 'show'])->name('show');
            Route::put('/{id}', [JadwalController::class, 'update'])->name('update');
            Route::delete('/{id}', [JadwalController::class, 'destroy'])->name('destroy');
            Route::post('/upload/{id}', [JadwalController::class, 'uploadProposal'])->name('upload');
            Route::get('/jadwal/{id}/generate-pdf', [JadwalController::class, 'generatePdf'])->name('generate-pdf');
        });
    });
});
