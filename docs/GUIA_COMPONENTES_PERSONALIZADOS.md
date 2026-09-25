# 🎨 GUÍA COMPLETA: COMPONENTES PERSONALIZADOS

## 📍 **UBICACIÓN DE LOS COMPONENTES**

```
D:\cursor_proy\cnotarios\resources\views\components\
```

Todos los componentes Blade se guardan aquí.

---

## 🛠️ **CÓMO CREAR UN COMPONENTE PERSONALIZADO**

### **Método 1: Crear Archivo Directamente (Recomendado)**

#### **Paso 1: Crear el archivo**

En tu editor de código o explorador de archivos:

```
D:\cursor_proy\cnotarios\resources\views\components\mi-componente.blade.php
```

#### **Paso 2: Escribir el código**

```blade
{{--
    Componente: Mi Componente Personalizado
    Descripción: Breve descripción de qué hace
    Variables: $variable1, $variable2
--}}

<div class="mi-componente">
    <h3>{{ $titulo ?? 'Título por Defecto' }}</h3>
    <p>{{ $contenido ?? 'Contenido por defecto' }}</p>
</div>

<style>
.mi-componente {
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
}
</style>
```

#### **Paso 3: Usar el componente**

En cualquier plantilla:

```blade
@include('components.mi-componente', [
    'titulo' => 'Mi Título',
    'contenido' => 'Mi contenido personalizado'
])
```

---

## 📚 **4 COMPONENTES DE EJEMPLO CREADOS**

He creado 4 componentes de ejemplo para ti:

### **1. Card de Información** 📦
**Archivo:** `ejemplo-card-info.blade.php`

**Uso:**
```blade
@include('components.ejemplo-card-info', [
    'titulo' => 'Atención 24/7',
    'icono' => 'fas fa-phone',
    'descripcion' => 'Estamos disponibles todos los días',
    'color' => 'primary'
])
```

**Vista Previa:**
```
┌─────────────────────────────────┐
│  📞  Atención 24/7              │
│                                 │
│  Estamos disponibles todos los  │
│  días del año                   │
└─────────────────────────────────┘
```

---

### **2. Contador Animado** 🔢
**Archivo:** `ejemplo-contador.blade.php`

**Uso:**
```blade
@include('components.ejemplo-contador', [
    'numero' => '250',
    'texto' => 'Notarios Registrados',
    'icono' => 'fas fa-user-tie',
    'color' => '#007bff'
])
```

**Vista Previa:**
```
    👔
    250
Notarios Registrados
```
(Con animación de 0 a 250)

---

### **3. Alerta Personalizada** ⚠️
**Archivo:** `ejemplo-alerta-personalizada.blade.php`

**Uso:**
```blade
@include('components.ejemplo-alerta-personalizada', [
    'tipo' => 'success',
    'titulo' => '¡Éxito!',
    'mensaje' => 'Tu documento ha sido registrado correctamente'
])
```

**Tipos disponibles:**
- `success` → Verde ✓
- `warning` → Amarillo ⚠️
- `danger` → Rojo ✗
- `info` → Azul ℹ️

---

### **4. Timeline / Línea de Tiempo** 📅
**Archivo:** `ejemplo-timeline.blade.php`

**Uso:**
```blade
@include('components.ejemplo-timeline', [
    'eventos' => [
        [
            'fecha' => '2025',
            'titulo' => 'Inauguración',
            'descripcion' => 'Apertura de nueva sede',
            'icono' => 'fas fa-flag'
        ],
        [
            'fecha' => '2024',
            'titulo' => 'Expansión',
            'descripcion' => 'Nuevos servicios digitales',
            'icono' => 'fas fa-rocket'
        ]
    ]
])
```

---

## 🎯 **ESTRUCTURA DE UN COMPONENTE**

### **Plantilla Base:**

