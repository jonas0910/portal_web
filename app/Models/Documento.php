<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Documento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'gc_documentos';

    protected $fillable = [
        'titulo',
        'descripcion',
        'archivo',
        'tipo_archivo',
        'descargas',
        'publico',
        'subido_por_id',
        'categoria_id',
    ];

    protected $casts = [
        'publico' => 'boolean',
    ];

    /**
     * Relación con usuario que subió el documento
     */
    public function subidoPor()
    {
        return $this->belongsTo(User::class, 'subido_por_id');
    }

    /**
     * Relación con categoría
     */
    public function categoria()
    {
        return $this->belongsTo(CategoriaDocumento::class, 'categoria_id');
    }

    /**
     * Scope para documentos públicos
     */
    public function scopePublicos($query)
    {
        return $query->where('publico', true);
    }

    /**
     * Scope para documentos por tipo
     */
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

}
