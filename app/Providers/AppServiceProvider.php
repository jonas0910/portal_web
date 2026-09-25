<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
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
        if (app()->runningInConsole()) {
            return;
        }

        Paginator::useBootstrapFive();
        $appUrl = config('app.url');
        $isHttps = str_starts_with(strtolower($appUrl), 'https://');

        // Producción con HTTPS: forzar esquema y URL configurada
        if (config('app.env') === 'production' && $isHttps) {
            URL::forceScheme('https');
            URL::forceRootUrl($appUrl);
            return;
        }

        // Desarrollo o producción con HTTP (ej. localhost): usar el host del request
        // para que asset() genere las mismas URLs que el navegador (evita imágenes rotas por HTTPS o distinto host)
        URL::forceRootUrl(request()->getSchemeAndHttpHost());
    }
}
