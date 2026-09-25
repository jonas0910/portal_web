<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    use HasFactory;

    protected $table = 'gc_contactos';

    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'asunto',
        'mensaje',
        'leido',
        'fecha_leido',
        'respuesta'
    ];

    protected $casts = [
        'leido' => 'boolean',
        'fecha_leido' => 'datetime',
    ];

    /**
     * Scope para mensajes no leídos
     */
    public function scopeNoLeidos($query)
    {
        return $query->where('leido', false);
    }

    /**
     * Scope para mensajes leídos
     */
    public function scopeLeidos($query)
    {
        return $query->where('leido', true);
    }

    /**
     * Marcar como leído
     */
    public function marcarComoLeido()
    {
        $this->update([
            'leido' => true,
            'fecha_leido' => now(),
        ]);
    }
}
