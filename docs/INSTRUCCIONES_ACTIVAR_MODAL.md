# 🚨 INSTRUCCIONES PARA ACTIVAR EL MODAL DE ANIVERSARIO

## ⚠️ IMPORTANTE: Sigue estos pasos en orden

### **Paso 1: Detener el servidor actual**

En la terminal que tiene el servidor corriendo (puerto 9000), presiona:
```
Ctrl + C
```

### **Paso 2: Ejecutar migraciones**

```bash
php artisan migrate --path=database/migrations/2025_11_28_000001_add_modal_aniversario_config.php
```

### **Paso 3: Limpiar cachés**

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### **Paso 4: Reiniciar servidor**

```bash
php artisan serve --host=0.0.0.0 --port=9000
```

### **Paso 5: Verificar que las rutas existen**

Abre una **nueva terminal** (sin cerrar el servidor) y ejecuta:

```bash
php artisan route:list | findstr "fotos-aniversario"
```

**Deberías ver algo como:**
```
GET|HEAD   admin/contenido/fotos-aniversario ........................
GET|HEAD   admin/contenido/fotos-aniversario/configurar ............
POST       admin/contenido/fotos-aniversario/configurar ............
GET|HEAD   admin/contenido/fotos-aniversario/create ................
POST       admin/contenido/fotos-aniversario .......................
GET|HEAD   admin/contenido/fotos-aniversario/{fotosAniversario}/edit
PUT|PATCH  admin/contenido/fotos-aniversario/{fotosAniversario} ....
DELETE     admin/contenido/fotos-aniversario/{fotosAniversario} ....
POST       admin/contenido/fotos-aniversario/{fotosAniversario}/toggle
```

---

## 📍 **Paso 6: Acceder al Panel de Admin**

### Opción A: Desde el Dashboard de Contenidos

1. Abre tu navegador
2. Ve a: `http://localhost:9000/admin/contenido`
3. Busca la tarjeta **"Aniversario"** (con ícono de pastel 🎂)
4. Click en **"Ver fotos"**

### Opción B: URL Directa

```
http://localhost:9000/admin/contenido/fotos-aniversario
```

---

## 🎯 **Paso 7: Agregar Primera Foto de Prueba**

1. Click en **"Nueva Foto"**
2. Completa:
   - **Título:** "Foto de Prueba"
   - **Año:** 2024
   - **Imagen:** Sube cualquier imagen
3. Marca: ✅ **Activo**
4. Click en **"Guardar Foto"**

---

## ⚙️ **Paso 8: Configurar el Modal**

1. Desde la lista de fotos, click en **"Configurar Modal"** (botón amarillo)
2. Activa estas opciones:
   - ✅ **Activar Modal de Aniversario**
   - ✅ **Abrir automáticamente al entrar al portal**
3. Selecciona:
   - **Frecuencia:** "Una vez por sesión"
   - **Tiempo de espera:** 1500
4. Click en **"Guardar Configuración"**

---

## 🌐 **Paso 9: Ver el Modal en el Portal**

1. Abre el portal: `http://localhost:9000/`
2. Espera 1.5 segundos
3. **El modal debería abrirse automáticamente** con tus fotos

---

## 🔍 **Si NO aparece el modal en el portal:**

### Verifica el código fuente de la página:

1. Abre `http://localhost:9000/`
2. Presiona `F12` (abrir DevTools)
3. Ve a la pestaña **Console**
4. Busca errores en rojo

### Verifica que jQuery esté cargando:

En la consola del navegador, escribe:
```javascript
console.log($)
```

Si dice "undefined", jQuery no está cargado.

---

## 🐛 **Solución de Problemas Comunes**

### **Error: "No aparece en el gestor de contenidos"**

```bash
# Verifica que la migración se ejecutó
php artisan migrate:status

# Busca: "2025_11_28_000001_add_modal_aniversario_config"
# Debe decir "Ran"
```

### **Error: "Target class [FotoAniversarioController] does not exist"**

```bash
# Regenera el autoload de composer
composer dump-autoload
```

### **Error: "Call to undefined method"**

```bash
# Verifica que el modelo ConfiguracionSitio tiene el método obtenerValor
# Si no existe, agrega este método al modelo
```

### **Error: "No se ve el modal en la página"**

1. Abre: `http://localhost:9000/`
2. Presiona `Ctrl + U` (ver código fuente)
3. Busca: `modalFotosAniversario`
4. Si NO aparece, el include no está funcionando

---

## ✅ **Checklist Final**

- [ ] Servidor reiniciado después de agregar rutas
- [ ] Migraciones ejecutadas
- [ ] Cachés limpiadas
- [ ] Rutas verificadas con `route:list`
- [ ] Al menos 1 foto agregada y marcada como "Activo"
- [ ] Configuración guardada con "Auto-abrir" activado
- [ ] Modal aparece al entrar a `http://localhost:9000/`

---

## 📞 **Si Aún No Funciona**

Copia y pega el resultado de estos comandos:

```bash
php artisan route:list | findstr "fotos-aniversario"
php artisan migrate:status | findstr "fotos_aniversario"
```

Y también el contenido de la consola del navegador (errores en rojo).

---

## 🎉 **Si Todo Funciona Correctamente**

Deberías ver:

1. ✅ En el admin: Sección "Fotos de Aniversario" con opciones completas
2. ✅ En el portal: Modal que se abre automáticamente después de 1.5 segundos
3. ✅ Botón flotante en la esquina inferior derecha (pastel 🎂)
4. ✅ Al hacer click en una foto, se amplía en un nuevo modal

**¡Eso es todo! El sistema está completamente funcional.** 🎊






