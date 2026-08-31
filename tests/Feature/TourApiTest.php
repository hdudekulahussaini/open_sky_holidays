<?php

use App\Models\Tour;
use App\Models\TourFeature;
use App\Models\TourType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('can list tours via API', function () {
    $tourType = TourType::create(['name' => 'Domestic', 'slug' => 'domestic']);
    $tour = Tour::create([
        'tour_type_id' => $tourType->id,
        'title' => 'Kerala',
        'slug' => 'kerala',
        'country' => 'India',
        'state' => 'Kerala',
        'duration' => '4 NIGHTS / 5 DAYS',
        'thumbnail' => 'tours/kerala.jpg',
        'areas' => ['Munnar', 'Alleppey', 'Thekkady', 'Kochi Fort'],
        'status' => true,
    ]);

    $tour->detail()->create([
        'heading' => 'About This Tour',
        'description' => 'Explore Kerala',
        'status' => 'active',
    ]);

    $tour->gallery()->create(['image' => 'tour-details/gallery/img1.jpg']);
    $tour->features()->create([
        'type' => TourFeature::TYPE_PACKAGE_INCLUSION,
        'title' => '4 Star Accommodation',
        'status' => 'active',
    ]);
    $tour->features()->create([
        'type' => TourFeature::TYPE_PLACE_COVERED,
        'title' => 'Munnar',
        'status' => 'active',
    ]);

    $response = $this->getJson('/api/tours');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id', 'title', 'slug', 'country', 'state', 'duration', 'thumbnail', 'thumbnail_url',
                    'areas', 'highlights',
                    'detail' => ['heading', 'description', 'status'],
                    'gallery' => [
                        '*' => ['id', 'image', 'image_url'],
                    ],
                    'tour_features' => [
                        '*' => ['id', 'title', 'type', 'type_label'],
                    ],
                    'package_inclusions',
                    'places_covered',
                ],
            ],
        ])
        ->assertJsonPath('data.0.areas.0', 'Munnar')
        ->assertJsonPath('data.0.highlights.0', 'Munnar');
});

test('can retrieve single tour via API by ID or slug', function () {
    $tourType = TourType::create(['name' => 'Domestic', 'slug' => 'domestic']);
    $tour = Tour::create([
        'tour_type_id' => $tourType->id,
        'title' => 'Goa Special',
        'slug' => 'goa-special',
        'country' => 'India',
        'state' => 'Goa',
        'duration' => '3 NIGHTS / 4 DAYS',
        'thumbnail' => 'tours/goa.jpg',
        'areas' => ['Anjuna Beach', 'Baga Beach', 'Old Goa Church', 'Fort Aguada', 'Night Life'],
        'status' => true,
    ]);

    // Test by ID
    $responseById = $this->getJson("/api/tours/{$tour->id}");
    $responseById->assertStatus(200)
        ->assertJsonPath('data.title', 'Goa Special')
        ->assertJsonPath('data.state', 'Goa')
        ->assertJsonPath('data.areas.4', 'Night Life');

    // Test by Slug
    $responseBySlug = $this->getJson("/api/tours/goa-special");
    $responseBySlug->assertStatus(200)
        ->assertJsonPath('data.slug', 'goa-special')
        ->assertJsonPath('data.state', 'Goa')
        ->assertJsonPath('data.areas.4', 'Night Life');
});

test('can filter tours by type', function () {
    $domestic = TourType::create(['name' => 'Domestic', 'slug' => 'domestic']);
    $intl = TourType::create(['name' => 'International', 'slug' => 'international']);

    Tour::create([
        'tour_type_id' => $domestic->id,
        'title' => 'Kerala',
        'slug' => 'kerala-filter',
        'country' => 'India',
        'state' => 'Kerala',
        'duration' => '4 Nights / 5 Days',
        'thumbnail' => 'tours/kerala.jpg',
        'areas' => ['Munnar'],
        'status' => true,
    ]);

    Tour::create([
        'tour_type_id' => $intl->id,
        'title' => 'Dubai',
        'slug' => 'dubai-filter',
        'country' => 'UAE',
        'duration' => '5 Nights / 6 Days',
        'thumbnail' => 'tours/dubai.jpg',
        'status' => true,
    ]);

    $response = $this->getJson('/api/tours?type=domestic');
    $response->assertStatus(200)
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.slug', 'kerala-filter');
});

