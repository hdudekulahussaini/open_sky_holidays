<?php

use App\Http\Controllers\Api\EnquiryController;
use App\Http\Controllers\Api\HeroController;
use App\Http\Controllers\Api\PageBannerController;
use Illuminate\Support\Facades\Route;

Route::post('/enquiries', [
    EnquiryController::class,
    'store',
])->name('api.enquiries.store');

Route::apiResource('hero', HeroController::class);


Route::get('/page-banners/page/{page}', [
    PageBannerController::class,
    'byPage',
])->name('api.page-banners.by-page');

Route::apiResource(
    'page-banners',
    PageBannerController::class
);