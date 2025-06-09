FROM php:8.1-apache

# Enable mod_rewrite (for frameworks like Laravel)
RUN a2enmod rewrite

# Copy your app to the web directory
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Install dependencies if needed
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install

EXPOSE 80
