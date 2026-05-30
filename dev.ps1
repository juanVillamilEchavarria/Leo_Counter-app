# Explicitly set output encoding to UTF-8 to avoid broken characters in Windows console
[Console]::OutputEncoding = [System.Text.Encoding]::UTF8

$ErrorActionPreference = "Stop"

$BLUE   = "`e[0;34m"
$CYAN   = "`e[1;36m"
$GREEN  = "`e[1;32m"
$YELLOW = "`e[1;33m"
$RED    = "`e[1;31m"
$NC     = "`e[0m"

Clear-Host
Write-Host "${BLUE}"
@'
    __                ______                    __
   / /   ___  ____   / ____/___  __  __ ____  / /_ ___  _____
  / /   / _ \/ __ \/ /   / __ \/ / / // __ \/ __// _ \/ ___/
 / /___/  __/ /_/ / /___/ /_/ / /_/ // / / / /_ /  __/ /
/_____/\___/\____/\____/\____/\__,_//_/ /_/\__/ \___/_/
'@ | Write-Host
Write-Host "${NC}"
Write-Host "${CYAN}=================================================================${NC}"
Write-Host "  Modo Desarrollo - Leo Counter (Windows PowerShell)"
Write-Host "${CYAN}=================================================================${NC}"
Write-Host ""

# ================================================================
# 1. VALIDACIONES PREVIAS
# ================================================================
Write-Host "${BLUE}>>> Verificando requisitos del sistema...${NC}"

if (-not (Get-Command docker -ErrorAction SilentlyContinue)) {
    Write-Host "${RED}ERROR: Docker no está instalado en este sistema.${NC}"
    Exit 1
}

try {
    $null = docker info
} catch {
    Write-Host "${RED}ERROR: El daemon de Docker no está corriendo.${NC}"
    Write-Host "  Por favor, abre 'Docker Desktop' y asegúrate de que esté iniciado.${NC}"
    Exit 1
}

if (-not (Get-Command docker-compose -ErrorAction SilentlyContinue) -and -not (docker compose version -ErrorAction SilentlyContinue)) {
    Write-Host "${RED}ERROR: Docker Compose no está disponible.${NC}"
    Exit 1
}

Write-Host "${GREEN}>>> Requisitos verificados.${NC}"

# ================================================================
# 2. CONFIGURACION DEL .env
# ================================================================
if (-not (Test-Path .env)) {
    if (-not (Test-Path .env.example)) {
        Write-Host "${RED}ERROR: No se encontró .env ni .env.example${NC}"
        Exit 1
    }
    Write-Host "${BLUE}>>> Creando .env desde .env.example...${NC}"
    Copy-Item .env.example .env
    Write-Host "${YELLOW}>>> Archivo .env creado. Edítalo si es necesario antes de continuar.${NC}"
} else {
    Write-Host "${BLUE}>>> Archivo .env encontrado.${NC}"
}

# ================================================================
# 3. ESTRUCTURA DE DIRECTORIOS
# ================================================================
Write-Host "${BLUE}>>> Creando estructura de directorios de storage...${NC}"

$Directories = @(
    "storage/app/public",
    "storage/app/data/movimientos",
    "storage/framework/cache/data",
    "storage/framework/sessions",
    "storage/framework/views",
    "storage/logs",
    "bootstrap/cache"
)

foreach ($Dir in $Directories) {
    if (-not (Test-Path $Dir)) {
        $null = New-Item -ItemType Directory -Path $Dir -Force
    }
}

# En Windows los permisos de archivos locales compartidos hacia Docker
# los administra automáticamente Docker Desktop (WSL2/Hyper-V).
Write-Host "${GREEN}>>> Directorios listos.${NC}"

# ================================================================
# 4. BUILD Y LEVANTAMIENTO DE SERVICIOS
# ================================================================
Write-Host "${BLUE}>>> Construyendo imagen de desarrollo...${NC}"
docker compose -f docker-compose.dev.yml build

Write-Host "${BLUE}>>> Iniciando servicios de soporte (DB, Redis, Mailhog, PhpMyAdmin)...${NC}"
docker compose -f docker-compose.dev.yml up -d db redis mailhog phpmyadmin

Write-Host "${YELLOW}>>> Esperando base de datos...${NC}"
$Retries = 30
$Count = 0
$DbContainerId = (docker compose -f docker-compose.dev.yml ps -q db).Trim()

