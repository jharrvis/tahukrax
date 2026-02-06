<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        Schema::defaultStringLength(191);
        Paginator::useTailwind();

        // Share social media settings with landing page views
        try {
            // Check if table exists to avoid errors during initial migration
            if (Schema::hasTable('settings')) {
                \Illuminate\Support\Facades\View::composer(
                    ['partials.landing.nav', 'partials.landing.footer'],
                    function ($view) {
                        $settings = \App\Models\Setting::whereIn('key', [
                            'social_facebook',
                            'social_instagram',
                            'social_tiktok'
                        ])->pluck('value', 'key');

                        $view->with([
                            'social_facebook' => $settings['social_facebook'] ?? '#',
                            'social_instagram' => $settings['social_instagram'] ?? '#',
                            'social_tiktok' => $settings['social_tiktok'] ?? '#',
                        ]);
                    }
                );
            }
        } catch (\Exception $e) {
            // Ignored to prevent crashes if DB connection fails
        }
    }
}
