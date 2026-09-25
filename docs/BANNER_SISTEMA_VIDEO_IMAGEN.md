# Sistema de Banners con Soporte de Video e Imágenes de Alta Resolución

## 📋 Características Implementadas

### ✅ Soporte para Múltiples Tipos de Media
- **Imágenes**: Hasta 20MB (ideal para alta resolución)
  - Formatos: JPEG, JPG, PNG, GIF, WebP
  - Versiones desktop y móvil
  
- **Videos**: Hasta 100MB
  - Formatos: MP4, WebM, OGV, MOV
  - Versiones desktop y móvil
  - Imagen poster para previsualización

### ✅ Funcionalidades
1. Selector de tipo de contenido (Imagen/Video)
2. Carga de archivos local o mediante URL externa
3. Organización automática de archivos:
   - `storage/banners/imagenes/` - Imágenes
   - `storage/banners/videos/` - Videos
   - `storage/banners/posters/` - Imágenes poster de videos

## 🗃️ Cambios en Base de Datos

### Nuevos Campos en Tabla `banners`
```sql
- tipo_media (enum: 'imagen', 'video')
- video (string, 500 caracteres)
- video_url (string, 500 caracteres)
- video_movil (string, 500 caracteres)
- video_movil_url (string, 500 caracteres)
- video_poster (string, 500 caracteres)
```

## 📁 Archivos Modificados

### Backend
1. **Migración**: `database/migrations/2025_11_05_152223_add_video_support_to_banners_table.php`
2. **Modelo**: `app/Models/Banner.php`
   - Nuevos campos en `$fillable`
   - Métodos helper: `esVideo()`, `esImagen()`
   - Atributos: `video_url_completo`, `video_movil_completo`, `video_poster_completo`

3. **Controlador**: `app/Http/Controllers/Admin/ContenidoController.php`
   - Validación de videos (hasta 100MB)
   - Validación de imágenes (hasta 20MB)
   - Manejo de carga de archivos
   - Eliminación de archivos locales

### Frontend (Vistas)
1. **resources/views/admin/contenido/banners/create.blade.php**
   - Selector de tipo de media
   - Campos dinámicos para imagen/video
   - JavaScript para toggle de campos

2. **resources/views/admin/contenido/banners/edit.blade.php**
   - Soporte para editar videos e imágenes
   - Previsualización de contenido actual
   - Mismas funcionalidades que create

3. **resources/views/admin/contenido/banners/index.blade.php**
   - Visualización de tipo de media (badge con icono)
   - Previsualización de videos con poster
   - Soporte para URLs externas

## ⚙️ Configuración del Servidor

### Opción 1: .htaccess (Apache)
El archivo `.htaccess` en la raíz ya está configurado con:
```apache
php_value upload_max_filesize 120M
php_value post_max_size 120M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Opción 2: php.ini
Si tienes acceso a `php.ini`, configura:
```ini
upload_max_filesize = 120M
post_max_size = 120M
max_execution_time = 300
max_input_time = 300
memory_limit = 256M
```

### Opción 3: PHP-FPM (Nginx)
Edita tu configuración de PHP-FPM:
```ini
php_admin_value[upload_max_filesize] = 120M
php_admin_value[post_max_size] = 120M
php_admin_value[max_execution_time] = 300
php_admin_value[memory_limit] = 256M
```

## 🚀 Uso del Sistema

### Crear Banner con Imagen
1. Acceder a `/admin/contenido/banners`
2. Clic en "Nuevo Banner"
3. Seleccionar "Imagen" en tipo de contenido
4. Completar campos:
   - Imagen Desktop (hasta 20MB)
   - Imagen Móvil (hasta 15MB) - Opcional
5. Guardar

### Crear Banner con Video
1. Acceder a `/admin/contenido/banners`
2. Clic en "Nuevo Banner"
3. Seleccionar "Video" en tipo de contenido
4. Completar campos:
   - Video Desktop (hasta 100MB)
   - Video Móvil (hasta 100MB) - Opcional
   - Imagen Poster (hasta 10MB) - Opcional pero recomendado
5. Guardar

### Usar URLs Externas
En lugar de subir archivos, puedes ingresar URLs directamente:
- URLs de CDN (CloudFlare, AWS S3, etc.)
- URLs de servicios de almacenamiento
- URLs de YouTube/Vimeo (para videos)

## 📊 Límites de Tamaño

| Tipo de Archivo | Tamaño Máximo | Propósito |
|-----------------|---------------|-----------|
| Imagen Desktop  | 20 MB         | Alta resolución para desktop |
| Imagen Móvil    | 15 MB         | Optimizada para móvil |
| Video Desktop   | 100 MB        | Video principal |
| Video Móvil     | 100 MB        | Video optimizado para móvil |
| Video Poster    | 10 MB         | Imagen de previsualización |

## 🔍 Formatos Soportados

### Imágenes
- JPEG / JPG
- PNG
- GIF
- WebP

### Videos
- MP4 (recomendado)
- WebM
- OGV (Ogg Video)
- MOV (QuickTime)

## 💡 Recomendaciones

### Para Imágenes
- Usar formato WebP para mejor compresión
- Resolución recomendada Desktop: 1920x1080 o superior
- Resolución recomendada Móvil: 768x1024 o 1080x1920

### Para Videos
- Usar formato MP4 con codec H.264 para mejor compatibilidad
- Resolución recomendada Desktop: 1920x1080 (Full HD)
- Resolución recomendada Móvil: 720x1280 o 1080x1920
- Siempre incluir imagen poster para mejor experiencia de usuario
- Considerar usar URL externa para videos muy grandes (ej: YouTube, Vimeo)

## 🐛 Solución de Problemas

### Error: "El archivo excede el tamaño máximo"
1. Verificar configuración de PHP
2. Reiniciar servidor web después de cambios
3. Verificar límites en `.htaccess`

### Video no se reproduce
1. Verificar formato de video (MP4 recomendado)
2. Verificar codec (H.264 recomendado)
3. Verificar permisos de carpeta `storage/banners/videos/`

### Imagen no se muestra
1. Ejecutar: `php artisan storage:link`
2. Verificar permisos de carpeta `storage/banners/imagenes/`

## 📝 Comandos Útiles

```bash
# Crear enlace simbólico de storage
php artisan storage:link

# Verificar configuración de PHP
php -i | grep -E "upload_max_filesize|post_max_size|memory_limit"

# Dar permisos a carpeta storage (Linux)
chmod -R 775 storage/
chown -R www-data:www-data storage/
```

## 🔄 Migración de Banners Antiguos

Los banners existentes automáticamente tendrán:
- `tipo_media` = 'imagen' (por defecto)
- Mantendrán sus imágenes actuales
- No requieren actualización manual

## 📞 Soporte

Para problemas o preguntas sobre el sistema de banners con video/imagen, contactar al equipo de desarrollo.

