<?php

use App\Models\User;
use App\Models\WhatWeOffer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('what we offer index page can be rendered', function () {
    $user = User::factory()->create(['is_admin' => true]);

    $offer = WhatWeOffer::create([
        'title' => 'Domestic Tours',
        'subtitle' => 'Explore India',
        'description' => 'Great domestic travel packages.',
        'image' => 'what-we-offers/test.jpg',
        'status' => 'active',
    ]);

    $response = $this->actingAs($user)->get(route('admin.what-we-offers.index'));

    $response->assertStatus(200);
    $response->assertSee('Domestic Tours');
    $response->assertSee('Explore India');
});

test('what we offer item can be created with image upload', function () {
    Storage::fake('public');
    $user = User::factory()->create(['is_admin' => true]);

    $file = UploadedFile::fake()->image('offer.jpg');

    $response = $this->actingAs($user)->post(route('admin.what-we-offers.store'), [
        'title' => 'International Trips',
        'subtitle' => 'Worldwide Travel',
        'description' => 'Explore global destinations.',
        'status' => 'active',
        'image' => $file,
    ]);

    $response->assertRedirect(route('admin.what-we-offers.index'));

    $this->assertDatabaseHas('what_we_offers', [
        'title' => 'International Trips',
        'subtitle' => 'Worldwide Travel',
        'status' => 'active',
    ]);

    $offer = WhatWeOffer::where('title', 'International Trips')->first();
    expect($offer)->not->toBeNull();
    Storage::disk('public')->assertExists($offer->image);
});

test('what we offer item can be updated without re-uploading image', function () {
    Storage::fake('public');
    $user = User::factory()->create(['is_admin' => true]);

    $offer = WhatWeOffer::create([
        'title' => 'Domestic Tours',
        'subtitle' => 'Explore India',
        'description' => 'Initial description.',
        'image' => 'what-we-offers/initial.jpg',
        'status' => 'active',
    ]);

    $response = $this->actingAs($user)->put(route('admin.what-we-offers.update', $offer), [
        'title' => 'Updated Domestic Tours',
        'subtitle' => 'Explore Incredible India',
        'description' => 'Updated description.',
        'status' => 'inactive',
    ]);

    $response->assertRedirect(route('admin.what-we-offers.index'));

    $this->assertDatabaseHas('what_we_offers', [
        'id' => $offer->id,
        'title' => 'Updated Domestic Tours',
        'subtitle' => 'Explore Incredible India',
        'description' => 'Updated description.',
        'image' => 'what-we-offers/initial.jpg',
        'status' => 'inactive',
    ]);
});
