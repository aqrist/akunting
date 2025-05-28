<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BiayaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\TransaksiController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Project
    Route::get('/projects/{project}/invoice', [ProjectController::class, 'generateInvoice'])->name('projects.invoice');
    Route::get('/projects/{project}/tagihan', [ProjectController::class, 'generateTagihan'])->name('projects.tagihan');
    Route::get('/projects/{project}/nota-lunas', [ProjectController::class, 'generateNotaLunas'])->name('projects.nota-lunas');
    Route::get('/projects/{project}/penawaran', [ProjectController::class, 'generatePenawaran'])->name('projects.penawaran');
    Route::resource('projects', ProjectController::class);

    // Transaksi
    Route::resource('transaksi', TransaksiController::class);
    Route::get('transaksi/project/{project_id}', [TransaksiController::class, 'byProject'])->name('transaksi.by-project');
    Route::get('transaksi/jenis/{jenis}', [TransaksiController::class, 'byJenis'])->name('transaksi.by-jenis');

    // Karyawan dan Gaji
    Route::resource('karyawan', KaryawanController::class);
    Route::get('karyawan/{id}/gaji', [KaryawanController::class, 'gajiHistory'])->name('karyawan.gaji');
    Route::post('karyawan/gaji/bayar', [KaryawanController::class, 'bayarGaji'])->name('karyawan.bayar-gaji');

    // Biaya Operasional
    Route::resource('biaya', BiayaController::class);

    // Laporan
    Route::get('laporan/arus-kas', [LaporanController::class, 'arusKas'])->name('laporan.arus-kas');
    Route::get('laporan/pendapatan', [LaporanController::class, 'pendapatan'])->name('laporan.pendapatan');
    Route::get('laporan/biaya', [LaporanController::class, 'biaya'])->name('laporan.biaya');
    Route::get('laporan/laba-rugi', [LaporanController::class, 'labaRugi'])->name('laporan.laba-rugi');
    Route::get('laporan/export/{jenis}', [LaporanController::class, 'export'])->name('laporan.export');
});

require __DIR__ . '/auth.php';
