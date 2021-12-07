<?php

use App\Http\Controllers\Contact\{CustomerController, SupplierController};
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Inventory\ItemController;
use App\Http\Controllers\Legal\KaryawanController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\Master\{CategoryBenefitController, UnitController, CategoryController, CategoryPotonganController, CategoryRequestController, DivisiController, JabatanController, LokasiController, StatusKaryawanController};
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Sale\SpalController;
use App\Http\Controllers\Setting\{UserController, PermissionController, RoleController};
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

    Route::resource('category-potongan', CategoryPotonganController::class);

    Route::resource('category-benefit', CategoryBenefitController::class);

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

// Sale
Route::middleware('auth')->prefix('sale')->group(function () {
    Route::resource('spal', SpalController::class);

    Route::get('/spal/download/{file}', [SpalController::class, 'downloadFileSpal']);
});

// Iinventory
Route::middleware('auth')->prefix('inventory')->group(function () {
    Route::resource('item', ItemController::class);
});


// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');

    Route::put('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
});

// Setting
Route::middleware('auth')->prefix('setting')->group(function () {
    Route::resource('role', RoleController::class);

    Route::resource('permission', PermissionController::class);

    Route::resource('user', UserController::class);
});
