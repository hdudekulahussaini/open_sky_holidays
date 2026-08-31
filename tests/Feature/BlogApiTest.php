<?php

use App\Models\Author;
use App\Models\Blog;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('blog create and edit pages render successfully with description', function () {
    $user = User::factory()->create(['is_admin' => true]);
    $category = Category::create(['name' => 'Destinations', 'slug' => 'destinations']);
    $author = Author::create(['name' => 'Open Sky Team']);

    $blog = Blog::create([
        'category_id' => $category->id,
        'author_id' => $author->id,
        'title' => 'Top 10 Must-Visit Destinations in India in 2026',
        'slug' => 'top-10-must-visit-destinations-in-india-in-2026',
        'description' => 'Explore the most breathtaking destinations across India with expert tips.',
        'table_of_contents' => [
            'Book Your Flights in Advance',
            'Be Flexible With Your Dates and Destinations',
        ],
        'content' => "1. Book Your Flights in Advance\nThe golden rule for budget travel.",
        'featured_image' => 'blogs/test.jpg',
        'read_time' => 3,
        'status' => true,
        'published_at' => now(),
    ]);

    $createResponse = $this->actingAs($user)->get(route('admin.blogs.create'));
    $createResponse->assertStatus(200);
    $createResponse->assertSee('Short Description / Overview');

    $editResponse = $this->actingAs($user)->get(route('admin.blogs.edit', $blog));
    $editResponse->assertStatus(200);
    $editResponse->assertSee('Explore the most breathtaking destinations across India with expert tips.');
});

test('api returns blog list and details with description field', function () {
    $category = Category::create(['name' => 'Destinations', 'slug' => 'destinations']);
    $author = Author::create(['name' => 'Open Sky Team']);

    $blog = Blog::create([
        'category_id' => $category->id,
        'author_id' => $author->id,
        'title' => 'How to Plan a Budget-Friendly International Trip',
        'slug' => 'how-to-plan-a-budget-friendly-international-trip',
        'description' => 'Complete guide with practical tips to travel the world on a budget.',
        'table_of_contents' => [
            'Book Your Flights in Advance',
        ],
        'content' => "1. Book Your Flights in Advance\nBook early to save money.",
        'featured_image' => 'blogs/test.jpg',
        'read_time' => 3,
        'status' => true,
        'published_at' => now(),
    ]);

    // Test List API
    $listResponse = $this->getJson('/api/blogs');
    $listResponse->assertStatus(200)
        ->assertJsonFragment([
            'title' => 'How to Plan a Budget-Friendly International Trip',
            'description' => 'Complete guide with practical tips to travel the world on a budget.',
        ]);

    // Test Detail API
    $detailResponse = $this->getJson('/api/blogs/' . $blog->slug);
    $detailResponse->assertStatus(200)
        ->assertJson([
            'success' => true,
            'blog' => [
                'title' => 'How to Plan a Budget-Friendly International Trip',
                'description' => 'Complete guide with practical tips to travel the world on a budget.',
            ],
        ]);
});
