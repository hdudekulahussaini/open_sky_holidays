<?php

use App\Models\AboutOurCoreValue;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('edit page can be rendered for about our core values', function () {
    $user = User::factory()->create();

    $coreValue = AboutOurCoreValue::create([
        'title' => 'Integrity',
        'description' => 'We act with honesty and transparency.',
    ]);

    $response = $this->actingAs($user)->get(route('admin.about-our-core-values.edit', $coreValue));

    $response->assertStatus(200);
    $response->assertSee('Integrity');
    $response->assertSee('We act with honesty and transparency.');
});

test('core value can be updated', function () {
    $user = User::factory()->create();

    $coreValue = AboutOurCoreValue::create([
        'title' => 'Integrity',
        'description' => 'We act with honesty and transparency.',
    ]);

    $response = $this->actingAs($user)->put(route('admin.about-our-core-values.update', $coreValue), [
        'title' => 'Excellence',
        'description' => 'We strive for the highest quality.',
    ]);

    $response->assertRedirect(route('admin.about-our-core-values.index'));
    $this->assertDatabaseHas('about_our_core_values', [
        'id' => $coreValue->id,
        'title' => 'Excellence',
        'description' => 'We strive for the highest quality.',
    ]);
});
