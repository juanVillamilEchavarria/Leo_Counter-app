FROM php:8.5-apache

ARG USER=leo
ARG UID=1000
ARG GID=1000

# ================================
# DEPENDENCIAS DEL SISTEMA 
# ================================
RUN apt-get update && apt-get install -y --no-install-recommends \
    cron \
    git zip unzip curl \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    libwebp-dev libzip-dev libonig-dev libxml2-dev \
    && rm -rf /var/lib/apt/lists/*

# ================================
# EXTENSIONES PHP
# ================================
RUN docker-php-ext-configure gd \
        --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) \
        gd pdo_mysql mbstring exif pcntl bcmath zip

RUN pecl install redis && docker-php-ext-enable redis

# ================================
# NODE.JS Y COMPOSER
# ================================
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ================================
# APACHE
# ================================
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
        /etc/apache2/sites-available/000-default.conf \
        /etc/apache2/apache2.conf \
    && a2enmod rewrite \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf

# ================================
# CONFIGURACIÓN NATIVA DE CRON 
# ================================
COPY docker/crontab /tmp/laravel-cron

RUN sed -i 's/\r$//' /tmp/laravel-cron

RUN crontab -u www-data /tmp/laravel-cron \
    && rm /tmp/laravel-cron

# Entrypoint del scheduler 
COPY docker/scheduler-entrypoint.sh /usr/local/bin/scheduler-entrypoint.sh
RUN chmod +x /usr/local/bin/scheduler-entrypoint.sh
# ================================
# USUARIO DEL SISTEMA 
# ================================
RUN groupadd -g "${GID}" "${USER}" \
    && useradd -G www-data -u "${UID}" -g "${GID}" -d "/home/${USER}" "${USER}" \
    && mkdir -p "/home/${USER}/.composer" \
    && chown -R "${USER}:${USER}" "/home/${USER}"

ENV COMPOSER_HOME="/home/${USER}/.composer"

WORKDIR /var/www/html

# ================================
# PNPM GLOBAL
# ================================
RUN npm install -g pnpm

# ================================
# ARGUMENTOS PARA BUILD DE VITE
# ================================
ARG REVERB_APP_KEY=
ARG REVERB_APP_ID=
ARG REVERB_APP_SECRET=
ARG REVERB_HOST=
ARG REVERB_PORT=
ARG REVERB_SCHEME=
ARG VITE_API_URL=

ENV VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
ENV VITE_REVERB_HOST="${REVERB_HOST}"
ENV VITE_REVERB_PORT="${REVERB_PORT}"
ENV VITE_REVERB_SCHEME="${REVERB_SCHEME}"
ENV VITE_API_URL="${VITE_API_URL}"

# ================================
# COPIAR CÓDIGO Y BUILD
# ================================
COPY . /var/www/html

RUN chown -R "${USER}:www-data" /var/www/html

USER "${USER}"

RUN composer install --no-dev --optimize-autoloader --no-scripts
# Eliminar el manifiesto de paquetes cacheado para forzar su regeneración limpia
RUN rm -f bootstrap/cache/packages.php && php artisan package:discover

RUN pnpm install && pnpm run build

# Verificar manifiesto Vite
RUN test -f public/build/manifest.json \
    || (echo "ERROR: manifest.json de Vite no encontrado." && exit 1)


USER root


ENV APACHE_RUN_USER=www-data \
    APACHE_RUN_GROUP=www-data

# ================================
# ESTRUCTURA DE STORAGE
# ================================
RUN mkdir -p \
    storage/app/public \
    storage/app/data/movimientos \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache


RUN chown -R www-data:www-data \
        storage \
        bootstrap/cache \
    && chmod -R 775 \
        storage \
        bootstrap/cache


RUN chmod -R 755 public

# ================================
# ENTRYPOINT
# ================================
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["apache2-foreground"]
