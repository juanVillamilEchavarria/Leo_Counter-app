#!/bin/bash
set -euo pipefail

BLUE='\033[1;34m'
CYAN='\033[1;36m'
GREEN='\033[1;32m'
YELLOW='\033[1;33m'
RED='\033[1;31m'
NC='\033[0m'

clear
echo -e "${BLUE}"
cat << 'BANNER'
    __                ______
   / /   ___  ____  / ____/___  __  __ ____  / /_ ___  _____
  / /   / _ \/ __ \/ /   / __ \/ / / // __ \/ __// _ \/ ___/
 / /___/  __/ /_/ / /___/ /_/ / /_/ // / / / /_ /  __/ /
/_____/\___/\____/\____/\____/\__,_//_/ /_/\__/ \___/_/
BANNER
echo -e "${NC}"
echo -e "${CYAN}=================================================================${NC}"
echo "  Iniciando el proceso de instalacion automatizada..."
echo -e "${CYAN}=================================================================${NC}"
echo ""

# ================================================================
# 1. VALIDACIONES PREVIAS
# ================================================================
echo -e "${BLUE}>>> Verificando requisitos del sistema...${NC}"

if ! command -v docker &>/dev/null; then
    echo -e "${RED}ERROR: Docker no esta instalado.${NC}"
    echo "Instala Docker: https://docs.docker.com/engine/install/"
    exit 1
fi

if ! docker info &>/dev/null; then
    echo -e "${RED}ERROR: El daemon de Docker no esta corriendo o no tienes permisos.${NC}"
    echo "Ejecuta: sudo systemctl start docker"
    echo "Y agrega tu usuario: sudo usermod -aG docker \$USER (requiere reiniciar sesion)"
    exit 1
fi

if ! docker compose version &>/dev/null; then
    echo -e "${RED}ERROR: Docker Compose no esta disponible.${NC}"
    exit 1
fi

echo -e "${GREEN}>>> Requisitos verificados.${NC}"

# ================================================================
# 2. CONFIGURACION DEL ARCHIVO .env
# ================================================================
if [ ! -f .env ]; then
    if [ ! -f .env.example ]; then
        echo -e "${RED}ERROR: No se encontro .env ni .env.example${NC}"
        exit 1
    fi
    echo -e "${BLUE}>>> Creando .env desde .env.example...${NC}"
    cp .env.example .env
    echo -e "${YELLOW}"
    echo "  IMPORTANTE: Edita el archivo .env antes de continuar."
    echo "  Variables clave: DB_ROOT_PASSWORD, DB_USERNAME, DB_PASSWORD, APP_URL"
    echo -e "${NC}"
    read -rp "  Presiona Enter cuando hayas editado .env..."
else
    echo -e "${BLUE}>>> Archivo .env ya existe.${NC}"
fi

# ================================================================
# 3. ESTRUCTURA DE DIRECTORIOS (CRITICO)
# ================================================================
echo -e "${BLUE}>>> Creando estructura de directorios requerida...${NC}"

mkdir -p \
    storage/app/public \
    storage/app/data/movimientos \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

# Archivos .gitkeep para que git trackee los directorios
touch storage/logs/.gitkeep 2>/dev/null || true
touch storage/framework/sessions/.gitkeep 2>/dev/null || true
touch storage/framework/views/.gitkeep 2>/dev/null || true

echo -e "${GREEN}>>> Estructura de directorios lista.${NC}"

# ================================================================
# 4. PERMISOS
# ================================================================
echo -e "${BLUE}>>> Ajustando permisos de directorios base...${NC}"
chmod 775 storage storage/framework storage/logs storage/app bootstrap/cache 2>/dev/null || true
echo -e "${GREEN}>>> Permisos base verificados.${NC}"

# ================================================================
# 5. BUILD DE IMAGENES
# ================================================================
echo -e "${BLUE}>>> Construyendo imagen Docker (puede tomar varios minutos)...${NC}"
docker compose build --no-cache

echo -e "${GREEN}>>> Imagen construida.${NC}"

# ================================================================
# 6. LEVANTAR SERVICIOS DE SOPORTE
# ================================================================
echo -e "${BLUE}>>> Iniciando servicios de soporte (DB, Redis, Mailhog, PhpMyAdmin)...${NC}"
docker compose up -d db redis mailhog phpmyadmin

echo -e "${YELLOW}>>> Esperando a que la base de datos este lista...${NC}"
RETRIES=30
COUNT=0
until [ "$(docker inspect -f '{{.State.Health.Status}}' "$(docker compose ps -q db)" 2>/dev/null)" = "healthy" ]; do
    COUNT=$((COUNT + 1))
    if [ "$COUNT" -ge "$RETRIES" ]; then
        echo -e "${RED}ERROR: La base de datos no respondio en el tiempo esperado.${NC}"
        docker compose logs db | tail -20
        exit 1
    fi
    echo -n "."
    sleep 2
done
echo ""
echo -e "${GREEN}>>> Base de datos lista.${NC}"

