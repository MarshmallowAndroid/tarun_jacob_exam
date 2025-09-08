<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductController extends Controller
{
    function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'stocks' => 'required|integer',
        ]);

        Product::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'stocks' => $validated['stocks'],
        ])->save();

        return back();
    }

    function delete(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer'
        ]);

        Product::find($validated['id'])->delete();

        return back();
    }

    function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string',
            'price' => 'required|numeric',
            'stocks' => 'required|integer',
        ]);

        Product::find($validated['id'])->fill($validated)->save();

        return back();
    }
}
