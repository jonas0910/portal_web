<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Postulacion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'gc_postulaciones';

    protected $fillable = [
        'puesto',
        'nombres',
        'apellidos',
        'email',
        'telefono',
        'ciudad',
        'experiencia',
        'formacion',
        'cv_path',
        'carta_presentacion',
        'estado',
        'notas_internas',
        'ip_address'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Obtener nombre completo
     */
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombres} {$this->apellidos}";
    }

    /**
     * Obtener URL del CV
     */
    public function getCvUrlAttribute()
    {
        if ($this->cv_path) {
            return asset('storage/' . $this->cv_path);
        }
        return null;
    }

    /**
     * Scope para filtrar por estado
     */
    public function scopeEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    /**
     * Scope para pendientes
     */
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    /**
     * Obtener badge de estado
     */
    public function getEstadoBadgeAttribute()
    {
        $badges = [
            'pendiente' => '<span class="badge badge-warning">Pendiente</span>',
            'en_revision' => '<span class="badge badge-info">En Revisión</span>',
            'preseleccionado' => '<span class="badge badge-primary">Preseleccionado</span>',
            'rechazado' => '<span class="badge badge-danger">Rechazado</span>',
            'aceptado' => '<span class="badge badge-success">Aceptado</span>',
        ];
        
        return $badges[$this->estado] ?? '<span class="badge badge-secondary">Desconocido</span>';
    }
}

