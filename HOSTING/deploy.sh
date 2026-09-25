#!/bin/bash

# ============================================
# SCRIPT DE DESPLIEGUE PARA VPS
# ============================================
# Uso: ./deploy.sh
# ============================================

set -e

echo "🚀 Iniciando despliegue..."

# Colores
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

# Directorio del proyecto
PROJECT_DIR=$(pwd)

echo -e "${YELLOW}📦 Instalando dependencias de Composer...${NC}"
composer install --optimize-autoloader --no-dev --no-interaction

echo -e "${YELLOW}🔧 Configurando permisos...${NC}"
chmod -R 775 storage
chmod -R 775 bootstrap/cache

echo -e "${YELLOW}🔑 Generando clave de aplicación (si no existe)...${NC}"
if ! grep -q "^APP_KEY=base64:" .env 2>/dev/null; then
    php artisan key:generate --force
fi

echo -e "${YELLOW}📂 Creando enlace simbólico de storage...${NC}"
php artisan storage:link --force 2>/dev/null || true

echo -e "${YELLOW}🗄️ Ejecutando migraciones...${NC}"
php artisan migrate --force

echo -e "${YELLOW}🌱 Ejecutando seeders...${NC}"
php artisan db:seed --force 2>/dev/null || echo "Seeders ya ejecutados o no disponibles"

echo -e "${YELLOW}🧹 Limpiando cachés...${NC}"
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo -e "${YELLOW}⚡ Optimizando para producción...${NC}"
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo -e "${GREEN}✅ ¡Despliegue completado exitosamente!${NC}"
echo ""
echo -e "${YELLOW}📋 Verificaciones pendientes:${NC}"
echo "   1. Verificar el archivo .env con las credenciales correctas"
echo "   2. Probar el acceso al sitio web"
echo "   3. Cambiar la contraseña del administrador"
echo ""

