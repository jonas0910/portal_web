# ✅ Solución: Imágenes y Videos del Landing

## 🔧 Problema Detectado
Las imágenes de los banners no se mostraban correctamente en la página pública (landing) porque el widget no estaba adaptado al nuevo sistema de videos e imágenes.

## ✅ Solución Implementada

### 1. Widget Hero Banner Actualizado
**Archivo**: `resources/views/components/public/widget-hero-banner.blade.php`

**Cambios realizados**:
- ✅ Soporte para mostrar **videos** con reproducción automática
- ✅ Detección correcta de URLs externas vs archivos locales
- ✅ Soporte para versiones **Desktop y Móvil** (responsive)
- ✅ Imagen poster para videos
- ✅ Compatibilidad con banners antiguos (solo imagen)

### 2. Sistema Responsive Implementado
El sistema ahora detecta automáticamente el tamaño de pantalla:

- **Desktop (>768px)**: Muestra imagen/video desktop
- **Móvil (≤768px)**: Muestra imagen/video móvil (si existe) o desktop como fallback

### 3. Soporte para Múltiples Tipos de URL
El sistema ahora maneja correctamente:
- ✅ Archivos locales: `storage/banners/imagenes/foto.jpg`
- ✅ URLs externas: `https://cdn.ejemplo.com/imagen.jpg`
- ✅ URLs de video: `https://youtube.com/...` o archivos locales MP4

## 🚀 Cómo Usar

### Verificar que los Banners Están Configurados

1. **Acceder al admin**:
   ```
   http://127.0.0.1:9000/admin/contenido/banners
   ```

2. **Verificar que existe al menos un banner con**:
   - ✅ **Posición**: "Principal"
   - ✅ **Estado**: "Activo" (checkbox marcado)
   - ✅ **Imagen o Video**: Cargado correctamente
   - ✅ **Fechas**: Sin restricciones o dentro del rango actual

### Crear/Editar Banner para el Landing

1. **Ir a Banners**: http://127.0.0.1:9000/admin/contenido/banners/create

2. **Configurar**:
   ```
   Título: "Bienvenido a Notaría Centro"
   Descripción: "Servicios Notariales de Calidad"
   Tipo de Contenido: Imagen o Video
   ```

3. **Para Imagen**:
   - Subir archivo (hasta 20MB) o
   - Ingresar URL externa
   
4. **Para Video**:
   - Subir archivo MP4 (hasta 100MB) o
   - Ingresar URL de YouTube/Vimeo
   - **Agregar imagen poster** (recomendado)

5. **Configuración importante**:
   - **Posición**: Seleccionar **"Principal"**
   - **Activo**: ✅ Marcar checkbox
   - **Orden**: 0 (para que sea el primero)
   - **Fechas**: Dejar vacío o configurar rango válido

6. **Guardar**

### Ver el Landing

1. Acceder a la página pública:
   ```
   http://127.0.0.1:9000/
   ```

2. Deberías ver el banner con:
   - Imagen o video de fondo
   - Título y descripción sobrepuestos
   - Botones de acción (si los configuraste)
   - Efecto de transición si hay múltiples banners

## 🔍 Diagnóstico de Problemas

### Problema: "No se ve ningún banner"

**Verificar**:

1. **¿Hay banners creados con posición "Principal"?**
   ```
   Admin → Contenido → Banners
   Verificar que existe al menos 1 banner con posición "Principal"
   ```

2. **¿El banner está activo?**
   ```
   Editar banner → Verificar que "Banner activo" esté ✅ marcado
   ```

3. **¿Las fechas son correctas?**
   ```
   Si tiene fecha_inicio, debe ser anterior a hoy
   Si tiene fecha_fin, debe ser posterior a hoy
   Mejor: Dejar ambas fechas vacías
   ```

### Problema: "Sale mensaje 'No hay banners configurados'"

