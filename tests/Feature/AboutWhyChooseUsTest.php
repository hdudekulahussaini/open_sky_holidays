<?php

use App\Models\AboutWhyChooseUs;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('about why choose us index and edit page can be rendered', function () {
    $user = User::factory()->create(['is_admin' => true]);

    $section = AboutWhyChooseUs::create([
        'subtitle' => 'Why Choose Us',
        'title' => 'Setting Standard for Trust and Comfort.',
        'description' => "We believe that traveling shouldn't be stressful.",
        'image' => 'about_why_choose_us/test.jpg',
        'features_icon' => ['fa-solid fa-headset'],
        'features_title' => ['24/7 Expert Support'],
        'features_description' => ['Our travel assistants are always available.'],
        'badge_title' => 'Trusted by 15,000+',
        'badge_subtitle' => 'Happy travelers worldwide',
        'status' => 'active',
    ]);

    $response = $this->actingAs($user)->get(route('admin.about-why-choose-us.index'));
    $response->assertStatus(200);
    $response->assertSee('Setting Standard for Trust and Comfort.');
    $response->assertSee('Trusted by 15,000+');

    $editResponse = $this->actingAs($user)->get(route('admin.about-why-choose-us.edit', $section));
    $editResponse->assertStatus(200);
    $editResponse->assertSee('24/7 Expert Support');
});

test('api can list active about why choose us with icons and badge', function () {
    AboutWhyChooseUs::create([
        'subtitle' => 'Why Choose Us',
        'title' => 'Setting Standard for Trust and Comfort.',
        'description' => "We believe that traveling shouldn't be stressful.",
        'image' => 'about_why_choose_us/test.jpg',
        'features_icon' => ['fa-solid fa-headset'],
        'features_title' => ['24/7 Expert Support'],
        'features_description' => ['Our travel assistants are always available.'],
        'badge_title' => 'Trusted by 15,000+',
        'badge_subtitle' => 'Happy travelers worldwide',
        'status' => 'active',
    ]);

    $response = $this->getJson('/api/about-why-choose-us');

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'data' => [
                [
                    'subtitle' => 'Why Choose Us',
                    'title' => 'Setting Standard for Trust and Comfort.',
                    'badge_title' => 'Trusted by 15,000+',
                    'badge_subtitle' => 'Happy travelers worldwide',
                    'features_icon' => ['fa-solid fa-headset'],
                    'features_title' => ['24/7 Expert Support'],
                ],
            ],
        ]);
});

test('api can fetch single active about why choose us section', function () {
    AboutWhyChooseUs::create([
        'subtitle' => 'Why Choose Us',
        'title' => 'Setting Standard for Trust and Comfort.',
        'description' => "We believe that traveling shouldn't be stressful.",
        'image' => 'about_why_choose_us/test.jpg',
        'features_icon' => ['fa-solid fa-headset', 'fa-solid fa-hotel'],
        'features_title' => ['24/7 Expert Support', 'Handpicked Accommodations'],
        'features_description' => ['Support text', 'Accommodations text'],
        'badge_title' => 'Trusted by 15,000+',
        'badge_subtitle' => 'Happy travelers worldwide',
        'status' => 'active',
    ]);

    $response = $this->getJson('/api/about-why-choose-us/active');

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'data' => [
                'subtitle' => 'Why Choose Us',
                'title' => 'Setting Standard for Trust and Comfort.',
                'badge_title' => 'Trusted by 15,000+',
                'badge_subtitle' => 'Happy travelers worldwide',
                'features' => [
                    [
                        'title' => '24/7 Expert Support',
                        'icon' => 'fa-solid fa-headset',
                    ],
                    [
                        'title' => 'Handpicked Accommodations',
                        'icon' => 'fa-solid fa-hotel',
                    ],
                ],
            ],
        ]);
});
