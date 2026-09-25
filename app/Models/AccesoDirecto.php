<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccesoDirecto extends Model
{
    use HasFactory;

    protected $table = 'gc_accesos_directos';

    protected $fillable = [
        'titulo',
        'url',
        'icono',
        'imagen', // Ruta de la imagen (alternativa al icono)
        'imagen_alto', // Alto de la imagen en px
        'fuente_tamano', // Tamaño de fuente en px (para lemas)
        'fuente_familia', // Familia de fuente (para lemas)
        'color',
        'target',
        'descripcion',
        'orden',
        'activo',
        'mostrar_en_header',
        'mostrar_en_footer',
        'mostrar_en_barra_superior',
        'tipo', // 'enlace' o 'lema'
    ];

    /**
     * Obtener la URL de la imagen
     */
    public function getImagenUrlAttribute()
    {
        if ($this->imagen) {
            return asset('storage/' . $this->imagen);
        }
        return null;
    }

    /**
     * Verificar si tiene imagen
     */
    public function tieneImagen()
    {
        return !empty($this->imagen);
    }

    protected $casts = [
        'activo' => 'boolean',
        'mostrar_en_header' => 'boolean',
        'mostrar_en_footer' => 'boolean',
        'mostrar_en_barra_superior' => 'boolean',
        'orden' => 'integer',
        'imagen_alto' => 'integer',
        'fuente_tamano' => 'integer',
    ];

    // Constantes para tipos
    const TIPO_ENLACE = 'enlace';
    const TIPO_LEMA = 'lema';
    const TIPO_TITULO = 'titulo';

    public function esLema()
    {
        return $this->tipo === self::TIPO_LEMA;
    }

    public function esTitulo()
    {
        return $this->tipo === self::TIPO_TITULO;
    }

    public function esEnlace()
    {
        return $this->tipo === self::TIPO_ENLACE || empty($this->tipo);
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopeEnHeader($query)
    {
        return $query->where('mostrar_en_header', true);
    }

    public function scopeEnFooter($query)
    {
        return $query->where('mostrar_en_footer', true);
    }

    public function scopeEnBarraSuperior($query)
    {
        return $query->where('mostrar_en_barra_superior', true);
    }

    public function scopeOrdenados($query)
    {
        return $query->orderBy('orden');
    }

    // Métodos estáticos para obtener accesos
    public static function paraHeader()
    {
        return static::activos()->enHeader()->ordenados()->get();
    }

    public static function paraFooter()
    {
        return static::activos()->enFooter()->ordenados()->get();
    }

    public static function paraBarraSuperior()
    {
        return static::activos()->enBarraSuperior()->ordenados()->get();
    }

    /**
     * Obtener URL con prefijo de subcarpeta (para /muni/)
     */
    public function getUrlFinalAttribute()
    {
        return self::agregarPrefijoUrl($this->url);
    }

    /**
     * Agregar prefijo de subcarpeta a URLs relativas
     */
    public static function agregarPrefijoUrl($url)
    {
        if (!$url || $url === '#') {
            return $url;
        }
        
        // Si es URL externa, devolverla tal cual
        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
            return $url;
        }
        
        // Si es URL relativa, agregar el prefijo
        if (str_starts_with($url, '/')) {
            $appUrl = config('app.url');
            $parsedUrl = parse_url($appUrl);
            $basePath = $parsedUrl['path'] ?? '';
            
            // Si ya tiene el prefijo, no agregarlo
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
}
