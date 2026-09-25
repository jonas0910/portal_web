# Sistema de Fotos de Aniversario

## 📋 Descripción

Se ha implementado un sistema completo para gestionar y mostrar fotos de aniversario desde el panel de administración. El sistema incluye:

- ✅ **CRUD completo** en el gestor de contenidos
- ✅ **Modal interactiva** en el frontend
- ✅ **Filtros por año** 
- ✅ **Galería responsive** con miniaturas
- ✅ **Vista ampliada** de imágenes
- ✅ **API REST** para consultas

---

## 🎯 Características Principales

### Panel de Administración

1. **Gestión de Fotos**
   - Crear, editar y eliminar fotos
   - Subir imagen principal y miniatura (opcional)
   - Asignar año del aniversario
   - Establecer fecha específica del evento
   - Configurar orden de visualización
   - Activar/desactivar fotos

2. **Estadísticas**
   - Contador de fotos totales
   - Contador de fotos activas
   - Integrado en el dashboard del gestor de contenidos

### Frontend Público

1. **Modal de Galería**
   - Botón flotante para abrir la galería
   - Vista de cuadrícula responsive
   - Filtro por año dinámico
   - Contador de fotos
   - Vista ampliada al hacer clic

2. **Características de UX**
   - Carga asíncrona de fotos
   - Animaciones suaves
   - Diseño responsive (móvil/tablet/desktop)
   - Scroll personalizado

---

## 🚀 Cómo Usar

### En el Panel de Administración

1. **Acceder al Gestor**
   - Ir a: `Admin → Contenido → Fotos de Aniversario`
   - URL: `/admin/contenido/fotos-aniversario`

2. **Crear una Nueva Foto**
   ```
   - Click en "Nueva Foto"
   - Completar formulario:
     * Título (requerido)
     * Descripción (opcional)
     * Imagen principal (requerido, máx. 10MB)
     * Miniatura (opcional, máx. 5MB)
     * Año del aniversario (opcional)
     * Fecha del evento (opcional)
     * Orden de visualización (0 = primera posición)
     * Estado (activo/inactivo)
   - Guardar
   ```

3. **Editar una Foto**
   - Click en el botón "Editar" de cualquier foto
   - Modificar los campos necesarios
   - Guardar cambios

4. **Cambiar Estado Rápidamente**
   - Click en el botón de toggle en la lista
   - La foto se activará/desactivará instantáneamente

5. **Eliminar una Foto**
   - Click en el botón de eliminar (icono de basura)
   - Confirmar la acción

### En el Frontend

1. **Incluir el Modal en una Vista**
   ```blade
   @include('public.components.modal-fotos-aniversario')
   ```

2. **El modal incluye automáticamente:**
   - ✅ Botón flotante en la esquina inferior derecha
   - ✅ Modal con galería completa
   - ✅ Filtros por año
   - ✅ Vista ampliada de imágenes

3. **Personalizar el Botón Flotante**
   - El botón está en la parte inferior derecha por defecto
   - Para ocultarlo, agregar CSS:
   ```css
   #btn-abrir-galeria-aniversario {
       display: none;
   }
   ```
   - Para crear tu propio botón:
   ```html
   <button data-toggle="modal" data-target="#modalFotosAniversario">
       Ver Galería de Aniversario
   </button>
   ```

---

## 📁 Estructura de Archivos Creados

### Migración
```
database/migrations/2025_11_28_000000_create_fotos_aniversario_table.php
```

### Modelo
```
app/Models/FotoAniversario.php
```

### Controlador
```
app/Http/Controllers/Admin/FotoAniversarioController.php
```

### Vistas de Admin
```
resources/views/admin/contenido/fotos_aniversario/
├── index.blade.php   (Lista de fotos)
├── create.blade.php  (Crear nueva foto)
└── edit.blade.php    (Editar foto)
```

### Componente Frontend
```
resources/views/public/components/modal-fotos-aniversario.blade.php
```

### Rutas Agregadas

**Rutas de Admin:**
```php
GET    /admin/contenido/fotos-aniversario
GET    /admin/contenido/fotos-aniversario/create
POST   /admin/contenido/fotos-aniversario
GET    /admin/contenido/fotos-aniversario/{id}/edit
PUT    /admin/contenido/fotos-aniversario/{id}
DELETE /admin/contenido/fotos-aniversario/{id}
POST   /admin/contenido/fotos-aniversario/{id}/toggle
```

