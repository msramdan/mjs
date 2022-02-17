<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Accounting\{
    AkunCoaController,
    AkunGrupController,
    AkunHeaderController,
    BillingController,
    InvoiceController,
    JurnalUmumController
};
use App\Http\Controllers\Contact\{
    CustomerController,
    SupplierController
};
use App\Http\Controllers\ElectronicDocument\{
    DocumentController,
    CategoryDocumentController
};
use App\Http\Controllers\Inventory\{
    AsoController,
    BacPakaiController,
    ItemController,
    BacTerimaController,
    ReceivedController
};
use App\Http\Controllers\Legal\{
    KaryawanController,
    BerkasKaryawanController,
    DokumenHrgaController
};
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\Master\{
    CategoryBenefitController,
    UnitController,
    CategoryController,
    CategoryPotonganController,
    CategoryRequestController,
    DivisiController,
    JabatanController,
    LokasiController,
    StatusKaryawanController
};
use App\Http\Controllers\Payroll\{
    PotonganController,
    BenefitController
};
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Purchase\PurchaseController;
use App\Http\Controllers\RequestForm\RequestFormController;
use App\Http\Controllers\Sale\{
    SpalController,
    SaleController
};
use App\Http\Controllers\Setting\{
    UserController,
    PermissionController,
    RoleController,
    SettingAppController
};
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

Route::middleware('auth')->resource('/request-form', RequestFormController::class);

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
    Route::get('/berkas-karyawan/download/{file}', [BerkasKaryawanController::class, 'download'])->name('berkas-karyawan.download');
    Route::get('/dokumen-hrga/download/{file}', [DokumenHrgaController::class, 'download'])->name('dokumen-hrga.download');

    Route::resource('karyawan', KaryawanController::class);
    Route::resource('berkas-karyawan', BerkasKaryawanController::class);
    Route::resource('dokumen-hrga', DokumenHrgaController::class);
});

// Sale
Route::middleware('auth')->prefix('sale')->group(function () {
    Route::get('/spal/download/{file}', [SpalController::class, 'download'])->name('spal.download');
    Route::get('/spal/get-spal-by-id/{id}', [SpalController::class, 'getSpalById']);

    Route::get('/sale/get-sale-by-id/{id}', [SaleController::class, 'getSaleById']);
    Route::get('/sale/generate-kode/{tanggal}', [SaleController::class, 'generateKode']);

    Route::resource('sale', SaleController::class);
    Route::resource('spal', SpalController::class);
});

// Purchase
Route::middleware('auth')->group(function () {
    Route::get('/purchase/generate-kode/{tanggal}', [PurchaseController::class, 'generateKode']);
    Route::get('/purchase/get-request-form-by-id/{id}', [RequestFormController::class, 'getRequestFormById']);
    Route::get('/purchase/get-purchase-by-id/{id}', [PurchaseController::class, 'getPurchaseById']);
    Route::get('/purchase/{id}/approve', [PurchaseController::class, 'approve'])->name('purchase.approve');

    Route::resource('purchase', PurchaseController::class);
});

// Iinventory
Route::middleware('auth')->prefix('inventory')->group(function () {
    Route::get('/item/{id}/tracking', [ItemController::class, 'tracking'])->name('item.tracking');
    Route::get('/item/get-item-by-id/{itemId}', [ItemController::class, 'getItemById']);
    Route::get('/item/get-item-and-supplier/{itemId}/{supplierId}', [ItemController::class, 'getItemAndSupplier']);

    Route::get('/item/get-item-by-supplier/{id}', [ItemController::class, 'getItemBySupplier']);
    Route::get('/item/generate-kode', [ItemController::class, 'generateKode']);
    // Route::get('/item/find-by-id/{id}', [ItemController::class, 'findById']);
    Route::get('/item/get-all', [ItemController::class, 'getAll']);

    Route::get('/bac-pakai/get-bac-pakai-by-id/{id}', [BacPakaiController::class, 'getBacById']);
    Route::get('/bac-terima/get-bac-terima-by-id/{id}', [BacTerimaController::class, 'getBacById']);

    Route::get('/bac-terima/download/{file}', [BacTerimaController::class, 'download'])
        ->name('bac-terima.download');

    Route::get('/bac-pakai/download/{file}', [BacPakaiController::class, 'download'])
        ->name('bac-pakai.download');

    Route::get('/bac-pakai/generate-kode/{tanggal}', [BacPakaiController::class, 'generateKode']);
    Route::get('/bac-terima/generate-kode/{tanggal}', [BacTerimaController::class, 'generateKode']);

    Route::resource('item', ItemController::class);
    Route::resource('bac-terima', BacTerimaController::class);
    Route::resource('bac-pakai', BacPakaiController::class);
    Route::resource('aso', AsoController::class);
    Route::resource('received', ReceivedController::class);
});

// Elecronic Document
Route::middleware('auth')->prefix('electronic-document')->group(function () {
    Route::get('/document/download/{file}', [DocumentController::class, 'download']);

    Route::resource('document', DocumentController::class);
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
    // Route::resource('permission', PermissionController::class);
    Route::resource('user', UserController::class);

    Route::get('/setting_app', [SettingAppController::class, 'index'])->name('setting_app.index');

    Route::put('/setting_app/{id}', [SettingAppController::class, 'update'])->name('setting_app.update');
});

// Request Form
Route::middleware('auth')->group(function () {
    Route::get('/request-form/generate-kode/{tanggal}', [RequestFormController::class, 'generateKode']);

    Route::get('/request-form/download/{file}', [RequestFormController::class, 'download'])
        ->name('request-form.download');

    Route::post('/request-form/set-status', [RequestFormController::class, 'setStatus'])
        ->name('request-form.set-status');
});

// accounting
Route::middleware('auth')->prefix('accounting')->group(function () {
    Route::get('/invoice/generate-kode/{tanggal}', [InvoiceController::class, 'generateKode']);
    Route::get('/billing/generate-kode/{tanggal}', [BillingController::class, 'generateKode']);

    Route::get('/invoice/{id}/print', [InvoiceController::class, 'print'])->name('invoice.print');
    Route::get('/billing/{id}/print', [BillingController::class, 'print'])->name('billing.print');

    Route::resource('invoice', InvoiceController::class);
    Route::resource('billing', BillingController::class);
    Route::resource('akun-grup', AkunGrupController::class);
    Route::resource('akun-header', AkunHeaderController::class);
    Route::resource('akun-coa', AkunCoaController::class);
    Route::resource('akun-coa', AkunCoaController::class);

    Route::resource('jurnal-umum', JurnalUmumController::class)->except('show', 'delete');
});

// Payroll
Route::prefix('payroll')->middleware('auth')->group(function () {
    Route::resource('potongan', PotonganController::class)->except(['update', 'create']);
    Route::resource('benefit', BenefitController::class)->except(['update', 'create']);
});
