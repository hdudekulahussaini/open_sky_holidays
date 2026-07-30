<?php

namespace App;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'Open Sky Holidays API',
    description: 'API documentation for Open Sky Holidays'
)]
#[OA\Server(
    url: 'http://127.0.0.1:8000',
    description: 'Local Development Server'
)]
#[OA\Tag(name: 'Enquiries', description: 'General customer contact and travel enquiries')]
#[OA\Tag(name: 'Tours', description: 'Tour packages and destinations')]
#[OA\Tag(name: 'Tour Inquiries', description: 'Specific tour booking and pricing inquiries')]
#[OA\Tag(name: 'Tour Details', description: 'Tour itineraries and detailed information')]
#[OA\Tag(name: 'Tour Features', description: 'Tour highlights and features')]
#[OA\Tag(name: 'Tour Types', description: 'Categories and types of tours')]
#[OA\Tag(name: 'Services', description: 'Travel, visa, flight, and passport services')]
#[OA\Tag(name: 'Blogs', description: 'Travel blogs, articles, and news')]
#[OA\Tag(name: 'Testimonials', description: 'Customer reviews and ratings')]
#[OA\Tag(name: 'Page Banners', description: 'Header page banner images')]
#[OA\Tag(name: 'Hero Section', description: 'Main hero slides for homepage')]
#[OA\Tag(name: 'About Section', description: 'About company section details')]
#[OA\Tag(name: 'Travel Support', description: 'Travel assistance and support sections')]
#[OA\Tag(name: 'Why Choose Us', description: 'Why choose Open Sky Holidays sections')]
#[OA\Tag(name: 'Adventures', description: 'Adventure activities and categories')]
#[OA\Tag(name: 'Offer Banners', description: 'Promotional offer banners')]
#[OA\Tag(name: 'About Core Values', description: 'About section core values')]
#[OA\Tag(name: 'About Why Choose Us', description: 'About section why choose us features')]
#[OA\Tag(name: 'Core Values', description: 'Company core values')]
#[OA\Tag(name: 'Counters', description: 'Homepage statistic counters')]
#[OA\Tag(name: 'Our Story', description: 'Company history and story')]
class OpenApiDocumentation
{
}
