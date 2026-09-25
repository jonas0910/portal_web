<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $table = 'gc_eventos';

    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'todo_el_dia',
        'tipo',
        'ubicacion',
        'color',
        'participantes',
        'publico'
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
        'todo_el_dia' => 'boolean',
        'participantes' => 'array',
        'publico' => 'boolean'
    ];

    public function scopeProximos($query)
    {
        return $query->where('fecha_inicio', '>=', now())->orderBy('fecha_inicio');
    }

    public function scopePublicos($query)
    {
        return $query->where('publico', true);
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }
}

