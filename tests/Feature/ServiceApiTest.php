<?php

use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('services api returns active services with cta banner and stats', function () {
    $service = Service::create([
        'title' => 'Visa Assistance Services',
        'slug' => 'visa-assistance-services',
        'about_title' => 'Your Gateway to Seamless Global Travel',
        'about_description' => 'Comprehensive visa guidance.',
        'features' => [
            ['icon' => 'fa-solid fa-clipboard-list', 'title' => 'Best Fares', 'description' => 'Competitive pricing'],
        ],
        'service_items' => ['Tourist Visas'],
        'process_steps' => [
            ['icon' => '01', 'title' => 'Profile Assessment', 'description' => 'We review your documents'],
        ],
        'documents' => ['Valid Passport'],
        'why_choose_items' => ['98% High Success Rate'],
        'cta_title' => 'Ready To Start Your Journey?',
        'cta_description' => 'Let us take care of your visa process.',
        'stats' => [
            ['number' => '10,000+', 'label' => 'Visas Processed'],
            ['number' => '25+', 'label' => 'Countries Covered'],
            ['number' => '98%', 'label' => 'Success Rate'],
        ],
        'status' => true,
    ]);

    $response = $this->getJson('/api/services');

    $response->assertOk()
        ->assertJsonPath('status', true)
        ->assertJsonPath('data.0.title', 'Visa Assistance Services')
        ->assertJsonPath('data.0.cta_title', 'Ready To Start Your Journey?')
        ->assertJsonPath('data.0.stats.0.number', '10,000+')
        ->assertJsonPath('data.0.features.0.icon', 'fa-solid fa-clipboard-list');
});

test('service details can be fetched by slug', function () {
    $service = Service::create([
        'title' => 'Visa Assistance Services',
        'slug' => 'visa',
        'about_title' => 'Your Gateway to Seamless Global Travel',
        'about_description' => 'Comprehensive visa guidance.',
        'features' => [
            ['icon' => 'fa-solid fa-shield-halved', 'title' => 'Global Reach', 'description' => '50+ countries'],
        ],
        'status' => true,
    ]);

    $response = $this->getJson('/api/services/visa');

    $response->assertOk()
        ->assertJsonPath('status', true)
        ->assertJsonPath('data.slug', 'visa')
        ->assertJsonPath('data.features.0.icon', 'fa-solid fa-shield-halved');
});