test('can create tour via API', function () {
    Storage::fake('public');

    $tourType = TourType::create(['name' => 'Adventure', 'slug' => 'adventure']);

    $payload = [
        'tour_type_id' => $tourType->id,
        'title' => 'New Adventure Tour',
        'slug' => 'new-adventure-tour',
        'country' => 'Oman',
        'state' => 'Muscat',
        'duration' => '3 Days',
        'thumbnail' => UploadedFile::fake()->image('thumb.jpg'),
        'areas' => ['Jebel Shams', 'Wadi Shab'],
        'features' => ['Jebel Shams', 'Wadi Shab'],
        'status' => 1,
        'detail' => [
            'heading' => 'Beautiful Mountains',
            'description' => 'Unbelievable sight seeing and trekking.',
            'status' => 'active',
        ],
        'gallery' => [
            UploadedFile::fake()->image('g1.jpg'),
            UploadedFile::fake()->image('g2.jpg'),
        ],
        'package_inclusions' => [
            ['title' => 'Free lunch', 'sort_order' => 1],
            ['title' => 'Pick up', 'sort_order' => 2],
        ],
        'places_covered' => [
            [
                'title' => 'Jebel Shams',
                'description' => 'Highest mountain in Oman',
                'image' => UploadedFile::fake()->image('place1.jpg'),
                'sort_order' => 1,
            ],
        ],
    ];

    $response = $this->postJson('/api/tours', $payload);

    $response->assertStatus(201)
        ->assertJsonPath('data.state', 'Muscat')
        ->assertJsonPath('data.areas.0', 'Jebel Shams')
        ->assertJsonPath('data.features.0', 'Jebel Shams');

    $this->assertDatabaseHas('tours', ['title' => 'New Adventure Tour', 'state' => 'Muscat']);
    $this->assertDatabaseHas('tour_details', ['heading' => 'Beautiful Mountains']);
    $this->assertDatabaseCount('tour_images', 2);
    $this->assertDatabaseCount('tour_features', 3); // 2 inclusions, 1 place
});

test('can update tour via API', function () {
    Storage::fake('public');

    $tourType = TourType::create(['name' => 'Adventure', 'slug' => 'adventure']);
    $tour = Tour::create([
        'tour_type_id' => $tourType->id,
        'title' => 'Old Tour',
        'slug' => 'old-tour',
        'country' => 'UAE',
        'duration' => '5 Hours',
        'thumbnail' => 'tours/test.jpg',
        'status' => true,
    ]);

    $tour->detail()->create([
        'heading' => 'Heading',
        'description' => 'Desc',
        'status' => 'active',
    ]);

    $gallery1 = $tour->gallery()->create(['image' => 'tour-details/gallery/img1.jpg']);
    $gallery2 = $tour->gallery()->create(['image' => 'tour-details/gallery/img2.jpg']);

    $inclusion = $tour->features()->create([
        'type' => TourFeature::TYPE_PACKAGE_INCLUSION,
        'title' => 'Old Inclusion',
        'status' => 'active',
    ]);

    $payload = [
        'tour_type_id' => $tourType->id,
        'title' => 'Updated Tour Title',
        'slug' => 'old-tour',
        'country' => 'UAE',
        'duration' => '6 Hours',
        'status' => 1,
        'detail' => [
            'heading' => 'Updated Heading',
            'description' => 'Updated Desc',
            'status' => 'active',
        ],
        'existing_gallery' => [
            $gallery1->image, // Retain image 1, delete image 2
        ],
        'gallery' => [
            UploadedFile::fake()->image('new-gallery.jpg'), // Add a new gallery image
        ],
        'package_inclusions' => [
            ['id' => $inclusion->id, 'title' => 'Updated Inclusion Name', 'sort_order' => 1],
            ['title' => 'New Inclusion', 'sort_order' => 2],
        ],
    ];

    $response = $this->putJson("/api/tours/{$tour->id}", $payload);

    $response->assertStatus(200);

    $this->assertDatabaseHas('tours', ['title' => 'Updated Tour Title']);
    $this->assertDatabaseHas('tour_details', ['heading' => 'Updated Heading']);

    // Check gallery count (1 existing retained + 1 new added = 2)
    $this->assertDatabaseCount('tour_images', 2);
    $this->assertDatabaseHas('tour_images', ['image' => $gallery1->image]);
    $this->assertDatabaseMissing('tour_images', ['image' => $gallery2->image]);

    // Check inclusions (1 updated + 1 new = 2)
    $this->assertDatabaseCount('tour_features', 2);
    $this->assertDatabaseHas('tour_features', ['id' => $inclusion->id, 'title' => 'Updated Inclusion Name']);
});

