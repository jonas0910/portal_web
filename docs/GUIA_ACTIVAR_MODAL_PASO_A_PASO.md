# 🎯 Guía Paso a Paso: Activar Modal de Aniversario

## ⚠️ El modal no se abre automáticamente

Si el modal no aparece al abrir la página principal, sigue estos pasos:

---

## 📋 PASO 1: Verificar Configuración

### 1.1 Acceder a la Configuración
```
http://localhost:9000/admin/contenido/fotos-aniversario/configurar
```

### 1.2 Activar TODAS estas opciones:

✅ **"Activar Modal de Aniversario"** → Debe estar MARCADO
✅ **"Abrir automáticamente al entrar al portal"** → Debe estar MARCADO  
📅 **"Frecuencia"** → Seleccionar "Una vez por sesión"
⏱️ **"Tiempo de espera"** → Dejar en 1500
✅ **"Mostrar botón flotante"** → Debe estar MARCADO

### 1.3 GUARDAR LA CONFIGURACIÓN
Click en el botón **"Guardar Configuración"**

### 1.4 Verificar que se guardó
Recarga la página (`F5`) → Los checkboxes deben **seguir marcados**

---

## 📷 PASO 2: Agregar al Menos UNA Foto

### 2.1 Ir a Fotos de Aniversario
```
http://localhost:9000/admin/contenido/fotos-aniversario
```

### 2.2 Si NO hay fotos, crear una:
1. Click en **"Nueva Foto"**
2. **Título:** "Foto de Prueba"
3. **Subir imagen** (cualquier imagen)
4. ✅ Marcar **"Activo"**
5. Click en **"Guardar Foto"**

### 2.3 Verificar
Debes ver al menos 1 foto en la lista con badge verde que dice **"Activo"**

---

## 🧹 PASO 3: Limpiar Cachés

Abre tu terminal de PowerShell y ejecuta:

```bash
php artisan cache:clear
php artisan view:clear
php artisan config:clear
```

---

## 🔄 PASO 4: Reiniciar el Navegador

1. **Cierra COMPLETAMENTE** el navegador
2. Vuelve a abrirlo
3. Ve a: `http://localhost:9000/`
4. Espera **2 segundos**
5. El modal debería abrirse ✨

---

## 🐛 PASO 5: Verificar Errores en el Navegador

### 5.1 Abrir Consola del Navegador
1. Abre: `http://localhost:9000/`
2. Presiona `F12`
3. Ve a la pestaña **"Console"**

### 5.2 Buscar Errores
Si ves mensajes en **ROJO**, anota cuáles son.

**Errores comunes:**

❌ **"$ is not defined"**
- **Causa:** jQuery no está cargando
- **Solución:** Verificar que jQuery está incluido ANTES del modal

❌ **"bootstrap is not defined"**
- **Causa:** Bootstrap no está cargando
- **Solución:** Verificar que Bootstrap 5 está incluido

❌ **"ConfiguracionSitio::obtenerValor() not found"**
- **Causa:** Método faltante en el modelo
- **Solución:** Ya debería estar agregado

---

## 🔍 PASO 6: Verificar el Código Fuente de la Página

### 6.1 Ver Código Fuente
1. Abre: `http://localhost:9000/`
2. Presiona `Ctrl + U` (Ver código fuente)
3. Busca (Ctrl + F): `modalFotosAniversario`

### 6.2 Qué deberías ver:
```html
<!-- Modal de Galería de Fotos de Aniversario -->
<div class="modal fade" id="modalFotosAniversario" ...>
```

**Si NO aparece:**
- El componente no está incluido
- Hay un error en la vista

**Si aparece pero el modal no se abre:**
- Hay un error de JavaScript
- Las configuraciones están en '0'

---

## 🧪 PASO 7: Prueba Manual del Modal

