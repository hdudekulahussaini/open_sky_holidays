<?php

use App\Http\Controllers\Api\AboutOurCoreValueController;
use App\Http\Controllers\Api\AboutSectionController;
use App\Http\Controllers\Api\AboutWhyChooseUsController;
use App\Http\Controllers\Api\AdventureCategoryController;
use App\Http\Controllers\Api\AdventureController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\ContactSectionController;
use App\Http\Controllers\Api\CoreValueController;
use App\Http\Controllers\Api\CounterController;
use App\Http\Controllers\Api\EnquiryController;
use App\Http\Controllers\Api\HeroController;
use App\Http\Controllers\Api\OfferBannerController;
use App\Http\Controllers\Api\OurProcessController;
use App\Http\Controllers\Api\OurStoryController;
use App\Http\Controllers\Api\PageBannerController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\TopHeaderController;
use App\Http\Controllers\Api\TourController;
use App\Http\Controllers\Api\TourDetailController;
use App\Http\Controllers\Api\TourFeatureController;
use App\Http\Controllers\Api\TourInquiryController;
use App\Http\Controllers\Api\TourTypeController;
use App\Http\Controllers\Api\TravelSupportSectionController;
use App\Http\Controllers\Api\WhatWeOfferController;
use App\Http\Controllers\Api\WhyChooseSectionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Enquiry & Tour Booking Inquiries (Customer Form Submissions)
|--------------------------------------------------------------------------
*/

Route::post('/enquiries', [
    EnquiryController::class,
    'store',
])->name('api.enquiries.store');

Route::post('/tour-inquiries', [
    TourInquiryController::class,
    'store',
])->name('api.tour-inquiries.store');

/*
|--------------------------------------------------------------------------
| Public Read-Only Content APIs (GET Only)
|--------------------------------------------------------------------------
*/

// Hero Section
Route::apiResource('heroes', HeroController::class)->only(['index', 'show']);

// About Section
Route::get('/about-section/active', [
    AboutSectionController::class,
    'active',
])->name('api.about-section.active');
Route::apiResource('about-sections', AboutSectionController::class)->only(['index', 'show']);

// Travel Support
Route::get('/travel-support/active', [
    TravelSupportSectionController::class,
    'active',
])->name('api.travel-support.active');
Route::apiResource('travel-support', TravelSupportSectionController::class)
    ->parameters(['travel-support' => 'travelSupport'])
    ->only(['index', 'show']);

// Why Choose Section
Route::get('/why-choose-sections/active', [
    WhyChooseSectionController::class,
    'active',
])->name('api.why-choose-sections.active');
Route::apiResource('why-choose-sections', WhyChooseSectionController::class)->only(['index', 'show']);

// Page Banners
Route::get('/page-banners/page/{page}', [
    PageBannerController::class,
    'byPage',
])->name('api.page-banners.by-page');
Route::apiResource('page-banners', PageBannerController::class)->only(['index', 'show']);

// Adventures & Adventure Categories
Route::apiResource('adventure-categories', AdventureCategoryController::class)->only(['index', 'show']);
Route::get('/adventures/category/{slug}', [
    AdventureController::class,
    'byCategorySlug',
])->name('api.adventures.category');
Route::apiResource('adventures', AdventureController::class)->only(['index', 'show']);

// Offer Banners
Route::apiResource('offer-banners', OfferBannerController::class)->only(['index', 'show']);

// Blogs
Route::get('/blogs', [
    BlogController::class,
    'index',
])->name('api.blogs.index');
Route::get('/blogs/{slug}', [
    BlogController::class,
    'show',
])->name('api.blogs.show');

// Our Stories
Route::apiResource('our-stories', OurStoryController::class)->only(['index', 'show']);

// What We Offer
Route::apiResource('what-we-offers', WhatWeOfferController::class)
    ->parameters(['what-we-offers' => 'whatWeOffer'])
    ->only(['index', 'show']);

// About Why Choose Us
Route::get('/about-why-choose-us/active', [
    AboutWhyChooseUsController::class,
    'active',
])->name('api.about-why-choose-us.active');
Route::apiResource('about-why-choose-us', AboutWhyChooseUsController::class)
    ->parameters(['about-why-choose-us' => 'aboutWhyChooseUs'])
    ->only(['index', 'show']);

// About Our Core Values
Route::apiResource('about-our-core-values', AboutOurCoreValueController::class)
    ->parameters(['about-our-core-values' => 'aboutOurCoreValue'])
    ->only(['index', 'show']);

// Testimonials
Route::apiResource('testimonials', TestimonialController::class)->only(['index', 'show']);

// Our Processes
Route::get('our-processes/active', [
    OurProcessController::class,
    'active',
])->name('our-processes.active');
Route::apiResource('our-processes', OurProcessController::class)->only(['index', 'show']);

// Core Values
Route::apiResource('core-values', CoreValueController::class)->only(['index', 'show']);

// Counters
Route::get('/counters/active', [CounterController::class, 'active'])->name('api.counters.active');
Route::apiResource('counters', CounterController::class)->only(['index', 'show']);

// Services
Route::apiResource('services', ServiceController::class)->only(['index', 'show']);

// Tour Types & Tours
Route::apiResource('tour-types', TourTypeController::class)->only(['index', 'show']);
Route::apiResource('tours', TourController::class)->only(['index', 'show']);
Route::apiResource('tour-details', TourDetailController::class)->only(['index', 'show']);
Route::apiResource('tour-features', TourFeatureController::class)->only(['index', 'show']);

// Contact Section
Route::get('/contact-section/active', [
    ContactSectionController::class,
    'active',
])->name('api.contact-section.active');
Route::apiResource('contact-sections', ContactSectionController::class)->only(['index', 'show']);

// Top Header / Topbar
Route::get('/top-header/active', [
    TopHeaderController::class,
    'active',
])->name('api.top-header.active');
Route::apiResource('top-headers', TopHeaderController::class)->only(['index', 'show']);
