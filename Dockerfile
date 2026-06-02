FROM php:8.2-cli

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    curl zip unzip git \
    libpng-dev libxml2-dev libzip-dev libonig-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring xml zip gd opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy composer files first for better Docker layer caching
COPY composer.json composer.lock ./

RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Copy the rest of the application
COPY . .

# Run post-install scripts after full copy
RUN composer run-script post-autoload-dump

# Set storage permissions
RUN mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache \
    storage/logs bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache

EXPOSE 8000

CMD php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && php artisan migrate --force \
    && php artisan db:seed --force \
    && php -S 0.0.0.0:${PORT:-8000} -t public
