<?php

use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/products', function (Request $request) {
    $searchQuery = $request->search;
    $sort = $request->sort;
    $validSort = $sort === 'asc' || $sort === 'desc';

    if ($searchQuery == null && $sort == null) {
        return Product::orderBy('price')->paginate(12);
    }

    if ($sort != '' && $searchQuery == '') {
        return Product::orderBy('price', $sort)->paginate(12);
    }

    if ($searchQuery != null) {
        $firstPass = Product::where('name', 'like', "%$searchQuery%");

        $secondPass = $firstPass->orderBy($validSort ? 'price' : 'created_at', $validSort ? $sort : 'desc');

        return $secondPass->paginate(12);
    }

})->name('api.products');

Route::get('/cart', function (Request $request) {
    $user = $request->user();
    if ($user) {
        return $user->cart()->orderByPivot('created_at', 'desc')->get();
    }
})->middleware('auth:sanctum')->name('api.cart');