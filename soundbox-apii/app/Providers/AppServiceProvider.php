<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Song;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        //
        Schema::defaultStringLength(191);
        view()->composer('components.layout', function ($view) {
            $songs = Song::all();
            $categories = Category::all();
            $view->with(['songs' => $songs, 'categories' => $categories]);
        });
    }
}
