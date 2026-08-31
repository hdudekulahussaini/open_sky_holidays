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
        $domesticType = TourType::updateOrCreate(['slug' => 'domestic'], ['name' => 'Domestic Tours']);
        $internationalType = TourType::updateOrCreate(['slug' => 'international'], ['name' => 'International Tours']);
        $adventureType = TourType::updateOrCreate(['slug' => 'adventure'], ['name' => 'Adventure Tours']);
        $honeymoonType = TourType::updateOrCreate(['slug' => 'honeymoon'], ['name' => 'Honeymoon Tours']);

        // 2. Kerala Domestic Tour
        $kerala = Tour::updateOrCreate(
            ['slug' => 'kerala'],
            [
                'tour_type_id' => $domesticType->id,
                'title' => 'Kerala',
                'country' => 'India',
                'state' => 'Kerala',
                'duration' => '4 NIGHTS / 5 DAYS',
                'thumbnail' => 'tours/kerala.jpg',
                'areas' => ['Munnar', 'Alleppey', 'Thekkady', 'Kochi Fort'],
                'features' => ['Munnar', 'Alleppey', 'Thekkady', 'Kochi Fort'],
                'status' => true,
            ]
        );
        $kerala->detail()->updateOrCreate(
            ['tour_id' => $kerala->id],
            [
                'heading' => 'About This Tour',
                'description' => 'Experience the tranquil backwaters, mist-covered tea gardens of Munnar, and pristine wildlife sanctuaries of God’s Own Country.',
                'status' => 'active',
            ]
        );
        $kerala->features()->delete();
        $kerala->features()->createMany([
            ['type' => TourFeature::TYPE_PACKAGE_INCLUSION, 'title' => '4 Star Accommodation', 'description' => 'Handpicked premium hotels', 'sort_order' => 1, 'status' => 'active'],
            ['type' => TourFeature::TYPE_PACKAGE_INCLUSION, 'title' => 'Daily Meal', 'description' => 'Buffet breakfast & dinner', 'sort_order' => 2, 'status' => 'active'],
            ['type' => TourFeature::TYPE_PACKAGE_INCLUSION, 'title' => 'All Sightseeing', 'description' => 'Private AC cab with chauffeur', 'sort_order' => 3, 'status' => 'active'],
            ['type' => TourFeature::TYPE_PACKAGE_INCLUSION, 'title' => '24/7 Support', 'description' => 'Dedicated local tour manager', 'sort_order' => 4, 'status' => 'active'],
            ['type' => TourFeature::TYPE_PLACE_COVERED, 'title' => 'Munnar', 'description' => 'Lush tea plantations & viewpoints', 'image' => null, 'sort_order' => 1, 'status' => 'active'],
            ['type' => TourFeature::TYPE_PLACE_COVERED, 'title' => 'Alleppey', 'description' => 'Scenic backwater houseboat cruise', 'image' => null, 'sort_order' => 2, 'status' => 'active'],
            ['type' => TourFeature::TYPE_PLACE_COVERED, 'title' => 'Thekkady', 'description' => 'Periyar wildlife & spice gardens', 'image' => null, 'sort_order' => 3, 'status' => 'active'],
            ['type' => TourFeature::TYPE_PLACE_COVERED, 'title' => 'Kochi Fort', 'description' => 'Colonial heritage & Chinese fishing nets', 'image' => null, 'sort_order' => 4, 'status' => 'active'],
        ]);

        // 3. Jammu Kashmir & Srinagar
        $jk = Tour::updateOrCreate(
            ['slug' => 'jammu-kashmir-srinagar'],
            [
                'tour_type_id' => $domesticType->id,
                'title' => 'Jammu Kashmir & Srinagar',
                'country' => 'India',
                'state' => 'Jammu & Kashmir',
                'duration' => '3 NIGHTS / 4 DAYS',
                'thumbnail' => 'tours/kashmir.jpg',
                'areas' => ['Tulip Garden', 'Ropeway', 'River Rafting', 'Gulmarg'],
                'features' => ['Tulip Garden', 'Ropeway', 'River Rafting', 'Gulmarg'],
                'status' => true,
            ]
        );
        $jk->detail()->updateOrCreate(
            ['tour_id' => $jk->id],
            [
                'heading' => 'About This Tour',
                'description' => 'Discover paradise on earth with snow-capped Himalayan peaks, Dal Lake shikara rides, and vibrant tulip meadows.',
                'status' => 'active',
            ]
        );
        $jk->features()->delete();
        $jk->features()->createMany([
            ['type' => TourFeature::TYPE_PACKAGE_INCLUSION, 'title' => '4 Star Accommodation', 'description' => 'Houseboat and luxury stay', 'sort_order' => 1, 'status' => 'active'],
            ['type' => TourFeature::TYPE_PACKAGE_INCLUSION, 'title' => 'Daily Meal', 'description' => 'Breakfast & dinner included', 'sort_order' => 2, 'status' => 'active'],
            ['type' => TourFeature::TYPE_PACKAGE_INCLUSION, 'title' => 'All Sightseeing', 'description' => 'Sightseeing transfers included', 'sort_order' => 3, 'status' => 'active'],
            ['type' => TourFeature::TYPE_PLACE_COVERED, 'title' => 'Tulip Garden', 'description' => 'Asia’s largest tulip sanctuary', 'image' => null, 'sort_order' => 1, 'status' => 'active'],
            ['type' => TourFeature::TYPE_PLACE_COVERED, 'title' => 'Ropeway', 'description' => 'Gulmarg Gondola scenic ride', 'image' => null, 'sort_order' => 2, 'status' => 'active'],
            ['type' => TourFeature::TYPE_PLACE_COVERED, 'title' => 'River Rafting', 'description' => 'White water rafting in Pahalgam', 'image' => null, 'sort_order' => 3, 'status' => 'active'],
            ['type' => TourFeature::TYPE_PLACE_COVERED, 'title' => 'Gulmarg', 'description' => 'Meadow of flowers & snow activities', 'image' => null, 'sort_order' => 4, 'status' => 'active'],
        ]);

        // 4. Goa
        $goa = Tour::updateOrCreate(
            ['slug' => 'goa'],
            [
                'tour_type_id' => $domesticType->id,
                'title' => 'Goa',
                'country' => 'India',
                'state' => 'Goa',
                'duration' => '3 NIGHTS / 4 DAYS',
                'thumbnail' => 'tours/goa.jpg',
                'areas' => ['Anjuna Beach', 'Baga Beach', 'Old Goa Church', 'Fort Aguada', 'Night Life'],
                'features' => ['Anjuna Beach', 'Baga Beach', 'Old Goa Church', 'Fort Aguada', 'Night Life'],
                'status' => true,
            ]
        );
        $goa->detail()->updateOrCreate(
            ['tour_id' => $goa->id],
            [
                'heading' => 'About This Tour',
                'description' => 'Golden sand beaches, vibrant water sports, historic Portuguese churches, and relaxed coastal nightlife.',
                'status' => 'active',
            ]
        );
        $goa->features()->delete();
        $goa->features()->createMany([
            ['type' => TourFeature::TYPE_PACKAGE_INCLUSION, 'title' => 'Resort Stay', 'description' => 'Beachside 4 star resort', 'sort_order' => 1, 'status' => 'active'],
            ['type' => TourFeature::TYPE_PACKAGE_INCLUSION, 'title' => 'Daily Meal', 'description' => 'Buffet breakfast included', 'sort_order' => 2, 'status' => 'active'],
            ['type' => TourFeature::TYPE_PLACE_COVERED, 'title' => 'Anjuna Beach', 'description' => 'Famous flea market & sunsets', 'image' => null, 'sort_order' => 1, 'status' => 'active'],
            ['type' => TourFeature::TYPE_PLACE_COVERED, 'title' => 'Baga Beach', 'description' => 'Water sports and beach shacks', 'image' => null, 'sort_order' => 2, 'status' => 'active'],
            ['type' => TourFeature::TYPE_PLACE_COVERED, 'title' => 'Old Goa Church', 'description' => 'Basilica of Bom Jesus heritage', 'image' => null, 'sort_order' => 3, 'status' => 'active'],
            ['type' => TourFeature::TYPE_PLACE_COVERED, 'title' => 'Fort Aguada', 'description' => '17th-century lighthouse fort', 'image' => null, 'sort_order' => 4, 'status' => 'active'],
        ]);
    }
}
