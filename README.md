# Portal Web

Aplicación web desarrollada con **Laravel 12**. Este documento explica cómo preparar el entorno e iniciar el proyecto desde cero.

## Requisitos

Antes de comenzar, el equipo debe contar con:

- **Git** 2.0 o superior.
- **PHP** 8.2 o superior.
- **Composer** 2.x.
- **Node.js** 20 o superior.
- **npm** 10 o superior.
- **MySQL** 8.0 o superior, con una base de datos disponible para la aplicación.

PHP debe tener habilitadas las extensiones necesarias para Laravel y MySQL, entre ellas:

```text
ctype, curl, dom, fileinfo, mbstring, openssl, PDO, pdo_mysql, tokenizer y xml
```

## Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/jonas0910/portal_web.git
cd portal_web
```

### 2. Instalar las dependencias

```bash
composer install
npm install
```

Estos comandos instalan las dependencias de PHP y del frontend utilizando los archivos de bloqueo incluidos en el repositorio.

### 3. Crear el archivo de entorno

```bash
cp env.example .env
php artisan key:generate
```

### 4. Configurar la conexión a la base de datos

Editar el archivo `.env` y completar los valores correspondientes al entorno local:

```env
APP_NAME="Portal Web"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=portal_web
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_password
```

La base de datos indicada debe estar creada, disponible y accesible con las credenciales configuradas.

### 5. Preparar el almacenamiento

```bash
php artisan storage:link
```

En Linux, si el servidor no tiene permisos suficientes, puede ser necesario ejecutarlo con `sudo` o corregir los permisos de las carpetas `storage` y `bootstrap/cache`.

### 6. Compilar los recursos del frontend

Para generar los archivos estáticos:

```bash
npm run build
```

Este comando es necesario cuando la aplicación se ejecutará sin el servidor de desarrollo de Vite.

## Iniciar la aplicación

### Modo de desarrollo

Ejecutar `npm run dev` en una terminal:

```bash
npm run dev
```

Luego, en una segunda terminal, iniciar Laravel:

```bash
php artisan serve
```

La aplicación estará disponible en:

```text
http://localhost:8000
```

El comando `npm run dev` debe permanecer activo para recompilar automáticamente los archivos del frontend.

### Con recursos compilados

Si se ejecutó previamente `npm run build`, solo es necesario iniciar Laravel:

```bash
php artisan serve
```

## Comandos principales

```bash
composer install     # Instala las dependencias de PHP
npm install          # Instala las dependencias del frontend
npm run dev          # Inicia Vite para desarrollo
npm run build        # Compila los recursos para uso final
php artisan serve    # Inicia el servidor local de Laravel
php artisan storage:link # Crea el enlace público de almacenamiento
```
