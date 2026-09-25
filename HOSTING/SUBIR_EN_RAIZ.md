# 🚀 GUÍA RÁPIDA: Subir Laravel a la Raíz del Hosting

## 📁 ESTRUCTURA FINAL EN EL HOSTING

```
public_html/
├── app/
├── bootstrap/
│   └── app.php          ← Reemplazar con app-raiz.php
├── config/
├── database/
├── lang/
├── resources/
├── routes/
├── storage/
│   ├── app/
│   │   └── public/      ← Aquí van las imágenes subidas
│   ├── framework/
│   └── logs/
├── vendor/
├── .env                 ← Configurar con datos del hosting
├── .htaccess            ← Copiar de htaccess-raiz.txt
├── index.php            ← Reemplazar con index-raiz.php
├── artisan
├── composer.json
├── css/                 ← Desde carpeta public/
├── js/                  ← Desde carpeta public/
├── images/              ← Desde carpeta public/
├── build/               ← Desde carpeta public/
└── vendor/              ← Desde carpeta public/ (AdminLTE)
```

---

## 📋 PASOS A SEGUIR

### 1️⃣ En tu computadora local:

```bash
# Limpiar cachés
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### 2️⃣ Subir archivos al hosting:

1. **Sube TODO el proyecto** a `public_html/`
2. **Copia el contenido de `public/`** también a `public_html/`
   - css/
   - js/
   - images/
   - build/
   - vendor/ (AdminLTE assets)
   - favicon.ico
   - robots.txt

### 3️⃣ Reemplazar archivos:

| Archivo Original | Reemplazar Con |
|------------------|----------------|
| `index.php` | `HOSTING/index-raiz.php` |
| `bootstrap/app.php` | `HOSTING/app-raiz.php` |
| `.htaccess` | `HOSTING/htaccess-raiz.txt` |
| `.env` | `HOSTING/env-produccion.txt` |

### 4️⃣ Configurar `.env`:

```env
APP_NAME="Municipalidad La Yarada Los Palos"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-dominio.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=tu_base_datos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

### 5️⃣ Ejecutar comandos en SSH:

```bash
cd ~/public_html

# Generar clave
php artisan key:generate

# Crear enlace de storage (IMPORTANTE)
php artisan storage:link

# Ejecutar migraciones
php artisan migrate --force

# Ejecutar seeders
php artisan db:seed --force

# Optimizar
php artisan optimize
```

### 6️⃣ Dar permisos:

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

---

## ⚠️ PROBLEMAS COMUNES

### Error 500:
```bash
# Ver el error
tail -50 storage/logs/laravel.log

# Limpiar todo
php artisan optimize:clear
```

### Imágenes no cargan:
```bash
# Verificar enlace simbólico
ls -la storage

# Si no existe, crear:
php artisan storage:link
```

### Error de permisos:
```bash
chmod -R 775 storage bootstrap/cache
```

---

## ✅ VERIFICAR QUE FUNCIONA

1. `https://tu-dominio.com` → Portal público
2. `https://tu-dominio.com/admin` → Panel de administración
3. `https://tu-dominio.com/admin/tramites` → Sistema de trámites

---

## 🔐 CREDENCIALES POR DEFECTO

- **URL**: https://tu-dominio.com/admin
- **Email**: admin@municipalidad.gob.pe
- **Password**: password

**⚠️ ¡CAMBIAR LA CONTRASEÑA INMEDIATAMENTE!**


