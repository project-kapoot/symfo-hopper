# Utilise l'image officielle de PHP 8.3.6 avec Apache
FROM php:8.3.6-apache

# Met à jour la liste des paquets et installe les dépendances nécessaires
RUN apt update && apt install -y --no-install-recommends \
    build-essential curl git unzip \
    zlib1g-dev libicu-dev libzip-dev \
    libpng-dev libjpeg-dev libwebp-dev libfreetype6-dev \
    libssl-dev pkg-config libpq-dev \
    && docker-php-ext-install intl opcache zip \
    && docker-php-ext-configure zip && docker-php-ext-install zip \
    && docker-php-ext-configure gd --with-freetype --with-webp --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt remove -y build-essential \
    && apt autoremove -y \
    && apt clean \
    && rm -rf /var/lib/apt/lists/*

# Activer le module de réécriture d'Apache
RUN a2enmod rewrite

# Copie tout le contenu du répertoire courant (le projet) dans /var/www dans le conteneur
COPY . /var/www

# Copie la configuration Apache personnalisée dans le répertoire des sites activés d'Apache
COPY ./docker/config/apache/default.conf /etc/apache2/sites-enabled/000-default.conf

# Télécharge et installe Composer
RUN curl -sS https://getcomposer.org/download/2.8.2/composer.phar -o /usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer

# Définit le répertoire de travail à /var/www
WORKDIR /var/www


# Installe les dépendances PHP définies dans composer.json
RUN composer install --optimize-autoloader --no-scripts 

# compile the assets
RUN php bin/console asset-map:compile

# Crée les répertoires nécessaires pour les fichiers de cache et de log
RUN mkdir -p var/cache/prod var/log \
    && chown -R www-data:www-data /var/www/var/cache /var/www/var/log /var/www/public

# Définition de l’environnement pour éviter de l’oublier dans docker run
ENV APP_ENV=prod

# Création d'un utilisateur non-root

RUN useradd hopper && usermod -aG www-data hopper
RUN chown -R hopper:www-data /var/www && chmod -R 770 /var/www
USER hopper


# Expose le port 80 pour permettre l'accès via HTTP
EXPOSE 80
