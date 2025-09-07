<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\HandleGuest;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

if (!function_exists('check_admin'))
{
    function check_admin(Request $request): bool
    {
        $user = $request->user();
        return $user !== null && $user->can('do-admin');
    }
}

Route::get('/', function (Request $request) {

    if (check_admin($request)) {
        return redirect('admin/products');
    } else {
        return Inertia::render('Home', [
            'products' => Product::paginate(perPage: 12)
        ]);
    }
})->name('home');

Route::middleware(['auth', HandleGuest::class])->group(function () {

    Route::prefix('admin')->name('admin.')->group(function () {

        Route::get('/', function() {
            return redirect('admin/products');
        });

        Route::get('products', function (Request $request) {
            return Inertia::render('admin/Products', ['products' => Product::orderBy('created_at', 'desc')->get()]);
        })->name('products');
        Route::post('products', [ProductController::class, 'create']
        )->name('products.create');
        Route::patch('products', [ProductController::class, 'update']
        )->name('products.update');
        Route::delete('products', [ProductController::class, 'delete']
        )->name('products.delete');

        Route::get('orders', function (Request $request) {
            return Inertia::render('admin/Orders');
        })->name('orders');

        Route::get('users', function (Request $request) {
            return Inertia::render('admin/Users', ['users' => User::orderBy('created_at', 'desc')->get()]);
        })->name('users');
        Route::post('users', [UserController::class, 'create']
        )->name('users.create');
        Route::patch('users', [UserController::class, 'update']
        )->name('users.update');
        Route::delete('users', [UserController::class, 'delete']
        )->name('users.delete');
    });
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
