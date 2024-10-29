<?php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

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

// Route untuk middleware isGuest
Route::middleware(['isGuest'])->group(function () {
    // Route untuk login
    Route::get('/', [UserController::class, 'showLogin'])->name('login.auth');
    Route::post('/login', [UserController::class, 'login'])->name('login.proses');
});

// Route untuk middleware isLogin
Route::middleware(['isLogin'])->group(function () {
    // Route untuk logout
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');

    // Route untuk landing page
    Route::get("/landing", [LandingPageController::class, 'index'])->name('home');

    // Route untuk middleware idAdmin
    Route::middleware(['isAdmin'])->group(function () {
        // Route untuk Medicine, sudah diprefix "/obat"
        Route::prefix('/obat')->name('obat.')->group(function () {
            Route::get('/tambah-obat', [MedicineController::class, 'create'])->name('tambah_obat'); // Form tambah obat
            Route::post('/tambah-obat', [MedicineController::class, 'store'])->name('simpan_obat'); // Simpan obat baru
            Route::get('/daftar-obat', [MedicineController::class, 'index'])->name('data_obat'); // Daftar semua obat
            Route::get('/edit/{id}', [MedicineController::class, 'edit'])->name('edit'); // Edit data Obat
            Route::patch('/edit/{id}', [MedicineController::class, 'update'])->name('edit.formulir'); // Mengupdate data Obat
            Route::delete('/hapus/{id}', [MedicineController::class, 'destroy'])->name('delete'); // Menghapus data obat
            Route::patch('/edit/stok/{id}', [MedicineController::class, 'updateStock'])->name('edit.stok'); // Mengupdate stok obat
        });

        // buat route untuk kelola pengguna
        Route::prefix('/akun')->name('akun.')->group(function () {
            Route::get('/daftar-akun', [UserController::class, 'index'])->name('daftar_akun'); // Daftar semua akun
            Route::get('/tambah-akun', [UserController::class, 'create'])->name('tambah_akun'); // Form tambah akun
            Route::post('/tambah-akun', [UserController::class, 'store'])->name('simpan_akun'); // Simpan akun baru
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit_akun'); // Edit data akun
            Route::patch('/edit/{id}', [UserController::class, 'update'])->name('edit.akun'); // Update data akun
            Route::delete('/hapus/{id}', [UserController::class, 'destroy'])->name('delete_akun'); // Menghapus data akun
        });
    });

    // Route untuk pembelian
    Route::prefix('/pembelian')->name('pembelian.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('data_pembelian'); // Daftar semua pembelian
        Route::get('/detail/{id}', [OrderController::class, 'detail'])->name('detail_pembelian'); // Detail pembelian
        Route::post('/simpan', [OrderController::class,'store'])->name('simpan_pembelian'); // Simpan pembelian baru
        Route::patch('/edit/{id}', [OrderController::class, 'update'])->name('edit_pembelian'); // Update data pembelian
        Route::delete('/hapus/{id}', [OrderController::class, 'destroy'])->name('delete_pembelian'); // Menghapus data pembelian
    });
});
