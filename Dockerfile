FROM php:8.4-apache

# Activer mod_rewrite pour Laravel
RUN a2enmod rewrite

# Installer dépendances système
RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpng-dev libonig-dev libxml2-dev libzip-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Extensions PHP nécessaires Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copier les fichiers de dépendances
COPY composer.json composer.lock ./

# Installer dépendances Laravel
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts

# Copier le reste du projet
COPY . .

# Générer l'autoload optimisé
RUN composer dump-autoload --optimize

# Permissions Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Configurer Apache pour pointer vers /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf

EXPOSE 80

CMD ["apache2-foreground"]
