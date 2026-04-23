<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
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
        Paginator::useBootstrapFive();

        $publicUrl = trim((string) config('site.public_url', ''), '/');
        if ($publicUrl !== '') {
            URL::forceRootUrl($publicUrl);

            if (str_starts_with($publicUrl, 'https://')) {
                URL::forceScheme('https');
            }
        }
    }
}
