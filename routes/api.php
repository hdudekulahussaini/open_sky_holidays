<?php

use App\Http\Controllers\Api\AboutSectionController;
use App\Http\Controllers\Api\AdventureCategoryController;
use App\Http\Controllers\Api\AdventureController;
use App\Http\Controllers\Api\EnquiryController;
use App\Http\Controllers\Api\HeroController;
use App\Http\Controllers\Api\PageBannerController;
use App\Http\Controllers\Api\TravelSupportSectionController;
use App\Http\Controllers\Api\WhyChooseSectionController;
use App\Http\Controllers\Api\OfferBannerController;
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

Route::apiResource('heroes', HeroController::class);

/*
|--------------------------------------------------------------------------
| About Section
|--------------------------------------------------------------------------
*/

Route::get(
    '/about-section/active',
    [AboutSectionController::class, 'active']
)->name('api.about-section.active');

Route::apiResource(
    'about-sections',
    AboutSectionController::class
);

/*
|--------------------------------------------------------------------------
| Travel Support
|--------------------------------------------------------------------------
*/

Route::get(
    '/travel-support/active',
    [TravelSupportSectionController::class, 'active']
);

Route::apiResource(
    'travel-support',
    TravelSupportSectionController::class
);

/*
|--------------------------------------------------------------------------
| Why Choose Section
|--------------------------------------------------------------------------
*/

Route::get(
    '/why-choose-sections/active',
    [WhyChooseSectionController::class, 'active']
);

Route::apiResource(
    'why-choose-sections',
    WhyChooseSectionController::class
);

/*
|--------------------------------------------------------------------------
| Page Banner
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

Route::get(
    '/adventures/category/{slug}',
    [AdventureController::class, 'byCategorySlug']
)->name('api.adventures.category');

Route::apiResource(
    'adventures',
    AdventureController::class
);
/*
|--------------------------------------------------------------------------
| Offer-Banners
|--------------------------------------------------------------------------
*/
Route::apiResource(
    'offer-banners',
    OfferBannerController::class
);
