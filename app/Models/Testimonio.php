<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonio extends Model
{
    use HasFactory;

    protected $table = 'gc_testimonios';

    protected $fillable = [
        'nombre',
        'cargo',
        'empresa',
        'testimonio',
        'calificacion',
        'foto',
        'foto_url',
        'email',
        'destacado',
        'activo',
        'orden'
    ];

    protected $casts = [
        'calificacion' => 'integer',
        'destacado' => 'boolean',
        'activo' => 'boolean',
        'orden' => 'integer',
    ];

    /**
     * Scope para obtener solo testimonios activos
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope para obtener testimonios destacados
     */
    public function scopeDestacados($query)
    {
        return $query->where('destacado', true)->where('activo', true);
    }

    /**
     * Accessor para obtener la URL de la foto
     */
    public function getFotoUrlFinalAttribute()
    {
        if ($this->foto_url) {
            return $this->foto_url;
        }
        
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        
        return null;
    }

    /**
     * Accessor para obtener las iniciales
     */
    public function getInicialesAttribute()
    {
        $palabras = explode(' ', $this->nombre);
        $iniciales = '';
        
        foreach ($palabras as $palabra) {
            if (!empty($palabra)) {
                $iniciales .= strtoupper(substr($palabra, 0, 1));
                if (strlen($iniciales) >= 2) break;
            }
        }
        
        return $iniciales ?: 'NN';
    }

    /**
     * Accessor para color del avatar
     */
    public function getColorAvatarAttribute()
    {
        $colores = ['#007bff', '#28a745', '#dc3545', '#ffc107', '#17a2b8', '#6f42c1', '#e83e8c', '#fd7e14'];
        $index = ord($this->nombre[0]) % count($colores);
        return $colores[$index];
    }
}










