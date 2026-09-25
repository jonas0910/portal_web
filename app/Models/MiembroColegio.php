<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MiembroColegio extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'gc_miembros_colegio';

    protected $fillable = [
        'nombre',
        'apellidos',
        'tipo',
        'cargo',
        'periodo',
        'notaria',
        'direccion',
        'distrito',
        'telefono',
        'email',
        'foto',
        'orden',
        'activo',
        'biografia'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'orden' => 'integer'
    ];

    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            if (filter_var($this->foto, FILTER_VALIDATE_URL)) {
                return $this->foto;
            }
            
            // Usamos la misma lógica que FotoAniversario que sí funciona:
            // Apuntar directamente al backend de la intranet (8000)
            $base = rtrim(config('app.intranet_storage_url', 'http://localhost:8000'), '/');
            $path = ltrim($this->foto, '/');
            $path = preg_replace('/^storage\//', '', $path);
            
            return $base . '/media/' . $path;
        }
        return asset('images/default-avatar.png');
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }
}
