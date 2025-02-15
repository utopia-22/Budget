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

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Ensure PORT is always set, default to 8000
ENV PORT=${PORT:-8000}

# Fix: Convert PORT to a valid number before passing it
CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=${PORT:-8000}"]