# ================================================================
# 7. INICIAR APLICACION
# ================================================================
echo -e "${BLUE}>>> Iniciando contenedor de la aplicacion...${NC}"
docker compose up -d app

echo -e "${YELLOW}>>> Esperando a que Apache este listo...${NC}"
RETRIES=15
COUNT=0
until docker compose exec -T app php -r "echo 'OK';" &>/dev/null; do
    COUNT=$((COUNT + 1))
    if [ "$COUNT" -ge "$RETRIES" ]; then
        echo -e "${RED}ERROR: El contenedor de la app no respondio.${NC}"
        docker compose logs app | tail -30
        exit 1
    fi
    sleep 2
done
echo -e "${GREEN}>>> Aplicacion lista.${NC}"

# ================================================================
# 8. SETUP DE LARAVEL
# ================================================================
echo -e "${BLUE}>>> Ejecutando migraciones...${NC}"
docker compose exec -T app php artisan migrate --force

echo -e "${BLUE}>>> Ejecutando seeders...${NC}"
docker compose exec -T app php artisan db:seed --force

echo -e "${BLUE}>>> Creando enlace simbolico de storage...${NC}"
docker compose exec -T app rm -f public/storage
docker compose exec -T app php artisan storage:link --force

echo -e "${BLUE}>>> Optimizando Laravel...${NC}"
docker compose exec -T app php artisan config:cache
docker compose exec -T app php artisan route:cache
docker compose exec -T app php artisan view:cache
docker compose exec -T app php artisan event:cache

echo -e "${GREEN}>>> Laravel configurado.${NC}"

# ================================================================
# 9. DIAGNOSTICO PREVIO AL FINISH
# ================================================================
echo -e "${BLUE}>>> Verificando estado de la aplicacion...${NC}"
HTTP_STATUS=$(curl -s -o /dev/null -w "%{http_code}" http://localhost:8080 2>/dev/null || echo "000")

if [ "$HTTP_STATUS" = "200" ] || [ "$HTTP_STATUS" = "302" ]; then
    echo -e "${GREEN}>>> Aplicacion respondiendo correctamente (HTTP $HTTP_STATUS).${NC}"
else
    echo -e "${YELLOW}>>> Aviso: La aplicacion respondio con HTTP $HTTP_STATUS.${NC}"
    echo -e "${YELLOW}>>> Revisando logs de Laravel...${NC}"
    docker compose exec -T app cat storage/logs/laravel.log 2>/dev/null | tail -30 \
        || echo "No hay logs disponibles aun."
fi

# ================================================================
# 10. SERVICIO SYSTEMD (opcional, solo si systemctl disponible)
# ================================================================
SERVICE_FILE="/etc/systemd/system/leo-counter.service"

if command -v systemctl &>/dev/null && [ ! -f "$SERVICE_FILE" ]; then
    echo -e "${BLUE}>>> Configurando servicio systemd...${NC}"
    WORKING_DIR="$(pwd)"
    CURRENT_USER="$(whoami)"

    sudo tee "$SERVICE_FILE" > /dev/null << EOF
[Unit]
Description=Leo Counter - Sistema de Gestion Financiera
Requires=docker.service
After=docker.service network-online.target

[Service]
Type=oneshot
RemainAfterExit=yes
WorkingDirectory=${WORKING_DIR}
ExecStart=/usr/bin/docker compose up -d
ExecStop=/usr/bin/docker compose down
StandardOutput=journal
StandardError=journal
User=${CURRENT_USER}
Group=docker

[Install]
WantedBy=multi-user.target
EOF

    sudo systemctl daemon-reload
    sudo systemctl enable leo-counter.service
    echo -e "${GREEN}>>> Servicio systemd configurado.${NC}"
elif [ -f "$SERVICE_FILE" ]; then
    echo -e "${BLUE}>>> Servicio systemd ya existe.${NC}"
fi

# ================================================================
# 11. ARRANQUE FINAL (todos los servicios)
# ================================================================
echo -e "${BLUE}>>> Iniciando todos los servicios (queue, scheduler, reverb)...${NC}"
docker compose up -d

echo ""
echo -e "${GREEN}============================================================${NC}"
echo -e "${GREEN}  ✅ Instalacion completada con exito!                      ${NC}"
echo -e "${GREEN}============================================================${NC}"
echo -e "${GREEN}  🌐 Aplicacion:   http://localhost:8080                    ${NC}"
echo -e "${GREEN}  📧 Mailhog:      http://localhost:8025                    ${NC}"
echo -e "${GREEN}  🗄️  PhpMyAdmin:   http://localhost:8082                    ${NC}"
echo -e "${GREEN}  🔌 Reverb WS:    ws://localhost:8085                      ${NC}"
echo -e "${GREEN}============================================================${NC}"
echo -e "${CYAN}  Para detener:   docker compose down                       ${NC}"
echo -e "${CYAN}  Para los logs:  docker compose logs -f app                ${NC}"
echo -e "${CYAN}  Para el error:  docker compose exec app cat storage/logs/laravel.log${NC}"
echo -e "${GREEN}============================================================${NC}"
