<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'gc_menus';

    protected $fillable = [
        'nombre',
        'ubicacion',
        'tipo',
        'pagina_id',
        'url',
        'icono',
        'target',
        'parent_id',
        'orden',
        'activo',
        'configuracion'
    ];

    protected $casts = [
        'configuracion' => 'array',
        'activo' => 'boolean',
        'orden' => 'integer',
        'parent_id' => 'integer'
    ];

    /**
     * Scope para menús activos
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope para menús por ubicación
     */
    public function scopePorUbicacion($query, $ubicacion)
    {
        return $query->where('ubicacion', $ubicacion);
    }

    /**
     * Scope para menús padre
     */
    public function scopePadres($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Relación con menú padre
     */
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    /**
     * Relación con menús hijos
     */
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('orden');
    }

    /**
     * Relación con página
     */
    public function pagina()
    {
        return $this->belongsTo(Pagina::class, 'pagina_id');
    }


    /**
     * Obtener todos los ancestros
     */
    public function ancestors()
    {
        $ancestors = collect();
        $parent = $this->parent;
        
        while ($parent) {
            $ancestors->prepend($parent);
            $parent = $parent->parent;
        }
        
        return $ancestors;
    }

    /**
     * Obtener todos los descendientes
     */
    public function descendants()
    {
        $descendants = collect();
        
        foreach ($this->children as $child) {
            $descendants->push($child);
            $descendants = $descendants->merge($child->descendants());
        }
        
        return $descendants;
    }

    /**
     * Obtener la estructura completa del menú
     */
    public function getEstructuraAttribute()
    {
        return $this->children->map(function($child) {
            return [
                'id' => $child->id,
                'nombre' => $child->nombre,
                'url' => $child->url_final,
                'icono' => $child->icono,
                'target' => $child->target,
                'children' => $child->estructura
            ];
        });
    }

    /**
     * Obtener la URL final del menú (con soporte para subcarpeta)
     */
    public function getUrlFinalAttribute()
    {
        $url = $this->url;
        
        if ($this->tipo === 'pagina' && $this->url) {
            // Buscar la página por slug
            $pagina = Pagina::where('slug', $this->url)->first();
            if ($pagina) {
                return $pagina->url; // Las páginas usan route() que ya tiene el prefijo
            }
        }
        
        // Si es URL externa (http/https), devolverla tal cual
        if ($url && (str_starts_with($url, 'http://') || str_starts_with($url, 'https://'))) {
            return $url;
        }

        // Si es un ancla (#), devolver tal cual
        if ($url && str_starts_with($url, '#')) {
            return $url;
        }
        
        // Si es URL relativa, asegurar que tenga el prefijo / y agregar prefijo de app
        if ($url) {
            if (!str_starts_with($url, '/')) {
                $url = '/' . $url;
            }
            return self::agregarPrefijoUrl($url);
        }
        
        return $url;
    }

    /**
     * Agregar prefijo de subcarpeta a URLs relativas
     */
    public static function agregarPrefijoUrl($url)
    {
        // Obtener el path de APP_URL (ej: /muni)
        $appUrl = config('app.url');
        $parsedUrl = parse_url($appUrl);
        $basePath = $parsedUrl['path'] ?? '';
        
        // Si ya tiene el prefijo, no agregarlo de nuevo
        if ($basePath && str_starts_with($url, $basePath)) {
            return $url;
        }
        
        // Si la URL es solo "/", devolver el basePath o "/"
        if ($url === '/') {
            return $basePath ?: '/';
        }
        
        // Agregar el prefijo
        return rtrim($basePath, '/') . $url;
    }

    /**
     * Obtener el nivel de profundidad
     */
    public function getNivelAttribute()
    {
        return $this->ancestors()->count();
    }

    /**
     * Obtener una configuración específica
     */
    public function getConfiguracion($clave, $default = null)
    {
        return data_get($this->configuracion, $clave, $default);
    }

    /**
     * Establecer una configuración específica
     */
    public function setConfiguracion($clave, $valor)
    {
        $configuracion = $this->configuracion ?? [];
        data_set($configuracion, $clave, $valor);
        $this->configuracion = $configuracion;
    }

    /**
     * Método estático para obtener menús por ubicación
     */
    public static function obtenerPorUbicacion($ubicacion)
    {
        return static::activos()
            ->porUbicacion($ubicacion)
            ->padres()
            ->orderBy('orden')
            ->get();
    }
}