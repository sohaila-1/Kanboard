FROM php:8.2-fpm

# Installer dépendances système + Node.js
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl procps net-tools nano \
    libonig-dev libxml2-dev libcurl4-openssl-dev \
    libpng-dev libjpeg-dev libfreetype6-dev gnupg \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring zip xml curl bcmath gd \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# 📥 Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier les fichiers du projet
COPY . /var/www/html

# Installer les dépendances Laravel
RUN composer install

# Commande de lancement par défaut
CMD ["php-fpm"]