FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy existing application directory contents
COPY . /var/www

# Install Composer dependencies
RUN composer install --no-interaction --optimize-autoloader

# Install Node.js dependencies
RUN npm install && npm run build

# Copy startup script and make it executable
COPY start-dev.sh /usr/local/bin/start-dev
RUN chmod +x /usr/local/bin/start-dev

# Create storage link
RUN php artisan storage:link || true

# Expose ports
EXPOSE 8000 5173

# Use our startup script
CMD ["start-dev"]