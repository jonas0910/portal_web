<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Portal Municipal Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for the Portal Municipal system.
    | You can customize various aspects of the system here.
    |
    */

    'app' => [
        'name' => 'Portal Municipal',
        'version' => '1.0.0',
        'description' => 'Sistema integral para la Municipalidad',
    ],

    'funcionarios' => [
        'foto_max_size' => 2048, // KB
        'foto_allowed_types' => ['jpeg', 'png', 'jpg', 'gif'],
        'especialidades' => [
            'Derecho Inmobiliario',
            'Derecho de Familia',
            'Derecho Comercial',
            'Derecho Civil',
            'Derecho Administrativo',
            'Derecho Laboral',
            'Derecho Penal',
            'Derecho Tributario',
        ],
    ],

    'documentos' => [
        'max_size' => 10240, // KB
        'allowed_types' => ['pdf', 'doc', 'docx'],
        'tipos' => [
            'Escritura Pública',
            'Poder',
            'Contrato',
            'Testamento',
            'Certificación',
            'Protocolo',
            'Acta',
            'Declaración',
        ],
    ],

    'servicios' => [
        'categorias' => [
            'Inmobiliario',
            'Representación',
            'Sucesiones',
            'Comercial',
            'Familia',
            'Laboral',
            'Otros',
        ],
        'iconos' => [
            'fas fa-home' => 'Inmobiliario',
            'fas fa-user-tie' => 'Representación',
            'fas fa-scroll' => 'Sucesiones',
            'fas fa-briefcase' => 'Comercial',
            'fas fa-heart' => 'Familia',
            'fas fa-users' => 'Laboral',
            'fas fa-file-contract' => 'Documentos',
            'fas fa-handshake' => 'Servicios',
        ],
    ],

    'contacto' => [
        'email' => 'contacto@municipalidad.gob.pe',
        'telefono' => '+51 1 234-5678',
        'direccion' => 'Av. Principal 123, Lima',
        'horario' => 'Lunes a Viernes: 8:00 AM - 5:00 PM',
    ],

    'pagination' => [
        'per_page' => 25,
        'per_page_options' => [10, 25, 50, 100],
    ],

    'cache' => [
        'ttl' => 3600, // 1 hora en segundos
        'prefix' => 'portal_municipal',
    ],

    'backup' => [
        'enabled' => true,
        'schedule' => 'daily',
        'retention_days' => 30,
    ],

    'logs' => [
        'activity' => true,
        'retention_days' => 90,
    ],
];