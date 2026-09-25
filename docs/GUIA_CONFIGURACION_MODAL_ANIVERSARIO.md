# 🎯 Guía de Configuración - Modal de Aniversario

## ✅ Funcionalidad Implementada

El modal de fotos de aniversario ahora es **totalmente gestionable** desde el panel de administración, incluyendo la apertura automática al ingresar al portal.

---

## 🚀 Cómo Configurar el Modal

### 1. Acceder a la Configuración

**Opción A - Desde el Dashboard de Contenidos:**
```
Admin → Contenido → Fotos de Aniversario → Botón "Configurar Modal"
```

**Opción B - URL directa:**
```
/admin/contenido/fotos-aniversario/configurar
```

### 2. Opciones de Configuración Disponibles

#### 🔵 **Activar Modal de Aniversario**
- **¿Qué hace?** Activa o desactiva completamente el modal en el sitio
- **Recomendación:** Activar solo cuando tengas fotos cargadas
- **Predeterminado:** ✅ Activado

#### 🔵 **Abrir automáticamente al entrar al portal**
- **¿Qué hace?** El modal se abre automáticamente cuando los usuarios entran al sitio
- **Recomendación:** Úsalo para eventos especiales o aniversarios importantes
- **Predeterminado:** ❌ Desactivado

#### 🔵 **Frecuencia de aparición automática**
- **Opciones:**
  - **Siempre:** Se abre cada vez que entran (puede ser molesto)
  - **Una vez por sesión:** Se abre solo una vez hasta que cierren el navegador (RECOMENDADO)
  - **Una vez por día:** Se abre una vez al día por visitante
- **Predeterminado:** Siempre
- **Recomendación:** Usar "Una vez por sesión" para mejor experiencia de usuario

#### 🔵 **Tiempo de espera antes de abrir**
- **¿Qué hace?** Espera X milisegundos antes de mostrar el modal
- **Rango:** 0 - 10,000 milisegundos (0 - 10 segundos)
- **Recomendación:** 1000-2000ms (1-2 segundos)
- **Predeterminado:** 1000ms (1 segundo)

#### 🔵 **Mostrar botón flotante**
- **¿Qué hace?** Muestra un botón flotante en la esquina inferior derecha
- **Recomendación:** Déjalo activado para que los usuarios puedan volver a abrir el modal
- **Predeterminado:** ✅ Activado

#### 🔵 **Título del Modal**
- **¿Qué hace?** Personaliza el título que aparece en el modal
- **Ejemplos:**
  - "Galería de Aniversario"
  - "50 Años de Historia"
  - "Celebramos Juntos"
- **Predeterminado:** "Galería de Aniversario"

---

## 📋 Configuración Recomendada para Diferentes Casos

### 🎊 **Caso 1: Evento de Aniversario Activo**
```
✅ Activar Modal de Aniversario: SÍ
✅ Abrir automáticamente: SÍ
📅 Frecuencia: Una vez por sesión
⏱️ Tiempo de espera: 1500ms (1.5 segundos)
🔘 Mostrar botón flotante: SÍ
📝 Título: "Celebramos nuestro 50° Aniversario"
```

### 📸 **Caso 2: Galería Permanente (sin auto-apertura)**
```
✅ Activar Modal de Aniversario: SÍ
❌ Abrir automáticamente: NO
🔘 Mostrar botón flotante: SÍ
📝 Título: "Galería de Momentos Especiales"
```

### 🔕 **Caso 3: Desactivar Temporalmente**
```
❌ Activar Modal de Aniversario: NO
(Las demás opciones no importan cuando está desactivado)
```

### 🎯 **Caso 4: Apertura Discreta**
```
✅ Activar Modal de Aniversario: SÍ
✅ Abrir automáticamente: SÍ
📅 Frecuencia: Una vez por día
⏱️ Tiempo de espera: 3000ms (3 segundos)
❌ Mostrar botón flotante: NO (si tienes tu propio botón)
```

---

## 🎬 Flujo de Uso Paso a Paso

### **Paso 1: Agregar Fotos**
1. Ve a: `Admin → Contenido → Fotos de Aniversario`
2. Click en "Nueva Foto"
3. Sube al menos 3-5 fotos
4. Asegúrate de marcarlas como **"Activo"**

### **Paso 2: Configurar el Modal**
1. Desde la lista de fotos, click en "Configurar Modal"
2. Activa la opción **"Abrir automáticamente al entrar al portal"**
3. Selecciona frecuencia: **"Una vez por sesión"**
4. Ajusta el tiempo de espera: **1500ms**
5. Personaliza el título si lo deseas
6. Click en "Guardar Configuración"

### **Paso 3: Probar**
1. Abre el portal en una ventana de incógnito
2. Espera 1.5 segundos
3. El modal debería abrirse automáticamente
4. Cierra el modal y recarga la página
5. El modal **NO** debería abrirse nuevamente (por sesión)

---

## 🎨 Cómo Funciona Internamente

### **Frecuencia: "Siempre"**
```javascript
// El modal se abre cada vez que cargas la página
// No guarda ningún registro
```

