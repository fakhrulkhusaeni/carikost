<?php

use App\Http\Controllers\BuktiKepemilikanKostController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KostController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\HunianLainController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PromosiController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerifikasiController;
use App\Http\Controllers\RatingController;


Route::get('/', [FrontController::class, 'index'])->name('frontend.index');
Route::get('/rekomendasi', [FrontController::class, 'rekomendasi'])->name('frontend.rekomendasi');
Route::get('/hunian_lain', [FrontController::class, 'hunian_lain'])->name('frontend.hunian_lain');
Route::get('/detail_hunianlain/{id}', [FrontController::class, 'detail_hunianlain'])->name('frontend.detail_hunianlain');
Route::get('/formulir', [FrontController::class, 'formulir'])->name('frontend.formulir');
Route::get('/promosi', [FrontController::class, 'promosi'])->name('frontend.promosi');
Route::get('/request', [FrontController::class, 'request'])->name('frontend.request');
Route::get('/kebijakan_privasi', [FrontController::class, 'kebijakan_privasi'])->name('frontend.kebijakan_privasi');
Route::get('/syarat_ketentuan', [FrontController::class, 'syarat_ketentuan'])->name('frontend.syarat_ketentuan');
Route::get('/detail/{id}', [FrontController::class, 'detail'])->name('frontend.detail');
Route::post('/rating', [RatingController::class, 'store'])->name('rating.store');
Route::post('bukti-kepemilikan/store', [BuktiKepemilikanKostController::class, 'store'])->name('bukti-kepemilikan.store');

Route::post('/riwayat/bayar/{transaksi_id}', [RiwayatController::class, "bayar"]);


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix(prefix: 'admin')->name('admin.')->group(function () {

    Route::middleware(['auth', 'can:manage hunian'])->group(function () {
        Route::resource('kost', KostController::class);

        Route::post('kost/{id}/keluar', [KostController::class, 'keluar'])->name('kost.keluar');
    });

    Route::middleware(['auth', 'can:manage data booking'])->group(function () {
        Route::resource('pembayaran', PembayaranController::class);

        // Route untuk konfirmasi dan penolakan
        Route::post('pembayaran/{id}/approve', [PembayaranController::class, 'approve'])->name('pembayaran.approve');
        Route::post('pembayaran/{id}/reject', [PembayaranController::class, 'reject'])->name('pembayaran.reject');
    });

    Route::middleware(['auth', 'can:manage riwayat booking'])->group(function () {
        Route::resource('riwayat', RiwayatController::class);
    });

    Route::middleware(['auth', 'can:manage verifikasi data'])->group(function () {
        Route::resource('verifikasi', VerifikasiController::class)->except(['store']);
        Route::post('verifikasi/{id}/verifikasi', [VerifikasiController::class, 'verifikasi'])->name('verifikasi.verifikasi');
        Route::post('verifikasi/{id}/tolak', [VerifikasiController::class, 'tolak'])->name('verifikasi.tolak');
    });

    Route::middleware(['auth', 'can:manage user'])->group(function () {
        Route::resource('pengguna', UserController::class);
    });

    Route::middleware(['auth', 'can:manage hunian lain'])->group(function () {
        Route::resource('hunian_lain', HunianLainController::class);
    });

    Route::middleware(['auth', 'can:manage data promosi'])->group(function () {
        Route::resource('promosi', PromosiController::class);
    });
});


require __DIR__ . '/auth.php';
