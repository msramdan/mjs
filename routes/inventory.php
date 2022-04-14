<?php

use App\Http\Controllers\Inventory\{
    AsoController,
    BacPakaiController,
    ItemController,
    BacTerimaController,
    NewBacTerimaController,
    ReceivedController
};
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('inventory')->group(function () {
    Route::prefix('item')->group(function () {
        Route::get('/{id}/tracking', [ItemController::class, 'tracking'])->name('item.tracking');
        Route::get('/get-item-by-id/{itemId}', [ItemController::class, 'getItemById']);
        Route::get('/get-item-and-supplier/{itemId}/{supplierId}', [ItemController::class, 'getItemAndSupplier']);
        Route::get('/get-item-by-supplier/{id}', [ItemController::class, 'getItemBySupplier']);
        Route::get('/generate-kode', [ItemController::class, 'generateKode']);
        // Route::get('/find-by-id/{id}', [ItemController::class, 'findById']);
        Route::get('/get-all', [ItemController::class, 'getAll']);
    });

    Route::prefix('bac-terima')->group(function () {
        Route::get('/get-bac-terima-by-id/{id}', [BacTerimaController::class, 'getBacById']);
        Route::get('/download/{file}', [BacTerimaController::class, 'download'])->name('bac-terima.download');
        Route::get('/generate-kode/{tanggal}', [BacTerimaController::class, 'generateKode']);
    });

    Route::prefix('new-bac-terima')->group(function () {
        Route::get('/get-bac-terima-by-id/{id}', [NewBacTerimaController::class, 'getBacById']);
        Route::get('/download/{file}', [NewBacTerimaController::class, 'download'])->name('new-bac-terima.download');
        Route::get('/generate-kode/{tanggal}', [NewBacTerimaController::class, 'generateKode']);
    });

    Route::prefix('bac-pakai')->group(function () {
        Route::get('/get-bac-pakai-by-id/{id}', [BacPakaiController::class, 'getBacById']);
        Route::get('/download/{file}', [BacPakaiController::class, 'download'])->name('bac-pakai.download');
        Route::get('/generate-kode/{tanggal}', [BacPakaiController::class, 'generateKode']);
    });

    Route::resource('item', ItemController::class)->except('show');
    Route::resource('bac-terima', BacTerimaController::class);
    Route::resource('new-bac-terima', NewBacTerimaController::class);
    Route::resource('bac-pakai', BacPakaiController::class);
    Route::resource('aso', AsoController::class);
    Route::resource('received', ReceivedController::class);
});
