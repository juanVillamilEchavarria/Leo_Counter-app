#!/bin/bash
set -euo pipefail

BLUE='\033[0;34m'
CYAN='\033[1;36m'
GREEN='\033[1;32m'
YELLOW='\033[1;33m'
RED='\033[1;31m'
NC='\033[0m'

clear
echo -e "${BLUE}"
cat << 'BANNER'
    __               ______                   __
   / /   ___  ____  / ____/___  __  __ ____  / /_ ___  _____
  / /   / _ \/ __ \/ /   / __ \/ / / // __ \/ __// _ \/ ___/
 / /___/  __/ /_/ / /___/ /_/ / /_/ // / / / /_ /  __/ /
/_____/\___/\____/\____/\____/\__,_//_/ /_/\__/ \___/_/
BANNER
echo -e "${NC}"
echo -e "${CYAN}=================================================================${NC}"
echo "  Modo Desarrollo - Leo Counter"
echo -e "${CYAN}=================================================================${NC}"
echo ""

# ================================================================
# 1. VALIDACIONES PREVIAS
# ================================================================
echo -e "${BLUE}>>> Verificando requisitos del sistema...${NC}"

if ! command -v docker &>/dev/null; then
    echo -e "${RED}ERROR: Docker no está instalado.${NC}"
    exit 1
fi
if ! docker info &>/dev/null; then
    echo -e "${RED}ERROR: El daemon de Docker no está corriendo o no tienes permisos.${NC}"
    echo "  Ejecuta: sudo systemctl start docker"
    echo "  Y agrega tu usuario: sudo usermod -aG docker \$USER"
    exit 1
fi
if ! docker compose version &>/dev/null; then
    echo -e "${RED}ERROR: Docker Compose no está disponible.${NC}"
    exit 1
fi

echo -e "${GREEN}>>> Requisitos verificados.${NC}"

# ================================================================
# 2. CONFIGURACION DEL .env
# ================================================================
if [ ! -f .env ]; then
    if [ ! -f .env.example ]; then
        echo -e "${RED}ERROR: No se encontró .env ni .env.example${NC}"
        exit 1
    fi
    echo -e "${BLUE}>>> Creando .env desde .env.example...${NC}"
    cp .env.example .env
    echo -e "${YELLOW}>>> Archivo .env creado. Edítalo si es necesario antes de continuar.${NC}"
else
    echo -e "${BLUE}>>> Archivo .env encontrado.${NC}"
fi

# ================================================================
# 3. ESTRUCTURA DE DIRECTORIOS
# ================================================================
echo -e "${BLUE}>>> Creando estructura de directorios de storage...${NC}"

mkdir -p \
    storage/app/public \
    storage/app/data/movimientos \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

# Tomamos posesión de las carpetas para el usuario local antes de cambiar permisos
echo -e "${BLUE}>>> Ajustando propiedad y permisos para el desarrollo local...${NC}"
sudo chown -R $USER:$USER storage bootstrap/cache 2>/dev/null || true
sudo chmod -R 775 storage bootstrap/cache


# SELinux (Fedora/RHEL)
if command -v getenforce &>/dev/null && [ "$(getenforce 2>/dev/null || echo Disabled)" != "Disabled" ]; then
    sudo chcon -Rt container_file_t storage bootstrap/cache 2>/dev/null \
        || sudo chcon -Rt svirt_sandbox_file_t storage bootstrap/cache 2>/dev/null \
        || true
fi

echo -e "${GREEN}>>> Directorios listos.${NC}"

# ================================================================
# 4. BUILD Y LEVANTAMIENTO DE SERVICIOS
# ================================================================
echo -e "${BLUE}>>> Construyendo imagen de desarrollo...${NC}"
docker compose -f docker-compose.dev.yml build

echo -e "${BLUE}>>> Iniciando servicios de soporte (DB, Redis, Mailhog, PhpMyAdmin)...${NC}"
docker compose -f docker-compose.dev.yml up -d db redis mailhog phpmyadmin

