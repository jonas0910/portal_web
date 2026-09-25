# 📍 DÓNDE VER LOS WIDGETS - GUÍA PASO A PASO

## 🎯 **UBICACIÓN DE LOS WIDGETS:**

Los widgets se muestran en el **Dashboard Principal del Admin**.

---

## 📋 **PASOS PARA VER LOS WIDGETS:**

### **1. Accede al sistema:**
```
http://127.0.0.1:9000/login
```

**Login:**
- Email: `admin@notarios.org.pe`
- Password: `password`

### **2. Después del login, serás redirigido a:**
```
http://127.0.0.1:9000/home
```

### **3. En el menú lateral (izquierda), haz click en:**
```
Dashboard
```

O ve directamente a:
```
http://127.0.0.1:9000/admin/dashboard
```

### **4. En esa página deberías ver:**
- 📊 **Estadísticas** (4 boxes de colores en la parte superior)
- 📅 **Widget Calendario de Audiencias** (card azul con lista de citas)
- 📄 **Widget Documentos Pendientes** (card amarillo con lista)
- 🔔 **Widget Notificaciones** (card rojo con alertas)
- 📆 **Widget Citas de Hoy** (card verde con timeline)

---

## ⚠️ **SI NO VES LOS WIDGETS:**

### **Problema 1: El tema no tiene widgets habilitados**

**Solución:**
1. Ve a: `http://127.0.0.1:9000/admin/temas`
2. Busca el tema "Clásico Legal"
3. Click en el botón verde (✓) para establecerlo como predeterminado
4. Recarga el dashboard

### **Problema 2: No hay datos en las tablas**

**Verifica ejecutando:**
```powershell
php artisan db:seed --class=WidgetsSeeder
```

### **Problema 3: Cache**

**Limpia el cache:**
```powershell
php artisan config:clear
php artisan view:clear
php artisan cache:clear
```

---

## 🔍 **ESTRUCTURA VISUAL DEL DASHBOARD:**

```
┌─────────────────────────────────────────────────┐
│ Dashboard Administrativo                         │
├─────────────────────────────────────────────────┤
│                                                  │
│ [Estadísticas - 4 boxes de colores]            │
│ ┌──────┐ ┌──────┐ ┌──────┐ ┌──────┐           │
│ │Notar.│ │Docs  │ │Serv. │ │Users │           │
│ └──────┘ └──────┘ └──────┘ └──────┘           │
│                                                  │
│ [Widgets según tema - aparecen aquí]           │
│ ┌────────────┐ ┌────────────┐ ┌────────────┐  │
│ │ Calendario │ │ Documentos │ │Notificac.│  │
│ │            │ │            │ │            │  │
│ └────────────┘ └────────────┘ └────────────┘  │
│                                                  │
│ ┌────────────────────────────────────────────┐  │
│ │ Citas de Hoy (Timeline)                   │  │
│ └────────────────────────────────────────────┘  │
│                                                  │
│ [Notarios Recientes] [Documentos Recientes]    │
│                                                  │
│ [Acciones Rápidas - 4 botones]                 │
│                                                  │
└─────────────────────────────────────────────────┘
```

---

## 🎨 **VISTA DE LOS WIDGETS:**

### **Calendario de Audiencias:**
```
┌────────────────────────────────┐
│ 📅 Calendario de Audiencias   │
├────────────────────────────────┤
│ [Consulta] Consulta Testamento │
│ 🕐 23/10/2025 10:00           │
│ 👤 Juan Pérez                  │
│ ✅ Confirmada                  │
├────────────────────────────────┤
│ [Ver Calendario Completo]      │
└────────────────────────────────┘
```

### **Documentos Pendientes:**
```
┌────────────────────────────────┐
│ 📄 Documentos Pendientes   [5]│
├────────────────────────────────┤
│ 📕 Escritura Pública...        │
│    Testamento                  │
├────────────────────────────────┤
│ [Ver Todos]                    │
└────────────────────────────────┘
```

---

## ✅ **CHECKLIST DE VERIFICACIÓN:**

- [ ] ¿Hiciste login correctamente?
- [ ] ¿Estás en `/admin/dashboard`?
- [ ] ¿Ejecutaste `php artisan db:seed --class=WidgetsSeeder`?
- [ ] ¿Limpiaste el caché con `php artisan config:clear`?
- [ ] ¿El tema "Clásico Legal" está como predeterminado?

---

## 🚀 **COMANDOS PARA VERIFICAR:**

```powershell
# 1. Crear tablas de widgets
php artisan db:arreglar-tablas

# 2. Poblar widgets con datos
php artisan db:seed --class=WidgetsSeeder

# 3. Poblar temas
php artisan db:seed --class=TemaSeeder

# 4. Limpiar caché
php artisan config:clear
php artisan view:clear
```

---

## 📍 **RUTA EXACTA:**

**NO** vayas a estas URLs:
- ❌ `/admin/contenido` (gestor de contenido)
- ❌ `/home` (home simple)

**SÍ** ve a esta URL:
- ✅ `/admin/dashboard` (dashboard con widgets)
- ✅ `http://127.0.0.1:9000/admin/dashboard`

---

**¿Estás en la URL correcta `/admin/dashboard`?** 

Si estás ahí y no ves los widgets, ejecuta los 4 comandos de arriba y luego recarga la página con `Ctrl + F5`. 🔄