**Ruta Pública (API):**
```php
GET    /api/fotos-aniversario  (Retorna JSON con las fotos activas)
```

---

## 🗄️ Estructura de la Base de Datos

### Tabla: `fotos_aniversario`

| Campo              | Tipo      | Descripción                           |
|--------------------|-----------|---------------------------------------|
| id                 | bigint    | Clave primaria                        |
| titulo             | string    | Título de la foto                     |
| descripcion        | text      | Descripción del evento                |
| imagen             | string    | Ruta de la imagen principal           |
| imagen_thumbnail   | string    | Ruta de la miniatura (opcional)       |
| anio               | integer   | Año del aniversario                   |
| fecha              | date      | Fecha específica del evento           |
| orden              | integer   | Orden de visualización (default: 0)   |
| activo             | boolean   | Estado activo/inactivo (default: true)|
| created_at         | timestamp | Fecha de creación                     |
| updated_at         | timestamp | Fecha de actualización                |

---

## 🎨 API REST

### Endpoint: GET `/api/fotos-aniversario`

**Parámetros (Query String):**
- `anio` (opcional): Filtrar por año específico

**Respuesta de Ejemplo:**
```json
{
    "success": true,
    "total": 5,
    "fotos": [
        {
            "id": 1,
            "titulo": "Aniversario 50 años",
            "descripcion": "Celebración del cincuentenario",
            "imagen": "http://localhost/storage/aniversario/foto1.jpg",
            "thumbnail": "http://localhost/storage/aniversario/thumbnails/foto1.jpg",
            "anio": 2024,
            "fecha": "15/11/2024",
            "orden": 0
        }
    ]
}
```

---

## 🎯 Ejemplo de Uso Completo

### 1. Agregar el Modal en el Layout Principal

```blade
{{-- resources/views/layouts/public.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <!-- ... -->
</head>
<body>
    <!-- Contenido del sitio -->
    
    @include('public.components.modal-fotos-aniversario')
</body>
</html>
```

### 2. Agregar Fotos desde el Admin

1. Acceder a: `/admin/contenido/fotos-aniversario`
2. Click en "Nueva Foto"
3. Subir imagen y completar datos
4. Guardar

### 3. Visualizar en el Frontend

- El botón flotante aparecerá automáticamente
- Click en el botón para abrir la galería
- Filtrar por año si es necesario
- Click en cualquier foto para ampliarla

---

## 💡 Recomendaciones

### Imágenes
- **Formato preferido:** JPG o WEBP (mejor compresión)
- **Resolución recomendada:** 1920x1080px
- **Tamaño máximo imagen principal:** 10MB
- **Tamaño máximo miniatura:** 5MB
- Las miniaturas son opcionales pero **recomendadas** para mejorar la velocidad de carga

### Organización
- Usar el campo "Orden" para controlar la secuencia de visualización
- Números más bajos aparecen primero (0, 1, 2, ...)
- Asignar años para facilitar el filtrado
- Agregar descripciones detalladas para mejor contexto

### Rendimiento
- Usar miniaturas para galerías grandes
- Optimizar imágenes antes de subirlas
- Desactivar fotos antiguas si no se necesitan

---

## 🔒 Seguridad

- ✅ Todas las rutas de admin están protegidas por autenticación
- ✅ Validación de tipos de archivo (solo imágenes)
- ✅ Límites de tamaño de archivo
- ✅ Protección CSRF en todos los formularios
- ✅ Solo fotos activas son visibles en el frontend

---

## 🐛 Resolución de Problemas

### El modal no se muestra
- Verificar que Bootstrap y jQuery estén cargados
- Verificar que el componente esté incluido en la vista

### Las fotos no aparecen
- Verificar que las fotos estén marcadas como "Activo"
- Revisar en el navegador la consola de JavaScript
- Verificar que la ruta `/api/fotos-aniversario` funcione

### Las imágenes no se ven
- Ejecutar: `php artisan storage:link`
- Verificar permisos de la carpeta `storage/app/public`

### Error al subir imágenes
- Verificar límites de `upload_max_filesize` en php.ini
- Verificar límites de `post_max_size` en php.ini
- Verificar permisos de escritura en storage

---

## 📞 Soporte

Para cualquier duda o problema con el sistema de fotos de aniversario, contactar al equipo de desarrollo.

**¡Sistema implementado y funcionando correctamente! 🎉**


