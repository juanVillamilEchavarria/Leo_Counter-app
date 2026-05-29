# --- Configuración de codificación para evitar problemas con tildes ---
$OutputEncoding = [System.Text.Encoding]::UTF8
[Console]::OutputEncoding = [System.Text.Encoding]::UTF8

Clear-Host

#
Write-Host "    __               ______                     __               " -ForegroundColor Cyan
Write-Host "   / /   ___  ____  / ____/___  __  __ ____  / /_ ___  _____ " -ForegroundColor Cyan
Write-Host "  / /   / _ \/ __ \/ /   / __ \/ / / // __ \/ __// _ \/ ___/ " -ForegroundColor Cyan
Write-Host " / /___/  __/ /_/ / /___/ /_/ / /_/ // / / / /_ /  __/ /     " -ForegroundColor Cyan
Write-Host "/_____/\___/\____/\____/\____/\__,_//_/ /_/\__/\___/_/      " -ForegroundColor Cyan
Write-Host "                                                                 "
Write-Host "                    Sistema de Gestión Financiera              " -ForegroundColor Blue
Write-Host "=================================================================" -ForegroundColor Blue
Write-Host "  Iniciando el proceso de instalación automatizada para Windows..."
Write-Host "=================================================================" -ForegroundColor Blue
Write-Host ""

# --- Validaciones previas ---
if (-not (Get-Command docker -ErrorAction SilentlyContinue)) {
    Write-Host "Error: Docker no está instalado o no está en el PATH." -ForegroundColor Red
    Write-Host "Por favor, instala Docker Desktop primero: https://www.docker.com/products/docker-desktop/" -ForegroundColor Yellow
    Exit 1
}

# --- 1. Archivo .env ---
if (-not (Test-Path .env)) {
    Write-Host ">>> Creando archivo .env desde .env.example..." -ForegroundColor Blue
    Copy-Item .env.example .env
    Write-Host ">>> Por favor, edita el archivo .env con tus configuraciones." -ForegroundColor Yellow
    Write-Host "    Especialmente DB_ROOT_PASSWORD, DB_USERNAME, DB_PASSWORD y APP_URL."
    Read-Host "Presiona Enter cuando hayas terminado de editar .env..."
} else {
    Write-Host ">>> Archivo .env ya existe. Saltando..." -ForegroundColor Blue
}

# --- 2. Construir imágenes y levantar DB ---
Write-Host ">>> Construyendo imágenes Docker..." -ForegroundColor Blue
docker compose build

Write-Host ">>> Iniciando la base de datos..." -ForegroundColor Blue
docker compose up -d db

Write-Host ">>> Esperando a que la base de datos esté lista (puede tomar unos segundos)..." -ForegroundColor Yellow
do {
    Start-Sleep -Seconds 2
    $dbStatus = docker compose exec -T db mysqladmin ping -h"127.0.0.1" --silent
} while ($LastExitCode -ne 0)
Write-Host ">>> Base de datos lista." -ForegroundColor Green

# --- 3. Dependencias PHP, clave, migraciones y seeders ---
Write-Host ">>> Configurando la aplicación Laravel..." -ForegroundColor Blue
docker compose run --rm app composer install --no-dev --optimize-autoloader
docker compose run --rm app php artisan key:generate --force
docker compose run --rm app php artisan migrate --force
docker compose run --rm app php artisan db:seed --force
try {
    docker compose run --rm app php artisan storage:link
} catch {
    # Ignorar si falla el enlace simbólico en Windows (a veces requiere permisos de Admin)
}

# --- 4. Arranque inicial ---
Write-Host ">>> Asegurando que todos los servicios estén arriba..." -ForegroundColor Blue
docker compose up -d

Write-Host ""
Write-Host "=============================================" -ForegroundColor Green
Write-Host "  ¡Instalación completada con éxito!         " -ForegroundColor Green
Write-Host "  Accede a tu aplicación en: http://localhost:8080" -ForegroundColor Green
Write-Host "  Para detener: docker compose down          " -ForegroundColor Green
Write-Host "=============================================" -ForegroundColor Green
