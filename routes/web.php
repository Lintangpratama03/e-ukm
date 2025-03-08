<?php

use App\Http\Controllers\Admin\DashboardController;
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

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
    });

    Route::middleware('role:user')->prefix('user')->name('user.')->group(function () {
        Route::get('dashboard', function () {
            return view('user.dashboard');
        })->name('dashboard');
    });
});
