<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class FotoAniversario extends Model
{
    use HasFactory;

    protected $table = 'gc_fotos_aniversario';

    protected $fillable = [
        'titulo',
        'nombre_actividad',
        'descripcion',
        'imagen',
        'imagen_thumbnail',
        'anio',
        'fecha',
        'fecha_inicio',
        'fecha_fin',
        'orden',
        'activo',
        'es_anuncio'
    ];

    protected $casts = [
        'fecha' => 'date',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'activo' => 'boolean',
        'anio' => 'integer',
        'orden' => 'integer'
    ];

    /**
     * Atributos que se deben añadir al JSON/Array.
     * Esto es VITAL para que el JavaScript reciba las URLs limpias.
     */
    protected $appends = ['imagen_url', 'thumbnail_url'];

    /**
     * Scope para obtener solo fotos activas
     */
    public function scopeActivas($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope para obtener solo fotos vigentes (dentro del periodo)
     */
    public function scopeVigentes($query)
    {
        $hoy = Carbon::today();
        
        return $query->where(function($q) use ($hoy) {
            // Sin fechas definidas = siempre vigente
            $q->where(function($q2) {
                $q2->whereNull('fecha_inicio')->whereNull('fecha_fin');
            })
            // Solo fecha inicio definida
            ->orWhere(function($q2) use ($hoy) {
                $q2->whereNotNull('fecha_inicio')
                   ->whereNull('fecha_fin')
                   ->where('fecha_inicio', '<=', $hoy);
            })
            // Solo fecha fin definida
            ->orWhere(function($q2) use ($hoy) {
                $q2->whereNull('fecha_inicio')
                   ->whereNotNull('fecha_fin')
                   ->where('fecha_fin', '>=', $hoy);
            })
            // Ambas fechas definidas
            ->orWhere(function($q2) use ($hoy) {
                $q2->whereNotNull('fecha_inicio')
                   ->whereNotNull('fecha_fin')
                   ->where('fecha_inicio', '<=', $hoy)
                   ->where('fecha_fin', '>=', $hoy);
            });
        });
    }

    /**
     * Verificar si la foto está vigente
     */
    public function getEstaVigenteAttribute()
    {
        $hoy = Carbon::today();
        
        $fechaInicio = $this->fecha_inicio;
        $fechaFin = $this->fecha_fin;
        
        // Sin fechas = siempre vigente
        if (empty($fechaInicio) && empty($fechaFin)) {
            return true;
        }
        
        // Solo fecha inicio definida
        if (!empty($fechaInicio) && empty($fechaFin)) {
            return $hoy->gte(Carbon::parse($fechaInicio));
        }
        
        // Solo fecha fin definida
        if (empty($fechaInicio) && !empty($fechaFin)) {
            return $hoy->lte(Carbon::parse($fechaFin));
        }
        
        // Ambas fechas definidas
        return $hoy->between(Carbon::parse($fechaInicio), Carbon::parse($fechaFin));
    }

    /**
     * Scope para ordenar por orden
     */
    public function scopeOrdenadas($query)
    {
        return $query->orderBy('orden', 'asc')->orderBy('created_at', 'desc');
    }

    /**
     * Scope para filtrar por año
     */
    public function scopePorAnio($query, $anio)
    {
        return $query->where('anio', $anio);
    }

    /**
     * Obtener la URL completa de la imagen.
     * Usa INTRANET_STORAGE_URL (backend 8000) porque las fotos se suben desde el gestor de contenidos.
     */
    public function getImagenUrlAttribute()
    {
        if (!$this->imagen) {
            return asset('images/default-placeholder.jpg');
        }

        // Si es una URL externa
        if (filter_var($this->imagen, FILTER_VALIDATE_URL)) {
            return $this->imagen;
        }

        // Mismo formato que el banner: URL directa al backend (8000) - el banner sí carga bien
        $base = rtrim(config('app.intranet_storage_url', 'http://localhost:8000'), '/');
        $path = ltrim($this->imagen, '/');
        // Limpiamos el prefijo 'storage/' si existe en el path guardado en DB
        $path = preg_replace('/^storage\//', '', $path);
        
        return $base . '/media/' . $path;
    }

    /**
     * Alias: gc_fotos_aniversario usa 'thumbnail', muni usa 'imagen_thumbnail'
     */
    public function getImagenThumbnailAttribute()
    {
        return $this->attributes['imagen_thumbnail'] ?? $this->attributes['thumbnail'] ?? null;
    }

    /**
     * Obtener la URL completa del thumbnail.
     * Usa INTRANET_STORAGE_URL (backend 8000) porque las fotos se suben desde el gestor de contenidos.
     */
    public function getThumbnailUrlAttribute()
    {
        $thumb = $this->imagen_thumbnail;
        if (!$thumb) {
            return $this->imagen_url;
        }

        // Si es una URL externa
        if (filter_var($thumb, FILTER_VALIDATE_URL)) {
            return $thumb;
        }

        // Mismo formato que el banner: URL directa al backend (8000)
        $base = rtrim(config('app.intranet_storage_url', 'http://localhost:8000'), '/');
        $path = ltrim($thumb, '/');
        // Limpiamos el prefijo 'storage/' si existe en el path guardado en DB
        $path = preg_replace('/^storage\//', '', $path);

        return $base . '/media/' . $path;
    }
}


