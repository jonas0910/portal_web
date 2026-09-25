<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaDocumento extends Model
{
    use HasFactory;

    protected $table = 'gc_categoria_documentos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'color',
        'icono',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * Relación con documentos
     */
    public function documentos()
    {
        return $this->hasMany(Documento::class, 'categoria_id');
    }

    /**
     * Scope para categorías activas
     */
    public function scopeActivas($query)
    {
        return $query->where('activo', true);
    }
}
