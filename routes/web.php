<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

if (!function_exists('check_admin'))
{
    function check_admin(Request $request): bool {
        $user = $request->user();
        return $user !== null && $user->can('do-admin');
    }
}

Route::get('/', function (Request $request) {
    if (check_admin($request)) {
        return redirect(route('admin.products'));
    } else {
        return Inertia::render('Home', [
            'search' => $request->search,
            'sort' => $request->sort,
        ]);
    }
})->name('home');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/cart.php';