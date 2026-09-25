# 📋 GUÍA: USO DEL COMPONENTE FORMULARIO-POSTULACIÓN

## 🎯 COMPONENTE COMPLETAMENTE FUNCIONAL

El componente `formulario-postulacion` está **100% funcional** y listo para usar.

---

## 📍 **UBICACIÓN:**

```
resources/views/components/formulario-postulacion.blade.php
```

---

## ✨ **CARACTERÍSTICAS:**

- ✅ **Modal completo** con formulario de 9 campos
- ✅ **Validación HTML5** (frontend)
- ✅ **Validación Laravel** (backend)
- ✅ **Upload de CV** (PDF, máx 5MB)
- ✅ **Envío AJAX** sin recargar página
- ✅ **Loading states** (botón "Enviando...")
- ✅ **Mensajes de éxito/error**
- ✅ **Auto-limpieza** del formulario
- ✅ **Notificación flotante**
- ✅ **Protección CSRF**
- ✅ **Responsive design**
- ✅ **Personalizable** (3 variables opcionales)

---

## 🚀 **CÓMO USARLO:**

### **Uso Básico (Simple):**

En cualquier plantilla Blade:

```blade
{{-- Incluir el componente --}}
@include('components.formulario-postulacion')

{{-- Botón para abrir el modal --}}
<button class="btn btn-primary" 
        data-toggle="modal" 
        data-target="#modalPostular" 
        data-puesto="Asistente Legal">
    Postular Ahora
</button>
```

---

### **Uso Personalizado (Avanzado):**

```blade
{{-- Incluir con variables personalizadas --}}
@include('components.formulario-postulacion', [
    'puesto' => 'Notario Asociado',
    'modalId' => 'modalPostularNotario',
    'colorHeader' => '#28a745',
    'tituloModal' => 'Únete a Nuestro Equipo'
])

{{-- Botón que abre el modal personalizado --}}
<button class="btn btn-success" 
        data-toggle="modal" 
        data-target="#modalPostularNotario" 
        data-puesto="Notario Asociado">
    <i class="fas fa-user-plus"></i> Aplicar Ahora
</button>
```

---

## 📝 **VARIABLES DISPONIBLES:**

| Variable | Tipo | Requerido | Default | Descripción |
|----------|------|-----------|---------|-------------|
| `$puesto` | String | No | '' | Nombre del puesto prellenado |
| `$modalId` | String | No | 'modalPostular' | ID único del modal |
| `$colorHeader` | String | No | 'var(--primary-color)' | Color del header |
| `$tituloModal` | String | No | 'Formulario de Postulación' | Título del modal |

---

## 📋 **CAMPOS DEL FORMULARIO:**

### **Campos Obligatorios (*):**
1. **Nombres** - Input text
2. **Apellidos** - Input text
3. **Email** - Input email (validado)
4. **Teléfono** - Input tel
5. **Ciudad/Ubicación** - Input text
6. **Formación Académica** - Select
7. **CV (PDF)** - File upload (máx 5MB)
8. **Acepto términos** - Checkbox

### **Campos Opcionales:**
1. **Años de Experiencia** - Select
2. **Carta de Presentación** - Textarea

---

## 🎨 **EJEMPLOS DE USO:**

### **Ejemplo 1: Página de Empleo**

```blade
@extends('layouts.public')

@section('content')
<div class="container py-5">
    <h1>Trabaja con Nosotros</h1>
    
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h4>Asistente Legal</h4>
                    <p>Lima - Tiempo Completo</p>
                    
                    <button class="btn btn-primary" 
                            data-toggle="modal" 
                            data-target="#modalPostular" 
                            data-puesto="Asistente Legal">
                        Postular Ahora
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Incluir el componente una sola vez --}}
    @include('components.formulario-postulacion')
</div>
@endsection
```

---

### **Ejemplo 2: Múltiples Ofertas con Mismo Modal**

```blade
<div class="ofertas">
    {{-- Oferta 1 --}}
    <button data-toggle="modal" data-target="#modalPostular" data-puesto="Puesto A">
        Postular A
    </button>
    
    {{-- Oferta 2 --}}
    <button data-toggle="modal" data-target="#modalPostular" data-puesto="Puesto B">
        Postular B
    </button>
    
    {{-- Oferta 3 --}}
    <button data-toggle="modal" data-target="#modalPostular" data-puesto="Puesto C">
        Postular C
    </button>
</div>

{{-- Un solo componente maneja todos los puestos --}}
@include('components.formulario-postulacion')
```

---

### **Ejemplo 3: Múltiples Modales Diferentes**

```blade
{{-- Modal 1: Para puestos administrativos --}}
@include('components.formulario-postulacion', [
    'modalId' => 'modalAdmin',
    'colorHeader' => '#007bff',
    'tituloModal' => 'Postular - Área Administrativa'
])

{{-- Modal 2: Para puestos legales --}}
@include('components.formulario-postulacion', [
    'modalId' => 'modalLegal',
    'colorHeader' => '#28a745',
    'tituloModal' => 'Postular - Área Legal'
])

{{-- Botones --}}
<button data-toggle="modal" data-target="#modalAdmin" data-puesto="Secretaria">
    Postular Administrativo
</button>

<button data-toggle="modal" data-target="#modalLegal" data-puesto="Abogado">
    Postular Legal
</button>
```

---

