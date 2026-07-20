<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EnquiryController;
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

            Route::patch('/enquiries/{enquiry}/status', [
                EnquiryController::class,
                'updateStatus',
            ])->name('enquiries.status');

            Route::delete('/enquiries/{enquiry}', [
                EnquiryController::class,
                'destroy',
            ])->name('enquiries.destroy');

            Route::post('/logout', [
                AuthController::class,
                'logout',
            ])->name('logout');
        });
    });