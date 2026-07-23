<?php

namespace Database\Seeders;

use App\Models\Tour;
use App\Models\TourFeature;
use App\Models\TourType;
use Illuminate\Database\Seeder;

class TourSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Tour Types
        $adventureType = TourType::updateOrCreate(['slug' => 'adventure'], ['name' => 'Adventure']);
        $honeymoonType = TourType::updateOrCreate(['slug' => 'honeymoon'], ['name' => 'Honeymoon']);
        $familyType = TourType::updateOrCreate(['slug' => 'family-tours'], ['name' => 'Family Tours']);
        $culturalType = TourType::updateOrCreate(['slug' => 'cultural'], ['name' => 'Cultural']);

        // 2. Create a fully populated Tour
        $tour = Tour::create([
            'tour_type_id' => $adventureType->id,
            'title' => 'Dubai Red Dunes Desert Safari',
            'slug' => 'dubai-red-dunes-desert-safari',
            'country' => 'United Arab Emirates',
            'duration' => '6 Hours',
            'thumbnail' => 'tours/desert_safari.jpg',
            'status' => true,
        ]);

        // 3. Create Tour Detail
        $tour->detail()->create([
            'heading' => 'Experience the magic of the Arabian Desert',
            'description' => 'Embark on an unforgettable adventure into the heart of the Dubai desert. Feel the thrill of dune bashing in a luxury 4x4, ride camels over sand dunes, and experience traditional Emirati culture at our desert camp. End your evening with a delicious BBQ dinner under the stars while watching live entertainment.',
            'status' => 'active',
        ]);

        // 4. Create Gallery Images (relational)
        $tour->gallery()->createMany([
            ['image' => 'tour-details/gallery/dune_bashing.jpg'],
            ['image' => 'tour-details/gallery/camel_riding.jpg'],
            ['image' => 'tour-details/gallery/desert_dinner.jpg'],
        ]);

        // 5. Create Inclusions
        $tour->features()->createMany([
            [
                'type' => TourFeature::TYPE_PACKAGE_INCLUSION,
                'title' => 'Hotel pick up and drop off in 4x4 SUV',
                'description' => 'Convenient transfer from any hotel in Dubai.',
                'sort_order' => 1,
                'status' => 'active',
            ],
            [
                'type' => TourFeature::TYPE_PACKAGE_INCLUSION,
                'title' => 'Barbecue dinner buffet',
                'description' => 'With vegetarian and non-vegetarian selections.',
                'sort_order' => 2,
                'status' => 'active',
            ],
            [
                'type' => TourFeature::TYPE_PACKAGE_INCLUSION,
                'title' => 'Sandboarding and camel riding',
                'description' => 'Guided sand adventure equipment included.',
                'sort_order' => 3,
                'status' => 'active',
            ],
        ]);

        // 6. Create Highlights
        $tour->features()->createMany([
            [
                'type' => TourFeature::TYPE_TOUR_HIGHLIGHT,
                'title' => '30-45 minutes thrilling dune bashing',
                'description' => 'Exciting ride over red dunes with professional drivers.',
                'sort_order' => 1,
                'status' => 'active',
            ],
            [
                'type' => TourFeature::TYPE_TOUR_HIGHLIGHT,
                'title' => 'Live belly dance and Tanoura show',
                'description' => 'Traditional dance performances at the camp.',
                'sort_order' => 2,
                'status' => 'active',
            ],
            [
                'type' => TourFeature::TYPE_TOUR_HIGHLIGHT,
                'title' => 'Sunset photo stop in the desert',
                'description' => 'Capture breath-taking photos of the desert sunset.',
                'sort_order' => 3,
                'status' => 'active',
            ],
        ]);

        // 7. Create Places Covered
        $tour->features()->createMany([
            [
                'type' => TourFeature::TYPE_PLACE_COVERED,
                'title' => 'Lahbab Red Sand Desert',
                'description' => 'Known for its stunning red dunes and tall slopes.',
                'image' => 'tour-features/lahbab.jpg',
                'sort_order' => 1,
                'status' => 'active',
            ],
            [
                'type' => TourFeature::TYPE_PLACE_COVERED,
                'title' => 'Al Aweer Bedouin Camp',
                'description' => 'A traditional camp showcasing Arabic culture and hospitality.',
                'image' => 'tour-features/camp.jpg',
                'sort_order' => 2,
                'status' => 'active',
            ],
        ]);
    }
}
