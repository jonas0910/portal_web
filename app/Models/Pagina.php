<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pagina extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'gc_paginas';

    protected $fillable = [
        'titulo',
        'slug',
        'descripcion',
        'contenido',
        'meta_titulo',
        'meta_descripcion',
        'meta_keywords',
        'imagen_principal',
        'plantilla_id',
        'activa',
        'mostrar_en_menu',
        'orden',
        'tipo'
    ];

    protected $casts = [
        'activa' => 'boolean',
        'mostrar_en_menu' => 'boolean',
        'orden' => 'integer'
    ];

    /**
     * Scope para paginas activas
     */
    public function scopeActivas($query)
    {
        return $query->where('activa', true);
    }

    /**
     * Scope para paginas visibles en menu
     */
    public function scopeVisiblesEnMenu($query)
    {
        return $query->where('mostrar_en_menu', true);
    }

    /**
     * Scope para paginas por tipo
     */
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    /**
     * Obtener la URL completa de la imagen principal
     */
    public function getImagenPrincipalUrlAttribute()
    {
        if ($this->imagen_principal) {
            if (filter_var($this->imagen_principal, FILTER_VALIDATE_URL)) {
                return $this->imagen_principal;
            }
            return asset('storage/' . $this->imagen_principal);
        }
        return null;
    }

    /**
     * Obtener la URL de la pagina
     */
    public function getUrlAttribute()
    {
        if ($this->slug === 'inicio') {
            return route('public.index');
        }
        return route('public.pagina', $this->slug);
    }

    /**
     * Relacion con plantilla
     */
    public function plantilla()
    {
        return $this->belongsTo(Plantilla::class, 'plantilla_id');
    }

    /**
     * Relacion con menus
     */
    public function menus()
    {
        return $this->hasMany(Menu::class, 'url', 'slug');
    }
}
