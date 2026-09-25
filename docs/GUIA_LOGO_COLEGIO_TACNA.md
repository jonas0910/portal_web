# 📋 Guía: Colocar Logo del Colegio de Notarios de Tacna

## ✅ Implementación Completada

He agregado una sección superior al menú donde se mostrará el logo del Colegio de Notarios de Tacna.

### 📁 Estructura Creada

```
storage/app/public/logos/
└── (Aquí deberás subir el logo)
```

### 🎨 Diseño Implementado

- **Barra superior negra** con el logo centrado
- **Fondo**: Negro (#000000)
- **Altura**: 80px (desktop) / 60px (móvil)
- **Borde inferior**: Color primario del tema
- **Responsive**: Se adapta automáticamente a móviles

## 📤 Cómo Subir el Logo

### Opción 1: Subir Archivo Directamente

1. **Copiar el logo** a la carpeta:
   ```
   storage/app/public/logos/logo-colegio-notarios-tacna.png
   ```
   O también puedes usar:
   ```
   storage/app/public/logos/logo-colegio-notarios-tacna.jpg
   ```

2. **Verificar que existe**:
   ```bash
   # Windows PowerShell
   dir storage\app\public\logos
   
   # Linux/Mac
   ls storage/app/public/logos/
   ```

3. **Acceder al sitio**:
   ```
   http://127.0.0.1:9000/
   ```
   El logo debería aparecer automáticamente.

### Opción 2: Configurar URL Externa

Si prefieres usar una URL externa, puedes configurarla en la base de datos:

```php
// Usando tinker
php artisan tinker

// Crear o actualizar configuración
\App\Models\ConfiguracionSitio::updateOrCreate(
    ['clave' => 'logo_header'],
    ['valor' => 'https://ejemplo.com/logo.png', 'categoria' => 'general']
);
```

### Opción 3: Usar Gestor de Configuración (si existe)

Si tienes un panel de administración para configuraciones:
1. Buscar configuración: `logo_header`
2. Ingresar la ruta o URL del logo
3. Guardar

## 🎯 Formatos Soportados

- ✅ PNG (recomendado para logos con transparencia)
- ✅ JPG/JPEG
- ✅ SVG (si el navegador lo soporta)
- ✅ WebP

## 📐 Tamaños Recomendados

- **Ancho**: 300-500 píxeles
- **Alto**: Proporcional (mantener relación de aspecto)
- **Resolución**: 72-150 DPI es suficiente para web
- **Tamaño archivo**: Idealmente menos de 200 KB

## 🔧 Personalización

### Cambiar la Ruta del Logo

Edita el archivo `resources/views/layouts/public.blade.php`:

```php
// Buscar esta línea (aproximadamente línea 161):
$logoPath = \App\Models\ConfiguracionSitio::obtener('logo_header', 'storage/logos/logo-colegio-notarios-tacna.png');

// Cambiar la ruta por defecto:
$logoPath = \App\Models\ConfiguracionSitio::obtener('logo_header', 'storage/logos/tu-logo.png');
```

### Cambiar el Color de Fondo

En el mismo archivo, busca `.logo-header`:

```css
.logo-header {
    background-color: #000000; /* Cambiar a otro color si prefieres */
    /* Ejemplos:
    background-color: #1a1a1a; (gris oscuro)
    background-color: #ffffff; (blanco)
    background-color: var(--primary-color); (color del tema)
    */
}
```

### Cambiar la Altura del Logo

```css
.logo-header img {
    max-height: 80px; /* Cambiar a otro valor, ej: 100px */
}
```

### Centrar o Alinear a la Izquierda

```css
.logo-header .container {
    justify-content: center; /* center, flex-start (izquierda), flex-end (derecha) */
}
```

## 🚀 Verificar que Funciona

### 1. Verificar Archivo
```bash
# Verificar que el archivo existe
dir storage\app\public\logos  # Windows
ls storage/app/public/logos   # Linux/Mac
```

### 2. Verificar Enlace Simbólico
```bash
php artisan storage:link
```

### 3. Ver en el Navegador
```
1. Abrir: http://127.0.0.1:9000/
2. Verificar que el logo aparece en la parte superior
3. Si no aparece, presionar Ctrl + Shift + R (recarga forzada)
```

### 4. Verificar Consola del Navegador
```
1. Presionar F12
2. Ir a pestaña "Consola"
3. Buscar errores de carga de imagen
4. Si hay error 404, verificar que la ruta es correcta
```

## 🐛 Solución de Problemas

### Problema: El logo no aparece

**Solución 1: Verificar que el archivo existe**
```bash
# Verificar en disco
dir storage\app\public\logos

# Si no existe, crearlo manualmente o subirlo
```

**Solución 2: Verificar enlace simbólico**
```bash
php artisan storage:link
```

**Solución 3: Verificar permisos (Linux/Mac)**
```bash
chmod -R 775 storage/app/public/logos
chown -R www-data:www-data storage/app/public/logos
```

**Solución 4: Limpiar caché**
```bash
php artisan view:clear
php artisan cache:clear
php artisan config:clear
```

### Problema: El logo se ve muy grande/pequeño

**Solución**: Ajustar el CSS en `resources/views/layouts/public.blade.php`:
```css
.logo-header img {
    max-height: 100px; /* Aumentar o disminuir según necesites */
}
```

### Problema: El logo no está centrado

**Solución**: Verificar el CSS:
```css
.logo-header .container {
    justify-content: center; /* Debe estar en 'center' */
}
```

### Problema: Error 404 al cargar el logo

**Causa**: La ruta del archivo no es correcta

**Solución**:
1. Verificar que el archivo existe en `storage/app/public/logos/`
2. Verificar que el nombre coincide exactamente
3. Verificar que el enlace simbólico existe: `php artisan storage:link`
4. Verificar la URL generada: debería ser `http://127.0.0.1:9000/storage/logos/logo-colegio-notarios-tacna.png`

## 📝 Configuración en Base de Datos (Opcional)

Si quieres que el logo sea configurable desde el admin:

```php
// Crear configuración en la base de datos
\App\Models\ConfiguracionSitio::create([
    'clave' => 'logo_header',
    'valor' => 'storage/logos/logo-colegio-notarios-tacna.png',
    'categoria' => 'general',
    'tipo' => 'text',
    'descripcion' => 'Logo del Colegio de Notarios de Tacna para el header'
]);
```

## 🎨 Estructura Visual Final

```
┌─────────────────────────────────────────┐
│  [LOGO COLEGIO DE NOTARIOS DE TACNA]   │  ← Barra negra con logo
├─────────────────────────────────────────┤
│  🏛️ Portal de Notarios    [Menú ☰]    │  ← Navbar con menú
└─────────────────────────────────────────┘
```

## ✅ Checklist de Implementación

- [x] Sección superior creada
- [x] Estilos CSS agregados
- [x] Responsive implementado
- [x] Fallback a texto si el logo no carga
- [x] Carpeta de logos creada
- [ ] Logo subido físicamente
- [ ] Enlace simbólico verificado
- [ ] Visualización probada en navegador

## 📞 Próximos Pasos

1. **Subir el logo** a `storage/app/public/logos/logo-colegio-notarios-tacna.png`
2. **Verificar** que el enlace simbólico existe: `php artisan storage:link`
3. **Probar** en el navegador: http://127.0.0.1:9000/
4. **Ajustar** tamaño/posición si es necesario

---

**Fecha de Implementación**: 5 de Noviembre, 2025  
**Estado**: ✅ **Sistema Listo para Recibir el Logo**

El sistema está completamente configurado. Solo necesitas subir el archivo del logo a la carpeta indicada.

