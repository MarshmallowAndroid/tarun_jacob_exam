<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    function get_cart_item(User $user, Product $product)
    {
        return $user->cart()
            ->withPivotValue('product_id', $product->getAttributeValue('id'))
            ->first();
    }

    function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer',
        ]);

        // store requested quantity
        $newQuantity = $validated['quantity'];

        // find matching product
        $productId = $validated['product_id'];
        $product = Product::find($productId);
        $cartItem = $this->get_cart_item($user, $product);

        // add the product if it doesn't exist in the cart
        // quantity is 0 since we're gonna add it later
        if (!$cartItem) {
            $user->cart()->attach($product, ['quantity' => 0]);
            $cartItem = $this->get_cart_item($user, $product);
        }

        // get the old quantity if ever
        $oldQuantity = $cartItem->cart_item->quantity;

        // update our cart pivot table
        $user->cart()->updateExistingPivot($productId, ['quantity' => $oldQuantity + $newQuantity]);

        return back();
    }

    function delete(Request $request)
    {
        $user = $request->user();
        $validated = $request->validate([
            'id' => 'required|integer'
        ]);
        $user->cart()->detach($validated['id']);

        return back();
    }
}