### **Frecuencia: "Una vez por sesión"**
```javascript
// Usa sessionStorage del navegador
// Se resetea al cerrar todas las pestañas del sitio
sessionStorage.setItem('modal_aniversario_mostrado', 'true');
```

### **Frecuencia: "Una vez por día"**
```javascript
// Usa localStorage del navegador
// Guarda la fecha actual
// Se resetea a las 00:00 del siguiente día
localStorage.setItem('modal_aniversario_fecha', '2024-11-28');
```

---

## ⚠️ Advertencias y Recomendaciones

### ✅ **Buenas Prácticas**

1. **Siempre ten fotos activas** antes de activar la auto-apertura
2. **Usa "Una vez por sesión"** para no molestar a los usuarios
3. **Espera 1-3 segundos** antes de abrir el modal (mejor UX)
4. **Mantén el botón flotante activo** para que puedan volver a verlo
5. **Prueba en incógnito** antes de publicar

### ❌ **Errores Comunes**

1. **Activar auto-apertura sin fotos**
   - Resultado: Modal vacío
   - Solución: Agregar fotos primero

2. **Tiempo de espera muy corto (0ms)**
   - Resultado: Aparece antes de que cargue la página
   - Solución: Mínimo 1000ms

3. **Usar "Siempre" en producción**
   - Resultado: Usuarios molestos
   - Solución: Cambiar a "Una vez por sesión"

4. **Desactivar el botón flotante sin tener otro botón**
   - Resultado: Los usuarios no pueden volver a abrir el modal
   - Solución: Mantener botón flotante O crear tu propio botón

---

## 🔧 Solución de Problemas

### **El modal no se abre automáticamente**

✔️ Verificar:
1. ¿Está activado "Abrir automáticamente"? → Ver configuración
2. ¿Tienes fotos activas? → Agregar/activar fotos
3. ¿Ya se mostró hoy/en esta sesión? → Limpiar caché del navegador
4. ¿El modal está activado? → Ver opción principal

**Comandos para limpiar caché del navegador:**
- Chrome/Edge: `Ctrl + Shift + Delete` → Borrar datos de navegación
- Firefox: `Ctrl + Shift + Delete` → Limpiar historial reciente
- O usar ventana de incógnito para probar

### **El modal se abre muchas veces**

✔️ Solución:
1. Ve a configuración
2. Cambia frecuencia a "Una vez por sesión"
3. Guarda cambios

### **No aparece el botón flotante**

✔️ Verificar:
1. Opción "Mostrar botón flotante" está activada
2. El modal está incluido en la vista: `@include('public.components.modal-fotos-aniversario')`
3. Bootstrap y jQuery están cargados

### **Las fotos no se ven en el modal**

✔️ Verificar:
1. Las fotos están marcadas como "Activo"
2. Las imágenes se subieron correctamente
3. Ejecutar: `php artisan storage:link`
4. Permisos de carpeta storage

---

## 📱 Compatibilidad

| Navegador | Versión Mínima | Auto-apertura | Frecuencias |
|-----------|----------------|---------------|-------------|
| Chrome    | 80+            | ✅            | ✅          |
| Firefox   | 75+            | ✅            | ✅          |
| Safari    | 13+            | ✅            | ✅          |
| Edge      | 80+            | ✅            | ✅          |
| Opera     | 67+            | ✅            | ✅          |

**Nota:** Funciona en todos los dispositivos (PC, tablet, móvil)

---

## 📊 Estadísticas en el Panel

En la página de configuración verás:
- **Total de fotos:** Todas las fotos (activas e inactivas)
- **Fotos activas:** Solo las que se mostrarán
- **Alerta:** Si no tienes fotos activas, te advertirá antes de guardar

---

## 🎁 Características Adicionales

### **Vista Previa**
- Botón "Ver en el Portal" abre el sitio en nueva pestaña
- Prueba la configuración antes de guardar definitivamente

### **Validación Inteligente**
- Si intentas activar auto-apertura sin fotos activas, te alertará
- No te deja guardar configuraciones inválidas

### **Opciones Dinámicas**
- Las opciones de frecuencia y delay solo aparecen si activas "Abrir automáticamente"
- Interfaz limpia y fácil de usar

---

## 🆘 Soporte

Si tienes problemas con la configuración:

1. Revisa esta guía completamente
2. Verifica que las migraciones se ejecutaron
3. Limpia caché: `php artisan cache:clear`
4. Limpia caché de configuración: `php artisan config:clear`
5. Contacta al equipo de desarrollo

---

## 🎉 Resumen Rápido

```bash
# 1. Agregar fotos desde el admin
Admin → Contenido → Fotos de Aniversario → Nueva Foto

# 2. Configurar auto-apertura
Admin → Contenido → Fotos de Aniversario → Configurar Modal

# 3. Activar estas opciones:
☑️ Abrir automáticamente: SÍ
☑️ Frecuencia: Una vez por sesión
☑️ Tiempo de espera: 1500ms

# 4. Guardar y probar
Click "Guardar Configuración" → Abrir portal en incógnito
```

**¡Listo! El modal se abrirá automáticamente al entrar al portal. 🎊**






