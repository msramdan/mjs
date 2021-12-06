<?php

use App\Http\Controllers\Contact\{CustomerController, SupplierController};
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Legal\KaryawanController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\Master\{UnitController, CategoryController, CategoryRequestController, DivisiController, JabatanController, LokasiController, StatusKaryawanController};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


// untuk nonaktifkan route register
Auth::routes(['register' => false]);

//route switch bahasa
Route::get('/localization/{language}', [LocalizationController::class, 'switch'])->name('localization.switch');

// Homepage
Route::get('/home', function () {
    return redirect()->route('home');
});

Route::get('/', [HomeController::class, 'index'])->name('home');

// Contact
Route::prefix('contact')->middleware('auth')->group(function () {
    Route::resource('supplier', SupplierController::class);

    Route::resource('customer', CustomerController::class);
});

// Master Data
Route::prefix('master')->middleware('auth')->group(function () {
    Route::resource('category', CategoryController::class);

    Route::resource('category-request', CategoryRequestController::class);

    Route::resource('unit', UnitController::class);

    Route::resource('lokasi', LokasiController::class);

    Route::resource('jabatan', JabatanController::class);

    Route::resource('status-karyawan', StatusKaryawanController::class);

    Route::resource('divisi', DivisiController::class);
});

// HR/Legal
Route::prefix('legal')->middleware('auth')->group(function () {
    Route::resource('karyawan', KaryawanController::class);
});
