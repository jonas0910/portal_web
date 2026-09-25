# 🔧 CREAR TABLAS DEL GESTOR DE CONTENIDO

## ⚠️ PROBLEMA ACTUAL

El sistema indica que **faltan tablas del gestor de contenido**.

---

## 📋 TABLAS DEL GESTOR DE CONTENIDO

Estas son las 4 tablas principales:

### 1. `paginas`
Almacena las páginas dinámicas del sitio (Inicio, Servicios, Contacto, etc.)

### 2. `menus`
Almacena los menús de navegación (principal, footer, enlaces rápidos)

### 3. `banners`
Almacena los banners y sliders del carousel

### 4. `configuracion_sitio`
Almacena la configuración general del sitio

---

## ✅ SOLUCIÓN RÁPIDA

### Opción 1: Ejecutar BAT (RECOMENDADO)

**Doble click en:**
```
crear_tablas.bat
```

Este script:
1. Ejecuta `php artisan db:arreglar-tablas`
2. Crea TODAS las tablas que falten
3. Te muestra el resultado

### Opción 2: Comando Manual

```bash
php artisan db:arreglar-tablas
```

**Output esperado:**
```
Creando todas las tablas del sistema...

✓ Tabla users creada
✓ Tabla roles creada
✓ Tabla permissions creada
✓ Tabla model_has_roles creada
✓ Tabla notarios creada
✓ Tabla categoria_documentos creada
✓ Tabla documentos creada
✓ Tabla servicios creada
✓ Tabla contactos creada
✓ Tabla paginas creada          ← GESTOR CONTENIDO
✓ Tabla menus creada             ← GESTOR CONTENIDO
✓ Tabla banners creada           ← GESTOR CONTENIDO
✓ Tabla configuracion_sitio creada ← GESTOR CONTENIDO
✓ Tabla cache creada/corregida
✓ Tabla cache_locks creada
✓ Tabla sessions creada
✓ Tabla password_resets creada
✓ Tabla temas creada
✓ Tabla citas creada
✓ Tabla eventos creada
✓ Tabla notificaciones creada

¡Todas las tablas han sido creadas exitosamente!
El sistema ya debería funcionar correctamente.
```

---

## 📦 DESPUÉS DE CREAR LAS TABLAS

### Paso 1: Poblar con Datos de Ejemplo

```bash
php artisan db:seed --class=ContenidoSeeder
```

Este seeder crea:
- 5 páginas de ejemplo (Inicio, Servicios, Contacto, etc.)
- 8 menús (principal, footer)
- 3 banners con imágenes
- Configuración del sitio

### Paso 2: Crear Temas

```bash
php artisan db:seed --class=TemaSeeder
```

Crea 6 temas predefinidos con widgets configurados.

### Paso 3: Limpiar Cachés

```bash
php artisan cache:clear
php artisan view:clear
```

### Paso 4: Verificar

Abre:
```
http://127.0.0.1:9000
```

Deberías ver:
- ✅ Banners en el carousel
- ✅ Menús de navegación
- ✅ Contenido de la página de inicio
- ✅ Widgets configurados

---

## 🧪 VERIFICAR QUE SE CREARON

### Opción A: Desde Tinker

```bash
php artisan tinker
```

```php
// Verificar tablas del gestor de contenido
echo "Páginas: " . \App\Models\Pagina::count() . "\n";
echo "Menús: " . \App\Models\Menu::count() . "\n";
echo "Banners: " . \App\Models\Banner::count() . "\n";
echo "Config: " . \App\Models\ConfiguracionSitio::count() . "\n";
exit
```

**Si todas dan 0:** Las tablas existen pero están vacías → ejecuta los seeders

**Si da error:** La tabla no existe → ejecuta `db:arreglar-tablas`

### Opción B: Desde MySQL

```sql
SHOW TABLES LIKE '%paginas%';
SHOW TABLES LIKE '%menus%';
SHOW TABLES LIKE '%banners%';
SHOW TABLES LIKE '%configuracion%';
```

---

## 🔍 ESTRUCTURA DE LAS TABLAS

### Tabla: paginas
```sql
- id
- titulo
- slug (único)
- descripcion
- contenido (HTML)
- meta_titulo
- meta_descripcion
- meta_keywords
- imagen_principal
- plantilla
- activa
- mostrar_en_menu
- orden
- tipo
- timestamps
- deleted_at
```

### Tabla: menus
```sql
- id
- nombre
- url
- url_externa
- icono
- ubicacion (principal, footer, lateral)
- orden
- parent_id
- activo
- abrir_nueva_ventana
- timestamps
```

### Tabla: banners
```sql
- id
- titulo
- descripcion
- imagen
- imagen_movil
- url
- boton_texto
- boton_url
- posicion (principal, secundario, footer)
- orden
- activo
- fecha_inicio
- fecha_fin
- timestamps
```

### Tabla: configuracion_sitio
```sql
- id
- clave (único)
- valor (texto largo)
- tipo (texto, numero, booleano, json)
- categoria
- descripcion
- timestamps
```

---

## 🚀 PASOS FINALES

### 1. Crear Tablas

```bash
php artisan db:arreglar-tablas
```

### 2. Poblar Datos

```bash
php artisan db:seed --class=ContenidoSeeder
php artisan db:seed --class=TemaSeeder
```

### 3. Limpiar Cachés

```bash
php artisan cache:clear
php artisan view:clear
```

### 4. Verificar

```
http://127.0.0.1:9000
```

---

## 📄 ARCHIVOS ÚTILES

- **`crear_tablas.bat`** - Script para crear tablas automáticamente
- **`VERIFICACION_TABLAS.md`** - Lista completa de tablas
- **`verificar_tablas.php`** - Script de verificación detallada

---

**Ejecuta `crear_tablas.bat` (doble click) o el comando manual:**
```bash
php artisan db:arreglar-tablas
```

Y dime qué tablas crea. Eso me dirá exactamente cuáles faltaban. 🎯