### 7.1 Abrir Modal Manualmente
1. Abre: `http://localhost:9000/`
2. Presiona `F12` → pestaña **"Console"**
3. Escribe este comando:
```javascript
const modalEl = document.getElementById('modalFotosAniversario');
if (modalEl) {
    const modal = new bootstrap.Modal(modalEl);
    modal.show();
} else {
    console.log('Modal NO encontrado');
}
```
4. Presiona `Enter`

**Si el modal se abre:**
✅ El modal existe y funciona
❌ El problema es la configuración de auto-apertura

**Si dice "Modal NO encontrado":**
❌ El componente no está incluido en la página

---

## 💾 PASO 8: Verificar Base de Datos

### 8.1 Ejecutar Tinker
```bash
php artisan tinker
```

### 8.2 Verificar Configuraciones
```php
DB::table('configuracion_sitio')->where('categoria', 'modal_aniversario')->get();
```

**Deberías ver 6 registros con valores:**
- `modal_aniversario_activo` = `'1'`
- `modal_aniversario_auto_abrir` = `'1'` ← **IMPORTANTE**
- `modal_aniversario_mostrar_boton` = `'1'`
- `modal_aniversario_delay` = `'1000'` o `'1500'`
- `modal_aniversario_titulo` = `'Galería de Aniversario'`
- `modal_aniversario_frecuencia` = `'siempre'` o `'una_vez_por_sesion'`

### 8.3 Verificar Fotos
```php
App\Models\FotoAniversario::activas()->count();
```

**Debería retornar:** 1 o más

```php
exit
```

---

## 🔧 PASO 9: Forzar Configuraciones (Si Nada Funciona)

Si nada de lo anterior funciona, fuerza las configuraciones:

```bash
php artisan tinker
```

```php
// Activar modal
DB::table('configuracion_sitio')->where('clave', 'modal_aniversario_activo')->update(['valor' => '1']);

// Activar auto-apertura
DB::table('configuracion_sitio')->where('clave', 'modal_aniversario_auto_abrir')->update(['valor' => '1']);

// Verificar
DB::table('configuracion_sitio')->where('categoria', 'modal_aniversario')->get();

exit
```

Luego:
```bash
php artisan cache:clear
php artisan view:clear
```

---

## ✅ Checklist Final

- [ ] Configuración: `modal_aniversario_activo` = `'1'`
- [ ] Configuración: `modal_aniversario_auto_abrir` = `'1'`
- [ ] Al menos 1 foto activa creada
- [ ] Cachés limpiadas
- [ ] Navegador completamente cerrado y reabierto
- [ ] No hay errores en consola del navegador (F12)
- [ ] Código fuente tiene `modalFotosAniversario`
- [ ] jQuery carga antes del modal
- [ ] Bootstrap 5 está cargado

---

## 🎉 Cuando TODO Funciona

Deberías ver:

1. ✅ Abres `http://localhost:9000/`
2. ⏱️ Esperas 1.5 segundos
3. ✨ El modal se abre automáticamente
4. 📸 Ves tus fotos en la galería
5. 🎂 Hay un botón flotante en la esquina inferior derecha

---

## 📞 Si AÚN No Funciona

Comparte:
1. **Captura de pantalla** del panel de configuración (con checkboxes visibles)
2. **Resultado** de: `DB::table('configuracion_sitio')->where('categoria', 'modal_aniversario')->get();`
3. **Captura** de la consola del navegador (F12 → Console)
4. **Número de fotos activas:** Resultado de `FotoAniversario::activas()->count()`

---

## 🚀 Atajos Rápidos

| Acción | URL |
|--------|-----|
| Configurar Modal | `http://localhost:9000/admin/contenido/fotos-aniversario/configurar` |
| Agregar Foto | `http://localhost:9000/admin/contenido/fotos-aniversario/create` |
| Ver Portal | `http://localhost:9000/` |
| Lista de Fotos | `http://localhost:9000/admin/contenido/fotos-aniversario` |

---

**Sigue estos pasos EN ORDEN y el modal funcionará. Si hay un paso que falla, anótalo y compártelo.** 🎯






