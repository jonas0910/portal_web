<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Proyecto extends Model
{
    use HasFactory;

    protected $table = 'gc_proyectos';

    protected $fillable = [
        'titulo',
        'slug',
        'descripcion_corta',
        'descripcion_completa',
        'estado',
        'prioridad',
        'responsable',
        'imagen_principal',
        'imagenes_galeria',
        'ubicacion',
        'presupuesto',
        'progreso',
        'fecha_inicio',
        'fecha_fin_estimada',
        'fecha_fin_real',
        'objetivos',
        'hitos',
        'equipo',
        'observaciones',
        'destacado',
        'publicado',
        'meta_titulo',
        'meta_descripcion',
        'orden'
    ];

    protected $casts = [
        'imagenes_galeria' => 'array',
        'objetivos' => 'array',
        'hitos' => 'array',
        'equipo' => 'array',
        'destacado' => 'boolean',
        'publicado' => 'boolean',
        'fecha_inicio' => 'date',
        'fecha_fin_estimada' => 'date',
        'fecha_fin_real' => 'date',
        'presupuesto' => 'decimal:2',
        'progreso' => 'integer',
        'orden' => 'integer'
    ];

    protected $dates = [
        'fecha_inicio',
        'fecha_fin_estimada',
        'fecha_fin_real'
    ];

    /**
     * Scope para proyectos publicados
     */
    public function scopePublicados($query)
    {
        return $query->where('publicado', true);
    }

    /**
     * Scope para proyectos destacados
     */
    public function scopeDestacados($query)
    {
        return $query->where('destacado', true);
    }

    /**
     * Scope para proyectos en curso
     */
    public function scopeEnCurso($query)
    {
        return $query->where('estado', 'en_curso');
    }

    /**
     * Scope para proyectos completados
     */
    public function scopeCompletados($query)
    {
        return $query->where('estado', 'completado');
    }

    /**
     * Scope por estado
     */
    public function scopeEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    /**
     * Accessor para la URL de la imagen principal.
     * Usa la ruta que sirve desde Storage para no depender del enlace public/storage.
     */
    public function getImagenPrincipalUrlAttribute()
    {
        if (!$this->imagen_principal) {
            return asset('images/proyecto-default.jpg');
        }
        if (filter_var($this->imagen_principal, FILTER_VALIDATE_URL)) {
            return $this->imagen_principal;
        }
        $path = str_replace('\\', '/', $this->imagen_principal);
        // Imagen principal está en proyectos/xxx (no en proyectos/galeria/)
        if (str_starts_with($path, 'proyectos/') && !str_starts_with($path, 'proyectos/galeria/')) {
            return url('/archivos/proyectos/principal/' . basename($path));
        }
        return Storage::disk('public')->url($path);
    }

    /**
     * URLs de las imágenes de la galería (para mostrar en vistas).
     * Usa la ruta 'archivo.galeria' que sirve desde Storage para no depender del enlace public/storage.
     */
    public function getGaleriaUrlsAttribute()
    {
        $galeria = $this->imagenes_galeria ?? [];
        if (!is_array($galeria)) {
            return [];
        }
        $urls = [];
        foreach ($galeria as $path) {
            if (!is_string($path) || $path === '') {
                continue;
            }
            $path = str_replace('\\', '/', $path);
            if (filter_var($path, FILTER_VALIDATE_URL)) {
                $urls[] = $path;
            } elseif (str_starts_with($path, 'proyectos/galeria/')) {
                $urls[] = url('/archivos/proyectos/galeria/' . basename($path));
            } else {
                $urls[] = Storage::disk('public')->url($path);
            }
        }
        return $urls;
    }

    /**
     * Accessor para la URL pública del proyecto
     */
    public function getUrlAttribute()
    {
        return route('public.proyecto', $this->slug);
    }

    /**
     * Accessor para el badge de estado
     */
    public function getEstadoBadgeAttribute()
    {
        $badges = [
            'planificacion' => 'secondary',
            'en_curso' => 'primary',
            'completado' => 'success',
            'pausado' => 'warning',
            'cancelado' => 'danger'
        ];
        
        return $badges[$this->estado] ?? 'secondary';
    }

    /**
     * Accessor para el badge de prioridad
     */
    public function getPrioridadBadgeAttribute()
    {
        $badges = [
            'baja' => 'info',
            'media' => 'primary',
            'alta' => 'warning',
            'urgente' => 'danger'
        ];
        
        return $badges[$this->prioridad] ?? 'primary';
    }

    /**
     * Calcular si el proyecto está retrasado
     */
    public function getEstaRetrasadoAttribute()
    {
        if (!$this->fecha_fin_estimada || $this->estado === 'completado') {
            return false;
        }
        
        return now()->gt($this->fecha_fin_estimada);
    }

    /**
     * Generar slug automáticamente al crear
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($proyecto) {
            if (empty($proyecto->slug)) {
                $proyecto->slug = Str::slug($proyecto->titulo);
            }
        });
    }
}
