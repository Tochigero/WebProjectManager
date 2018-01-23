FROM php:7.2-fpm

# APT packages
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libicu-dev \
    libbz2-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libxml2-dev \
    git \
    && rm -rf /var/lib/apt/lists/*

# PHP Coniguration
COPY config/php.ini /usr/local/etc/php/php.ini
COPY config/apcu.ini config/xdebug.ini /usr/local/etc/php/conf.d/

# Bash
RUN chsh -s /bin/bash www-data

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --filename=composer --install-dir=/usr/local/bin
