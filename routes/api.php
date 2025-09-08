<?php

use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/products', function (Request $request)
{
    return Product::paginate(12);
})->name('api.products');

Route::get('/cart', function (Request $request)
{
    $user = $request->user();
    if ($user)
    {
        return $user->cart()
            ->orderBy('created_at', 'desc')->get();
    }
})->middleware('auth:sanctum')->name('api.cart');