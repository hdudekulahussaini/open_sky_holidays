<?php

use App\Http\Controllers\Admin\AboutOurCoreValueController;
use App\Http\Controllers\Admin\AboutSectionController;
use App\Http\Controllers\Admin\AboutWhyChooseUsController;
use App\Http\Controllers\Admin\AdventureCategoryController;
use App\Http\Controllers\Admin\AdventureController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CounterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\Admin\HeroController;
use App\Http\Controllers\Admin\OfferBannerController;
use App\Http\Controllers\Admin\OurProcessController;
use App\Http\Controllers\Admin\OurStoryController;
use App\Http\Controllers\Admin\PageBannerController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\TourController;
use App\Http\Controllers\Admin\TourDetailController;
use App\Http\Controllers\Admin\TourTypeController;
use App\Http\Controllers\Admin\TravelSupportSectionController;
use App\Http\Controllers\Admin\WhatWeOfferController;
use App\Http\Controllers\Admin\WhyChooseSectionController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin/login');

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Admin Guest Routes
        |--------------------------------------------------------------------------
        */

        Route::middleware('guest')->group(function () {
            Route::get('/login', [
                AuthController::class,
                'showLogin',
            ])->name('login');

            Route::post('/login', [
                AuthController::class,
                'login',
            ])->name('login.submit');
        });

        /*
        |--------------------------------------------------------------------------
        | Protected Admin Routes
        |--------------------------------------------------------------------------
        */

        Route::middleware([
            'auth',
            'admin',
        ])->group(function () {

            /*
            |--------------------------------------------------------------------------
            | Dashboard
            |--------------------------------------------------------------------------
            */

            Route::get('/dashboard', [
                DashboardController::class,
                'index',
            ])->name('dashboard');

            /*
            |--------------------------------------------------------------------------
            | Admin Profile
            |--------------------------------------------------------------------------
            */

            Route::get('/profile', [
                ProfileController::class,
                'edit',
            ])->name('profile.edit');

            Route::put('/profile', [
                ProfileController::class,
                'update',
            ])->name('profile.update');

            /*
            |--------------------------------------------------------------------------
            | Enquiries
            |--------------------------------------------------------------------------
            */

            Route::get('/enquiries', [
                EnquiryController::class,
                'index',
            ])->name('enquiries.index');

            Route::get('/enquiries/{enquiry}', [
                EnquiryController::class,
                'show',
            ])->name('enquiries.show');

            Route::patch(
                '/enquiries/{enquiry}/status',
                [
                    EnquiryController::class,
                    'updateStatus',
                ]
            )->name('enquiries.status');

            Route::delete('/enquiries/{enquiry}', [
                EnquiryController::class,
                'destroy',
            ])->name('enquiries.destroy');

            /*
            |--------------------------------------------------------------------------
            | About Sections
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'about-sections',
                AboutSectionController::class
            );

            /*
            |--------------------------------------------------------------------------
            | Travel Support
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'travel-support',
                TravelSupportSectionController::class
            );

            /*
            |--------------------------------------------------------------------------
            | Why Choose Us
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'why-choose-sections',
                WhyChooseSectionController::class
            );

            /*
            |--------------------------------------------------------------------------
            | Hero Slides
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'heroes',
                HeroController::class
            )->except('show');

            /*
            |--------------------------------------------------------------------------
            | Page Banners
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'page-banners',
                PageBannerController::class
            )->except('show');

            /*
            |--------------------------------------------------------------------------
            | Blog Categories
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'categories',
                CategoryController::class
            )->except('show');

            /*
            |--------------------------------------------------------------------------
            | Testimonials
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'testimonials',
                TestimonialController::class
            );

            /*
            |--------------------------------------------------------------------------
            | Blog Authors
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'authors',
                AuthorController::class
            )->except('show');

            /*
            |--------------------------------------------------------------------------
            | Blogs
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'blogs',
                BlogController::class
            )->except('show');

            /*
            |--------------------------------------------------------------------------
            | Our Stories
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'our-stories',
                OurStoryController::class
            );
            Route::resource(
                'our-processes',
                OurProcessController::class
            );
            Route::resource('counters', CounterController::class);
            Route::resource('services', ServiceController::class);
            Route::resource('tour-types', TourTypeController::class);
            Route::resource('tours', TourController::class);
            Route::resource('tour-details', TourDetailController::class);

            /*
            |--------------------------------------------------------------------------
            | Offer Banners
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'offer-banners',
                OfferBannerController::class
            )->except('show');

            /*
            |--------------------------------------------------------------------------
            | Adventure Categories
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'adventure-categories',
                AdventureCategoryController::class
            )->except('show');

            /*
            |--------------------------------------------------------------------------
            | Adventures
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'adventures',
                AdventureController::class
            )->except('show');

            /*
            |--------------------------------------------------------------------------
            | What We Offer
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'what-we-offers',
                WhatWeOfferController::class
            )
                ->parameters([
                    'what-we-offers' => 'whatWeOffer',
                ])
                ->except('show');
            /*
            |--------------------------------------------------------------------------
            | About-Why-Choose-Us
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'about-why-choose-us',
                AboutWhyChooseUsController::class
            )
                ->parameters([
                    'about-why-choose-us' => 'aboutWhyChooseUs',
                ])
                ->except('show');
            /*
            |--------------------------------------------------------------------------
            | About-Our-Core-Values
            |--------------------------------------------------------------------------
            */
            Route::resource(
                'about-our-core-values',
                AboutOurCoreValueController::class
            )
                ->parameters([
                    'about-our-core-values' => 'aboutOurCoreValue',
                ])
                ->except('show');

            /*
            |--------------------------------------------------------------------------
            | Logout
            |--------------------------------------------------------------------------
            */

            Route::post('/logout', [
                AuthController::class,
                'logout',
            ])->name('logout');
        });
    });