echo -e "${YELLOW}>>> Esperando base de datos...${NC}"
RETRIES=30
COUNT=0
until [ "$(docker inspect -f '{{.State.Health.Status}}' "$(docker compose -f docker-compose.dev.yml ps -q db)" 2>/dev/null)" = "healthy" ]; do
    COUNT=$((COUNT + 1))
    if [ "$COUNT" -ge "$RETRIES" ]; then
        echo -e "${RED}ERROR: La base de datos no respondió.${NC}"
        docker compose -f docker-compose.dev.yml logs db | tail -20
        exit 1
    fi
    echo -n "."
    sleep 2
done
echo ""
echo -e "${GREEN}>>> Base de datos lista.${NC}"

echo -e "${BLUE}>>> Iniciando aplicación...${NC}"
docker compose -f docker-compose.dev.yml up -d app
sleep 3
docker compose -f docker-compose.dev.yml exec -T app chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true

echo -e "${YELLOW}>>> Esperando que PHP esté listo...${NC}"
RETRIES=20
COUNT=0
until docker compose -f docker-compose.dev.yml exec -T app php -r "echo 'OK';" &>/dev/null; do
    COUNT=$((COUNT + 1))
    if [ "$COUNT" -ge "$RETRIES" ]; then
        echo -e "${RED}ERROR: El contenedor de la app no respondió.${NC}"
        docker compose -f docker-compose.dev.yml logs app | tail -20
        exit 1
    fi
    sleep 2
done
echo -e "${GREEN}>>> Aplicación lista.${NC}"

# ================================================================
# 5. INSTALACIÓN DE DEPENDENCIAS
# ================================================================
echo -e "${BLUE}>>> Configurando Git para el contenedor...${NC}"
docker compose -f docker-compose.dev.yml exec -T app \
    git config --global --add safe.directory /var/www/html

echo -e "${BLUE}>>> Instalando dependencias PHP (Composer)...${NC}"
docker compose -f docker-compose.dev.yml exec -T app \
    composer install

echo -e "${BLUE}>>> Instalando dependencias Node (pnpm)...${NC}"
# ✅ pnpm usa copy mode (configurado en .npmrc) y store dentro del volumen de node_modules
# Esto evita el error ERR_PNPM_EACCES por cross-filesystem hardlinks
docker compose -f docker-compose.dev.yml exec -T app pnpm install

# ================================================================
# 6. PREPARACIÓN DE LARAVEL
# ================================================================
echo -e "${BLUE}>>> Generando clave de aplicación...${NC}"
docker compose -f docker-compose.dev.yml exec -T app php artisan key:generate --force

echo -e "${BLUE}>>> Ejecutando migraciones...${NC}"
docker compose -f docker-compose.dev.yml exec -T app php artisan migrate --force

echo -e "${BLUE}>>> Ejecutando seeders...${NC}"
docker compose -f docker-compose.dev.yml exec -T app php artisan db:seed --force

echo -e "${BLUE}>>> Creando enlace simbólico de storage...${NC}"
docker compose -f docker-compose.dev.yml exec -T app php artisan storage:link --force

# ================================================================
# 7. INICIAR SERVICIOS RESTANTES
# ================================================================
echo -e "${BLUE}>>> Iniciando queue, scheduler y reverb...${NC}"
docker compose -f docker-compose.dev.yml up -d

# ================================================================
# 8. MENSAJE FINAL
# ================================================================
echo ""
echo -e "${GREEN}============================================================${NC}"
echo -e "${GREEN}   Entorno de desarrollo listo!                           ${NC}"
echo -e "${GREEN}============================================================${NC}"
echo -e "${GREEN}   App:        http://localhost:8080                      ${NC}"
echo -e "${GREEN}   Mailhog:    http://localhost:8025                      ${NC}"
echo -e "${GREEN}    PhpMyAdmin: http://localhost:8082                      ${NC}"
echo -e "${GREEN}============================================================${NC}"
echo ""
echo -e "${CYAN}  Hot reload (Vite):                                         ${NC}"
echo -e "    docker compose -f docker-compose.dev.yml exec app pnpm run dev"
echo ""
echo -e "${CYAN}  Detener entorno:                                           ${NC}"
echo -e "    docker compose -f docker-compose.dev.yml down"
echo ""
echo -e "${CYAN}  Si cambias package.json:                                   ${NC}"
echo -e "    docker compose -f docker-compose.dev.yml exec app pnpm install"
echo ""
