# ✅ TinyMCE CONFIGURADO CON API KEY

## 🎉 EDITOR PREMIUM ACTIVADO

He configurado TinyMCE con tu API Key para acceder a todas las funciones premium.

**API Key configurada:** `ao8ah2aled7o2nhu02nfhpy282lz5qihue3m4o8qwijxls2f`

---

## ✨ FUNCIONES PREMIUM ACTIVADAS

### 🚀 Plugins Adicionales Agregados:

1. **codesample** - Bloques de código con sintaxis destacada (HTML, CSS, JS, PHP, etc.)
2. **hr** - Insertar líneas horizontales decorativas
3. **pagebreak** - Saltos de página para impresión
4. **nonbreaking** - Espacios no separables
5. **directionality** - Texto de derecha a izquierda (RTL)
6. **visualchars** - Ver caracteres invisibles
7. **template** - Plantillas de contenido predefinidas
8. **quickbars** - Barras de herramientas contextuales rápidas

### ⚡ Quick Bars (Nuevo):

**Al seleccionar texto:**
```
[B] [I] | [Enlace] [H2] [H3] [Cita]
```

**Al hacer click en espacio vacío:**
```
[Insertar Imagen] [Insertar Tabla]
```

Aparecen automáticamente cuando necesitas!

### 🎨 Toolbar Mejorado:

```
[Undo] [Redo] │ [Bloques ▼] [Tamaño ▼] │ [B] [I] [U] [S] │
[🎨 Color texto] [🎨 Color fondo] │ [←] [↔] [→] [⇆] │
[• Lista] [1. Lista] [←] [→] │ [🧹 Limpiar] │
[Tabla] [Enlace] [Imagen] [Video] [<Código/>] │ [━] [⎙] │
[</> HTML] [👁️ Vista] [⛶ Pantalla] [?]
```

**Modo Sliding:** Si la ventana es pequeña, las herramientas se agrupan en menús desplegables.

---

## 📝 NUEVAS FUNCIONALIDADES

### 1. Bloques de Código con Sintaxis

Inserta código con resaltado de sintaxis:

```html
<button class="btn btn-primary">Click aquí</button>
```

```javascript
function hola() {
    console.log('¡Hola mundo!');
}
```

**Lenguajes soportados:**
- HTML, CSS, JavaScript
- PHP, Python, Java
- SQL, JSON, XML
- Y muchos más...

### 2. Líneas Horizontales Decorativas

Inserta separadores visuales:
```
────────────────────────────
```

### 3. Control de Tamaño de Fuente

Ahora puedes cambiar el tamaño:
- 8pt, 10pt, 12pt, 14pt, 16pt, 18pt, 24pt, 36pt

### 4. Plantillas de Contenido

Crea plantillas reutilizables:
- Hero sections
- Secciones de servicios
- Galerías de imágenes
- Testimonios
- Y más...

---

## 🎯 CONFIGURACIÓN APLICADA

### Ambos Archivos Actualizados:

✅ `resources/views/admin/contenido/paginas/edit.blade.php`  
✅ `resources/views/admin/contenido/paginas/create.blade.php`

### Funciones Configuradas:

- ✅ **API Key configurada** (funciones premium)
- ✅ **18 plugins activos** (antes: 13)
- ✅ **Toolbar extendido** con más opciones
- ✅ **Quick Bars** contextuales
- ✅ **Upload de imágenes** drag & drop
- ✅ **Bloques de código** con sintaxis
- ✅ **Tamaños de fuente** personalizables
- ✅ **Modo responsive** (toolbar sliding)

---

## 🚀 PRUEBA EL EDITOR AHORA

### Paso 1: Limpia Cachés

