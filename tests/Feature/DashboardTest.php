<?php

use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('guests are redirected to the login page', function () {
    $response = $this->get(route('admin.products'));
    $response->assertRedirect(route('login'));
});

test('admin users can visit the dashboard', function () {
    $user = User::factory()->adminUser()->create();
    $this->actingAs($user);

    $response = $this->get(route('admin.products'));
    $response->assertStatus(200);
});