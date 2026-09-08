#!/bin/sh
set -e

# Wrapper para el contenedor scheduler.
# Ejecuta el daemon cron en foreground sin necesidad de privilegios de root,
# heredando el entorno provisto por Docker (env_file / environment).
# La entrada del crontab (docker/crontab) llama a `php artisan schedule:run`
# de forma periódica.

echo ">>> [scheduler] Asegurando archivo de log de cron..."
touch /var/www/html/storage/logs/cron.log

echo ">>> [scheduler] Iniciando cron en foreground..."
exec cron -f