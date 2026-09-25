<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plantilla extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'gc_plantillas';

    protected $fillable = [
        'nombre',
        'slug',
        'categoria',
        'descripcion',
        'vista',
        'icono',
        'preview',
        'componentes',
        'campos_personalizados',
        'configuracion',
        'permite_sidebar',
        'permite_galeria',
        'permite_tablas',
        'permite_formularios',
        'es_dinamica',
        'activa',
        'orden',
        'nivel'
    ];

    protected $casts = [
        'componentes' => 'array',
        'campos_personalizados' => 'array',
        'configuracion' => 'array',
        'sidebar_widgets' => 'array',
        'sidebar_habilitado' => 'boolean',
        'permite_sidebar' => 'boolean',
        'permite_galeria' => 'boolean',
        'permite_tablas' => 'boolean',
        'permite_formularios' => 'boolean',
        'es_dinamica' => 'boolean',
        'activa' => 'boolean'
    ];

    /**
     * Scope para plantillas activas
     */
    public function scopeActivas($query)
    {
        return $query->where('activa', true);
    }

    /**
     * Scope por categoría
     */
    public function scopeCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    /**
     * Scope por nivel
     */
    public function scopeNivel($query, $nivel)
    {
        return $query->where('nivel', $nivel);
    }

    /**
     * Relación con páginas
     */
    public function paginas()
    {
        return $this->hasMany(Pagina::class, 'plantilla', 'slug');
    }

    /**
     * Obtener URL de preview
     */
    public function getPreviewUrlAttribute()
    {
        if ($this->preview) {
            if (filter_var($this->preview, FILTER_VALIDATE_URL)) {
                return $this->preview;
            }
            return asset('storage/' . $this->preview);
        }
        return asset('images/plantilla-default.jpg');
    }

    /**
     * Obtener badge de nivel
     */
    public function getNivelBadgeAttribute()
    {
        $badges = [
            'basico' => '<span class="badge badge-success">Básico</span>',
            'intermedio' => '<span class="badge badge-info">Intermedio</span>',
            'avanzado' => '<span class="badge badge-warning">Avanzado</span>',
        ];
        
        return $badges[$this->nivel] ?? '<span class="badge badge-secondary">N/A</span>';
    }

    /**
     * Obtener badge de categoría
     */
    public function getCategoriaBadgeAttribute()
    {
        $badges = [
            'basica' => '<span class="badge badge-light">Básica</span>',
            'intermedia' => '<span class="badge badge-primary">Intermedia</span>',
            'avanzada' => '<span class="badge badge-danger">Avanzada</span>',
            'especial' => '<span class="badge badge-dark">Especial</span>',
        ];
        
        return $badges[$this->categoria] ?? '<span class="badge badge-secondary">N/A</span>';
    }

    /**
     * Verificar si tiene componente específico
     */
    public function tieneComponente($componente)
    {
        $componentes = $this->componentes ?? [];
        return in_array($componente, $componentes);
    }
}

