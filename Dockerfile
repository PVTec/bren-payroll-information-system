# Use PHP 8.2 with Apache
FROM php:8.2-apache

# Install required system packages and PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    libpq-dev \
    && docker-php-ext-install pdo_mysql pdo_pgsql zip

# Enable Apache mod_rewrite para gumana ang Laravel routing
RUN a2enmod rewrite

# Palitan ang default root folder ng Apache to Laravel's "public" directory
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copy everything into the container
COPY . /var/www/html

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Laravel dependencies (zero fluff, production mode)
RUN composer install --no-dev --optimize-autoloader

# Set correct folder permissions para sa Laravel cache at logs
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
