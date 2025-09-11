<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function store(Request $request)
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

    public function delete(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer',
        ]);

        Product::find($validated['id'])->delete();

        return back();
    }

    public function update(Request $request)
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
