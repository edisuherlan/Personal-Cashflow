<?php
// Aplikasi ini dikembangkan oleh Edi Suherlan
// mail: edisuherlan@gmail.com -->
// GitHub: https://github.com/edisuherlan


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\UangMasukController;
use App\Http\Controllers\UangKeluarController;
use App\Http\Controllers\TransaksiController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth') // Menambahkan middleware 'auth'
    ->name('dashboard');

// Route untuk halaman login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'showProfileForm'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'profile']);

    Route::get('/uang_masuk', [UangMasukController::class, 'index'])->name('uang_masuk.index');
    Route::get('/uang_masuk/create', [UangMasukController::class, 'create'])->name('uang_masuk.create');
    Route::post('/uang_masuk', [UangMasukController::class, 'store'])->name('uang_masuk.store');
    Route::get('/uang_keluar', [UangKeluarController::class, 'index'])->name('uang_keluar.index');
    Route::get('/uang_keluar/create', [UangKeluarController::class, 'create'])->name('uang_keluar.create');
    Route::post('/uang_keluar', [UangKeluarController::class, 'store'])->name('uang_keluar.store');
    Route::get('/laporan/transaksi', [TransaksiController::class, 'index'])->name('laporan.transaksi');
});

Route::resource('uang_masuk', UangMasukController::class)->except(['create', 'store']);
Route::resource('uang_keluar', UangKeluarController::class)->except(['create', 'store']);



