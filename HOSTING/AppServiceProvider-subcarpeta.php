<?php

/**
 * ============================================
 * AppServiceProvider PARA SUBCARPETA /muni/
 * ============================================
 * 
 * Reemplace app/Providers/AppServiceProvider.php 
 * con este archivo en el hosting
 * 
 * ============================================
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // ============================================
        // FORZAR URL BASE PARA SUBCARPETA /muni/
        // ============================================
        
        // Solo en producción
        if (config('app.env') === 'production') {
            // Forzar HTTPS
            URL::forceScheme('https');
            
            // Forzar la URL raíz correcta
            URL::forceRootUrl(config('app.url'));
        }
        
        // Alternativa: Detectar automáticamente la subcarpeta
        // $this->app['url']->forceRootUrl(env('APP_URL', 'https://munilayaradalospalos.gob.pe/muni'));
    }
}

