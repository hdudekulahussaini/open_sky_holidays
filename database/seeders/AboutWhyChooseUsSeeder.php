<?php

namespace Database\Seeders;

use App\Models\AboutWhyChooseUs;
use Illuminate\Database\Seeder;

class AboutWhyChooseUsSeeder extends Seeder
{
    public function run(): void
    {
        AboutWhyChooseUs::updateOrCreate(
            ['id' => 1],
            [
                'subtitle' => 'Why Choose Us',
                'title' => 'Setting Standard for Trust and Comfort.',
                'description' => "We believe that traveling shouldn't be stressful. We ensure every segment of your journey—from flights to accommodation and ground transportation—is organized with precise dedication.",
                'image' => 'about_why_choose_us/about_why_choose_us.jpg',
                'features_icon' => [
                    'fa-solid fa-headset',
                    'fa-solid fa-hand-holding-dollar',
                    'fa-solid fa-location-dot',
                    'fa-solid fa-hotel',
                ],
                'features_title' => [
                    '24/7 Expert Support',
                    'Completely Transparent Pricing',
                    'Unmatched Local Expertise',
                    'Handpicked Accommodations',
                ],
                'features_description' => [
                    'Our travel assistants are always available to help you navigate queries or itinerary shifts, anytime, anywhere.',
                    'No hidden charges or unexpected surprise fees. We outline every invoice line item so you can choose exactly what fits your budget.',
                    'We work directly with local, vetted destination representatives and drivers to offer safer excursions and authentic details.',
                    'Every hotel and resort in our network is verified for quality, safety, and comfort to guarantee your peace of mind.',
                ],
                'badge_title' => 'Trusted by 15,000+',
                'badge_subtitle' => 'Happy travelers worldwide',
                'status' => 'active',
            ]
        );
    }
}
