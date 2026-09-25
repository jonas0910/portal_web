# ✅ OPCIÓN PARA AGREGAR LOGOS AL NAVBAR RESTAURADA

## 📍 UBICACIÓN

La opción para subir logos ahora está en:

```
Admin → Contenido → Configuración del Sitio
URL: http://127.0.0.1:9000/admin/contenido/configuracion
```

---

## 🖼️ LOGOS DISPONIBLES

Ahora puedes configurar **2 logos diferentes**:

### 1. 📌 Logo Header
- **Campo**: `logo_header`
- **Ubicación**: Barra negra superior (arriba del navbar)
- **Tamaño recomendado**: 200x80px
- **Descripción**: Logo principal en la cabecera del sitio

### 2. 🏷️ Logo Navbar
- **Campo**: `logo_navbar`
- **Ubicación**: Barra de navegación (al lado del nombre del sitio)
- **Tamaño recomendado**: 50x50px
- **Descripción**: Logo pequeño en la barra de navegación

---

## 🚀 CÓMO SUBIR LOS LOGOS

### Paso 1: Acceder a Configuración
```
1. Ir a: http://127.0.0.1:9000/admin
2. Usuario: admin@notariatacna.pe
3. Contraseña: admin123
4. Menú → Contenido → Configuración del Sitio
```

### Paso 2: Encontrar los Campos de Logo

En la sección **"General"** verás:

```
┌─────────────────────────────────────────┐
│ General                                 │
├─────────────────────────────────────────┤
│ nombre_sitio                            │
│ Portal de Notarios de Tacna             │
├─────────────────────────────────────────┤
│ logo_header                             │
│ Logo principal en la cabecera del sitio │
│ (recomendado: 200x80px)                 │
│ [ Seleccionar archivo ]                 │
├─────────────────────────────────────────┤
│ logo_navbar                             │
│ Logo en la barra de navegación          │
│ (recomendado: 50x50px)                  │
│ [ Seleccionar archivo ]                 │
└─────────────────────────────────────────┘
```

### Paso 3: Subir las Imágenes

1. **Para Logo Header**:
   - Clic en "Seleccionar archivo" del campo `logo_header`
   - Seleccionar imagen (JPG, PNG, GIF, WebP)
   - Tamaño máximo: 5MB

2. **Para Logo Navbar**:
   - Clic en "Seleccionar archivo" del campo `logo_navbar`
   - Seleccionar imagen (JPG, PNG, GIF, WebP)
   - Tamaño máximo: 5MB

### Paso 4: Guardar

- Clic en **"Guardar Configuraciones"** al final de la página
- Verás mensaje de éxito: ✅ "Configuraciones actualizadas correctamente"

---

## 👀 DÓNDE SE VERÁN LOS LOGOS

### Logo Header (logo_header)
```
┌─────────────────────────────────────────┐
│ ███████████████████████████████████████ │ ← Barra negra
│      [LOGO HEADER]                      │ ← Logo grande aquí
└─────────────────────────────────────────┘
```

Visible en: **TODAS las páginas públicas**
- Página principal (/)
- Servicios (/servicios)
- Notarios (/notarios)
- Contacto (/contacto)
- Etc.

### Logo Navbar (logo_navbar)
```
┌─────────────────────────────────────────┐
│ [🏷️] Portal de Notarios | Menú ≡       │
│  ↑                                      │
│  Logo Navbar                            │
└─────────────────────────────────────────┘
```

Visible en: **Barra de navegación de todas las páginas**

---

## ✏️ EDITAR O ELIMINAR LOGOS

### Ver Logo Actual

Si ya subiste un logo, verás:

```
┌─────────────────────────────────────────┐
│ logo_navbar                             │
├─────────────────────────────────────────┤
│ ┌─────────────┐                         │
│ │   [LOGO]    │ ← Preview del logo      │
│ └─────────────┘                         │
│ Imagen actual                           │
│                                         │
│ ☐ 🗑️ Eliminar esta imagen              │
│                                         │
│ [ Seleccionar archivo nuevo ]           │
└─────────────────────────────────────────┘
```

### Cambiar Logo

1. **Sin eliminar el anterior**: Solo selecciona un nuevo archivo
2. El logo anterior se reemplazará automáticamente

### Eliminar Logo

1. Marcar checkbox: ☑️ **"Eliminar esta imagen"**
2. NO seleccionar nuevo archivo
3. Guardar
4. El logo se eliminará y volverá a mostrar el icono por defecto

---

## 📏 TAMAÑOS RECOMENDADOS

