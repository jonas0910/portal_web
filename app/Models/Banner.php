<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $table = 'gc_banners';

    protected $fillable = [
        'titulo',
        'subtitulo',
        'descripcion',
        'tipo_media',
        'imagen_url',
        'imagen_movil_url',
        'video_url',
        'video_movil_url',
        'poster_url',
        'url',
        'boton_texto',
        'boton_url',
        'target',
        'posicion',
        'posicion_contenido',
        'alineacion_texto',
        'orden',
        'activo',
        'fecha_inicio',
        'fecha_fin',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'orden' => 'integer',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    /**
     * Scope para banners activos
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope para banners por posicion
     */
    public function scopePorPosicion($query, $posicion)
    {
        return $query->where('posicion', $posicion);
    }

    /**
     * Scope para banners vigentes
     */
    public function scopeVigentes($query)
    {
        $now = now();
        return $query->where(function($q) use ($now) {
            $q->whereNull('fecha_inicio')
              ->orWhere('fecha_inicio', '<=', $now);
        })->where(function($q) use ($now) {
            $q->whereNull('fecha_fin')
              ->orWhere('fecha_fin', '>=', $now);
        });
    }

    /**
     * Verificar si el banner esta vigente
     */
    public function getVigenteAttribute()
    {
        $now = now();

        if ($this->fecha_inicio && $this->fecha_inicio > $now) {
            return false;
        }

        if ($this->fecha_fin && $this->fecha_fin < $now) {
            return false;
        }

        return true;
    }

    /**
     * Metodo estatico para obtener banners por posicion
     */
    public static function obtenerPorPosicion($posicion)
    {
        return static::activos()
            ->porPosicion($posicion)
            ->vigentes()
            ->orderBy('orden')
            ->get();
    }

    /**
     * Obtener URL final del boton (con soporte para subcarpeta)
     */
    public function getBotonUrlFinalAttribute()
    {
        $url = $this->boton_url ?? $this->url ?? '#';
        return self::agregarPrefijoUrl($url);
    }

    /**
     * Agregar prefijo de subcarpeta a URLs relativas
     */
    public static function agregarPrefijoUrl($url)
    {
        if (!$url || $url === '#') {
            return $url;
        }

        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
            return $url;
        }

        if (str_starts_with($url, '/')) {
            $appUrl = config('app.url');
            $parsedUrl = parse_url($appUrl);
            $basePath = $parsedUrl['path'] ?? '';

            if ($basePath && str_starts_with($url, $basePath)) {
                return $url;
            }

            if ($url === '/') {
                return $basePath ?: '/';
            }

            return rtrim($basePath, '/') . $url;
        }

        return $url;
    }

    /**
     * Metodo estatico para obtener banners principales
     * Acepta posicion 'principal' o 0 (por compatibilidad con migración desde muni)
     */
    public static function obtenerPrincipales()
    {
        return static::activos()
            ->vigentes()
            ->where(function ($q) {
                $q->where('posicion', 'principal')
                  ->orWhere('posicion', 0);
            })
            ->orderBy('orden')
            ->get();
    }

    /**
     * Metodo estatico para obtener banners secundarios
     */
    public static function obtenerSecundarios()
    {
        return static::obtenerPorPosicion('secundario');
    }

    /**
     * Metodo estatico para obtener banners del footer
     */
    public static function obtenerFooter()
    {
        return static::obtenerPorPosicion('footer');
    }

    /**
     * Verificar si el banner es de tipo video
     */
    public function esVideo()
    {
        return $this->tipo_media === 'video';
    }

    /**
     * Verificar si el banner es de tipo imagen
     */
    public function esImagen()
    {
        return $this->tipo_media === 'imagen';
    }

    /**
     * Obtener la URL completa del video (fallback al campo directo)
     */
    public function getVideoUrlCompletoAttribute()
    {
        return $this->video_url;
    }

    /**
     * Obtener la URL completa del video movil
     */
    public function getVideoMovilCompletoAttribute()
    {
        return $this->video_movil_url ?? $this->video_url;
    }

    /**
     * Obtener la URL completa del poster del video
     */
    public function getVideoPosterCompletoAttribute()
    {
        return $this->poster_url;
    }
}
