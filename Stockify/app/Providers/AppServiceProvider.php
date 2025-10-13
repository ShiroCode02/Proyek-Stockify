<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Settings;

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
        // Share settings global ke semua view (untuk nama app, logo, dll.)
        view()->share('appName', Settings::get('app_name', 'Stockify'));
        view()->share('appLogo', Settings::get('logo_url'));
        view()->share('showLogoSidebar', Settings::get('show_logo_sidebar', true));
        view()->share('darkModeDefault', Settings::get('dark_mode_default', false));
    }
}