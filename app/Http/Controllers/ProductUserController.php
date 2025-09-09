<?php

namespace App\Http\Controllers;

use App\Models\ProductUser;
use Illuminate\Http\Request;
use Log;

class ProductUserController extends Controller
{
    function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer',
            'status' => 'required|integer',
        ]);

        ProductUser::find($validated['id'])->fill($validated)
            ->save();

        return back();
    }

    function delete(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer',
        ]);

        ProductUser::find($validated['id'])->delete();

        return back();
    }
}
