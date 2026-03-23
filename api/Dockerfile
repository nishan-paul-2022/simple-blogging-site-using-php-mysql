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
    xml

# Install Redis extension from PECL
RUN pecl install redis && docker-php-ext-enable redis

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/api

# Copy application files
COPY . .

# Install PHP dependencies (artisan is now available for composer scripts)
RUN composer install --no-interaction --no-progress --prefer-dist

# Generate app key
RUN php artisan key:generate || true

# Create necessary storage directories
RUN mkdir -p storage/logs storage/app/public && \
    chmod -R 775 storage bootstrap/cache

# Expose port
EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
