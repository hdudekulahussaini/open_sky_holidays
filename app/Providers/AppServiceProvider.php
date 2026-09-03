<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (is_dir(storage_path('app/public/about'))) {
            \Illuminate\Support\Facades\File::copyDirectory(
                storage_path('app/public/about'),
                public_path('storage/about')
            );
        }

        if (is_dir(storage_path('app/public/testimonials'))) {
            \Illuminate\Support\Facades\File::copyDirectory(
                storage_path('app/public/testimonials'),
                public_path('storage/testimonials')
            );
        }
        Paginator::useBootstrapFive();
    }
}
