<?php

return [
    'menu' => [
        [
            'text' => 'Dashboard',
            'url' => 'admin',
            'icon' => 'fas fa-tachometer-alt',
            'can' => 'ver-dashboard',
        ],
        [
            'text' => 'Gestión',
            'icon' => 'fas fa-cogs',
            'submenu' => [
                [
                    'text' => 'Funcionarios',
                    'url' => 'admin/notarios',
                    'icon' => 'fas fa-user-tie',
                    'can' => 'ver-notarios',
                ],
                [
                    'text' => 'Documentos',
                    'url' => 'admin/documentos',
                    'icon' => 'fas fa-file-contract',
                    'can' => 'ver-documentos',
                ],
                [
                    'text' => 'Servicios',
                    'url' => 'admin/servicios',
                    'icon' => 'fas fa-handshake',
                    'can' => 'ver-servicios',
                ],
                [
                    'text' => 'Categorías',
                    'url' => 'admin/categorias',
                    'icon' => 'fas fa-tags',
                    'can' => 'ver-categorias',
                ],
            ],
        ],
        [
            'text' => 'Usuarios',
            'icon' => 'fas fa-users',
            'submenu' => [
                [
                    'text' => 'Lista de Usuarios',
                    'url' => 'admin/usuarios',
                    'icon' => 'fas fa-list',
                    'can' => 'ver-usuarios',
                ],
                [
                    'text' => 'Roles y Permisos',
                    'url' => 'admin/roles',
                    'icon' => 'fas fa-shield-alt',
                    'can' => 'ver-usuarios',
                ],
                [
                    'text' => 'Actividad de Usuarios',
                    'url' => 'admin/actividad',
                    'icon' => 'fas fa-history',
                    'can' => 'ver-usuarios',
                ],
            ],
        ],
        [
            'text' => 'Comunicación',
            'icon' => 'fas fa-comments',
            'submenu' => [
                [
                    'text' => 'Mensajes de Contacto',
                    'url' => 'admin/contactos',
                    'icon' => 'fas fa-envelope',
                    'can' => 'ver-contactos',
                ],
                [
                    'text' => 'Notificaciones',
                    'url' => 'admin/notificaciones',
                    'icon' => 'fas fa-bell',
                    'can' => 'ver-contactos',
                ],
                [
                    'text' => 'Newsletter',
                    'url' => 'admin/newsletter',
                    'icon' => 'fas fa-newspaper',
                    'can' => 'ver-contactos',
                ],
            ],
        ],
        [
            'text' => 'Reportes',
            'icon' => 'fas fa-chart-bar',
            'submenu' => [
                [
                    'text' => 'Estadísticas Generales',
                    'url' => 'admin/reportes/estadisticas',
                    'icon' => 'fas fa-chart-pie',
                    'can' => 'ver-estadisticas',
                ],
                [
                    'text' => 'Reportes de Funcionarios',
                    'url' => 'admin/reportes/notarios',
                    'icon' => 'fas fa-user-tie',
                    'can' => 'ver-estadisticas',
                ],
                [
                    'text' => 'Reportes de Documentos',
                    'url' => 'admin/reportes/documentos',
                    'icon' => 'fas fa-file-contract',
                    'can' => 'ver-estadisticas',
                ],
                [
                    'text' => 'Exportar Datos',
                    'url' => 'admin/reportes/exportar',
                    'icon' => 'fas fa-download',
                    'can' => 'ver-estadisticas',
                ],
            ],
        ],
        [
            'text' => 'Sitio Web',
            'icon' => 'fas fa-globe',
            'submenu' => [
                [
                    'text' => 'Página Principal',
                    'url' => '/',
                    'icon' => 'fas fa-home',
                    'target' => '_blank',
                ],
                [
                    'text' => 'Directorio de Funcionarios',
                    'url' => '/notarios',
                    'icon' => 'fas fa-user-tie',
                    'target' => '_blank',
                ],
                [
                    'text' => 'Servicios Públicos',
                    'url' => '/servicios',
                    'icon' => 'fas fa-handshake',
                    'target' => '_blank',
                ],
                [
                    'text' => 'Documentos Públicos',
                    'url' => '/documentos',
                    'icon' => 'fas fa-file-contract',
                    'target' => '_blank',
                ],
            ],
        ],
        [
            'text' => 'Configuración',
            'icon' => 'fas fa-cog',
            'submenu' => [
                [
                    'text' => 'Configuración General',
                    'url' => 'admin/configuracion',
                    'icon' => 'fas fa-cogs',
                    'can' => 'ver-configuracion',
                ],
                [
                    'text' => 'Configuración de Email',
                    'url' => 'admin/configuracion/email',
                    'icon' => 'fas fa-envelope',
                    'can' => 'ver-configuracion',
                ],
                [
                    'text' => 'Configuración de Archivos',
                    'url' => 'admin/configuracion/archivos',
                    'icon' => 'fas fa-folder',
                    'can' => 'ver-configuracion',
                ],
                [
                    'text' => 'Backup y Restauración',
                    'url' => 'admin/configuracion/backup',
                    'icon' => 'fas fa-database',
                    'can' => 'ver-configuracion',
                ],
            ],
        ],
    ],
];
