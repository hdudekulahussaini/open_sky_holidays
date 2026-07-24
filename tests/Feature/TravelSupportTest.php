<?php

use App\Models\TravelSupportSection;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('travel support index page can be rendered', function () {
    $user = User::factory()->create(['is_admin' => true]);

    $travelSupport = TravelSupportSection::create([
        'small_heading' => 'Assistance',
        'heading' => 'Full Travel Support',
        'description' => 'We assist you.',
        'features' => ['Feature A'],
        'status' => true,
    ]);

    $response = $this->actingAs($user)->get(route('admin.travel-support.index'));

    $response->assertStatus(200);
    $response->assertSee('Full Travel Support');
});

test('travel support edit page preloads travel support data successfully', function () {
    $user = User::factory()->create(['is_admin' => true]);

    $travelSupport = TravelSupportSection::create([
        'small_heading' => 'Assistance',
        'heading' => 'Full Travel Support',
        'description' => 'We assist you at every step.',
        'features' => ['Feature A', 'Feature B'],
        'status' => true,
    ]);

    $response = $this->actingAs($user)->get(route('admin.travel-support.edit', $travelSupport));

    $response->assertStatus(200);
    $response->assertSee('Full Travel Support');
    $response->assertSee('We assist you at every step.');
    $response->assertSee('Feature A');
});

test('travel support record can be updated', function () {
    $user = User::factory()->create(['is_admin' => true]);

    $travelSupport = TravelSupportSection::create([
        'small_heading' => 'Assistance',
        'heading' => 'Full Travel Support',
        'description' => 'We assist you at every step.',
        'features' => ['Feature A', 'Feature B'],
        'status' => true,
    ]);

    $response = $this->actingAs($user)->put(route('admin.travel-support.update', $travelSupport), [
        'small_heading' => 'Complete Help',
        'heading' => 'Updated Support',
        'description' => 'New Description',
        'features' => ['New Feature A'],
        'status' => '1',
    ]);

    $response->assertRedirect(route('admin.travel-support.index'));

    $this->assertDatabaseHas('travel_support_sections', [
        'id' => $travelSupport->id,
        'small_heading' => 'Complete Help',
        'heading' => 'Updated Support',
        'description' => 'New Description',
        'status' => true,
    ]);
});
