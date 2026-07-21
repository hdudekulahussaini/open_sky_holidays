<?php

use App\Http\Controllers\Admin\AboutSectionController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\Admin\HeroController;
use App\Http\Controllers\Admin\PageBannerController;
use App\Http\Controllers\Admin\TravelSupportSectionController;
use App\Http\Controllers\Admin\WhyChooseSectionController;
use App\Http\Controllers\Admin\AdventureCategoryController;
use App\Http\Controllers\Admin\AdventureController;
use App\Http\Controllers\Admin\OfferBannerController;
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

        Route::middleware(['auth', 'admin'])->group(function () {
            Route::get('/dashboard', [
                DashboardController::class,
                'index',
            ])->name('dashboard');

            Route::get('/enquiries', [
                EnquiryController::class,
                'index',
            ])->name('enquiries.index');

            Route::get('/enquiries/{enquiry}', [
                EnquiryController::class,
                'show',
            ])->name('enquiries.show');

            Route::resource(
                'about-sections',
                AboutSectionController::class
            );
            Route::resource(
                'travel-support',
                TravelSupportSectionController::class
            );
            Route::resource(
                'why-choose-sections',
                WhyChooseSectionController::class
            );
            Route::patch('/enquiries/{enquiry}/status', [
                EnquiryController::class,
                'updateStatus',
            ])->name('enquiries.status');

            Route::delete('/enquiries/{enquiry}', [
                EnquiryController::class,
                'destroy',
            ])->name('enquiries.destroy');

            Route::resource('heroes', HeroController::class)
                ->except('show');
            Route::resource(
                'page-banners',
                PageBannerController::class
            )->except('show');
            Route::resource(
                'adventure-categories',
                AdventureCategoryController::class
            )->except('show');

            Route::resource(
                'adventures',
                AdventureController::class
            )->except('show');
            Route::resource(
                'offer-banners',
                OfferBannerController::class
            )->except('show');


            Route::post('/logout', [
                AuthController::class,
                'logout',
            ])->name('logout');
        });
    });
