FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    curl \
    zip \
    unzip \
    git \
    mysql-client \
    libpq-dev \
    libfcgi0ldbl \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    redis \
    bcmath \
    ctype \
    curl \
    json \
    mbstring \
    openssl \
    tokenizer \
    xml

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/api

# Copy composer files
COPY composer.json composer.lock* ./

# Install PHP dependencies
RUN composer install --no-interaction --no-progress --prefer-dist

# Copy application files
COPY . .

# Generate app key
RUN php artisan key:generate || true

# Create necessary storage directories
RUN mkdir -p storage/logs storage/app/public && \
    chmod -R 775 storage bootstrap/cache

# Expose port
EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
