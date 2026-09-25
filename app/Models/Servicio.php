<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servicio extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'gc_servicios';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'duracion',
        'requisitos',
        'procedimiento',
        'activo',
        'categoria',
        'icono',
        'imagen',
        'orden',
        'url'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'precio' => 'decimal:2',
        'requisitos' => 'array',
        'procedimiento' => 'array',
    ];


    /**
     * Scope para servicios activos
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope para servicios por categoría
     */
    public function scopePorCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    /**
     * Accessor para precio formateado
     */
    public function getPrecioFormateadoAttribute()
    {
        $precio = is_numeric($this->precio) ? $this->precio : 0;
        return 'S/ ' . number_format($precio, 2);
    }

    /**
     * Accessor para duración formateada
     */
    public function getDuracionFormateadaAttribute()
    {
        $duracion = is_numeric($this->duracion) ? (int)$this->duracion : 0;
        
        if ($duracion <= 0) {
            return 'Consultar tiempo';
        }
        
        if ($duracion < 60) {
            return $duracion . ' minutos';
        } else {
            $horas = floor($duracion / 60);
            $minutos = $duracion % 60;
            return $horas . 'h ' . $minutos . 'm';
        }
    }

    /**
     * Iconos alusivos a servicios municipales (estilo Pocollay y similares).
     * Clase Font Awesome => descripción para selector en admin.
     */
    /**
     * Iconos alusivos a servicios municipales (referencia: munidepocollay.gob.pe/serviciosPanel).
     */
    public static function iconosAlusivos(): array
    {
        return [
            '' => '— Sin icono —',
            'fas fa-users' => 'Consejo de Coordinación Local Distrital',
            'fas fa-map-marked-alt' => 'Planeamiento Urbano y Catastro',
            'fas fa-heartbeat' => 'Lucha contra la Anemia',
            'fas fa-child' => 'CIAM / Niños y adolescentes',
            'fas fa-wheelchair' => 'OMAPED / Discapacidad',
            'fas fa-file-contract' => 'Saneamiento Físico Legal',
            'fas fa-broom' => 'Limpieza Pública',
            'fas fa-shield-alt' => 'CODISEC',
            'fas fa-id-card' => 'SISFOH / Padrón Nominal',
            'fas fa-truck' => 'Equipo Mecánico',
            'fas fa-exclamation-triangle' => 'Gestión de Riesgos de Desastres',
            'fas fa-user-shield' => 'Seguridad Ciudadana',
            'fas fa-monument' => 'Cementerio Municipal',
            'fas fa-briefcase' => 'PROCOMPITE',
            'fas fa-home' => 'Techo Propio',
            'fas fa-glass-martini-alt' => 'Vaso de Leche',
            'fas fa-hands-helping' => 'DEMUNA',
            'fas fa-inbox' => 'Mesa de Partes Virtual',
            'fas fa-book' => 'Normativas',
            'fas fa-bullhorn' => 'Convocatorias',
            'fas fa-file-pdf' => 'Formatos',
            'fas fa-list-alt' => 'Padrón Nominal',
            'fas fa-calendar-alt' => 'Agenda Oficial',
            'fas fa-envelope-open-text' => 'Correo Institucional',
            'fas fa-folder-open' => 'Documentos de Interés',
            'fas fa-comment-dots' => 'Buzón de Sugerencias',
            'fas fa-book-open' => 'Libro de Reclamaciones',
            'fas fa-phone-alt' => 'Directorio telefónico',
            'fas fa-landmark' => 'Tributos Municipales',
            'fas fa-balance-scale' => 'Legal / Notarial',
            'fas fa-gavel' => 'Registral / Judicial',
            'fas fa-cogs' => 'Servicios generales',
            'fas fa-file-alt' => 'Documentación',
            'fas fa-envelope' => 'Correo / Mesa de partes',
        ];
    }

    /**
     * Icono a mostrar: el guardado o uno alusivo según el nombre del servicio.
     */
    public function getIconoAlusivoAttribute(): string
    {
        if (!empty($this->icono)) {
            return $this->icono;
        }
        $n = mb_strtolower($this->nombre ?? '');
        $map = [
            'consejo' => 'fas fa-users',
            'coordinacion' => 'fas fa-users',
            'planeamiento' => 'fas fa-map-marked-alt',
            'catastro' => 'fas fa-map-marked-alt',
            'urbano' => 'fas fa-map-marked-alt',
            'anemia' => 'fas fa-heartbeat',
            'ciam' => 'fas fa-child',
            'omaped' => 'fas fa-wheelchair',
            'discapacidad' => 'fas fa-wheelchair',
            'saneamiento' => 'fas fa-file-contract',
            'limpieza' => 'fas fa-broom',
            'codisec' => 'fas fa-shield-alt',
            'sisfoh' => 'fas fa-id-card',
            'padrón' => 'fas fa-id-card',
            'padron' => 'fas fa-id-card',
            'equipo mecánico' => 'fas fa-truck',
            'equipo mecanico' => 'fas fa-truck',
            'riesgos' => 'fas fa-exclamation-triangle',
            'desastres' => 'fas fa-exclamation-triangle',
            'defensa civil' => 'fas fa-exclamation-triangle',
            'seguridad ciudadana' => 'fas fa-user-shield',
            'cementerio' => 'fas fa-monument',
            'procompite' => 'fas fa-briefcase',
            'techo propio' => 'fas fa-home',
            'vivienda' => 'fas fa-home',
            'vaso de leche' => 'fas fa-glass-martini-alt',
            'demuna' => 'fas fa-hands-helping',
            'defensoría' => 'fas fa-hands-helping',
            'defensoria' => 'fas fa-hands-helping',
            'mesa de partes' => 'fas fa-inbox',
            'normativas' => 'fas fa-book',
            'convocatoria' => 'fas fa-bullhorn',
            'formatos' => 'fas fa-file-pdf',
            'agenda oficial' => 'fas fa-calendar-alt',
            'correo institucional' => 'fas fa-envelope-open-text',
            'documentos de interés' => 'fas fa-folder-open',
            'buzón' => 'fas fa-comment-dots',
            'buzon' => 'fas fa-comment-dots',
            'sugerencia' => 'fas fa-comment-dots',
            'libro de reclamaciones' => 'fas fa-book-open',
            'reclamaciones' => 'fas fa-book-open',
            'directorio' => 'fas fa-phone-alt',
            'tributo' => 'fas fa-landmark',
            'tributos' => 'fas fa-landmark',
            'notarial' => 'fas fa-balance-scale',
        ];
        foreach ($map as $keyword => $icon) {
            if (str_contains($n, $keyword)) {
                return $icon;
            }
        }
        return 'fas fa-cogs';
    }
}
