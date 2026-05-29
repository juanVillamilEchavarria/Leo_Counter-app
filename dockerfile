FROM php:8.5-apache

ARG USER=leo
ARG UID=1000

# ================================
# DEPENDENCIAS DEL SISTEMA
# ================================
RUN apt-get update && apt-get install -y --no-install-recommends \
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
# USUARIO DEL SISTEMA
# ================================
RUN useradd -G www-data,root -u "${UID}" -d "/home/${USER}" "${USER}" \
    && mkdir -p "/home/${USER}/.composer" \
    && chown -R "${USER}:${USER}" "/home/${USER}"

WORKDIR /var/www/html

# ================================
# PNPM GLOBAL
# ================================
RUN npm install -g pnpm

# ================================
# COPIAR CÓDIGO Y BUILD
# ================================
COPY . /var/www/html

# Dependencias PHP
RUN composer install --no-dev --optimize-autoloader --no-scripts
# Eliminar el manifiesto de paquetes cacheado para forzar su regeneración limpia
RUN rm -f bootstrap/cache/packages.php && php artisan package:discover

# Build de assets
RUN pnpm install && pnpm run build

# Verificar manifiesto Vite
RUN test -f public/build/manifest.json \
    || (echo "ERROR: manifest.json de Vite no encontrado." && exit 1)

# ================================
# ESTRUCTURA DE STORAGE (crítico para bind mounts frescos)
# ================================
RUN mkdir -p \
    storage/app/public \
    storage/app/data/movimientos \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

# Permisos correctos para www-data
RUN chown -R www-data:www-data \
        storage \
        bootstrap/cache \
        public/build \
    && chmod -R 775 \
        storage \
        bootstrap/cache

# ================================
# ENTRYPOINT
# ================================
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["apache2-foreground"]