while ($true) {
    $Status = (docker inspect -f '{{.State.Health.Status}}' $DbContainerId 2>$null).Trim()
    if ($Status -eq "healthy") {
        break
    }

    $Count++
    if ($Count -ge $Retries) {
        Write-Host ""
        Write-Host "${RED}ERROR: La base de datos no respondió.${NC}"
        docker compose -f docker-compose.dev.yml logs db | Select-Object -Last 20
        Exit 1
    }
    Write-Host -NoNewline "."
    Start-Sleep -Seconds 2
}
Write-Host ""
Write-Host "${GREEN}>>> Base de datos lista.${NC}"

Write-Host "${BLUE}>>> Iniciando aplicación...${NC}"
docker compose -f docker-compose.dev.yml up -d app
Start-Sleep -Seconds 3

Write-Host "${YELLOW}>>> Esperando que PHP esté listo...${NC}"
$Retries = 20
$Count = 0

while ($true) {
    try {
        $Response = docker compose -f docker-compose.dev.yml exec -T app php -r "echo 'OK';" 2>$null
        if ($Response.Trim() -eq "OK") {
            break
        }
    } catch {}

    $Count++
    if ($Count -ge $Retries) {
        Write-Host "${RED}ERROR: El contenedor de la app no respondió.${NC}"
        docker compose -f docker-compose.dev.yml logs app | Select-Object -Last 20
        Exit 1
    }
    Start-Sleep -Seconds 2
}
Write-Host "${GREEN}>>> Aplicación lista.${NC}"

# ================================================================
# 5. INSTALACIÓN DE DEPENDENCIAS
# ================================================================
Write-Host "${BLUE}>>> Configurando Git para el contenedor...${NC}"
docker compose -f docker-compose.dev.yml exec -T app git config --global --add safe.directory /var/www/html

Write-Host "${BLUE}>>> Instalando dependencias PHP (Composer)...${NC}"
docker compose -f docker-compose.dev.yml exec -T app composer install

Write-Host "${BLUE}>>> Instalando dependencias Node (pnpm)...${NC}"
docker compose -f docker-compose.dev.yml exec -T app pnpm install

# ================================================================
# 6. PREPARACIÓN DE LARAVEL
# ================================================================
Write-Host "${BLUE}>>> Generando clave de aplicación...${NC}"
docker compose -f docker-compose.dev.yml exec -T app php artisan key:generate --force

Write-Host "${BLUE}>>> Ejecutando migraciones...${NC}"
docker compose -f docker-compose.dev.yml exec -T app php artisan migrate --force

Write-Host "${BLUE}>>> Ejecutando seeders...${NC}"
docker compose -f docker-compose.dev.yml exec -T app php artisan db:seed --force

Write-Host "${BLUE}>>> Creando enlace simbólico de storage...${NC}"
docker compose -f docker-compose.dev.yml exec -T app php artisan storage:link --force

# ================================================================
# 7. INICIAR SERVICIOS RESTANTES
# ================================================================
Write-Host "${BLUE}>>> Iniciando queue, scheduler y reverb...${NC}"
docker compose -f docker-compose.dev.yml up -d

# ================================================================
# 8. MENSAJE FINAL
# ================================================================
Write-Host ""
Write-Host "${GREEN}============================================================${NC}"
Write-Host "    Entorno de desarrollo listo!                          "
Write-Host "${GREEN}============================================================${NC}"
Write-Host "${GREEN}   App:         http://localhost:8080                      ${NC}"
Write-Host "${GREEN}   Mailhog:     http://localhost:8025                      ${NC}"
Write-Host "${GREEN}   PhpMyAdmin:  http://localhost:8082                      ${NC}"
Write-Host "${GREEN}============================================================${NC}"
Write-Host ""
Write-Host "${CYAN}  Hot reload (Vite):${NC}"
Write-Host "    docker compose -f docker-compose.dev.yml exec app pnpm run dev"
Write-Host ""
Write-Host "${CYAN}  Detener entorno:${NC}"
Write-Host "    docker compose -f docker-compose.dev.yml down"
Write-Host "${CYAN}  Arrancar nuevamente el entorno:${NC}"
Write-Host "    docker compose -f docker-compose.dev.yml up -d"
Write-Host ""
Write-Host "${CYAN}  Si cambias package.json:${NC}"
Write-Host "    docker compose -f docker-compose.dev.yml exec app pnpm install"
Write-Host ""
