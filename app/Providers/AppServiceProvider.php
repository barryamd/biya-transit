<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //Schema::defaultStringLength(191);
        $locale = config('app.locale');
        setlocale(LC_TIME, $locale);
        //$dbLocale = $locale == 'en' ? $locale.'_US' : $locale.'_FR';
        //DB::statement("SET lc_time_names = '$dbLocale'");

        // Partage de données avec toutes les vues
        // View::share('title', __(config('titles.'.Route::currentRouteName())));
    }
}