```blade
{{--
    ════════════════════════════════════════
    DOCUMENTACIÓN DEL COMPONENTE
    ════════════════════════════════════════
    Nombre: Mi Componente
    Descripción: Qué hace este componente
    Variables requeridas: $variable1
    Variables opcionales: $variable2
    Ejemplo de uso: @include('components.mi-componente')
    ════════════════════════════════════════
--}}

@php
    // Variables por defecto
    $color = $color ?? 'blue';
    $tamano = $tamano ?? 'medium';
@endphp

<div class="mi-componente {{ $clase ?? '' }}">
    {{-- HTML del componente --}}
    <h3>{{ $titulo }}</h3>
    <p>{{ $descripcion }}</p>
</div>

<style>
/* Estilos CSS específicos del componente */
.mi-componente {
    padding: 20px;
    background: {{ $color }};
}
</style>

@push('scripts')
<script>
// JavaScript específico del componente (si es necesario)
$(document).ready(function() {
    // Tu código JS aquí
});
</script>
@endpush
```

---

## 💡 **IDEAS DE COMPONENTES PERSONALIZADOS**

### **Para Sistema de Notarios:**

1. **card-notario**
   - Foto, nombre, especialidad, contacto
   
2. **lista-servicios**
   - Servicios con iconos y precios
   
3. **mapa-oficinas**
   - Mapa interactivo con ubicaciones

4. **calculadora-aranceles**
   - Calcular costos de servicios

5. **chat-asistente**
   - Chat bot para consultas

6. **comparador-servicios**
   - Tabla comparativa de servicios

7. **buscador-notarios**
   - Filtros por ubicación, especialidad

8. **calendario-citas**
   - Selector de fecha/hora

9. **card-testimonio**
   - Testimonios con foto y rating

10. **proceso-paso-a-paso**
    - Guía visual de trámites

---

## 🔨 **CREAR COMPONENTE PASO A PASO**

### **Ejemplo: Componente "Card Notario"**

#### **Paso 1: Crear archivo**
```
resources/views/components/card-notario.blade.php
```

#### **Paso 2: Escribir código**

```blade
{{--
    Componente: Card de Notario
    Uso: Mostrar información de un notario
    Variables: $notario (objeto), $mostrarContacto (boolean)
--}}

<div class="card card-notario shadow-sm h-100">
    <div class="card-body text-center">
        {{-- Foto --}}
        @if($notario->foto)
            <img src="{{ asset('storage/' . $notario->foto) }}" 
                 alt="{{ $notario->nombre }}" 
                 class="rounded-circle mb-3"
                 style="width: 100px; height: 100px; object-fit: cover;">
        @else
            <div class="avatar-placeholder mb-3">
                {{ strtoupper(substr($notario->nombre, 0, 1)) }}
            </div>
        @endif
        
        {{-- Nombre --}}
        <h5 class="card-title">{{ $notario->nombre }} {{ $notario->apellidos }}</h5>
        
        {{-- Especialidad --}}
        @if($notario->especialidad)
            <p class="text-muted mb-2">
                <i class="fas fa-graduation-cap"></i> {{ $notario->especialidad }}
            </p>
        @endif
        
        {{-- Ubicación --}}
        @if($notario->distrito)
            <p class="text-muted mb-3">
                <i class="fas fa-map-marker-alt"></i> {{ $notario->distrito }}
            </p>
        @endif
        
        {{-- Contacto (opcional) --}}
        @if($mostrarContacto ?? true)
            <div class="contacto-btns">
                @if($notario->telefono)
                    <a href="tel:{{ $notario->telefono }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-phone"></i> Llamar
                    </a>
                @endif
                @if($notario->email)
                    <a href="mailto:{{ $notario->email }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-envelope"></i> Email
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

<style>
.card-notario {
    transition: transform 0.3s ease;
}

.card-notario:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.2) !important;
}

.avatar-placeholder {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    font-weight: bold;
    margin: 0 auto;
}
</style>
```

#### **Paso 3: Usar en plantilla**

```blade
<div class="row">
    @foreach($notarios as $notario)
        <div class="col-md-4 mb-4">
            @include('components.card-notario', [
                'notario' => $notario,
                'mostrarContacto' => true
            ])
        </div>
    @endforeach
</div>
```

---

## 📖 **BUENAS PRÁCTICAS**

### ✅ **DO (Hacer):**

