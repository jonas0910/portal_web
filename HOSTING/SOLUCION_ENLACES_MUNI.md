# 🔧 SOLUCIÓN: Enlaces apuntan a raíz en vez de /muni/

## El Problema
Los enlaces generan URLs como:
- ❌ `https://munilayaradalospalos.gob.pe/admin`
- ❌ `https://munilayaradalospalos.gob.pe/storage/...`

En lugar de:
- ✅ `https://munilayaradalospalos.gob.pe/muni/admin`
- ✅ `https://munilayaradalospalos.gob.pe/muni/storage/...`

---

## 🔧 SOLUCIÓN COMPLETA

### Paso 1: Actualizar .env

Edita `public_html/muni/.env` y asegúrate de tener:

```env
APP_URL=https://munilayaradalospalos.gob.pe/muni
ASSET_URL=https://munilayaradalospalos.gob.pe/muni
```

**⚠️ IMPORTANTE:** Debe incluir `/muni` al final, NO solo el dominio.

---

### Paso 2: Reemplazar AppServiceProvider

Reemplaza el archivo `app/Providers/AppServiceProvider.php` con el contenido de `HOSTING/AppServiceProvider-subcarpeta.php`:

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Forzar URL base para subcarpeta /muni/
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
            URL::forceRootUrl(config('app.url'));
        }
    }
}
```

---

### Paso 3: Limpiar TODA la caché

**MUY IMPORTANTE** - Ejecuta estos comandos via SSH:

```bash
cd ~/public_html/muni

php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Regenerar caché de configuración
php artisan config:cache
```

---

### Paso 4: Verificar

1. Abre https://munilayaradalospalos.gob.pe/muni/
2. Haz clic en cualquier enlace del menú
3. La URL debe incluir `/muni/`

---

## 📋 Resumen de archivos a modificar en el hosting:

| Archivo | Acción |
|---------|--------|
| `.env` | Agregar `/muni` a APP_URL y ASSET_URL |
| `app/Providers/AppServiceProvider.php` | Reemplazar con versión de HOSTING/ |
| Ejecutar comandos | `php artisan config:clear` etc. |

---

## ⚠️ Si sigue sin funcionar

Verifica que el archivo `.env` realmente se guardó:

```bash
cd ~/public_html/muni
cat .env | grep APP_URL
```

Debe mostrar:
```
APP_URL=https://munilayaradalospalos.gob.pe/muni
ASSET_URL=https://munilayaradalospalos.gob.pe/muni
```

Si muestra algo diferente, el archivo no se guardó correctamente.


