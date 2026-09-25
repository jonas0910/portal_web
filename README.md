# Portal Notarios - Sistema Integral

Sistema web completo para el Colegio de Notarios del Perú con intranet, extranet y gestor de contenidos dinámico.

## 🚀 Características Principales

### Frontend Público
- **Diseño moderno** inspirado en notarios.org.pe
- **Directorio de notarios** con búsqueda y filtros
- **Catálogo de servicios** notariales
- **Documentos públicos** disponibles para descarga
- **Formulario de contacto** integrado
- **Diseño responsive** para todos los dispositivos

### Panel Administrativo (AdminLTE)
- **Dashboard completo** con estadísticas
- **Gestión de notarios** con DataTables
- **Gestión de documentos** con subida de archivos
- **Gestión de servicios** notariales
- **Sistema de usuarios** con roles y permisos
- **Gestión de categorías** de documentos
- **Mensajes de contacto** del sitio público

### Sistema de Roles
- **Administrador**: Acceso completo al sistema
- **Notario**: Gestión de sus documentos y servicios
- **Cliente**: Acceso a documentos públicos y servicios

### Funcionalidades Técnicas
- **Base de datos MySQL** optimizada
- **Autenticación Laravel** con roles (Spatie Permission)
- **DataTables** para gestión de datos
- **Subida de archivos** con validación
- **Sistema de permisos** granular
- **Logs de actividad** (Spatie Activity Log)
- **Backup automático** (Spatie Backup)

## 📋 Requisitos del Sistema

- PHP 8.1 o superior
- MySQL 5.7 o superior
- Composer
- Node.js y NPM (para assets)
- Servidor web (Apache/Nginx)

## 🛠️ Instalación

### 1. Clonar el repositorio
```bash
git clone https://github.com/tu-usuario/portal-notarios.git
cd portal-notarios
```

### 2. Instalar dependencias
```bash
composer install
npm install
```

### 3. Configurar entorno
```bash
cp env.example .env
php artisan key:generate
```

### 4. Configurar base de datos
Editar el archivo `.env` con los datos de tu base de datos:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cnotarios
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_password
```

### 5. Ejecutar migraciones y seeders
```bash
php artisan migrate --seed
```

### 6. Compilar assets
```bash
npm run dev
# o para producción
npm run build
```

### 7. Configurar almacenamiento
```bash
php artisan storage:link
```

## 👥 Usuarios por Defecto

Después de ejecutar los seeders, tendrás estos usuarios:

### Administrador
- **Email**: admin@notarios.org.pe
- **Password**: password
- **Rol**: Administrador completo

### Notarios de Ejemplo
- **Email**: carlos.mendoza@notarios.org.pe
- **Password**: password
- **Rol**: Notario

- **Email**: maria.rodriguez@notarios.org.pe
- **Password**: password
- **Rol**: Notario

## 🗂️ Estructura del Proyecto

```
app/
├── Http/Controllers/
│   ├── Admin/          # Controladores del panel admin
│   ├── Notario/        # Controladores para notarios
│   ├── Cliente/        # Controladores para clientes
│   └── PublicController.php
├── Models/
│   ├── Notario.php
│   ├── Documento.php
│   ├── Servicio.php
│   ├── CategoriaDocumento.php
│   └── User.php
└── ...

database/
├── migrations/         # Migraciones de base de datos
└── seeders/           # Datos iniciales

resources/
├── views/
│   ├── admin/         # Vistas del panel administrativo
│   ├── public/        # Vistas del sitio público
│   └── layouts/       # Layouts base
└── ...

routes/
└── web.php           # Rutas del sistema
```

## 🔧 Configuración Adicional

### AdminLTE
El panel administrativo usa AdminLTE 3. La configuración se encuentra en:
- `config/adminlte.php`
- `config/adminlte_menu.php`

### Permisos y Roles
Los permisos se definen en `database/seeders/RolesAndPermissionsSeeder.php`

### DataTables
Las tablas dinámicas están configuradas en los controladores Admin con:
- Procesamiento del lado del servidor
- Búsqueda y filtrado
- Paginación automática
- Exportación de datos

## 📱 Funcionalidades por Módulo

### Módulo de Notarios
- Registro completo de datos profesionales
- Gestión de especialidades
- Subida de fotos profesionales
- Estados activo/inactivo
- Asociación con usuarios del sistema

### Módulo de Documentos
- Subida de archivos (PDF, DOC, DOCX)
- Categorización por tipo
- Control de visibilidad (público/privado)
- Sistema de tags
- Metadatos completos

### Módulo de Servicios
- Catálogo de servicios notariales
- Precios y duración
- Requisitos y procedimientos
- Asociación con notarios
- Estados activo/inactivo

### Módulo de Contacto
- Formulario público integrado
- Gestión de mensajes en el admin
- Sistema de respuestas
- Estados de lectura

## 🎨 Personalización

### Colores del Tema
Los colores principales se definen en CSS variables:
```css
:root {
    --primary-color: #1e3a8a;
    --secondary-color: #f59e0b;
    --accent-color: #dc2626;
}
```

### Logo y Branding
- Cambiar logo en `resources/views/layouts/public.blade.php`
- Configurar colores en las variables CSS
- Personalizar AdminLTE en `config/adminlte.php`

## 🔒 Seguridad

- Autenticación Laravel con hash de contraseñas
- Middleware de roles y permisos
- Validación de archivos subidos
- Protección CSRF en formularios
- Sanitización de datos de entrada

## 📊 Monitoreo y Logs

- Logs de actividad con Spatie Activity Log
- Backup automático con Spatie Backup
- Logs de Laravel en `storage/logs/`

## 🚀 Despliegue

### Producción
1. Configurar variables de entorno de producción
2. Ejecutar `php artisan config:cache`
3. Ejecutar `php artisan route:cache`
4. Ejecutar `php artisan view:cache`
5. Compilar assets con `npm run build`

### Servidor Web
Configurar el servidor web para apuntar al directorio `public/`

## 🤝 Contribución

1. Fork el proyecto
2. Crear una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abrir un Pull Request

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver `LICENSE` para más detalles.

## 📞 Soporte

Para soporte técnico o consultas:
- Email: soporte@notarios.org.pe
- Documentación: [Wiki del proyecto]
- Issues: [GitHub Issues]

---

**Portal Notarios** - Sistema integral para el Colegio de Notarios del Perú
