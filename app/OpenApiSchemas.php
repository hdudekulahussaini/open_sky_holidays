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
            new OA\Property(property: 'tour_type_id', type: 'integer', example: 1),
            new OA\Property(
                property: 'tour_type',
                type: 'object',
                properties: [
                    new OA\Property(property: 'id', type: 'integer', example: 1),
                    new OA\Property(property: 'name', type: 'string', example: 'Domestic Tours'),
                    new OA\Property(property: 'slug', type: 'string', example: 'domestic'),
                ]
            ),
            new OA\Property(property: 'title', type: 'string', example: 'Kerala'),
            new OA\Property(property: 'slug', type: 'string', example: 'kerala'),
            new OA\Property(property: 'country', type: 'string', example: 'INDIA'),
            new OA\Property(property: 'state', type: 'string', example: 'Kerala', nullable: true),
            new OA\Property(property: 'duration', type: 'string', example: '4 Nights / 5 Days'),
            new OA\Property(property: 'thumbnail', type: 'string', example: 'tours/kerala.jpg'),
            new OA\Property(property: 'thumbnail_url', type: 'string', example: 'http://127.0.0.1:8000/storage/tours/kerala.jpg'),
            new OA\Property(
                property: 'areas',
                type: 'array',
                items: new OA\Items(type: 'string'),
                example: ['Munnar', 'Alleppey', 'Thekkady', 'Kochi Fort']
            ),
            new OA\Property(
                property: 'features',
                type: 'array',
                items: new OA\Items(type: 'string'),
                example: ['Munnar', 'Alleppey', 'Thekkady', 'Kochi Fort']
            ),
            new OA\Property(
                property: 'highlights',
                type: 'array',
                items: new OA\Items(type: 'string'),
                example: ['Munnar', 'Alleppey', 'Thekkady', 'Kochi Fort']
            ),
            new OA\Property(
                property: 'package_inclusions',
                type: 'array',
                items: new OA\Items(ref: '#/components/schemas/TourFeature')
            ),
            new OA\Property(
                property: 'places_covered',
                type: 'array',
                items: new OA\Items(ref: '#/components/schemas/TourFeature')
            ),
            new OA\Property(
                property: 'detail',
                type: 'object',
                properties: [
                    new OA\Property(property: 'heading', type: 'string', example: 'About This Tour'),
                    new OA\Property(property: 'description', type: 'string', example: 'Experience the tranquil backwaters...'),
                    new OA\Property(property: 'status', type: 'string', example: 'active'),
                ]
            ),
            new OA\Property(property: 'status', type: 'boolean', example: true),
        ]
    )]
    public static function tourSchema() {}

    #[OA\Schema(
        schema: 'Service',
        type: 'object',
        properties: [
            new OA\Property(property: 'id', type: 'integer', example: 1),
            new OA\Property(property: 'title', type: 'string', example: 'Visa Assistance Services'),
            new OA\Property(property: 'slug', type: 'string', example: 'visa-assistance-services'),
            new OA\Property(property: 'about_title', type: 'string', example: 'Your Gateway to Seamless Global Travel', nullable: true),
            new OA\Property(property: 'about_description', type: 'string', example: 'Navigating international visa requirements can be overwhelming.', nullable: true),
            new OA\Property(property: 'about_image_url', type: 'string', example: 'http://127.0.0.1:8000/storage/services/about/visa.jpg', nullable: true),
            new OA\Property(
                property: 'features',
                type: 'array',
                items: new OA\Items(
                    properties: [
                        new OA\Property(property: 'icon', type: 'string', example: 'fa-solid fa-clipboard-list'),
                        new OA\Property(property: 'title', type: 'string', example: 'Best Fares'),
                        new OA\Property(property: 'description', type: 'string', example: 'Competitive pricing on all routes'),
                    ]
                )
            ),
            new OA\Property(property: 'service_items', type: 'array', items: new OA\Items(type: 'string')),
            new OA\Property(
                property: 'process_steps',
                type: 'array',
                items: new OA\Items(
                    properties: [
                        new OA\Property(property: 'icon', type: 'string', example: '01'),
                        new OA\Property(property: 'title', type: 'string', example: 'Document Review'),
                        new OA\Property(property: 'description', type: 'string', example: 'We verify your documents'),
                    ]
                )
            ),
            new OA\Property(property: 'documents', type: 'array', items: new OA\Items(type: 'string')),
            new OA\Property(property: 'why_choose_items', type: 'array', items: new OA\Items(type: 'string')),
            new OA\Property(property: 'cta_title', type: 'string', example: 'Ready To Start Your Journey?', nullable: true),
            new OA\Property(property: 'cta_description', type: 'string', example: 'Let us take care of your visa process while you focus on making unforgettable memories.', nullable: true),
            new OA\Property(property: 'cta_background_image_url', type: 'string', example: 'http://127.0.0.1:8000/storage/services/cta/banner.jpg', nullable: true),
            new OA\Property(
                property: 'stats',
                type: 'array',
                items: new OA\Items(
                    properties: [
                        new OA\Property(property: 'number', type: 'string', example: '10,000+'),
                        new OA\Property(property: 'label', type: 'string', example: 'Visas Processed'),
                    ]
                )
            ),
            new OA\Property(property: 'status', type: 'boolean', example: true),
        ]
    )]
    public static function serviceSchema() {}

    #[OA\Schema(
        schema: 'Blog',
        type: 'object',
        properties: [
            new OA\Property(property: 'id', type: 'integer', example: 1),
            new OA\Property(property: 'title', type: 'string', example: 'Top 10 Must-Visit Destinations in India in 2026'),
            new OA\Property(property: 'slug', type: 'string', example: 'top-10-must-visit-destinations-in-india-in-2026'),
            new OA\Property(property: 'description', type: 'string', example: 'Explore the most breathtaking destinations across India with travel tips and budget guides.', nullable: true),
            new OA\Property(property: 'short_description', type: 'string', example: 'Explore the most breathtaking destinations across India with travel tips and budget guides.'),
            new OA\Property(
                property: 'category',
                type: 'object',
                properties: [
                    new OA\Property(property: 'id', type: 'integer', example: 1),
                    new OA\Property(property: 'name', type: 'string', example: 'Destinations'),
                    new OA\Property(property: 'slug', type: 'string', example: 'destinations'),
                ]
            ),
            new OA\Property(
                property: 'author',
                type: 'object',
                properties: [
                    new OA\Property(property: 'id', type: 'integer', example: 1),
                    new OA\Property(property: 'name', type: 'string', example: 'Open Sky Team'),
                    new OA\Property(property: 'image', type: 'string', example: 'http://127.0.0.1:8000/storage/authors/team.jpg', nullable: true),
                    new OA\Property(property: 'description', type: 'string', example: 'Travel enthusiast sharing guides and tips.', nullable: true),
                    new OA\Property(property: 'twitter_url', type: 'string', nullable: true),
                    new OA\Property(property: 'facebook_url', type: 'string', nullable: true),
                    new OA\Property(property: 'linkedin_url', type: 'string', nullable: true),
                    new OA\Property(
                        property: 'social_links',
                        type: 'array',
                        items: new OA\Items(
                            properties: [
                                new OA\Property(property: 'platform', type: 'string', example: 'Instagram'),
                                new OA\Property(property: 'icon', type: 'string', example: 'fa-brands fa-instagram'),
                                new OA\Property(property: 'url', type: 'string', example: 'https://instagram.com/opensky'),
                            ]
                        )
                    ),
                ]
            ),
            new OA\Property(
                property: 'table_of_contents',
                type: 'array',
                items: new OA\Items(
                    properties: [
                        new OA\Property(property: 'number', type: 'string', example: '01'),
                        new OA\Property(property: 'title', type: 'string', example: 'The Backwaters of Kerala'),
                    ]
                )
            ),
            new OA\Property(property: 'content', type: 'string', example: '1. Book Your Flights in Advance...'),
            new OA\Property(property: 'featured_image', type: 'string', example: 'http://127.0.0.1:8000/storage/blogs/featured-images/taj.jpg', nullable: true),
            new OA\Property(property: 'read_time', type: 'integer', example: 3),
            new OA\Property(property: 'read_time_text', type: 'string', example: '3 min read'),
            new OA\Property(property: 'published_at', type: 'string', format: 'date-time', example: '2026-08-31T10:00:00.000000Z'),
            new OA\Property(property: 'published_date', type: 'string', example: 'August 31, 2026'),
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
            new OA\Property(property: 'title', type: 'string', example: 'Worldwide Coverage'),
            new OA\Property(property: 'description', type: 'string', example: 'Explore domestic and international destinations with complete planning and trusted travel support.'),
            new OA\Property(property: 'icon', type: 'string', example: 'fa-solid fa-earth-americas', nullable: true),
            new OA\Property(property: 'sort_order', type: 'integer', example: 0),
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
            new OA\Property(property: 'main_heading', type: 'string', example: 'We Are Open Sky Holidays, The Best Travel Agency Company'),
            new OA\Property(property: 'mission_title', type: 'string', example: 'Mission & Vision'),
            new OA\Property(property: 'mission_icon', type: 'string', example: 'fa-solid fa-bullseye'),
            new OA\Property(property: 'focus_title', type: 'string', example: 'Focus On Customer'),
            new OA\Property(property: 'focus_icon', type: 'string', example: 'fa-solid fa-crosshairs'),
            new OA\Property(property: 'description', type: 'string', example: '<p>Explore the world with our curated travel packages.</p>'),
            new OA\Property(property: 'customer_count', type: 'integer', example: 10200),
            new OA\Property(property: 'destinations_subtitle', type: 'string', example: 'Click any country to view tours'),
            new OA\Property(property: 'status', type: 'boolean', example: true),
            new OA\Property(
                property: 'globe_locations',
                type: 'array',
                items: new OA\Items(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'location_name', type: 'string', example: 'India'),
                    ]
                )
            ),
            new OA\Property(
                property: 'customer_avatars',
                type: 'array',
                items: new OA\Items(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer', example: 1),
                        new OA\Property(property: 'image', type: 'string', example: 'about/customer-avatars/avatar1.jpg'),
                        new OA\Property(property: 'image_url', type: 'string', example: 'http://127.0.0.1:8000/storage/about/customer-avatars/avatar1.jpg'),
                    ]
                )
            ),
            new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2026-08-31T10:00:00.000000Z'),
            new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2026-08-31T10:00:00.000000Z'),
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
        schema: 'CounterInput',
        type: 'object',
        required: ['value', 'name'],
        properties: [
            new OA\Property(property: 'value', type: 'string', example: '25+'),
            new OA\Property(property: 'name', type: 'string', example: 'Years Of Experience'),
            new OA\Property(property: 'icon', type: 'string', example: 'fa-solid fa-trophy', nullable: true),
            new OA\Property(property: 'status', type: 'boolean', example: true),
        ]
    )]
    public static function counterInputSchema() {}

    #[OA\Schema(
        schema: 'Counter',
        type: 'object',
        properties: [
            new OA\Property(property: 'id', type: 'integer', example: 1),
            new OA\Property(property: 'value', type: 'string', example: '25+'),
            new OA\Property(property: 'name', type: 'string', example: 'Years Of Experience'),
            new OA\Property(property: 'icon', type: 'string', example: 'fa-solid fa-trophy'),
            new OA\Property(property: 'status', type: 'boolean', example: true),
            new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2026-08-31T10:00:00.000000Z'),
            new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2026-08-31T10:00:00.000000Z'),
        ]
    )]
    public static function counterSchema() {}

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
            new OA\Property(property: 'title', type: 'string', example: 'Integrity'),
            new OA\Property(property: 'icon', type: 'string', example: 'fa-solid fa-handshake', nullable: true),
            new OA\Property(property: 'description', type: 'string', example: 'We operate with complete honesty — no hidden fees, no misleading itineraries, just clear and ethical service.'),
        ]
    )]
    public static function aboutOurCoreValueSchema() {}

    #[OA\Schema(
        schema: 'AboutWhyChooseUs',
        type: 'object',
        properties: [
            new OA\Property(property: 'id', type: 'integer', example: 1),
            new OA\Property(property: 'subtitle', type: 'string', example: 'Why Choose Us'),
            new OA\Property(property: 'title', type: 'string', example: 'Setting Standard for Trust and Comfort.'),
            new OA\Property(property: 'description', type: 'string', example: 'We believe that traveling shouldn\'t be stressful. We ensure every segment of your journey is organized with precise dedication.'),
            new OA\Property(property: 'image', type: 'string', example: 'about_why_choose_us/photo.jpg', nullable: true),
            new OA\Property(property: 'image_url', type: 'string', example: 'https://openskyholidays.com/storage/about_why_choose_us/photo.jpg', nullable: true),
            new OA\Property(property: 'features_icon', type: 'array', items: new OA\Items(type: 'string', example: 'fa-solid fa-headset')),
            new OA\Property(property: 'features_title', type: 'array', items: new OA\Items(type: 'string', example: '24/7 Expert Support')),
            new OA\Property(property: 'features_description', type: 'array', items: new OA\Items(type: 'string', example: 'Our travel assistants are always available to help you navigate queries or itinerary shifts.')),
            new OA\Property(property: 'badge_title', type: 'string', example: 'Trusted by 15,000+'),
            new OA\Property(property: 'badge_subtitle', type: 'string', example: 'Happy travelers worldwide'),
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
            new OA\Property(property: 'title', type: 'string', example: 'Deluxe Hotel Stay'),
            new OA\Property(property: 'type', type: 'string', example: 'package_inclusion'),
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