1. **Documentar siempre**
   ```blade
   {{-- Descripción, variables, uso --}}
   ```

2. **Valores por defecto**
   ```php
   $color = $color ?? 'blue';
   ```

3. **Nombres descriptivos**
   ```
   ✅ card-notario.blade.php
   ❌ comp1.blade.php
   ```

4. **Estilos dentro del componente**
   ```blade
   <style>
   .mi-componente { ... }
   </style>
   ```

5. **Reutilizable**
   ```blade
   {{-- Debe funcionar en cualquier página --}}
   ```

### ❌ **DON'T (No hacer):**

1. **No hardcodear datos**
   ```blade
   ❌ <h1>Juan Pérez</h1>
   ✅ <h1>{{ $nombre }}</h1>
   ```

2. **No estilos globales**
   ```blade
   ❌ <style> body { ... } </style>
   ✅ <style> .mi-componente { ... } </style>
   ```

3. **No dependencias innecesarias**
   ```blade
   ❌ Requiere 10 variables
   ✅ Requiere 2-3 variables, resto opcional
   ```

---

## 🎨 **EDITOR RECOMENDADO**

### **Visual Studio Code:**

**Extensiones útiles:**
- Laravel Blade Snippets
- Laravel Blade Formatter
- Laravel goto view

**Atajos útiles:**
- `Ctrl + Space` → Autocompletado
- `Ctrl + /` → Comentar línea
- `Alt + ↑/↓` → Mover línea

---

## 🚀 **FLUJO DE TRABAJO**

```
1. Identificar necesidad
   └─> "Necesito mostrar tarjetas de notarios"

2. Crear componente
   └─> resources/views/components/card-notario.blade.php

3. Diseñar HTML/CSS
   └─> Agregar estilos y estructura

4. Probar en página
   └─> @include('components.card-notario')

5. Refinar
   └─> Ajustar diseño y funcionalidad

6. Agregar a plantilla
   └─> Marcar en editor de plantillas
```

---

## 📁 **ESTRUCTURA RECOMENDADA**

```
resources/views/components/
├── layout/
│   ├── header.blade.php
│   ├── footer.blade.php
│   └── sidebar.blade.php
├── cards/
│   ├── card-notario.blade.php
│   ├── card-servicio.blade.php
│   └── card-documento.blade.php
├── forms/
│   ├── contacto.blade.php
│   └── postulacion.blade.php
├── widgets/
│   ├── contador.blade.php
│   ├── mapa.blade.php
│   └── testimonios.blade.php
└── ejemplos/
    ├── ejemplo-card-info.blade.php
    ├── ejemplo-contador.blade.php
    ├── ejemplo-alerta-personalizada.blade.php
    └── ejemplo-timeline.blade.php
```

---

## 🎯 **PRÓXIMOS PASOS**

### **1. Ver componentes de ejemplo:**
```
D:\cursor_proy\cnotarios\resources\views\components\
```

Abre cualquier archivo `ejemplo-*.blade.php`

### **2. Crear tu primer componente:**
```
Archivo: mi-primer-componente.blade.php
```

### **3. Usarlo en una plantilla:**
```blade
@include('components.mi-primer-componente')
```

### **4. Agregarlo al editor de plantillas:**

Ve a: `http://127.0.0.1:9000/admin/plantillas/8/edit`

Scroll hasta "Componentes Personalizados"

Click en "[+] Agregar Componente Personalizado"

Escribe: `mi-primer-componente`

---

## 📞 **RESUMEN**

**Ubicación:**
```
D:\cursor_proy\cnotarios\resources\views\components\
```

**Crear componente:**
```
1. Crear archivo: mi-componente.blade.php
2. Escribir HTML/CSS/JS
3. Documentar variables
4. Usar con @include('components.mi-componente')
```

**4 ejemplos creados:**
- ✅ ejemplo-card-info.blade.php
- ✅ ejemplo-contador.blade.php
- ✅ ejemplo-alerta-personalizada.blade.php
- ✅ ejemplo-timeline.blade.php

---

**¡Ahora puedes crear tus propios componentes personalizados!** 🎨🚀

