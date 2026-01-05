# 
FROM php:8.5-apache

# 1. Argumentos para manejar permisos
ARG USER=juan
ARG UID=1000
# ================================
# DEPENDENCIAS DEL SISTEMA
# ================================
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    curl \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libwebp-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    && rm -rf /var/lib/apt/lists/*

# ================================
# EXTENSIONES PHP
# ================================
RUN docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
    && docker-php-ext-install -j$(nproc) \
        gd \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        zip

# 3. Instalar Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# 4. Instalar Composer de forma eficiente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Configurar Apache (DocumentRoot y mod_rewrite)
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf \
    && sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf \
    && a2enmod rewrite

# 6. CREAR USUARIO DE SISTEMA PARA EVITAR PROBLEMAS DE PERMISOS
# Esto crea un usuario que coincide con el del host
RUN useradd -G www-data,root -u $UID -d /home/$USER $USER \
    && mkdir -p /home/$USER/.composer && \
    chown -R $USER:$USER /home/$USER

# 7. Directorio de trabajo
WORKDIR /var/www/html

# 8. Copiar archivos de dependencias primero
COPY composer.json composer.lock* package.json package-lock.json* ./

# 9. Cambiar a nuestro nuevo usuario para instalar cosas
USER $USER

# Instalar dependencias (Sin scripts para que no falle si falta algo de código)
RUN composer install --no-scripts --no-autoloader --no-dev || true
RUN npm install || true

# 10. Copiar el resto del código como el usuario creado
COPY --chown=$USER:$USER . .

# Finalizar autoload de composer
RUN composer dump-autoload --optimize

# Exponer puerto
EXPOSE 80

CMD ["apache2-foreground"]