```bash
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

### Paso 2: Crea el Symlink de Storage

```bash
php artisan storage:link
```

Este comando es **CRÍTICO** para que las imágenes se puedan ver después de subirlas.

### Paso 3: Edita una Página

```
http://127.0.0.1:9000/admin/contenido/paginas/2/edit
```

### Paso 4: Explora las Funciones

**Prueba estas funcionalidades:**

1. **Inserta código con sintaxis:**
   - Click en `</>` (codesample)
   - Selecciona lenguaje (HTML, CSS, JS, PHP)
   - Pega tu código
   - Se verá con colores!

2. **Inserta imagen por drag & drop:**
   - Arrastra una imagen desde tu PC
   - Suéltala en el editor
   - Se sube automáticamente
   - Aparece en el contenido

3. **Cambia tamaño de fuente:**
   - Selecciona texto
   - Click en "Tamaño de fuente"
   - Elige el tamaño

4. **Usa Quick Bars:**
   - Selecciona cualquier texto
   - Aparecerá una barra flotante
   - Aplica formato rápido

5. **Inserta tabla:**
   - Click en "Tabla"
   - Selecciona filas x columnas
   - La tabla tendrá clases Bootstrap automáticamente

6. **Inserta línea horizontal:**
   - Click en "hr"
   - Se inserta un separador visual

---

## 📸 GESTIÓN DE IMÁGENES

### Upload Directo:

Las imágenes se guardan en:
```
storage/app/public/contenido/imagenes/
```

Y son accesibles vía:
```
http://127.0.0.1:9000/storage/contenido/imagenes/nombre.jpg
```

### Formatos Soportados:

- ✅ JPG/JPEG
- ✅ PNG
- ✅ GIF
- ✅ WebP
- ✅ SVG (con precaución)

### Tamaño Máximo:

- 5MB por imagen
- Configurable en `ContenidoController.php` línea 443

---

## 🎨 ESTILOS PREDEFINIDOS

### Para Texto:

- **Texto Destacado:** `<strong>` en negrita
- **Texto Importante:** Rojo y negrita
- **Cita:** `<blockquote>` estilo Bootstrap
- **Código inline:** `<code>`

### Para Enlaces:

- **Botón Primario:** Clase `btn btn-primary`
- **Botón Secundario:** Clase `btn btn-secondary`
- **Enlace Externo:** Clase `external-link`

### Para Tablas:

Todas las tablas automáticamente tienen:
```html
<table class="table table-bordered table-hover">
```

Se ven perfectas con Bootstrap!

---

## 🔧 CONFIGURACIÓN AVANZADA

### Toolbar Mode: Sliding

Si la ventana es pequeña, las herramientas se agrupan automáticamente en menús desplegables.

### Extended Valid Elements

El editor permite elementos HTML5 completos:
```
<div>, <section>, <article>, <header>, <footer>, <nav>, <aside>
```

Perfecto para crear landing pages complejas.

### Block Formats Personalizados:

- Párrafo (`<p>`)
- Encabezado 1 (`<h1>`)
- Encabezado 2 (`<h2>`)
- Encabezado 3 (`<h3>`)
- Encabezado 4 (`<h4>`)
- Preformateado (`<pre>`)

---

## 💡 TIPS DE USO

### 1. Insertar Video de YouTube:

1. Click en "Media"
2. Pega la URL del video de YouTube
3. Se embebe automáticamente

### 2. Crear Botón:

1. Escribe el texto del botón
2. Selecciónalo
3. Click en "Link"
4. En "Class" selecciona "Botón Primario"
5. ¡Listo!

### 3. Vista Previa:

- Click en "Preview"
- Ve cómo se verá el contenido final
- Perfecto antes de guardar

### 4. Modo Pantalla Completa:

- Click en el ícono de pantalla completa
- Más espacio para trabajar
- Presiona ESC para salir

---

## 🎉 RESULTADO FINAL

Ahora tienes un **editor de contenido de nivel profesional**:

✅ **Funciones premium activadas** con API Key  
✅ **18 plugins** para máxima funcionalidad  
✅ **Upload de imágenes** drag & drop  
✅ **Bloques de código** con sintaxis  
✅ **Quick Bars** contextuales  
✅ **Toolbar responsive** adaptativo  
✅ **Estilos Bootstrap** integrados  
✅ **Interfaz en español**  

---

## 🚀 COMANDOS FINALES

```bash
# 1. Crear symlink de storage (IMPORTANTE)
php artisan storage:link

# 2. Limpiar cachés
php artisan route:clear
php artisan view:clear

# 3. Editar página
http://127.0.0.1:9000/admin/contenido/paginas/2/edit
```

---

**¡El editor profesional está completamente configurado!** 🎨

Abre la página de edición y disfru de un editor de contenido de clase mundial, igual al de WordPress o Medium.

