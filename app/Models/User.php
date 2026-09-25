<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'apellidos',
        'email',
        'password',
        'activo',
        'avatar',
        'telefono',
        'direccion',
        'area_principal_id',
        'cargo'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'activo' => 'boolean',
    ];

    /**
     * Relación con notario
     */
    public function notario()
    {
        return $this->hasOne(Notario::class);
    }

    /**
     * Área principal del usuario
     */
    public function areaPrincipal()
    {
        return $this->belongsTo(AreaTramite::class, 'area_principal_id');
    }

    /**
     * Área a mostrar (para vistas): área principal o la primera de las áreas asignadas.
     * Evita mostrar "Sin área" cuando el usuario tiene áreas asignadas pero area_principal_id vacío.
     */
    public function areaParaMostrar()
    {
        if ($this->area_principal_id && $this->relationLoaded('areaPrincipal') && $this->areaPrincipal) {
            return $this->areaPrincipal;
        }
        if ($this->area_principal_id) {
            $area = \App\Models\AreaTramite::find($this->area_principal_id);
            if ($area) {
                return $area;
            }
        }
        return $this->areas()->first();
    }

    /**
     * Áreas asignadas al usuario (muchos a muchos)
     */
    public function areas()
    {
        return $this->belongsToMany(AreaTramite::class, 'area_tramite_user')
                    ->withPivot('es_responsable', 'puede_recibir', 'puede_derivar', 'puede_atender', 'activo')
                    ->withTimestamps();
    }

    /**
     * Áreas donde el usuario es responsable
     */
    public function areasResponsable()
    {
        return $this->areas()->wherePivot('es_responsable', true);
    }

    /**
     * Indica si el usuario es responsable de al menos un área (pivot es_responsable).
     * Los responsables de área tienen acceso a todos los menús de trámites de su área
     * excepto el menú padre "Administración".
     */
    public function esResponsableDeAlgunaArea()
    {
        return $this->areas()->wherePivot('es_responsable', true)->exists();
    }

    /**
     * Áreas activas del usuario
     */
    public function areasActivas()
    {
        return $this->areas()->wherePivot('activo', true);
    }

    /**
     * Verificar si el usuario pertenece a un área
     */
    public function perteneceAlArea($areaId)
    {
        return $this->areas()->where('areas_tramite.id', $areaId)->exists();
    }

    /**
     * Verificar si el usuario puede recibir trámites en un área
     */
    public function puedeRecibirEnArea($areaId)
    {
        return $this->areas()
            ->where('areas_tramite.id', $areaId)
            ->wherePivot('puede_recibir', true)
            ->wherePivot('activo', true)
            ->exists();
    }

    /**
     * Verificar si el usuario puede atender trámites en un área
     */
    public function puedeAtenderEnArea($areaId)
    {
        return $this->areas()
            ->where('areas_tramite.id', $areaId)
            ->wherePivot('puede_atender', true)
            ->wherePivot('activo', true)
            ->exists();
    }

    /**
     * Scope para usuarios activos
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Verificar si el usuario es administrador
     */
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    /**
     * Alias de isAdmin() para compatibilidad
     */
    public function esAdmin()
    {
        return $this->isAdmin();
    }

    /**
     * Verificar si el usuario es notario
     */
    public function isNotario()
    {
        return $this->hasRole('notario');
    }

    /**
     * Verificar si el usuario es cliente
     */
    public function isCliente()
    {
        return $this->hasRole('cliente');
    }

    /**
     * Verificar si el usuario es administrador de trámites
     */
    public function isAdminTramites()
    {
        return $this->hasRole('admin') || $this->hasRole('admin_tramites');
    }

    /**
     * Verificar si el usuario puede ver todos los trámites
     */
    public function puedeVerTodosTramites()
    {
        return $this->hasPermissionTo('tramites.ver_todos') || $this->isAdmin();
    }

    /**
     * Verificar si el usuario puede gestionar áreas de trámites
     */
    public function puedeGestionarAreasTramites()
    {
        return $this->hasPermissionTo('tramites.gestionar_areas') || $this->isAdminTramites();
    }

    /**
     * Verificar si el usuario puede gestionar tipos de trámites
     */
    public function puedeGestionarTiposTramites()
    {
        return $this->hasPermissionTo('tramites.gestionar_tipos') || $this->isAdminTramites();
    }

    /**
     * Verificar si el usuario puede asignar usuarios a áreas
     */
    public function puedeGestionarUsuariosTramites()
    {
        return $this->hasPermissionTo('tramites.gestionar_usuarios') || $this->isAdminTramites();
    }

    /**
     * Métodos para AdminLTE
     */
    
    /**
     * URL del perfil del usuario para AdminLTE
     */
    public function adminlte_profile_url()
    {
        return route('admin.profile');
    }

    /**
     * Descripción del usuario para AdminLTE
     */
    public function adminlte_desc()
    {
        $roles = $this->roles->pluck('name')->toArray();
        $roleText = !empty($roles) ? implode(', ', $roles) : 'Usuario';
        
        return $roleText . ' - ' . $this->email;
    }

    /**
     * Imagen del usuario para AdminLTE
     */
    public function adminlte_image()
    {
        // Si tiene avatar, usar el avatar
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        
        // Si es notario y tiene foto, usar la foto del notario
        if ($this->notario && $this->notario->foto) {
            return asset('storage/' . $this->notario->foto);
        }
        
        // Usar imagen por defecto
        return asset('vendor/adminlte/dist/img/default-user.png');
    }

    /**
     * Nombre completo del usuario para AdminLTE
     */
    public function adminlte_name()
    {
        return $this->name;
    }
}
