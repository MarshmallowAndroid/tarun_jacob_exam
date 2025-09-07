<?php

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

pest()->use(RefreshDatabase::class);

it('returns a successful response', function () {

    $response = $this->get('/');

    $response->assertStatus(200);
});
