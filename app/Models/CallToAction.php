<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallToAction extends Model
{
    use HasFactory;

    protected $table = 'gc_call_to_actions';

    protected $fillable = [
        'nombre',
        'titulo',
        'subtitulo',
        'boton_principal_texto',
        'boton_principal_url',
        'boton_secundario_texto',
        'boton_secundario_url',
        'tipo',
        'ubicacion',
        'caracteristicas',
        'color_fondo',
        'imagen_fondo',
        'activo',
        'orden'
    ];

    protected $casts = [
        'caracteristicas' => 'array',
        'activo' => 'boolean',
        'orden' => 'integer',
    ];

    /**
     * Scope para CTAs activos
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope para CTAs por ubicación
     */
    public function scopeUbicacion($query, $ubicacion)
    {
        return $query->where('ubicacion', $ubicacion)->where('activo', true);
    }

    /**
     * Obtener CTA global (para página principal)
     */
    public static function obtenerGlobal()
    {
        return self::where('ubicacion', 'global')
            ->where('activo', true)
            ->orderBy('orden')
            ->first();
    }
}










