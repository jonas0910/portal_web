# 🚀 PASOS RÁPIDOS PARA SUBIR AL HOSTING

## 📁 ARCHIVOS QUE DEBE SUBIR

### Carpeta `public_html` (raíz web):
Copie TODO el contenido de la carpeta `public/` de su proyecto:
```
public_html/
├── index.php          ← Use el de HOSTING/index.php (modificado)
├── .htaccess          ← Use el de HOSTING/htaccess-produccion.txt
├── css/
├── js/
├── images/
├── vendor/            (AdminLTE)
├── build/             (Vite compilado)
├── favicon.ico
└── robots.txt
```

### Carpeta `proyecto` (fuera de public_html):
Suba TODAS las demás carpetas:
```
proyecto/
├── app/
├── bootstrap/
├── config/
├── database/
├── lang/
├── resources/
├── routes/
├── storage/
├── vendor/
├── .env               ← Renombrar env-produccion.txt
├── artisan
├── composer.json
└── composer.lock
```

---

## ⚡ COMANDOS A EJECUTAR EN EL SERVIDOR

### Via SSH o Terminal Web de cPanel:

```bash
# 1. Ir a la carpeta del proyecto
cd ~/proyecto

# 2. Generar clave de aplicación
php artisan key:generate

# 3. Crear enlace de storage
php artisan storage:link

# 4. Ejecutar migraciones
php artisan migrate --force

# 5. Ejecutar seeders (datos iniciales)
php artisan db:seed --force

# 6. Limpiar y optimizar
php artisan optimize:clear
php artisan optimize
```

---

## 🗄️ EXPORTAR BASE DE DATOS LOCAL

### Desde phpMyAdmin local:
1. Abrir http://localhost/phpmyadmin
2. Seleccionar la base de datos
3. Pestaña "Exportar"
4. Método: Rápido
5. Formato: SQL
6. Continuar → Descargar archivo

### Desde línea de comandos:
```bash
mysqldump -u root -p nombre_bd > backup.sql
```

---

## 📋 CHECKLIST

- [ ] Base de datos creada en hosting
- [ ] Usuario de BD creado con todos los privilegios
- [ ] Archivo .env configurado con datos del hosting
- [ ] Archivos subidos a public_html y proyecto
- [ ] index.php modificado con ruta correcta
- [ ] .htaccess copiado
- [ ] Comando `php artisan key:generate` ejecutado
- [ ] Comando `php artisan migrate` ejecutado
- [ ] Comando `php artisan storage:link` ejecutado
- [ ] Permisos 775 en storage y bootstrap/cache
- [ ] Sitio funcionando ✅

---

## 🔧 SI HAY ERRORES

### Error 500:
```bash
# Ver el log
tail -50 ~/proyecto/storage/logs/laravel.log

# Dar permisos
chmod -R 775 storage bootstrap/cache
```

### Error de base de datos:
1. Verificar credenciales en .env
2. Verificar que el usuario tenga permisos

### Página en blanco:
```bash
php artisan config:clear
php artisan cache:clear
```

---

## 🔐 CREDENCIALES

**Admin por defecto:**
- URL: https://su-dominio.com/admin
- Email: admin@municipalidad.gob.pe
- Password: password

**⚠️ CAMBIAR CONTRASEÑA INMEDIATAMENTE**


