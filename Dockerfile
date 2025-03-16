# Utilise l'image officielle de PHP 8.3.6 avec Apache
FROM php:8.3.6-apache

# Met à jour la liste des paquets disponibles et installe les dépendances nécessaires
RUN apt update \
    && apt install -y build-essential curl zlib1g-dev g++ git libicu-dev zip libzip-dev \
    libpng-dev libjpeg-dev libwebp-dev libfreetype6-dev libssl-dev pkg-config \
    # Installe les extensions PHP nécessaires
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && docker-php-ext-configure gd --with-freetype --with-webp --with-jpeg \
    # Nettoie les caches APT pour réduire la taille de l'image
    && apt clean

# Copie tout le contenu du répertoire courant (le projet) dans /var/www dans le conteneur
COPY . /var/www

# Copie la configuration Apache personnalisée dans le répertoire des sites activés d'Apache
COPY ./docker/config/apache/default.conf /etc/apache2/sites-enabled/000-default.conf

# Télécharge et installe Composer
RUN curl -sS https://getcomposer.org/download/2.8.2/composer.phar -o /usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer

# Définit le répertoire de travail à /var/www
WORKDIR /var/www

# Supprime le fichier composer.lock (optionnel, selon vos besoins)
RUN rm composer.lock

# Installe les dépendances PHP définies dans composer.json
RUN composer install --optimize-autoloader --no-scripts

# Crée les répertoires nécessaires pour les fichiers de cache et de log
RUN mkdir -p var/cache/prod \
    && mkdir -p var/log


RUN chown -R www-data:www-data /var/www/var/cache /var/www/var/log
# Définit les permissions pour permettre l'écriture dans les répertoires de cache et de log
RUN chmod -R 777 var/cache/prod \
    && chmod -R 777 var/log

# Expose le port 80 pour permettre l'accès via HTTP
EXPOSE 80
