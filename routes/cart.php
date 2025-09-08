<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::get('cart', function () {
        return to_route('home');
    });
    Route::post('cart', [CartController::class, 'store'])->name('cart.store');
    Route::delete('cart', [CartController::class, 'delete'])->name('cart.delete');
});