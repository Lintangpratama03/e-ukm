<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KelolaAnggotaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\KelolaProfilController;
use App\Http\Controllers\Admin\TempatController;
use App\Http\Controllers\AuthController;


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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

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

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/tempat', [TempatController::class, 'index'])->name('tempat.index');
        Route::get('/tempat/data', [TempatController::class, 'getData'])->name('tempat.getData');
        Route::post('/tempat', [TempatController::class, 'store'])->name('tempat.store');
        Route::get('/tempat/edit/{id}', [TempatController::class, 'edit'])->name('tempat.edit');
        Route::post('/tempat/{id}', [TempatController::class, 'update'])->name('tempat.update');
        Route::delete('/tempat/{id}', [TempatController::class, 'destroy'])->name('tempat.destroy');
    });

    Route::middleware('role:user')->prefix('user')->name('user.')->group(function () {
        Route::get('dashboard', function () {
            return view('user.dashboard');
        })->name('dashboard');
    });
});