test('can delete tour via API', function () {
    Storage::fake('public');

    $tourType = TourType::create(['name' => 'Adventure', 'slug' => 'adventure']);
    $tour = Tour::create([
        'tour_type_id' => $tourType->id,
        'title' => 'Delete Me',
        'slug' => 'delete-me',
        'country' => 'UAE',
        'duration' => '5 Hours',
        'thumbnail' => 'tours/test.jpg',
        'status' => true,
    ]);

    $tour->detail()->create(['heading' => 'H', 'description' => 'D']);
    $tour->gallery()->create(['image' => 'tour-details/gallery/del.jpg']);
    $tour->features()->create([
        'type' => TourFeature::TYPE_PACKAGE_INCLUSION,
        'title' => 'Inclusion',
        'status' => 'active',
    ]);

    $response = $this->deleteJson("/api/tours/{$tour->id}");

    $response->assertStatus(200);

    $this->assertDatabaseMissing('tours', ['id' => $tour->id]);
    $this->assertDatabaseMissing('tour_details', ['tour_id' => $tour->id]);
    $this->assertDatabaseMissing('tour_images', ['tour_id' => $tour->id]);
    $this->assertDatabaseMissing('tour_features', ['tour_id' => $tour->id]);
});

test('deleting a tour type automatically deletes all related tours and triggers their file deletions', function () {
    Storage::fake('public');

    $tourType = TourType::create(['name' => 'Adventure', 'slug' => 'adventure']);
    $tour = Tour::create([
        'tour_type_id' => $tourType->id,
        'title' => 'Delete Me With Type',
        'slug' => 'delete-me-with-type',
        'country' => 'UAE',
        'duration' => '5 Hours',
        'thumbnail' => 'tours/test.jpg',
        'status' => true,
    ]);

    $tour->detail()->create(['heading' => 'H', 'description' => 'D']);
    $tour->gallery()->create(['image' => 'tour-details/gallery/del.jpg']);
    $tour->features()->create([
        'type' => TourFeature::TYPE_PACKAGE_INCLUSION,
        'title' => 'Inclusion',
        'status' => 'active',
    ]);

    // Delete the TourType
    $tourType->delete();

    // Assert everything is gone from DB
    $this->assertDatabaseMissing('tour_types', ['id' => $tourType->id]);
    $this->assertDatabaseMissing('tours', ['id' => $tour->id]);
    $this->assertDatabaseMissing('tour_details', ['tour_id' => $tour->id]);
    $this->assertDatabaseMissing('tour_images', ['tour_id' => $tour->id]);
    $this->assertDatabaseMissing('tour_features', ['tour_id' => $tour->id]);
});
