FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    curl \
    zip \
    unzip \
    git \
    default-mysql-client \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_mysql \
    bcmath \
    mbstring \
    xml \
    zip

# Install Redis extension from PECL
RUN pecl install redis && docker-php-ext-enable redis

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/app-backend

# Copy composer files first (for better layer caching)
COPY composer.json composer.lock* ./

# Create required Laravel directories BEFORE composer install
# so that post-autoload-dump scripts (artisan package:discover) can run
RUN mkdir -p \
    bootstrap/cache \
    storage/logs \
    storage/app/public \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    && chmod -R 775 bootstrap/cache storage

# Copy the rest of the application
COPY . .

# Ensure .env exists (copy from .env.example if not present)
RUN [ -f .env ] || cp .env.example .env

# Fix permissions again after full copy
RUN chmod -R 775 bootstrap/cache storage \
    && chown -R www-data:www-data bootstrap/cache storage

# Install PHP dependencies
RUN composer install --no-interaction --no-progress --prefer-dist --optimize-autoloader

# Generate app key only if APP_KEY is missing or empty in .env
RUN if grep -q "APP_KEY=$" .env || ! grep -q "APP_KEY=" .env; then \
        php artisan key:generate --force; \
    fi

# Final permission fix
RUN chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# Expose port
EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
