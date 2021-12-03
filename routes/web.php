<?php

use App\Http\Controllers\BarangJasa\SupplierController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocalizationController;
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

Route::prefix('barang-jasa')->middleware('auth')->group(function () {
    Route::resource('supplier', SupplierController::class);
});
