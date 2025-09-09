<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductUserController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\HandleGuest;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductUser;
use App\Models\User;
use Inertia\Inertia;


Route::middleware(['auth', HandleGuest::class])->group(function () {

    Route::prefix('admin')->name('admin.')->group(function () {

        Route::get('/', function () {
            return redirect('admin/products');
        });

        Route::get('products', function (Request $request) {
            return Inertia::render('admin/Products', ['products' => Product::orderBy('created_at', 'desc')->get()]);
        })->name('products');
        Route::post(
            'products',
            [ProductController::class, 'store']
        )->name('products.store');
        Route::patch(
            'products',
            [ProductController::class, 'update']
        )->name('products.update');
        Route::delete(
            'products',
            [ProductController::class, 'delete']
        )->name('products.delete');

        Route::get('orders', function (Request $request) {
            return Inertia::render('admin/Orders', [
                'orders' => ProductUser::where('checked_out', '=', true)->
                    orderBy('created_at', 'desc')->with(['user', 'product'])->get()
            ]);
        })->name('orders');
        Route::post('orders', [ProductUserController::class, 'update']);
        Route::delete('orders', [ProductUserController::class, 'delete']);

        Route::get('users', function (Request $request) {
            return Inertia::render('admin/Users', ['users' => User::orderBy('created_at', 'desc')->get()]);
        })->name('users');
        Route::post(
            'users',
            [UserController::class, 'store']
        )->name('users.store');
        Route::patch(
            'users',
            [UserController::class, 'update']
        )->name('users.update');
        Route::delete(
            'users',
            [UserController::class, 'delete']
        )->name('users.delete');
    });
});