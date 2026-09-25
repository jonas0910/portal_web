<?php

return [
    'title' => 'Portal Municipal',
    'title_prefix' => '',
    'title_postfix' => '',

    'logo' => '<b>Portal</b> Municipal',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Portal Municipal',

    'usermenu_enabled' => true,
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => true,
    'usermenu_desc' => true,
    'usermenu_profile_url' => 'admin/profile',

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_register' => false,
    'classes_auth_login' => false,
    'classes_auth_title' => '',

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-nav',
    'classes_topnav_container' => 'container',

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    'use_ico_only' => false,
    'use_fullscreen' => false,
    'use_rounded' => false,
    'sidebar_focus_auto_expand' => false,

    'paths' => [
        'js' => [
            'public/vendor/adminlte/dist/js/adminlte.min.js',
        ],
        'css' => [
            'public/vendor/adminlte/dist/css/adminlte.min.css',
        ],
        'plugins' => [],
    ],

    'plugins' => [
        'Datatables' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],

    'livewire' => false,

    'menu' => [
        [
            'text' => 'Dashboard',
            'url' => 'admin',
            'icon' => 'fas fa-tachometer-alt',
        ],
        [
            'text' => 'Gestión',
            'icon' => 'fas fa-cogs',
            'submenu' => [
                [
                    'text' => 'Funcionarios',
                    'url' => 'admin/notarios',
                    'icon' => 'fas fa-user-tie',
                ],
                [
                    'text' => 'Documentos',
                    'url' => 'admin/documentos',
                    'icon' => 'fas fa-file-contract',
                ],
                [
                    'text' => 'Servicios',
                    'url' => 'admin/servicios',
                    'icon' => 'fas fa-cogs',
                ],
                [
                    'text' => 'Noticias',
                    'url' => 'admin/noticias',
                    'icon' => 'fas fa-newspaper',
                ],
                [
                    'text' => 'Eventos',
                    'url' => 'admin/eventos',
                    'icon' => 'fas fa-calendar-alt',
                ],
                [
                    'text' => 'Proyectos',
                    'url' => 'admin/proyectos',
                    'icon' => 'fas fa-project-diagram',
                ],
                [
                    'text' => 'Usuarios',
                    'url' => 'admin/usuarios',
                    'icon' => 'fas fa-users',
                ],
                [
                    'text' => 'Categorías',
                    'url' => 'admin/categorias',
                    'icon' => 'fas fa-folder',
                ],
                [
                    'text' => 'Contactos',
                    'url' => 'admin/contactos',
                    'icon' => 'fas fa-envelope',
                ],
            ],
        ],
        [
            'text' => 'Recursos Humanos',
            'icon' => 'fas fa-users text-warning',
            'submenu' => [
                [
                    'text' => 'Ofertas de Empleo',
                    'url' => 'admin/ofertas',
                    'icon' => 'fas fa-briefcase text-info',
                ],
                [
                    'text' => 'Postulaciones',
                    'url' => 'admin/postulaciones',
                    'icon' => 'fas fa-user-check text-success',
                ],
            ],
        ],
        [
            'text' => 'Marketing',
            'icon' => 'fas fa-bullhorn text-danger',
            'submenu' => [
                [
                    'text' => 'Testimonios',
                    'url' => 'admin/testimonios',
                    'icon' => 'fas fa-quote-left text-primary',
                ],
                [
                    'text' => 'Call to Actions',
                    'url' => 'admin/ctas',
                    'icon' => 'fas fa-mouse-pointer text-warning',
                ],
            ],
        ],
        [
            'text' => 'Gestión de Contenido',
            'icon' => 'fas fa-edit',
            'submenu' => [
                [
                    'text' => 'Dashboard',
                    'url' => 'admin/contenido',
                    'icon' => 'fas fa-tachometer-alt',
                ],
                [
                    'text' => 'Páginas',
                    'url' => 'admin/contenido/paginas',
                    'icon' => 'fas fa-file-alt',
                ],
                [
                    'text' => 'Menús',
                    'url' => 'admin/contenido/menus',
                    'icon' => 'fas fa-bars',
                ],
                [
                    'text' => 'Banners',
                    'url' => 'admin/contenido/banners',
                    'icon' => 'fas fa-image',
                ],
                [
                    'text' => 'Fotos Aniversario',
                    'url' => 'admin/contenido/fotos-aniversario',
                    'icon' => 'fas fa-birthday-cake',
                ],
                [
                    'text' => 'Accesos Directos',
                    'url' => 'admin/accesos-directos',
                    'icon' => 'fas fa-external-link-alt text-info',
                ],
                [
                    'text' => 'Plantillas',
                    'url' => 'admin/plantillas',
                    'icon' => 'fas fa-layer-group',
                ],
                [
                    'text' => 'Temas',
                    'url' => 'admin/temas',
                    'icon' => 'fas fa-palette',
                ],
                [
                    'text' => 'Configuración Sitio',
                    'url' => 'admin/contenido/configuracion',
                    'icon' => 'fas fa-sliders-h',
                ],
            ],
        ],
        [
            'text' => 'Reportes',
            'icon' => 'fas fa-chart-bar',
            'submenu' => [
                [
                    'text' => 'Estadísticas',
                    'url' => 'admin/reportes/estadisticas',
                    'icon' => 'fas fa-chart-pie',
                ],
                [
                    'text' => 'Funcionarios',
                    'url' => 'admin/reportes/notarios',
                    'icon' => 'fas fa-user-tie',
                ],
                [
                    'text' => 'Documentos',
                    'url' => 'admin/reportes/documentos',
                    'icon' => 'fas fa-file-contract',
                ],
                [
                    'text' => 'Exportar',
                    'url' => 'admin/reportes/exportar',
                    'icon' => 'fas fa-download',
                ],
            ],
        ],
        [
            'text' => 'Configuración',
            'url' => 'admin/configuracion',
            'icon' => 'fas fa-cog',
        ],
        [
            'text' => 'Portal Público',
            'url' => '/',
            'icon' => 'fas fa-globe',
            'target' => '_blank',
        ],
    ],

    'navbar' => [
        [
            'text' => 'Dashboard',
            'url' => 'admin',
            'icon' => 'fas fa-tachometer-alt',
        ],
        [
            'text' => 'Funcionarios',
            'url' => 'admin/notarios',
            'icon' => 'fas fa-user-tie',
        ],
        [
            'text' => 'Documentos',
            'url' => 'admin/documentos',
            'icon' => 'fas fa-file-contract',
        ],
        [
            'text' => 'Servicios',
            'url' => 'admin/servicios',
            'icon' => 'fas fa-cogs',
        ],
        [
            'text' => 'Reportes',
            'icon' => 'fas fa-chart-bar',
            'submenu' => [
                [
                    'text' => 'Estadísticas',
                    'url' => 'admin/reportes/estadisticas',
                    'icon' => 'fas fa-chart-pie',
                ],
                [
                    'text' => 'Funcionarios',
                    'url' => 'admin/reportes/notarios',
                    'icon' => 'fas fa-user-tie',
                ],
                [
                    'text' => 'Documentos',
                    'url' => 'admin/reportes/documentos',
                    'icon' => 'fas fa-file-contract',
                ],
            ],
        ],
        [
            'text' => 'Configuración',
            'url' => 'admin/configuracion',
            'icon' => 'fas fa-cog',
        ],
        [
            'text' => 'Portal Público',
            'url' => '/',
            'icon' => 'fas fa-globe',
            'target' => '_blank',
        ],
    ],

    'usermenu' => [
        [
            'text' => 'Perfil',
            'url' => 'admin/profile',
            'icon' => 'fas fa-user',
        ],
        [
            'text' => 'Configuración',
            'url' => 'admin/configuracion',
            'icon' => 'fas fa-cog',
        ],
        [
            'text' => 'Ayuda',
            'url' => 'admin/help',
            'icon' => 'fas fa-question-circle',
        ],
        [
            'text' => 'Cerrar Sesión',
            'url' => 'logout',
            'icon' => 'fas fa-sign-out-alt',
        ],
    ],
];
