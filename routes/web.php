<?php

use App\Http\Controllers\Accounting\CoaController;
use App\Http\Controllers\Contact\{CustomerController, SupplierController};
use App\Http\Controllers\ElectronicDocument\{DocumentController, CategoryDocumentController};
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Inventory\ItemController;
use App\Http\Controllers\Legal\{KaryawanController, BerkasKaryawanController};
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\Master\{CategoryBenefitController, UnitController, CategoryController, CategoryPotonganController, CategoryRequestController, DivisiController, JabatanController, LokasiController, StatusKaryawanController};
use App\Http\Controllers\Payroll\{PotonganController,BenefitController};
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestForm\RequestFormController;
use App\Http\Controllers\Sale\{SpalController, SaleController};
use App\Http\Controllers\Setting\{UserController, PermissionController, RoleController};
use Illuminate\Support\Facades\{Route, Auth};


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

    Route::get('/berkas-karyawan/download/{file}', [BerkasKaryawanController::class, 'download'])->name('berkas-karyawan.download');

    Route::resource('berkas-karyawan', BerkasKaryawanController::class);
});

// Sale
Route::middleware('auth')->prefix('sale')->group(function () {
    Route::resource('sale', SaleController::class);

    Route::resource('spal', SpalController::class);

    Route::get('/spal/download/{file}', [SpalController::class, 'downloadFileSpal']);

    Route::get('/spal/get-spal-by-id/{id}', [SpalController::class, 'getSpalById']);
});

// Iinventory
Route::middleware('auth')->prefix('inventory')->group(function () {
    Route::get('/item/get-item-by-id/{id}', [ItemController::class, 'getItemById']);

    Route::resource('item', ItemController::class);
});

// Elecronic Document
Route::middleware('auth')->prefix('electronic-document')->group(function () {
    Route::resource('document', DocumentController::class);

    Route::get('/document/download/{file}', [DocumentController::class, 'download']);

    Route::resource('category-document', CategoryDocumentController::class);
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

// Request Form
Route::middleware('auth')->resource('/request-form', RequestFormController::class);

Route::middleware('auth')->get('/request-form/download/{file}', [RequestFormController::class, 'download'])->name('request-form.download');

// COA
Route::middleware('auth')->prefix('accounting')->group(function () {
    Route::resource('coa', CoaController::class);
});

// Payroll
Route::prefix('payroll')->middleware('auth')->group(function () {
    Route::resource('potongan', PotonganController::class)->except(['update','create']);
    Route::resource('benefit', BenefitController::class)->except(['update','create']);
});

