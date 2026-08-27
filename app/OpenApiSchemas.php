<?php

namespace App;

use OpenApi\Attributes as OA;

class OpenApiSchemas
{
    /*
    |--------------------------------------------------------------------------
    | Reusable Input & Response Schemas
    |--------------------------------------------------------------------------
    */

    #[OA\Schema(
        schema: 'EnquiryInput',
        type: 'object',
        required: ['name', 'email', 'phone', 'travel_date', 'destination', 'travelers', 'tour_type'],
        properties: [
            new OA\Property(property: 'name', type: 'string', example: 'Hussaini'),
            new OA\Property(property: 'email', type: 'string', format: 'email', example: 'hussaini@example.com'),
            new OA\Property(property: 'phone', type: 'string', example: '9908117712'),
            new OA\Property(property: 'travel_date', type: 'string', format: 'date', example: '2026-08-15'),
            new OA\Property(property: 'destination', type: 'string', example: 'Dubai'),
            new OA\Property(property: 'travelers', type: 'integer', example: 2),
            new OA\Property(property: 'tour_type', type: 'string', example: 'International Tour'),
            new OA\Property(property: 'message', type: 'string', example: 'I need information about the Dubai tour.', nullable: true),
        ]
    )]
    public static function enquiryInputSchema() {}

    #[OA\Schema(
        schema: 'Enquiry',
        type: 'object',
        properties: [
            new OA\Property(property: 'id', type: 'integer', example: 1),
            new OA\Property(property: 'name', type: 'string', example: 'Hussaini'),
            new OA\Property(property: 'email', type: 'string', example: 'hussaini@example.com'),
            new OA\Property(property: 'phone', type: 'string', example: '9908117712'),
            new OA\Property(property: 'travel_date', type: 'string', example: '2026-08-15'),
            new OA\Property(property: 'destination', type: 'string', example: 'Dubai'),
            new OA\Property(property: 'travelers', type: 'integer', example: 2),
            new OA\Property(property: 'tour_type', type: 'string', example: 'International Tour'),
            new OA\Property(property: 'message', type: 'string', example: 'I need information about the Dubai tour.', nullable: true),
            new OA\Property(property: 'status', type: 'string', example: 'new'),
            new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2026-07-27T10:00:00.000000Z'),
            new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2026-07-27T10:00:00.000000Z'),
        ]
    )]
    public static function enquirySchema() {}

    #[OA\Schema(
        schema: 'TourInquiryInput',
        type: 'object',
        required: ['tour_id', 'name', 'phone', 'email', 'travel_date', 'travelers'],
        properties: [
            new OA\Property(property: 'tour_id', type: 'integer', example: 1),
            new OA\Property(property: 'name', type: 'string', example: 'Hussaini'),
            new OA\Property(property: 'phone', type: 'string', example: '9908117712'),
            new OA\Property(property: 'email', type: 'string', format: 'email', example: 'hussaini@example.com'),
            new OA\Property(property: 'travel_date', type: 'string', format: 'date', example: '2026-09-01'),
            new OA\Property(property: 'travelers', type: 'integer', example: 2),
        ]
    )]
    public static function tourInquiryInputSchema() {}

    #[OA\Schema(
        schema: 'Tour',
        type: 'object',
        properties: [
            new OA\Property(property: 'id', type: 'integer', example: 1),
            new OA\Property(property: 'title', type: 'string', example: 'Exotic Dubai & Desert Safari'),
            new OA\Property(property: 'slug', type: 'string', example: 'exotic-dubai-desert-safari'),
            new OA\Property(property: 'tour_type_id', type: 'integer', example: 1),
            new OA\Property(property: 'price', type: 'number', format: 'float', example: 49999.00),
            new OA\Property(property: 'duration', type: 'string', example: '5 Nights / 6 Days'),
            new OA\Property(property: 'description', type: 'string', example: 'Experience luxury and adventure in Dubai.'),
            new OA\Property(property: 'image', type: 'string', example: 'tours/dubai.jpg', nullable: true),
            new OA\Property(property: 'status', type: 'boolean', example: true),
        ]
    )]
    public static function tourSchema() {}

    #[OA\Schema(
        schema: 'Service',
        type: 'object',
        properties: [
            new OA\Property(property: 'id', type: 'integer', example: 1),
            new OA\Property(property: 'title', type: 'string', example: 'Visa Assistance'),
            new OA\Property(property: 'slug', type: 'string', example: 'visa-assistance'),
            new OA\Property(property: 'short_description', type: 'string', example: 'Hassle-free tourist visa processing for all countries.'),
            new OA\Property(property: 'image', type: 'string', example: 'services/visa.jpg', nullable: true),
            new OA\Property(property: 'status', type: 'boolean', example: true),
        ]
    )]
    public static function serviceSchema() {}

    #[OA\Schema(
        schema: 'Blog',
        type: 'object',
        properties: [
            new OA\Property(property: 'id', type: 'integer', example: 1),
            new OA\Property(property: 'title', type: 'string', example: 'Top 10 Places to Visit in Dubai'),
            new OA\Property(property: 'slug', type: 'string', example: 'top-10-places-to-visit-in-dubai'),
            new OA\Property(property: 'content', type: 'string', example: 'Discover the world tallest building, luxury shopping...'),
            new OA\Property(property: 'image', type: 'string', example: 'blogs/dubai-guide.jpg', nullable: true),
            new OA\Property(property: 'category_id', type: 'integer', example: 1),
            new OA\Property(property: 'author_id', type: 'integer', example: 1),
            new OA\Property(property: 'status', type: 'boolean', example: true),
        ]
    )]
    public static function blogSchema() {}

    #[OA\Schema(
        schema: 'Testimonial',
        type: 'object',
        properties: [
            new OA\Property(property: 'id', type: 'integer', example: 1),
            new OA\Property(property: 'platform', type: 'string', example: 'Google'),
            new OA\Property(property: 'customer_name', type: 'string', example: 'Rahul Sharma'),
            new OA\Property(property: 'customer_image', type: 'string', example: 'testimonials/rahul.jpg', nullable: true),
            new OA\Property(property: 'customer_image_url', type: 'string', example: 'http://127.0.0.1:8000/storage/testimonials/rahul.jpg', nullable: true),
            new OA\Property(property: 'location', type: 'string', example: 'Delhi, India', nullable: true),
            new OA\Property(property: 'rating', type: 'integer', example: 5),
            new OA\Property(property: 'review', type: 'string', example: 'Open Sky Holidays planned our honeymoon trip perfectly!'),
            new OA\Property(property: 'reviewed_at', type: 'string', format: 'date-time', example: '2026-07-27T10:00:00.000000Z'),
            new OA\Property(property: 'status', type: 'boolean', example: true),
        ]
    )]
    public static function testimonialSchema() {}

    #[OA\Schema(
        schema: 'Adventure',
        type: 'object',
        properties: [
            new OA\Property(property: 'id', type: 'integer', example: 1),
            new OA\Property(property: 'title', type: 'string', example: 'Desert Safari & Quad Biking'),
            new OA\Property(property: 'description', type: 'string', example: 'Thrilling desert dune bashing and quad biking experience.'),
            new OA\Property(property: 'features', type: 'array', items: new OA\Items(type: 'string', example: 'Dune Bashing')),
            new OA\Property(property: 'video_link', type: 'string', example: 'https://youtube.com/watch?v=example', nullable: true),
            new OA\Property(property: 'image_one', type: 'string', example: 'adventures/desert1.jpg', nullable: true),
            new OA\Property(property: 'image_one_url', type: 'string', example: 'http://127.0.0.1:8000/storage/adventures/desert1.jpg', nullable: true),
            new OA\Property(property: 'image_two', type: 'string', example: 'adventures/desert2.jpg', nullable: true),
            new OA\Property(property: 'image_two_url', type: 'string', example: 'http://127.0.0.1:8000/storage/adventures/desert2.jpg', nullable: true),
            new OA\Property(property: 'status', type: 'string', example: 'active'),
        ]
    )]
    public static function adventureSchema() {}

    #[OA\Schema(
        schema: 'WhyChooseSection',
        type: 'object',
        properties: [
            new OA\Property(property: 'id', type: 'integer', example: 1),
            new OA\Property(property: 'title', type: 'string', example: '24/7 Dedicated Support'),
            new OA\Property(property: 'description', type: 'string', example: 'Our team is available round the clock to assist you.'),
            new OA\Property(property: 'icon', type: 'string', example: 'fa-solid fa-headset', nullable: true),
            new OA\Property(property: 'background_color', type: 'string', example: '#ffffff'),
            new OA\Property(property: 'text_color', type: 'string', example: '#000000'),
            new OA\Property(property: 'sort_order', type: 'integer', example: 1),
            new OA\Property(property: 'status', type: 'boolean', example: true),
        ]
    )]
    public static function whyChooseSectionSchema() {}

    #[OA\Schema(
        schema: 'TravelSupportSection',
        type: 'object',
        properties: [
            new OA\Property(property: 'id', type: 'integer', example: 1),
            new OA\Property(property: 'small_heading', type: 'string', example: 'Travel Assistance'),
            new OA\Property(property: 'heading', type: 'string', example: 'We Care For Your Seamless Experience'),
            new OA\Property(property: 'description', type: 'string', example: 'Complete guidance and hassle-free travel planning.'),
            new OA\Property(property: 'image', type: 'string', example: 'http://127.0.0.1:8000/storage/travel-support/banner.jpg', nullable: true),
            new OA\Property(property: 'features', type: 'array', items: new OA\Items(type: 'string', example: 'Flight Booking')),
            new OA\Property(property: 'status', type: 'boolean', example: true),
        ]
    )]
    public static function travelSupportSectionSchema() {}

    #[OA\Schema(
        schema: 'AboutSection',
        type: 'object',
        properties: [
            new OA\Property(property: 'id', type: 'integer', example: 1),
            new OA\Property(property: 'main_heading', type: 'string', example: 'Crafting Unforgettable Experiences'),
            new OA\Property(property: 'mission_title', type: 'string', example: 'Our Mission'),
            new OA\Property(property: 'focus_title', type: 'string', example: 'Our Focus'),
            new OA\Property(property: 'description', type: 'string', example: 'Open Sky Holidays is a leading travel management company.'),
            new OA\Property(property: 'customer_count', type: 'integer', example: 10000),
            new OA\Property(property: 'status', type: 'boolean', example: true),
        ]
    )]
    public static function aboutSectionSchema() {}

    #[OA\Schema(
        schema: 'OurProcess',
        type: 'object',
        properties: [
            new OA\Property(property: 'id', type: 'integer', example: 1),
            new OA\Property(property: 'small_heading', type: 'string', example: 'How It Works'),
            new OA\Property(property: 'heading', type: 'string', example: '4 Easy Steps To Travel'),
            new OA\Property(property: 'description', type: 'string', example: 'Simple steps to plan and enjoy your holiday.'),
            new OA\Property(property: 'status', type: 'string', example: 'active'),
        ]
    )]
    public static function ourProcessSchema() {}

    #[OA\Schema(
        schema: 'TourType',
        type: 'object',
        properties: [
            new OA\Property(property: 'id', type: 'integer', example: 1),
            new OA\Property(property: 'name', type: 'string', example: 'International Tours'),
            new OA\Property(property: 'slug', type: 'string', example: 'international-tours'),
            new OA\Property(property: 'tours_count', type: 'integer', example: 15, nullable: true),
        ]
    )]
    public static function tourTypeSchema() {}

    #[OA\Schema(
        schema: 'OfferBanner',
        type: 'object',
        properties: [
            new OA\Property(property: 'id', type: 'integer', example: 1),
            new OA\Property(property: 'title', type: 'string', example: 'Summer Special Discount'),
            new OA\Property(property: 'discount_text', type: 'string', example: 'Up to 30% Off'),
            new OA\Property(property: 'subtitle', type: 'string', example: 'Book Dubai holiday packages today'),
            new OA\Property(property: 'image', type: 'string', example: 'offers/summer.jpg', nullable: true),
            new OA\Property(property: 'status', type: 'boolean', example: true),
        ]
    )]
    public static function offerBannerSchema() {}

    #[OA\Schema(
        schema: 'PageBanner',
        type: 'object',
        properties: [
            new OA\Property(property: 'id', type: 'integer', example: 1),
            new OA\Property(property: 'page', type: 'string', example: 'tours-international'),
            new OA\Property(property: 'title', type: 'string', example: 'International Holiday Packages'),
            new OA\Property(property: 'subtitle', type: 'string', example: 'Explore the world with luxury & comfort'),
            new OA\Property(property: 'banner_image', type: 'string', example: 'banners/international.jpg'),
        ]
    )]
    public static function pageBannerSchema() {}

    #[OA\Schema(
        schema: 'Hero',
        type: 'object',
        properties: [
            new OA\Property(property: 'id', type: 'integer', example: 1),
            new OA\Property(property: 'title', type: 'string', example: 'Unforgettable Journeys Await'),
            new OA\Property(property: 'subtitle', type: 'string', example: 'Book your dream vacation today'),
            new OA\Property(property: 'image', type: 'string', example: 'hero/slide1.jpg'),
            new OA\Property(property: 'btn_text', type: 'string', example: 'Explore Packages'),
            new OA\Property(property: 'btn_link', type: 'string', example: '/tours'),
            new OA\Property(property: 'status', type: 'boolean', example: true),
        ]
    )]
    public static function heroSchema() {}

    #[OA\Schema(
        schema: 'ValidationErrorResponse',
        type: 'object',
        properties: [
            new OA\Property(property: 'message', type: 'string', example: 'The given data was invalid.'),
            new OA\Property(
                property: 'errors',
                type: 'object',
                properties: [
                    new OA\Property(
                        property: 'email',
                        type: 'array',
                        items: new OA\Items(type: 'string', example: 'The email field is required.')
                    ),
                ]
            ),
        ]
    )]
    public static function validationErrorSchema() {}

    #[OA\Schema(
        schema: 'AboutOurCoreValue',
        type: 'object',
        properties: [
            new OA\Property(property: 'id', type: 'integer', example: 1),
            new OA\Property(property: 'title', type: 'string', example: 'Customer First'),
            new OA\Property(property: 'description', type: 'string', example: 'We prioritize our customers experience above everything else.'),
            new OA\Property(property: 'icon', type: 'string', example: 'fas fa-heart', nullable: true),
            new OA\Property(property: 'status', type: 'string', example: 'active'),
        ]
    )]
    public static function aboutOurCoreValueSchema() {}

    #[OA\Schema(
        schema: 'AboutWhyChooseUs',
        type: 'object',
        properties: [
            new OA\Property(property: 'id', type: 'integer', example: 1),
            new OA\Property(property: 'subtitle', type: 'string', example: 'Why Choose Open Sky'),
            new OA\Property(property: 'main_heading', type: 'string', example: 'Your Trusted Travel Partner'),
            new OA\Property(property: 'main_description', type: 'string', example: 'We provide seamless travel booking and custom tour packages.'),
            new OA\Property(property: 'image', type: 'string', example: 'about_why_choose_us/photo.jpg', nullable: true),
            new OA\Property(property: 'features_title', type: 'array', items: new OA\Items(type: 'string', example: 'Best Price Guarantee')),
            new OA\Property(property: 'features_description', type: 'array', items: new OA\Items(type: 'string', example: 'No hidden charges on any package')),
            new OA\Property(property: 'status', type: 'string', example: 'active'),
        ]
    )]
    public static function aboutWhyChooseUsSchema() {}

    #[OA\Schema(
        schema: 'CoreValue',
        type: 'object',
        properties: [
            new OA\Property(property: 'id', type: 'integer', example: 1),
            new OA\Property(property: 'title', type: 'string', example: 'Integrity & Trust'),
            new OA\Property(property: 'description', type: 'string', example: 'Transparent pricing and honest travel guidance.'),
            new OA\Property(property: 'icon', type: 'string', example: 'fas fa-shield-alt', nullable: true),
            new OA\Property(property: 'sort_order', type: 'integer', example: 1),
            new OA\Property(property: 'status', type: 'string', example: 'active'),
        ]
    )]
    public static function coreValueSchema() {}

    #[OA\Schema(
        schema: 'Counter',
        type: 'object',
        properties: [
            new OA\Property(property: 'id', type: 'integer', example: 1),
            new OA\Property(property: 'count_number', type: 'string', example: '10K+'),
            new OA\Property(property: 'count_title', type: 'string', example: 'Happy Travelers'),
            new OA\Property(property: 'icon', type: 'string', example: 'fas fa-smile', nullable: true),
            new OA\Property(property: 'status', type: 'boolean', example: true),
        ]
    )]
    public static function counterSchema() {}

    #[OA\Schema(
        schema: 'OurStory',
        type: 'object',
        properties: [
            new OA\Property(property: 'id', type: 'integer', example: 1),
            new OA\Property(property: 'heading', type: 'string', example: 'Our Journey Since 2015'),
            new OA\Property(property: 'description', type: 'string', example: 'Started with a vision to make international travel accessible to everyone.'),
            new OA\Property(property: 'images', type: 'array', items: new OA\Items(type: 'string', example: 'our-stories/story1.jpg')),
            new OA\Property(property: 'features', type: 'array', items: new OA\Items(type: 'string', example: 'Certified Travel Agents')),
            new OA\Property(property: 'status', type: 'boolean', example: true),
        ]
    )]
    public static function ourStorySchema() {}

    #[OA\Schema(
        schema: 'TourDetail',
        type: 'object',
        properties: [
            new OA\Property(property: 'id', type: 'integer', example: 1),
            new OA\Property(property: 'tour_id', type: 'integer', example: 1),
            new OA\Property(property: 'title', type: 'string', example: 'Complete Dubai Desert Safari Itinerary'),
            new OA\Property(property: 'overview', type: 'string', example: 'Detailed overview of the 5-day tour package.'),
            new OA\Property(property: 'itinerary', type: 'object', example: '{"Day 1": "Arrival and Dhow Cruise", "Day 2": "City Tour and Burj Khalifa"}'),
            new OA\Property(property: 'inclusions', type: 'array', items: new OA\Items(type: 'string', example: 'Hotel Stay')),
            new OA\Property(property: 'exclusions', type: 'array', items: new OA\Items(type: 'string', example: 'Personal Expenses')),
            new OA\Property(property: 'gallery', type: 'array', items: new OA\Items(type: 'string', example: 'tour-details/gallery/img1.jpg')),
        ]
    )]
    public static function tourDetailSchema() {}

    #[OA\Schema(
        schema: 'TourFeature',
        type: 'object',
        properties: [
            new OA\Property(property: 'id', type: 'integer', example: 1),
            new OA\Property(property: 'tour_id', type: 'integer', example: 1),
            new OA\Property(property: 'title', type: 'string', example: 'Burj Khalifa Top Floor Access'),
            new OA\Property(property: 'type', type: 'string', example: 'highlight'),
            new OA\Property(property: 'icon', type: 'string', example: 'fas fa-building', nullable: true),
            new OA\Property(property: 'image', type: 'string', example: 'tour-features/feature1.jpg', nullable: true),
            new OA\Property(property: 'sort_order', type: 'integer', example: 1),
        ]
    )]
    public static function tourFeatureSchema() {}

    #[OA\Schema(
        schema: 'WhatWeOffer',
        type: 'object',
        properties: [
            new OA\Property(property: 'id', type: 'integer', example: 1),
            new OA\Property(property: 'title', type: 'string', example: 'Customized Holiday Packages'),
            new OA\Property(property: 'subtitle', type: 'string', example: 'Tailored for your dream vacation', nullable: true),
            new OA\Property(property: 'description', type: 'string', example: 'We offer personalized itineraries for individuals, families, and groups.', nullable: true),
            new OA\Property(property: 'image', type: 'string', example: 'what-we-offers/offer1.jpg', nullable: true),
            new OA\Property(property: 'image_url', type: 'string', example: 'http://127.0.0.1:8000/storage/what-we-offers/offer1.jpg', nullable: true),
            new OA\Property(property: 'status', type: 'string', example: 'active'),
        ]
    )]
    public static function whatWeOfferSchema() {}

    #[OA\Schema(
        schema: 'ContactSectionInput',
        type: 'object',
        properties: [
            new OA\Property(property: 'phone', type: 'string', example: '+91 99081 17712', nullable: true),
            new OA\Property(property: 'email', type: 'string', example: 'info@openskyholidays.com', nullable: true),
            new OA\Property(property: 'address', type: 'string', example: '#1-11-110, Shyamlal Building, Begumpet, Hyderabad - 500018', nullable: true),
            new OA\Property(property: 'map_link', type: 'string', example: 'https://www.google.com/maps/search/?api=1&query=Shyamlal+Building+Begumpet+Hyderabad+500018', nullable: true),
            new OA\Property(property: 'whatsapp_number', type: 'string', example: '+91 99081 17712', nullable: true),
            new OA\Property(property: 'map_embed_url', type: 'string', example: 'https://maps.google.com/maps?q=Begumpet&output=embed', nullable: true),
            new OA\Property(property: 'status', type: 'boolean', example: true),
        ]
    )]
    public static function contactSectionInputSchema() {}

    #[OA\Schema(
        schema: 'ContactSection',
        type: 'object',
        properties: [
            new OA\Property(property: 'id', type: 'integer', example: 1),
            new OA\Property(property: 'phone', type: 'string', example: '+91 99081 17712'),
            new OA\Property(property: 'email', type: 'string', example: 'info@openskyholidays.com'),
            new OA\Property(property: 'address', type: 'string', example: '#1-11-110, Shyamlal Building, Begumpet, Hyderabad - 500018'),
            new OA\Property(property: 'map_link', type: 'string', example: 'https://www.google.com/maps/search/?api=1&query=Shyamlal+Building+Begumpet+Hyderabad+500018'),
            new OA\Property(property: 'whatsapp_number', type: 'string', example: '+91 99081 17712'),
            new OA\Property(property: 'map_embed_url', type: 'string', example: 'https://maps.google.com/maps?q=Begumpet&output=embed', nullable: true),
            new OA\Property(property: 'status', type: 'boolean', example: true),
            new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2026-08-20T11:00:00.000000Z'),
            new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2026-08-20T11:00:00.000000Z'),
        ]
    )]
    public static function contactSectionSchema() {}

    #[OA\Schema(
        schema: 'TopHeaderInput',
        type: 'object',
        properties: [
            new OA\Property(property: 'email', type: 'string', example: 'info@openskyholidays.com', nullable: true),
            new OA\Property(property: 'tagline', type: 'string', example: 'The World Is Waiting. One Stop Destination For All Your Tours & Travels Needs.', nullable: true),
            new OA\Property(property: 'button_text', type: 'string', example: 'Book Your Tour', nullable: true),
            new OA\Property(property: 'button_url', type: 'string', example: '/tours', nullable: true),
            new OA\Property(
                property: 'social_links',
                type: 'array',
                items: new OA\Items(
                    properties: [
                        new OA\Property(property: 'platform', type: 'string', example: 'facebook'),
                        new OA\Property(property: 'icon', type: 'string', example: 'fa-brands fa-facebook-f'),
                        new OA\Property(property: 'url', type: 'string', example: 'https://facebook.com/openskyholidays'),
                    ]
                ),
                nullable: true
            ),
            new OA\Property(property: 'status', type: 'boolean', example: true),
        ]
    )]
    public static function topHeaderInputSchema() {}

    #[OA\Schema(
        schema: 'TopHeader',
        type: 'object',
        properties: [
            new OA\Property(property: 'id', type: 'integer', example: 1),
            new OA\Property(property: 'email', type: 'string', example: 'info@openskyholidays.com'),
            new OA\Property(property: 'tagline', type: 'string', example: 'The World Is Waiting. One Stop Destination For All Your Tours & Travels Needs.'),
            new OA\Property(property: 'button_text', type: 'string', example: 'Book Your Tour'),
            new OA\Property(property: 'button_url', type: 'string', example: '/tours'),
            new OA\Property(
                property: 'social_links',
                type: 'array',
                items: new OA\Items(
                    properties: [
                        new OA\Property(property: 'platform', type: 'string', example: 'facebook'),
                        new OA\Property(property: 'icon', type: 'string', example: 'fa-brands fa-facebook-f'),
                        new OA\Property(property: 'url', type: 'string', example: 'https://facebook.com/openskyholidays'),
                    ]
                )
            ),
            new OA\Property(property: 'status', type: 'boolean', example: true),
            new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2026-08-27T12:00:00.000000Z'),
            new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2026-08-27T12:00:00.000000Z'),
        ]
    )]
    public static function topHeaderSchema() {}
}


