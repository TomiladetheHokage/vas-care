FROM php:8.1-apache

# Enable URL rewriting
RUN a2enmod rewrite

# Install system and PHP dependencies
RUN apt-get update && apt-get install -y unzip libzip-dev zip \
    && docker-php-ext-install zip pdo pdo_mysql

# Copy Composer from official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy your app to the Apache server root
COPY . /var/www/html/

# Change Apache's root directory to 'src'
ENV APACHE_DOCUMENT_ROOT=/var/www/html/src

# Update Apache config to use the new document root
RUN sed -i "s|/var/www/html|/var/www/html/src|g" /etc/apache2/sites-available/000-default.conf

# Set working directory to src
WORKDIR /var/www/html/src

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader || true

EXPOSE 80
