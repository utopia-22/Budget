# Step 1: Use the Official PHP Image with FPM
FROM php:8.3-fpm

# Step 2: Install System Dependencies
RUN apt-get update -y && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    npm \
    && docker-php-ext-install pdo_mysql mbstring zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*


# Step 3: Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Step 4: Set the Working Directory
WORKDIR /var/www/html

# Step 5: Copy Project Files
COPY . .

# Step 6: Install PHP Dependencies
RUN composer install --no-dev --optimize-autoloader

# Step 7: Install Node.js Dependencies
RUN npm install && npm run build

# Step 8: Set Permissions
RUN chmod -R 777 storage bootstrap/cache

# Step 9: Run Laravel Commands
RUN php artisan storage:link
RUN php artisan migrate --force
RUN php artisan optimize

# Step 10: Expose the Application Port
EXPOSE 9000

# Step 11: Start PHP-FPM
CMD ["php-fpm"]