Este mensaje indica que NO hay banners con posición "Principal" y activos.

**Solución rápida**:
```bash
# Verificar en base de datos
php artisan tinker
>>> \App\Models\Banner::where('posicion', 'principal')->where('activo', true)->get()
```

Si está vacío, crear un banner nuevo siguiendo los pasos anteriores.

### Problema: "La imagen no carga (404 error)"

**Verificar**:

1. **Enlace simbólico de storage**:
   ```bash
   php artisan storage:link
   ```

2. **Permisos de carpeta** (Linux/Mac):
   ```bash
   chmod -R 775 storage/app/public/banners/
   chown -R www-data:www-data storage/
   ```

3. **Verificar que el archivo existe**:
   - Si usas URL externa, verifica que la URL sea accesible
   - Si usas archivo local, verifica en: `storage/app/public/banners/imagenes/`

### Problema: "El video no se reproduce"

**Verificar**:

1. **Formato del video**: Debe ser MP4 con codec H.264
2. **Tamaño**: No debe exceder 100MB
3. **URL**: Si es externa, debe ser accesible públicamente
4. **Navegador**: Probar en Chrome/Firefox (mejor soporte)

### Problema: "En móvil se ve pixelado"

**Solución**:
1. Subir versión específica para móvil en "Imagen/Video Móvil"
2. Usar resolución optimizada para móvil: 1080x1920 (vertical)

## 📱 Ejemplo de Uso Completo

### Banner con Imagen para Notaría

```
Título: Notaría Centro - 50 Años de Experiencia
Descripción: Servicios notariales con la más alta calidad
Tipo: Imagen
Imagen Desktop: [Subir foto fachada 1920x1080]
Imagen Móvil: [Subir foto fachada 1080x1920]
Posición: Principal
Orden: 0
Activo: ✅
Texto Botón: Ver Servicios
URL Botón: /servicios
```

### Banner con Video de Recorrido

```
Título: Conoce Nuestras Instalaciones
Descripción: Recorrido virtual por nuestra notaría
Tipo: Video
Video Desktop: [Subir video_recorrido.mp4]
Imagen Poster: [Subir poster.jpg]
Posición: Principal
Orden: 1
Activo: ✅
Texto Botón: Agendar Cita
URL Botón: /contacto
```

## 🎨 Personalización del Banner

El banner hereda colores del tema activo:
- **Color primario**: Para gradiente del overlay
- **Color acento**: Para badges y botones
- **Opacidad overlay**: Configurable en el banner (0.3 por defecto)

## 📊 Estado Actual

### ✅ Completado
- [x] Widget actualizado para soportar videos
- [x] Detección correcta de URLs externas/locales
- [x] Sistema responsive desktop/móvil
- [x] Soporte para imagen poster de videos
- [x] Reproducción automática de videos con loop
- [x] Fallback a versión desktop si no hay móvil
- [x] Compatible con banners antiguos

### 📝 Archivos Modificados
- `resources/views/components/public/widget-hero-banner.blade.php`

## 🆘 Soporte Rápido

### Comando para verificar banners
```bash
php artisan tinker
>>> $banners = \App\Models\Banner::where('posicion', 'principal')->where('activo', true)->get();
>>> $banners->each(function($b) { 
...   echo "ID: {$b->id} | Título: {$b->titulo} | Tipo: {$b->tipo_media} | Imagen: " . ($b->imagen ? 'Sí' : 'No') . "\n"; 
... });
```

### Limpiar caché
```bash
php artisan cache:clear
php artisan view:clear
php artisan config:clear
```

### Probar en el navegador
1. Abrir: http://127.0.0.1:9000/
2. Presionar `F12` → Consola
3. Buscar errores 404 en imágenes/videos
4. Verificar que los archivos se cargan correctamente

---

**Fecha de Solución**: 5 de Noviembre, 2025  
**Estado**: ✅ Resuelto y Funcionando

