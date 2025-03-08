<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\KelolaProfilController;
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
    return redirect()->route('login');
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
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('profil', [KelolaProfilController::class, 'index'])->name('profil.index');
        Route::get('profil/data', [KelolaProfilController::class, 'data'])->name('profil.data');
        Route::post('profil/store', [KelolaProfilController::class, 'store'])->name('profil.store');
        Route::get('profil/edit/{id}', [KelolaProfilController::class, 'edit'])->name('profil.edit');
        Route::post('profil/update/{id}', [KelolaProfilController::class, 'update'])->name('profil.update');
        Route::delete('profil/delete/{id}', [KelolaProfilController::class, 'destroy'])->name('profil.destroy');
    });

    Route::middleware('role:user')->prefix('user')->name('user.')->group(function () {
        
    });
});
