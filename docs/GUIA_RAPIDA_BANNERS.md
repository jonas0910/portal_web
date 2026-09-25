# 🎬 Guía Rápida - Sistema de Banners con Video e Imagen

## ✅ Sistema Implementado y Funcionando

### 🎯 Capacidades del Sistema

#### Para Imágenes de Notarías
- ✅ **Alta Resolución**: Hasta 20MB por imagen
- ✅ **Formatos**: JPEG, PNG, GIF, WebP
- ✅ **Versiones**: Desktop (1920x1080+) y Móvil (768x1024+)
- ✅ **Carga**: Archivo local o URL externa

#### Para Videos de Notarías
- ✅ **Alta Calidad**: Hasta 100MB por video
- ✅ **Formatos**: MP4, WebM, OGV, MOV
- ✅ **Versiones**: Desktop (Full HD) y Móvil (HD)
- ✅ **Poster**: Imagen de previsualización (10MB)
- ✅ **Carga**: Archivo local o URL externa (YouTube, Vimeo, CDN)

## 🚀 Cómo Usar

### Acceso al Sistema
1. Abrir navegador en: http://127.0.0.1:9000/admin/contenido/banners
2. Clic en **"Nuevo Banner"**

### Subir Imagen de Notaría
1. **Título**: Ej. "Notaría Centro - Servicios Legales"
2. **Descripción**: Texto descriptivo
3. **Tipo de Contenido**: Seleccionar **"Imagen"**
4. **Imagen Desktop**: 
   - Subir archivo (hasta 20MB) o
   - Pegar URL externa
5. **Imagen Móvil**: (Opcional) Versión optimizada para móvil
6. **Configurar**:
   - Posición (Principal/Secundario/Footer)
   - Orden de visualización
   - Activo/Inactivo
   - Fechas de vigencia
7. **Guardar**

### Subir Video de Notaría
1. **Título**: Ej. "Recorrido Virtual Notaría"
2. **Descripción**: Texto descriptivo
3. **Tipo de Contenido**: Seleccionar **"Video"**
4. **Video Desktop**: 
   - Subir archivo MP4 (hasta 100MB) o
   - Pegar URL de YouTube/Vimeo/CDN
5. **Video Móvil**: (Opcional) Versión optimizada
6. **Imagen Poster**: (Recomendado) Imagen que se muestra antes de reproducir
7. **Configurar posición y guardar**

## 📊 Estado del Sistema

### ✅ Configuración Actual del Servidor
```
✓ Upload Max Filesize: 2GB (Soporta archivos grandes)
✓ Post Max Size: 2GB
✓ Memory Limit: 512MB
✓ Carpetas de almacenamiento: Creadas
✓ Enlaces simbólicos: Configurados
```

### 📁 Estructura de Almacenamiento
```
storage/app/public/banners/
├── imagenes/     ← Imágenes de notarías (hasta 20MB)
├── videos/       ← Videos de notarías (hasta 100MB)
└── posters/      ← Imágenes poster de videos (hasta 10MB)
```

## 💡 Recomendaciones para Notarías

### Para Imágenes
- **Fachada de la Notaría**: 1920x1080px, formato WebP o JPEG
- **Interior/Oficinas**: 1920x1080px, alta calidad
- **Logo/Distintivos**: PNG con transparencia
- **Personal**: Fotos profesionales 1920x1080px

### Para Videos
- **Recorrido Virtual**: MP4, 1920x1080, 30fps, hasta 60 segundos
- **Presentación Servicios**: MP4, 1920x1080, 30fps
- **Testimonios**: MP4, 1280x720 (HD suficiente)
- **Usar siempre imagen poster**: Primera impresión importante

### Optimización
- **Imágenes**: Comprimir con TinyPNG o similar antes de subir
- **Videos**: 
  - Codec H.264 para mejor compatibilidad
  - Bitrate: 5-8 Mbps para Full HD
  - Considerar usar YouTube/Vimeo para videos muy largos
  - Agregar subtítulos si hay diálogos

## 🔗 URLs Útiles

- **Gestión de Banners**: http://127.0.0.1:9000/admin/contenido/banners
- **Crear Nuevo**: http://127.0.0.1:9000/admin/contenido/banners/create
- **Dashboard Admin**: http://127.0.0.1:9000/admin/dashboard

## 📱 Responsive

El sistema es completamente responsive:
- **Desktop**: Muestra imagen/video desktop
- **Tablet**: Muestra imagen/video móvil (si existe) o desktop
- **Móvil**: Muestra imagen/video móvil optimizado

## 🎨 Ejemplo de Uso para Notaría

### Banner Principal (Hero)
- **Tipo**: Video
- **Contenido**: Recorrido virtual de 30 segundos
- **Poster**: Fachada de la notaría
- **Posición**: Principal
- **Texto**: "Más de 50 años brindando servicios notariales"

### Banner Secundario
- **Tipo**: Imagen
- **Contenido**: Collage de servicios
- **Posición**: Secundario
- **Texto**: "Compra-Venta, Poderes, Testamentos, Sociedades"

### Banner de Promoción
- **Tipo**: Imagen
- **Contenido**: Promoción especial
- **Posición**: Footer
- **Vigencia**: Del 1 al 31 del mes
- **Texto**: "Descuento en apertura de sociedades"

## 🆘 Solución Rápida de Problemas

### "Error al subir archivo"
- ✅ Verificar que el archivo no supere 100MB para videos o 20MB para imágenes
- ✅ Verificar formato del archivo (MP4 para videos, JPEG/PNG para imágenes)

### "No se ve la imagen/video"
- ✅ Verificar que el banner esté marcado como "Activo"
- ✅ Verificar fechas de vigencia
- ✅ Limpiar caché del navegador (Ctrl + F5)

### "Video no se reproduce"
- ✅ Verificar formato MP4 con codec H.264
- ✅ Probar URL del video directamente en el navegador
- ✅ Verificar permisos de carpeta storage/

## 📞 Contacto

Para soporte técnico o preguntas sobre el sistema de banners, contactar al equipo de desarrollo.

---

**Fecha de Implementación**: 5 de Noviembre, 2025
**Versión del Sistema**: 1.0
**Estado**: ✅ Completamente Funcional

