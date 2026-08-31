<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */
        $destinationsCategory = Category::firstOrCreate(
            ['slug' => 'destinations'],
            ['name' => 'Destinations']
        );

        $travelTipsCategory = Category::firstOrCreate(
            ['slug' => 'travel-tips'],
            ['name' => 'Travel Tips']
        );

        $honeymoonCategory = Category::firstOrCreate(
            ['slug' => 'honeymoon'],
            ['name' => 'Honeymoon']
        );

        $adventureCategory = Category::firstOrCreate(
            ['slug' => 'adventure'],
            ['name' => 'Adventure']
        );

        $foodCategory = Category::firstOrCreate(
            ['slug' => 'food-culture'],
            ['name' => 'Food & Culture']
        );

        $wildlifeCategory = Category::firstOrCreate(
            ['slug' => 'wildlife-nature'],
            ['name' => 'Wildlife & Nature']
        );

        /*
        |--------------------------------------------------------------------------
        | Author
        |--------------------------------------------------------------------------
        */
        $author = Author::firstOrCreate(
            ['name' => 'Open Sky Team'],
            [
                'image' => null,
                'description' => 'Travel enthusiasts sharing honest guides, travel tips, and destination stories to inspire your next adventure.',
                'twitter_url' => 'https://twitter.com/openskyholidays',
                'facebook_url' => 'https://facebook.com/openskyholidays',
                'linkedin_url' => 'https://linkedin.com/company/openskyholidays',
                'status' => true,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 1. Top 10 Must-Visit Destinations in India in 2026 (blogs/1)
        |--------------------------------------------------------------------------
        */
        $mainBlogContent = <<<'HTML'
From the backwaters of Kerala to the snow-capped peaks of Kashmir, explore the most breathtaking destinations India has to offer this year. India is a land of diverse cultures, breathtaking landscapes, and timeless heritage. From the snow-capped peaks of the Himalayas to the serene backwaters of Kerala, the vibrant streets of Rajasthan to the tropical beaches of Goa, the country offers unforgettable experiences for every traveler. Here are the top destinations that should be on your next bucket list.

1. The Backwaters of Kerala
Kerala, often referred to as "God's Own Country," offers a serene escape. Cruising through the tranquil backwaters of Alleppey in a traditional houseboat is an experience you simply cannot miss in 2026. Enjoy the lush greenery, spot local wildlife, and indulge in authentic South Indian coastal cuisine.

2. Snow-Capped Peaks of Kashmir
Kashmir remains a paradise on earth. The majestic valleys of Gulmarg and Pahalgam provide the perfect backdrop for romantic getaways and thrilling ski adventures. Improved accessibility and luxury stays make reaching these pristine locations easier than ever.

3. The Royal Heritage of Rajasthan
Step back in time by visiting the magnificent forts and palaces of Jaipur, Udaipur, and Jodhpur. Experience the vibrant culture, rich history, and the warm hospitality of the desert state.

4. The Spiritual Aura of Varanasi
Witnessing the Ganga Aarti at dusk in Varanasi is a spiritually uplifting experience. The ancient city's narrow winding lanes, historic ghats, and profound traditions make it an essential stop for cultural explorers.

5. Goa — The Beach Paradise
Beyond its famous nightlife, Goa boasts tranquil secret beaches, Portuguese colonial architecture, and vibrant spice plantations perfect for relaxation and water adventures.

6. Himachal Pradesh — The Mountain Retreat
From the colonial charm of Shimla to the adventurous slopes of Manali and peaceful retreats of Dharamshala, Himachal offers refreshing mountain air and stunning vistas.

7. Ladakh — The Land of High Passes
Marvel at the dramatic landscapes of Pangong Lake, Nubra Valley, and high-altitude monasteries. An unforgettable road trip destination for adventure enthusiasts.

8. Uttarakhand — The Spiritual Escape
Known as Devbhumi, Uttarakhand combines spiritual tranquility in Rishikesh and Haridwar with breathtaking trekking in the Valley of Flowers.

9. Andaman & Nicobar — Island Beauty
Pristine white sand beaches, crystal-clear turquoise waters, and world-class scuba diving await you on Havelock and Neil islands.

10. Northeast India — The Hidden Gem
Explore the living root bridges of Meghalaya, the tea gardens of Assam, and the serene monasteries of Sikkim for an off-the-beaten-path adventure.
HTML;

        Blog::updateOrCreate(
            ['slug' => 'top-10-must-visit-destinations-in-india-in-2026'],
            [
                'category_id' => $destinationsCategory->id,
                'author_id' => $author->id,
                'title' => 'Top 10 Must-Visit Destinations in India in 2026',
                'description' => 'From the serene backwaters of Kerala to the majestic snow-capped peaks of Kashmir, explore the top 10 breathtaking destinations in India for 2026.',
                'table_of_contents' => [
                    "Kerala – God's Own Country",
                    'Rajasthan – The Land of Kings',
                    'Goa – The Beach Paradise',
                    'Himachal Pradesh – The Mountain Retreat',
                    'Ladakh – The Land of High Passes',
                    'Uttarakhand – The Spiritual Escape',
                    'Andaman & Nicobar – Island Beauty',
                    'Mumbai – The City of Dreams',
                    'Varanasi – The Spiritual Heart',
                    'Northeast India – The Hidden Gem',
                ],
                'content' => $mainBlogContent,
                'featured_image' => null,
                'read_time' => 3,
                'status' => true,
                'published_at' => Carbon::create(2026, 7, 13, 10, 0, 0),
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 2. How to Plan a Budget-Friendly International Trip
        |--------------------------------------------------------------------------
        */
        Blog::updateOrCreate(
            ['slug' => 'how-to-plan-a-budget-friendly-international-trip'],
            [
                'category_id' => $travelTipsCategory->id,
                'author_id' => $author->id,
                'title' => 'How to Plan a Budget-Friendly International Trip',
                'description' => 'The golden rule for budget international travel is booking your flights early. Monitor prices using flight comparison tools and set up price alerts.',
                'table_of_contents' => [
                    'Book Your Flights in Advance',
                    'Be Flexible With Your Dates and Destinations',
                    'Master the Art of Packing Light',
                    'Embrace Local Street Food and Public Transport',
                ],
                'content' => "1. Book Your Flights in Advance\nThe golden rule for budget international travel is booking your flights early. Monitor prices using flight comparison tools and set up price alerts. Often, booking 3-4 months in advance can save you hundreds of dollars.\n\n2. Be Flexible With Your Dates and Destinations\nIf you can be flexible with your travel dates, you can take advantage of shoulder season pricing. Sometimes flying on a Tuesday instead of a Friday can significantly drop your ticket price.\n\n3. Master the Art of Packing Light\nMany budget airlines charge hefty fees for checked baggage. By packing light and traveling with just a carry-on, you avoid these extra fees and gain mobility.\n\n4. Embrace Local Street Food and Public Transport\nEating where the locals eat is not only cheaper but often far more delicious and authentic than tourist trap restaurants. Similarly, utilizing local buses and trains will drastically reduce your daily expenditures.",
                'featured_image' => null,
                'read_time' => 5,
                'status' => true,
                'published_at' => Carbon::create(2026, 1, 5, 9, 30, 0),
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 3. Best Honeymoon Spots: Maldives vs Bali vs Mauritius
        |--------------------------------------------------------------------------
        */
        Blog::updateOrCreate(
            ['slug' => 'best-honeymoon-spots-maldives-vs-bali-vs-mauritius'],
            [
                'category_id' => $honeymoonCategory->id,
                'author_id' => $author->id,
                'title' => 'Best Honeymoon Spots: Maldives vs Bali vs Mauritius',
                'description' => 'A comprehensive honeymoon comparison guide covering overwater villas, romantic beaches, budgets, and activities for newlyweds.',
                'table_of_contents' => [
                    'Maldives: Ultimate Luxury & Overwater Villas',
                    'Bali: Culture, Beaches & Lush Greenery',
                    'Mauritius: Coral Reefs & Romantic Escapes',
                ],
                'content' => "1. Maldives: Ultimate Luxury & Overwater Villas\nFor couples seeking privacy and luxury, nothing beats waking up in an overwater villa surrounded by crystal-clear turquoise waters.\n\n2. Bali: Culture, Beaches & Lush Greenery\nBali combines vibrant cultural temples, jungle villas in Ubud, and romantic sunset beaches in Seminyak and Uluwatu.\n\n3. Mauritius: Coral Reefs & Romantic Escapes\nMauritius offers stunning nature, luxury beachfront resorts, and underwater waterfalls for adventurous couples.",
                'featured_image' => null,
                'read_time' => 4,
                'status' => true,
                'published_at' => Carbon::create(2026, 6, 28, 14, 0, 0),
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 4. Adventure Travel: Exploring India's Hidden Trails
        |--------------------------------------------------------------------------
        */
        Blog::updateOrCreate(
            ['slug' => 'adventure-travel-exploring-indias-hidden-trails'],
            [
                'category_id' => $adventureCategory->id,
                'author_id' => $author->id,
                'title' => "Adventure Travel: Exploring India's Hidden Trails",
                'description' => 'Discover the most thrilling off-the-beaten-path treks and nature trails across the Western Ghats and the Himalayas.',
                'table_of_contents' => [
                    'The Valley of Flowers Trek in Uttarakhand',
                    'Kudremukh Peak Trek in Karnataka',
                    'Sandakphu: View of the Highest Peaks',
                ],
                'content' => "1. The Valley of Flowers Trek in Uttarakhand\nA UNESCO World Heritage site known for its meadows of endemic alpine flowers and diverse fauna.\n\n2. Kudremukh Peak Trek in Karnataka\nA picturesque trek through rolling green hills, dense shola forests, and mist-covered ridges.\n\n3. Sandakphu: View of the Highest Peaks\nThe highest point in West Bengal offering panoramic views of Everest, Kanchenjunga, and Lhotse.",
                'featured_image' => null,
                'read_time' => 6,
                'status' => true,
                'published_at' => Carbon::create(2026, 6, 20, 11, 15, 0),
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 5. Family-Friendly Guide To Dubai: Top Fun Travelling Spots
        |--------------------------------------------------------------------------
        */
        Blog::updateOrCreate(
            ['slug' => 'family-friendly-guide-to-dubai-top-fun-travelling-spots'],
            [
                'category_id' => $destinationsCategory->id,
                'author_id' => $author->id,
                'title' => 'Family-Friendly Guide To Dubai: Top Fun Travelling Spots',
                'description' => 'A complete family travel guide to Dubai covering theme parks, Desert Safari, Burj Khalifa observation decks, and kid-friendly attractions.',
                'table_of_contents' => [
                    'Burj Khalifa & The Dubai Fountain',
                    'Desert Safari with BBQ & Camel Rides',
                    'Dubai Aquarium & Underwater Zoo',
                    'IMG Worlds of Adventure',
                ],
                'content' => "1. Burj Khalifa & The Dubai Fountain\nTake your family to the 124th floor of the world's tallest building and enjoy the spectacular synchronized water show below.\n\n2. Desert Safari with BBQ & Camel Rides\nAn exhilarating dune-bashing ride followed by cultural performances, Henna painting, and a star-lit Arabian dinner.\n\n3. Dubai Aquarium & Underwater Zoo\nWalk through a 48-meter aquarium tunnel and marvel at thousands of aquatic animals, sharks, and stingrays in Dubai Mall.\n\n4. IMG Worlds of Adventure\nThe world's largest indoor theme park featuring Marvel superheroes and Cartoon Network characters in temperature-controlled comfort.",
                'featured_image' => null,
                'read_time' => 4,
                'status' => true,
                'published_at' => Carbon::create(2026, 6, 15, 12, 0, 0),
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 6. Culinary Journey: Top Street Foods You Must Try in Southeast Asia
        |--------------------------------------------------------------------------
        */
        Blog::updateOrCreate(
            ['slug' => 'culinary-journey-top-street-foods-you-must-try-in-southeast-asia'],
            [
                'category_id' => $foodCategory->id,
                'author_id' => $author->id,
                'title' => 'Culinary Journey: Top Street Foods You Must Try in Southeast Asia',
                'description' => 'From authentic Pad Thai in Bangkok to savory Pho in Hanoi, experience the richest flavors and street food cultures across Southeast Asia.',
                'table_of_contents' => [
                    'Pad Thai & Mango Sticky Rice in Bangkok',
                    'Pho & Banh Mi in Hanoi',
                    'Nasi Lemak & Char Kway Teow in Penang',
                ],
                'content' => "1. Pad Thai & Mango Sticky Rice in Bangkok\nSavor wok-tossed rice noodles with tamarind, fresh shrimp, crushed peanuts, followed by sweet mango and coconut-infused sticky rice.\n\n2. Pho & Banh Mi in Hanoi\nA fragrant beef broth with rice noodles and fresh herbs, paired with crispy French baguettes stuffed with savory pâté and pickled veggies.\n\n3. Nasi Lemak & Char Kway Teow in Penang\nMalaysia's food capital serves fragrant coconut rice with sambal and wok-fried flat noodles infused with smokiness.",
                'featured_image' => null,
                'read_time' => 5,
                'status' => true,
                'published_at' => Carbon::create(2026, 6, 10, 10, 30, 0),
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 7. Ultimate Wildlife Safari Guide: Top National Parks in India
        |--------------------------------------------------------------------------
        */
        Blog::updateOrCreate(
            ['slug' => 'ultimate-wildlife-safari-guide-top-national-parks-in-india'],
            [
                'category_id' => $wildlifeCategory->id,
                'author_id' => $author->id,
                'title' => 'Ultimate Wildlife Safari Guide: Top National Parks in India',
                'description' => 'Get up close with Royal Bengal Tigers, one-horned rhinos, and Asiatic lions in India’s most renowned wildlife reserves.',
                'table_of_contents' => [
                    'Jim Corbett National Park, Uttarakhand',
                    'Ranthambore National Park, Rajasthan',
                    'Kaziranga National Park, Assam',
                ],
                'content' => "1. Jim Corbett National Park, Uttarakhand\nIndia's oldest national park known for its dense Sal forests, picturesque river valleys, and elusive tiger sightings.\n\n2. Ranthambore National Park, Rajasthan\nFamous for its historic 10th-century fort ruins and majestic tigers roaming among ancient pavilions.\n\n3. Kaziranga National Park, Assam\nA UNESCO World Heritage site home to two-thirds of the world's great one-horned rhinoceroses.",
                'featured_image' => null,
                'read_time' => 5,
                'status' => true,
                'published_at' => Carbon::create(2026, 6, 5, 8, 0, 0),
            ]
        );
    }
}
