<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Tema extends Model
{
    use HasFactory;

    protected $table = 'gc_temas';

    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'es_predeterminado',
        'color_primario',
        'color_secundario',
        'color_acento',
        'fuente_principal',
        'fuente_secundaria',
        'color_navbar',
        'color_top_bar',
        'color_texto_top_bar',
        'mostrar_top_bar',
        'mostrar_header_accesos',
        'mostrar_footer',
        'banner_alto',
        'banner_alto_movil',
        'banner_ajuste_imagen',
        'boton_estilo',
        'boton_tamano',
        'espaciado_secciones',
        'animaciones_habilitadas',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'es_predeterminado' => 'boolean',
        'mostrar_top_bar' => 'boolean',
        'mostrar_header_accesos' => 'boolean',
        'mostrar_footer' => 'boolean',
        'animaciones_habilitadas' => 'boolean',
    ];

    /**
     * Scope para temas activos
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Obtener el tema predeterminado
     */
    public static function obtenerPredeterminado()
    {
        return static::where('es_predeterminado', true)->first() ?? static::activos()->first();
    }

    /**
     * Establecer como tema predeterminado
     */
    public function establecerComoPredeterminado()
    {
        static::where('es_predeterminado', true)->update(['es_predeterminado' => false]);

        $this->es_predeterminado = true;
        $this->activo = true;
        $this->save();

        Cache::forget('tema_predeterminado');

        return $this;
    }

    /**
     * Boot del modelo
     */
    protected static function boot()
    {
        parent::boot();

        static::saved(function($model) {
            if ($model->es_predeterminado) {
                Cache::forget('tema_predeterminado');
            }
        });

        static::deleted(function($model) {
            if ($model->es_predeterminado) {
                Cache::forget('tema_predeterminado');
                $nuevoDefault = static::activos()->first();
                if ($nuevoDefault) {
                    $nuevoDefault->establecerComoPredeterminado();
                }
            }
        });
    }
}