## 🔄 **FLUJO COMPLETO:**

```
1. Usuario hace click en "Postular Ahora"
   ↓
2. Modal se abre
   ↓
3. El puesto se llena automáticamente (data-puesto)
   ↓
4. Usuario llena el formulario
   ↓
5. Usuario sube su CV (PDF)
   ↓
6. Usuario acepta términos
   ↓
7. Click en "Enviar Postulación"
   ↓
8. Validación frontend (HTML5)
   ↓
9. Botón cambia a "🔄 Enviando..."
   ↓
10. AJAX POST a /postulaciones
    ↓
11. Validación backend (Laravel)
    ↓
12. CV se guarda en storage/postulaciones/cvs/
    ↓
13. Datos se guardan en tabla postulaciones
    ↓
14. Retorna JSON success
    ↓
15. Mensaje de éxito en modal
    ↓
16. Modal se cierra automáticamente (2 seg)
    ↓
17. Notificación flotante aparece
    ↓
18. Formulario se limpia
    ↓
19. Listo para otra postulación
```

---

## 🎯 **PERSONALIZACIÓN:**

### **Cambiar Color del Header:**

```blade
@include('components.formulario-postulacion', [
    'colorHeader' => '#ff6b6b'  {{-- Rojo --}}
])
```

### **Cambiar Título:**

```blade
@include('components.formulario-postulacion', [
    'tituloModal' => '¡Únete a Nuestro Equipo!'
])
```

### **Modal con ID Único:**

```blade
@include('components.formulario-postulacion', [
    'modalId' => 'modalTrabajaConNosotros'
])

{{-- Botón correspondiente --}}
<button data-toggle="modal" data-target="#modalTrabajaConNosotros">
    Aplicar
</button>
```

---

## ✅ **VALIDACIONES IMPLEMENTADAS:**

### **Frontend (HTML5):**
- ✅ Campos requeridos: required
- ✅ Email válido: type="email"
- ✅ Archivo PDF: accept=".pdf"
- ✅ Checkbox términos: required

### **Backend (Laravel):**
- ✅ Tipos de datos validados
- ✅ Tamaño de archivo (máx 5MB)
- ✅ Formato PDF verificado
- ✅ Email válido
- ✅ Todos los campos requeridos

---

## 📊 **DATOS QUE SE GUARDAN:**

Cada postulación almacena:
- Puesto
- Nombres y Apellidos
- Email y Teléfono
- Ciudad
- Experiencia
- Formación
- CV (PDF en storage)
- Carta de presentación
- Estado: "pendiente"
- IP del postulante
- Fecha de postulación

---

## 🔍 **VER POSTULACIONES RECIBIDAS:**

Las postulaciones se guardan en la tabla `postulaciones`.

Para verlas:
```bash
php artisan tinker --execute="echo 'Total postulaciones: ' . App\Models\Postulacion::count();"
```

---

## 🌐 **DÓNDE SE USA ACTUALMENTE:**

El componente ya está incluido en:

```
resources/views/plantillas/seleccion-personal.blade.php
```

Puedes verlo funcionando en:
```
http://127.0.0.1:9000/trabaja-con-nosotros
```

---

## 📝 **EDITAR EL COMPONENTE:**

### **Desde el Admin:**
```
http://127.0.0.1:9000/admin/componentes/formulario-postulacion/edit
```

**Puedes modificar:**
- Campos del formulario
- Textos y labels
- Estilos CSS
- Validaciones
- Mensajes de error/éxito
- Comportamiento del AJAX

**Con Preview en Vivo:**
- Edita el código
- Click en "Actualizar Preview"
- Ve los cambios inmediatamente
- Guarda cuando estés satisfecho

---

## 🎨 **PERSONALIZAR CAMPOS:**

### **Agregar nuevo campo:**

En el componente, después de "Ciudad":

```blade
<div class="form-group">
    <label for="nuevo_campo">Mi Campo Nuevo</label>
    <input type="text" class="form-control" id="nuevo_campo" name="nuevo_campo">
</div>
```

### **Hacer campo obligatorio:**

```blade
<input ... required>
<label>Campo <span class="text-danger">*</span></label>
```

### **Agregar más opciones al select:**

```blade
<select ...>
    <option value="Nueva Opción">Nueva Opción</option>
</select>
```

---

## ✅ **ESTADO ACTUAL:**

**Componente:**
- ✅ 100% funcional
- ✅ Documentación completa
- ✅ Variables personalizables
- ✅ Validación completa
- ✅ AJAX funcional
- ✅ Responsive
- ✅ Accesible desde el gestor
- ✅ Preview en vivo disponible

**Usado en:**
- ✅ Plantilla "Selección de Personal"
- ✅ Página "Trabaja con Nosotros"

---

## 🚀 **RESUMEN:**

**Para usar el componente:**
1. Incluye: `@include('components.formulario-postulacion')`
2. Agrega botón con `data-target="#modalPostular"` y `data-puesto="Nombre"`
3. ¡Listo! El formulario funciona automáticamente

**Para editarlo:**
1. Ve a: `http://127.0.0.1:9000/admin/componentes/formulario-postulacion/edit`
2. Modifica el código
3. Click en "Actualizar Preview"
4. Guarda cambios

---

**¡El componente está completamente funcional y documentado!** 📋✅

Puedes usarlo en cualquier página que necesite un formulario de postulación.

