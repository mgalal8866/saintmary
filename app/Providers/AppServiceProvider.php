<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Support\Facades\Schema;
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
        if (Schema::hasTable('services')) {

            view()->share('servicemodel', Service::get());
            view()->share('categorymodel', Category::with('service')->get());
        } else {
            // Handle the case where the table doesn't exist, e.g., log an error or provide a default value
            view()->share('servicemodel', collect());
            view()->share('category', collect());
        }

    }
}
