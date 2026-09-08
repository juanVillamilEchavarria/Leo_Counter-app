#!/bin/sh
set -e

echo ">>> [entrypoint] Verificando estructura de storage..."

# Crear directorios requeridos por Laravel si no existen (fresh volume)
for dir in \
    /var/www/html/storage/app/public \
    /var/www/html/storage/app/data/movimientos \
    /var/www/html/storage/framework/cache/data \
    /var/www/html/storage/framework/sessions \
    /var/www/html/storage/framework/views \
    /var/www/html/storage/logs \
    /var/www/html/bootstrap/cache; do
    if [ ! -d "$dir" ]; then
        echo ">>> [entrypoint] Creando: $dir"
        mkdir -p "$dir"
    fi
done

echo ">>> [entrypoint] Ajustando permisos de storage..."
# Solo ajustar permisos cuando corremos como root (bootstrap de Apache).
# En entornos no-privilegiados se omite para no fallar.
if [ "$(id -u)" = "0" ]; then
    chown -R www-data:www-data \
        /var/www/html/storage \
        /var/www/html/bootstrap/cache

    chmod -R 775 \
        /var/www/html/storage \
        /var/www/html/bootstrap/cache
fi
# Eliminar el manifiesto de paquetes cacheado si existe (evita referencias a paquetes de desarrollo)
rm -f /var/www/html/bootstrap/cache/packages.php

# Eliminar el marcador de hot-reload de Vite si existe (queda huérfano al usar
# `pnpm run dev` en el host). Su presencia hace que @vite resuelva los assets al
# dev-server (localhost:5173), rompiendo la app en producción.
rm -f /var/www/html/public/hot

cd /var/www/html && php artisan package:discover --ansi

# Ajustar .env si existe
if [ -f /var/www/html/.env ]; then
    chmod 664 /var/www/html/.env

    # Generar APP_KEY si está vacía o ausente
    KEY=$(grep -E '^APP_KEY=' /var/www/html/.env | cut -d= -f2- | tr -d '"'"'" | tr -d '[:space:]')
    if [ -z "$KEY" ] || [ "$KEY" = "null" ]; then
        echo ">>> [entrypoint] Generando APP_KEY..."
        cd /var/www/html && php artisan key:generate --force
    fi
fi

echo ">>> [entrypoint] Listo. Iniciando $*"
exec "$@"
