<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'Visa Assistance Services',
                'slug' => 'visa',
                'about_title' => 'Your Gateway to Seamless Global Travel',
                'about_description' => 'Navigating international visa requirements can be overwhelming. Our expert visa assistance team provides comprehensive guidance, application preparation, and appointment booking to ensure a fast, stress-free approval experience.',
                'about_image' => null,
                'features' => [
                    ['icon' => 'fa-solid fa-clipboard-list', 'title' => 'Best Fares', 'description' => 'Competitive visa processing fees with no hidden costs'],
                    ['icon' => 'fa-solid fa-shield-halved', 'title' => 'Global Reach', 'description' => 'Visa assistance across 50+ countries including US, UK, Schengen & Gulf'],
                    ['icon' => 'fa-solid fa-clock', 'title' => 'Instant Booking', 'description' => 'Fast-track document filing and rapid appointment slots'],
                    ['icon' => 'fa-solid fa-user', 'title' => 'Flexible Dates', 'description' => 'Dedicated relationship manager for individual and corporate travelers'],
                    ['icon' => 'fa-solid fa-headset', 'title' => '24/7 Support', 'description' => 'Round-the-clock tracking updates and phone consultation'],
                ],
                'service_items' => [
                    'Tourist & Visitor Visas',
                    'Business & Conference Visas',
                    'Transit Visas & Express Processing',
                    'Visa Interview Preparation & Consultation',
                ],
                'process_steps' => [
                    ['icon' => '01', 'title' => 'Profile Assessment', 'description' => 'We review your travel plans, documents, and visa requirements.'],
                    ['icon' => '02', 'title' => 'Application & Filing', 'description' => 'Our experts prepare accurate forms and compile mandatory paperwork.'],
                    ['icon' => '03', 'title' => 'Embassy Submission', 'description' => 'We book slots and assist with biometric and consulate appointments.'],
                    ['icon' => '04', 'title' => 'Visa Delivery', 'description' => 'Receive your approved visa passport delivered safely.'],
                ],
                'documents' => [
                    'Valid Passport (minimum 6 months validity)',
                    'Passport Size Photographs (white background)',
                    'Confirmed Return Flight & Hotel Itinerary',
                    'Bank Statements & Financial Proof',
                ],
                'why_choose_items' => [
                    '98% High Success & Approval Rate',
                    'Over 10,000+ Visas Processed Successfully',
                    'Certified Travel & Visa Counselors',
                    'Transparent and Upfront Consultation',
                ],
                'cta_title' => 'Ready To Start Your Journey?',
                'cta_description' => 'Let us take care of your visa process while you focus on making unforgettable memories.',
                'cta_background_image' => null,
                'stats' => [
                    ['number' => '10,000+', 'label' => 'Visas Processed'],
                    ['number' => '25+', 'label' => 'Countries Covered'],
                    ['number' => '98%', 'label' => 'Success Rate'],
                ],
                'status' => true,
            ],
            [
                'title' => 'Flight Ticket Booking & Private Charters',
                'slug' => 'flight-ticket-booking',
                'about_title' => 'Exclusive Fares on Domestic & International Flights',
                'about_description' => 'Get the best deals on worldwide airline bookings, group travels, and private air charters with Open Sky Holidays.',
                'about_image' => null,
                'features' => [
                    ['icon' => 'fa-solid fa-plane-departure', 'title' => 'Exclusive Airline Deals', 'description' => 'Special consolidator fares with top airlines'],
                    ['icon' => 'fa-solid fa-wallet', 'title' => 'Zero Hidden Fees', 'description' => 'Transparent breakdown of taxes and fuel charges'],
                    ['icon' => 'fa-solid fa-headset', 'title' => '24/7 Flight Support', 'description' => 'Real-time schedule monitoring and rebooking assistance'],
                ],
                'service_items' => [
                    'Economy & Business Class Tickets',
                    'Group Bookings & Corporate Fares',
                    'Private Jet & Charter Services',
                ],
                'process_steps' => [
                    ['icon' => '01', 'title' => 'Search Itineraries', 'description' => 'Find the best routes and timings for your destination.'],
                    ['icon' => '02', 'title' => 'Reserve & Confirm', 'description' => 'Secure tickets with instant airline confirmation.'],
                ],
                'documents' => [
                    'Passport / Government ID',
                    'Valid Visa for Destination',
                ],
                'why_choose_items' => [
                    'Direct partnerships with 100+ global airlines',
                    'Instant e-ticket generation and seat selection',
                ],
                'cta_title' => 'Ready For Takeoff?',
                'cta_description' => 'Book your dream flight with Open Sky Holidays and enjoy smooth skies all the way.',
                'cta_background_image' => null,
                'stats' => [
                    ['number' => '500+', 'label' => 'Airlines Network'],
                    ['number' => '50,000+', 'label' => 'Tickets Issued'],
                    ['number' => '99.8%', 'label' => 'On-Time Support'],
                ],
                'status' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['slug' => $service['slug']],
                $service
            );
        }
    }
}
