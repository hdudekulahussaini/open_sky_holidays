<?php

use App\Http\Controllers\Api\AboutSectionController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\EnquiryController;
use App\Http\Controllers\Api\PageBannerController;
use App\Http\Controllers\Api\TravelSupportSectionController;
use App\Http\Controllers\Api\WhyChooseSectionController;
use Illuminate\Support\Facades\Route;

Route::post('/enquiries', [
    EnquiryController::class,
    'store',
])->name('api.enquiries.store');
Route::get(
    '/about-section/active',
    [AboutSectionController::class, 'active']
)->name('api.about-section.active');

// Route::middleware('auth:sanctum')->group(function () {
//     Route::apiResource(
//         'about-sections',
//         AboutSectionController::class
//     );

// });
Route::apiResource(
    'about-sections',
    AboutSectionController::class
);
Route::get(
    'travel-support/active',
    [TravelSupportSectionController::class, 'active']
);

Route::apiResource(
    'travel-support',
    TravelSupportSectionController::class
);
Route::get(
    'why-choose-sections/active',
    [WhyChooseSectionController::class, 'active']
);

Route::apiResource(
    'why-choose-sections',
    WhyChooseSectionController::class
);
Route::apiResource(
    'page-banners',
    PageBannerController::class
);

Route::get('/blogs', [
    BlogController::class,
    'index',
]);

Route::get('/blogs/{slug}', [
    BlogController::class,
    'show',
]);
