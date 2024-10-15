FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies, PHP extensions, and Composer
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    vim \
    unzip \
    curl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql \
    && docker-php-ext-enable pdo_mysql

# Configure and install GD extension
RUN docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install -j$(nproc) gd

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy composer files and install dependencies first to leverage Docker cache
COPY composer.json composer.lock /var/www/html/

RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy application files after dependencies are installed
COPY . /var/www/html

COPY entrypoint.sh /usr/local/bin/entrypoint.sh

RUN chmod +x /usr/local/bin/entrypoint.sh

# Add user for laravel application
RUN groupadd -g 1000 www && useradd -u 1000 -ms /bin/bash -g www www

# Change current user to www
USER www


# Expose the port php-fpm runs on
EXPOSE 9000

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

