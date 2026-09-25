<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class OfertaEmpleo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'gc_ofertas_empleo';

    protected $fillable = [
        'titulo',
        'slug',
        'descripcion',
        'requisitos',
        'beneficios',
        'salario_minimo',
        'salario_maximo',
        'tipo_contrato',
        'modalidad',
        'ubicacion',
        'vacantes',
        'estado',
        'fecha_publicacion',
        'fecha_cierre',
        'pdf_bases',
        'pdf_evaluacion',
        'pdf_ganadores',
        'creado_por_id'
    ];

    protected $casts = [
        'fecha_publicacion' => 'date',
        'fecha_cierre' => 'date',
        'salario_minimo' => 'decimal:2',
        'salario_maximo' => 'decimal:2',
        'vacantes' => 'integer',
    ];

    /**
     * Parsea requisitos/beneficios que pueden ser JSON o texto con saltos de línea.
     */
    protected function parseListAttribute(?string $value): array
    {
        if (empty($value)) {
            return [];
        }
        $decoded = json_decode($value);
        if (is_array($decoded)) {
            return array_values(array_filter($decoded));
        }
        return array_values(array_filter(preg_split('/\r?\n/', $value)));
    }

    /**
     * Boot del modelo
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($oferta) {
            if (empty($oferta->slug)) {
                $oferta->slug = Str::slug($oferta->titulo);
            }
        });
    }

    /**
     * Accessors para requisitos y beneficios (JSON o texto con saltos de línea).
     */
    protected function requisitos(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->parseListAttribute($value),
        );
    }

    protected function beneficios(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->parseListAttribute($value),
        );
    }

    /**
     * Scopes
     */
    public function scopeActivas($query)
    {
        return $query->whereNotIn('estado', ['cerrada', 'finalizada']);
    }

    public function scopeAbiertas($query)
    {
        return $query->where('estado', 'abierta');
    }

    public function scopeDestacadas($query)
    {
        return $query;
    }

    /**
     * Relacion con postulaciones
     */
    public function postulaciones()
    {
        return $this->hasMany(Postulacion::class, 'oferta_empleo_id');
    }

    /**
     * Relacion con el usuario creador
     */
    public function creadoPor()
    {
        return $this->belongsTo(User::class, 'creado_por_id');
    }

    /**
     * Accessors
     */
    public function getEstadoBadgeAttribute()
    {
        $badges = [
            'borrador' => '<span class="badge badge-secondary">Borrador</span>',
            'abierta' => '<span class="badge badge-success">Abierta</span>',
            'cerrada' => '<span class="badge badge-warning">Cerrada</span>',
            'finalizada' => '<span class="badge badge-dark">Finalizada</span>'
        ];

        return $badges[$this->estado] ?? '';
    }

    public function getModalidadTextAttribute()
    {
        $modalidades = [
            'presencial' => 'Presencial',
            'remoto' => 'Remoto',
            'hibrido' => 'Hibrido'
        ];

        return $modalidades[$this->modalidad] ?? $this->modalidad;
    }

    public function getSalarioRangoAttribute()
    {
        if ($this->salario_minimo && $this->salario_maximo) {
            return "S/ {$this->salario_minimo} - S/ {$this->salario_maximo}";
        } elseif ($this->salario_minimo) {
            return "Desde S/ {$this->salario_minimo}";
        } elseif ($this->salario_maximo) {
            return "Hasta S/ {$this->salario_maximo}";
        }

        return 'A convenir';
    }

    /**
     * Verificar si esta vigente
     */
    public function estaVigente()
    {
        if (in_array($this->estado, ['cerrada', 'finalizada'])) {
            return false;
        }

        if ($this->fecha_cierre && $this->fecha_cierre < now()) {
            return false;
        }

        return true;
    }

    /**
     * URL del PDF de bases
     */
    public function getPdfBasesUrlAttribute()
    {
        if ($this->pdf_bases) {
            return asset('storage/' . $this->pdf_bases);
        }
        return null;
    }

    /**
     * URL del PDF de evaluacion
     */
    public function getPdfEvaluacionUrlAttribute()
    {
        if ($this->pdf_evaluacion) {
            return asset('storage/' . $this->pdf_evaluacion);
        }
        return null;
    }

    /**
     * URL del PDF de ganadores
     */
    public function getPdfGanadoresUrlAttribute()
    {
        if ($this->pdf_ganadores) {
            return asset('storage/' . $this->pdf_ganadores);
        }
        return null;
    }

    /**
     * Verificar si tiene documentos PDF
     */
    public function tieneDocumentos()
    {
        return $this->pdf_bases || $this->pdf_evaluacion || $this->pdf_ganadores;
    }
}
