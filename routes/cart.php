<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::post('cart', [CartController::class, 'store'])->name('cart.store');
});