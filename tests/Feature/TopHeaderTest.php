<?php

use App\Models\TopHeader;
use App\Models\User;

test('guest cannot access admin top-headers index', function () {
    $response = $this->get(route('admin.top-headers.index'));

    $response->assertRedirect(route('admin.login'));
});

test('authenticated admin can view top-headers index and create', function () {
    $user = User::factory()->create([
        'is_admin' => true,
    ]);

    $response = $this->actingAs($user)->get(route('admin.top-headers.index'));
    $response->assertStatus(200);

    $createResponse = $this->actingAs($user)->get(route('admin.top-headers.create'));
    $createResponse->assertStatus(200);
});

test('api returns active top header', function () {
    TopHeader::create([
        'email' => 'contact@openskyholidays.com',
        'tagline' => 'Explore the world with us!',
        'button_text' => 'Book Tour',
        'button_url' => 'https://openskyholidays.com/tours',
        'social_links' => [
            ['platform' => 'Facebook', 'icon' => 'fa-brands fa-facebook-f', 'url' => 'https://facebook.com/opensky'],
        ],
        'status' => true,
    ]);

    $response = $this->getJson('/api/top-header/active');
    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'data' => [
                'email' => 'contact@openskyholidays.com',
                'tagline' => 'Explore the world with us!',
                'button_text' => 'Book Tour',
                'button_url' => 'https://openskyholidays.com/tours',
            ],
        ]);
});

test('api returns 404 when no active top header exists', function () {
    TopHeader::query()->delete();

    $response = $this->getJson('/api/top-header/active');
    $response->assertStatus(404)
        ->assertJson([
            'success' => false,
            'message' => 'No active top header bar found.',
        ]);
});
