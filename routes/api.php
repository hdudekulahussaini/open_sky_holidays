<?php

use App\Http\Controllers\Api\AboutSectionController;
use App\Http\Controllers\Api\AdventureCategoryController;
use App\Http\Controllers\Api\AdventureController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\EnquiryController;
use App\Http\Controllers\Api\HeroController;
use App\Http\Controllers\Api\OfferBannerController;
use App\Http\Controllers\Api\OurStoryController;
use App\Http\Controllers\Api\PageBannerController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\TravelSupportSectionController;
use App\Http\Controllers\Api\WhatWeOfferController;
use App\Http\Controllers\Api\WhyChooseSectionController;
use App\Http\Controllers\Api\AboutWhyChooseUsController;
use App\Http\Controllers\Api\AboutOurCoreValueController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Enquiry
|--------------------------------------------------------------------------
*/

Route::post('/enquiries', [
    EnquiryController::class,
    'store',
])->name('api.enquiries.store');

/*
|--------------------------------------------------------------------------
| Hero
|--------------------------------------------------------------------------
*/

Route::apiResource(
    'heroes',
    HeroController::class
);

/*
|--------------------------------------------------------------------------
| About Section
|--------------------------------------------------------------------------
*/

Route::get('/about-section/active', [
    AboutSectionController::class,
    'active',
])->name('api.about-section.active');

Route::apiResource(
    'about-sections',
    AboutSectionController::class
);

/*
|--------------------------------------------------------------------------
| Travel Support
|--------------------------------------------------------------------------
*/

Route::get('/travel-support/active', [
    TravelSupportSectionController::class,
    'active',
])->name('api.travel-support.active');

Route::apiResource(
    'travel-support',
    TravelSupportSectionController::class
);

/*
|--------------------------------------------------------------------------
| Why Choose Section
|--------------------------------------------------------------------------
*/

Route::get('/why-choose-sections/active', [
    WhyChooseSectionController::class,
    'active',
])->name('api.why-choose-sections.active');

Route::apiResource(
    'why-choose-sections',
    WhyChooseSectionController::class
);

/*
|--------------------------------------------------------------------------
| Page Banners
|--------------------------------------------------------------------------
*/

Route::apiResource(
    'page-banners',
    PageBannerController::class
);

/*
|--------------------------------------------------------------------------
| Adventure Categories
|--------------------------------------------------------------------------
*/

Route::apiResource(
    'adventure-categories',
    AdventureCategoryController::class
);

/*
|--------------------------------------------------------------------------
| Adventures
|--------------------------------------------------------------------------
*/

Route::get('/adventures/category/{slug}', [
    AdventureController::class,
    'byCategorySlug',
])->name('api.adventures.category');

Route::apiResource(
    'adventures',
    AdventureController::class
);

/*
|--------------------------------------------------------------------------
| Offer Banners
|--------------------------------------------------------------------------
*/

Route::apiResource(
    'offer-banners',
    OfferBannerController::class
);

/*
|--------------------------------------------------------------------------
| Blogs
|--------------------------------------------------------------------------
*/

Route::get('/blogs', [
    BlogController::class,
    'index',
])->name('api.blogs.index');

Route::get('/blogs/{slug}', [
    BlogController::class,
    'show',
])->name('api.blogs.show');

/*
|--------------------------------------------------------------------------
| Our Stories
|--------------------------------------------------------------------------
*/

Route::apiResource(
    'our-stories',
    OurStoryController::class
);

/*
|--------------------------------------------------------------------------
| What We Offer
|--------------------------------------------------------------------------
*/

Route::apiResource(
    'what-we-offers',
    WhatWeOfferController::class
)->parameters([
    'what-we-offers' => 'whatWeOffer',
]);
/*
|--------------------------------------------------------------------------
| About-Why-Choose-Us
|--------------------------------------------------------------------------
*/
Route::apiResource(
    'about-why-choose-us',
    AboutWhyChooseUsController::class
)->parameters([
    'about-why-choose-us' =>
    'aboutWhyChooseUs',
]);
/*
|--------------------------------------------------------------------------
| About Our Core Values
|--------------------------------------------------------------------------
*/

Route::apiResource(
    'about-our-core-values',
    AboutOurCoreValueController::class
)->parameters([
    'about-our-core-values' =>
    'aboutOurCoreValue',
]);

/*
|--------------------------------------------------------------------------
| Testimonials
|--------------------------------------------------------------------------
*/

Route::apiResource(
    'testimonials',
    TestimonialController::class
);
