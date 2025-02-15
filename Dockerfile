# Use official PHP CLI image (not FPM)
FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
	zip unzip curl \
	libpng-dev libjpeg-dev libfreetype6-dev \
	&& docker-php-ext-configure gd \
	&& docker-php-ext-install gd pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www

# Copy project files
COPY . .

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions for storage and bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Ensure PORT is always set, default to 8000
ENV PORT=${PORT:-8000}

# Start Laravel server and run migrations before serving
CMD ["sh", "-c", "php artisan migrate --force && php artisan config:cache && php artisan serve --host=0.0.0.0 --port=${PORT}"]
