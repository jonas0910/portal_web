# 🚀 GUÍA DE DESPLIEGUE EN HOSTING

## 📋 Requisitos del Hosting

- **PHP**: 8.1 o superior
- **MySQL**: 5.7 o superior / MariaDB 10.3+
- **Extensiones PHP requeridas**:
  - BCMath
  - Ctype
  - Fileinfo
  - JSON
  - Mbstring
  - OpenSSL
  - PDO
  - PDO_MySQL
  - Tokenizer
  - XML
  - cURL
  - GD o Imagick

---

## 📦 OPCIÓN 1: Hosting Compartido (cPanel/Plesk)

### Paso 1: Preparar los archivos localmente

Ejecute estos comandos en su computadora antes de subir:

```bash
# 1. Limpiar cachés y archivos temporales
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 2. Optimizar para producción
composer install --optimize-autoloader --no-dev

# 3. Compilar assets (si usa Vite/npm)
npm run build
```

### Paso 2: Crear la base de datos en cPanel

1. Ingrese a **cPanel** → **Bases de datos MySQL**
2. Cree una nueva base de datos (ej: `usuario_muni`)
3. Cree un usuario de base de datos con contraseña segura
4. Asigne el usuario a la base de datos con **TODOS LOS PRIVILEGIOS**

### Paso 3: Subir archivos

**Estructura recomendada en el hosting:**

```
/home/usuario/
├── public_html/          ← Contenido de la carpeta "public"
│   ├── index.php         (MODIFICADO - ver abajo)
│   ├── .htaccess
│   ├── css/
│   ├── js/
│   ├── storage -> ../proyecto/storage/app/public
│   └── vendor/           (AdminLTE assets)
│
└── proyecto/             ← Todo lo demás (FUERA de public_html)
    ├── app/
    ├── bootstrap/
    ├── config/
    ├── database/
    ├── resources/
    ├── routes/
    ├── storage/
    ├── vendor/
    ├── .env              ← Archivo de configuración
    └── artisan
```

### Paso 4: Modificar index.php

Edite `public_html/index.php` para apuntar a la nueva ubicación:

```php
<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determinar si está en mantenimiento
if (file_exists($maintenance = __DIR__.'/../proyecto/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Autoloader de Composer
require __DIR__.'/../proyecto/vendor/autoload.php';

// Bootstrap de Laravel
$app = require_once __DIR__.'/../proyecto/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
```

### Paso 5: Configurar .env

1. Copie `HOSTING/env-produccion.txt` a `/proyecto/.env`
2. Configure los valores:

```env
APP_NAME="Municipalidad La Yarada Los Palos"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://www.su-dominio.com

DB_DATABASE=usuario_muni
DB_USERNAME=usuario_db
DB_PASSWORD=su_contraseña_segura
```

3. Genere la clave de aplicación vía SSH o terminal web:

```bash
cd ~/proyecto
php artisan key:generate
```

### Paso 6: Crear enlace simbólico de storage

Vía SSH:
```bash
cd ~/public_html
ln -s ../proyecto/storage/app/public storage
```

O cree el archivo `public_html/storage/.htaccess`:
```apache
# Redirección a storage
```

### Paso 7: Ejecutar migraciones y seeders

Vía SSH:
```bash
cd ~/proyecto
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
```

### Paso 8: Permisos de carpetas

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

---

## 📦 OPCIÓN 2: VPS (DigitalOcean, Linode, AWS)

### Usando el script de despliegue

```bash
# Subir proyecto
scp -r ./muni usuario@servidor:/var/www/

# Conectar al servidor
ssh usuario@servidor

# Ejecutar script
cd /var/www/muni
chmod +x HOSTING/deploy.sh
./HOSTING/deploy.sh
```

---

## 🔧 CONFIGURACIÓN DE .htaccess

### Para public_html/.htaccess:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Forzar HTTPS
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

    # Redirigir www a sin www (o viceversa)
    # RewriteCond %{HTTP_HOST} ^www\.(.*)$ [NC]
    # RewriteRule ^(.*)$ https://%1/$1 [R=301,L]

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>

# Compresión GZIP
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/css application/json
    AddOutputFilterByType DEFLATE application/javascript text/xml application/xml
</IfModule>

# Cache de archivos estáticos
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpg "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/gif "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType image/webp "access plus 1 year"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
</IfModule>
```

---

## 📊 EXPORTAR BASE DE DATOS LOCAL

### Opción A: Usando phpMyAdmin
1. Abrir phpMyAdmin local
2. Seleccionar la base de datos `muni` (o el nombre que tenga)
3. Exportar → Método: Rápido → Formato: SQL
4. Descargar el archivo .sql

### Opción B: Usando comando
```bash
mysqldump -u root -p muni > HOSTING/database_backup.sql
```

---

## ✅ VERIFICACIÓN POST-DESPLIEGUE

Después de subir, verifique:

1. **Página principal**: `https://su-dominio.com`
2. **Panel admin**: `https://su-dominio.com/admin`
3. **Sistema de trámites**: `https://su-dominio.com/admin/tramites`
4. **Consulta pública**: `https://su-dominio.com/tramites/consulta`

### Si hay errores 500:

```bash
# Ver logs de error
tail -f ~/proyecto/storage/logs/laravel.log

# Limpiar cachés
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Regenerar autoload
composer dump-autoload
```

---

## 🔐 CREDENCIALES POR DEFECTO

**Usuario Administrador:**
- Email: `admin@municipalidad.gob.pe`
- Contraseña: `password` (¡CAMBIAR INMEDIATAMENTE!)

---

## 📞 SOPORTE

Si tiene problemas con el despliegue:
1. Revise los logs en `storage/logs/laravel.log`
2. Verifique los permisos de carpetas
3. Confirme que PHP tiene las extensiones requeridas
4. Verifique la conexión a la base de datos


