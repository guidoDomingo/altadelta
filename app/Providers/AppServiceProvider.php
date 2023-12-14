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
            Log::debug(['ENTRO_BOOT_APPSERVICEPROVIDER' => $this->app->environment()]);
            URL::forceScheme('https');

            // Obtén el prefijo delta de la configuración o ajusta según sea necesario
            $deltaPrefix = config('app.delta_prefix', 'delta');

            // Agrega el prefijo a la URL base
            $baseUrl = config('app.url') . '/' . $deltaPrefix;

            // Forzar la URL base con el prefijo delta
            URL::forceRootUrl($baseUrl);
        }
    }
}
