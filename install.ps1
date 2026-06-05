# --- Configuración de codificación para evitar problemas con tildes ---
$OutputEncoding = [System.Text.Encoding]::UTF8
[Console]::OutputEncoding = [System.Text.Encoding]::UTF8

Clear-Host

#
Write-Host "    __               ______                   __               " -ForegroundColor Cyan
Write-Host "   / /   ___  ____  / ____/___  __  __ ____  / /_ ___  _____ " -ForegroundColor Cyan
Write-Host "  / /   / _ \/ __ \/ /   / __ \/ / / // __ \/ __// _ \/ ___/ " -ForegroundColor Cyan
Write-Host " / /___/  __/ /_/ / /___/ /_/ / /_/ // / / / /_ /  __/ /     " -ForegroundColor Cyan
Write-Host "/_____/\___/\____/\____/\____/\__,_//_/ /_/\__/ \___/_/      " -ForegroundColor Cyan
Write-Host "                                                                "
Write-Host "                    Sistema de Gestión Financiera              " -ForegroundColor Blue
Write-Host "=================================================================" -ForegroundColor Blue
Write-Host "  Iniciando el proceso de instalación automatizada para Windows..."
Write-Host "=================================================================" -ForegroundColor Blue
Write-Host ""

# --- 1. Validaciones previas ---
if (-not (Get-Command docker -ErrorAction SilentlyContinue)) {
    Write-Host "Error: Docker no está instalado o no está en el PATH." -ForegroundColor Red
    Write-Host "Por favor, instala Docker Desktop primero: https://www.docker.com/products/docker-desktop/" -ForegroundColor Yellow
    Exit 1
}

# --- 2. Archivo .env ---
if (-not (Test-Path .env)) {
    Write-Host ">>> Creando archivo .env desde .env.example..." -ForegroundColor Blue
    Copy-Item .env.example .env
    Write-Host ">>> Por favor, edita el archivo .env con tus configuraciones." -ForegroundColor Yellow
    Write-Host "    Especialmente DB_ROOT_PASSWORD, DB_USERNAME, DB_PASSWORD y APP_URL."
    Read-Host "Presiona Enter cuando hayas terminado de editar .env..."
} else {
    Write-Host ">>> Archivo .env ya existe. Saltando..." -ForegroundColor Blue
}

# --- 3. Estructura de directorios ---
Write-Host ">>> Creando estructura de directorios requerida..." -ForegroundColor Blue

$directories = @(
    "storage/app/public",
    "storage/app/data/movimientos",
    "storage/framework/cache/data",
    "storage/framework/sessions",
    "storage/framework/views",
    "storage/logs",
    "bootstrap/cache"
)

foreach ($dir in $directories) {
    if (-not (Test-Path $dir)) {
        New-Item -ItemType Directory -Path $dir -Force | Out-Null
    }
}

# Archivos .gitkeep para que git trackee los directorios
"" | Out-File -FilePath "storage/logs/.gitkeep" -Encoding utf8 -ErrorAction SilentlyContinue
"" | Out-File -FilePath "storage/framework/sessions/.gitkeep" -Encoding utf8 -ErrorAction SilentlyContinue
"" | Out-File -FilePath "storage/framework/views/.gitkeep" -Encoding utf8 -ErrorAction SilentlyContinue

Write-Host ">>> Estructura de directorios lista." -ForegroundColor Green

# --- 4. Build de imágenes con argumentos de entorno ---
Write-Host ">>> Preparando variables de entorno para el build..." -ForegroundColor Blue

$envContent = Get-Content .env -Raw

function Get-EnvValue($key) {
    $pattern = "^$key=(.*)"
    $match = [regex]::Match($envContent, $pattern, [Text.RegularExpressions.RegexOptions]::Multiline)
    if ($match.Success) {
        return $match.Groups[1].Value.Trim('"').Trim()
    }
    return ""
}

$REVERB_APP_KEY = Get-EnvValue "REVERB_APP_KEY"
$REVERB_APP_ID = Get-EnvValue "REVERB_APP_ID"
$REVERB_APP_SECRET = Get-EnvValue "REVERB_APP_SECRET"
$REVERB_HOST = Get-EnvValue "REVERB_HOST"
$REVERB_PORT = Get-EnvValue "REVERB_PORT"
$REVERB_SCHEME = Get-EnvValue "REVERB_SCHEME"
$VITE_API_URL = Get-EnvValue "VITE_API_URL"

