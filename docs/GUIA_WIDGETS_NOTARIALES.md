# 📊 GUÍA COMPLETA DE WIDGETS PARA SISTEMA DE NOTARÍAS

## 🔍 **DÓNDE ESTÁN LOS WIDGETS:**

### **1. CONFIGURACIÓN EN LA BASE DE DATOS**

Los widgets están guardados en:
- **Tabla:** `temas`
- **Columna:** `configuracion` (JSON)
- **Ubicación:** `http://127.0.0.1:9000/admin/temas`

---

## 📋 **WIDGETS CONFIGURADOS EN CADA TEMA:**

### **Tema Clásico Legal:**
```json
{
  "widgets": {
    "calendario_audiencias": true,
    "documentos_pendientes": true,
    "estadisticas_dashboard": true,
    "notificaciones": true,
    "citas_proximas": true
  },
  "calendario": {
    "mostrar_en_home": true,
    "eventos_por_pagina": 10,
    "color_eventos": "#1e3a8a"
  }
}
```

### **Tema Ejecutivo Premium:**
```json
{
  "widgets": {
    "calendario_audiencias": true,
    "documentos_pendientes": true,
    "estadisticas_dashboard": true,
    "notificaciones": true,
    "citas_proximas": true,
    "grafica_mensual": true,
    "actividad_reciente": true
  }
}
```

---

## 🎯 **CÓMO ACCEDER A LA CONFIGURACIÓN DE WIDGETS:**

### **Desde el Código:**

```php
// En un controlador o vista
$tema = \App\Models\Tema::obtenerPredeterminado();

// Obtener configuración de widgets
$widgets = $tema->configuracion['widgets'] ?? [];

// Verificar si un widget está habilitado
if ($widgets['calendario_audiencias'] ?? false) {
    // Mostrar calendario
}
```

### **Ejemplo en una vista Blade:**

```blade
@php
    $tema = \App\Models\Tema::obtenerPredeterminado();
    $widgets = $tema->configuracion['widgets'] ?? [];
@endphp

{{-- Mostrar calendario si está habilitado --}}
@if($widgets['calendario_audiencias'] ?? false)
    <div class="widget-calendario">
        {{-- Código del calendario aquí --}}
    </div>
@endif
```

---

## 🏗️ **PARA IMPLEMENTAR LOS WIDGETS VISUALMENTE:**

Los widgets están **configurados** pero necesitan ser **implementados** en las vistas. Te voy a crear los componentes de widgets.

### **Ubicación de los Widgets:**

**Panel Administrativo:**
- Dashboard principal: `resources/views/admin/dashboard.blade.php`
- Vista del tema: Usa la configuración del tema activo

**Página Pública:**
- Inicio: `resources/views/public/index.blade.php`
- Widgets públicos según tema

---

## 📦 **WIDGETS QUE SE PUEDEN CREAR:**

### **1. Calendario de Audiencias**
```php
// Ubicación: resources/views/components/widgets/calendario-audiencias.blade.php
// Muestra: Calendario mensual con eventos
// Fuente de datos: Tabla de citas/audiencias
```

### **2. Documentos Pendientes**
```php
// Ubicación: resources/views/components/widgets/documentos-pendientes.blade.php
// Muestra: Lista de documentos sin firmar
// Fuente de datos: Tabla documentos WHERE estado = 'pendiente'
```

### **3. Estadísticas Dashboard**
```php
// Ubicación: resources/views/components/widgets/estadisticas.blade.php
// Muestra: Contadores y gráficos
// Fuente de datos: Count de notarios, documentos, servicios
```

### **4. Notificaciones**
```php
// Ubicación: resources/views/components/widgets/notificaciones.blade.php
// Muestra: Badge con número de notificaciones
// Fuente de datos: Tabla notificaciones
```

### **5. Citas Próximas**
```php
// Ubicación: resources/views/components/widgets/citas-proximas.blade.php
// Muestra: Lista de citas del día/semana
// Fuente de datos: Tabla citas WHERE fecha >= hoy
```

---

## 🎨 **DÓNDE VER LA CONFIGURACIÓN DE WIDGETS:**

### **En el Panel Admin:**

1. Ve a: `http://127.0.0.1:9000/admin/temas`
2. Edita cualquier tema
3. La configuración JSON incluye todos los widgets

### **En la Base de Datos:**

**phpMyAdmin:**
1. Abre: `http://localhost/phpmyadmin`
2. Selecciona: `cnotarios`
3. Tabla: `temas`
4. Columna: `configuracion`
5. Verás el JSON con todos los widgets

---

## 💡 **ESTADO ACTUAL:**

✅ **Configuración de widgets:** CREADA (en JSON de cada tema)
❌ **Componentes visuales:** NO IMPLEMENTADOS (solo configuración)
❌ **Tablas adicionales:** Faltan (citas, eventos, notificaciones)

---

## 🚀 **PARA IMPLEMENTAR LOS WIDGETS VISUALMENTE:**

Necesitas:

1. **Crear tablas adicionales:**
   - `citas` - Para el calendario
   - `eventos` - Eventos del calendario
   - `notificaciones` - Sistema de notificaciones

2. **Crear componentes Blade:**
   - `resources/views/components/widgets/` - Carpeta de widgets
   - Cada widget en su propio archivo

3. **Actualizar el dashboard:**
   - Leer configuración del tema activo
   - Renderizar widgets habilitados

---

## 📍 **RESUMEN:**

**Los widgets ESTÁN CONFIGURADOS en cada tema**, pero son solo **configuración JSON**.

Para **verlos funcionando**, necesito crear:
1. Las vistas de cada widget
2. Las tablas para calendario y eventos
3. La lógica del dashboard que lea la configuración

**¿Quieres que implemente los widgets visuales ahora?** 🛠️

