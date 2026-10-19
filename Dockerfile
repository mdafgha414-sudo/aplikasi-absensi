FROM php:8.3-cli

# 1. Install system dependencies & Node.js (untuk build aset)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# 2. Install PHP extensions (yang dibutuhkan Laravel & MySQL)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql zip exif pcntl gd

# 3. Bersihkan cache apt
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# 4. Set working directory
WORKDIR /var/www/html

# 5. Copy file proyek
COPY . .

# 6. Install Composer & dependencies PHP
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-interaction

# 7. Install dependencies Node & Build aset (CSS/JS)
RUN npm install && npm run build

# 8. Set permission agar Laravel bisa menulis file (log, cache, dll)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 9. Entrypoint Script (Perintah yang dijalankan saat server menyala)
RUN echo '#!/bin/bash\n\
set -e\n\
\n\
# Buat link storage\n\
php artisan storage:link --force\n\
\n\
# Bersihkan & optimasi cache untuk production\n\
php artisan config:cache\n\
php artisan route:cache\n\
php artisan view:cache\n\
\n\
# Jalankan migrasi database secara otomatis\n\
php artisan migrate --force\n\
\n\
# Jalankan server Laravel\n\
exec php artisan serve --host=0.0.0.0 --port=${PORT:-80}' > /usr/local/bin/entrypoint.sh \
    && chmod +x /usr/local/bin/entrypoint.sh

# 10. Jalankan script
CMD ["/usr/local/bin/entrypoint.sh"]