Write-Host ">>> Construyendo imagen Docker (puede tomar varios minutos)..." -ForegroundColor Blue
docker compose build --no-cache `
    --build-arg REVERB_APP_KEY="$REVERB_APP_KEY" `
    --build-arg REVERB_APP_ID="$REVERB_APP_ID" `
    --build-arg REVERB_APP_SECRET="$REVERB_APP_SECRET" `
    --build-arg REVERB_HOST="$REVERB_HOST" `
    --build-arg REVERB_PORT="$REVERB_PORT" `
    --build-arg REVERB_SCHEME="$REVERB_SCHEME" `
    --build-arg VITE_API_URL="$VITE_API_URL"

Write-Host ">>> Imagen construida." -ForegroundColor Green

# --- 5. Iniciar servicios de soporte y esperar a la base de datos ---
Write-Host ">>> Iniciando servicios de soporte (DB, Redis, Mailhog, PhpMyAdmin)..." -ForegroundColor Blue
docker compose up -d db redis mailhog phpmyadmin

Write-Host ">>> Esperando a que la base de datos esté lista..." -ForegroundColor Yellow
$retries = 30
$count = 0
do {
    Start-Sleep -Seconds 2
    $count++
    $dbId = docker compose ps -q db 2>$null
    if ($dbId) {
        $health = docker inspect -f '{{.State.Health.Status}}' $dbId 2>$null
    }
} while ($health -ne "healthy" -and $count -lt $retries)

if ($health -ne "healthy") {
    Write-Host "ERROR: La base de datos no respondio en el tiempo esperado." -ForegroundColor Red
    docker compose logs db | Select-Object -Last 20
    Exit 1
}
Write-Host ">>> Base de datos lista." -ForegroundColor Green

# --- 6. Iniciar aplicación y esperar a Apache ---
Write-Host ">>> Iniciando contenedor de la aplicación..." -ForegroundColor Blue
docker compose up -d app

Write-Host ">>> Esperando a que Apache esté listo..." -ForegroundColor Yellow
$retries = 15
$count = 0
do {
    Start-Sleep -Seconds 2
    $count++
    docker compose exec -T app php -r "echo 'OK';" 2>$null | Out-Null
} while ($LastExitCode -ne 0 -and $count -lt $retries)

if ($count -ge $retries) {
    Write-Host "ERROR: El contenedor de la app no respondió." -ForegroundColor Red
    docker compose logs app | Select-Object -Last 30
    Exit 1
}
Write-Host ">>> Aplicación lista." -ForegroundColor Green

# --- 7. Setup de Laravel ---
Write-Host ">>> Preparando la configuración..." -ForegroundColor Blue
docker compose exec -T app php artisan config:clear

Write-Host ">>> Ejecutando migraciones..." -ForegroundColor Blue
$MaxTries = 5
$Tries = 0

while ($Tries -lt $MaxTries) {
    docker compose exec -T app php artisan migrate --force
    if ($LASTEXITCODE -eq 0) {
        break
    } else {
        $IntentoActual = $Tries + 1
        Write-Host ">>> La base de datos aun no acepta conexiones TCP, reintentando en 3 segundos... ($IntentoActual/$MaxTries)" -ForegroundColor Yellow
        Start-Sleep -Seconds 3
        $Tries++
    }
}

if ($Tries -eq $MaxTries) {
    Write-Host "ERROR: Las migraciones fallaron porque la base de datos no respondio despues de $MaxTries intentos." -ForegroundColor Red
    exit 1
}

Write-Host ">>> Ejecutando seeders..." -ForegroundColor Blue
docker compose exec -T app php artisan db:seed --force

Write-Host ">>> Creando enlace simbólico de storage..." -ForegroundColor Blue
docker compose exec -T app rm -f public/storage
docker compose exec -T app php artisan storage:link --force

Write-Host ">>> Optimizando Laravel..." -ForegroundColor Blue
docker compose exec -T app php artisan config:cache
docker compose exec -T app php artisan route:cache
docker compose exec -T app php artisan view:cache
docker compose exec -T app php artisan event:cache

Write-Host ">>> Laravel configurado." -ForegroundColor Green

# --- 8. Diagnóstico previo al finish ---
Write-Host ">>> Verificando estado de la aplicación..." -ForegroundColor Blue
try {
    $response = Invoke-WebRequest -Uri "http://localhost:8080" -Method Head -TimeoutSec 5 -ErrorAction SilentlyContinue
    $httpStatus = $response.StatusCode
} catch {
    $httpStatus = 0
}

if ($httpStatus -eq 200 -or $httpStatus -eq 302) {
    Write-Host ">>> Aplicación respondiendo correctamente (HTTP $httpStatus)." -ForegroundColor Green
} else {
    Write-Host ">>> Aviso: La aplicación respondió con HTTP $httpStatus." -ForegroundColor Yellow
    Write-Host ">>> Revisando logs de Laravel..." -ForegroundColor Yellow
    try {
        docker compose exec -T app cat storage/logs/laravel.log 2>$null | Select-Object -Last 30
    } catch {
        Write-Host "No hay logs disponibles aún." -ForegroundColor Yellow
    }
}

# --- 9. Arranque final (todos los servicios) ---
Write-Host ">>> Iniciando todos los servicios (queue, scheduler, reverb)..." -ForegroundColor Blue
docker compose up -d

Write-Host ""
Write-Host "============================================================" -ForegroundColor Green
Write-Host "   Instalación completada con éxito!                      " -ForegroundColor Green
Write-Host "============================================================" -ForegroundColor Green
Write-Host "   Aplicación:   http://localhost:8080                    " -ForegroundColor Green
Write-Host "   Mailhog:      http://localhost:8025                    " -ForegroundColor Green
Write-Host "   PhpMyAdmin:   http://localhost:8082                    " -ForegroundColor Green
Write-Host "   Reverb WS:    ws://localhost:8085                      " -ForegroundColor Green
Write-Host "============================================================" -ForegroundColor Green
Write-Host "  Para detener:   docker compose down                       " -ForegroundColor Cyan
Write-Host "  Para los logs:  docker compose logs -f app                " -ForegroundColor Cyan
Write-Host "  Para el error:  docker compose exec app cat storage/logs/laravel.log" -ForegroundColor Cyan
Write-Host "============================================================" -ForegroundColor Green

