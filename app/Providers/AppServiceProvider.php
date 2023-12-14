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

            // Obtener el dominio dinámicamente desde la solicitud HTTP
            $dynamicDomain = request()->getHttpHost();

            // Obtener el prefijo delta de la configuración o ajustar según sea necesario
            $deltaPrefix = config('app.delta_prefix', 'delta');

            // Construir la URL base con el prefijo y el dominio dinámico
            $baseUrl = "https://$dynamicDomain/$deltaPrefix";

            // Forzar la URL base con el prefijo delta y el dominio dinámico
            URL::forceRootUrl($baseUrl);
        }
    }
}
