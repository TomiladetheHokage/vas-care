FROM php:8.1-apache

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install required PHP extensions and Composer
RUN apt-get update && apt-get install -y unzip libzip-dev zip \
    && docker-php-ext-install mysqli pdo pdo_mysql zip
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set the working directory
WORKDIR /var/www/html

# Copy all files
COPY . .

# Install dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Set permissions for Apache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true

# Change Apache DocumentRoot to public
ENV APACHE_DOCUMENT_ROOT=/var/w/html/public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80
