# Defining base image
FROM php:8.2-fpm

# Setting arguments
ARG user=developer
ARG uid=1000

# Install system dependencies
RUN apt-get update && apt-get install -y \
    bash \
    curl \
    git \
    htop \
    iputils-ping \
    libicu-dev \
    libmcrypt-dev \
    libmemcached-dev \
    libonig-dev \
    libpng-dev \
    libssl-dev \
    libxml2-dev \
    net-tools \
    openssl \
    vim \
    unzip \
    zip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd sockets opcache intl

# Install Redis
RUN pecl install -o -f redis && \
    rm -rf /tmp/pear && \
    docker-php-ext-enable redis

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user && \
    mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

# Copy custom.ini of PHP to the final directory
COPY ./custom.ini /usr/local/etc/php/conf.d/custom.ini

# Remove possible unnecessary directory (to avoid errors with symbolic link)
RUN rm -rf /var/www/html

# Create symbolic link
RUN ln -s public html

# Define user been used
USER $user

# Expose port
EXPOSE 9000