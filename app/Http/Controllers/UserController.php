<?php

namespace App\Http\Controllers;

use App\Http\Requests\Settings\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return back();
    }

    function delete(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer'
        ]);

        User::find($validated['id'])->delete();

        return back();
    }

    function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string|max:255',
            // ignore unique email rule for the current user
            'email' => 'required|string|lowercase|email|max:255|'.Rule::unique(User::class)->ignore($request['id']),
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $attribs = [
            'name' => $validated['name'],
            'email' => $validated['email']
        ];

        if ($validated['password']) {
            $attribs['password'] = $validated['password'];
        }

        User::find($validated['id'])->update($attribs);

        return back();
    }
}