### Logo Header
```
Ancho: 200px - 300px
Alto: 60px - 100px
Proporción: Horizontal (logo amplio)
Formato: PNG con fondo transparente (recomendado)
Resolución: 2x para pantallas retina (400x120px)
```

**Ejemplo**: 
- Logo del Colegio de Notarios: 250x80px
- Fondo transparente PNG
- Colores: Blanco o claros (la barra es negra)

### Logo Navbar
```
Ancho: 40px - 60px
Alto: 40px - 60px
Proporción: Cuadrado o circular
Formato: PNG con fondo transparente
Resolución: 2x para pantallas retina (100x100px)
```

**Ejemplo**:
- Escudo o símbolo: 50x50px
- Circular o cuadrado
- Colores: Cualquiera (fondo claro)

---

## 🎨 TIPS DE DISEÑO

### Para Logo Header

✅ **Hacer**:
- Usar fondo transparente
- Colores claros (la barra es negra)
- Logo horizontal
- Alta resolución
- Formato PNG

❌ **Evitar**:
- Logos muy altos (deforman la barra)
- Colores oscuros (no se verán bien)
- Formato JPG con fondo blanco
- Resolución baja

### Para Logo Navbar

✅ **Hacer**:
- Diseño simple y reconocible
- Proporción cuadrada
- Alta resolución
- Colores distintivos

❌ **Evitar**:
- Logos con mucho detalle
- Textos pequeños (no se leerán)
- Proporciones muy rectangulares

---

## 🔍 VERIFICAR LOS LOGOS

### Después de Guardar

1. **Ver en el admin**:
   - Refresca la página de configuración
   - Deberías ver el preview del logo

2. **Ver en el portal**:
   ```
   http://127.0.0.1:9000/
   ```
   - Presiona: `Ctrl + Shift + R` (recarga forzada)
   - Deberías ver ambos logos

3. **Ver en todas las páginas**:
   - /servicios
   - /notarios
   - /contacto
   - Etc.

---

## 🐛 SOLUCIÓN DE PROBLEMAS

### Logo no se ve después de subir

**Causa**: Caché del navegador

**Solución**:
```
1. Presionar Ctrl + Shift + R (recarga forzada)
2. O borrar caché del navegador
3. O probar en modo incógnito
```

### Logo se ve pixelado

**Causa**: Resolución muy baja

**Solución**:
```
1. Usar imagen de mayor resolución
2. Recomendado: 2x del tamaño mostrado
3. Ejemplo: Si se muestra 50x50px, subir 100x100px
```

### Logo se ve deformado

**Causa**: Proporción incorrecta

**Solución**:
```
1. Logo Header: Usar proporción horizontal (3:1 o 4:1)
2. Logo Navbar: Usar proporción cuadrada (1:1)
3. Editar imagen antes de subir
```

### No aparece el campo para subir logo

**Causa**: Configuración no existe

**Solución**:
```bash
# Ejecutar el seeder para crear las configuraciones
php artisan db:seed --class=DatosEjemploCompletosSeeder
```

---

## 📊 ESTADO ACTUAL

### Configuraciones de Logos

| Campo | Tipo | Categoría | Estado |
|-------|------|-----------|--------|
| logo_header | Imagen | General | ✅ Creado |
| logo_navbar | Imagen | General | ✅ Creado |

### Funcionalidades

| Función | Estado |
|---------|--------|
| Subir logo header | ✅ Funcional |
| Subir logo navbar | ✅ Funcional |
| Ver preview | ✅ Funcional |
| Eliminar logos | ✅ Funcional |
| Cambiar logos | ✅ Funcional |
| Validación de formatos | ✅ Funcional |
| Tamaño máximo 5MB | ✅ Funcional |

---

## 📸 EJEMPLO DE USO

### Antes de Subir Logos
```
Header:  [Barra negra vacía]
Navbar:  [🏛️ icono] Portal de Notarios
```

### Después de Subir Logos
```
Header:  [Logo del Colegio de Notarios]
Navbar:  [Escudo] Portal de Notarios
```

---

## 🎯 RESUMEN RÁPIDO

1. **Acceder**: Admin → Contenido → Configuración del Sitio
2. **Buscar**: Sección "General"
3. **Subir**: 
   - `logo_header` (200x80px)
   - `logo_navbar` (50x50px)
4. **Guardar**: Clic en "Guardar Configuraciones"
5. **Verificar**: http://127.0.0.1:9000/ (Ctrl + Shift + R)

---

**Fecha**: 5 de Noviembre, 2025  
**Estado**: ✅ **Opción para Agregar Logos Restaurada y Funcional**

¡Ahora puedes subir los logos del Colegio de Notarios de Tacna! 🎉

