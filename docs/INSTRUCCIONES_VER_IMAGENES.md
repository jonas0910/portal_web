# 🖼️ INSTRUCCIONES PARA VER LAS IMÁGENES

## 📋 **PASOS A SEGUIR EN ORDEN:**

### **Paso 1: Asegurar que las tablas existen**
```powershell
php artisan db:arreglar-tablas
```

### **Paso 2: Limpiar tablas de banners y páginas**
```powershell
php artisan tinker --execute="DB::table('banners')->truncate(); DB::table('paginas')->truncate(); DB::table('menus')->truncate();"
```

### **Paso 3: Ejecutar el seeder con las imágenes**
```powershell
php artisan db:seed --class=ContenidoSeeder
```

### **Paso 4: Verificar que se crearon los banners**
```powershell
php artisan tinker --execute="echo 'Total banners: ' . DB::table('banners')->count();"
```

### **Paso 5: Limpiar TODOS los cachés**
```powershell
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### **Paso 6: Ver las imágenes**

**Opción A: En el panel admin**
```
http://127.0.0.1:8000/admin/contenido/banners
```

**Opción B: En la página principal**
```
http://127.0.0.1:8000
```

---

## 🔍 **SI AÚN NO SE VEN:**

### **Verificar que el servidor esté corriendo:**
```powershell
php artisan serve
```

### **Abrir en modo incógnito:**
- `Ctrl + Shift + N` (Chrome)
- `Ctrl + Shift + P` (Firefox)

### **Verificar las imágenes en el admin:**
1. Ve a: `http://127.0.0.1:8000/admin/contenido/banners`
2. Deberías ver 4 banners con imágenes
3. Si las ves ahí, el problema es en la vista pública

---

## 🎯 **FUENTES DE IMÁGENES USADAS:**

**Picsum Photos** (https://picsum.photos)
- ✅ CDN rápido y confiable
- ✅ Sin CORS issues
- ✅ Imágenes aleatorias profesionales
- ✅ Responsive automático

**URLs de ejemplo:**
```
Desktop: https://picsum.photos/1920/600?random=1
Móvil: https://picsum.photos/800/600?random=1
```

---

## ⚠️ **SOLUCIÓN ALTERNATIVA:**

Si Picsum no carga, usa **placeholders locales**:

### **Editar en el admin:**
1. Ve a `/admin/contenido/banners`
2. Edita cada banner
3. En "Imagen Desktop" cambia a:
   ```
   https://via.placeholder.com/1920x600/007bff/ffffff?text=Servicios+Notariales
   ```
4. En "Imagen Móvil" cambia a:
   ```
   https://via.placeholder.com/800x600/007bff/ffffff?text=Servicios+Notariales
   ```

---

## 🎊 **EJECUTA TODOS LOS COMANDOS EN ORDEN**

Copia y pega estos comandos uno por uno:

```powershell
php artisan db:arreglar-tablas
php artisan tinker --execute="DB::table('banners')->truncate(); DB::table('paginas')->truncate(); DB::table('menus')->truncate();"
php artisan db:seed --class=ContenidoSeeder
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

**Luego ve a:** `http://127.0.0.1:8000/admin/contenido/banners`

**Deberías ver las imágenes ahí.** 📸

