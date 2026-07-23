<?php

use App\Models\Tour;
use App\Models\TourInquiry;
use App\Models\TourType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can create a tour inquiry via API', function () {
    $tourType = TourType::create(['name' => 'Adventure', 'slug' => 'adventure']);
    $tour = Tour::create([
        'tour_type_id' => $tourType->id,
        'title' => 'Red Dunes Safari',
        'slug' => 'red-dunes-safari',
        'country' => 'UAE',
        'duration' => '5 Hours',
        'thumbnail' => 'tours/thumb.jpg',
        'status' => true,
    ]);

    $payload = [
        'tour_id' => $tour->id,
        'name' => 'John Doe',
        'phone' => '+971501234567',
        'email' => 'john@example.com',
        'travel_date' => now()->addDays(5)->format('Y-m-d'),
        'travelers' => 3,
    ];

    $response = $this->postJson('/api/tour-inquiries', $payload);

    $response->assertStatus(201)
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.name', 'John Doe');

    $this->assertDatabaseHas('tour_inquiries', [
        'tour_id' => $tour->id,
        'name' => 'John Doe',
        'phone' => '+971501234567',
        'email' => 'john@example.com',
        'travelers' => 3,
        'status' => 'new',
    ]);
});

test('api validation rules block invalid tour inquiry payloads', function () {
    $response = $this->postJson('/api/tour-inquiries', []);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['tour_id', 'name', 'phone', 'email', 'travel_date', 'travelers']);
});

test('guest is redirected from admin tour inquiries pages', function () {
    $response = $this->get('/admin/tour-inquiries');
    $response->assertRedirect('/admin/login');
});

test('admin can access and manage tour inquiries via dashboard', function () {
    // Create admin user
    $admin = User::create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
        'is_admin' => true,
    ]);

    $tourType = TourType::create(['name' => 'Adventure', 'slug' => 'adventure']);
    $tour = Tour::create([
        'tour_type_id' => $tourType->id,
        'title' => 'Red Dunes Safari',
        'slug' => 'red-dunes-safari',
        'country' => 'UAE',
        'duration' => '5 Hours',
        'thumbnail' => 'tours/thumb.jpg',
        'status' => true,
    ]);

    $inquiry = TourInquiry::create([
        'tour_id' => $tour->id,
        'name' => 'Jane Smith',
        'phone' => '+971507654321',
        'email' => 'jane@example.com',
        'travel_date' => now()->addDays(10)->format('Y-m-d'),
        'travelers' => 2,
    ]);

    // index
    $response = $this->actingAs($admin)->get('/admin/tour-inquiries');
    $response->assertStatus(200)
        ->assertSee('Jane Smith')
        ->assertSee('Red Dunes Safari');

    // show
    $response = $this->actingAs($admin)->get("/admin/tour-inquiries/{$inquiry->id}");
    $response->assertStatus(200)
        ->assertSee('Jane Smith')
        ->assertSee('+971507654321');

    // update
    $payload = [
        'status' => 'contacted',
    ];
    $response = $this->actingAs($admin)
        ->from("/admin/tour-inquiries/{$inquiry->id}")
        ->put("/admin/tour-inquiries/{$inquiry->id}", $payload);

    $response->assertRedirect("/admin/tour-inquiries/{$inquiry->id}");

    $this->assertDatabaseHas('tour_inquiries', [
        'id' => $inquiry->id,
        'name' => 'Jane Smith', // remains unchanged
        'status' => 'contacted',
    ]);

    // destroy
    $response = $this->actingAs($admin)->delete("/admin/tour-inquiries/{$inquiry->id}");
    $response->assertRedirect('/admin/tour-inquiries');

    $this->assertDatabaseMissing('tour_inquiries', ['id' => $inquiry->id]);
});
