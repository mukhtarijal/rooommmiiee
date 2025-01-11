<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HelpCenterController;
use App\Http\Controllers\KostController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SewaController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PusatBantuanController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ChatController;

// Route untuk halaman utama (welcome)
Route::get('/', [WelcomeController::class, 'index'])->name('welcome')
    ->middleware('guest');

// Route untuk dashboard (hanya bisa diakses setelah login)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Route untuk menampilkan semua daftar kost
Route::get('/cari-kost', [KostController::class, 'index'])->name('kost.index');

// Route untuk menampilkan detail kost
Route::get('/kost/{slug}', [KostController::class, 'show'])->name('kost.detail');

// Route untuk menampilkan daftar kost premium
Route::get('/kost-premium', [KostController::class, 'premium'])->name('kost.premium');

// Route untuk kost di kota yang sama
Route::get('/kost-same-city', [KostController::class, 'sameCity'])->name('kost.same-city');

Route::get('/search', [DashboardController::class, 'search'])->name('kost.search');

// Route untuk halaman Pusat Bantuan (bisa diakses oleh semua user)
Route::get('/pusat-bantuan', [PusatBantuanController::class, 'index'])->name('pusat-bantuan');

// Route untuk halaman Artikel (bisa diakses oleh semua user)
Route::get('/artikel', [ArtikelController::class, 'index'])->name('artikel');

// Route untuk halaman Favorit (hanya bisa diakses setelah login)
Route::middleware('auth')->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat');
});

//Route::post('/favorite/{kost}', [FavoriteController::class, 'toggle'])
//    ->name('favorite.toggle')
//    ->middleware('auth');

Route::get('/sewa', [SewaController::class, 'index'])->name('sewa.index');

// Route untuk menampilkan form upload bukti pembayaran
Route::get('/sewa/{sewa}/upload', [SewaController::class, 'showUploadForm'])->name('sewa.upload');

// Route untuk menyimpan bukti pembayaran
Route::post('/sewa/{sewa}/upload', [SewaController::class, 'uploadPaymentProof'])->name('sewa.upload.submit');

Route::post('/review/store', [ReviewController::class, 'store'])->name('review.store');

Route::get('/help-center', [HelpCenterController::class, 'index'])->name('help-center.index');

Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');

Route::middleware('auth')->group(function () {
    Route::get('/sewa/{kost}', [SewaController::class, 'create'])->name('sewa.create');
    Route::post('/sewa/{kost}', [SewaController::class, 'store'])->name('sewa.store');
});

// Route untuk profil user (hanya bisa diakses setelah login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route untuk autentikasi (login, register, dll.)
require __DIR__.'/auth.php';
