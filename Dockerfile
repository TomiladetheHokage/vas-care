FROM php:8.1-apache

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install required PHP extensions including mysqli
RUN apt-get update && apt-get install -y unzip libzip-dev zip \
    && docker-php-ext-install mysqli pdo pdo_mysql zip

# Set the working directory to where your app is
WORKDIR /var/www/html/src

# Copy Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy everything to the container
COPY . /var/www/html/

# Change Apache DocumentRoot to src
ENV APACHE_DOCUMENT_ROOT=/var/www/html/src
RUN sed -i "s|/var/www/html|/var/www/html/src|g" /etc/apache2/sites-available/000-default.conf

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader || true

EXPOSE 80
