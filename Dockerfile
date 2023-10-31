FROM php:8.1-fpm

# set your user name
ARG user=www-data
# ARG uid=1000

COPY composer*.json /var/www/

WORKDIR /var/www/

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . /var/www/

RUN chown -R www-data:www-data /var/www/storage

RUN chmod -R 755 /var/www/storage

RUN printf "\n\nInstalling composer dependencies...\n\n"
RUN composer install

CMD /var/www/script.sh; sleep infinity
