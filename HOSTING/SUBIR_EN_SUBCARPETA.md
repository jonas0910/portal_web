# 🚀 GUÍA: Subir a public_html/muni/

## 📁 ESTRUCTURA FINAL

```
public_html/
└── muni/                      ← TODO VA AQUÍ
    ├── app/
    ├── bootstrap/
    │   └── app.php            ← Reemplazar con app-subcarpeta.php
    ├── config/
    ├── database/
    ├── lang/
    ├── resources/
    ├── routes/
    ├── storage/
    │   ├── app/
    │   │   └── public/
    │   ├── framework/
    │   └── logs/
    ├── vendor/
    ├── .env                   ← Usar env-subcarpeta.txt
    ├── .htaccess              ← Usar htaccess-subcarpeta.txt
    ├── index.php              ← Usar index-subcarpeta.php
    ├── artisan
    ├── composer.json
    ├── css/                   ← Copiar de public/
    ├── js/                    ← Copiar de public/
    ├── images/                ← Copiar de public/
    ├── build/                 ← Copiar de public/
    └── vendor/                ← Copiar de public/ (AdminLTE)
```

---

## 📋 PASOS

### 1️⃣ Crear carpeta en hosting

En cPanel File Manager o FTP:
```
Crear: public_html/muni/
```

### 2️⃣ Subir archivos

Sube TODO el proyecto dentro de `public_html/muni/`:

```bash
# Carpetas principales
app/
bootstrap/
config/
database/
lang/
resources/
routes/
storage/
vendor/

# Archivos de la raíz
artisan
composer.json
composer.lock

# Contenido de public/ (copiar a muni/)
css/
js/
images/
build/
vendor/    (AdminLTE assets)
favicon.ico
robots.txt
```

### 3️⃣ Reemplazar archivos

| Original | Reemplazar con |
|----------|---------------|
| `muni/index.php` | `HOSTING/index-subcarpeta.php` |
| `muni/bootstrap/app.php` | `HOSTING/app-subcarpeta.php` |
| `muni/.htaccess` | `HOSTING/htaccess-subcarpeta.txt` |
| `muni/.env` | `HOSTING/env-subcarpeta.txt` |

### 4️⃣ Configurar .env

Edita `muni/.env`:
```env
APP_URL=https://tu-dominio.com/muni
ASSET_URL=https://tu-dominio.com/muni

DB_DATABASE=tu_base_datos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

### 5️⃣ Ejecutar comandos SSH

```bash
# Ir a la carpeta
cd ~/public_html/muni

# Generar clave de aplicación
php artisan key:generate

# Crear enlace simbólico de storage
php artisan storage:link

# Ejecutar migraciones
php artisan migrate --force

# Ejecutar seeders
php artisan db:seed --force

# Dar permisos
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Limpiar y optimizar
php artisan optimize:clear
php artisan optimize
```

---

## 🌐 URLs FINALES

| Página | URL |
|--------|-----|
| **Portal público** | `https://tu-dominio.com/muni/` |
| **Panel admin** | `https://tu-dominio.com/muni/admin` |
| **Sistema trámites** | `https://tu-dominio.com/muni/admin/tramites` |
| **Consulta trámites** | `https://tu-dominio.com/muni/tramites/consulta` |

---

## 🔐 CREDENCIALES

- **URL**: https://tu-dominio.com/muni/admin
- **Email**: admin@municipalidad.gob.pe
- **Password**: password

**⚠️ ¡CAMBIAR CONTRASEÑA INMEDIATAMENTE!**

---

## ⚠️ PROBLEMAS COMUNES

### Error 404 en rutas:
Verificar que `.htaccess` tenga:
```apache
RewriteBase /muni/
```

### Assets no cargan (CSS/JS):
Verificar en `.env`:
```env
APP_URL=https://tu-dominio.com/muni
ASSET_URL=https://tu-dominio.com/muni
```

### Error 500:
```bash
cd ~/public_html/muni
tail -50 storage/logs/laravel.log
php artisan optimize:clear
```

### Imágenes no cargan:
```bash
cd ~/public_html/muni
php artisan storage:link
```


