<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ConfiguracionSitio extends Model
{
    use HasFactory;

    protected $table = 'gc_configuracion_sitio';

    protected $fillable = [
        'clave',
        'valor',
        'tipo',
        'categoria',
        'descripcion',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean'
    ];

    /**
     * Scope para configuraciones activas
     */
    public function scopeActivas($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope para configuraciones por categoría
     */
    public function scopePorCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    /**
     * Obtener el valor convertido según el tipo
     */
    public function getValorConvertidoAttribute()
    {
        switch ($this->tipo) {
            case 'numero':
                return (float) $this->valor;
            case 'booleano':
                return filter_var($this->valor, FILTER_VALIDATE_BOOLEAN);
            case 'json':
                return json_decode($this->valor, true);
            default:
                return $this->valor;
        }
    }

    /**
     * Obtener una configuración por clave
     */
    public static function obtener($clave, $default = null)
    {
        $cacheKey = "configuracion.{$clave}";
        
        return Cache::remember($cacheKey, 60, function() use ($clave, $default) {
            $config = static::activas()->where('clave', $clave)->first();
            return $config ? $config->valor_convertido : $default;
        });
    }

    /**
     * Obtener el valor de una configuración (alias de obtener)
     * Útil para mantener consistencia con obtenerValor
     */
    public static function obtenerValor($clave, $default = null)
    {
        return static::obtener($clave, $default);
    }

    /**
     * Obtener todas las configuraciones por categoría
     */
    public static function obtenerPorCategoria($categoria)
    {
        $cacheKey = "configuracion.categoria.{$categoria}";
        
        return Cache::remember($cacheKey, 60, function() use ($categoria) {
            return static::activas()
                ->porCategoria($categoria)
                ->get()
                ->pluck('valor_convertido', 'clave')
                ->toArray();
        });
    }

    /**
     * Obtener configuraciones SEO
     */
    public static function obtenerSEO()
    {
        return static::obtenerPorCategoria('seo');
    }

    /**
     * Obtener configuraciones de redes sociales
     */
    public static function obtenerRedesSociales()
    {
        return static::obtenerPorCategoria('redes_sociales');
    }

    /**
     * Obtener configuraciones de contacto
     */
    public static function obtenerContacto()
    {
        return static::obtenerPorCategoria('contacto');
    }

    /**
     * Obtener configuraciones de diseño
     */
    public static function obtenerDiseno()
    {
        return static::obtenerPorCategoria('diseno');
    }

    /**
     * Establecer una configuración
     */
    public static function establecer($clave, $valor, $tipo = 'texto', $categoria = 'general', $descripcion = null)
    {
        $config = static::updateOrCreate(
            ['clave' => $clave],
            [
                'valor' => $valor,
                'tipo' => $tipo,
                'categoria' => $categoria,
                'descripcion' => $descripcion,
                'activo' => true
            ]
        );

        // Limpiar cache
        Cache::forget("configuracion.{$clave}");
        Cache::forget("configuracion.categoria.{$categoria}");

        return $config;
    }

    /**
     * Limpiar cache de configuraciones
     */
    public static function limpiarCache()
    {
        $categorias = static::activas()->distinct()->pluck('categoria');
        
        foreach ($categorias as $categoria) {
            Cache::forget("configuracion.categoria.{$categoria}");
        }
        
        $claves = static::activas()->pluck('clave');
        foreach ($claves as $clave) {
            Cache::forget("configuracion.{$clave}");
        }
    }

    /**
     * Boot del modelo
     */
    protected static function boot()
    {
        parent::boot();

        static::saved(function($model) {
            Cache::forget("configuracion.{$model->clave}");
            Cache::forget("configuracion.categoria.{$model->categoria}");
        });

        static::deleted(function($model) {
            Cache::forget("configuracion.{$model->clave}");
            Cache::forget("configuracion.categoria.{$model->categoria}");
        });
    }
}