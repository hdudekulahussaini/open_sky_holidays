<?php

use App\Models\Tour;
use App\Models\TourFeature;
use App\Models\TourType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('can list tours via API', function () {
    $tourType = TourType::create(['name' => 'Adventure', 'slug' => 'adventure']);
    $tour = Tour::create([
        'tour_type_id' => $tourType->id,
        'title' => 'Desert Safari',
        'slug' => 'desert-safari',
        'country' => 'UAE',
        'duration' => '5 Hours',
        'thumbnail' => 'tours/test.jpg',
        'status' => true,
    ]);

    $tour->detail()->create([
        'heading' => 'Explore the red dunes',
        'description' => 'A great experience',
        'status' => 'active',
    ]);

    $tour->gallery()->create(['image' => 'tour-details/gallery/img1.jpg']);
    $tour->features()->create([
        'type' => TourFeature::TYPE_PACKAGE_INCLUSION,
        'title' => 'Inclusion 1',
        'status' => 'active',
    ]);

    $response = $this->getJson('/api/tours');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id', 'title', 'slug', 'country', 'duration', 'thumbnail', 'thumbnail_url',
                    'detail' => ['heading', 'description', 'status'],
                    'gallery' => [
                        '*' => ['id', 'image', 'image_url'],
                    ],
                    'features' => [
                        '*' => ['id', 'title', 'type', 'type_label'],
                    ],
                ],
            ],
        ]);
});

test('can retrieve single tour via API', function () {
    $tourType = TourType::create(['name' => 'Adventure', 'slug' => 'adventure']);
    $tour = Tour::create([
        'tour_type_id' => $tourType->id,
        'title' => 'Desert Safari',
        'slug' => 'desert-safari',
        'country' => 'UAE',
        'duration' => '5 Hours',
        'thumbnail' => 'tours/test.jpg',
        'status' => true,
    ]);

    $response = $this->getJson("/api/tours/{$tour->id}");

    $response->assertStatus(200)
        ->assertJsonPath('data.title', 'Desert Safari');
});

test('can create tour via API', function () {
    Storage::fake('public');

    $tourType = TourType::create(['name' => 'Adventure', 'slug' => 'adventure']);

    $payload = [
        'tour_type_id' => $tourType->id,
        'title' => 'New Adventure Tour',
        'slug' => 'new-adventure-tour',
        'country' => 'Oman',
        'duration' => '3 Days',
        'thumbnail' => UploadedFile::fake()->image('thumb.jpg'),
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
        'tour_highlights' => [
            ['title' => 'Stunning views', 'sort_order' => 1],
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

    $response->assertStatus(201);

    $this->assertDatabaseHas('tours', ['title' => 'New Adventure Tour']);
    $this->assertDatabaseHas('tour_details', ['heading' => 'Beautiful Mountains']);
    $this->assertDatabaseCount('tour_images', 2);
    $this->assertDatabaseCount('tour_features', 4); // 2 inclusions, 1 highlight, 1 place
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
