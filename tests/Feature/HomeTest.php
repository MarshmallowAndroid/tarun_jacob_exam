<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Log;

test('add to cart redirects to login if unauthenticated', function () {
    $this->seed();

    $product = Product::first();

    $response = $this->post(route('cart.store', [
        'product_id' => $product->id,
        'quantity' => 1,
    ]));

    $response->assertRedirect(route('login'));
});

test('authenticated users can add to cart', function () {
    $this->seed();

    $user = User::factory()->create();

    $product = Product::first();

    $response = $this->actingAs($user)->
        post(route('cart.store', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]));

    $response->assertRedirectBack();
});

test('adding to cart increases quantity instead of duplicating', function () {
    $this->seed();

    $user = User::factory()->create();

    $product = Product::first();

    $this->actingAs($user)->
        post(route('cart.store', [
            'product_id' => $product->id,
            'quantity' => 2,
        ]));

    $cart = $this->actingAs($user)
        ->get(route('api.cart'))
        ->json();

    $this->assertEquals(1, count($cart));
    $this->assertEquals(2, $cart[0]['cart_item']['quantity']);

    $this->actingAs($user)->
        post(route('cart.store', [
            'product_id' => $product->id,
            'quantity' => 5,
        ]));

    $cart = $this->actingAs($user)
        ->get(route('api.cart'))
        ->json();

    $this->assertEquals(1, count($cart));
    $this->assertEquals(7, $cart[0]['cart_item']['quantity']);
});