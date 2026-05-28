FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git unzip curl libpq-dev \
    nodejs npm \
    && docker-php-ext-install pdo pdo_pgsql pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

# PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# FRONTEND BUILD (THIS IS REQUIRED)
RUN npm install
RUN npm run build

# Laravel optimizations
RUN php artisan config:clear
RUN php artisan cache:clear
RUN php artisan view:cache

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=10000