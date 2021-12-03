<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;


// untuk nonaktifkan route register
Auth::routes(['register' => false]);

// Homepage
Route::get('/home', function () {
    return redirect()->route('home');
});

Route::get('/', [HomeController::class, 'index'])->name('home');


