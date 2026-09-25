<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $table = 'gc_citas';

    protected $fillable = [
        'titulo',
        'descripcion',
        'area',
        'cliente_nombre',
        'cliente_email',
        'cliente_telefono',
        'cliente_dni',
        'fecha_inicio',
        'fecha_fin',
        'tipo',
        'estado',
        'color',
        'notas',
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
        'recordatorio_enviado' => 'boolean',
    ];

    public function scopeProximas($query)
    {
        return $query->where('fecha_inicio', '>=', now())
            ->whereNotIn('estado', ['cancelada'])
            ->orderBy('fecha_inicio');
    }

    public function scopeHoy($query)
    {
        return $query->whereDate('fecha_inicio', today())
            ->whereNotIn('estado', ['cancelada']);
    }
}
