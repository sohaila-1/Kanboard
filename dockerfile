FROM php:8.2-fpm

# Installer dépendances système
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl procps net-tools nano libonig-dev libxml2-dev libcurl4-openssl-dev libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring zip xml curl bcmath gd

# 📥 Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier les fichiers
COPY . /var/www/html

# Installer les dépendances Laravel
RUN composer install

CMD ["php-fpm"]
