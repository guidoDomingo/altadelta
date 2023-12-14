<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
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
        if ($this->app->environment() == 'production') {
            //URL::forceSchema('http');
            Log::debug(['ENTRO_BOOT_APPSERVICEPROVIDER' => $this->app->environment()]);
            URL::forceScheme('https');
            //URL::forceRootUrl(config('app.url_remoto'));
            //nuevo commit
        }
    }
}
