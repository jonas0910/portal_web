<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ArreglarTablas extends Command
{
    protected $signature = 'db:arreglar-tablas';
    protected $description = 'Arregla y crea TODAS las tablas faltantes del sistema';

    public function handle()
    {
        $this->info('Creando todas las tablas del sistema...');
        $this->newLine();

        try {
            // Tabla users
            DB::statement("
                CREATE TABLE IF NOT EXISTS `users` (
                  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                  `name` varchar(255) NOT NULL,
                  `email` varchar(255) NOT NULL,
                  `email_verified_at` timestamp NULL DEFAULT NULL,
                  `password` varchar(255) NOT NULL,
                  `activo` tinyint(1) NOT NULL DEFAULT '1',
                  `remember_token` varchar(100) DEFAULT NULL,
                  `created_at` timestamp NULL DEFAULT NULL,
                  `updated_at` timestamp NULL DEFAULT NULL,
                  PRIMARY KEY (`id`),
                  UNIQUE KEY `users_email_unique` (`email`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
            $this->info('✓ Tabla users creada');

            // Tabla roles
            DB::statement("
                CREATE TABLE IF NOT EXISTS `roles` (
                  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                  `name` varchar(255) NOT NULL,
                  `guard_name` varchar(255) NOT NULL,
                  `created_at` timestamp NULL DEFAULT NULL,
                  `updated_at` timestamp NULL DEFAULT NULL,
                  PRIMARY KEY (`id`),
                  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
            $this->info('✓ Tabla roles creada');

            // Tabla permissions
            DB::statement("
                CREATE TABLE IF NOT EXISTS `permissions` (
                  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                  `name` varchar(255) NOT NULL,
                  `guard_name` varchar(255) NOT NULL,
                  `created_at` timestamp NULL DEFAULT NULL,
                  `updated_at` timestamp NULL DEFAULT NULL,
                  PRIMARY KEY (`id`),
                  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
            $this->info('✓ Tabla permissions creada');

            // Tabla model_has_roles
            DB::statement("
                CREATE TABLE IF NOT EXISTS `model_has_roles` (
                  `role_id` bigint(20) unsigned NOT NULL,
                  `model_type` varchar(255) NOT NULL,
                  `model_id` bigint(20) unsigned NOT NULL,
                  PRIMARY KEY (`role_id`,`model_id`,`model_type`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
            $this->info('✓ Tabla model_has_roles creada');

            // Tabla notarios
            DB::statement("
                CREATE TABLE IF NOT EXISTS `notarios` (
                  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                  `nombre` varchar(255) NOT NULL,
                  `apellidos` varchar(255) NOT NULL,
                  `email` varchar(255) NOT NULL,
                  `telefono` varchar(255) DEFAULT NULL,
                  `direccion` text,
                  `distrito` varchar(255) DEFAULT NULL,
                  `provincia` varchar(255) DEFAULT NULL,
                  `departamento` varchar(255) DEFAULT NULL,
                  `numero_colegiatura` varchar(255) NOT NULL,
                  `fecha_colegiatura` date NOT NULL,
                  `especialidad` varchar(255) DEFAULT NULL,
                  `biografia` text,
                  `foto` varchar(255) DEFAULT NULL,
                  `activo` tinyint(1) NOT NULL DEFAULT '1',
                  `user_id` bigint(20) unsigned DEFAULT NULL,
                  `created_at` timestamp NULL DEFAULT NULL,
                  `updated_at` timestamp NULL DEFAULT NULL,
                  `deleted_at` timestamp NULL DEFAULT NULL,
                  PRIMARY KEY (`id`),
                  UNIQUE KEY `notarios_email_unique` (`email`),
                  UNIQUE KEY `notarios_numero_colegiatura_unique` (`numero_colegiatura`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
            $this->info('✓ Tabla notarios creada');

            // Tabla categoria_documentos
            DB::statement("
                CREATE TABLE IF NOT EXISTS `categoria_documentos` (
                  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                  `nombre` varchar(255) NOT NULL,
                  `descripcion` text,
                  `color` varchar(255) NOT NULL DEFAULT '#007bff',
                  `icono` varchar(255) DEFAULT NULL,
                  `activo` tinyint(1) NOT NULL DEFAULT '1',
                  `created_at` timestamp NULL DEFAULT NULL,
                  `updated_at` timestamp NULL DEFAULT NULL,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
            $this->info('✓ Tabla categoria_documentos creada');

            // Tabla documentos
            DB::statement("
                CREATE TABLE IF NOT EXISTS `documentos` (
                  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                  `titulo` varchar(255) NOT NULL,
                  `descripcion` text,
                  `tipo` varchar(255) NOT NULL,
                  `archivo` varchar(255) NOT NULL,
                  `archivo_nombre` varchar(255) NOT NULL,
                  `tamano_archivo` bigint(20) NOT NULL,
                  `publico` tinyint(1) NOT NULL DEFAULT '0',
                  `notario_id` bigint(20) unsigned NOT NULL,
                  `categoria_id` bigint(20) unsigned DEFAULT NULL,
                  `tags` json DEFAULT NULL,
                  `fecha_documento` date NOT NULL,
                  `numero_documento` varchar(255) DEFAULT NULL,
                  `observaciones` text,
                  `created_at` timestamp NULL DEFAULT NULL,
                  `updated_at` timestamp NULL DEFAULT NULL,
                  `deleted_at` timestamp NULL DEFAULT NULL,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
            $this->info('✓ Tabla documentos creada');

            // Tabla servicios
            DB::statement("
                CREATE TABLE IF NOT EXISTS `servicios` (
                  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                  `nombre` varchar(255) NOT NULL,
                  `descripcion` text NOT NULL,
                  `precio` decimal(10,2) NOT NULL DEFAULT '0.00',
                  `duracion` int(11) DEFAULT NULL,
                  `requisitos` json DEFAULT NULL,
                  `procedimiento` json DEFAULT NULL,
                  `activo` tinyint(1) NOT NULL DEFAULT '1',
                  `categoria` varchar(255) DEFAULT NULL,
                  `icono` varchar(255) DEFAULT NULL,
                  `imagen` varchar(255) DEFAULT NULL,
                  `orden` int(11) NOT NULL DEFAULT '0',
                  `created_at` timestamp NULL DEFAULT NULL,
                  `updated_at` timestamp NULL DEFAULT NULL,
                  `deleted_at` timestamp NULL DEFAULT NULL,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
            $this->info('✓ Tabla servicios creada');

            // Tabla contactos
            DB::statement("
                CREATE TABLE IF NOT EXISTS `contactos` (
                  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                  `nombre` varchar(255) NOT NULL,
                  `email` varchar(255) NOT NULL,
                  `telefono` varchar(255) DEFAULT NULL,
                  `asunto` varchar(255) NOT NULL,
                  `mensaje` text NOT NULL,
                  `leido` tinyint(1) NOT NULL DEFAULT '0',
                  `fecha_leido` timestamp NULL DEFAULT NULL,
                  `respuesta` text,
                  `created_at` timestamp NULL DEFAULT NULL,
                  `updated_at` timestamp NULL DEFAULT NULL,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
            $this->info('✓ Tabla contactos creada');

            // Tabla paginas
            DB::statement("
                CREATE TABLE IF NOT EXISTS `paginas` (
                  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                  `titulo` varchar(255) NOT NULL,
                  `slug` varchar(255) NOT NULL,
                  `descripcion` text,
                  `contenido` longtext,
                  `meta_titulo` varchar(255) DEFAULT NULL,
                  `meta_descripcion` text,
                  `meta_keywords` varchar(255) DEFAULT NULL,
                  `imagen_principal` varchar(255) DEFAULT NULL,
                  `imagenes_adicionales` json DEFAULT NULL,
                  `plantilla` varchar(255) NOT NULL DEFAULT 'default',
                  `activa` tinyint(1) NOT NULL DEFAULT '1',
                  `mostrar_en_menu` tinyint(1) NOT NULL DEFAULT '1',
                  `orden` int(11) NOT NULL DEFAULT '0',
                  `tipo` varchar(255) NOT NULL DEFAULT 'pagina',
                  `configuracion` json DEFAULT NULL,
                  `created_at` timestamp NULL DEFAULT NULL,
                  `updated_at` timestamp NULL DEFAULT NULL,
                  `deleted_at` timestamp NULL DEFAULT NULL,
                  PRIMARY KEY (`id`),
                  UNIQUE KEY `paginas_slug_unique` (`slug`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
            $this->info('✓ Tabla paginas creada');

            // Tabla menus
            DB::statement("
                CREATE TABLE IF NOT EXISTS `menus` (
                  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                  `nombre` varchar(255) NOT NULL,
                  `ubicacion` varchar(255) NOT NULL DEFAULT 'principal',
                  `tipo` varchar(255) NOT NULL DEFAULT 'pagina',
                  `url` varchar(255) DEFAULT NULL,
                  `icono` varchar(255) DEFAULT NULL,
                  `target` varchar(255) NOT NULL DEFAULT '_self',
                  `parent_id` int(11) DEFAULT NULL,
                  `orden` int(11) NOT NULL DEFAULT '0',
                  `activo` tinyint(1) NOT NULL DEFAULT '1',
                  `configuracion` json DEFAULT NULL,
                  `created_at` timestamp NULL DEFAULT NULL,
                  `updated_at` timestamp NULL DEFAULT NULL,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
            $this->info('✓ Tabla menus creada');

            // Tabla banners
            DB::statement("
                CREATE TABLE IF NOT EXISTS `banners` (
                  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                  `titulo` varchar(255) NOT NULL,
                  `subtitulo` varchar(500) DEFAULT NULL,
                  `descripcion` text,
                  `imagen` varchar(255) NOT NULL,
                  `imagen_url` varchar(500) DEFAULT NULL,
                  `imagen_movil` varchar(255) DEFAULT NULL,
                  `imagen_movil_url` varchar(500) DEFAULT NULL,
                  `url` varchar(255) DEFAULT NULL,
                  `boton_texto` varchar(255) DEFAULT NULL,
                  `boton_url` varchar(255) DEFAULT NULL,
                  `target` varchar(50) NOT NULL DEFAULT '_self',
                  `posicion` varchar(255) NOT NULL DEFAULT 'principal',
                  `orden` int(11) NOT NULL DEFAULT '0',
                  `activo` tinyint(1) NOT NULL DEFAULT '1',
                  `fecha_inicio` datetime DEFAULT NULL,
                  `fecha_fin` datetime DEFAULT NULL,
                  `configuracion` json DEFAULT NULL,
                  `created_at` timestamp NULL DEFAULT NULL,
                  `updated_at` timestamp NULL DEFAULT NULL,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
            $this->info('✓ Tabla banners creada');

            // Tabla configuracion_sitio
            DB::statement("
                CREATE TABLE IF NOT EXISTS `configuracion_sitio` (
                  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                  `clave` varchar(255) NOT NULL,
                  `valor` text,
                  `tipo` varchar(255) NOT NULL DEFAULT 'texto',
                  `categoria` varchar(255) NOT NULL DEFAULT 'general',
                  `descripcion` text,
                  `activo` tinyint(1) NOT NULL DEFAULT '1',
                  `created_at` timestamp NULL DEFAULT NULL,
                  `updated_at` timestamp NULL DEFAULT NULL,
                  PRIMARY KEY (`id`),
                  UNIQUE KEY `configuracion_sitio_clave_unique` (`clave`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
            $this->info('✓ Tabla configuracion_sitio creada');

            // Tabla cache (corregir si existe con columna incorrecta)
            DB::statement("DROP TABLE IF EXISTS `cache`");
            DB::statement("
                CREATE TABLE `cache` (
                  `key` varchar(255) NOT NULL,
                  `value` mediumtext NOT NULL,
                  `expiration` int(11) NOT NULL,
                  PRIMARY KEY (`key`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
            $this->info('✓ Tabla cache creada/corregida');

            // Tabla cache_locks
            DB::statement("
                CREATE TABLE IF NOT EXISTS `cache_locks` (
                  `key` varchar(255) NOT NULL,
                  `owner` varchar(255) NOT NULL,
                  `expiration` int(11) NOT NULL,
                  PRIMARY KEY (`key`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
            $this->info('✓ Tabla cache_locks creada');

            // Tabla sessions
            DB::statement("
                CREATE TABLE IF NOT EXISTS `sessions` (
                  `id` varchar(255) NOT NULL,
                  `user_id` bigint(20) unsigned DEFAULT NULL,
                  `ip_address` varchar(45) DEFAULT NULL,
                  `user_agent` text,
                  `payload` longtext NOT NULL,
                  `last_activity` int(11) NOT NULL,
                  PRIMARY KEY (`id`),
                  KEY `sessions_user_id_index` (`user_id`),
                  KEY `sessions_last_activity_index` (`last_activity`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
            $this->info('✓ Tabla sessions creada');

            // Tabla password_resets
            DB::statement("
                CREATE TABLE IF NOT EXISTS `password_resets` (
                  `email` varchar(255) NOT NULL,
                  `token` varchar(255) NOT NULL,
                  `created_at` timestamp NULL DEFAULT NULL,
                  KEY `password_resets_email_index` (`email`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
            $this->info('✓ Tabla password_resets creada');

            // Tabla temas
            DB::statement("
                CREATE TABLE IF NOT EXISTS `temas` (
                  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                  `nombre` varchar(255) NOT NULL,
                  `slug` varchar(255) NOT NULL,
                  `descripcion` text,
                  `preview` varchar(255) DEFAULT NULL,
                  `color_primario` varchar(255) NOT NULL DEFAULT '#007bff',
                  `color_secundario` varchar(255) NOT NULL DEFAULT '#6c757d',
                  `color_acento` varchar(255) NOT NULL DEFAULT '#28a745',
                  `color_fondo` varchar(255) DEFAULT '#ffffff',
                  `color_texto` varchar(255) DEFAULT '#212529',
                  `fuente_principal` varchar(255) DEFAULT 'Roboto',
                  `fuente_secundaria` varchar(255) DEFAULT 'Open Sans',
                  `tamano_fuente` varchar(255) DEFAULT '16px',
                  `estilo_navbar` varchar(255) NOT NULL DEFAULT 'fixed',
                  `estilo_footer` varchar(255) DEFAULT 'default',
                  `mostrar_breadcrumbs` tinyint(1) NOT NULL DEFAULT '1',
                  `ancho_contenedor` varchar(255) NOT NULL DEFAULT 'container',
                  `configuracion` json DEFAULT NULL,
                  `activo` tinyint(1) NOT NULL DEFAULT '0',
                  `predeterminado` tinyint(1) NOT NULL DEFAULT '0',
                  `created_at` timestamp NULL DEFAULT NULL,
                  `updated_at` timestamp NULL DEFAULT NULL,
                  PRIMARY KEY (`id`),
                  UNIQUE KEY `temas_slug_unique` (`slug`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
            $this->info('✓ Tabla temas creada');

            // Tabla citas
            DB::statement("
                CREATE TABLE IF NOT EXISTS `citas` (
                  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                  `titulo` varchar(255) NOT NULL,
                  `descripcion` text,
                  `notario_id` bigint(20) unsigned DEFAULT NULL,
                  `cliente_nombre` varchar(255) NOT NULL,
                  `cliente_email` varchar(255) DEFAULT NULL,
                  `cliente_telefono` varchar(255) DEFAULT NULL,
                  `fecha_inicio` datetime NOT NULL,
                  `fecha_fin` datetime DEFAULT NULL,
                  `tipo` varchar(255) NOT NULL DEFAULT 'consulta',
                  `estado` varchar(255) NOT NULL DEFAULT 'pendiente',
                  `color` varchar(255) NOT NULL DEFAULT '#007bff',
                  `notas` text,
                  `recordatorio_enviado` tinyint(1) NOT NULL DEFAULT '0',
                  `created_at` timestamp NULL DEFAULT NULL,
                  `updated_at` timestamp NULL DEFAULT NULL,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
            $this->info('✓ Tabla citas creada');

            // Tabla eventos
            DB::statement("
                CREATE TABLE IF NOT EXISTS `eventos` (
                  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                  `titulo` varchar(255) NOT NULL,
                  `descripcion` text,
                  `fecha_inicio` datetime NOT NULL,
                  `fecha_fin` datetime DEFAULT NULL,
                  `todo_el_dia` tinyint(1) NOT NULL DEFAULT '0',
                  `tipo` varchar(255) NOT NULL DEFAULT 'general',
                  `ubicacion` varchar(255) DEFAULT NULL,
                  `color` varchar(255) NOT NULL DEFAULT '#007bff',
                  `participantes` json DEFAULT NULL,
                  `publico` tinyint(1) NOT NULL DEFAULT '0',
                  `created_at` timestamp NULL DEFAULT NULL,
                  `updated_at` timestamp NULL DEFAULT NULL,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
            $this->info('✓ Tabla eventos creada');

            // Tabla notificaciones
            DB::statement("
                CREATE TABLE IF NOT EXISTS `notificaciones` (
                  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                  `user_id` bigint(20) unsigned NOT NULL,
                  `tipo` varchar(255) NOT NULL,
                  `titulo` varchar(255) NOT NULL,
                  `mensaje` text NOT NULL,
                  `icono` varchar(255) DEFAULT NULL,
                  `enlace` varchar(255) DEFAULT NULL,
                  `leida` tinyint(1) NOT NULL DEFAULT '0',
                  `fecha_leida` datetime DEFAULT NULL,
                  `datos_adicionales` json DEFAULT NULL,
                  `created_at` timestamp NULL DEFAULT NULL,
                  `updated_at` timestamp NULL DEFAULT NULL,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
            $this->info('✓ Tabla notificaciones creada');

            // Tabla plantillas
            DB::statement("
                CREATE TABLE IF NOT EXISTS `plantillas` (
                  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                  `nombre` varchar(255) NOT NULL,
                  `slug` varchar(255) NOT NULL,
                  `categoria` varchar(255) NOT NULL DEFAULT 'basica',
                  `descripcion` text,
                  `vista` varchar(255) NOT NULL,
                  `icono` varchar(255) DEFAULT 'fas fa-file-alt',
                  `preview` varchar(255) DEFAULT NULL,
                  `componentes` json DEFAULT NULL,
                  `campos_personalizados` json DEFAULT NULL,
                  `configuracion` json DEFAULT NULL,
                  `permite_sidebar` tinyint(1) NOT NULL DEFAULT '0',
                  `permite_galeria` tinyint(1) NOT NULL DEFAULT '0',
                  `permite_tablas` tinyint(1) NOT NULL DEFAULT '0',
                  `permite_formularios` tinyint(1) NOT NULL DEFAULT '0',
                  `es_dinamica` tinyint(1) NOT NULL DEFAULT '0',
                  `activa` tinyint(1) NOT NULL DEFAULT '1',
                  `orden` int(11) NOT NULL DEFAULT '0',
                  `nivel` varchar(255) NOT NULL DEFAULT 'basico',
                  `created_at` timestamp NULL DEFAULT NULL,
                  `updated_at` timestamp NULL DEFAULT NULL,
                  `deleted_at` timestamp NULL DEFAULT NULL,
                  PRIMARY KEY (`id`),
                  UNIQUE KEY `plantillas_slug_unique` (`slug`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
            $this->info('✓ Tabla plantillas creada');

            // Tabla postulaciones
            DB::statement("
                CREATE TABLE IF NOT EXISTS `postulaciones` (
                  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                  `puesto` varchar(255) NOT NULL,
                  `nombres` varchar(255) NOT NULL,
                  `apellidos` varchar(255) NOT NULL,
                  `email` varchar(255) NOT NULL,
                  `telefono` varchar(20) NOT NULL,
                  `ciudad` varchar(255) NOT NULL,
                  `experiencia` varchar(255) DEFAULT NULL,
                  `formacion` varchar(255) NOT NULL,
                  `cv_path` varchar(255) DEFAULT NULL,
                  `carta_presentacion` text,
                  `estado` enum('pendiente','en_revision','preseleccionado','rechazado','aceptado') NOT NULL DEFAULT 'pendiente',
                  `notas_internas` text,
                  `ip_address` varchar(45) DEFAULT NULL,
                  `created_at` timestamp NULL DEFAULT NULL,
                  `updated_at` timestamp NULL DEFAULT NULL,
                  `deleted_at` timestamp NULL DEFAULT NULL,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
            $this->info('✓ Tabla postulaciones creada');

            // Tabla ofertas_empleo
            DB::statement("
                CREATE TABLE IF NOT EXISTS `ofertas_empleo` (
                  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                  `titulo` varchar(255) NOT NULL,
                  `slug` varchar(255) NOT NULL UNIQUE,
                  `estado` enum('abierto','por_cerrar','cerrado') NOT NULL DEFAULT 'abierto',
                  `ubicacion` varchar(255) NOT NULL,
                  `departamento` varchar(255) DEFAULT NULL,
                  `modalidad` enum('presencial','remoto','hibrido') NOT NULL DEFAULT 'presencial',
                  `jornada` enum('tiempo_completo','medio_tiempo','por_horas') NOT NULL DEFAULT 'tiempo_completo',
                  `salario_min` varchar(255) DEFAULT NULL,
                  `salario_max` varchar(255) DEFAULT NULL,
                  `mostrar_salario` tinyint(1) NOT NULL DEFAULT '0',
                  `descripcion` text NOT NULL,
                  `requisitos` json DEFAULT NULL,
                  `responsabilidades` json DEFAULT NULL,
                  `beneficios` json DEFAULT NULL,
                  `fecha_inicio` date DEFAULT NULL,
                  `fecha_cierre` date DEFAULT NULL,
                  `vacantes` int(11) NOT NULL DEFAULT '1',
                  `area` varchar(255) DEFAULT NULL,
                  `contacto_email` varchar(255) DEFAULT NULL,
                  `contacto_telefono` varchar(255) DEFAULT NULL,
                  `activo` tinyint(1) NOT NULL DEFAULT '1',
                  `destacado` tinyint(1) NOT NULL DEFAULT '0',
                  `orden` int(11) NOT NULL DEFAULT '0',
                  `vistas` int(11) NOT NULL DEFAULT '0',
                  `postulaciones_count` int(11) NOT NULL DEFAULT '0',
                  `created_at` timestamp NULL DEFAULT NULL,
                  `updated_at` timestamp NULL DEFAULT NULL,
                  `deleted_at` timestamp NULL DEFAULT NULL,
                  PRIMARY KEY (`id`),
                  UNIQUE KEY `ofertas_empleo_slug_unique` (`slug`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
            $this->info('✓ Tabla ofertas_empleo creada');

            // Tabla testimonios
            DB::statement("
                CREATE TABLE IF NOT EXISTS `testimonios` (
                  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                  `nombre` varchar(255) NOT NULL,
                  `cargo` varchar(255) DEFAULT NULL,
                  `empresa` varchar(255) DEFAULT NULL,
                  `testimonio` text NOT NULL,
                  `calificacion` int(11) NOT NULL DEFAULT '5',
                  `foto` varchar(255) DEFAULT NULL,
                  `foto_url` varchar(255) DEFAULT NULL,
                  `email` varchar(255) DEFAULT NULL,
                  `destacado` tinyint(1) NOT NULL DEFAULT '0',
                  `activo` tinyint(1) NOT NULL DEFAULT '1',
                  `orden` int(11) NOT NULL DEFAULT '0',
                  `created_at` timestamp NULL DEFAULT NULL,
                  `updated_at` timestamp NULL DEFAULT NULL,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
            $this->info('✓ Tabla testimonios creada');

            // Tabla call_to_actions
            DB::statement("
                CREATE TABLE IF NOT EXISTS `call_to_actions` (
                  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                  `nombre` varchar(255) NOT NULL,
                  `titulo` varchar(255) NOT NULL,
                  `subtitulo` text DEFAULT NULL,
                  `boton_principal_texto` varchar(255) DEFAULT NULL,
                  `boton_principal_url` varchar(255) DEFAULT NULL,
                  `boton_secundario_texto` varchar(255) DEFAULT NULL,
                  `boton_secundario_url` varchar(255) DEFAULT NULL,
                  `tipo` varchar(255) NOT NULL DEFAULT 'general',
                  `ubicacion` varchar(255) NOT NULL DEFAULT 'global',
                  `caracteristicas` json DEFAULT NULL,
                  `color_fondo` varchar(255) DEFAULT NULL,
                  `imagen_fondo` varchar(255) DEFAULT NULL,
                  `activo` tinyint(1) NOT NULL DEFAULT '1',
                  `orden` int(11) NOT NULL DEFAULT '0',
                  `created_at` timestamp NULL DEFAULT NULL,
                  `updated_at` timestamp NULL DEFAULT NULL,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
            $this->info('✓ Tabla call_to_actions creada');

            $this->newLine();
            $this->info('¡Todas las tablas han sido creadas exitosamente!');
            $this->info('El sistema ya debería funcionar correctamente.');

        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}

