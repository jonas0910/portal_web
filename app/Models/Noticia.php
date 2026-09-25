<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Noticia extends Model
{
    use HasFactory;

    protected $table = 'gc_noticias';

    protected $fillable = [
        'titulo',
        'slug',
        'resumen',
        'contenido',
        'autor',
        'imagen_principal',
        'imagen_miniatura',
        'categoria',
        'tags',
        'archivo_adjunto',
        'vistas',
        'destacada',
        'publicada',
        'fecha_publicacion',
        'meta_titulo',
        'meta_descripcion',
        'meta_keywords',
        'orden'
    ];

    protected $casts = [
        'tags' => 'array',
        'destacada' => 'boolean',
        'publicada' => 'boolean',
        'fecha_publicacion' => 'date',
        'vistas' => 'integer',
        'orden' => 'integer'
    ];

    protected $dates = [
        'fecha_publicacion'
    ];

    /**
     * Scope para noticias publicadas
     */
    public function scopePublicadas($query)
    {
        return $query->where('publicada', true)
                    ->where(function($q) {
                        $q->whereNull('fecha_publicacion')
                          ->orWhere('fecha_publicacion', '<=', now());
                    });
    }

    /**
     * Scope para noticias destacadas
     */
    public function scopeDestacadas($query)
    {
        return $query->where('destacada', true);
    }

    /**
     * Scope para buscar por categoria
     */
    public function scopeCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    /**
     * Accessor para la URL de la imagen principal (sirve desde Storage).
     */
    public function getImagenPrincipalUrlAttribute()
    {
        if (!$this->imagen_principal) {
            return asset('images/noticia-default.jpg');
        }
        if (filter_var($this->imagen_principal, FILTER_VALIDATE_URL)) {
            return $this->imagen_principal;
        }

        $base = rtrim(config('app.intranet_storage_url', 'http://localhost:8000'), '/');
        $path = ltrim(str_replace('storage/', '', $this->imagen_principal), '/');
        
        return $base . '/media/' . $path;
    }

    /**
     * Accessor para la URL de la imagen miniatura (sirve desde Storage).
     */
    public function getImagenMiniaturaUrlAttribute()
    {
        if (!$this->imagen_miniatura) {
            return $this->imagen_principal_url;
        }
        if (filter_var($this->imagen_miniatura, FILTER_VALIDATE_URL)) {
            return $this->imagen_miniatura;
        }

        $base = rtrim(config('app.intranet_storage_url', 'http://localhost:8000'), '/');
        $path = ltrim(str_replace('storage/', '', $this->imagen_miniatura), '/');
        
        return $base . '/media/' . $path;
    }

    /**
     * Accessor para la URL del archivo adjunto (sirve desde Storage).
     */
    public function getArchivoAdjuntoUrlAttribute()
    {
        if (!$this->archivo_adjunto) {
            return null;
        }
        if (filter_var($this->archivo_adjunto, FILTER_VALIDATE_URL)) {
            return $this->archivo_adjunto;
        }

        $base = rtrim(config('app.intranet_storage_url', 'http://localhost:8000'), '/');
        $path = ltrim(str_replace('storage/', '', $this->archivo_adjunto), '/');
        
        return $base . '/media/' . $path;
    }

    /**
     * URLs de la galeria (no hay columna imagenes_galeria en la tabla).
     */
    public function getGaleriaUrlsAttribute()
    {
        return [];
    }

    /**
     * Accessor para la URL publica de la noticia
     */
    public function getUrlAttribute()
    {
        return route('public.noticia', $this->slug);
    }

    /**
     * Incrementar contador de vistas
     */
    public function incrementarVistas()
    {
        $this->increment('vistas');
    }

    /**
     * Generar slug automaticamente al crear
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($noticia) {
            if (empty($noticia->slug)) {
                $noticia->slug = Str::slug($noticia->titulo);
            }
        });
    }
}
