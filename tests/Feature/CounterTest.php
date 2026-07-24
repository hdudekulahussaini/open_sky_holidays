<?php

use App\Models\Counter;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('create page can be rendered for counters', function () {
    $user = User::factory()->create(['is_admin' => true]);

    $response = $this->actingAs($user)->get(route('admin.counters.create'));

    $response->assertStatus(200);
    $response->assertSee('Create Counter');
    $response->assertSee('+ Add Counter');
});

test('multiple counters can be stored at once', function () {
    $user = User::factory()->create(['is_admin' => true]);

    $response = $this->actingAs($user)->post(route('admin.counters.store'), [
        'counters' => [
            ['value' => '10K+', 'name' => 'Happy Customers'],
            ['value' => '100+', 'name' => 'Destinations'],
        ],
        'status' => '1',
    ]);

    $response->assertRedirect(route('admin.counters.index'));

    $this->assertDatabaseHas('counters', [
        'value' => '10K+',
        'name' => 'Happy Customers',
        'status' => true,
    ]);

    $this->assertDatabaseHas('counters', [
        'value' => '100+',
        'name' => 'Destinations',
        'status' => true,
    ]);
});

test('edit page preloads counter values', function () {
    $user = User::factory()->create(['is_admin' => true]);

    $counter = Counter::create([
        'value' => '15+',
        'name' => 'Years Experience',
        'status' => true,
    ]);

    $response = $this->actingAs($user)->get(route('admin.counters.edit', $counter));

    $response->assertStatus(200);
    $response->assertSee('Edit Counter');
    $response->assertSee('15+');
    $response->assertSee('Years Experience');
});

test('counters can be updated and new ones created on update', function () {
    $user = User::factory()->create(['is_admin' => true]);

    $counter1 = Counter::create([
        'value' => '15+',
        'name' => 'Years Experience',
        'status' => true,
    ]);

    $response = $this->actingAs($user)->put(route('admin.counters.update', $counter1), [
        'counters' => [
            [
                'id' => $counter1->id,
                'value' => '20+',
                'name' => 'Years Experience',
            ],
            [
                'value' => '1000+',
                'name' => 'Tours Sold',
            ],
        ],
        'status' => '1',
    ]);

    $response->assertRedirect(route('admin.counters.index'));

    $this->assertDatabaseHas('counters', [
        'id' => $counter1->id,
        'value' => '20+',
        'name' => 'Years Experience',
        'status' => true,
    ]);

    $this->assertDatabaseHas('counters', [
        'value' => '1000+',
        'name' => 'Tours Sold',
        'status' => true,
    ]);
});

test('edit page does not show add and remove options', function () {
    $user = User::factory()->create(['is_admin' => true]);

    $counter = Counter::create([
        'value' => '15+',
        'name' => 'Years Experience',
        'status' => true,
    ]);

    $response = $this->actingAs($user)->get(route('admin.counters.edit', $counter));

    $response->assertStatus(200);
    $response->assertDontSee('+ Add Counter');
    $response->assertDontSee('Remove');
});
