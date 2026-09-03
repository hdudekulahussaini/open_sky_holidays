<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'platform' => 'tripadvisor',
                'customer_name' => 'Kiran Reddy',
                'customer_image' => 'testimonials/isZFp9Pp6Ug2cUDPAfhMZ2FmYNOF2ktZuQxUtCH2.jpg',
                'location' => 'Warangal',
                'rating' => 5,
                'review' => 'Our Goa holiday was affordable and enjoyable. The hotel was close to the beach, and the sightseeing driver was friendly and punctual.',
                'reviewed_at' => Carbon::create(2026, 4, 17, 18, 50, 0),
                'status' => true,
            ],
            [
                'platform' => 'google',
                'customer_name' => 'Meera Nair',
                'customer_image' => 'testimonials/cg8pjR8ioQ1ewZYIdXwcZCnJpMUH0a7fisxRYiE7.jpg',
                'location' => 'Kochi',
                'rating' => 5,
                'review' => 'The passport and visa guidance was clear and helpful. Their team explained every document and kept us updated during the complete process.',
                'reviewed_at' => Carbon::create(2026, 4, 8, 14, 25, 0),
                'status' => true,
            ],
            [
                'platform' => 'tripadvisor',
                'customer_name' => 'Rahul Sharma',
                'customer_image' => 'testimonials/qonM0z1CbJ6v2xR8lVFBKUXwjkvu9me6S7uwJViU.jpg',
                'location' => 'Hyderabad',
                'rating' => 5,
                'review' => 'Our Kerala family tour was planned perfectly. The hotels, transfers and sightseeing arrangements were comfortable, and the team supported us throughout the journey.',
                'reviewed_at' => Carbon::create(2026, 6, 18, 10, 30, 0),
                'status' => true,
            ],
            [
                'platform' => 'facebook',
                'customer_name' => 'Ananya Deshmukh',
                'customer_image' => 'testimonials/Eo0Q4ngWwpDV8bKoYT0YYIvDpCWvOE32EmqubLoO.jpg',
                'location' => 'Mumbai',
                'rating' => 5,
                'review' => 'Booking our Dubai holiday package with Open Sky Holidays was the best decision! Everything from desert safari to Burj Khalifa tickets was flawlessly handled.',
                'reviewed_at' => Carbon::create(2026, 5, 12, 16, 15, 0),
                'status' => true,
            ],
            [
                'platform' => 'google',
                'customer_name' => 'Vikram Malhotra',
                'customer_image' => 'testimonials/cg8pjR8ioQ1ewZYIdXwcZCnJpMUH0a7fisxRYiE7.jpg',
                'location' => 'Bengaluru',
                'rating' => 5,
                'review' => 'Exceptional service! The customized Bali itinerary they prepared for our honeymoon was breathtaking. Highly recommend their holiday packages.',
                'reviewed_at' => Carbon::create(2026, 5, 28, 11, 45, 0),
                'status' => true,
            ],
            [
                'platform' => 'facebook',
                'customer_name' => 'Sneha Patel',
                'customer_image' => 'testimonials/isZFp9Pp6Ug2cUDPAfhMZ2FmYNOF2ktZuQxUtCH2.jpg',
                'location' => 'Ahmedabad',
                'rating' => 5,
                'review' => 'Great flight booking support and quick responses. They found us the best flight fares for our family vacation with zero hassle.',
                'reviewed_at' => Carbon::create(2026, 6, 5, 19, 20, 0),
                'status' => true,
            ],
            [
                'platform' => 'google',
                'customer_name' => 'Rajesh Gupta',
                'customer_image' => 'testimonials/qonM0z1CbJ6v2xR8lVFBKUXwjkvu9me6S7uwJViU.jpg',
                'location' => 'Delhi',
                'rating' => 5,
                'review' => 'Open Sky Holidays made our Europe trip smooth and stress-free. From visa appointments to Eurail passes, their team was always accessible.',
                'reviewed_at' => Carbon::create(2026, 6, 22, 15, 10, 0),
                'status' => true,
            ],
            [
                'platform' => 'tripadvisor',
                'customer_name' => 'Priya Sundaram',
                'customer_image' => 'testimonials/Eo0Q4ngWwpDV8bKoYT0YYIvDpCWvOE32EmqubLoO.jpg',
                'location' => 'Chennai',
                'rating' => 5,
                'review' => 'Superb arrangements for our Singapore and Malaysia tour. Kid-friendly itineraries, great hotels, and great customer care throughout.',
                'reviewed_at' => Carbon::create(2026, 7, 2, 9, 45, 0),
                'status' => true,
            ],
        ];

        foreach ($testimonials as $data) {
            Testimonial::updateOrCreate(
                [
                    'customer_name' => $data['customer_name'],
                    'platform' => $data['platform'],
                ],
                $data
            );
        }
    }
}
