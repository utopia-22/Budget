# Use official PHP image with extensions for Laravel
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

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Allow Render to set the port dynamically
ENV PORT 8000

# Start Laravel server (no Nginx or PHP-FPM)
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=${PORT}"]
